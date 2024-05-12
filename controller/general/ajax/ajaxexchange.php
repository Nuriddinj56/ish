<?php
include_once 'config/Database.php';

$database = new Databaser();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'shopsRecord') {
	$record->id = $_POST["id"];
	$record->shopsRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'clientsRecord') {
	$record->id = $_POST["id"];
	$record->clientsRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'inactiveRecord') {
	$record->id = $_POST["id"];
	$record->inactiveRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'activeRecord') {
	$record->id = $_POST["id"];
	$record->what = $_POST["what"];	
	/* if($record->what == 'Клиенты') {
	$record->delsCurRecord();
	$record->delsRecord();
	} elseif($record->what == 'Магазины') {
		$record->delsCurApiRecord();
	} */
	$record->activesRecord();
	$record->activeRecord();
}

class Records {	
   
	private $recordsTable = 'exchanges';
	private $recordsTablePars = 'currency_para';
	private $recordsTableCur = 'currency_in';
	private $recordsTableCurApi = 'currency_api';
	public $id;
    public $name;
    public $api_secret;
	public $api_key;
	public $what;
	public $active;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR api_key LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR api_secret LIKE "%'.$_POST["search"]["value"].'%" ';		}
		
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
		
		if($record['what'] == 'Магазины') {
	        $active_vivod = 'Магазины';
			$button_vivod = 'success';
			$active_status_vivod = '<a href="#" class="dropdown-item clients" onclick="return false" id="'.$record["id"].'">Клиенты</a>';
		} elseif($record['what'] == 'Клиенты') {
			$active_vivod = 'Клиенты';
			$button_vivod = 'user';
			$active_status_vivod = '<a href="#" class="dropdown-item shops" onclick="return false" id="'.$record["id"].'">Магазины</a>';
		} elseif($record['what'] == NULL) {
			$active_vivod = 'Не выбрано';
			$button_vivod = 'user';
			$active_status_vivod = '<a href="#" class="dropdown-item shops" onclick="return false" id="'.$record["id"].'">Магазины</a><a href="#" class="dropdown-item clients" onclick="return false" id="'.$record["id"].'">Клиенты</a>';
		}
		
		if($record['active'] == '1') {
	        $active = 'Активна';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item inactive" onclick="return false" id="'.$record["id"].'">Выключить</a>';
		} elseif($record['active'] == '0') {
			$active = 'Отключена';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" onclick="return false" what="'.$record["what"].'" id="'.$record["id"].'">Включить</a>';
		}
		
		
		$stmt = $this->conn->prepare('SELECT name FROM group_shops WHERE id = ?');
		$namegroup = $record['groupshop']; // or $_GET['userId'];
		$stmt -> bind_param('i', $namegroup);
		$stmt -> execute();
		$stmt -> store_result();
		$stmt -> bind_result($name);
		$stmt -> fetch();
		
		if($record['groupshop'] == NULL) {
	        $groupshop = 'Не указано';
		} else {
			$groupshop = $name;
		}
		
			$rows = array();
			$rows[] = '<img class="" width="85" src="https://m.foolcdn.com/media/affiliates/cryptocurrency-art/Coinbase_logo_qQKi9Mh.png" alt="">';
			$rows[] = $record['name'];
			$rows[] = '<div class="btn-group btn-block"><a class="badge badge-'.$button_vivod.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active_vivod.'</a><div class="dropdown-menu">'.$active_status_vivod.'</div></div>';
			$rows[] = $groupshop;
			$rows[] = '<div class="btn-group btn-block"><a class="badge badge-'.$button.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active.'</a><div class="dropdown-menu">'.$active_status.'</div></div>';
			$rows[] = $record['api_key'];
			$rows[] = $record['api_secret'];
			$rows[] = '
			 <ul class="table-controls">
			 <li><a class="action-delete btn-delete-employee" href="javascript:void(0);" data-id="'.$record["id"].'"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></li>
			 </ul>
			
			';
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
		
			public function shopsRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET what = 'Магазины'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
	
		public function clientsRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET what = 'Клиенты', active = '0'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
	
	public function activesRecord(){
		
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = '0'
			WHERE active = '1' and what = ?");
			
			$this->what = htmlspecialchars(strip_tags($this->what));

			
			
			$stmt->bind_param("s", $this->what);
			
			if($stmt->execute()){
				return true;
			}
	}
	
	
	public function delsRecord(){
		
			
			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->recordsTablePars." 
				");
			if($stmt->execute()){
				return true;
			}
	}
	
	
	public function delsCurRecord(){
		
			
			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->recordsTableCur." 
				WHERE id != '4'");
				
			if($stmt->execute()){
				return true;
			}
	}
	
	public function delsCurApiRecord(){
		
			
			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->recordsTableCurApi." 
				");
				
			if($stmt->execute()){
				return true;
			}
	}
	
	
	public function activeRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = '1'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function inactiveRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = '0'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
		
		
		
	
}