<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$this->pdo->prepare("UPDATE shop SET oborot=?")->execute(array(0));