<?php

/**
*        Класс для работы с СУБД
*
*        Соединение с базой данных
*        $db = new database("mydb.db",'sqlite');
*        $db = new database("mydb", "mysql", "localhost", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
*
*        Выборка одной строки
*        $getrow = $db->row("SELECT * FROM users");
*        $getrow = $db->row("SELECT * FROM users WHERE id >?", array("0"));
*
*        Выборка нескольких строк
*        $getrows = $db->rows("SELECT * FROM users");
*        $getrows = $db->rows("SELECT * FROM users WHERE id >?", array("replace" => array("1"))); // Замещение вопроса на array
*        $getrows = $db->rows("SELECT * FROM users WHERE id >?", array("paginate" => array("1","5"))); // Выборка количества
*
*        Вставка строки
*        $insertrow = $db->insert("INSERT INTO users (username, email) VALUES (?, ?)", array("yusaf", "yusaf@email.com"));
*
*        Обновление строки         
*        $updaterow = $db->update("UPDATE users SET username = ?, email = ? WHERE id = ?", array("yusafk", "yusafk@email.com", "1"));
*
*        Удаление строки
*        $deleterow = $db->delete("DELETE FROM users WHERE id = ?", array("1"));
*
*        Disconnect базы данные
*        $db->disconnect();
*
*        Проверка соединения с бд
*        $db->isConnected;
*
*/

    class database
    {
        
        public $isConnected;
        protected $datab;

        public function __construct($dbname,$type,$host=null,$username=null,$password=null,$options=null){
            $this->isConnected = true;
            try {

            	if ($type == 'mysql') {
            		$this->datab = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
            	} else if ($type == 'sqlite') {
            		$this->datab = new PDO("sqlite:$dbname"); 
            	}
                $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } 
            catch(PDOException $e) { 
                $this->isConnected = false;
                throw new Exception($e->getMessage());
            }
        }

        public function disconnect(){
            $this->datab = null;
            $this->isConnected = false;
        }

        public function row($query, $params=array()){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                return $stmt->fetch();  
                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }

        public function rows($query, $params=array()){
            try{ 

                if (!empty($params['paginate']['0']) and !empty($params['paginate']['1'])) {
                    $query = $query.
                            ' LIMIT ' . 
                            (int)$params['paginate']['0'].
                            ', '.
                            (int)$params['paginate']['1'];
                }
                $stmt = $this->datab->prepare($query);
                if (!empty($params['replace'])) {
                $stmt->execute($params['replace']);
                } else {
                    $stmt->execute();
                }
                return $stmt->fetchAll();       
                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }       
        }

        public function insert($query, $params){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                return $this->datab->lastInsertId();

                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }

        public function update($query, $params){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                return $result = ($stmt->rowCount()) ? true : false;

                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }

        public function delete($query, $params){
            try{ 
                $stmt = $this->datab->prepare($query); 
                $stmt->execute($params);
                return $result = ($stmt->rowCount()) ? true : false;

                }catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }
    }