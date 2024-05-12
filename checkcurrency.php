<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/PDO.php";

$coinbase = $pdo->query("SELECT * FROM exchanges WHERE what = 'Магазины' and active = '1'");
$coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);

$API_KEY = $coinbase['api_key'];
$API_SECRET = $coinbase['api_secret'];
$timestamp = time();
$method = "GET";
$path = '/v2/accounts';

$message = $timestamp . $method . $path;
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

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
$arr = json_decode($html, true);

foreach ($arr['data'] as $arrs) {
    $search_id = $pdo->query("SELECT * FROM currency_in WHERE nominal = '".$arrs["currency"]["code"]."'");
    $search_id = $search_id->fetchAll();
	if(count($search_id) == 0){
	$params = array('nominal' => $arrs["currency"]["code"], 'logo' => 'https://loutre.blockchair.io/assets/svg/chains/'.$arrs["currency"]["slug"].'.svg', 'kurs' => '0', 'kurs_usd' => '0', 'user_id' => $arrs["id"], 'network' => $arrs["currency"]["slug"]);   
	$q = $pdo->prepare("INSERT INTO `currency_api` (nominal, logo, kurs, kurs_usd, user_id, network) VALUES (:nominal, :logo, :kurs, :kurs_usd, :user_id, :network)");  
	$q->execute($params);
	}
	 
	}
	
	
	echo $html;