<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';

$json = array();
$category = $this->pdo->query("SELECT * FROM shop WHERE name LIKE '%".$_GET['query']."%' LIMIT 20");
        while ($rows = $category->fetch()) {
	$json[] = $rows["name"];
}
echo json_encode($json);
?>