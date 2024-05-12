<?php
$res_data = $this->pdo->query("SELECT * FROM exchanges WHERE btc_id is null");
while ($coinbase = $res_data->fetch()) {
$coin = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$coinbase['id']."'");
$coin = $coin->fetch(PDO::FETCH_ASSOC);
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

    $this->pdo->prepare("UPDATE exchanges SET BTC=? WHERE id = ".$coin['id']."")->execute(array($arrs['id']));
if($arrs['currency']['code'] == 'BTC'){
	
	$this->pdo->prepare("UPDATE exchanges SET btc_id=? WHERE id = ".$coin['id']."")->execute(array($arrs['id']));

} elseif($arrs['currency']['code'] == 'LTC'){
	
	$this->pdo->prepare("UPDATE exchanges SET ltc_id=? WHERE id = ".$coin['id']."")->execute(array($arrs['id']));
} elseif($arrs['currency']['code'] == 'ETH'){

	$this->pdo->prepare("UPDATE exchanges SET ETH_id=? WHERE id = ".$coin['id']."")->execute(array($arrs['id']));
} elseif($arrs['currency']['code'] == 'USDT'){

	$this->pdo->prepare("UPDATE exchanges SET usdt_id=? WHERE id = ".$coin['id']."")->execute(array($arrs['id']));
	
}
	 
	}
}