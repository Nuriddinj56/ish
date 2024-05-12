<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 2015.12.01
 * Time: 14:59
 */

namespace app\commands;

use app\models\Log;
use app\models\Schedule;
use app\models\Stat;
use app\models\User;
use Curl\Curl;
use Curl\MultiCurl;
use yii\console\Controller;
use Yii;
use Cron\CronExpression;
use yii\db\Query;
use yii\helpers\Json;
use yii\base\InvalidParamException;
use \DateTime;
use \DateTimeZone;
use \DateInterval;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

set_time_limit(0);

class ExecController extends Controller
{
    protected $processId;
    protected $currentTime;
    protected $startTime;
    protected $schedule = [];

    public function init() {
        parent::init();
        $this->processId = $this->getUniqueProcessId();
        $this->currentTime = new DateTime('now', new DateTimeZone(Yii::$app->params['timezone']));
    }

    public function actionIndex() {
        $curlOpts = Yii::$app->params['curl'];
        $timeOut = (int) ArrayHelper::getValue($curlOpts, CURLOPT_TIMEOUT);
        $connectionTimeout = (int) ArrayHelper::getValue($curlOpts, CURLOPT_CONNECTTIMEOUT);

        $query = Schedule::find()
            ->with([
                "profile",
                "settings",
                "user"=>function($q) {
                    $q->select(User::tableName().".id, lang_id");
                }
            ])
            ->andWhere("process_id IS NULL AND send_at_server <= :current_time AND status=:status", [
                ":current_time"=>$this->currentTime->format("Y-m-d H:i:s"),
                ":status"=>Schedule::STATUS_ENABLED,
            ]);

        if($timeOut > 0 AND $connectionTimeout > 0) {
            $date = new DateTime('now', new DateTimeZone(Yii::$app->params['timezone']));
            $interval = new DateInterval('PT'. ($timeOut + $connectionTimeout + 20) . 'S');
            $date->sub($interval);

            // Frozen and broken processes
            $query->orWhere("process_id IS NOT NULL AND send_at_server <= :send_at_server", [
                ":send_at_server"=>$date->format("Y-m-d H:i:s")
            ]);
        }

        $multiCurl = new MultiCurl();
        $multiCurl->complete([$this, 'processResponse']);

        foreach($query->each() as $row) {
            // Make sure that there were no collision with other processes
            if(!(Yii::$app->db->createCommand()
                ->update(Schedule::tableName(), [
                    "process_id"=>$this->processId,
                ], "id=:id AND send_at_server <= :current_time", [":id"=>$row->id, ":current_time"=>$this->currentTime->format("Y-m-d H:i:s")])
                ->execute())) {
                continue;
            }

            $this->schedule[$row->id] = $row;

            //echo "Processing {$row['title']} \n";

            // Add URL into queue
            $cookie = $this->getParam($row, "cookie");
            $post = $this->getParam($row, "post");
            if(!empty($post)) {
                $curl = $multiCurl->addPost($row->url, $post);
            } else {
                $curl = $multiCurl->addGet($row->url);
            }
            if(!empty($row->http_auth_username)) {
                curl_setopt($curl->curl, CURLOPT_USERPWD, $row->http_auth_username . ":" . $row->http_auth_password);
            }

            $curl->id = $row->id;
            curl_setopt_array($curl->curl, Yii::$app->params['curl']);
            foreach($cookie as $key=>$val) {
                $curl->setCookie($key, $val);
            }

            // Reset process handler and generate next execution date
            try {
                $cron = CronExpression::factory($row->expression);
                $currentDate = new DateTime('now', new DateTimeZone($row->settings->timezone));
                $runDate = $cron->getNextRunDate($currentDate);
            } catch(\Exception $e) {
                $toUpdate = [
                    "status"=>Schedule::STATUS_DISABLED,
                    "process_id"=>NULL,
                ];
                Yii::$app->db->createCommand()->update(Schedule::tableName(), $toUpdate, "id=:id", [":id"=>$row->id])->execute();
                continue;
            }

            $toUpdate = [];
            $toUpdate['process_id'] = NULL;
            $toUpdate['send_at_user'] = $runDate->format("Y-m-d H:i:s");
            $toUpdate['total_executions'] = $row->total_executions + 1;


            if((($row->max_executions > 0) AND ($toUpdate['total_executions'] >= $row->max_executions)) OR (!empty($row->stop_at_user) AND ($runDate >= (new DateTime($row->stop_at_user, new DateTimeZone($row->settings->timezone)))))) {
                $toUpdate['status'] = Schedule::STATUS_DISABLED;
            }

            $runDate->setTimezone(new DateTimeZone(Yii::$app->getTimeZone()));
            $toUpdate['send_at_server'] = $runDate->format("Y-m-d H:i:s");

            Yii::$app->db->createCommand()->update(Schedule::tableName(), $toUpdate, "id=:id", [":id"=>$row->id])->execute();

            //echo "Processing {$row['id']} : {$this->processId}... \n";
            //sleep(10);
        }

        $this->startTime = date("Y-m-d H:i:s");
        $multiCurl->start();
    }

    protected function getUniqueProcessId() {
        return md5(serialize($_SERVER).uniqid(rand(), true));
    }

    public function getParam($row, $param) {
        try {
            $data = Json::decode($row->$param);
        } catch(InvalidParamException $e) {
            $data = [];
        }
        return is_null($data) ? [] : $data;
    }

    public function processResponse($instance) {
        /**
         * @var $schedule Schedule
         */
        $schedule = $this->schedule[$instance->id];

        try {
            $curlInfo = Json::encode(curl_getinfo($instance->curl));
        } catch(InvalidParamException $e) {
            $curlInfo = Json::encode([]);
        }

        $finishTime = date("Y-m-d H:i:s");

        Yii::$app->db->createCommand()
            ->insert(Log::tableName(), [
                "curl_info"=>$curlInfo,
                "response"=>$instance->response,
                "http_code"=>$instance->httpStatusCode,
                "schedule_id"=>$schedule->id,
                "user_id"=>$schedule->user_id,
                "added_at"=>date("Y-m-d H:i:s"),
                "error_msg"=>$instance->errorMessage,
                "is_error"=>$instance->error,
                "start_at"=>$this->startTime,
                "finish_at"=>$finishTime,
                "schedule_time"=>$schedule->send_at_server,
            ])
            ->execute();
        $logId = Yii::$app->db->lastInsertID;

        $sql =  "INSERT INTO ". Stat::tableName(). " (insert_at, failed, success, user_id, schedule_id) ".
                "VALUES (:insert_date, ". ($instance->error ? 1 : 0) . ", ". ($instance->error ? 0 : 1) .", :user_id, :schedule_id)".
                "ON DUPLICATE KEY UPDATE ". ($instance->error ? "failed = failed + 1" : "success = success + 1");

        Yii::$app->db->createCommand($sql, [
            ":insert_date" => $schedule->send_at_user,
            ":user_id"=> $schedule->user_id,
            ":schedule_id"=>$schedule->id,
        ])->execute();

        if($instance->error AND $schedule->isFailNotify()) {
            $this->sendMessage($schedule, $instance, $logId);
            return 0;
        }

        if($schedule->isAlwaysNotify()) {
            $this->sendMessage($schedule, $instance, $logId);
            return 0;
        }

        return 0;
    }

    private function sendMessage(Schedule $schedule, Curl $instance, $logId) {
        //echo "Sending message \n";

        $emailOutput = substr($instance->response, 0, 1024 * (int) Yii::$app->params['kbEmailOutput']);
        //echo $schedule->user->id. " ". $schedule->user->lang_id ."\n";

        try {
            $result = Yii::$app->mailer->compose([
                'html' => 'notification-html',
                'text' => 'notification-text',
            ], [
                "schedule"=>$schedule,
                "instance"=>$instance,
                "response"=>$emailOutput,
                "logId"=>$logId,
            ])
                ->setFrom(Yii::$app->params['notificationFrom'])
                ->setTo($schedule->profile->email)
                ->setSubject(Yii::t("app", "Cron Job Execution Log | {title}", [
                    "title"=>$schedule->title,
                ], $schedule->user->lang_id))
                ->send();
            return $result;
        } catch(\Exception $e) {
            Yii::error($e->getMessage());
            return false;
        }
    }
}