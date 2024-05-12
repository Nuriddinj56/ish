<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$username = $request['username']; //get the date of birth from collected data above
	$name = $request['name']; //get the date of birth from collected data above
	$status = 'Активирован';
	$token = $request['token'];

	$servername = "localhost"; //set the servername
	$username = "orion"; //set the server username
	$password = "пароль от бд"; // set the server password (you must put password here if your using live server)
	$dbname = "orion"; // set the table name

	$mysqli = new mysqli($servername, $username, $password, $dbname);
			if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}
$ch = curl_init('https://api.telegram.org/bot'.$token.'/GetMe');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			if($array['ok'] == true){
				
				

	// Set the INSERT SQL data
	$sql = "INSERT INTO bots (username, name, status, token)
	VALUES ('".$array['result']['username']."', '".$array['result']['first_name']."', '".$status."', '".$token."')";
      	
			} else {
			$data['result'] = "error";
			$data['mess'] = "Не верный токен, выпустите новый.";
			}

	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  $id = $mysqli->insert_id;
			$chs = curl_init("https://api.telegram.org/bot".$token."/setwebhook?url=https://exorion.biz/bot/".$id."/");
			curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($chs, CURLOPT_HEADER, false);
			$htmls = curl_exec($chs);
			curl_close($chs);
			$jsonStrings = $htmls;
			$arrays = json_decode($jsonStrings, true);
	              if($arrays['ok'] == true){
			 $data['mess'] = "Настройки сохранены, бот активирован.";
			 $data['result'] = "success";
			} else {
			$data['mess'] = "Не верный токен";
			 $data['result'] = "error";
			}
	} else {
    $data['mess'] = "Не верный токен";
	$data['result'] = "error";
	}

	// Close the connection after using it
	$mysqli->close();

echo json_encode($data);	
?>