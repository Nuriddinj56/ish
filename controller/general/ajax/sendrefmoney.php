<?php
 $zayavka = $_POST["hid"];
 $statusref = $_POST["statusref"];
 $exchange = $_POST["exchange"];
 $zayavka_in = $_POST["zayavka_in"];
 $currencys = $_POST["currencys"];
 $adress_ref = $_POST["adress_ref"];
 $summ = $_POST["summ"];
if (empty($exchange)){
?>
<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> Не выбран аккаунт биржи.</div>
<?
} elseif (empty($zayavka_in)){
?>
<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> Не выбран способ выплаты.</div>
<?
} elseif (empty($currencys)){
?>
<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> Не выбрана валюта.</div>
<?
} elseif (empty($adress_ref)){
?>
<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> Не указан адресс кошелька.</div>
<?
} elseif (empty($summ)){
?>
<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> Не указан адресс кошелька.</div>
<?
} else {
	
$zayavkas = $this->pdo->query("SELECT * FROM conclusion_referals WHERE id = '".$zayavkas."'");
$zayavkas = $zayavkas->fetch(PDO::FETCH_ASSOC);


$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$exchange."'");
$coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);


if ($coinbase['what'] == 'Клиенты' ){
$cur = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$currencys."' ");
$cur = $cur->fetch(PDO::FETCH_ASSOC);
} else {
$cur = $this->pdo->query("SELECT * FROM `currency_api` WHERE nominal = '".$currencys."' ");
$cur = $cur->fetch(PDO::FETCH_ASSOC);
}

if ($zayavka_in == 'shops' ){
    $API_KEY = $coinbase['api_key'];
	$API_SECRET = $coinbase['api_secret'];  
	$USER_ID = $cur['user_id'];
	$timestamp = time();
	$method = "POST";
	$path = '/v2/accounts/' . $USER_ID . '/transactions';
	$body = json_encode(array(
	 'type' => 'send',
	 'to' => $adress_ref,
	 'amount' => $summ,
	 'currency' => $currencys
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
		echo $cur['user_id'];
	?>
	<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> <? echo $arr['errors'][0]['message'];?></div>
	<?	
		
	} else {
	?>	
	<div class="alert alert-light-success border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Успех!</strong> Средства успешно отправлены. </div>
	<?
	}
} else {
	
	
    $API_KEY = $coinbase['api_key'];
	$API_SECRET = $coinbase['api_secret'];  
	$USER_ID = $cur['user_id'];
	$timestamp = time();
	$method = "POST";
	$path = '/v2/accounts/' . $USER_ID . '/transactions';
	$body = json_encode(array(
	 'type' => 'send',
	 'to' => $zayavkas['requisites'],
	 'amount' => $zayavkas['sum_crypto'],
	 'currency' => $zayavkas['currency']
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
		echo 'asasaas';
	?>
	<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Ошибка!</strong> <? echo $arr['errors'][0]['message'];?></div>
	<?	
		
	} else {
	?>	
	<div class="alert alert-light-success border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Успех!</strong> Средства успешно отправлены. </div>
	<?
	}	
	
}

}