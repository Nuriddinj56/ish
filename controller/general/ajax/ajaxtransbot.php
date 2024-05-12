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
    $record->sum_rub = $_POST["sum_rub"];
    $record->sum_crypto = $_POST["sum_crypto"];
	$record->client_requisites = $_POST["client_requisites"];
	$record->payer_requisites = $_POST["payer_requisites"];
	$record->addRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRecord') {
	$record->id = $_POST["id"];
	$record->getRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateRecord') {
	$record->id = $_POST["id"];
	$record->chat = $_POST["chat"];
    $record->sum_rub = $_POST["sum_rub"];
    $record->sum_crypto = $_POST["sum_crypto"];
	$record->client_requisites = $_POST["client_requisites"];
	$record->payer_requisites = $_POST["payer_requisites"];
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

if(!empty($_POST['action']) && $_POST['action'] == 'paysRecord') {
	$record->id = $_POST["id"];
	$record->paysRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'sendmoneyRecord') {
	$record->id = $_POST["id"];
	$record->sendmoneyRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'waitRecord') {
	$record->id = $_POST["id"];
	$record->waitRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'cancellRecord') {
	$record->id = $_POST["id"];
	$record->cancellRecord();
}
if(!empty($_POST['action']) && $_POST['action'] == 'timeoffRecord') {
	$record->id = $_POST["id"];
	$record->timeoffRecord();
}


class Records {	
   
	private $recordsTable = 'transactions';
	public $id;
    public $chat;
    public $sum_crypto;
    public $client_requisites;
	public $payer_requisites;
	public $sum_rub;
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }	    
	
	public function listRecords(){
		
		$sqlQuery = "SELECT * FROM ".$this->recordsTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR chat LIKE "%'.$_POST["search"]["value"].'%" ';			
			$sqlQuery .= ' OR payer_requisites LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR client_requisites LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR name_shop LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR id_transaction LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR uniq_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR port LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR sms_fullid LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR datetime LIKE "%'.$_POST["search"]["value"].'%") ';	
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
       
	   
$network_chto = $record['network_chto'];
		$network_nachto = $record['network_nachto'];
        if($record['chto'] == 'VISA') {
		$chto = $record['sum_rub'] . ' руб.';
		} else {
		$chto = $record['sendclient_crypto'] . ' ('.$record['out_summ'].'₽)';
		}
        if($record['na_chto'] == 'VISA') {
		$na_chto = $record['sum_rub'] . ' руб.';
		} else {
		$na_chto = $record['sendclient_crypto'] . ' ('.$record['out_summ'].'₽)';
		}
		
		$stmt = $this->conn->prepare('SELECT username, last_name, first_name, image FROM dle_users WHERE chat = ?');
		$namegroup = $record['chat']; // or $_GET['userId'];
		$stmt -> bind_param('i', $namegroup);
		$stmt -> execute();
		$stmt -> store_result();
		$stmt -> bind_result($username, $last_name, $first_name, $image);
		$stmt -> fetch();
		
		$time_add = date('Y-m-d H:i:s', $record['date_create']);
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'Cегодня в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		
		if($record['status'] == 'Ждём оплату') {
	        $active = 'В ожидании';
			$button = 'wait';
			$active_status = '<a href="#" class="dropdown-item inactive" id="'.$record["id"].'">Выключить</a>';
		} elseif($record['status'] == 'Отменён') {
			$active = 'Отменён';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		} elseif($record['status'] == 'Выплачено') {
			$active = 'Выплачено';
			$button = 'success';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		}
		 elseif($record['status'] == 'Просрочено') {
			$active = 'Просрочено';
			$button = 'danger';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		} else {
			$active = $record['status'];
			$button = 'primary';
			$active_status = '<a href="#" class="dropdown-item active" id="'.$record["id"].'">Включить</a>';
		}
				if($record['date_pay'] == NULL) {
		$datepay = '<span class="inv-date" style="color:#A61000;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Не оплачен</span>';
		} else {
		$time_adds = date('Y-m-d H:i:s', $record['date_pay']);
		$date_str = new DateTime($time_adds);
		$date = $date_str->Format('d.m.Y');
		$date_month = $date_str->Format('d.m');
		$date_year = $date_str->Format('Y');
		$date_time = $date_str->Format('H:i');
		
		$ndate = date('d.m.Y');
		$ndate_time = date('H:i');
		$ndate_time_m = date('i');
		$ndate_exp = explode('.', $date);
		$nmonth = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth as $key => $value) {
			if($key == intval($ndate_exp[1])) $nmonth_name = $value;
		}
		
		if ($date == date('d.m.Y')){
			$datetime = 'Cегодня в ' .$date_time;
		}
		else if ($date == date('d.m.Y', strtotime('-1 day'))){
			$datetime = 'Вчера в ' .$date_time;
		}
		else if ($date != date('d.m.Y') && $date_year != date('Y')){
			$datetime = $ndate_exp[0].' '.$nmonth_name.' '.$ndate_exp[2]. ' в '.$date_time.'';
		}
		else {
		    $datetime = $ndate_exp[0].' '.$nmonth_name.' в '.$date_time.'';
		}
		$datepay = '<span class="inv-date" style="color:#1abc9c;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> '.$datetime.'</span>';
		}
		
		if($record['kto'] == 'shop') {
		$what = '<i class="fa-solid fa-shop fa-sm"  style="color:#0D58A6;"></i> API';
		} else {
		$what = '<i class="fa-solid fa-robot fa-sm" style="color:#0D58A6;"></i> BOT';
		}
		if($record['date_pay'] == NULL) {
		$datepayfull = 'Не оплачена';
		} else {
		$datepayfull =	$datetime;
		}
		if($record['kto'] == 'shop') {
			$us = '';
			$ava = 'assets/img/90x90.jpg';
		} else {
			$us = '<b>Пользователь:</b><br> '.$record["chat"].'<br>'.$username.' '.$last_name.' '.$first_name.'<br>';
			$ava = $image;
		}
	
		
		if($record['status'] == 'Выплачено') {
			$pays = '<b>Отправлено в крипте:</b><br>  '.$record['sendclient_crypto'].' '.$record['na_chto'].'  ( '.$record["out_summ"].' ₽)<br>';
		} elseif($record['status'] == 'Зачислено на счёт') {
			$pays = '<b>Зачислено на счёт в крипте:</b><br>  '.$record['sendclient_crypto'].' '.$record['na_chto'].'  ( '.$record["out_summ"].' ₽)<br>';
		} else {
			$pays = '';
		}

		
		$stmtss = $this->conn->prepare('SELECT date, msg, id_sms FROM simbank WHERE id = ?');
		$sms = $record['sms_id']; // or $_GET['userId'];
		$stmtss -> bind_param('i', $sms);
		$stmtss -> execute();
		$stmtss -> store_result();
		$stmtss -> bind_result($date, $msg, $id_sms);
		$stmtss -> fetch();
		
		
		if($record['sms_id'] == NULL) {
			$smska = '';
		} else {
		
		$time_pay = date('Y-m-d H:i:s', $date);
		$date_str_pay = new DateTime($time_pay);
		$date_pay = $date_str_pay->Format('d.m.Y');
		$date_month_pay = $date_str_pay->Format('d.m');
		$date_year_pay = $date_str_pay->Format('Y');
		$date_time_pay = $date_str_pay->Format('H:i');
		
		$ndate_pay = date('d.m.Y');
		$ndate_time_pay = date('H:i');
		$ndate_time_m_pay = date('i');
		$ndate_exp_pay = explode('.', $date_pay);
		$nmonth_pay = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_pay as $key_pay => $value_pay) {
			if($key_pay == intval($ndate_exp_pay[1])) $nmonth_name_pay = $value_pay;
		}
		
		if ($date_pay == date('d.m.Y')){
			$datetime_pay = 'Cегодня в ' .$date_time_pay;
		}
		else if ($date_pay == date('d.m.Y', strtotime('-1 day'))){
			$datetime_pay = 'Вчера в ' .$date_time_pay;
		}
		else if ($date_pay != date('d.m.Y') && $date_year_pay != date('Y')){
			$datetime_pay = $ndate_exp_pay[0].' '.$nmonth_name_pay.' '.$ndate_exp_pay[2]. ' в '.$date_time_pay;
		}
		else {
		    $datetime_pay = $ndate_exp_pay[0].' '.$nmonth_name_pay.' в '.$date_time_pay;
		} 
			$smska = '<b>Сообщение:</b><br> '.$msg.'<br><b>ID SMS:</b><br> '.$id_sms.'<br><b>Дата получения:</b><br> '.$datetime_pay;
		}
		
		if ($record['name_shop'] == NULL){
			$name_shop = 'Клиент';
		} else {
		    $name_shop = $record['name_shop'];	
		}
		
			$rows = array();			
			$rows[] = '<div class="d-flex"><p class="align-self-center mb-0 admin-name"><i class="fa-solid fa-hashtag fa-lg" style="color:#0D58A6;"></i> '.$record["id"].'<br>'.$what.'</p></div>';
			$rows[] = $name_shop;
			$rows[] = '<a href="#" data-toggle="modal" data-target="#exampleModalCenter'.$record["id"].'" id="'.$record["id"].'" onclick="return false"><i class="fa-thin fa-rectangle-barcode fa-2x" style="color:#1abc9c;"></i></a>
		

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter'.$record["id"].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalCenterTitle">Просмотр заявки #'.$record["id"].'<br><span style="font-size:0.7rem;color:#999;">'.$record["name_shop"].'</span></h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
												<b>Номер заявки:</b><br>  '.$record["id"].'<br>
												<b>Уникальный ID заявки:</b><br>  '.$record["uniq_id"].'<br>
												<b>Где создана заявка:</b><br>  '.$what.'<br>
						 <b>Дата создания заявки:</b><br>  '.$datetime_create.'<br>
						 <b>Дата оплаты заявки:</b><br>  '.$datepayfull.'<br>
						 <b>Направление обмена:</b><br>  '.ucfirst($network_chto).' на '.ucfirst($network_nachto).'<br>
						 <b>Сумма в рублях на момент создания:</b><br>  '.$record["sum_rub"].'<br>
						 <b>Сумма в крипте на момент создания:</b><br>  '.$record["original_crypto"].'<br>
						 <b>Статус заявки:</b><br>  '.$record["status"].'<br>
						 '.$us.'
						 '.$pays.'
			<b>Реквизиты пользователя:</b><br> '.$record["client_requisites"].'<br>
			<b>Реквизиты оплаты:</b><br> '.$record["payer_requisites"].'<br>
			'.$smska.'
                                                     
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Закрыть</button>
                                                </div>
                                            </div>
                                        </div>
			';
			$rows[] = '<div class="d-flex"><div class="usr-img-frame mr-2 rounded-circle"><img alt="avatar" class="img-fluid rounded-circle" src="'.$record['logo_chto'].'"></div><p class="align-self-center mb-0 admin-name">'.ucfirst($network_chto).'<br>'.$chto.' </p></div>';
			$rows[] = '<i class="fa-thin fa-arrows-rotate fa-1x" style="color:#1abc9c;"></i>';
			$rows[] = '<div class="d-flex"><div class="usr-img-frame mr-2 rounded-circle"><img alt="avatar" class="img-fluid rounded-circle" src="'.$record['logo_nachto'].'"></div><p class="align-self-center mb-0 admin-name"><span style="color:#19af92;"><i class="fa-solid fa-chevron-down"></i></span> '.$record['original_crypto'] . ' ('.$record['sum_rub'].'₽)<br>'.$na_chto.' <span style="color:#bd434e;"><i class="fa-solid fa-chevron-up"></i></span></p></div>';
			$rows[] = ' <div class="btn-group btn-block"><a class="badge badge-'.$button.' inv-status" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$active.'</a>
			<div class="dropdown-menu">
			<a class="dropdown-item pays" id="'.$record["id"].'" href="javascript:void(0);">Выплачено</a>
			<a class="dropdown-item sendmoney" id="'.$record["id"].'" href="javascript:void(0);">Переводим средства</a>
			<a class="dropdown-item wait" id="'.$record["id"].'" href="javascript:void(0);">В ожиданиии</a>
			<a class="dropdown-item cancell" id="'.$record["id"].'" href="javascript:void(0);">Отменить</a>
			<a class="dropdown-item timeoff" id="'.$record["id"].'" href="javascript:void(0);">Просрочено</a>
			</div></div>';
			$rows[] = '<div class="d-flex"><div class="usr-img-frame mr-2 rounded-circle"><img alt="avatar" class="img-fluid rounded-circle" src="/'.$ava.'"></div><p class="align-self-center mb-0 admin-name"> '.$username.' '.$last_name.' '.$first_name.'<br>'.$record['chat'].' </p></div>';
			$rows[] = $datepay . '<br><span class="inv-date"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> '.$datetime_create.'</span>';	
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
			</svg>Удалить</a></div></div>';			$records[] = $rows;
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
			SET chat= ?, sum_rub = ?, sum_crypto = ?, client_requisites = ?, payer_requisites = ?
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->chat = htmlspecialchars(strip_tags($this->chat));
			$this->sum_rub = htmlspecialchars(strip_tags($this->sum_rub));
			$this->sum_crypto = htmlspecialchars(strip_tags($this->sum_crypto));
			$this->client_requisites = htmlspecialchars(strip_tags($this->client_requisites));
			$this->payer_requisites = htmlspecialchars(strip_tags($this->payer_requisites));
			
			
			$stmt->bind_param("sisssi", $this->chat, $this->sum_rub, $this->sum_crypto, $this->client_requisites, $this->payer_requisites, $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function addRecord(){
		
		if($this->chat) {

			$stmt = $this->conn->prepare("
			INSERT INTO ".$this->recordsTable."(`chat`, `sum_rub`, `sum_crypto`, `client_requisites`, `payer_requisites`)
			VALUES(?,?,?,?,?)");
		
			$this->chat = htmlspecialchars(strip_tags($this->chat));
			$this->sum_rub = htmlspecialchars(strip_tags($this->sum_rub));
			$this->sum_crypto = htmlspecialchars(strip_tags($this->sum_crypto));
			$this->client_requisites = htmlspecialchars(strip_tags($this->client_requisites));
			$this->payer_requisites = htmlspecialchars(strip_tags($this->payer_requisites));
			
			
			$stmt->bind_param("sisss", $this->chat, $this->sum_rub, $this->sum_crypto, $this->client_requisites, $this->payer_requisites);
			
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
	
	public function waitRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Ждём оплату', accert = '0'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function cancellRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Отменён', accert = '4'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	public function timeoffRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Просрочено', accert = '4'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
	
		public function sendmoneyRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Переводим средства', accert = '2'
			WHERE id = ?");
	 
			$this->id = htmlspecialchars(strip_tags($this->id));

			
			
			$stmt->bind_param("i", $this->id);
			
			if($stmt->execute()){
				return true;
			}
			
		}	
	}
	
		public function paysRecord(){
if($this->id) {			
			
			$stmt = $this->conn->prepare("
			UPDATE ".$this->recordsTable." 
			SET status = 'Выплачено', accert = '3'
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