<?php
// comment out the following two lines when deployed to production
if (in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', '84.55.60.33'])) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require(__DIR__ . '/protected/vendor/autoload.php');
require(__DIR__ . '/protected/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/protected/config/web.php');

(new yii\web\Application($config))->run();