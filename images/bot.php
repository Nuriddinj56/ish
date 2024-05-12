<?php
error_reporting (1);
// определим кодировку UTF-8
header("HTTP/1.1 200 OK");
header('Content-type: text/html; charset=utf-8');
// создаем объект магазина
$newShop = new ShopBot();
// запускаем магазин
$newShop->init();

class ShopBot
{
    private $host = 'localhost';
    private $db = 'orion';
    private $user = 'orion';
    private $pass = 'пароль от бд';
    private $charset = 'utf8mb4';
    private $pdo;
    private $img_path = "img"; // путь до директории с картинками относительно этого файла

    public function init()
    {
        $this->setPdo();
        $rawData = json_decode(file_get_contents('php://input'), true);
		$json = file_get_contents('php://input'); // Получаем запрос от пользователя
        $action = json_decode($json, true); // Расшифровываем JSON
        $this->router($rawData);
        return true;
    }

    private function router($data)
    {
		
        $chat_id = $this->getChatId($data);
        $msg = $this->getText($data);
		
		$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE id = '1'");
		$coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		
		$str=$coinbase['kurs_ltc'];
		$a=mb_strstr($str,".",true);
		if($a) $str=$a."";
		$today_cash = number_format($str); //output: 5,000,000
		$summ = str_replace(',', '.', $today_cash);
		$this->kurs_ltc = $summ;
		
		$str=$coinbase['kurs_eth'];
		$a=mb_strstr($str,".",true);
		if($a) $str=$a."";
		$today_cash = number_format($str); //output: 5,000,000
		$summ = str_replace(',', '.', $today_cash);
		$this->kurs_eth = $summ;
		
		$str=$coinbase['kurs_btc'];
		$a=mb_strstr($str,".",true);
		if($a) $str=$a."";
		$today_cash = number_format($str); //output: 5,000,000
		$summ = str_replace(',', '.', $today_cash);
		$this->kurs_btc = $summ;
		
		
		
		$this->api_key = $coinbase['api_key'];
		$this->api_secret = $coinbase['api_secret'];
		$this->api_btc_id = $coinbase['btc_id'];
		$this->api_ltc_id = $coinbase['ltc_id'];
		
		$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		$userok = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $userok = $userok->fetch(PDO::FETCH_ASSOC);
		$this->mode = $get_set['mode'];
        
        if (array_key_exists("message", $data)) {
            $actionUser = $this->getUserAction($chat_id);
            if (array_key_exists("text", $data['message'])) {
				$msg = $msg ?? '';
				$text = $text ?? '';
                $text = $data['message']['text'];
                if ($text == "/start") {
					$this->StartBotOne($chat_id, $data);
                } else {
					if($userok['send'] == 0){
					if (preg_match("/[ @]?(\d{1}\.\d{4})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{1})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{2})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{3})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{5})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{6})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{7})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					} elseif (preg_match("/[ @]?(\d{1}\.\d{8})\b/", $text)) {
						$this->kursCrypto($chat_id, $data, $text);
					}  elseif (preg_match("/^\d+$/", $text)) { 
						$this->kursRub($chat_id, $data, $text);
					}  else { 
						$this->StartBotOne($chat_id, $data);
					} 
					} else {
					if (preg_match("~^step_1_summ$~", $actionUser)) {
                        $this->saveSummUserAny($msg, $data);
                    }   elseif (preg_match("~^step_1_address$~", $actionUser)) {
                        $this->saveMyAddress($msg, $data);
                    } else {
						$this->StartBotOne($chat_id, $data);
					}
					}
                    }
                }
				$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
			}
        
        elseif (array_key_exists("callback_query", $data)) {
            // смотрим какая функция вызывается
            $func_param = explode("_", $msg);
            // определяем функцию в переменную
            $func = $func_param[0];
            // вызываем функцию передаем ей весь объект
            $this->$func($data['callback_query']);
        }
        return true;
    }
	
//===========================================================================//
	
	 private function kursRub($chat_id, $data, $text)
    {

		$json = file_get_contents('php://input'); // Получаем запрос от пользователя
        $action = json_decode($json, true); // Расшифровываем JSON
		$endpoint = 'convert';
		$access_key = 'f61a31867c7c9c6df8595da56cfc0f36';
		$msg .= 'За <b>'.$text.'</b> RUB вы получите:
=========================';
		$res_data = $this->pdo->query("SELECT * FROM currency_para WHERE `currency_in` NOT IN ('VISA') ORDER BY id DESC");
		while ($row = $res_data->fetch()) {
		$from = 'RUB';
		$to = $row['currency_in'];
		$amount = $text;
		$ch = curl_init('https://api.coinlayer.com/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);
		$conversionResult = json_decode($json, true);
		$msg .= '
'.$conversionResult['result'] . ' ' . $row['currency_in'] . '
';
		$msg .= '=========================';
		}		
        $data_send = [
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'html',
        ];
		if (is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
        $this->botApiQuery("sendMessage", $data_send);
	

    }
	
	private function kursCrypto($chat_id, $data, $text)
    {

		$json = file_get_contents('php://input'); // Получаем запрос от пользователя
        $action = json_decode($json, true); // Расшифровываем JSON

		// set API Endpoint, access key, required parameters
		$endpoint = 'convert';
		$access_key = 'f61a31867c7c9c6df8595da56cfc0f36';
				$msg .= '=========================';
		$res_data = $this->pdo->query("SELECT * FROM currency_para WHERE `currency_out` NOT IN ('VISA') ORDER BY id DESC");
		while ($row = $res_data->fetch()) {
		$from = $row['currency_out'];
		$to = 'RUB';
		$amount = $text;
		
		// initialize CURL:
		$ch = curl_init('https://api.coinlayer.com/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// get the JSON data
		$json = curl_exec($ch);
		curl_close($ch);
		
		// Decode JSON response
		$conversionResult = json_decode($json, true);
		$y = $conversionResult['result'];
		$x = (int)$y;
		$cash = number_format($x); //output: 5,000,000
		$summ = str_replace(',', '.', $cash);
		
$msg .= '
За <b>'.$text.'</b> ' . $row['currency_out'] . ' вы получите: '.$summ.' RUB
';
		$msg .= '=========================';
		}		
		
        $data_send = [
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'html',
        ];
		if (is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
        $this->botApiQuery("sendMessage", $data_send);
	

    }
	
	
	
private function StartBotOne($chat_id, $data)
    {
        // получаем данные
		$chat_id = $chat_id;
        // Выводим корзину
        $this->startBot($chat_id, $data);
        $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
        $this->notice($data['id']);
    }

    /** Выводим корзину
     * @param $chat_id
     * @param $data
     */
    private function startBot($chat_id, $data)
    {
        $json = file_get_contents('php://input'); // Получаем запрос от пользователя
        $action = json_decode($json, true); // Расшифровываем JSON
        
		$user = $this->pdo->prepare("SELECT * FROM dle_users WHERE chat = :chat");
        $user->execute(['chat' => $chat_id]);
		
		$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
	    $this->pdo->prepare("UPDATE dle_users SET chat_message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$msg = $msg ?? '';
        $username = strtolower($data['message']['from']['username']);
		$this->botApiQuery("sendSticker", [
                    'chat_id' => $chat_id,
                    'sticker' => 'CAACAgIAAxkBAAJigmId-udnErpbzZehuwT5O0LR8jHLAAJuFAACn4PoSLrSfm_0GlpLIwQ',
					'parse_mode' => 'HTML',
                ]
            );
		if ($username == '') {
		$login = 'Не указано';
		} else {
		$login = $username;	
		}
        if ($user->rowCount() == 0) {
            if ($get_set['mode'] == '0') {
				$timestamp = time();
				$method = "POST";
				$path = '/v2/accounts/' . $USER_ID . '/addresses';
				$body = json_encode(array('name' => 'New receive address'));
				$message = $timestamp . $method . $path . $body;
				$signature = hash_hmac('SHA256', $message, $this->api_secret);
				$version = '2021-01-11';
				$headers = array(
				'CB-ACCESS-SIGN: ' . $signature,
				'CB-ACCESS-TIMESTAMP: ' . $timestamp,
				'CB-ACCESS-KEY: ' . $this->api_key,
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
				$mode = $arr['data']['address'];
			} elseif ($get_set['mode'] == '1') {
				$mode = NULL;
			}
			$date = date("Y-m-d");
            $newUser = $this->pdo->prepare("INSERT INTO dle_users SET chat = :chat, username = :username, login = :login, first_name = :first_name, last_name = :last_name, reg_date = :reg_date, action = 'start'");
            $newUser->execute([
				'chat' => $chat_id,
                'first_name' => $data['message']['chat']['first_name'],
                'last_name' => $data['message']['chat']['last_name'],
				'username' => $login,
				'login' => $login,
				'reg_date' => $date,
            ]);
			$this->sendMessage($chat_id, "Вы успешно зарегестрированы в системе.");
        } else {
            // если пользователь есть то меняем ему действие
            @$this->setActionUser("start", $chat_id);
        }
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$msg = '<b>Добро пожаловать в Orion - обмен btc , ltc, eth и usdt</b>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
┌ Моментальный автоматический обмен.
├ Сделки без регистрации и верификации.
├ Реферальная программа 5%.
├ Еженедельные конкурсы.
├ Автоматизация вашего бизнеса по API.
└ Работаем без выходных и праздников.

┌ Ваш ID: <code>'.$chat_id.'</code>
├ Ваш баланс: ₽'.$user['balans_rub'].'
├ Совершено обменов: 0
└ Ссылка приглашения: <code>exorion.biz/ref32343</code>
=========================
Что-бы расчитать сколько вы получите во всех возможных валютах, в любом разделе бота, отправьте сообщение с суммой. 
';
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Начать обмен", "goChange_"),
            ];
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Обратная связь", "photoHost_"),
            ];
		
        $data_send = [
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'html',
        ];
		if (is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
        $this->botApiQuery("sendMessage", $data_send);
	
    
    }

        private function nochaloBot($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		
		
		$msg = '<b>Добро пожаловать в Orion - обмен btc , ltc, eth и usdt</b>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
┌ Моментальный автоматический обмен.
├ Сделки без регистрации и верификации.
├ Реферальная программа 5%.
├ Еженедельные конкурсы.
├ Автоматизация вашего бизнеса по API.
└ Работаем без выходных и праздников.

┌ Ваш ID: <code>'.$chat_id.'</code>
├ Ваш баланс: ₽'.$user['balans_rub'].'
├ Совершено обменов: 0
└ Ссылка приглашения: <code>exorion.biz/ref32343</code>
=========================
Что-бы расчитать сколько вы получите во всех возможных валютах, в любом разделе бота, отправьте сообщение с суммой. 
';
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Начать обмен", "goChange_"),
            ];
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Обратная связь", "photoHost_"),
            ];

	    $this->editMessageText($chat_id, $message_id, $msg, $buttons);
        $this->notice($data['id'], "Главное меню");
		}
		
		
		private function goChange($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
			    
		$msg = '<code>Вы начали процедуру обмена.</code>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
<b>Шаг - 1:</b> Что у Вас есть?';
			$res_data = $this->pdo->query("SELECT * FROM currency_in WHERE active = '1' ORDER BY id DESC");
			while ($row = $res_data->fetch()) {
		    $str=$row['kurs'];
			$a=mb_strstr($str,".",true);
			if($a) $str=$a."";
			$today_cash = number_format($str); //output: 5,000,000
			$kurs = str_replace(',', '.', $today_cash);
			if ($row['nominal'] == 'BTC') {
				$cur = 	'BITCOIN';
			} elseif ($row['nominal'] == 'LTC') {
			$cur = 	'LITECOIN';
			} elseif ($row['nominal'] == 'ETH') {
				$cur = 	'ETHERIUM';
			} elseif ($row['nominal'] == 'VISA') {
				$cur = 	'Visa/MasterCard [RUB]';
			}
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('У меня есть: '.$cur, "goChangeStepOneCrypto_" . $row['id'].'_' . $row['nominal']),
            ];
			}
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("<< В главное меню", "nochaloBot_"),
            ];

	    $this->editMessageText($chat_id, $message_id, $msg, $buttons);
        $this->notice($data['id'], "Выберите что хотите поменять.");
		}
		
		
		
		private function goChangeStepOneCrypto($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$this->pdo->prepare("UPDATE dle_users SET chto=? WHERE chat=? ")->execute(array($param[1], $chat_id));
/* 		if ($this->mode == '0') {
            @$this->setCreateWallet($param[2], $chat_id);
			} */
		
		if ($param[2] == 'BTC') {
		$cur = 	'BITCOIN';
		$obmen = 'goChangeStepOneCrypto';
		} elseif ($param[2] == 'LTC') {
		$cur = 	'LITECOIN';
		$obmen = 'goChangeStepOneCrypto';
		} elseif ($param[2] == 'ETH') {
		$cur = 	'ETHERIUM';
		$obmen = 'goChangeStepOneCrypto';
		} elseif ($param[2] == 'VISA') {
		$cur = 	'Visa/MasterCard';
		$obmen = 'goChangeStepOneRub';
		}
		
		$msg = '<code>Идёт процедура обмена.</code>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
<b>Шаг - 2:</b> На что Вы хотите поменять Ваши <b>'.$cur.'</b>?';
			
			$res_data = $this->pdo->query("SELECT * FROM currency_para WHERE chto = '".$param[1]."' ORDER BY id DESC");
			while ($row = $res_data->fetch()) {
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('Поменять '.$cur.' на ' . $row['currency_out'], $obmen.'_' . $row['currency_out'].'_'.$row['na_chto']),
            ];
			}
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("<< Назад", "goChange_"),
					$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_"),
            ];

	    $this->editMessageText($chat_id, $message_id, $msg, $buttons);
        $this->notice($data['id'], "Выберите на что хотите поменять.");
		}
		
		
		
		
private function goChangeStepOneRub($data)
    {
        $chat_id = $this->getChatId($data);
        if ($this->setActionUser("step_1_summ", $chat_id)) {
            $this->insertSummAny($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
    }

       private function insertSummAny($chat_id, $data)
    {
		$param = explode("_", $data['data']);
		if ($param[1] == 'BTC') {
		$cur = 	'BITCOIN';
		} elseif ($param[1] == 'LTC') {
		$cur = 	'LITECOIN';
		} elseif ($param[1] == 'ETH') {
		$cur = 	'ETHERIUM';
		}
		
        $msg = '<code>Идёт процедура обмена.</code>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
<b>Шаг - 3:</b> Введите сумму <b>которая у вас есть в рублях, либо введите сумму которая Вам нужна в криптоалюте</b>, система определит и выдаст Вам результат.
=========================
Формат ввода:
<b>Рубли:</b> вводите просто сумму числом, например: 10000
<b>'.$cur.':</b> вводите сумму которая вам нужна в '.$cur.', например: 0.004312
';
        $this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET na_chto=? WHERE chat=?")->execute(array($param[2], $chat_id));
            $buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "nochaloBot_"),
            ];
        $this->botApiQuery("editMessageText", [
            'chat_id' => $chat_id,
            'text' => $msg,
            'message_id' => $this->getMessageId($data),
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons),
        ]);
		
				
        $this->notice($data['id']);
    }

     private function saveSummUserAny($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE chto = {$user['chto']} and na_chto = {$user['na_chto']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		if ($currency_para['currency_in'] == 'VISA') {
		$cur = 	'Visa/MasterCard [RUB]';
		}
		
		if (preg_match("/[ @]?(\d{1}\.\d{1})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{2})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{3})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{4})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{5})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{6})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{7})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{8})\b/", $msg)) {
		// set API Endpoint, access key, required parameters
		$endpoint = 'convert';
		$access_key = 'f61a31867c7c9c6df8595da56cfc0f36';
		$from = $currency_para['currency_out'];
		$to = 'RUB';
		$amount = $msg;
		$ch = curl_init('https://api.coinlayer.com/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);
		$conversionResult = json_decode($json, true);
		$y = $conversionResult['result'];
		$x = (int)$y;
		
		    $percent_summ = $x + ($x/100) * $currency_para['percent'];
			$percent_summgo = (int)$percent_summ;
		    $this->pdo->prepare("UPDATE dle_users SET amount_rub=? WHERE chat=? ")->execute(array($percent_summgo, $chat_id));
            $this->pdo->prepare("UPDATE dle_users SET amount_crypto=? WHERE chat=? ")->execute(array($msg, $chat_id));
			$text_msg = "<code>Внимательно проверьте все данные!</code>
<code>===============</code>
<b>Вы меняете:</b> {$cur} на {$currency_para['currency_out']}
<b>Вам нужно:</b> {$msg} {$currency_para['currency_out']}
<b>К оплате в рублях:</b> {$percent_summgo}
<code>===============</code>
<code>Если Вы хотите изменить сумму платежа, просто отправьте новую сумму и она заменит предыдущую.</code>";

					$buttons[] = [$this->buildInlineKeyBoardButton("Продолжить оплату", "goSaveMyAdress_"),];
					$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];

		} elseif (preg_match("/^\d+$/", $msg)) {
				// set API Endpoint, access key, required parameters
		$endpoint = 'convert';
		$access_key = 'f61a31867c7c9c6df8595da56cfc0f36';
		$from = 'RUB';
		$to = $currency_para['currency_out'];
		$amount = $msg;
		$ch = curl_init('https://api.coinlayer.com/api/'.$endpoint.'?access_key='.$access_key.'&from='.$from.'&to='.$to.'&amount='.$amount.'');   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);
		$conversionResult = json_decode($json, true);
		$price = $conversionResult['result'];
		$percent = $currency_para['percent'];
        $percent_summ = $price - ($price * ($percent / 100));  // 800

		    $this->pdo->prepare("UPDATE dle_users SET amount_rub=? WHERE chat=? ")->execute(array($msg, $chat_id));
            $this->pdo->prepare("UPDATE dle_users SET amount_crypto=? WHERE chat=? ")->execute(array($percent_summ, $chat_id));
			$text_msg = "<code>Внимательно проверьте все данные!</code>
<code>===============</code>
<b>Вы меняете:</b> {$cur} на {$currency_para['currency_out']}
<b>У вас есть:</b> {$msg} рублей
<b>Вы получите:</b> {$percent_summ} {$currency_para['currency_out']}
<code>===============</code>
<code>Если Вы хотите изменить сумму платежа, просто отправьте новую сумму и она заменит предыдущую.</code>";	
		

						
					$buttons[] = [$this->buildInlineKeyBoardButton("Продолжить оплату", "goSaveMyAdress_"),];
					$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];

				} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.\n\nУкажите сумму числом!";
        }
				$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

				$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
    }
		
		
		
		private function goSaveMyAdress($data)
    {
        $chat_id = $this->getChatId($data);
        if ($this->setActionUser("step_1_address", $chat_id)) {
            $this->insertMyAdress($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
    }

       private function insertMyAdress($chat_id, $data)
    {
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE chto = {$user['chto']} and na_chto = {$user['na_chto']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
        $msg = "<code>Процедура обмена</code>
<code>===============</code>
У вас пока нет сохранённых кошельков <b>{$currency_para['currency_out']}</b>.
<code>===============</code>
<b>Шаг - 4:</b> Введите ваш <b>{$currency_para['currency_out']}</b> кошелёк, куда будет переведено <b>{$user['amount_crypto']}</b> {$currency_para['currency_out']}.
";
            $buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "nochaloBot_"),
            ];
        $this->botApiQuery("editMessageText", [
            'chat_id' => $chat_id,
            'text' => $msg,
            'message_id' => $this->getMessageId($data),
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons),
        ]);
		
				
        $this->notice($data['id']);
    }

     private function saveMyAddress($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE chto = {$user['chto']} and na_chto = {$user['na_chto']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/.*/', $msg)) {
		    $this->pdo->prepare("UPDATE dle_users SET my_address=? WHERE chat=? ")->execute(array($msg, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET time_api=? WHERE chat=? ")->execute(array(time(), $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET time_rez=? WHERE chat=? ")->execute(array(60, $chat_id));
/* 			$newAddress = $this->pdo->prepare("INSERT INTO users_address SET chat = :chat, address = :address");
            $newAddress->execute([
				'chat' => $chat_id,
                'address' => $msg
            ]); */
            
			$text_msg = "Адрес сохранён, идёт создание заявки...";
            sleep(3)
            $fields = $this->goObmen($data);
            $this->botApiQuery("sendMessage", $fields);
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.";
        }
				$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);
    }
	
	
   private function goObmen($data)
    {
       // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE chto = {$user['chto']} and na_chto = {$user['na_chto']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);

		$endOfDiscount = $user['time_api']; // дата окончания распродажи
        $now = time()-60*$user['time_rez']; // текущее время
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

			$msg = "<code>У тебя имеется активная заявка на пополнение баланса</code>
=========================
<b>Номер заказа:</b>
<code>{$user['zakaz_api']}</code>
<b>Карта для оплаты:</b>
<code>{$user['card_api']}</code>
[Нажми на номер карты что-бы скопировать]
<b>Сумма к оплате:</b>
<code>{$user['summ_api']} ₽</code>
=========================
";	
		
		$ch = curl_init();
		curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$get_set['tokenbot'].'/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
			'text' => $msg,
            'parse_mode' => 'html',
			'reply_markup' => $buttons2
			),
			));
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=? ")->execute(array($array['result']['message_id'], $chat_id));
		}		
		
		
		
		
		private function getUserAction($chat_id)
    {
        $last = $this->pdo->prepare("SELECT action FROM dle_users WHERE chat = :chat");
        $last->execute(['chat' => $chat_id]);
        $lastAction = $last->fetch();
        return !empty($lastAction['action']) ? $lastAction['action'] : false;
    }

    private function setActionUser($action, $chat_id)
    {
        $insertSql = $this->pdo->prepare("UPDATE dle_users SET action = :action WHERE chat = :chat");
        return $insertSql->execute(['action' => $action, 'chat' => $chat_id]);
    }
	
	    private function setCreateWallet($action, $chat_id)
    {
		
		        if ($action == 'BTC') {
		        $crypto_id = $this->api_btc_id;
				$wallet = 'btc_wallet = :btc_wallet';
				$wallet2 = 'btc_wallet';
				$qr = 'bitcoin';
				$wallet_id = 'btc_id = :btc_id';
				$wallet_id2 = 'btc_id';
		        } elseif ($action == 'LTC') {
		        $crypto_id = $this->api_ltc_id;
				$wallet = 'ltc_wallet = :ltc_wallet';
				$wallet2 = 'ltc_wallet';
				$qr = 'litecoin';
				$wallet_id = 'ltc_id = :ltc_id';
				$wallet_id2 = 'ltc_id';
		        } elseif ($action == 'ETH') {
		        $crypto_id = $this->api_eth_id;
				$wallet = 'eth_wallet = :eth_wallet';
				$wallet2 = 'eth_wallet';
				$qr = 'ethereum';
				$wallet_id = 'eth_id = :eth_id';
				$wallet_id2 = 'eth_id';
		        }
				$timestamp = time();
				$method = "POST";
				$path = '/v2/accounts/' . $crypto_id . '/addresses';
				$body = json_encode(array('name' => 'New receive address'));
				$message = $timestamp . $method . $path . $body;
				$signature = hash_hmac('SHA256', $message, $this->api_secret);
				$version = '2021-01-11';
				$headers = array(
				'CB-ACCESS-SIGN: ' . $signature,
				'CB-ACCESS-TIMESTAMP: ' . $timestamp,
				'CB-ACCESS-KEY: ' . $this->api_key,
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
				
        $insertSql = $this->pdo->prepare("UPDATE dle_users SET ".$wallet.", ".$wallet_id.", qr = :qr WHERE chat = :chat");
        return $insertSql->execute([$wallet2 => $arr['data']['address'], $wallet_id2 => $arr['data']['id'], 'qr' => 'https://www.bitcoinqrcodemaker.com/api/?style='.$qr.'&border=5&color=3&address='.$arr['data']['address'],  'chat' => $chat_id]);
    }
	
    private function setParamUser($param, $value, $chat_id)
    {
        $insertSql = $this->pdo->prepare("UPDATE dle_users SET " . $param . " = :value WHERE chat = :chat");
        return $insertSql->execute(['value' => $value, 'chat' => $chat_id]);
    }

		    private function NoInfo($data)
    {
        $this->notice($data['id'], "Дальше нет ничего интересного.", true);
    }
	
	private function setPdo()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=''"
        ];
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
    }
	
    private function getChatId($data)
    {
        if ($this->getType($data) == "callback_query") {
            return $data['callback_query']['message']['chat']['id'];
        }
        return $data['message']['chat']['id'];
    }

    private function getMessageId($data)
    {
        if ($this->getType($data) == "callback_query") {
            return $data['callback_query']['message']['message_id'];
        }
        return $data['message']['message_id'];
    }

    private function getText($data)
    {
        if ($this->getType($data) == "callback_query") {
            return $data['callback_query']['data'];
        }
        return $data['message']['text'];
    }

    private function getType($data)
    {
        if (isset($data['callback_query'])) {
            return "callback_query";
        } elseif (isset($data['message']['text'])) {
            return "message";
        } elseif (isset($data['message']['photo'])) {
            return "photo";
        } elseif (isset($data['message']['video'])) {
            return "video";
        } else {
            return false;
        }
    }

    public function buildInlineKeyboardButton($msg, $callback_data = '', $url = '')
    {
        $replyMarkup = [
            'text' => $msg,
        ];
        if ($url != '') {
            $replyMarkup['url'] = $url;
        } elseif ($callback_data != '') {
            $replyMarkup['callback_data'] = $callback_data;
        }
        return $replyMarkup;
    }

    public function buildInlineKeyBoard(array $options)
    {
        // собираем кнопки
        $replyMarkup = [
            'inline_keyboard' => $options,
        ];
        // преобразуем в JSON объект
        $encodedMarkup = json_encode($replyMarkup, true);
        // возвращаем клавиатуру
        return $encodedMarkup;
    }

    public function buildKeyboardButton($msg, $request_contact = false, $request_location = false)
    {
        $replyMarkup = [
            'text' => $msg,
            'request_contact' => $request_contact,
            'request_location' => $request_location,
        ];
        return $replyMarkup;
    }

    public function buildKeyBoard(array $options, $onetime = false, $resize = false, $selective = true)
    {
        $replyMarkup = [
            'keyboard' => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard' => $resize,
            'selective' => $selective,
        ];
        $encodedMarkup = json_encode($replyMarkup, true);
        return $encodedMarkup;
    }

    private function sendMessage($chat_id, $msg, $buttons = NULL)
    {
        $data_send = [
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'html',
			'disable_web_page_preview' => true
        ];
        if (!is_null($buttons) && is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
        return $this->botApiQuery("sendMessage", $data_send);
    }

    private function editMessageText($chat_id, $message_id, $msg, $buttons = NULL)
    {
        $data_send = [
            'chat_id' => $chat_id,
            'text' => $msg,
            'message_id' => $message_id,
            'parse_mode' => 'html',
			'disable_web_page_preview' => true
        ];
        if (!is_null($buttons) && is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
        return $this->botApiQuery("editMessageText", $data_send);
    }
	
    private function notice($cbq_id, $msg = "", $type = false)
    {
        $data = [
            'callback_query_id' => $cbq_id,
            'show_alert' => $type,
        ];

        if (!empty($msg)) {
            $data['text'] = $msg;
        }

        $this->botApiQuery("answerCallbackQuery", $data);
    }

    private function botApiQuery($method, $fields = array())
    {
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
        $ch = curl_init('https://api.telegram.org/bot' . $get_set['token'] . '/' . $method);
        curl_setopt_array($ch, array(
            CURLOPT_POST => count($fields),
            CURLOPT_POSTFIELDS => http_build_query($fields),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 10
        ));
        $r = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $r;
    }
}
?>