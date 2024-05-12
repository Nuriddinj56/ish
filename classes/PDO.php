<?
$db_server = 'localhost';
$db_name = 'orion';
$db_user = 'orion';
$db_password = 'пароль от бд';

$dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8";

// Параметры задают что в качестве ответа получаем ассоциативный массив
$opt = array(
            // способ обработки ошибок - режим исключений
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // тип получаемого результата по-умолчанию - ассоциативный массив
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // отключаем эмуляцию подготовленных запросов
            PDO::ATTR_EMULATE_PREPARES => false,
            // определяем кодировку запросов
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=''"
);

$pdo = new PDO($dsn, $db_user, $db_password, $opt);

?>