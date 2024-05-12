<?php
if (empty($_GET['uniqid'])) {
 echo 'ПНХ';
}

    $idshop = $_GET['idshop'];
	$uniqid = $_GET['uniqid'];
	
    $zakaz = $this->pdo->query("SELECT * FROM `transactions` WHERE uniq_id = '".$uniqid."' and send = '0' ");
    $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);
	
    $coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE bir = 'coinbase' and what = 'Магазины' and active = '1' ");
    $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
	
	$shop = $this->pdo->query("SELECT * FROM `shop` WHERE id = '".$zakaz['id_shop']."' ");
    $shop = $shop->fetch(PDO::FETCH_ASSOC);
	
	$cur = $this->pdo->query("SELECT * FROM `currency_api` WHERE nominal = '".$zakaz['na_chto']."' ");
	$cur = $cur->fetch(PDO::FETCH_ASSOC);
	
		  
    $API_KEY = $coinbase['api_key'];
	$API_SECRET = $coinbase['api_secret'];  
	$USER_ID = $cur['user_id'];
	$timestamp = time();
	$method = "POST";
	$path = '/v2/accounts/' . $USER_ID . '/transactions';
	$body = json_encode(array(
	 'type' => 'send',
	 'to' => $zakaz['client_requisites'],
	 'amount' => $zakaz['sendclient_crypto'],
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
	 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."'")->execute(array('Зачислено на счёт'));
	 $this->pdo->prepare("UPDATE transactions SET error_text=? WHERE id = '".$zakaz['id']."'")->execute(array($arr['errors'][0]['message']));
	} else {
	$this->pdo->prepare("UPDATE transactions SET status=? WHERE id = '".$zakaz['id']."'")->execute(array('Выплачено'));
	 $this->pdo->prepare("UPDATE transactions SET id_transaction=? WHERE id = '".$zakaz['id']."'")->execute(array($arr['data']['id']));		
	}
	$this->pdo->prepare("UPDATE transactions SET send=? WHERE id = '".$zakaz['id']."'")->execute(array(1));
	$this->pdo->prepare("DELETE FROM webcron_schedule WHERE title=?")->execute(array($uniqid));
