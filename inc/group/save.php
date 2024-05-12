<?php
	$request = $_REQUEST;
	$percent = $request['percent'];
	$name = $request['name'];

	
if (empty($name)){
$data['result'] = "error";
$data['mess'] = "Вы не указали название категории";
} elseif (empty($percent)){
$data['result'] = "error";
$data['mess'] = "Вы не указали процент";
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

	$sql = "INSERT INTO group_shops (percent, name, active, replace_card)
	VALUES ('".$percent."', '".$name."', 'Активна', 'Работает')";

	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Категория успешно добавлена.";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	$mysqli->close();
	}
	echo json_encode($data);
?>