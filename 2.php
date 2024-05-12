
<?
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/PDO.php";

$API_KEY = "5sKpdVfAwiFJY8B4";
$API_SECRET = "lDft0lmO264zb7JMfVn3xqVJiS25Gsk6";  
$USER_ID = "5732e34f-8745-55b9-a300-bf920555bf8d";
$timestamp = time();
$method = "GET";
$path = '/v2/accounts/5732e34f-8745-55b9-a300-bf920555bf8d/transactions';


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
echo $html; 
     
     foreach ($arr['data'] as $arrs) {
    
		 echo $arrs["id"];
	echo $arrs['network']['hash'];
    $search_id = $pdo->query("SELECT * FROM transactions_crypto WHERE id_transaction = '".$arrs["id"]."'");
    $search_id = $search_id->fetchAll();
	if(count($search_id) == 0){
	$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arrs['resource_path']);
	$str = preg_replace('/  */', ' ', $str);
	$str = preg_replace('/\\s+/', ' ', $str);
	$array = explode(' ', $str);
		
		
	$params = array('date' => $arrs["created_at"], 'id_transaction' => $arrs["id"], 'address' => $arrs["to"]["address"], 'title' => $arrs['details']['title'], 'header' => $arrs['details']['header'], 'type' => $arrs["type"], 'status' => $arrs["status"], 'amount' => $arrs['amount']['amount'], 'native_amount' => $arrs['native_amount']['amount'], 'currency' => $arrs['amount']['currency'], 'native_curency' => $arrs['native_amount']['currency'], 'hash' => $arrs['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arrs['network']['hash'], 'id_account' => $array[3] );   
	$q = $pdo->prepare("INSERT INTO `transactions_crypto` (date, id_transaction, address, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:date, :id_transaction, :address, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	$q->execute($params);
	}
	
	}  
?>



