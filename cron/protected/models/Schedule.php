<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 2015.11.05
 * Time: 22:34
 */

namespace app\models;


use app\components\Cron;
use app\models\query\OwnerTrait;
use app\models\query\ScheduleQuery;
use app\validators\AdditionalParamsFilter;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Cron\CronExpression;
use Yii;

class Schedule extends ActiveRecord
{
    public $postParams = [];
    public $cookieParams = [];

    const TYPE_GUI = 'gui';
    const TYPE_EXPRESSION = 'expression';
    const TYPE_ALIAS = 'alias';

    const NOTIFY_FAILS = 'fails';
    const NOTIFY_AFTER = 'after';
    const NOTIFY_NEVER = 'never';

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    const SCENARIO_MANAGE = 'manage';

    /**
     * @var User
     */
    private $_user;

    /**
     * @var \DateTime
     */
    private $_runDate;

    public $logsCount;
    public $totalFailed;
    public $totalSuccess;

    public function setUser(User $user) {
        $this->_user = $user;
    }

    public function behaviors() {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'createdAtAttribute'=>'created_at',
                'updatedAtAttribute'=>'modified_at',
                'value'=>function() { return date("Y-m-d H:i:s"); }
            ],
        ];
    }

    public static function find() {
        return new ScheduleQuery(get_called_class());
    }

    public static function tableName() {
        return "{{%schedule}}";
    }

    public function beforeValidate() {
        if(!$this->_user instanceof User) {
            throw new \InvalidArgumentException("Please set User");
        }
        $this->user_id = $this->_user->id;
        return true;
    }

    public function rules() {
        return [
            ["expression", "filter", "filter"=>[$this, "filterExpr"], "on"=>self::SCENARIO_MANAGE],
            ['cookieParams', AdditionalParamsFilter::className(), "dbattr"=>"cookie", "skipOnEmpty"=>false],
            ['postParams',  AdditionalParamsFilter::className(), "dbattr"=>"post", "skipOnEmpty"=>false],

            ['stop_at_user', "filter", "filter"=>function($value) {
                if(empty($value)) {
                    return null;
                }
                try {
                    $date = $this->_user->getDateObject($value);
                    return $date->format("Y-m-d H:i:s");
                } catch(\Exception $e) {
                    return false;
                }
            }],

            [["url", "title", "expression", "notify", "type", "status"], "required"],
            [["cookieParams", "postParams", "category_id", "stop_at_user", "max_executions", "http_auth_password"], "required", "skipOnEmpty"=>true],
            [["http_auth_username"], "required", "when"=>function($model) {
                return !empty($model->http_auth_password);
            }],

            ["url", "url"],
            ["title", "string", "length"=>["max"=>60]],
            ["title", "unique", "targetAttribute"=>["title", "user_id"], "message"=>Yii::t("app", "Cron job with taken name already exists.")],
            ["notify", "in", "range"=>array_keys(self::getNotifyArray())],
            ["expression", function($attribute, $params) {
                $this->_runDate = Cron::isValidExpression($this->$attribute, $this->_user->getDateObject());
                if(!$this->_runDate) {
                    $this->addError($attribute, Yii::t("app", "Expression is invalid or expired"));
                }
            }],

            ["stop_at_user", "validateStopAtUser"],
            ["max_executions", "integer", "min"=>0],
            ["max_executions", "validateMaxExec"],
            ["max_executions", "validateDontAllowBoth"],

            ["status", "in", "range"=>[self::STATUS_ENABLED, self::STATUS_DISABLED]],
            ["category_id", "exist", "targetClass"=>Category::className(), "targetAttribute" => "id", "skipOnEmpty"=>true],
        ];
    }

    public function validateStopAtUser($attribute, $params) {
        if($this->hasErrors()) {
            return true;
        }
        $a = $this->$attribute;
        if($a===false) {
            $this->addError($attribute, Yii::t('yii', 'The format of {attribute} is invalid.', ['attribute'=>Yii::t("app", "Stop running at")]));
            return false;
        }

        if(strtotime($this->_runDate->format("Y-m-d H:i:s")) >= strtotime($a)) {
            $this->addError($attribute, Yii::t("app", "The date is expired"));
            return false;
        }

        return true;
    }

    public function validateMaxExec($attribute, $params) {
        $dirty = $this->getDirtyAttributes();
        if(isset($dirty['max_executions'])) {
            $this->total_executions = 0;
        }
        if($this->max_executions == 0) {
            return true;
        }
        if($this->total_executions >= $this->max_executions) {
            $this->addError($attribute, Yii::t("app", "Total number of executions has been exceeded"));
        }
        return true;
    }

    public function validateDontAllowBoth($attribute, $params) {
        if(!empty($this->stop_at_user) AND $this->max_executions > 0) {
            $message = Yii::t("app", "Please choose either a Stop running date or a Number of executions");
            $this->addError("max_executions", $message);
        }
    }

    public function filterExpr($attribute) {
        if(!Yii::$app->request->getIsPost()) {
            return $attribute;
        }
        if($this->type == self::TYPE_ALIAS) {
            return Yii::$app->request->post("cron_alias");
        } elseif($this->type == self::TYPE_EXPRESSION) {
            return Yii::$app->request->post("cron_expression");
        }
        return $attribute;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if($this->getIsNewRecord()) {
                $this->is_log = 1;
                $this->total_executions = 0;
            }

            $this->send_at_user = $this->_runDate->format("Y-m-d H:i:s");
            $this->_runDate->setTimezone(new \DateTimeZone(Yii::$app->getTimeZone()));
            $this->send_at_server = $this->_runDate->format("Y-m-d H:i:s");

            $this->future_execution = 1;
            $this->max_executions = (int) $this->max_executions;

            return true;
        } else {
            return false;
        }
    }
    
    public function isGui() {
        return $this->type == self::TYPE_GUI;
    }

    public function isAlias() {
        return $this->type == self::TYPE_ALIAS;
    }

    public function isExpression() {
        return $this->type == self::TYPE_EXPRESSION;
    }

    public function isNeverNotify() {
        return $this->notify == self::NOTIFY_NEVER;
    }

    public function isAlwaysNotify() {
        return $this->notify == self::NOTIFY_AFTER;
    }

    public function isFailNotify() {
        return $this->notify == self::NOTIFY_FAILS;
    }

    public static function getNotifyArray() {
        return [
            self::NOTIFY_AFTER => Yii::t("app", "After execution"),
            self::NOTIFY_FAILS => Yii::t("app", "If execution fails"),
            self::NOTIFY_NEVER => Yii::t("app", "Never"),
        ];
    }

    public static function getStatusArray() {
        return [
            self::STATUS_ENABLED => Yii::t("app", "Enabled"),
            self::STATUS_DISABLED => Yii::t("app", "Disabled"),
        ];
    }

    public function getHttpAuthMsg() {
        return !empty($this->http_auth_username) ? Yii::t("app", "Yes") : Yii::t("app", "No");
    }

    public function shuttingDownMsg() {
        if($this->max_executions > 0) {
            return Yii::t("app", "The number of remaining executions", ["<strong>".($this->max_executions-$this->total_executions)."</strong>", "<strong>".($this->max_executions)."</strong>"]);
        } elseif($this->stop_at_user) {
            return Yii::t("app", "The execution will be stopped at {date}", ["date"=>"<strong>".$this->stop_at_user."</strong>"]);
        } else {
            return Yii::t("app", "No force shut down");
        }
    }

    public function getStatusMsg() {
        switch($this->status) {
            case self::STATUS_ENABLED:
                return Yii::t("app", "Enabled");
                break;
            case self::STATUS_DISABLED:
                return Yii::t("app", "Disabled");
                break;
        }
        return Yii::t("app", "Unknown");
    }

    public function getNotifyMsg() {
        switch($this->notify) {
            case self::NOTIFY_NEVER:
                return Yii::t("app", "Never");
            break;
            case self::NOTIFY_FAILS:
                return Yii::t("app", "If execution fails");
            break;
            case self::NOTIFY_AFTER:
                return Yii::t("app", "After execution");
            break;
        }
        return Yii::t("app", "Unknown");
    }

    public function isEnabled() {
        return $this->status == self::STATUS_ENABLED;
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ["id"=>"category_id"]);
    }

    public function getSettings() {
        return $this->hasOne(Settings::className(), ["user_id"=>"user_id"]);
    }

    public function getProfile() {
        return $this->hasOne(Profile::className(), ["user_id"=>"user_id"]);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ["id"=>"user_id"]);
    }

    public function getLogs() {
        return $this->hasMany(Log::className(), ["schedule_id"=>"id"]);
    }

    public function attributeLabels() {
        return [
            "id"=>Yii::t("app", "ID"),
            "send_at_server"=>Yii::t("app", "Execute at"),
            "send_at_user"=>Yii::t("app", "Execute at"),
            "cookie"=>Yii::t("app", "Cookies"),
            "post"=>Yii::t("app", "POST"),
            "log"=>Yii::t("app", "Logging"),
            "title"=>Yii::t("app", "Name"),
            "expression"=>Yii::t("app", "Expression"),
            "status"=>Yii::t("app", "Status"),
            "notify"=>Yii::t("app", "Email Me"),
            "url"=>Yii::t("app", "URL"),
            "created_at"=>Yii::t("app", "Created at"),
            "modified_at"=>Yii::t("app", "Modified at"),
            "user_id"=>Yii::t("app", "User"),
            "category_id"=>Yii::t("app", "Category"),
            "type"=>Yii::t("app", "Type"),
            "stop_at_user"=>Yii::t("app", "Stop running at"),
            "total_executions"=>Yii::t("app", "Number of executions"),
            "max_executions"=>Yii::t("app", "Maximum number of executions"),
            "http_auth_username"=>Yii::t("app", "Username"),
            "http_auth_password"=>Yii::t("app", "Password"),
        ];
    }
}