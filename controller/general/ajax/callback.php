<?php
$inputJSON = file_get_contents('php://input');
$input= json_decode( $inputJSON, TRUE );


$address = $input['data']['address'];

$get_set = $this->pdo->query("SELECT * FROM necro_setting ");
$get_set = $get_set->fetch(PDO::FETCH_ASSOC);
			  
$zakaz = $this->pdo->query("SELECT * FROM transactions WHERE payer_requisites = '".$address."' and accert = '0'");
$zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);

if($zakaz['accert'] == 0){

$address_id = $input['additional_data']['transaction']['id'];
$summ = $input['additional_data']['amount']['amount'];
$hash = $input['additional_data']['hash'];
$currency = $input['additional_data']['amount']['currency'];

$wallet = $this->pdo->query("SELECT * FROM `wallets` WHERE address = '".$address."' ");
$wallet = $wallet->fetch(PDO::FETCH_ASSOC);

$users = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$wallet['chat']."' ");
$users = $users->fetch(PDO::FETCH_ASSOC);

$kurs = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$currency."' ");
$kurs = $kurs->fetch(PDO::FETCH_ASSOC);

$para = $this->pdo->query("SELECT * FROM `currency_para` WHERE currency_in = '".$currency."' ");
$para = $para->fetch(PDO::FETCH_ASSOC);

$token = $get_set['token'];
$mess_zak = $users['mess_zak'];
$mess_zak3 = $users['mess_zak3'];
$message_id = $users['message_id'];


$search_id = $this->pdo->query("SELECT * FROM transactions WHERE payer_requisites = '".$address."' and accert = '0'");
$search_id = $search_id->fetchAll();
if(count($search_id) == 0){
echo 'не найдено';
} else {



        $price = $summ;
		$kurs = $kurs['kurs'];
		$itog_bez_proc = $price * $kurs;
		$percent = $para['percent'];
		$itog = $itog_bez_proc - ($itog_bez_proc * ($percent / 100));
		$scheck = number_format($itog, 2, '.', '');
		$itog_bez_proc = number_format($itog_bez_proc, 2, '.', '');
  

$this->pdo->prepare("UPDATE transactions SET sum_crypto=? WHERE payer_requisites=? and accert = '0' ")->execute(array($summ, $address));
$this->pdo->prepare("UPDATE transactions SET sum_rub=? WHERE payer_requisites=? and accert = '0' ")->execute(array($itog_bez_proc, $address));
$this->pdo->prepare("UPDATE transactions SET out_summ=? WHERE payer_requisites=? and accert = '0' ")->execute(array($scheck, $address));
$this->pdo->prepare("UPDATE transactions SET original_crypto=? WHERE payer_requisites=? and accert = '0' ")->execute(array($summ, $address));

$this->pdo->prepare("UPDATE transactions SET hash=? WHERE payer_requisites=? and accert = '0' ")->execute(array($hash, $address));
$this->pdo->prepare("UPDATE transactions SET status=? WHERE payer_requisites=? and accert = '0' ")->execute(array('Видим оплату', $address));
$this->pdo->prepare("UPDATE transactions SET date_pay=? WHERE payer_requisites=? and accert = '0' ")->execute(array(time(), $address));
$this->pdo->prepare("UPDATE transactions SET id_transaction=? WHERE payer_requisites=? and accert = '0' ")->execute(array($address_id, $address));
$this->pdo->prepare("UPDATE transactions SET accert=? WHERE payer_requisites=? and accert = '0' ")->execute(array('1', $address));
//-----------------------------//
$ch = curl_init();
curl_setopt_array(
$ch,
array(
CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',
CURLOPT_POST => TRUE,
CURLOPT_RETURNTRANSFER => TRUE,
CURLOPT_TIMEOUT => 10,
CURLOPT_POSTFIELDS => array(
'chat_id' => $users['chat'],
'message_id' => $mess_zak,
),
)
);
curl_exec($ch);
//-----------------------------//	
$ch = curl_init();
curl_setopt_array(
$ch,
array(
CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',
CURLOPT_POST => TRUE,
CURLOPT_RETURNTRANSFER => TRUE,
CURLOPT_TIMEOUT => 10,
CURLOPT_POSTFIELDS => array(
'chat_id' => $users['chat'],
'message_id' => $message_id,
),
)
);
curl_exec($ch);
//-----------------------------//	
$ch = curl_init();
curl_setopt_array(
$ch,
array(
CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',
CURLOPT_POST => TRUE,
CURLOPT_RETURNTRANSFER => TRUE,
CURLOPT_TIMEOUT => 10,
CURLOPT_POSTFIELDS => array(
'chat_id' => $users['chat'],
'message_id' => $mess_zak3,
),
)
);
curl_exec($ch);
//-----------------------------//	    
$chh = curl_init();
curl_setopt_array(
$chh,
array(
CURLOPT_URL => 'https://chain.so/api/v2/get_confidence/'.$currency.'/'.$hash.'',
CURLOPT_POST => TRUE,
CURLOPT_RETURNTRANSFER => TRUE,
CURLOPT_TIMEOUT => 10,
CURLOPT_POSTFIELDS => array(
'chat_id' => $users['chat'],
'message_id' => $mess_zak3,
),
)
);
$html = curl_exec($chh);
curl_close($chh);
$jsonString = $html;
$arrays = json_decode($jsonString, true);
	
$text_one = "Ждём подтверждения сети. Хэш транзакции ниже.

<code>".$hash."</code>";

$ch3 = curl_init();
curl_setopt_array(
$ch3,
array(
CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/sendVideo',
CURLOPT_POST => TRUE,
CURLOPT_RETURNTRANSFER => TRUE,
CURLOPT_TIMEOUT => 10,
CURLOPT_POSTFIELDS => array(
'chat_id' => $users['chat'],
'video' => 'http://exorion.biz/assets/time.mp4',
'caption' => $text_one,
'parse_mode' => 'HTML'
),
)
);
$html = curl_exec($ch3);
curl_close($ch3);
$jsonString = $html;
$array = json_decode($jsonString, true);
$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=? ")->execute(array($array['result']['message_id'], $users['chat']));

$text3 = "
┌ Номер заказа: #<b>".$users['zakaz_number']."</b>
├ Статус заявки: <b>".$zakaz['status']."</b>
├ Сумма ".$currency." в ожидании: <b>".$summ."</b>
└ Количество подтверждений: <b>".$arrays["data"]['confirmations']."</b> из <b>3</b>.
===========
Просьба, спокойно дожидаться Вашего обмена, ничего не тыкая и не отправляя боту, всё пройдёт автоматически, Вы получите все уведомления.
";
$ch4 = curl_init();
curl_setopt_array(
$ch4,
array(
CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/sendMessage',
CURLOPT_POST => TRUE,
CURLOPT_RETURNTRANSFER => TRUE,
CURLOPT_TIMEOUT => 10,
CURLOPT_POSTFIELDS => array(
'chat_id' => $users['chat'],
'text' => $text3,
'parse_mode' => 'HTML'
),
)
);
$html = curl_exec($ch4);
curl_close($ch4);
$jsonString = $html;
$arrays = json_decode($jsonString, true);
$this->pdo->prepare("UPDATE dle_users SET mess_zak4=? WHERE chat=? ")->execute(array($arrays['result']['message_id'], $users['chat']));
}
}