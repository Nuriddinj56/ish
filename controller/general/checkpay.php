<?PHP
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$smstemp = $this->pdo->query("SELECT * FROM smstemp WHERE port = '".$_POST['comport']."'");
$smstemp = $smstemp->fetch(PDO::FETCH_ASSOC);

$text = $_POST['message'];

$array = explode(' ', $text);

echo $array[$a]; // ещё
echo $array[$b]; // ещё

$a = round($smstemp['summa']);
$b = $smstemp['balance'];

$str = $array[$a];
$str2 = $array[$b];
$sum = explode( '.', $str )[0];
$bal = explode( '.', $str2 )[0];
$search_id = $this->pdo->query("SELECT * FROM simbank WHERE id_sms = '".$_POST['id']."'");
$search_id = $search_id->fetchAll();
if(count($search_id) == 0){
$empQuery = $this->pdo->prepare("INSERT INTO simbank SET id_sms = :id_sms, from_sms = :from_sms, msg = :msg, imei = :imei, com_port = :com_port, summa = :summa, balance = :balance, date = :date");
				$empQuery->execute([
				'id_sms' => $_POST['id'],
				'from_sms' => $_POST['from'],
				'msg' => $_POST['message'],
				'imei' => $_POST['imei'],
				'com_port' => $_POST['comport'],
				'summa' => $sum,
				'balance' => $bal,
				'date' => time()
				]);
}