<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/PDO.php";
$pdo->query("DELETE FROM bots WHERE id = '".$_GET['id']."' ");
?>