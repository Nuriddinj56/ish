<?php

$get_shop = $this->pdo->query("SELECT * FROM `shop` WHERE name = '".$_POST['domain']."' ");
$get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);

$shop = $this->pdo->prepare("SELECT * FROM necrobots WHERE username = :username");
$shop->execute(['username' => $_POST['domain']]);
if ($shop->rowCount() == 0) {
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://reshi.cam/api/asdsadorion.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('domain' => $_POST['domain'],'token' => $_POST['token']),
));

$response = curl_exec($curl);

curl_close($curl);

$params = array('id_shop' => $get_shop['id'], 'username' =>  $_POST['domain'], 'token' => $_POST['token'], 'chat' => $get_shop['chat']);   
$q = $this->pdo->prepare("INSERT INTO `necrobots` (id_shop, username, token, chat) VALUES (:id_shop, :username, :token, :chat)");  
$q->execute($params); 

$data['mess'] = $response;
$data['result'] = "success";
echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
$data['mess'] = 'Такой бот уде есть в базе';
$data['result'] = "error";	
}
