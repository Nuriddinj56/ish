<?php

	$request = $_REQUEST;
    $name = $request['name'];
    $api_secret = $request['api_secret'];
	$api_key = $request['api_key'];
	$what = $request['what'];
	$active = '0';
	$groupshop = $request['groupshop'];
if (empty($name)){
$data['result'] = "error";
$data['mess'] = "Вы не указали название";
} elseif (empty($api_secret)){
$data['result'] = "error";
$data['mess'] = "Вы не указали секрет";
} elseif (empty($api_key)){
$data['result'] = "error";
$data['mess'] = "Вы не указали ключ";
} elseif (empty($groupshop)){
$data['result'] = "error";
$data['mess'] = "Вы не выбрали категорию магазинов";
} else {
	
$API_KEY = $api_key;
$API_SECRET = $api_secret;  
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

if ($arr['errors'][0]['id'] == ''){	
	
	$servername = "localhost";
	$username = "orion";
	$password = "пароль от бд";
	$dbname = "orion"; 

	$mysqli = new mysqli($servername, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}

	$sql = "INSERT INTO exchanges (name, api_secret, api_key)
	VALUES ('".$name."', '".$api_secret."', '".$api_key."')";
	
	$text = 'Добавил новую биржу: <b>'.$name.'</b>';
	$sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'save')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Биржа успешно добавлена.";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	$mysqli->close();
	} else {
	$data['result'] = "error";
    $data['mess'] = "Ошибка, ключ или секрет неверные, проверьте ещё раз.";	
}
	}
	echo json_encode($data);
?>