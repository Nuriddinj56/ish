<?php
	$request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
	$id = $request['id']; //employee ID we are using it to get the employee record
	$sum_rub = $request['sum_rub']; //get the date of birth from collected data above
	$sendclient_crypto = $request['sendclient_crypto']; //get the date of birth from collected data above
	$status = $request['status'];
	$status_payclient = $request['status_payclient'];

if (empty($sum_rub)){
$data['result'] = "error";
$data['mess'] = "Вы не указали сумму в рублях";
} elseif (empty($sendclient_crypto)){
$data['result'] = "error";
$data['mess'] = "Вы не указали сумму в крипте";
} elseif (empty($status)){
$data['result'] = "error";
$data['mess'] = "Вы не выбрали статус выплаты";
} elseif (empty($status_payclient)){
$data['result'] = "error";
$data['mess'] = "Вы не выбрали статус оплаты";
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
	$sql = "UPDATE transactions SET sum_rub='".$sum_rub."', sendclient_crypto='".$sendclient_crypto."', status='".$status."', status_payclient='".$status_payclient."' WHERE id='".$id."'";

    // Process the query so that we will save the date of birth
	if ($mysqli->query($sql)) {
	  $data['result'] = "success";
      $data['mess'] = "Транзакция успешно сохранёна.";
	} else {
		$data['result'] = "error";
        $data['mess'] = "Error: " . $sql . "<br>" . $mysqli->error;
	}

	// Close the connection after using it
	$mysqli->close();
}
echo json_encode($data);

?>