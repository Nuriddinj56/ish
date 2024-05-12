<?php
	$request = $_REQUEST;
    $number = $request['number'];
	$temp = $request['temp'];
	$name = $request['name'];
	$what = $request['what'];
	$limitpay = $request['limitpay'];
	$groupshop = $request['groupshop'];
	$bank = $request['bank'];
	$logo_card = $request['logo_card'];
	$active = $request['active'];
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
	} else {
	$what = 'clients';	
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
	  echo "Карта успешно добавлена.";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	$mysqli->close();
?>