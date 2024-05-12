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
    $record->id_account = $_POST["id_account"];
	$record->header = $_POST["header"];
	$record->address = $_POST["address"];
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
    $record->id_account = $_POST["id_account"];
	$record->header = $_POST["header"];
	$record->address = $_POST["address"];
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
   
	private $recordsTable = 'transactions_crypto';
	private $recordsTable2 = 'transactions';
	public $id;
    public $summa;
    public $id_account;
    public $header;
	public $address;
	public $balance;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR id_transaction LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR address LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR header LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR uniq_zakaz LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR id_zakaz LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR date LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR id_account LIKE "%'.$_POST["search"]["value"].'%") ';			
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
		
		
	   if($record['currency'] == 'LTC') {
			$logo = 'https://cryptologos.cc/logos/litecoin-ltc-logo.png';
		} elseif($record['currency'] == 'BTC') {
			$logo = 'https://cryptologos.cc/logos/bitcoin-btc-logo.png';
		} elseif($record['currency'] == 'ETH') {
			$logo = 'https://cryptologos.cc/logos/ethereum-eth-logo.png';
		} elseif($record['currency'] == 'USDT') {
			$logo = 'https://cryptologos.cc/logos/tether-usdt-logo.png';
		}
		
		if($record['address'] == NULL) {
		$address = 'Входящий платёж';	
		} else {
	    $address = $record['address'];	
		}
	  
			$rows = array();
			$rows[] = '<div class="d-flex"><div class="usr-img-frame mr-2 rounded-circle"><img alt="avatar" class="img-fluid rounded-circle" src="'.$logo.'"></div><p class="align-self-center mb-0 admin-name">'.$record['currency'].'</p></div>';			
			$rows[] = $record['header'];
			$rows[] = $record['id_zakaz'];
			$rows[] = $record['uniq_zakaz'];
			$rows[] = $record['date'];
			$rows[] = $record['id_transaction'];			
			$rows[] = $address;
			$rows[] = $record['id_account'];
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
			SET summa= ?, balance = ?, id_account = ?, header = ?, address = ?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->summa = htmlspecialchars(strip_tags($this->summa));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->id_account = htmlspecialchars(strip_tags($this->id_account));
			$this->header = htmlspecialchars(strip_tags($this->header));
			$this->address = htmlspecialchars(strip_tags($this->address));
			
			
			$stmt->bind_param("sisssi", $this->summa, $this->balance, $this->id_account, $this->header, $this->address, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		if($this->summa) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`summa`, `balance`, `id_account`, `header`, `address`)
			VALUES(?,?,?,?,?)");
		
			$this->summa = htmlspecialchars(strip_tags($this->summa));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->id_account = htmlspecialchars(strip_tags($this->id_account));
			$this->header = htmlspecialchars(strip_tags($this->header));
			$this->address = htmlspecialchars(strip_tags($this->address));
			
			
			$stmt->bind_param("sisss", $this->summa, $this->balance, $this->id_account, $this->header, $this->address);
			
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