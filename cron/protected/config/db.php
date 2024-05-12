<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=orion',
    'username' => 'orion',
    'password' => 'пароль от бд',
    'charset' => 'utf8',
    'tablePrefix'=>'webcron_',
    'enableSchemaCache'=>true,
    'schemaCacheDuration'=>60*60*24*30,
];
