
<?
$zakaz = $this->pdo->query("SELECT * FROM `transactions` WHERE id = '".$_GET['zakaz']."' ");
$zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);

$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE groupshop = '".$zakaz['groupshop']."' and active = '1' and what = 'Магазины'");
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
 
 echo   $arr['data']['network']['hash'].$arr['data']['status'];
 
$this->pdo->prepare("UPDATE transactions_crypto SET hash=?, status=? WHERE id_zakaz=?")->execute(array($arr['data']['network']['hash'], $arr['data']['status'], $_GET['zakaz']));
$this->pdo->prepare("UPDATE transactions SET hash=? WHERE id=?")->execute(array($arr['data']['network']['hash'], $_GET['zakaz']));
 if ($arr['data']['status'] == 'completed') {
$this->pdo->prepare("DELETE FROM webcron_schedule WHERE title=?")->execute(array($arr['data']['id']));	 
 }

?>



