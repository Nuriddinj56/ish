<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['id']; //employee ID we are using it to get the employee record
	$number = $request['number']; //get the date of birth from collected data above
	$temp = $request['temp']; //get the date of birth from collected data above
	$name = $request['name'];
	$user_id = $request['userid'];
	$what = $request['what'];
	$limitpay = $request['limitpay'];
	$bank = $request['bank'];
	$logo_card = $request['logo_card'];
	$active = 'Активна';
	if($request['what'] == 'clients') {
	$groupshop = '0';
	} else {
	$groupshop = $request['groupshop'];
	}
	if(empty($request['drop_name'])) {
	$drop_name = 'NULL';
	} else {
	$drop_name = $request['drop_name'];	
	}
	if(empty($request['drop_tel'])) {
	$drop_tel = 'NULL';
	} else {
	$drop_tel = $request['drop_tel'];	
	}
	if(empty($request['drop_contact'])) {
	$drop_contact = 'NULL';
	} else {
	$drop_contact = $request['drop_contact'];	
	}
	if(empty($request['zametka'])) {
	$zametka = 'NULL';
	} else {
	$zametka = $request['zametka'];	
	}

	$servername = "localhost"; //set the servername
	$username = "orion"; //set the server username
	$password = "пароль от бд"; // set the server password (you must put password here if your using live server)
	$dbname = "orion"; // set the table name

	$mysqli = new mysqli($servername, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}

	// Set the UPDATE SQL data
	$sql = "UPDATE card SET number='".$number."', temp='".$temp."', name='".$name."', limitpay='".$limitpay."', what='".$what."', groupshop='".$groupshop."', bank='".$bank."', logo_card='".$logo_card."', active='".$active."', drop_name='".$drop_name."', drop_tel='".$drop_tel."', drop_contact='".$drop_contact."', zametka='".$zametka."' WHERE id='".$id."'";

	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  echo "Карта успешно сохранена.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
	
	$text = 'Изменил настройки карты: <b>'.$number.'</b>';
	$sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'save')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
?>