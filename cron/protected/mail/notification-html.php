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
<table border="1" cellpadding="5">
    <tr>
        <td><?php echo Yii::t("app", "Cron Job Name", [], $schedule->user->lang_id) ?>: </td>
        <td><?= Html::encode($schedule->title) ?></td>
    </tr>
    <tr>
        <td><?php echo Yii::t("app", "Execution time", [], $schedule->user->lang_id) ?>: </td>
        <td><?= $schedule->send_at_user ?></td>
    </tr>
    <tr>
        <td><?php echo Yii::t("app", "HTTP Code", [], $schedule->user->lang_id) ?>: </td>
        <td><?= $instance->httpStatusCode ?></td>
    </tr>
    <tr>
        <td><?php echo Yii::t("app", "More info", [], $schedule->user->lang_id) ?>: </td>
        <td><?= Html::a(Yii::t("app", "Click here", [], $schedule->user->lang_id), Url::to(["cron-job/log", "id"=>$logId, "language"=>$schedule->user->lang_id]))?></td>
    </tr>
</table>

<p>
    <?php echo Yii::t("app", "First {n} KB output", [
        "n"=>Yii::$app->params['kbEmailOutput']
    ], $schedule->user->lang_id) ?>
</p>

<hr>

<pre>
<?php echo Html::encode($response) ?>
</pre>