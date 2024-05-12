<?php

	$request = $_REQUEST;
    $chat = $request['chat'];
	$user_id = $request['user_id'];
	$percent = $request['percent'];
	$name = $request['name'];
	$groupshop = $request['groupshop'];
	$vivod = $request['vivod'];
	$apikey = $request['apikey'];
if (empty($request['percent_referal'])){
$percent_referal = '0';
} else {
$percent_referal = $request['percent_referal'];
}	
if (empty($request['referal'])){
$referal = 'Не указан';
} else {
$referal = $request['referal'];
}
if (empty($name)){
$data['result'] = "error";
$data['mess'] = "Вы не указали название магазина";
} elseif (empty($chat)){
$data['result'] = "error";
$data['mess'] = "Вы не указали CHAT-ID админа";
} elseif (empty($groupshop)){
$data['result'] = "error";
$data['mess'] = "Вы не выбрали категорию магазина";
} elseif (empty($vivod)){
$data['result'] = "error";
$data['mess'] = "Вы не выбрали способ выплаты";
} elseif (empty($apikey)){
$data['result'] = "error";
$data['mess'] = "Вы не сгенерировали API ключ";
} else {
	

	$servername = "localhost";
	$username = "orion";
	$password = "пароль от бд";
	$dbname = "orion"; 

	$mysqli = new mysqli($servername, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}

	$sql = "INSERT INTO shop (chat, percent, name, percent_referal, referal, groupshop, vivod, apikey, createdate)
	VALUES ('".$chat."', '".$percent."', '".$name."', '".$percent_referal."', '".$referal."', '".$groupshop."', '".$vivod."', '".$apikey."', '".time()."')";
	
	$text = 'Добавил новый магазин: <b>'.$name.'</b>';
	$sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'save')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Магазин успешно добавлен.";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	$mysqli->close();
	}
	echo json_encode($data);
?>