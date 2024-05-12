<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['id']; //employee ID we are using it to get the employee record
    $name = $request['name'];
    $api_secret = $request['api_secret'];
	$api_key = $request['api_key'];
	$what = $request['what'];
	
if (empty($name)){
$data['result'] = "error";
$data['mess'] = "Вы не указали название";
} elseif (empty($api_secret)){
$data['result'] = "error";
$data['mess'] = "Вы не указали секрет";
} elseif (empty($api_key)){
$data['result'] = "error";
$data['mess'] = "Вы не указали ключ";
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

	// Set the UPDATE SQL data
	$sql = "UPDATE exchanges SET name='".$name."', api_secret='".$api_secret."', api_key='".$api_key."', what='".$what."' WHERE id='".$id."'";
    
	$text = 'Изменил настройки биржи: <b>'.$name.'</b>';
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
      $data['mess'] = "Биржа успешно сохранена.";
	} else {
		$data['result'] = "error";
        $data['mess'] = "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
}
echo json_encode($data);
?>