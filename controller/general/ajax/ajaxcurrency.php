<?php
include_once 'config/Database.php';

$database = new Databaser();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['actionp']) && $_POST['actionp'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['actionp']) && $_POST['actionp'] == 'addRecordp') {	
	$record->currency_in = $_POST["currency_in"];
    $record->currency_out = $_POST["currency_out"];
	$record->percent = $_POST["percent"];
	$record->addRecord();
}
if(!empty($_POST['actionp']) && $_POST['actionp'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['actionp']) && $_POST['actionp'] == 'updateRecordp') {
	$record->id = $_POST["id"];
	$record->currency_in = $_POST["currency_in"];
    $record->currency_out = $_POST["currency_out"];
	$record->percent = $_POST["percent"];
	$record->updateRecord();
}
if(!empty($_POST['actionp']) && $_POST['actionp'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}
if(!empty($_POST['actionp']) && $_POST['actionp'] == 'activeRecord') {
	$record->id = $_POST["id"];
	$record->activeRecord();
}

if(!empty($_POST['actionp']) && $_POST['actionp'] == 'inactiveRecord') {
	$record->id = $_POST["id"];
	$record->inactiveRecord();
}

class Records {	
   
	private $recordsTable = 'currency_para';
	public $id;
    public $currency_in;
    public $currency_out;
    public $percent;
	public $active;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR percent_in LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR nominal LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR logo LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR percent_out LIKE "%'.$_POST["search"]["value"].'%") ';			
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


        if($record['active'] == 'Активно') {
		$status = 'color:#2bc155;';
		$status2 = '<button type="button" class="btn btn-warning btn-sm waves-effect waves-light inactive"  id="'.$record["id"].'">Отключить</span>';
		$percent_in = ''.$record['percent_in'].'%';
		$percent_out = ''.$record['percent_out'].'%';
		} else {
		$status = 'color:#d8d9dd;';
		$status2 = '<button type="button" class="btn btn-success btn-sm waves-effect waves-light active"  id="'.$record["id"].'">Включить</span>';
		$percent_in = ''.$record['percent_in'].'%';
		$percent_out = ''.$record['percent_out'].'%';
		}
        if($record['active'] == 'Активно') {
		$active = '<a class="dropdown-item inactive" id="'.$record["id"].'" href="#" onclick="return false">Отключить</a>';
		$active2 = '<span class="badge badge-transparent" style="font-size:0.7rem;"><font color="#31ce77">Активна</font></span>';
		} else {
		$active = '<a class="dropdown-item active" id="'.$record["id"].'" href="#" onclick="return false">Включить</a>';
        $active2 = '<span class="badge badge-transparent" style="font-size:0.7rem;"><font color="#f34943">Отключена</font></span>';			
		}
		

		
		
		
        $card = substr($record['percent_in'],15);
		
			$rows = array();
			$rows[] = '#'.$record['id'];
			$rows[] = $record['currency_in'];
			$rows[] = '<img src="https://акб.kz/ic2.png" width="25" alt="product"/>';
            $rows[] = $record['currency_out'];
			$rows[] = $record['percent'].'%';
			$rows[] = ' <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
                                                    <a class="dropdown-item action-edit update" id="'.$record["id"].'" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>Редактировать</a>
                                                    <a class="dropdown-item action-delete delete" id="'.$record["id"].'" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>Удалить</a>
                                                </div>
                                            </div>';
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
		$home = $_SERVER['DOCUMENT_ROOT'].'/';
        require_once $home . "classes/Db.php";
		$db = new Db();
	    $this->pdo = $db->connect();
		$this->id = htmlspecialchars(strip_tags($this->id));
		
		$this->pdo->prepare("UPDATE ".$this->recordsTable." SET percent=?, currency_in=?, currency_out=? WHERE id=? ")->execute(array($this->percent, $this->currency_in, $this->currency_out, $this->id));
			
		}
	}
	public function addRecord(){
		
		$home = $_SERVER['DOCUMENT_ROOT'].'/';
        require_once $home . "classes/Db.php";
		$db = new Db();
	    $this->pdo = $db->connect();
		
		$empQuery = $this->pdo->prepare("INSERT INTO ".$this->recordsTable." SET percent = :percent, currency_in = :currency_in, currency_out = :currency_out");
                    if($empQuery->execute([
					'percent' => $this->percent,
					'currency_in' => $this->currency_in,
					'currency_out' => $this->currency_out
					])){
					$data['result'] = "success";	
					} else {
					$data['result'] = "error";
					}
					echo json_encode($data);
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
			SET active = 'Активно'
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
			SET active = 'Отключено'
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