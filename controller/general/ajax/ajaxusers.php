<?php
include_once 'config/Database.php';

$database = new Databaser();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {	
	$record->chat = $_POST["chat"];
    $record->time_api = $_POST["time_api"];
    $record->login = $_POST["login"];
	$record->first_name = $_POST["first_name"];
	$record->last_name = $_POST["last_name"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->chat = $_POST["chat"];
    $record->time_api = $_POST["time_api"];
    $record->login = $_POST["login"];
	$record->first_name = $_POST["first_name"];
	$record->last_name = $_POST["last_name"];
	$record->updateRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'adminRecord') {
	$record->id = $_POST["id"];
	$record->adminRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'adminoffRecord') {
	$record->id = $_POST["id"];
	$record->adminoffRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'bannedoffRecord') {
	$record->id = $_POST["id"];
	$record->bannedoffRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'bannedRecord') {
	$record->id = $_POST["id"];
	$record->bannedRecord();
}


class Records {	
   
	private $recordsTable = 'dle_users';
	private $recordsTable2 = 'transactions';
	public $id;
    public $chat;
    public $login;
    public $first_name;
	public $last_name;
	public $time_api;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR chat LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR last_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR first_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR username LIKE "%'.$_POST["search"]["value"].'%") ';			
		}
		
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();	
		
		$stmtTotal = $this->conn->prepare("SELECT * FROM ".$this->recordsTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;
		
		$displayRecords = $result->num_rows;
		$records = array();		
		while ($record = $result->fetch_assoc()) {
       
	   
	   if($record['user_group'] == '1') {
		 $kto = '<div class="btn-group btn-block"><a href="#" id="'.$record["id"].'" class="badge badge-danger inv-status adminoff" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Админ</a></div>';
		 $admin = 'Снять админа';
		 $go = 'adminoff';
		 $but = 'danger';
	   } else {
		 $kto = '<div class="btn-group btn-block"><a href="#" id="'.$record["id"].'" class="badge badge-user inv-status admin" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Клиент</a></div>';
		 $admin = 'Дать админа';
		 $go = 'admin';
		 $but = 'primary';		 
	   }
		
		$stmtTotalObmens = $this->conn->prepare("SELECT * FROM ".$this->recordsTable2." WHERE chat = '".$record['chat']."' and status = 'Выплачено' ");
		$stmtTotalObmens->execute();
		$allResultObmens = $stmtTotalObmens->get_result();
		$allObmens = $allResultObmens->num_rows;
		
		$stmtTotalRefs = $this->conn->prepare("SELECT * FROM ".$this->recordsTable." WHERE referal = '".$record['chat']."'");
		$stmtTotalRefs->execute();
		$allResultRefs = $stmtTotalRefs->get_result();
		$allRefs = $allResultRefs->num_rows;
		
		if($record['status'] == 'Активен') {
	        $active = 'Активен';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item banned" id="'.$record["id"].'" onclick="return false">Забанить</a>';
		} elseif($record['status'] == 'Забанен') {
			$active = 'Забанен';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item bannedoff" id="'.$record["id"].'" onclick="return false">Разбанить</a>';
		}
		
			$rows = array();			
			$rows[] = '<div class="t-dot bg-'.$button.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Normal"></div>';
			$rows[] = ucfirst($record['chat']);
			$rows[] = '<div class="d-flex"><div class="usr-img-frame mr-2 rounded-circle"><img alt="avatar" class="img-fluid rounded-circle" src="/'.$record['image'].'"></div><p class="align-self-center mb-0 admin-name"> '.$record['last_name'].' '.$record['first_name'].'<br>'.$record['username'].' </p></div>';
			$rows[] = '<div class="btn-group btn-block">
                                                        <a class="badge badge-'.$button.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            '.$active.'
                                                        </a>
                                                        <div class="dropdown-menu">
												'.$active_status.'
                                                </div>
                                            </div>';
			$rows[] = 'Операций: '.$allObmens.'<br>Рефералов: '.$allRefs;
			$rows[] = $record['reg_date'];			
			$rows[] = $kto;
			$rows[] = '<div class="btn-group btn-block"><a href="#" id="'.$record["id"].'" class="badge badge-danger inv-status delete" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Удалить</a></div>';
			$records[] = $rows;
		}
		
		$output = array(
			"draw"	=>	intval($_POST["draw"]),			
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$records
		);
		
		echo json_encode($output);
	}
	
	public function getRecord(){
		if($this->id) {
			$sqlQuery = "
				SELECT * FROM ".$this->recordsTable." 
				WHERE id = ?";			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);	
			$stmt->execute();
			$result = $stmt->get_result();
			$record = $result->fetch_assoc();
			echo json_encode($record);
		}
	}
	public function updateRecord(){
		
		if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET chat= ?, time_api = ?, login = ?, first_name = ?, last_name = ?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->chat = htmlspecialchars(strip_tags($this->chat));
			$this->time_api = htmlspecialchars(strip_tags($this->time_api));
			$this->login = htmlspecialchars(strip_tags($this->login));
			$this->first_name = htmlspecialchars(strip_tags($this->first_name));
			$this->last_name = htmlspecialchars(strip_tags($this->last_name));
			
			
			$stmt->bind_param("sisssi", $this->chat, $this->time_api, $this->login, $this->first_name, $this->last_name, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		$get_set = $this->pdo->query("SELECT * FROM necro_setting ");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
		if($this->chat) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`chat`, `time_api`, `login`, `first_name`, `last_name`)
			VALUES(?,?,?,?,?)");
		
			$this->chat = htmlspecialchars(strip_tags($this->chat));
			$this->time_api = htmlspecialchars(strip_tags($this->time_api));
			$this->login = htmlspecialchars(strip_tags($this->login));
			$this->first_name = htmlspecialchars(strip_tags($this->first_name));
			$this->last_name = htmlspecialchars(strip_tags($this->last_name));
			
			
			$stmt->bind_param("sisss", $this->chat, $this->time_api, $this->login, $this->first_name, $this->last_name);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}
	public function deleteRecord(){
		if($this->id) {			

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->recordsTable." 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if($stmt->execute()){
				return true;
			}
		}
	}
	
public function adminRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET user_group = '1'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function adminoffRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET user_group = '4'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
		public function bannedoffRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Активен'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
		public function bannedRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Забанен'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	
}
?>