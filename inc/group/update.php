<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['id']; //employee ID we are using it to get the employee record
	$percent = $request['percent'];
	$name = $request['name'];

	
if (empty($name)){
$data['result'] = "error";
$data['mess'] = "Вы не указали название категории";
} elseif (empty($percent)){
$data['result'] = "error";
$data['mess'] = "Вы не указали процент";
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
	$sql = "UPDATE group_shops SET percent='".$percent."', name='".$name."' WHERE id='".$id."'";

	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Категория успешно сохранёна.";
	} else {
		$data['result'] = "error";
        $data['mess'] = "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
}
echo json_encode($data);
?>