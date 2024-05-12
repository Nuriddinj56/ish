<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['employee_id']; //employee ID we are using it to get the employee record

     $home = $_SERVER['DOCUMENT_ROOT'].'/';
     require_once $home . "classes/Db.php";
     $db = new Db();
     $this->pdo = $db->connect();

	// Set the DELETE SQL data
	$sql = "DELETE FROM card WHERE id='".$id."'";

	// Process the query so that we will save the date of birth
	if ($db->query($sql)) {
	  echo "Employee has been deleted.";
	} else {
	  echo "Error: " . $sql . "<br>" . $db->error;
	}

	// Close the connection after using it
	$db->close();
?>