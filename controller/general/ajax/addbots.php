<?php
function clear_data($val){
    $val = trim($val);
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);
    return $val;
}

$pattern_name = '^(http|https):\/\/cs[0-9]+\.[a-zA-Z0-9]+\.me\/[^.]+';
$err = [];
$flag = 0;
 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
$ch = curl_init('https://api.telegram.org/bot'.$_POST['token'].'/GetMe');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			
$params = array('name' => $array['result']['first_name'], 'username' => $array['result']['username'], 'token' => $_POST['token']);   
$q = $this->pdo->prepare("INSERT INTO `bots` (name, username, token) VALUES (:name, :username, :token)");  
$q->execute($params); 
			$id = $this->pdo->lastInsertId();
			$chs = curl_init("https://api.telegram.org/bot".$_POST['token']."/setwebhook?url=https://exorion.biz/bot/".$id."/");
			curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($chs, CURLOPT_HEADER, false);
			$htmls = curl_exec($chs);
			curl_close($chs);
			$jsonStrings = $htmls;
			$arrays = json_decode($jsonStrings, true);
            if($arrays['ok'] == true){
			 $data['mess'] = "Настройки сохранены, бот активирован.";
			 $data['result'] = "success";
			}
}				
echo json_encode($data, JSON_UNESCAPED_UNICODE);
