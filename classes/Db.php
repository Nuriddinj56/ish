<?php
/**
 * Class Db
 */
class Db {
    // для соединения с БД 
    private $host = 'localhost';
    private $db = 'orion';
    private $user = 'orion';
    private $pass = 'пароль от бд';
    private $charset = 'utf8mb4';
    private $pdo = null;

    /** Получаем соединение
     * @return bool
     */
    public function connect()
    {
        if(is_null($this->pdo)) {
            $this->setPdo();
        }
        return $this->pdo;
    }

    /**
     *  Создаем соединение с БД
     */
    private function setPdo()
    {
        // задаем тип БД, хост, имя базы данных и чарсет
        $dsn = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
        // дополнительные опции
        $opt = [
            // способ обработки ошибок - режим исключений
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // тип получаемого результата по-умолчанию - ассоциативный массив
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // отключаем эмуляцию подготовленных запросов
            PDO::ATTR_EMULATE_PREPARES => false,
            // определяем кодировку запросов
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];
        // // записываем объект PDO в свойство $this->pdo
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
    }
}
?>