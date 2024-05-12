<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['id']; //employee ID we are using it to get the employee record
    $chat = $request['chat'];
    $user_id = $request['userid'];
	$percent = $request['percent'];
	$name = $request['name'];
	$groupshop = $request['groupshop'];
	$vivod = $request['vivod'];
	$apikey = $request['apikey'];
	$token = $request['token'];
	
	
if (empty($request['pay_referal'])){
$pay_referal = 'Обменник';
} else {
$pay_referal = $request['pay_referal'];
}		
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
	
	
	
	$servername = "localhost"; //set the servername
	$username = "orion"; //set the server username
	$password = "пароль от бд"; // set the server password (you must put password here if your using live server)
	$dbname = "orion"; // set the table name

	$mysqli = new mysqli($servername, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}
if (!empty($token)){
$ch = curl_init('https://api.telegram.org/bot'.$token.'/GetMe');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			if($array['ok'] == false){
			$data['result'] = "error";
			$data['mess'] = "Ошибка бота, попробуйте другой токен";	
			} elseif($array['ok'] == true){
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://reshi.cam/api/asdsadorionupdate.php',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => array('domain' => $array['result']['username'],'token' => $token, 'id_apishop' => $id),
				));
				$response = curl_exec($curl);
				curl_close($curl);
				// Set the UPDATE SQL data
	$sql = "UPDATE shop SET chat='".$chat."', percent='".$percent."', name='".$name."', referal='".$referal."', percent_referal='".$percent_referal."', groupshop='".$groupshop."', vivod='".$vivod."', apikey='".$apikey."', pay_referal='".$pay_referal."', token='".$token."', username='".$array['result']['username']."' WHERE id='".$id."'";
    
	$text = 'Изменил настройки магазина: <b>'.$name.'</b>';
	$sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'edit')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}
	
	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Магазин успешно сохранён. Бот успешно активирован";
	} else {
		$data['result'] = "error";
        $data['mess'] = "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
			}
	
  } else {
	  
	// Set the UPDATE SQL data
	$sql = "UPDATE shop SET chat='".$chat."', percent='".$percent."', name='".$name."', referal='".$referal."', percent_referal='".$percent_referal."', groupshop='".$groupshop."', vivod='".$vivod."', apikey='".$apikey."', pay_referal='".$pay_referal."' WHERE id='".$id."'";
    
	$text = 'Изменил настройки магазина: <b>'.$name.'</b>';
	$sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'edit')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}
	
	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Магазин успешно сохранён.";
	} else {
		$data['result'] = "error";
        $data['mess'] = "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();  
	  
  }
}
echo json_encode($data);
?>