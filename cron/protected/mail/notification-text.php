<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 2015.12.26
 * Time: 11:39
 *
 * @var $response string
 * @var $schedule \app\models\Schedule
 * @var $instance \Curl\Curl;
 * @var $prevTime DateTime;
 * @var $logId int
 */
use yii\helpers\Html;
use app\components\Helper;
use yii\helpers\Url;
?>
<?php echo Yii::t("app", "Cron Job Name", [], $schedule->user->lang_id) ?>: <?= Html::encode($schedule->title) ?>

<?php echo Yii::t("app", "Execution time", [], $schedule->user->lang_id) ?>: <?= $schedule->send_at_user ?>

<?php echo Yii::t("app", "HTTP Code", [], $schedule->user->lang_id) ?>: <?= $instance->httpStatusCode ?>

<?php echo Yii::t("app", "More info", [], $schedule->user->lang_id) ?>: <?= Url::to(["cron-job/log", "id"=>$logId, "language"=>$schedule->user->lang_id]) ?>

<?php echo Yii::t("app", "First {n} KB output", [
    "n"=>Yii::$app->params['kbEmailOutput']
], $schedule->user->lang_id) ?>


>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


<?php echo Html::encode($response) ?>