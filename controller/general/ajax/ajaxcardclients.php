<?php
include_once 'config/Database.php';

$database = new Databaser();
$db = $database->getConnection();

$record = new Records($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listRecords') {
	$record->listRecords();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addRecord') {
	$record->name = $_POST["name"];
	$record->number = $_POST["number"];
    $record->balance = $_POST["balance"];
	$record->bank = $_POST["bank"];
	$record->limitpay = $_POST["limitpay"];
	$record->limit = $_POST["limit"];
	$record->what = $_POST["what"];
	$record->active = $_POST["active"];
	$record->temp = $_POST["temp"];
	$record->logo = $_POST["logo"];
	if($_POST["what"] == 'shops') {
	$record->groupshop = $_POST["groupshop"];
	} elseif($_POST["what"] == 'clients') {
	$record->groupshop = 0;	
	}

	$record->zametka = $_POST['zametka'];
	$record->drop_name = $_POST['drop_name'];
	$record->drop_tel = $_POST['drop_tel'];
	$record->drop_contact = $_POST['drop_contact'];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->name = $_POST["name"];
	$record->number = $_POST["number"];
    $record->balance = $_POST["balance"];
	$record->bank = $_POST["bank"];
	$record->limitpay = $_POST["limitpay"];
	$record->active = $_POST["active"];
	$record->what = $_POST["what"];
	$record->limit = $_POST["limit"];
	$record->temp = $_POST["temp"];
	$record->logo = $_POST["logo"];
	$record->zametka = $_POST["zametka"];
	if($_POST["what"] == 'shops') {
	$record->groupshop = $_POST["groupshop"];
	} elseif($_POST["what"] == 'clients') {
	$record->groupshop = 0;	
	}
	$record->zametka = $_POST['zametka'];
	$record->drop_name = $_POST['drop_name'];
	$record->drop_tel = $_POST['drop_tel'];
	$record->drop_contact = $_POST['drop_contact'];

	$record->updateRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'inactiveRecord') {
	$record->id = $_POST["id"];
	$record->inactiveRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'activeRecord') {
	$record->id = $_POST["id"];
	$record->activeRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'blockedRecord') {
	$record->id = $_POST["id"];
	$record->blockedRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'problemRecord') {
	$record->id = $_POST["id"];
	$record->problemRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'reshRecord') {
	$record->id = $_POST["id"];
	$record->reshRecord();
}
class Records {	
   
	private $recordsTable = 'card';
	private $recordsTable2 = 'banks';
	public $id;
	public $name;
    public $number;
    public $balance;
    public $bank;
	public $logo;
	public $limitpay;
	public $drop_name;
	public $drop_tel;
	public $drop_contact;
	public $temp;
	public $limit;
	public $zametka;
	public $what;
	public $groupshop;
	public $active;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(drop_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR number LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR drop_contact LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR temp LIKE "%'.$_POST["search"]["value"].'%") ';
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

        if($record['active'] == 'Активна') {
		$status = 'color:#2bc155;';
		$status2 = '<font color="#2bc155">Активна</font>';
		$balance = '<span class="badge badge-pill badge-white">'.$record['balance'].' руб</span>';
		$number = '<span class="badge badge-pill badge-info">'.$record['number'].'</span>';
		} else {
		$status = 'color:#d8d9dd;';
		$status2 = '<font color="#e7515a">Отключена</font>';
		$balance = '<span class="badge badge-pill badge-white">'.$record['balance'].' руб</span>';
		$number = '<span class="badge badge-pill badge-info">'.$record['number'].'</span>';
		}
		if($record['nominal'] == 'VISA') {
		$nominal = '<i class="fab fa-cc-visa fa-1x" style="'.$status.'"></i>';
		} else {
		$nominal = '<i class="fab fa-cc-mastercard fa-1x" style="'.$status.'"></i>';
		}
		if($record['bank'] == 'Сбербанк') {
		$bank = '/assets/images/2020-09-23-sber-logotype.png';
		} elseif($record['bank'] == 'Тинькоф') {
		$bank = '/assets/images/1609144582_tinkoff.png';
		}
		
		if($record['active'] == 'Активна') {
	        $active = '<font color="#2bc155">Активна</font>';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item inactive" id="'.$record["id"].'">Выключить</a>';
		} elseif($record['active'] == 'Отключена') {
			$active = '<font color="#e7515a">Отключена</font>';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		} elseif($record['active'] == 'Заблокирована') {
			$active = '<font color="#e7515a">Блок</font>';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		} elseif($record['active'] == 'Проблемная') {
			$active = '<font color="#e2a03f">Проблема</font>';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'" >Включить</a>';
		} elseif($record['active'] == 'Вопрос решается') {
			$active = '<font color="#805dca">Вопрос решается</font>';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'" >Включить</a>';
		}
		
		if($record['what'] == 'clients') {
		$what = '<span class="badge badge-transparent" style="font-size:0.7rem;">Клиенты</span>';
		} else {
		$what = '<span class="badge badge-transparent" style="font-size:0.7rem;">Магазины</span>';
		}
		$stmt = $this->conn->prepare('SELECT name FROM group_shops WHERE id = ?');
		$namegroup = $record['groupshop']; // or $_GET['userId'];
		$stmt -> bind_param('i', $namegroup);
		$stmt -> execute();
		$stmt -> store_result();
		$stmt -> bind_result($name);
		$stmt -> fetch();
		
		$stmts = $this->conn->prepare('SELECT name_rus, logo_mini FROM banks WHERE name_rus = ?');
		$bank = $record['bank']; // or $_GET['userId'];
		$stmts -> bind_param('s', $bank);
		$stmts -> execute();
		$stmts -> store_result();
		$stmts -> bind_result($name_rus, $logo_mini);
		$stmts -> fetch();
		
		$sum_end = $record['limitpay'];
		$sum = $record['proshlo'];
		$percent = ($sum / $sum_end) * 100;
		$vot =  round($percent);

		
        if($record['groupshop'] == '0') {
		$name = '<span class="badge badge-transparent" style="font-size:0.7rem;">Не выбрано</span>';
		} else {
		$name = '<span class="badge badge-transparent" style="font-size:0.7rem;">'.$name.'</span>';
		}
		
		if($vot < '30') {
		$vottema = 'success';
		} elseif($vot < '50') {
		$vottema = 'primary';
		} elseif($vot < '75') {
		$vottema = 'warning';
		} elseif($vot < '100') {
		$vottema = 'danger';
		}
		    $card = substr($record['number'],15);
			$rows = array();
			$rows[] = '<img class="" width="85" src="'.$record['logo_card'].'" alt="">'.'<span style="display:none;">'.$name_rus.'</span>';
			$rows[] = '<a class="viewsss" href="javascript:void(0);" id="'.$record["id"].'" onclick="return false" data-toggle="tooltip" data-placement="top" title="Edit"><span class="badge badge-darks inv-status"> **** '.$card.' </span></a>';
			$rows[] = ' <div class="btn-group btn-block"><a class="badge badge-'.$button.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active.'</a><div class="dropdown-menu">'.$active_status.'<a class="dropdown-item blocked" id="'.$record["id"].'" href="javascript:void(0);">Заблокирована</a><a class="dropdown-item problem" id="'.$record["id"].'" href="javascript:void(0);">Проблемная</a><a class="dropdown-item resh" id="'.$record["id"].'" href="javascript:void(0);">Вопрос решается</a></div></div>';
			$rows[] = '<div class="progress br-30"><div class="progress-bar br-30 bg-'.$vottema.'" role="progressbar" style="width: '.$vot.'%" aria-valuenow="'.$vot.'" aria-valuemin="0" aria-valuemax="100"></div></div>';
			$rows[] = $record['temp'];
			$rows[] = $name;
			$rows[] = ' <div class="dropdown">
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
			SET name= ?, number= ?, bank= ?, limitpay= ?, what= ?, groupshop= ?, drop_name= ?, drop_tel= ?, drop_contact= ?, zametka= ?, active= ?, temp=?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->number = htmlspecialchars(strip_tags($this->number));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->bank = htmlspecialchars(strip_tags($this->bank));
			$this->limitpay = htmlspecialchars(strip_tags($this->limitpay));
			$this->what = htmlspecialchars(strip_tags($this->what));
			$this->groupshop = htmlspecialchars(strip_tags($this->groupshop));
			$this->active = htmlspecialchars(strip_tags($this->active));
			$this->drop_name = htmlspecialchars(strip_tags($this->drop_name));
			$this->drop_tel = htmlspecialchars(strip_tags($this->drop_tel));
			$this->drop_contact = htmlspecialchars(strip_tags($this->drop_contact));
			$this->zametka = htmlspecialchars(strip_tags($this->zametka));
			$this->temp = htmlspecialchars(strip_tags($this->temp));
			
			
			$stmt->bind_param("ssssssssssssi", $this->name, $this->number, $this->bank, $this->limitpay, $this->what, $this->groupshop, $this->drop_name, $this->drop_tel, $this->drop_contact, $this->zametka, $this->active, $this->temp, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}

	
	public function addRecord(){
		
		
		
		if($this->number) {
		
			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`name`, `number`, `balance`, `bank`, `limitpay`, `what`, `groupshop`, `drop_name`, `drop_tel`, `drop_contact`, `zametka`, `active`, `temp`)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
		
		    $this->name = htmlspecialchars(strip_tags($this->name));
			$this->number = htmlspecialchars(strip_tags($this->number));
			$this->balance = htmlspecialchars(strip_tags($this->balance));
			$this->bank = htmlspecialchars(strip_tags($this->bank));
			$this->limitpay = htmlspecialchars(strip_tags($this->limitpay));
			$this->what = htmlspecialchars(strip_tags($this->what));
			$this->groupshop = htmlspecialchars(strip_tags($this->groupshop));
			$this->drop_name = htmlspecialchars(strip_tags($this->drop_name));
			$this->drop_tel = htmlspecialchars(strip_tags($this->drop_tel));
			$this->drop_contact = htmlspecialchars(strip_tags($this->drop_contact));
			$this->zametka = htmlspecialchars(strip_tags($this->zametka));
			$this->active = htmlspecialchars(strip_tags($this->active));
			$this->temp = htmlspecialchars(strip_tags($this->temp));
			
			$stmt->bind_param("ssissssssssss", $this->name, $this->number, $this->balance, $this->bank, $this->limitpay, $this->what, $this->groupshop, $this->drop_name, $this->drop_tel, $this->drop_contact, $this->zametka, $this->active, $this->temp);
			
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
	public function blockedRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = 'Заблокирована'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
	public function problemRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = 'Проблемная'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
	public function reshRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET active = 'Вопрос решается'
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