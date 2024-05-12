<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';

$this->pdo->query("DELETE FROM smstemp WHERE id = '".$_GET['id']."' ");
?>