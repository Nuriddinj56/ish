<?
$API_KEY = $_POST['api_key'];
$API_SECRET = $_POST['api_secret'];  
$timestamp = time();
$method = "GET";
$path = '/v2/accounts';

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

if ($arr['errors'][0]['id'] == ''){
		echo '<div class="alert alert-light-success border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>ПРОВЕРКА ПРОШЛА УСПЕШНО!</strong> Можете продолжать добавление аккаунта. </div>';
foreach ($arr['data'] as $arrs) {
											?>
											
                                                <li style="margin-left:-30px;">
                                                    <? echo $arrs["name"];?>
                                                    <ul>
                                                        <li>
                                                            Баланс: <? echo $arrs['balance']['amount'];?> <? echo $arrs['balance']['currency'];?>
                                                        </li>
														<li>
                                                            Название полное: <? echo $arrs['currency']['slug'];?>
                                                        </li>
                                                        <li>
                                                            ID: <? echo $arrs['id'];?>
                                                        </li>
														<li>
                                                            Создан: <? echo $arrs['created_at'];?>
                                                        </li>
														<li>
                                                            Обновлён: <? echo $arrs['updated_at'];?>
                                                        </li>
                                                    </ul>
                                                </li>
												<?
												}
												
} else {
	echo '<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>ОШИБКА!</strong> Внимательно проверьте введённые API ключ и секрет. </div>';
}