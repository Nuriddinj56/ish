<?php


		      $category = $this->pdo->query("SELECT * FROM transactions WHERE status = 'Видим оплату' and accert = '1'");
		      while ($zakaz = $category->fetch()) {
			  $get_set = $this->pdo->query("SELECT * FROM bots WHERE id = '".$zakaz['id_bot']."' ");
			  $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
			  //=============Ищем пользователя заявки=======//
			  $wallet = $this->pdo->query("SELECT * FROM `wallets` WHERE address = '".$zakaz['payer_requisites']."' ");
			  $wallet = $wallet->fetch(PDO::FETCH_ASSOC);
			  //=============Ищем пользователя заявки конец=======//
			  $cur = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$zakaz['chto']."' ");
			  $cur = $cur->fetch(PDO::FETCH_ASSOC);
			   //=============Ищем пользователя заявки=======//
			  $users = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$wallet['chat']."' ");
			  $users = $users->fetch(PDO::FETCH_ASSOC);
			  //=============Ищем пользователя заявки конец=======//
			  
			   $coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE active = '1' and what = 'Клиенты'");
               $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
			   $currency = $zakaz['chto'];
if($currency == 'BTC'){
	$user_id = $coinbase['btc_id'];
} elseif($currency == 'LTC'){
    $user_id = $coinbase['ltc_id'];
} elseif($currency == 'ETH'){
	$user_id = $coinbase['eth_id'];
} elseif($currency == 'USDT'){
	$user_id = $coinbase['usdt_id'];
}  
    $search_zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = '".$zakaz['id']."' and accert = '1' ");
    $search_zakaz = $search_zakaz->fetchAll();
	if(count($search_zakaz) == 0){
		echo 'Мимо';
	} else {
$token = $get_set['token'];
$API_KEY = $coinbase['api_key'];
$API_SECRET = $coinbase['api_secret'];  
$USER_ID = $user_id;  
$timestamp = time();
$method = "GET";
$path = '/v2/accounts/'.$USER_ID.'/transactions/'.$zakaz['id_transaction'].'';


$message = $timestamp . $method . $path;
$signature = hash_hmac('SHA256', $message, $API_SECRET);
$version = '2021-01-11';

$headers = array(
    'CB-ACCESS-SIGN: ' . $signature,
    'CB-ACCESS-TIMESTAMP: ' . $timestamp,
    'CB-ACCESS-KEY: ' . $API_KEY,
    'CB-VERSION: ' . $version,
    'Content-Type: application/json'
);

$api_url = "https://api.coinbase.com" . $path;

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
$arr = json_decode($html, true);
echo $arr["data"]['network']["status"];

$hash = $arr["data"]['network']['hash'];
$currency = $arr["data"]['amount']["currency"];


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
     
    $search_id = $this->pdo->query("SELECT * FROM transactions_crypto WHERE id_transaction = '".$arr["data"]["id"]."'");
    $search_id = $search_id->fetchAll();
	if(count($search_id) == 0){
		
	$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arr["data"]['resource_path']);
	$str = preg_replace('/  */', ' ', $str);
	$str = preg_replace('/\\s+/', ' ', $str);
	$array = explode(' ', $str);
		
	$params = array('uniq_zakaz' => $zakaz['uniq_id'], 'id_zakaz' => $zakaz['id'], 'date' => $arr['data']["created_at"], 'id_transaction' => $arr["data"]["id"], 'title' => $arr["data"]['details']['title'], 'header' => $arr["data"]['details']['header'], 'type' => $arr["data"]["type"], 'status' => $arr["data"]["status"], 'amount' => $arr["data"]['amount']['amount'], 'native_amount' => $arr["data"]['native_amount']['amount'], 'currency' => $arr["data"]['amount']['currency'], 'native_curency' => $arr["data"]['native_amount']['currency'], 'hash' => $arr["data"]['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr["data"]['network']['hash'], 'id_account' => $array[3]);   
	$q = $this->pdo->prepare("INSERT INTO `transactions_crypto` (uniq_zakaz, id_zakaz, date, id_transaction, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:uniq_zakaz, :id_zakaz, :date, :id_transaction, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	$q->execute($params);
	
	$this->pdo->prepare("UPDATE transactions SET sum_rub_orig=? WHERE id = '".$zakaz['id']."' ")->execute(array($arr["data"]['native_amount']['amount']));
	$this->pdo->prepare("UPDATE transactions SET in_coin_orign=? WHERE id = '".$zakaz['id']."' ")->execute(array($arr["data"]['details']['header']));
	}
	
     if($arrays["data"]['confirmations'] >= $zakaz['confirm']){
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = '".$users['chto_id']."' ");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$currency = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$arr["data"]['amount']["currency"]."' ");
        $currency = $currency->fetch(PDO::FETCH_ASSOC);
		
		$price = $arr["data"]['amount']["amount"];
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price * $kurs;
		$percent = $currency_para['percent'];
		$itog = $itog_bez_proc - ($itog_bez_proc * ($percent / 100));
		$scheck = number_format($itog, 2, '.', ' ');
		
		
		$this->pdo->query("DELETE FROM webcron_schedule WHERE id = ".$zakaz['id']."");
		
		$buttons4 = json_encode([
            'inline_keyboard' => [
                // первый ряд
                [
                    // первая кнопка первого ряда
                  [
                        "text" => "Средства отправлены",
                        "callback_data" => "showUserPolRUB_"
                    ],
           
                ],
				                [
                    // первая кнопка первого ряда
                  [
                        "text" => "Удалить заявку",
                        "callback_data" => "nochaloBot_"
                    ],
           
                ],
            ],
        ], true);
$text2 = 'Получена оплата по заявке <b>#'.$zakaz['id'].'</b>
Пользователь: <b>'.$users['chat'].' '.$users['last_name'].' '.$users['first_name'].' '.$users['username'].'</b>
Полученная сумма: <b>'.$arr["data"]['amount']["amount"].' '.$arr["data"]['amount']["currency"].'</b>
Сумма к выплате: <b>'.$zakaz['out_summ'].'</b>
На карту: <code>'.$zakaz['client_requisites'].'</code>';


$category = $this->pdo->query("SELECT * FROM dle_users WHERE user_group = '1'");
while ($row = $category->fetch()) {
	$ch2 = curl_init();
    curl_setopt_array(
        $ch2,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $row['chat'],
                'text' => $text2,
				'parse_mode' => 'HTML',
				'reply_markup' => $buttons4,
            ),
        )
    );
    curl_exec($ch2);
}

		$params = array('chat' => $users['chat'], 'zakaz' => $zakaz['id'], 'text' => 'Заявка #'.$zakaz['id'].' оплачена. Клиент ожидает выплату на карту.');   
	    $q = $this->pdo->prepare("INSERT INTO `notify` (chat, zakaz, text) VALUES (:chat, :zakaz, :text)");  
	    $q->execute($params);
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
                'message_id' => $users['message_id'],
            ),
        )
    );
	curl_exec($ch);
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
                'message_id' => $users['mess_zak4'],
            ),
        )
    );
	curl_exec($ch);
	
	$buttons3 = json_encode([
            'inline_keyboard' => [
                // первый ряд
                [
                    // первая кнопка первого ряда
                  [
                        "text" => "В главное меню",
                        "callback_data" => "nochaloBot_"
                    ],
           
                ],
            ],
        ], true);
	
	$text_one = 'Получена оплата по заявке <code>#'.$zakaz['id'].'</code>
Полученная сумма: <code>'.$arr["data"]['amount']["amount"].' '.$arr["data"]['amount']["currency"].'</code>
Сумма к выплате: <code>'.$zakaz['out_summ'].'</code>
На карту: <code>'.$zakaz['client_requisites'].'</code>
==========
Выплата происходит по актуальному курсу на момент полной оплаты заявки.
==========
Данное направление обрабатывается в полуавтоматическом режиме, ожидайте перевода средств в порядке очереди.

Статус заявки вы можете посмотреть в личном кабинете.
';
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
			    'video' => 'http://exorion.biz/assets/send_money.mp4',
			    'caption' => $text_one,
				'reply_markup' => $buttons3,
				'parse_mode' => 'HTML'
            ),
        )
    );
		$html = curl_exec($ch3);
		curl_close($ch3);
		
		 $this->pdo->prepare("DELETE FROM webcron_schedule WHERE id=?")->execute(array($zakaz['id']));
		
		 $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(0, $users['chat']));
		 $this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(0, $users['chat']));
		 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array(NULL, $users['chat']));
		 $this->pdo->prepare("UPDATE dle_users SET my_card=? WHERE chat=?")->execute(array(NULL, $users['chat']));
		 
		 $this->pdo->prepare("UPDATE transactions_crypto SET status=? WHERE id_transaction = '".$arr["data"]["id"]."' and accert = ? ")->execute(array($arr["status"], 0)); 
		 $this->pdo->prepare("UPDATE transactions_crypto SET accert=? WHERE id_transaction = '".$arr["id"]."' and accert = ? ")->execute(array(1, 0));
		 
		 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."' and accert = '1' ")->execute(array('Переводим средства'));
		 $this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$zakaz['id']."'")->execute(array(2));
		 $this->pdo->prepare("UPDATE transactions SET date_pay=? WHERE id = '".$zakaz['id']."'")->execute(array(time()));
		 //$this->pdo->prepare("UPDATE transactions SET sum_rub=? WHERE id = '".$zakaz['id']."'")->execute(array($scheck));
		 $this->pdo->prepare("UPDATE transactions SET sum_crypto=? WHERE id = '".$zakaz['id']."'")->execute(array($arr["data"]['amount']["amount"]));
		 $this->pdo->prepare("UPDATE transactions SET chto=? WHERE id = '".$zakaz['id']."'")->execute(array($arr["data"]['amount']["currency"]));
         $this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$zakaz['id']."'")->execute(array('Оплата получена'));
		 
		
	 } else {
		$this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$zakaz['id']."'")->execute(array('Оплата получена'));
		 $text3 = "
┌ Номер заказа: #<b>".$zakaz['id']."</b>
├ Статус заявки: <b>".$zakaz['status']."</b>
├ Сумма ".$arr["data"]['amount']["currency"]." в ожидании: <b>".$arr["data"]['amount']["amount"]."</b>
└ Количество подтверждений: <b>".$arrays["data"]['confirmations']."</b> из <b>".$zakaz['confirm']."</b>.
===========
Просьба, спокойно дожидаться Вашего обмена, ничего не тыкая и не отправляя боту, всё пройдёт автоматически, Вы получите все уведомления.
";
        $ch4 = curl_init();
		curl_setopt_array(
        $ch4,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/editMessageText',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
                'chat_id' => $users['chat'],
				'message_id' => $users['mess_zak4'],
			    'text' => $text3,
				'parse_mode' => 'HTML'
            ),
        )
    );
		$html = curl_exec($ch4);
		curl_close($ch4);
	 }
	}
	}
	