<?php
	$conn=mysqli_connect("localhost", "orion", "пароль от бд", "orion");
	
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
?>