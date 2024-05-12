<?php
include_once 'config/Database.php';

$database = new Databaser();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {	
	$record->percent = $_POST["percent"];
    $record->percent_out = $_POST["percent_out"];
	$record->logo = $_POST["logo"];
	$record->name = $_POST["name"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->percent = $_POST["percent"];
    $record->percent_out = $_POST["percent_out"];
	$record->logo = $_POST["logo"];
	$record->name = $_POST["name"];
	$record->active = '0';
	$record->updateRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'zamenaRecord') {
	$record->id = $_POST["id"];
	$record->zamenaRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'zamenaOffRecord') {
	$record->id = $_POST["id"];
	$record->zamenaOffRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'inactiveRecord') {
	$record->id = $_POST["id"];
	$record->inactiveRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'activeRecord') {
	$record->id = $_POST["id"];
	$record->activeRecord();
}
class Records {	
   
	private $recordsTable = 'group_shops';
	public $id;
    public $percent;
    public $percent_out;
    public $logo;
	public $name;
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
			$sqlQuery .= ' OR active LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR percent LIKE "%'.$_POST["search"]["value"].'%" ';		}
		
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
		
		if($record['active'] == 'Активна') {
	        $active = 'Активна';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item inactive" id="'.$record["id"].'">Выключить</a>';
		} elseif($record['active'] == 'Отключена') {
			$active = 'Отключена';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		} elseif($record['status'] == 'Модерация') {
			$active = 'Блок';
			$button = 'warning';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		}
		
		if($record['replace_card'] == 'Работает') {
	        $active_card = 'Работает';
			$button_card = 'success';
			$active_status_card = '<a href="#" class="dropdown-item zamena" id="'.$record["id"].'">Режим смены карты</a>';
		} elseif($record['replace_card'] == 'Замена карты') {
			$active_card = 'Замена карты';
			$button_card = 'danger';
			$active_status_card = '<a href="#" class="dropdown-item zamenaoff" id="'.$record["id"].'">Включить</a>';
		}
		
		
		 if($record['active'] == 'Активна') {
		$status = 'color:#2bc155;';
		$status2 = '<span class="badge badge-pill badge-success">Активна</span>';
		$percent = '<span class="badge badge-transparent" style="font-size:0.7rem;">'.$record['percent'].'%</span>';
		$percent_out = '<span class="badge badge-pill badge-dark"><i class="fa-solid fa-cart-arrow-up"></i> '.$record['percent_out'].'%</span>';
		} else {
		$status = 'color:#d8d9dd;';
		$status2 = '<span class="badge badge-pill badge-warning">Отключена</span>';
		$percent = '<span class="badge badge-transparent" style="font-size:0.7rem;">'.$record['percent'].'%</span>';
		$percent_out = '<span class="badge badge-pill badge-dark"><i class="fa-solid fa-cart-arrow-up"></i> '.$record['percent_out'].'%</span>';
		}
		
		
        $card = substr($record['percent'],15);
		
			$rows = array();
			$rows[] = $record['id'];
			$rows[] = '<span class="badge badge-darks inv-status"> '.$record['name'].' </span>';
			$rows[] = $percent;
			$rows[] = '<div class="btn-group btn-block">
                                                        <a class="badge badge-'.$button_card.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            '.$active_card.'
                                                        </a>
                                                        <div class="dropdown-menu">
												'.$active_status_card.'
                                                </div>
                                            </div>';
			$rows[] = '<div class="btn-group btn-block">
                                                        <a class="badge badge-'.$button.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            '.$active.'
                                                        </a>
                                                        <div class="dropdown-menu">
												'.$active_status.'
                                                </div>
                                            </div>';
											$rows[] = '<div class="dropdown">
			<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1">
			</circle><circle cx="19" cy="12" r="1"></circle>
			<circle cx="5" cy="12" r="1"></circle></svg></a>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
			<a class="dropdown-item action-edit" data-toggle="modal" data-target="#edit-employee-modal" data-id="'.$record["id"].'" href="javascript:void(0);">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
			<path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
			</svg>Редактировать</a>
			<a class="dropdown-item action-delete btn-delete-employee" data-id="'.$record["id"].'" href="javascript:void(0);">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
			<polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
			</svg>Удалить</a></div></div>';
											
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
			SET name= ?, percent = ?
			WHERE id = ?");
	 
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->percent = htmlspecialchars(strip_tags($this->percent));
			
			
			$stmt->bind_param("sii", $this->name, $this->percent, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		if($this->percent) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`name`, `percent`)
			VALUES(?,?)");
		
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->percent = htmlspecialchars(strip_tags($this->percent));
			
			
			$stmt->bind_param("si", $this->name, $this->percent);
			
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
	
	public function zamenaRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET replace_card = 'Замена карты'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
		public function zamenaOffRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET replace_card = 'Работает'
			WHERE id = ?");
	 
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
			SET active = 'Активна'
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
			SET active = 'Отключена'
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