<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/PDO.php";

$coinbase = $pdo->query("SELECT * FROM exchanges WHERE what = 'Клиенты'");
$coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);

$api_key = $coinbase['api_key'];
$api_secret = $coinbase['api_secret'];
$time = time();
$method = "GET";
$res_data = $pdo->query("SELECT * FROM currency_in WHERE id != 4");
			while ($row = $res_data->fetch()) {
				$currency = $row['nominal'];
				$path = '/v2/exchange-rates?currency='.$currency.'';
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
					$pdo->prepare("UPDATE currency_in SET kurs=? WHERE nominal = '".$currency."'")->execute(array($arr['data']['rates']['RUB']));
					$pdo->prepare("UPDATE currency_in SET kurs_usd=? WHERE nominal = '".$currency."'")->execute(array($arr['data']['rates']['USD']));

			}