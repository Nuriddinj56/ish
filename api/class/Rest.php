<?php
class Rest{
private $host  = 'localhost';
private $user  = 'orion';
private $password   = "пароль от бд";
private $database  = "orion";      
private $empTable = 'transactions';	
private $dbConnect = false;
public function __construct(){
	if(!$this->dbConnect){ 
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		if($conn->connect_error){
			die("Error failed to connect to MySQL: " . $conn->connect_error);
		}else{
			$this->dbConnect = $conn;
		}
	}
}
private function getData($sqlQuery) {
	$result = mysqli_query($this->dbConnect, $sqlQuery);
	if(!$result){
		die('Error in query: '. mysqli_error());
	}
	$data= array();
	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$data[]=$row;            
	}
	return $data;
}
private function getNumRows($sqlQuery) {
	$result = mysqli_query($this->dbConnect, $sqlQuery);
	if(!$result){
		die('Error in query: '. mysqli_error());
	}
	$numRows = mysqli_num_rows($result);
	return $numRows;
}
public function getEmployee($empId) {		
	$sqlQuery = '';
	$home = $_SERVER['DOCUMENT_ROOT'].'/';
	require_once $home . "classes/Db.php";
	$db = new Db();
	$this->pdo = $db->connect();
	
	$order = $this->pdo->prepare("SELECT * FROM transactions WHERE uniq_id = :uniq_id");
	$order->execute(['uniq_id' => $empId]);
	if ($order->rowCount() > 0) {
		
	$orders = $this->pdo->query("SELECT * FROM `transactions` WHERE uniq_id = '".$empId."'");
	$orders = $orders->fetch(PDO::FETCH_ASSOC);

	if ($orders['status_payclient'] == 'Оплата получена') {
				if($empId) {
	$empData = array(
		'id' => $orders['uniq_id'],
		'amount' => $orders['sum_rub'],
		'requisites' => $orders['payer_requisites'],
		'status' => $orders['status_payclient'],
		'date_create' => $orders['date_create'],
		'date_pay' => $orders['date_pay']
/* 		'send_crypto' => $orders['status'],
		'currency_crypto' => $orders['na_chto'],
		'summa_crypto' => $orders['sendclient_crypto'],
		'hash_crypto' => $orders['hash'] */
	);
	}
	  } else {
		if($empId) {
	$empData = array(
	    'id' => $orders['uniq_id'],
		'amount' => $orders['sum_rub'],
		'requisites' => $orders['payer_requisites'],
		'status' => $orders['status_payclient'],
		'date_create' => $orders['date_create']
/* 		'send_crypto' => $orders['status'],
		'currency_crypto' => $orders['na_chto'],
		'summa_crypto' => $orders['sendclient_crypto'],
		'hash_crypto' => $orders['hash'] */
	);
	}  	
	
		  
	  }
	header('Content-Type: application/json');
	echo json_encode($empData, JSON_UNESCAPED_UNICODE);
	
	} else {
		$empResponse = array(
		'error' => 'Такого заказа не существует'
	);
	header('Content-Type: application/json');
	echo json_encode($empResponse, JSON_UNESCAPED_UNICODE);
		
	}
}
function insertEmployee($empData){
	if(!empty($empData["invoice_get"]) && !empty($empData["apikey"]) && !empty($empData["shop_currency"]) && !empty($empData["shop_wallet"])){
	$home = $_SERVER['DOCUMENT_ROOT'].'/';
	require_once $home . "classes/Db.php";
	$db = new Db();
	$this->pdo = $db->connect();
	
	$order = $this->pdo->prepare("SELECT * FROM shop WHERE apikey = :apikey");
	$order->execute(['apikey' => $empData["apikey"]]);
	$shop = $this->pdo->query("SELECT * FROM `shop` WHERE apikey = '".$empData["apikey"]."' and status = 'Активен'");
	$shop = $shop->fetch(PDO::FETCH_ASSOC);
	$price = $empData["invoice_get"];
	$percent = $shop["percent"];
	$itog = $price + ($price * ($percent / 100));  // 1200
	if ($order->rowCount() > 0) {

	
	$card_verify = $this->pdo->prepare("SELECT * FROM card WHERE groupshop = :groupshop and active = :active");
	$card_verify->execute(['groupshop' => $shop['groupshop'], 'active' => 'Активна']);
	
	if ($card_verify->rowCount() > 0) {
		
	$card = $this->pdo->query("SELECT * FROM card WHERE groupshop = '".$shop['groupshop']."' and active = 'Активна' and what = 'shops' order by rand() ");
	$card = $card->fetch(PDO::FETCH_ASSOC);
	
	$port = $this->pdo->query("SELECT * FROM card WHERE groupshop = '".$shop['groupshop']."' and active = 'Активна' ");
	$port = $port->fetch(PDO::FETCH_ASSOC);
	
	$summ_verify = $this->pdo->prepare("SELECT * FROM transactions WHERE sum_rub = :sum_rub and status = :status");
	$summ_verify->execute(['sum_rub' => $itog, 'status' => 'Ждём оплату']);

	
	if ($summ_verify->rowCount() > 0) {
	$a = $itog;
	$b = $itog+100;
	$catalog_position = $db->connect()->query("SELECT max(sum_rub) as max FROM transactions WHERE `sum_rub` < '".$b."' AND `sum_rub` >= '".$a."' AND status = 'Ждём оплату'");
	$catalog_position = $catalog_position->fetch(PDO::FETCH_ASSOC);
	$maxid = round($catalog_position['max']+1);
	} else {
	$maxid = round($itog);
	}
	$id_shop=$shop["id"];
	$what=$empData["what"];
	$status=$empData["status"];
	$invoice_date_creat=$empData["invoice_date_creat"];		
	$invoice_get=$maxid;
	$apikey=$empData["apikey"];
	$shop_currency=$empData["shop_currency"];
	$na_chto=$empData["shop_currency"];
	$shop_wallet=$empData["shop_wallet"];
	$card=$card["number"];
	$card_id=$port["id"];
	$port=$port["temp"];
	$date = date("Y-m-d H:i:s");
	$expire = time() + 3600;
	$bank = $empData["bank"];
	$uniq_id = uniqid(time());
	$time = time() + 3600;
	
	$cur = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = 'VISA'");
	$cur = $cur->fetch(PDO::FETCH_ASSOC);
	
	$curs = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$na_chto."'");
	$curs = $curs->fetch(PDO::FETCH_ASSOC);
	
	$shops = $this->pdo->query("SELECT * FROM shop WHERE apikey = '".$empData["apikey"]."' and status = 'Активен' ");
	$shops = $shops->fetch(PDO::FETCH_ASSOC);
	
	$group_shops = $this->pdo->query("SELECT * FROM group_shops WHERE id = '".$shops['groupshop']."'");
	$group_shops = $group_shops->fetch(PDO::FETCH_ASSOC);


	$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Магазины'");
	$coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
	
	$api_key = $coinbase['api_key'];
	$api_secret = $coinbase['api_secret'];
	$time = time();
	$method = "GET";
	$path = '/v2/exchange-rates?currency='.$na_chto.'';
			$sign = base64_encode(hash_hmac("sha256", $time.$method.$path, $api_secret));
			$headers = array(
				"CB-VERSION: 2018-03-30",
				"CB-ACCESS-SIGN: ".$sign,
				"CB-ACCESS-TIMESTAMP: ".$time,
				"CB-ACCESS-KEY: ".$api_key,
				"Content-Type: application/json"
				);
				$ch = curl_init('https://api.coinbase.com'.$path);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$result = curl_exec($ch);
				curl_close($ch);
				$arr = json_decode($result, true);
	   

	$price = $invoice_get;
	$kurs = $arr['data']['rates']['RUB'];
	$itog_bez_proc = $price / $kurs;
	$percent = $group_shops['percent'];
	$itog = $itog_bez_proc - ($itog_bez_proc * ($percent / 100));
	$scheck = number_format($itog, 8, '.', '');
	$scheck_bez_proc = number_format($itog_bez_proc, 8, '.', '');
	$_monthsList = array(
"1"=>"Январь","2"=>"Февраль","3"=>"Март",
"4"=>"Апрель","5"=>"Май", "6"=>"Июнь",
"7"=>"Июль","8"=>"Август","9"=>"Сентябрь",
"10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");

$month = $_monthsList[date("n")];

$days = array( 1 => "Понедельник" , "Вторник" , "Среда" , "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );		
	$empQuery = $this->pdo->prepare("INSERT INTO ".$this->empTable." SET name_shop = :name_shop, chislo = :chislo, month = :month, day = :day, number_day_week = :number_day_week, card_id = :card_id, id_shop = :id_shop, uniq_id = :uniq_id, port = :port, kto = :kto, what = :what, chto = :chto, na_chto = :na_chto, date_create = :date_create, payer_requisites = :payer_requisites, client_requisites = :client_requisites, expire = :expire, sum_rub = :sum_rub, logo_chto = :logo_chto, logo_nachto = :logo_nachto, network_chto = :network_chto, network_nachto = :network_nachto, wallet_client = :wallet_client, percent_referal = :percent_referal, percent_obmen = :percent_obmen, percent_client = :percent_client, groupshop = :groupshop");
				if($empQuery->execute([
				'name_shop' => $shop['name'],
				'chislo' => date("d"),
				'month' => $month,
				'day' => $days[date( "N" )],
				'number_day_week' => date( "N" ),
				/*'original_crypto' => $scheck_bez_proc,
				'sendclient_crypto' => $scheck,*/
				'card_id' => $card_id,
				'id_shop' => $id_shop,
				'uniq_id' => $uniq_id,
				'port' => $port,
				'kto' => 'shop',
				'what' => 'in',
				'chto' => 'VISA',
				'na_chto' => $na_chto,
				'date_create' => time(),
				'payer_requisites' => $card,
				'client_requisites' => $shop_wallet,
				'expire' => $expire,
				'sum_rub' => $invoice_get,
				/* 'sum_crypto' => $scheck, */
				'logo_chto' => $cur['logo'], 
				'logo_nachto' => $curs['logo'], 
				'network_chto' => $cur['network'], 
				'network_nachto' => $curs['network'],
				'wallet_client' => 'На отдельный кошелёк',
				'percent_referal' => $shops['percent_referal'],
				'percent_obmen' => $group_shops['percent'],
				'percent_client' => $shops['percent'],
				'groupshop' => $shops['groupshop']
				])) {
				$idzakaz = $this->pdo->lastInsertId();
				$messgae = "Заказ успешно создан.";
				$status = 'Успех';
				$order = $idzakaz;
				$invoice_date_creat = time();
				$invoice_get = $invoice_get;
				$shop_currency = $shop_currency;
				$shop_wallet = $shop_wallet;
				$card = $card;
				$expire = $expire;
				$uniq_id = $uniq_id;
	} else {
		$messgae = "Ошибка";
		$status = "Ошибка";			
	}
	$empResponse = array(
		'status' => 'Успех',
		'id' => $idzakaz,
		'order' => $uniq_id,
		'date_create' => time(),
		'amount' => $invoice_get,
		'card' => $card,
		'expire' => $expire
	);
	} else {
		$messgae = "Нет свободных карт.";
		$status = "Ошибка";
		$empResponse = array(
		'status' => $status,
		'status_message' => $messgae
	);
	}
	} else {
		$messgae = "Не верный API ключ.";
		$status = "Ошибка";
		$empResponse = array(
		'status' => $status,
		'status_message' => $messgae
	);
	}
	} else {
		$messgae = "Неправильный запрос.";
		$status = "Ошибка";
		$empResponse = array(
		'status' => $status,
		'status_message' => $messgae
	);
	}
	header('Content-Type: application/json');
	echo json_encode($empResponse, JSON_UNESCAPED_UNICODE);
}
function updateEmployee($empData){ 		
	if($empData["id"]) {
		$empName=$empData["empName"];
		$empAge=$empData["empAge"];
		$empSkills=$empData["empSkills"];
		$empAddress=$empData["empAddress"];		
		$empDesignation=$empData["empDesignation"];
		$empQuery="
			UPDATE ".$this->empTable." 
			SET name='".$empName."', age='".$empAge."', skills='".$empSkills."', address='".$empAddress."', designation='".$empDesignation."' 
			WHERE id = '".$empData["id"]."'";
			echo $empQuery;
		if( mysqli_query($this->dbConnect, $empQuery)) {
			$messgae = "Employee updated successfully.";
			$status = 1;			
		} else {
			$messgae = "Employee update failed.";
			$status = 0;			
		}
	} else {
		$messgae = "Invalid request.";
		$status = 0;
	}
	$empResponse = array(
		'status' => $status,
		'status_message' => $messgae
	);
	header('Content-Type: application/json');
	echo json_encode($empResponse);
}
public function deleteEmployee($empId) {		
	if($empId) {			
		$empQuery = "
			DELETE FROM ".$this->empTable." 
			WHERE id = '".$empId."'	ORDER BY id DESC";	
		if( mysqli_query($this->dbConnect, $empQuery)) {
			$messgae = "Employee delete Successfully.";
			$status = 1;			
		} else {
			$messgae = "Employee delete failed.";
			$status = 0;			
		}		
	} else {
		$messgae = "Invalid request.";
		$status = 0;
	}
	$empResponse = array(
		'status' => $status,
		'status_message' => $messgae
	);
	header('Content-Type: application/json');
	echo json_encode($empResponse);	
}
}
?>