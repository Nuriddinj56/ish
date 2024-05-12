<?php
$res_data = $this->pdo->query("SELECT * FROM exchanges");
while ($coinbase = $res_data->fetch()) {
$coin = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$coinbase['id']."'");
$coin = $coin->fetch(PDO::FETCH_ASSOC);




$API_KEY = $coinbase['api_key'];
$API_SECRET = $coinbase['api_secret'];
$USER_ID = $coinbase['btc_id'];
$timestamp = time();
$method = "GET";
$path = '/v2/accounts/' . $USER_ID;

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

echo $arr['data']['balance']['amount'];
$this->pdo->prepare("UPDATE exchanges SET balance_btc=? WHERE id = ".$coin['id']."")->execute(array($arr['data']['balance']['amount']));

}


//Баланс LTC


$res_data = $this->pdo->query("SELECT * FROM exchanges");
while ($coinbase = $res_data->fetch()) {
$coin = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$coinbase['id']."'");
$coin = $coin->fetch(PDO::FETCH_ASSOC);




$API_KEY = $coinbase['api_key'];
$API_SECRET = $coinbase['api_secret'];
$USER_ID = $coinbase['ltc_id'];
$timestamp = time();
$method = "GET";
$path = '/v2/accounts/' . $USER_ID;

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
$this->pdo->prepare("UPDATE exchanges SET balance_ltc=? WHERE id = ".$coin['id']."")->execute(array($arr['data']['balance']['amount']));
echo $arr['data']['balance']['amount'];
}


//Баланс ETH


$res_data = $this->pdo->query("SELECT * FROM exchanges");
while ($coinbase = $res_data->fetch()) {
$coin = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$coinbase['id']."'");
$coin = $coin->fetch(PDO::FETCH_ASSOC);




$API_KEY = $coinbase['api_key'];
$API_SECRET = $coinbase['api_secret'];
$USER_ID = $coinbase['eth_id'];
$timestamp = time();
$method = "GET";
$path = '/v2/accounts/' . $USER_ID;

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
$this->pdo->prepare("UPDATE exchanges SET balance_eth=? WHERE id = ".$coin['id']."")->execute(array($arr['data']['balance']['amount']));
echo $arr['data']['balance']['amount'];
}


//Баланс USDT


$res_data = $this->pdo->query("SELECT * FROM exchanges");
while ($coinbase = $res_data->fetch()) {
$coin = $this->pdo->query("SELECT * FROM exchanges WHERE id = '".$coinbase['id']."'");
$coin = $coin->fetch(PDO::FETCH_ASSOC);




$API_KEY = $coinbase['api_key'];
$API_SECRET = $coinbase['api_secret'];
$USER_ID = $coinbase['usdt_id'];
$timestamp = time();
$method = "GET";
$path = '/v2/accounts/' . $USER_ID;

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
$this->pdo->prepare("UPDATE exchanges SET balance_usdt=? WHERE id = ".$coin['id']."")->execute(array($arr['data']['balance']['amount']));
echo $arr['data']['balance']['amount'];
}