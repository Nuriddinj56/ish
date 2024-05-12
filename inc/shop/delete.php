<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['employee_id']; //employee ID we are using it to get the employee record
    $user_id = $_GET['user_id'];
	$servername = "localhost"; //set the servername
	$username = "orion"; //set the server username
	$password = "пароль от бд"; // set the server password (you must put password here if your using live server)
	$dbname = "orion"; // set the table name

	$mysqli = new mysqli($servername, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
	  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	  exit();
	}

	// Set the DELETE SQL data
	$sql = "DELETE FROM shop WHERE id='".$id."'";

	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  echo "<font color='#fff'>Магазин успешно удален</font>.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
	
	$text = 'Удалил магазин с ID: <b>'.$id.'</b>';
	$sqls = "INSERT INTO activity_admin (user_id, text, date, action)
	VALUES ('".$user_id."', '".$text."', '".time()."', 'delete')";
	if ($mysqli->query($sqls)) {
	  $data['result'] = "success";
	} else {
	  return "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
?>