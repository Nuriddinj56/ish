<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['id']; //employee ID we are using it to get the employee record
	$username = $request['username']; //get the date of birth from collected data above
	$name = $request['name']; //get the date of birth from collected data above
	$status = $request['status'];
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

	// Set the UPDATE SQL data
	$sql = "UPDATE bots SET username='".$username."', name='".$name."', status='".$status."', token='".$token."' WHERE id='".$id."'";

	// Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  echo "Employee has been updated.";
	} else {
	  echo "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
?>