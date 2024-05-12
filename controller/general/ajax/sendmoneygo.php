<?php
 $currency = $_POST["bircurrencys"];
 $exchange = $_POST["biracc"];
 $adress_bir = $_POST["adress_bir"];
 $summbir = $_POST["summbir"];
 $pometkabir = $_POST["pometkabir"];
 
 $coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$exchange."'");
 $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);

 $cur = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$currency."' ");
 $cur = $cur->fetch(PDO::FETCH_ASSOC);
 
if($currency == 'BTC'){
	$user_id = $coinbase['btc_id'];
} elseif($currency == 'LTC'){
    $user_id = $coinbase['ltc_id'];
} elseif($currency == 'ETH'){
	$user_id = $coinbase['eth_id'];
} elseif($currency == 'USDT'){
	$user_id = $coinbase['usdt_id'];
}



    $API_KEY = $coinbase['api_key'];
	$API_SECRET = $coinbase['api_secret'];  
	$USER_ID = $user_id;
	$timestamp = time();
	$method = "POST";
	$path = '/v2/accounts/' . $USER_ID . '/transactions';
	$body = json_encode(array(
	 'type' => 'send',
	 'to' => $adress_bir,
	 'amount' => $summbir,
	 'currency' => $currency
	));
	$message = $timestamp . $method . $path . $body;
	$signature = hash_hmac('SHA256', $message, $API_SECRET);
	$version = '2021-01-11';
	$headers = array(
	'CB-ACCESS-SIGN: ' . $signature,
	'CB-ACCESS-TIMESTAMP: ' . $timestamp,
	'CB-ACCESS-KEY: ' . $API_KEY,
	'CB-VERSION: ' . $version,
	'Content-Type: application/json'
	);
	$api_url = "https://api.coinbase.com" . $path;
	$curl = curl_init($api_url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
	$resp = curl_exec($curl);
	curl_close($curl);
	$arr = json_decode($resp, true);	
	if($arr['data'] == ''){
	?>
	<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> <? echo $arr['errors'][0]['message'];?></div>
	<?	
		
	} else {
		$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arr['data']['resource_path']);
	$str = preg_replace('/  */', ' ', $str);
	$str = preg_replace('/\\s+/', ' ', $str);
	$array = explode(' ', $str);
	$params = array('what' => $pometkabir, 'date' => $arr['data']["created_at"], 'id_transaction' => $arr['data']['id'], 'address' => $arr['data']["to"]["address"], 'title' => $arr['data']['details']['title'], 'header' => $arr['data']['details']['header'], 'type' => $arr['data']["type"], 'status' => $arr['data']["status"], 'amount' => $arr['data']['amount']['amount'], 'native_amount' => $arr['data']['native_amount']['amount'], 'currency' => $arr['data']['amount']['currency'], 'native_curency' => $arr['data']['native_amount']['currency'], 'hash' => $arr['data']['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr['data']['network']['hash'], 'id_account' => $array[3] );   
	$q = $this->pdo->prepare("INSERT INTO `transactions_out` (what, date, id_transaction, address, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:what, :date, :id_transaction, :address, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	$q->execute($params);
	?>
	<div class="alert alert-light-success border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Успех!</strong> Средства успешно отправлены. </div>
	<?
	}


