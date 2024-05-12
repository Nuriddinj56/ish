<?php
		  $idzakaz = $_GET['idzakaz'];
		  $uniq_id = $_GET['uniq_id'];
		  //=============Берём API ORION=======//
		  //=============Берём API ORION конец=======//
		  $zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = '".$idzakaz."' and status = 'Ждём оплату' and accert = '0'");
		  $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);
		  $get_set = $this->pdo->query("SELECT * FROM necro_setting ");
		  $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		  //=============Берём API ORION=======//
			  $get_bots = $this->pdo->query("SELECT * FROM bots WHERE id = '".$zakaz['id_bot']."' ");
			  $get_bots = $get_bots->fetch(PDO::FETCH_ASSOC);
		 //=============Берём API ORION конец=======//
		  
		  //=============Ищем пользователя заявки конец=======//
		  $cur = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$zakaz['na_chto']."' ");
		  $cur = $cur->fetch(PDO::FETCH_ASSOC);
		  
		  $para = $this->pdo->query("SELECT * FROM `currency_para` WHERE currency_out = '".$zakaz['na_chto']."' ");
		  $para = $para->fetch(PDO::FETCH_ASSOC);
		  
		   //=============Ищем пользователя заявки=======//
		  $users = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$zakaz['chat']."' ");
		  $users = $users->fetch(PDO::FETCH_ASSOC);
		  //=============Ищем пользователя заявки конец=======//
		$port = $zakaz['port'];  
		$sum_rub = $zakaz['sum_rub'];
		$sum_crypto = $zakaz['sum_crypto'];
		$time_end = $zakaz['expire'];
		$time_now = strtotime('+50 seconds', time());	  
	$token = $get_bots['token'];
	

	
    $buttons = json_encode(['inline_keyboard' => [[["text" => "В главное меню","callback_data" => "nochaloBot_"],],],], true);

	if ($time_end < $time_now){
	$text2 = 'Ваша заявка удалена, т.к время на оплату истекло.';	
	$ch2 = curl_init();curl_setopt_array($ch2,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/sendMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'text' => $text2,'parse_mode' => 'HTML','reply_markup' => $buttons,),));curl_exec($ch2);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak'],),));curl_exec($ch);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak3'],),));curl_exec($ch);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak4'],),));curl_exec($ch);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['message_id'],),));curl_exec($ch);
	 $this->pdo->prepare("DELETE FROM webcron_schedule WHERE id=?")->execute(array($idzakaz));
	 $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(0, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(0, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET my_card=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET my_address=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$idzakaz."'")->execute(array('Просрочено'));
	 $this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$idzakaz."'")->execute(array(4));
	 $this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$idzakaz."'")->execute(array('Время истекло'));

	} else {
	$smstemp = $this->pdo->query("SELECT * FROM smstemp WHERE port = '".$port."'");
	$smstemp = $smstemp->fetch(PDO::FETCH_ASSOC);
	$search_summ = $this->pdo->query("SELECT * FROM simbank WHERE summa = '".$sum_rub."' and accert = '0' and com_port = '".$port."' ");
	$search_summ = $search_summ->fetchAll();
	if(count($search_summ) == 0){
	$endOfDiscount = $users['time_api']; // дата окончания распродажи
	$now = time()-60*$users['time_rez']; // текущее время
	$secondsRemaining = $endOfDiscount - $now; // оставшееся время
	 define('SECONDS_PER_MINUTE', 60); // секунд в минуте
	 define('SECONDS_PER_HOUR', 3600); // секунд в часу
	 define('SECONDS_PER_DAY', 86400); // секунд в дне
	 $daysRemaining = floor($secondsRemaining / SECONDS_PER_DAY); //дни, до даты
	 $secondsRemaining -= ($daysRemaining * SECONDS_PER_DAY);     //обновляем переменную
	 $hoursRemaining = floor($secondsRemaining / SECONDS_PER_HOUR); // часы до даты
	 $secondsRemaining -= ($hoursRemaining * SECONDS_PER_HOUR);     //обновляем переменную
	 $minutesRemaining = floor($secondsRemaining / SECONDS_PER_MINUTE); //минуты до даты
	 $secondsRemaining -= ($minutesRemaining * SECONDS_PER_MINUTE);     //обновляем переменную 
	 $msg = "Обмен на Ваш кошелёк ".$users['na_chto'].": <b>".$users['my_address']."</b>
	 
До конца заявки: <b>".$minutesRemaining."</b> мин.

<b>Будьте внимательны при переводе, не ошибитесь в сумме и номере карты, можете их скопировать нажатием по сумме и номеру.</b>
";

$buttons4 = json_encode(['inline_keyboard' => [[["text" => "Отменить заявку","callback_data" => "otmena_".$idzakaz],],],], true);

	$ch4 = curl_init();curl_setopt_array($ch4,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/editMessageText',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak'],'text' => $msg,'parse_mode' => 'HTML','reply_markup' => $buttons4),));$html = curl_exec($ch4);curl_close($ch4);
	} else {
	if($zakaz['wallet_client'] == 'На отдельный кошелёк'){
	$msg = "Оплата получена,  отправляем вам средства в размере <b>".$zakaz['sum_crypto']." ".$zakaz['na_chto']."</b>, на кошелёк <b>".$users['my_address']."</b>";
	
				   $coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE active = '1' and what = 'Клиенты'");
               $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
			   $currency = $zakaz['na_chto'];
if($currency == 'BTC'){
	$user_id = $coinbase['btc_id'];
} elseif($currency == 'LTC'){
    $user_id = $coinbase['ltc_id'];
} elseif($currency == 'ETH'){
	$user_id = $coinbase['eth_id'];
} elseif($currency == 'USDT'){
	$user_id = $coinbase['usdt_id'];
} 
	
	
    $API_KEY = $coinbase['api_key'];
    $API_SECRET = $coinbase['api_secret'];  
	$USER_ID = $user_id;
	$timestamp = time();
	$method = "POST";
	$path = '/v2/accounts/' . $USER_ID . '/transactions';
	$body = json_encode(array(
	 'type' => 'send',
	 'to' => $users['my_address'],
	 'amount' => $zakaz['sum_crypto'],
	 'currency' => $currency
	));
	$message = $timestamp . $method . $path . $body;
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
	$curl = curl_init($api_url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
	$resp = curl_exec($curl);
	curl_close($curl);
	$arr = json_decode($resp, true);
		if($arr['data'] == ''){
    $msg_error = "<b>".$arr['errors']['message']."</b>";
	
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/editMessageText',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak'],'text' => 'Ошибка выплаты: '.$msg_error.'

Администратор уведомлён, ожидайте, с минуты на минуту вам отправят','parse_mode' => 'HTML','reply_markup' => $buttons),));$html = curl_exec($ch);curl_close($ch);
     
	 
	 
	 
	 $params = array('id_transaction' => $arr["data"]["id"], 'title' => $arr["data"]['details']['title'], 'header' => $arr["data"]['details']['header'], 'type' => $arr["data"]["type"], 'status' => $arr["data"]["status"], 'amount' => $arr["data"]['amount']['amount'], 'native_amount' => $arr["data"]['native_amount']['amount'], 'currency' => $arr["data"]['amount']['currency'], 'native_curency' => $arr["data"]['native_amount']['currency'], 'hash' => $arr["data"]['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr["data"]['network']['hash'], 'id_account' => $array[3]);   
	 $q = $this->pdo->prepare("INSERT INTO `transactions_out` (id_transaction, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:id_transaction, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	 $q->execute($params);
	 
	 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$idzakaz."'")->execute(array('Ошибка выплаты'));
	 $this->pdo->prepare("UPDATE transactions SET error_text=? WHERE id = '".$idzakaz."'")->execute(array($arr['errors'][0]['message']));
	 $this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$idzakaz."'")->execute(array(2));	
	} else {
	$search_id = $this->pdo->query("SELECT * FROM transactions_out WHERE id_transaction = '".$arr["data"]["id"]."'");
    $search_id = $search_id->fetchAll();
	if(count($search_id) == 0){
		
	$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arr["data"]['resource_path']);
	$str = preg_replace('/  */', ' ', $str);
	$str = preg_replace('/\\s+/', ' ', $str);
	$array = explode(' ', $str);
		
	$params = array('id_transaction' => $arr["data"]["id"], 'title' => $arr["data"]['details']['title'], 'header' => $arr["data"]['details']['header'], 'type' => $arr["data"]["type"], 'status' => $arr["data"]["status"], 'amount' => $arr["data"]['amount']['amount'], 'native_amount' => $arr["data"]['native_amount']['amount'], 'currency' => $arr["data"]['amount']['currency'], 'native_curency' => $arr["data"]['native_amount']['currency'], 'hash' => $arr["data"]['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr["data"]['network']['hash'], 'id_account' => $array[3]);   
	$q = $this->pdo->prepare("INSERT INTO `transactions_out` (id_transaction, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:id_transaction, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	$q->execute($params);
	
	}
	
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/editMessageText',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak'],'text' => $msg,'parse_mode' => 'HTML','reply_markup' => $buttons),));$html = curl_exec($ch);curl_close($ch);
	sleep(4);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/editMessageText',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak'],'text' => 'Средства отправлены на ваш кошелёк.
Ссылка на транзакцию ниже.

'.$arr['data']['to']['address_url'].' ','parse_mode' => 'HTML','reply_markup' => $buttons),));
	$html = curl_exec($ch);curl_close($ch);
	
	 $money = preg_replace('/[^\d\.]+/','',$arr['data']['amount']['amount']);
	 $money_rub = preg_replace('/[^\d\.]+/','',$arr['data']['native_amount']['amount']);
     $this->pdo->prepare("UPDATE transactions SET id_transaction=? WHERE id = '".$idzakaz."' ")->execute(array($arr['data']['id']));
	  $this->pdo->prepare("UPDATE transactions SET sendclient_crypto=? WHERE id = '".$idzakaz."' ")->execute(array($money));
	 $this->pdo->prepare("UPDATE transactions SET out_summ=? WHERE id = '".$idzakaz."' ")->execute(array($money_rub));
	$this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$idzakaz."'")->execute(array('Оплата получена'));
	$this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$idzakaz."'")->execute(array('Выплачено'));
	$this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$idzakaz."'")->execute(array(3));
	}
	} else {
	$wallet = $this->pdo->query("SELECT * FROM `wallets` WHERE address = '".$zakaz['client_requisites']."' and chat = ".$users['chat']."");
	$wallet = $wallet->fetch(PDO::FETCH_ASSOC);
	$balans_add = $wallet['balance'] + $sum_crypto;
	
	   /*  $price = $zakaz['sum_crypto'];
		$kurs = $cur['kurs'];
		$itog_bez_proc = $price * $kurs;
		$percent = $para['percent'];
		$itog = $itog_bez_proc - ($itog_bez_proc * ($percent / 100));
		$scheck = number_format($itog, 2, '.', '');
	
	
	$this->pdo->prepare("UPDATE transactions SET out_summ=? WHERE id = '".$idzakaz."' ")->execute(array($scheck)); */
	$this->pdo->prepare("UPDATE wallets SET balance=? WHERE address = '".$zakaz['client_requisites']."' and chat = ".$users['chat']." ")->execute(array($balans_add));
	$msg = "Оплата получена, средства в размере <b>".$zakaz['sum_crypto']." ".$zakaz['na_chto']."</b>, зачислены на личный счёт обменника.";
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/editMessageText',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak'],'text' => $msg,'parse_mode' => 'HTML','reply_markup' => $buttons),));$html = curl_exec($ch);curl_close($ch);
	$this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$idzakaz."'")->execute(array('Выплачено'));
	$this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$idzakaz."'")->execute(array('Оплата получена'));
	$this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$idzakaz."'")->execute(array(3));
	$this->pdo->prepare("UPDATE transactions SET sendclient_crypto=? WHERE id = '".$idzakaz."' ")->execute(array($zakaz['sum_crypto']));
	}
	
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak3'],),));curl_exec($ch);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['mess_zak4'],),));curl_exec($ch);
	$ch = curl_init();curl_setopt_array($ch,array(CURLOPT_URL => 'https://api.telegram.org/bot'.$token.'/deleteMessage',CURLOPT_POST => TRUE,CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_TIMEOUT => 10,CURLOPT_POSTFIELDS => array('chat_id' => $users['chat'],'message_id' => $users['message_id'],),));curl_exec($ch);
	 $this->pdo->prepare("DELETE FROM webcron_schedule WHERE id=?")->execute(array($idzakaz));
	 //=================================//
	 $this->pdo->prepare("UPDATE transactions SET date_pay=? WHERE id = '".$idzakaz."'")->execute(array(time()));
	 //$this->pdo->prepare("UPDATE live SET new_summ=? WHERE id = '1'")->execute(array($zakaz['sum_rub']));
	 //=================================//
	 $this->pdo->prepare("UPDATE simbank SET accert=? WHERE summa = '".$sum_rub."' and com_port = '".$port."' ")->execute(array(1));
	 //=================================//
	 $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(0, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(0, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET my_card=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET my_address=? WHERE chat=?")->execute(array(NULL, $users['chat']));
    
	
	$prcie   = $zakaz['sum_rub'];
    $percent = $para['percent'];
    $itogs = $prcie * ($percent / 100);  // 200
    $balance_add = $get_set['oborot_rub'] + $itogs;
	
	$this->pdo->prepare("UPDATE necro_setting SET oborot_rub=? WHERE id = '1'")->execute(array($balance_add));
	$this->pdo->prepare("UPDATE transactions SET obmen_plus=? WHERE id = '".$idzakaz."'")->execute(array($itogs));
	
	
	}
	
	}


