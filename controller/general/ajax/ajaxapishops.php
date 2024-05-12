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
    $record->status = $_POST["status"];
	$record->oborot = $_POST["oborot"];
	$record->name = $_POST["name"];
    $record->vetka = $_POST["vetka"];
	$record->site = $_POST["site"];
	$record->groupshop = $_POST["groupshop"];
	$record->apikey = $_POST["apikey"];
	$record->oborot = $_POST["oborot"];
	$record->referal = $_POST["referal"];
	$record->percent_referal = $_POST["percent_referal"];
	$record->vivod = $_POST["vivod"];
	$record->percent = $_POST["percent"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->chat = $_POST["chat"];
    $record->status = $_POST["status"];
	$record->oborot = $_POST["oborot"];
	$record->name = $_POST["name"];
    $record->vetka = $_POST["vetka"];
	$record->site = $_POST["site"];
	$record->groupshop = $_POST["groupshop"];
	$record->apikey = $_POST["apikey"];
	$record->oborot = $_POST["oborot"];
	$record->referal = $_POST["referal"];
	$record->percent_referal = $_POST["percent_referal"];
	$record->vivod = $_POST["vivod"];
	$record->percent = $_POST["percent"];
	$record->updateRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteRecord') {
	$record->id = $_POST["id"];
	$record->deleteRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'momentRecord') {
	$record->id = $_POST["id"];
	$record->momentRecord();
}

if(!empty($_POST['action']) && $_POST['action'] == 'nakopRecord') {
	$record->id = $_POST["id"];
	$record->nakopRecord();
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
   
	private $recordsTable = 'shop';
	public $id;
    public $name;
    public $referal;
    public $groupshop;
	public $apikey;
	public $vivod;
	public $percent_referal;
	public $chat;
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
			$sqlQuery .= ' OR groupshop LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR referal LIKE "%'.$_POST["search"]["value"].'%") ';			
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
			if($record['status'] == 'Активен') {
	        $active = 'Активен';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item inactive" onclick="return false" id="'.$record["id"].'">Выключить</a>';
		} elseif($record['status'] == 'Отключен') {
			$active = 'Отключен';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" onclick="return false" id="'.$record["id"].'">Включить</a>';
		} elseif($record['status'] == 'Модерация') {
			$active = 'На модерации';
			$button = 'primary';
			$active_status = '<a href="#" class="dropdown-item active" onclick="return false" id="'.$record["id"].'">Включить</a>';
		}
		
		
		if($record['vivod'] == 'Накопительный') {
	        $active_vivod = 'Накопительный';
			$button_vivod = 'success';
			$active_status_vivod = '<a href="#" class="dropdown-item moment" onclick="return false" id="'.$record["id"].'">Моментальный</a>';
		} elseif($record['vivod'] == 'Моментальный') {
			$active_vivod = 'Моментальный';
			$button_vivod = 'user';
			$active_status_vivod = '<a href="#" class="dropdown-item nakop" onclick="return false" id="'.$record["id"].'">Накопительный</a>';
		}
		
		
		if($record['token'] == NULL) {
	        $active_bot = 'Бот не добавлен';
			$button_bot = 'user';
			$active_status_bot = '<a href="#" class="dropdown-item action-edit" data-toggle="modal" data-target="#edit-employee-modal" data-id="'.$record["id"].'" href="javascript:void(0);" onclick="return false">Добавить бота</a>';
		} else {
			$active_bot = $record["username"];
			$button_bot = 'success';
			$active_status_bot = '<a href="#" class="dropdown-item action-edit" data-toggle="modal" data-target="#edit-employee-modal" data-id="'.$record["id"].'" href="javascript:void(0);" onclick="return false">Редактировать</a>';
		}
		
		
		$stmt = $this->conn->prepare('SELECT name FROM group_shops WHERE id = ?');
		$namegroup = $record['groupshop']; // or $_GET['userId'];
		$stmt -> bind_param('i', $namegroup);
		$stmt -> execute();
		$stmt -> store_result();
		$stmt -> bind_result($name);
		$stmt -> fetch();
		
		$stmts = $this->conn->prepare('SELECT last_name, first_name, username FROM dle_users WHERE chat = ?');
		$chat = $record['chat']; // or $_GET['userId'];
		$stmts -> bind_param('i', $chat);
		$stmts -> execute();
		$stmts -> store_result();
		$stmts -> bind_result($last_name, $first_name, $username);
		$stmts -> fetch();
		
		if($record['oborot'] < '20000') {
			$vottema = 'danger';
		} elseif($record['oborot'] < '50000') {
			$vottema = 'warning';
		} elseif($record['oborot'] < '90000') {
			$vottema = 'primary';
		} elseif($record['oborot'] < '1000000') {
			$vottema = 'success';
		}
		
		$sum_end = 100000;
		$sum = $record['oborot'];
		$percent = ($sum / $sum_end) * 100;
		
			$rows = array();
			$rows[] = '<a class="viewsss" href="javascript:void(0);" id="'.$record["id"].'" onclick="return false" data-toggle="tooltip" data-placement="top" title="Edit"><span class="badge badge-darks inv-status"> '.$record['name'].' </span></a>';
			$rows[] = '<a href="#" data-toggle="modal" data-target="#exampleModalCenter'.$record["id"].'" id="'.$record["id"].'" onclick="return false"><i class="fa-solid fa-square-info fa-2x" style="color:#1abc9c;"></i></a>
		

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter'.$record["id"].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalCenterTitle">Просмотр магазина '.$record["name"].'</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
												<b>Категория:</b>  '.$name.'
												 <hr>
												<b>Баланс BTC:</b>  '.$record["BTC"].'<br>
												<b>Баланс LTC:</b>  '.$record["LTC"].'<br>
												<b>Баланс ETH:</b>  '.$record["ETH"].'<br>
												<b>Баланс USDT:</b>  '.$record["USDT"].'<br>
												<hr>
						 <b>Процент реферала:</b>  '.$record["percent_referal"].'%<br>
						 <b>Дополнительный процент:</b>  '.$record["percent"].'%<br>
						 <b>Реферал:</b>  ('.$record["referal"].') '.$last_name.' '.$first_name.' '.$username.'
                                                     
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Закрыть</button>
                                                </div>
                                            </div>
                                        </div>
			';
			$rows[] = $name;
			$rows[] = '<div class="btn-group btn-block"><a class="badge badge-'.$button_bot.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active_bot.'</a><div class="dropdown-menu">'.$active_status_bot.'</div></div>';
			
			$rows[] = '<div class="btn-group btn-block"><a href="javascript:void(0);" id="'.$record["id"].'" onclick="return false" class="badge badge-user inv-status viewsss" type="button">Статистика</a></div>';
			$rows[] = '<div class="btn-group btn-block"><a class="badge badge-'.$button.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active.'</a><div class="dropdown-menu">'.$active_status.'</div></div>';
			$rows[] = '<div class="btn-group btn-block"><a class="badge badge-'.$button_vivod.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active_vivod.'</a><div class="dropdown-menu">'.$active_status_vivod.'</div></div>';
			
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
		
			public function momentRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET vivod = 'Моментальный'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
	
		public function nakopRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET vivod = 'Накопительный'
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
			SET status = 'Активен'
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
			SET status = 'Отключен'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}
	}
		
		
		
	
}