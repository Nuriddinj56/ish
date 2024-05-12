<?php
class Databaser{
	
	private $host  = 'localhost';
    private $user  = 'orion';
    private $password   = "пароль от бд";
    private $database  = "orion"; 
    
    public function getConnection(){		
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		} else {
			return $conn;
		}
    }
}
?>