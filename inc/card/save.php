<?php
	$request = $_REQUEST;
    $number = $request['number'];
	$user_id = $request['user_id'];
	$temp = $request['temp'];
	$name = $request['name'];
	$limitpay = $request['limitpay'];
	$active = $request['active'];
	
	if(empty($temp)) {
	 $data['result'] = "error";
     $data['mess'] = "Вы не выбрали шаблон.";	
	} elseif(empty($number)) {
	 $data['result'] = "error";
     $data['mess'] = "Вы не указали номер карты";	
	} elseif(empty($name)) {
	 $data['result'] = "error";
     $data['mess'] = "Вы не указали название карты";	
	} elseif(empty($limitpay)) {
	 $data['result'] = "error";
     $data['mess'] = "Вы не указали лимит карты";	
	} else {
		
if(empty($request['drop_name'])) {
	$drop_name = 'Не указан';
	} else {
	$drop_name = $request['drop_name'];	
	}
	if(empty($request['drop_tel'])) {
	$drop_tel = 'Не указан';
	} else {
	$drop_tel = $request['drop_tel'];	
	}
	if(empty($request['drop_contact'])) {
	$drop_contact = 'Не указан';
	} else {
	$drop_contact = $request['drop_contact'];	
	}
	if(empty($request['zametka'])) {
	$zametka = 'Не указана';
	} else {
	$zametka = $request['zametka'];	
	}
	if($request['what'] == 'shopss') {
	$what = 'shops';
	$groupshop = $request['groupshop'];
	} else {
	$what = 'clients';
	$groupshop = 0;
	}
	
	if($request['logo_card'] == '/images/') {
	$logo_card = '/images/nologo.png';	
	} else {
	$logo_card = $request['logo_card'];		
	}
	
	if (empty($request['bank'])){
	$bank = $request['name'];
	} else {
	$bank = $request['bank'];	
	}
	
	$servername = "localhost";
	$username = "orion";
	$password = "пароль от бд";
	$dbname = "orion"; 

	$mysqli = new mysqli($servername, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}

	$sql = "INSERT INTO card (number, temp, name, limitpay, what, groupshop, bank, logo_card)
	VALUES ('".$number."', '".$temp."', '".$name."', '".$limitpay."', '".$what."', '".$groupshop."', '".$bank."', '".$logo_card."')";

	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Карта успешно добавлена.";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}
	
	$text = 'Добавил новую карту: <b>'.$number.'</b>';
    $sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'save')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	$mysqli->close();
	}
	echo json_encode($data);
?>