<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';

$json = array();
$category = $this->pdo->query("SELECT * FROM dle_users WHERE chat LIKE '%".$_GET['query']."%' LIMIT 20");
        while ($rows = $category->fetch()) {
	$json[] = $rows["chat"] . ' - ' . $rows["username"];
}
echo json_encode($json);
?>