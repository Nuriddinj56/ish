<?php

$search = $_POST["referal"];
if (isset($_POST["type"])) {
    if ($_POST["type"] == "userDatas") {
		$category = $this->pdo->query("SELECT * FROM dle_users WHERE chat LIKE '{$search}%' OR username LIKE '{$search}%' ORDER BY id ASC");
		while ($row = $category->fetch()) {
            $output[] = [
                'id' => $row["chat"],
                'name' => $row["username"],
				'chat' => $row["chat"],
            ];
        }
        echo json_encode($output); 
    }
}
  
?>