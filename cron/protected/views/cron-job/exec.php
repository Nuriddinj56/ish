<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 2015.11.14
 * Time: 00:23
 *
 * @var $startTime string
 * @var $finishTime string
 * @var $curl_info array
 * @var $success boolean
 * @var $instance \Curl\Curl
 */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\components\Helper;
?>
<tr class="odd">
    <td class="text-center"><?php echo Helper::covertToUserDate(date("Y-m-d H:i:s", $startTime)); ?></td>
    <td class="text-center"><?php echo Helper::covertToUserDate(date("Y-m-d H:i:s", $finishTime)); ?></td>v
    <td class="text-center"><?php echo ArrayHelper::getValue($curl_info, 'connect_time'); ?></td>
    <td class="text-center"><?php echo ArrayHelper::getValue($curl_info, 'total_time'); ?></td>
    <td class="text-center"><?php echo $instance->httpStatusCode; ?></td>
    <td class="text-center">
        <?php if(!$success): ?>
            <?php echo Yii::t("app", "Failed") ?> <a id="view-cron-job-output-error" style="text-decoration: underline; cursor: pointer;"><?php echo Yii::t("app", "Details") ?></a>
        <?php else: ?>
            <?php echo Yii::t("app", "Succeeded") ?>
        <?php endif; ?>
    </td>
    <td class="text-center"><?php echo Yii::$app->getFormatter()->asShortSize(ArrayHelper::getValue($curl_info, 'size_download')); ?></td>
    <td class="text-center" style="padding: 4px 6px 3px;">
        <button class="btn btn-small btn-default" id="view-cron-job-output"> <?php echo Yii::t("app", "View Output") ?></button>
    </td>
</tr>

<tr id="output-error-row" style="display: none">
    <td class="alignCenter" colspan="9">
        <textarea rows="4" class="form-control" readonly><?php echo $instance->errorMessage; ?></textarea>
    </td>
</tr>

<tr id="output-row" style="display: none">
    <td class="alignCenter" colspan="9">
        <textarea rows="15" class="form-control" readonly><?php echo Html::encode($instance->response); ?></textarea>
    </td>
</tr>
