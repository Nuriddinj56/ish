<?php
include_once 'config/Database.php';

$database = new Databaser();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {	
	$record->summa = $_POST["summa"];
    $record->balance = $_POST["balance"];
    $record->id_sms = $_POST["id_sms"];
	$record->com_port = $_POST["com_port"];
	$record->from_sms = $_POST["from_sms"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->summa = $_POST["summa"];
    $record->balance = $_POST["balance"];
    $record->id_sms = $_POST["id_sms"];
	$record->com_port = $_POST["com_port"];
	$record->from_sms = $_POST["from_sms"];
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
   
	private $recordsTable = 'simbank';
	private $recordsTable2 = 'transactions';
	public $id;
    public $summa;
    public $id_sms;
    public $com_port;
	public $from_sms;
	public $balance;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR msg LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR from_sms LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR com_port LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR zakaz LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR id_sms LIKE "%'.$_POST["search"]["value"].'%") ';			
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
       
	   
	  
			$rows = array();			
			$rows[] = ucfirst($record['from_sms']);
			$rows[] = $record['com_port'];
			$rows[] = $record['msg'];
			$rows[] = $record['zakaz'];	
			$rows[] = '<div class="btn-group btn-block"><a href="#" class="badge badge-user inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$record['summa'].'</a></div>';	
			$rows[] = '<div class="btn-group btn-block"><a href="#" class="badge badge-user inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$record['balance'].'</a></div>';	
			$rows[] = $record['id_sms'];
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
			SET summa= ?, balance = ?, id_sms = ?, com_port = ?, from_sms = ?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->summa = htmlspecialchars(strip_tags($this->summa));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->id_sms = htmlspecialchars(strip_tags($this->id_sms));
			$this->com_port = htmlspecialchars(strip_tags($this->com_port));
			$this->from_sms = htmlspecialchars(strip_tags($this->from_sms));
			
			
			$stmt->bind_param("sisssi", $this->summa, $this->balance, $this->id_sms, $this->com_port, $this->from_sms, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		if($this->summa) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`summa`, `balance`, `id_sms`, `com_port`, `from_sms`)
			VALUES(?,?,?,?,?)");
		
			$this->summa = htmlspecialchars(strip_tags($this->summa));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->id_sms = htmlspecialchars(strip_tags($this->id_sms));
			$this->com_port = htmlspecialchars(strip_tags($this->com_port));
			$this->from_sms = htmlspecialchars(strip_tags($this->from_sms));
			
			
			$stmt->bind_param("sisss", $this->summa, $this->balance, $this->id_sms, $this->com_port, $this->from_sms);
			
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