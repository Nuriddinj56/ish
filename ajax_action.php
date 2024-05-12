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
    $record->max = $_POST["max"];
    $record->currency_in = $_POST["currency_in"];
	$record->currency_out = $_POST["currency_out"];
	$record->min = $_POST["min"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->percent = $_POST["percent"];
    $record->max = $_POST["max"];
    $record->currency_in = $_POST["currency_in"];
	$record->currency_out = $_POST["currency_out"];
	$record->min = $_POST["min"];
	$record->updateRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}

class Records {	
   
	private $recordsTable = 'currency_para';
	public $id;
    public $percent;
    public $currency_in;
    public $currency_out;
	public $min;
	public $max;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR percent LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR min LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR currency_out LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR currency_in LIKE "%'.$_POST["search"]["value"].'%") ';			
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
			$rows[] = $record['id'];
			$rows[] = ucfirst($record['percent']);
			$rows[] = $record['max'];		
			$rows[] = $record['currency_in'];	
			$rows[] = $record['currency_out'];
			$rows[] = $record['min'];					
			$rows[] = '<button type="button" name="update" id="'.$record["id"].'" class="btn btn-warning btn-xs update">Update</button>';
			$rows[] = '<button type="button" name="delete" id="'.$record["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
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
			SET percent= ?, max = ?, currency_in = ?, currency_out = ?, min = ?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->percent = htmlspecialchars(strip_tags($this->percent));
			$this->max = htmlspecialchars(strip_tags($this->max));
			$this->currency_in = htmlspecialchars(strip_tags($this->currency_in));
			$this->currency_out = htmlspecialchars(strip_tags($this->currency_out));
			$this->min = htmlspecialchars(strip_tags($this->min));
			
			
			$stmt->bind_param("sisssi", $this->percent, $this->max, $this->currency_in, $this->currency_out, $this->min, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		if($this->percent) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`percent`, `max`, `currency_in`, `currency_out`, `min`)
			VALUES(?,?,?,?,?)");
		
			$this->percent = htmlspecialchars(strip_tags($this->percent));
			$this->max = htmlspecialchars(strip_tags($this->max));
			$this->currency_in = htmlspecialchars(strip_tags($this->currency_in));
			$this->currency_out = htmlspecialchars(strip_tags($this->currency_out));
			$this->min = htmlspecialchars(strip_tags($this->min));
			
			
			$stmt->bind_param("sisss", $this->percent, $this->max, $this->currency_in, $this->currency_out, $this->min);
			
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
}
?>