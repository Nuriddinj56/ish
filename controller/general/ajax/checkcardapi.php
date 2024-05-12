<?php

		  //=============Берём API ORION=======//
		  $get_set = $this->pdo->query("SELECT * FROM necro_setting ");
		  $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		  //=============Берём API ORION конец=======//
		  $category = $this->pdo->query("SELECT * FROM transactions WHERE status = 'Ждём оплату' and accert = '0' and sms_id IS NULL");
		  while ($zakaz = $category->fetch()) {
		  //=============Ищем пользователя заявки конец=======//
		  $cur = $this->pdo->query("SELECT * FROM `currency_api` WHERE nominal = '".$zakaz['na_chto']."' ");
		  $cur = $cur->fetch(PDO::FETCH_ASSOC);
		   //=============Ищем пользователя заявки=======//
		  
		   $shop = $this->pdo->query("SELECT * FROM `shop` WHERE id = '".$zakaz['id_shop']."' ");
		   $shop = $shop->fetch(PDO::FETCH_ASSOC);
		   
		   $card = $this->pdo->query("SELECT * FROM `card` WHERE number = '".$zakaz['payer_requisites']."' ");
		   $card = $card->fetch(PDO::FETCH_ASSOC);
	
		  $users = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$shop['referal']."' ");
		  $users = $users->fetch(PDO::FETCH_ASSOC);
	
		  $group_shop = $this->pdo->query("SELECT * FROM `group_shops` WHERE id = '".$zakaz['groupshop']."' ");
		  $group_shop = $group_shop->fetch(PDO::FETCH_ASSOC);
		   
		  $coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE groupshop = '".$zakaz['groupshop']."' and active = '1' and what = 'Магазины'");
          $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		   
		  //=============Ищем пользователя заявки конец=======//
		$port = $zakaz['port'];  
		$sum_rub = $zakaz['sum_rub'];
		$sum_crypto = $zakaz['sum_crypto'];
		$time_end = $zakaz['expire'];
		$time_now = strtotime('+50 seconds', time());	  
	    $token = $get_set['token'];
	

	
	
	if ($time_end < $time_now){
		
	 $this->pdo->prepare("DELETE FROM webcron_schedule WHERE id=?")->execute(array($zakaz['id']));
	 $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(0, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(0, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET my_card=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE dle_users SET my_address=? WHERE chat=?")->execute(array(NULL, $users['chat']));
	 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."'")->execute(array('Просрочено'));
	 $this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$zakaz['id']."'")->execute(array(4));
	 $this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$zakaz['id']."'")->execute(array('Время истекло'));
	 
	} else {	
	$search_summ = $this->pdo->query("SELECT * FROM simbank WHERE summa = '".$sum_rub."' and accert = '0' and com_port = '".$port."' and zakaz IS NULL ");
	$search_summ = $search_summ->fetchAll();
	if(count($search_summ) == 0){
	echo "Не найдено";
	} else {
    $sms = $this->pdo->query("SELECT * FROM simbank WHERE summa = '".$sum_rub."' and accert = '0' and com_port = '".$port."' ");
	$sms = $sms->fetch(PDO::FETCH_ASSOC);
	echo "НАйдено";
	
	
	$price = $sum_rub;
	if ($shop["pay_referal"] == 'Магазин') {
	$percent = $zakaz['percent_obmen'] + $zakaz['percent_referal'];	
	} else {
	$percent = $zakaz['percent_obmen'];	
	}
	$its = $price - ($price * ($percent / 100));  // 800
	
	
	$api_key = $coinbase['api_key'];
	$api_secret = $coinbase['api_secret'];
	$time = time();
	$method = "GET";
	$path = '/v2/exchange-rates?currency='.$zakaz['na_chto'].'';
	$sign = base64_encode(hash_hmac("sha256", $time.$method.$path, $api_secret));
	$headers = array(
	"CB-VERSION: 2018-03-30",
	"CB-ACCESS-SIGN: ".$sign,
	"CB-ACCESS-TIMESTAMP: ".$time,
	"CB-ACCESS-KEY: ".$api_key,
	"Content-Type: application/json"
	);
	$ch = curl_init('https://api.coinbase.com'.$path);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	curl_close($ch);
	$arr = json_decode($result, true);
	
	
    $price_send = $its;
	$kurs_send = $arr['data']['rates']['RUB'];
	$itog_bez_proc_send = $price_send / $kurs_send;
	$percent_send = $group_shop['percent'];
	$itog_send = $itog_bez_proc_send - ($itog_bez_proc_send * ($percent_send / 100));
	$scheck_send = number_format($itog_send, 8, '.', '');
	$scheck_bez_proc_send = number_format($itog_bez_proc_send, 8, '.', '');
	$this->pdo->prepare("UPDATE transactions SET original_crypto=? WHERE id = '".$zakaz['id']."'")->execute(array($scheck_bez_proc_send));
	
	
	
	
    if ($shop['vivod'] == 'Моментальный'){
		
    $API_KEY = $coinbase['api_key'];
	$API_SECRET = $coinbase['api_secret'];  
	$USER_ID = $cur['user_id'];
	$timestamp = time();
	$method = "POST";
	$path = '/v2/accounts/' . $USER_ID . '/transactions';
	$body = json_encode(array(
	 'type' => 'send',
	 'to' => $zakaz['client_requisites'],
	 'amount' => $scheck_send,
	 'currency' => $zakaz['na_chto']
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
		
      if($zakaz['na_chto'] == 'BTC'){
		  $balance_add = $shop['BTC'] + $scheck_send;
		  $this->pdo->prepare("UPDATE shop SET BTC=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
	  } elseif($zakaz['na_chto'] == 'LTC'){
			  $balance_add = $shop['LTC'] + $scheck_send;
			  $this->pdo->prepare("UPDATE shop SET LTC=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
		  }	elseif($zakaz['na_chto'] == 'ETH'){
			  $balance_add = $shop['ETH'] + $scheck_send;
			  $this->pdo->prepare("UPDATE shop SET ETH=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
		  }	elseif($zakaz['na_chto'] == 'USDT'){
			  $balance_add = $shop['USDT'] + $scheck_send;
			  $this->pdo->prepare("UPDATE shop SET USDT=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
		  }
        $params = array('chat' => $users['chat'], 'zakaz' => $zakaz['id'], 'text' => 'Недостаточно средств для выплаты по заявке #'.$zakaz['id'].'.');   
	    $q = $this->pdo->prepare("INSERT INTO `notify` (chat, zakaz, text) VALUES (:chat, :zakaz, :text)");  
	    $q->execute($params);		  
	 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."'")->execute(array('Зачислено на счёт'));
	 $this->pdo->prepare("UPDATE transactions SET error_text=? WHERE id = '".$zakaz['id']."'")->execute(array($arr['errors'][0]['message']));
	 $this->pdo->prepare("UPDATE transactions SET sendclient_crypto=? WHERE id = '".$zakaz['id']."'")->execute(array($scheck_send));
	 $this->pdo->prepare("UPDATE transactions SET out_summ=? WHERE id = '".$zakaz['id']."'")->execute(array($its));
	} else {
		
	$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arr['data']['resource_path']);
	$str = preg_replace('/  */', ' ', $str);
	$str = preg_replace('/\\s+/', ' ', $str);
	$array = explode(' ', $str);
		
		
	$params = array('what' => 'За транзакцию магазина', 'uniq_zakaz' => $zakaz['uniq_id'], 'id_zakaz' => $zakaz['id'], 'date' => $arr['data']["created_at"], 'id_transaction' => $arr['data']['id'], 'address' => $arr['data']["to"]["address"], 'title' => $arr['data']['details']['title'], 'header' => $arr['data']['details']['header'], 'type' => $arr['data']["type"], 'status' => $arr['data']["status"], 'amount' => $arr['data']['amount']['amount'], 'native_amount' => $arr['data']['native_amount']['amount'], 'currency' => $arr['data']['amount']['currency'], 'native_curency' => $arr['data']['native_amount']['currency'], 'hash' => $arr['data']['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr['data']['network']['hash'], 'id_account' => $array[3] );   
	$q = $this->pdo->prepare("INSERT INTO `transactions_crypto` (what, uniq_zakaz, id_zakaz, date, id_transaction, address, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:what, :uniq_zakaz, :id_zakaz, :date, :id_transaction, :address, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	$q->execute($params);
	
		$date_at_server = date('Y-m-d H:i:s', strtotime("-12 hour"));
		$date_at_user = date('Y-m-d H:i:s', strtotime("-2 hour"));
		$date = date("Y-m-d H:i:s");
		$date_cron = date('Y-m-d H:i:s', strtotime("-2 hour"));
		$date_stop = date('Y-m-d H:i:s', strtotime("+4 hour"));
		$params_cron = array('title' => $arr['data']['id'], 'expression' => '* * * * *', 'status' => 'enabled', 'url' => 'https://exorion.biz/checkconfirm/'.$zakaz['id'].'/', 'created_at' => $date_cron, 'user_id' => '1', 'category_id' => '1', 'max_executions' => '100', 'send_at_server' => $date_at_server, 'send_at_user' => $date_at_user );   
        $qcron = $this->pdo->prepare("INSERT INTO webcron_schedule (title, expression, status, url, created_at, user_id, category_id, max_executions, send_at_server, send_at_user) 
		VALUES (:title, :expression, :status, :url, :created_at, :user_id, :category_id, :max_executions, :send_at_server, :send_at_user)");  
        $qcron->execute($params_cron);
	
	$amount = $arr['data']['amount']['amount'];
    $amount = mb_eregi_replace('[^0-9.]', '', $amount);
	
	$native_amount = $arr['data']['native_amount']['amount'];
	$native_amount = mb_eregi_replace('[^0-9.]', '', $native_amount);
	$this->pdo->prepare("UPDATE transactions SET out_summ=? WHERE id = '".$zakaz['id']."'")->execute(array($native_amount));
	$this->pdo->prepare("UPDATE transactions SET sendclient_crypto=? WHERE id = '".$zakaz['id']."'")->execute(array($amount));	
	$this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."'")->execute(array('Выплачено'));
	 $this->pdo->prepare("UPDATE transactions SET id_transaction=? WHERE id = '".$zakaz['id']."'")->execute(array($arr['data']['id']));		
	}
	} else {
		
	if($zakaz['na_chto'] == 'BTC'){
		  $balance_add = $shop['BTC'] + $zakaz['sendclient_crypto'];
		  $this->pdo->prepare("UPDATE shop SET BTC=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
	  } elseif($zakaz['na_chto'] == 'LTC'){
			  $balance_add = $shop['LTC'] + $zakaz['sendclient_crypto'];
			  $this->pdo->prepare("UPDATE shop SET LTC=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
		  }	elseif($zakaz['na_chto'] == 'ETH'){
			  $balance_add = $shop['ETH'] + $zakaz['sendclient_crypto'];
			  $this->pdo->prepare("UPDATE shop SET ETH=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
		  }	elseif($zakaz['na_chto'] == 'USDT'){
			  $balance_add = $shop['USDT'] + $zakaz['sendclient_crypto'];
			  $this->pdo->prepare("UPDATE shop SET USDT=? WHERE id = '".$zakaz['id_shop']."' ")->execute(array($balance_add));
		  }	
	 $this->pdo->prepare("UPDATE transactions SET out_summ=? WHERE id = '".$zakaz['id']."'")->execute(array($its));
	 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."'")->execute(array('Зачислено на счёт'));
	}
	
	$this->pdo->prepare("UPDATE transactions SET send=? WHERE id = '".$zakaz['id']."'")->execute(array(1));		
	$this->pdo->prepare("UPDATE transactions SET accert=? WHERE id = '".$zakaz['id']."'")->execute(array(3));
	$this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id = '".$zakaz['id']."'")->execute(array('Оплата получена'));
	$this->pdo->prepare("UPDATE transactions SET sms_id=? WHERE id = '".$zakaz['id']."'")->execute(array($sms['id']));
	$this->pdo->prepare("UPDATE transactions SET sms_fullid=? WHERE id = '".$zakaz['id']."'")->execute(array($sms['id_sms']));
	$this->pdo->prepare("UPDATE simbank SET zakaz=? WHERE summa = '".$sum_rub."' and accert = '0' and com_port = '".$port."'")->execute(array($zakaz['id']));
	$this->pdo->prepare("UPDATE simbank SET accert=? WHERE summa = '".$sum_rub."' and accert = '0' and com_port = '".$port."'")->execute(array(1));
	
	$prcie   = $zakaz['sum_rub'];
    if ($shop["pay_referal"] == 'Магазин') {
	$percent = $zakaz['percent_obmen'];	
	} else {
	$percent = $zakaz['percent_obmen'] - $zakaz['percent_referal'];	
	}
    $itogs = $prcie * ($percent / 100);  // 200
    $balance_add = $get_set['oborot_rub'] + $itogs;
	
	$this->pdo->prepare("UPDATE necro_setting SET oborot_rub=? WHERE id = '1'")->execute(array($balance_add));
	$this->pdo->prepare("UPDATE transactions SET obmen_plus=? WHERE id = '".$zakaz['id']."'")->execute(array($itogs));
	
	if ($shop["referal"] == 'Не указан' OR $shop["referal"] == NULL OR $shop["referal"] == '') {
		echo 'Реферал не указан';
	} else {
	$prcie   = $zakaz['sum_rub'];
    $percent = $shop['percent_referal'];
    $itogs = $prcie * ($percent / 100);  // 200
    $balance_add = $users['balance_referal'] + $itogs;
	
	$this->pdo->prepare("UPDATE dle_users SET balance_referal=? WHERE chat = '".$shop['referal']."'")->execute(array($balance_add));
	$this->pdo->prepare("UPDATE transactions SET ref_sum=? WHERE id = '".$zakaz['id']."'")->execute(array($itogs));
	$params = array('id_shop' => $zakaz['id_shop'], 'status' => 'Зачислено', 'sum_rub' => $itogs, 'currency' => 'RUB', 'date' => time(), 'chat' => $shop["referal"]);   
	$q = $this->pdo->prepare("INSERT INTO `transactions_referals` (id_shop, status, sum_rub, currency, date, chat) VALUES (:id_shop, :status, :sum_rub, :currency, :date, :chat)");  
	$q->execute($params);
	
	}
	
	$balance_add = $shop['oborot'] + $sum_rub;
	$this->pdo->prepare("UPDATE shop SET oborot=? WHERE id = '".$shop['id']."' ")->execute(array($balance_add));
	
	$balance_add = $card['proshlo'] + $sum_rub;
	$this->pdo->prepare("UPDATE card SET proshlo=? WHERE number = '".$zakaz['payer_requisites']."' ")->execute(array($balance_add));
	
	
	$this->pdo->prepare("UPDATE transactions SET date_pay=? WHERE id = '".$zakaz['id']."'")->execute(array(time()));
	
	
	
	}


	}
		  }
	echo $group_shop['id'];