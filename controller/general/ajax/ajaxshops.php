<?php
include_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {
	$record->name = $_POST["name"];
	$record->percent = $_POST["percent"];
    $record->balance = $_POST["balance"];
	$record->apikey = $_POST["apikey"];
	$record->groupshop = $_POST["groupshop"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->name = $_POST["name"];
	$record->percent = $_POST["percent"];
    $record->balance = $_POST["balance"];
	$record->apikey = $_POST["apikey"];
	$record->groupshop = $_POST["groupshop"];
	$record->active = '0';
	$record->updateRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'activeRecord') {
	$record->id = $_POST["id"];
	//$record->clearRecord();
	$record->activeRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'inactiveRecord') {
	$record->id = $_POST["id"];
	$record->inactiveRecord();
}

class Records {	
   
	private $recordsTable = 'api_shops';
	public $id;
	public $name;
    public $percent;
    public $balance;
    public $apikey;
	public $groupshop;
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
			$sqlQuery .= ' OR apikey LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR balance LIKE "%'.$_POST["search"]["value"].'%") ';			
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

        if($record['active'] == 1) {
		$status = 'color:#2bc155;';
		$status2 = '<span class="badge badge-pill badge-success">Активен</span>';
		$balance = '<span class="badge badge-pill badge-white">'.$record['balance'].' руб</span>';
		$percent = '<span class="badge badge-pill badge-info">'.$record['percent'].'</span>';
		} else {
		$status = 'color:#d8d9dd;';
		$status2 = '<span class="badge badge-pill badge-warning">Отключен</span>';
		$balance = '<span class="badge badge-pill badge-white">'.$record['balance'].' руб</span>';
		$percent = '<span class="badge badge-pill badge-info">'.$record['percent'].'</span>';
		}
		if($record['nominal'] == 'VISA') {
		$nominal = '<i class="fab fa-cc-visa fa-2x" style="'.$status.'"></i>';
		} else {
		$nominal = '<i class="fab fa-cc-mastercard fa-2x" style="'.$status.'"></i>';
		}
		if($record['apikey'] == 'Сбербанк') {
		$apikey = '/assets/images/2020-09-23-sber-logotype.png';
		} elseif($record['apikey'] == 'Тинькоф') {
		$apikey = '/assets/images/1609144582_tinkoff.png';
		}
		
		if($record['active'] == '1') {
		$active = '<a class="dropdown-item inactive" id="'.$record["id"].'" href="#" onclick="return false">Отключить</a>';
		} else {
		$active = '<a class="dropdown-item active" id="'.$record["id"].'" href="#" onclick="return false">Включить</a>';	
		}
		
		$stmt = $this->conn->prepare('SELECT name FROM group_shops WHERE id = ?');
		$namegroup = $record['groupshop']; // or $_GET['userId'];
		$stmt -> bind_param('i', $namegroup);
		$stmt -> execute();
		$stmt -> store_result();
		$stmt -> bind_result($name);
		$stmt -> fetch();
        if($record['groupshop'] == '0') {
		$name = '<span class="badge badge-pill badge-white">Не выбрано</span>';
		} else {
		$name = '<span class="badge badge-pill badge-white">'.$name.'</span>';
		}
		
			$rows = array();
			$rows[] = '<span class="badge badge-pill badge-white">'.$record['name'].'</span>';
			$rows[] = $status2;
			$rows[] = '<div class="btn-group mb-2 btn-group-sm" style="margin-top:9px;"><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#basicModal'.$record['id'].'" onclick="return false">показать</button></div>
			<div class="modal fade" id="basicModal'.$record['id'].'">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">API KEY Магазина '.$record['name'].'</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body"><p id="foo'.$record['id'].'">'.$record['apikey'].'</p>
                                                <div class="modal-footer">
												<div class="btn-group btn-block mb-2 btn-group-sm">
                                    <button class="btn btn-block btn-primary" data-clipboard-target="#foo'.$record['id'].'" type="button">Копировать ключ</button>
                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
			';
			$rows[] = '<span class="badge badge-pill badge-primary">'.$record['percent'].'%</span>';
			$rows[] = $name;
            $rows[] = $balance;			
			$rows[] = '<div class="dropdown ms-auto text-right"><div class="btn-link" data-bs-toggle="dropdown"><svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></div><div class="dropdown-menu dropdown-menu-end">'.$active.'<a class="dropdown-item update" id="'.$record["id"].'" href="#" onclick="return false">Редактировать</a><a class="dropdown-item delete" id="'.$record["id"].'" href="#" onclick="return false">Удалить</a></div></div>';
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
			SET name= ?, percent= ?, balance = ?, apikey = ?, groupshop = ?, active = ?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->percent = htmlspecialchars(strip_tags($this->percent));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->apikey = htmlspecialchars(strip_tags($this->apikey));
			$this->groupshop = htmlspecialchars(strip_tags($this->groupshop));
			$this->active = htmlspecialchars(strip_tags($this->active));
			
			
			$stmt->bind_param("ssisssi", $this->name, $this->percent, $this->balance, $this->apikey, $this->groupshop, $this->active, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		if($this->percent) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`name`, `percent`, `balance`, `apikey`, `groupshop`)
			VALUES(?,?,?,?,?)");
		
		    $this->name = htmlspecialchars(strip_tags($this->name));
			$this->percent = htmlspecialchars(strip_tags($this->percent));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->apikey = htmlspecialchars(strip_tags($this->apikey));
			$this->groupshop = htmlspecialchars(strip_tags($this->groupshop));
			
			$stmt->bind_param("ssiss", $this->name, $this->percent, $this->balance, $this->apikey, $this->groupshop);
			
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
	
	public function clearRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = 0
			WHERE active = 1");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	public function activeRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = 1
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
			SET active = 0
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