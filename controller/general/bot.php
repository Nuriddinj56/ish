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
		$this->id_bot = $_GET['id'];
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
		$this->api_eth_id = $coinbase['eth_id'];
		
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
                    }  elseif (preg_match("~^step_1_crypto$~", $actionUser)) {
                        $this->saveSummUserCrypto($msg, $data);
                    }  elseif (preg_match("~^step_1_card$~", $actionUser)) {
                        $this->saveMyCard($msg, $data);
                    } elseif (preg_match("~^step_1_address$~", $actionUser)) {
                        $this->saveMyAddress($msg, $data);
                    } elseif (preg_match("~^step_1_shopaddr$~", $actionUser)) {
                        $this->saveShopAddress($msg, $data);
                    } elseif (preg_match("~^step_1_crvivod$~", $actionUser)) {
                        $this->savecryptoVivod($msg, $data);
                    } elseif (preg_match("~^step_1_crvivodref$~", $actionUser)) {
                        $this->savecryptoVivodRef($msg, $data);
                    } elseif (preg_match("~^step_1_oneapi$~", $actionUser)) {
                        $this->saveSaveStepOne($msg, $data);
                    } elseif (preg_match("~^step_1_twoapi$~", $actionUser)) {
                        $this->saveSaveStepTwo($msg, $data);
                    } elseif (preg_match("~^step_1_threeapi$~", $actionUser)) {
                        $this->saveSaveStepThree($msg, $data);
                    } elseif (preg_match("~^step_1_fourapi$~", $actionUser)) {
                        $this->saveSaveStepFour($msg, $data);
                    } elseif (preg_match("~^step_1_fiveapi$~", $actionUser)) {
                        $this->saveSaveStepFive($msg, $data);
                    }  elseif (preg_match("~^step_6_contact$~", $actionUser)) {
                        $this->saveContact($msg, $data);
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
	
	
	private function Lichka($chat_id, $data, $text)
    {
		$chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_lichka", $chat_id);
        $param = explode("_", $data['data']);
		
		$msg = 'asdasdasdasdasd';
	
                $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

				$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
	

    }
	
private function otmena($data)
    {
        // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        // меняем дуйствие
        @$this->setActionUser("otmena", $chat_id);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		 $this->pdo->prepare("DELETE FROM webcron_schedule WHERE id=?")->execute(array($user['zakaz_number']));
		 $this->pdo->prepare("UPDATE transactions SET accert=? WHERE id=?")->execute(array(4, $user['zakaz_number']));
		 $this->pdo->prepare("UPDATE transactions SET status=? WHERE id=?")->execute(array('Отменён', $user['zakaz_number']));
		 $this->pdo->prepare("UPDATE transactions SET status_payclient=? WHERE id=?")->execute(array('Отменён', $user['zakaz_number']));
		 $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array('0', $chat_id));
		 $this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(0, $chat_id));
		 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array(NULL, $chat_id));
		 $this->pdo->prepare("UPDATE dle_users SET my_card=? WHERE chat=?")->execute(array(NULL, $chat_id));

		 $msg = "Ваша заявка успешно удалена.";
		
		$buttons[][] = $this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0");

			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
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
	    $this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$msg = $msg ?? '';
        $username = strtolower($data['message']['from']['username']);
		if ($username == '') {
		$login = 'Не указано';
		} else {
		$login = $username;	
		}
        if ($user->rowCount() == 0) {
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
        } else {
            // если пользователь есть то меняем ему действие
            @$this->setActionUser("start", $chat_id);
        }
		$this->setActionUser("start", $chat_id);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$msg = '<b>'.$get_set['name'].'</b>
=========================
'.$get_set['descr'].'
';
		
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Продолжить", "nochaloBot_"),
            ];
					
					$this->botApiQuery("sendMessage", [
                    'chat_id' => $chat_id,
					'parse_mode' => 'HTML',
					'text' => $msg,
					'reply_markup' => $this->buildInlineKeyBoard($buttons)
                ]
            );	
	
    
    }

        private function nochaloBot($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$api_search = $this->pdo->prepare("SELECT * FROM shop WHERE chat = :chat");
        $api_search->execute(['chat' => $chat_id]);
		
		$referal_search = $this->pdo->prepare("SELECT * FROM shop WHERE referal = :referal");
        $referal_search->execute(['referal' => $chat_id]);
		
		$totalapishop = $this->pdo->query("SELECT * FROM shop WHERE chat = '".$chat_id."'");
        $totalapishop = $totalapishop->fetchAll();
		
		$totalreferal = $this->pdo->query("SELECT * FROM shop WHERE referal = '".$chat_id."'");
        $totalreferal = $totalreferal->fetchAll();
		
        $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(0, $chat_id));
		if ($user['zakaz'] == 1) {
			
		$msg = 'У вас уже есть активная заявка.';
		if ($user['chto'] == 'VISA') {
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Перейти к заявке...", "activePayCrypto_"),
            ];
		} else {
		$buttons[] = [
                    $this->buildInlineKeyBoardButton("Перейти к заявке...", "activePayVisa_"),
            ];	
		}
		} else {
		$totalobmen = $this->pdo->query("SELECT * FROM transactions WHERE chat = '".$chat_id."'");
        $totalobmen = $totalobmen->fetchAll();
		$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		$bot_set = $this->pdo->query("SELECT * FROM bots WHERE id = ".$this->id_bot."");
        $bot_set = $bot_set->fetch(PDO::FETCH_ASSOC);
		$curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.telegram.org/bot' . $bot_set['token'] . '/getUserProfilePhotos?user_id='.$chat_id.'',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  ));
			      $response = curl_exec($curl);
				  curl_close($curl);
				  $jsonString = $response;

				  $x = json_decode($jsonString, true);
				  $id = $x["result"]["photos"][0][0]["file_id"];
				  if(!$user['file_id'] == $id){
				  $ch = curl_init('https://api.telegram.org/bot' . $bot_set['token'] . '/getFile');  
				  curl_setopt($ch, CURLOPT_POST, 1);  
				  curl_setopt($ch, CURLOPT_POSTFIELDS, array('file_id' => $id));
				  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				  curl_setopt($ch, CURLOPT_HEADER, false);
				  $res = curl_exec($ch);
				  curl_close($ch);
				  $res = json_decode($res, true);
				  if ($res['ok']) {
					  $src  = 'https://api.telegram.org/file/bot' . $bot_set['token'] . '/' . $res['result']['file_path'];
					  $dest = 'avatars/' . time() . '-' . basename($src);
					  copy($src, $dest);
					  $this->pdo->prepare("UPDATE dle_users SET file_id=? WHERE chat = ".$chat_id." ")->execute(array($id));
					  $this->pdo->prepare("UPDATE dle_users SET image=? WHERE chat = ".$chat_id." ")->execute(array($dest));
					  
				  }}
		
		$msg = '<b>'.$get_set['name'].'</b>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
'.$get_set['descr'].'
';
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Начать обмен", "goChange_"),
            ];
			
            $buttons[] = [
                    $this->buildInlineKeyBoardButton("Ваши заявки на обмен [".count($totalobmen).']', "MyTranz_"),
            ];
			if ($api_search->rowCount() > 0) {
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Управление магазинами [".count($totalapishop)."]", "kabinetShop_"),
            ];
			}
			if ($referal_search->rowCount() > 0) {
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Кабинет реферала [".count($totalreferal)."]", "kabinetReferal_"),
            ];
			}
/* 			$buttons[] = [
                    $this->buildInlineKeyBoardButton("API Для бизнеса", "apiSystems_"),
            ]; */
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Обратная связь", "contacts_"),
            ];
		}
       			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        $this->notice($data['id'], "Главное меню");
		}
		
		
		private function contacts($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        $obj = $data['data'];
        // разбиваем в массив
        $param = explode("_", $obj);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
		$msg = ''.$get_set['contacts'].'';
		
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        
    }
		
		
function num_word($value, $words, $show = true) 
{
	$num = $value % 100;
	if ($num > 19) { 
		$num = $num % 10; 
	}
	
	$out = ($show) ?  $value . ' ' : '';
	switch ($num) {
		case 1:  $out .= $words[0]; break;
		case 2: 
		case 3: 
		case 4:  $out .= $words[1]; break;
		default: $out .= $words[2]; break;
	}
	
	return $out;
}


 private function kabinetReferal($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		$this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(1, $chat_id));
		
        $totalreferal = $this->pdo->query("SELECT * FROM shop WHERE referal = '".$chat_id."'");
        $totalreferal = $totalreferal->fetchAll();
        
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$all_cash = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions_referals WHERE chat = '".$chat_id."'");
		$all_cash =  $all_cash->fetch(PDO::FETCH_ASSOC);
		if (!$all_cash['sum_rub']):
		$all_cash['sum_rub'] = 0;
		endif;
		
        $value = $user['balance_referal'];
		$words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
        $values = $all_cash['sum_rub'];
		$wordss = $this->num_word($values, array('рубль', 'рубля', 'рублей'));
		
		
		    $get_stat_trans = $this->pdo->query("SELECT COUNT(*) AS count FROM transactions_referals WHERE chat = ".$chat_id." ");			
			$get_stat_trans =  $get_stat_trans->fetch(PDO::FETCH_ASSOC);
			if (!$get_stat_trans['count']){
			$get_stat_trans['count'] = 0;
			$get_stat_trans['count'] = 0;
			}
			$get_stat_vivod = $this->pdo->query("SELECT COUNT(*) AS count FROM conclusion_referals WHERE chat = ".$chat_id." ");			
			$get_stat_vivod =  $get_stat_vivod->fetch(PDO::FETCH_ASSOC);
			if (!$get_stat_vivod['count']){
			$get_stat_vivod['count'] = 0;
			$get_stat_vivod['count'] = 0;
			}
		
		$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
            $msg = '<b>'.$get_set['page_two'].'</b>
=========================
┌ Твой баланс: <code>'.$words.'</code>
├ Рефералов: <code>'.count($totalreferal).'</code>
└ Заработано в общем: <code>'.$wordss.'</code>
=========================';
            $buttons[] = [
                    $this->buildInlineKeyBoardButton('Пополнения [' . $get_stat_trans['count'].']', "showTransRef_"),
					$this->buildInlineKeyBoardButton('Выплаты [' . $get_stat_vivod['count'].']', "showCashBackRef_"),
            ];
			if ($user['balance_referal'] < 500){
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('Вывести средства [' . $user['balance_referal'].' руб]', "payFuck_"),
            ];
			} else {
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('Вывести средства [' . $user['balance_referal'].' руб]', "vivodRef_".$param[1]),
            ];	
			}
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "nochaloBot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}
		
		
		private function vivodRef($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        $obj = $data['data'];
        // разбиваем в массив
        $param = explode("_", $obj);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		
		$msg = 'Вывод средств с баланса магазина - <b>'.$get_shop['name'].'</b>
<code>=========================</code>
<b>Выберите валюту, куда будем выводить средства:</b>
		';
		$buttons[] = [
                    $this->buildInlineKeyBoardButton('На Российскую карту [Visa/MasterCard/МИР]', "cardVivodRef_".$param[1].'_VISA'),
            ];
		$buttons[] = [
                    $this->buildInlineKeyBoardButton('Bitcoin', "cryptoVivodRef_".$param[1].'_BTC'),
					$this->buildInlineKeyBoardButton('Litecoin', "cryptoVivodRef_".$param[1].'_LTC'),
            ];
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('Etherium', "cryptoVivodRef_".$param[1].'_ETH'),
					$this->buildInlineKeyBoardButton('Tether (USDT)', "cryptoVivodRef_".$param[1].'_USDT'),
            ];
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "kabinetReferal_"),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        
    }
	
	
	
	private function cryptoVivodRef($data)
    {
        $chat_id = $this->getChatId($data);
        @$this->setActionUser("step_1_crvivodref", $chat_id);
        $this->insertcryptoVivodRef($chat_id, $data);

    }

       private function insertcryptoVivodRef($chat_id, $data)
    {
		
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		
		
		$currency = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$param[2]."' ");
        $currency = $currency->fetch(PDO::FETCH_ASSOC);
		
        $price = $user['balance_referal'];
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price * $kurs;
		
		$price = $user['balance_referal'];
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price / $kurs;
		$scheck = number_format($itog_bez_proc, 8, '.', '');
		$this->pdo->prepare("UPDATE dle_users SET crypto_sum=? WHERE chat=? ")->execute(array($scheck, $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET rub_sum=? WHERE chat=? ")->execute(array($user['balance_referal'], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET crypto_cur=? WHERE chat=? ")->execute(array($param[2], $chat_id));
		$scheckcurs = number_format($currency['kurs'], 2, '.', '');
				$msg = 'Вывод средств с реферального баланса
<code>=========================</code>
Баланс: <b>'.$user['balance_referal'].'</b>
Курс '.$param[2].': <b>'.$scheckcurs.'</b> руб.
Будет выплачено: <b>'.$scheck.'</b> '.$param[2].'.
<code>=========================</code>
<b>Введите адрес вашего <b>'.$param[2].'</b> кошелька:</b>
		';
	
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "kabinetReferal_"),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
        $this->botApiQuery("editMessageText", [
            'chat_id' => $chat_id,
            'text' => $msg,
            'message_id' => $this->getMessageId($data),
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons),
        ]);
    }

 private function savecryptoVivodRef($msg, $data)
    {
        $chat_id = $this->getChatId($data);
	
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
	
		
		$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Магазины' and active = '1'");
        $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		
		 $cur = $this->pdo->query("SELECT * FROM `currency_api` WHERE nominal = '".$user['crypto_cur']."' ");
		 $cur = $cur->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/^[-a-zA-Z0-9]+$/', $msg)) {
		$this->pdo->prepare("UPDATE dle_users SET balance_referal=? WHERE chat=? ")->execute(array(0, $chat_id));
			
			
	    $API_KEY = $coinbase['api_key'];
	    $API_SECRET = $coinbase['api_secret']; 
		$USER_ID = $cur['user_id'];
	    $timestamp = time();
	    $method = "POST";
	    $path = '/v2/accounts/' . $USER_ID . '/transactions';
	    $body = json_encode(array(
	    'type' => 'send',
	    'to' => $msg,
	    'amount' => $user['crypto_sum'],
	    'currency' => $user['crypto_cur']
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
			
	    $text_msg = "Ошибка автоматической выплаты, администратор уведомлён и скоро вам переведут ваши средства, приносим извинения.";
		
		    $newAddress = $this->pdo->prepare("INSERT INTO conclusion_referals SET chat = :chat, requisites = :requisites, status = :status, sum_crypto = :sum_crypto, sum_rub = :sum_rub, currency = :currency, date = :date, error = :error");
            $newAddress->execute([
				'chat' => $chat_id,
                'requisites' => $msg,
				'status' => 'В ожидании',
				'sum_crypto' => $user['crypto_sum'],
				'sum_rub' => $user['rub_sum'],
				'currency' => $user['crypto_cur'],
				'date' => time(),
				'error' => $arr['errors'][0]['message']
            ]);	
            $idZakaz = $this->pdo->lastInsertId();
		    $value = $user['rub_sum'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
			
		$time_add = date('Y-m-d H:i:s', time());
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'Cегодня в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		$text_rew = '❗️ВНИМАНИЕ❗️Выплата по заявке <b>'. $idZakaz.'</b> завершилась неудачно. 
Текст ошибки <b>'.$arr['errors'][0]['message'].'</b>.
<code>===============</code>
Заявка: # <b>'.$idZakaz.'</b>
Сумма: '.$words.'
Дата: <b>'.$datetime_create.'</b>
Статус: <b>В ожидании</b>		
';
		
        $admin_notify = $this->pdo->query("SELECT * FROM dle_users WHERE chat = ".$chat_id." and user_group = '1'");
        while ($row = $admin_notify->fetch()) {
		$data_sends = [
            'chat_id' => $row['chat'],
            'text' => $text_rew,
            'parse_mode' => 'html',
        ];	
		$this->botApiQuery("sendMessage", $data_sends);
		 }
		
	} else {
		
		$text_msg = "Операция прошла успешно, <b>".$user['crypto_sum']."</b> ".$user['crypto_cur']." отправлены на ваш кошелёк:
".$msg;
		
		    $newAddress = $this->pdo->prepare("INSERT INTO conclusion_shops SET chat = :chat, requisites = :requisites, status = :status, sum_crypto = :sum_crypto, currency = :currency, date = :date");
            $newAddress->execute([
				'chat' => $chat_id,
                'requisites' => $msg,
				'status' => 'Выплачено',
				'sum_crypto' => $user['crypto_sum'],
				'currency' => $user['crypto_cur'],
				'date' => time()
            ]);	
		}
		
	
		} else {
            $text_msg = "Не верный кошелёк, укажите правильно.";
        }
		
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "kabinetReferal_"),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	
	
	
		
		
		
		
		
		private function showCashBackRef($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
		
		if ($param[1] == '') {
		$pageno = 1;	
		} else {
        $pageno = $param[1];
		}
		
		$size_page = 5;
        $offset = ($pageno-1) * $size_page;
        
		$total = $this->pdo->query("SELECT * FROM conclusion_referals WHERE chat = ".$chat_id." ");
        $total = $total->fetchAll();
		
		$total_rows = count($total);
        $total_pages = ceil($total_rows / $size_page);
		
		
		$totals = $this->pdo->query("SELECT * FROM conclusion_referals WHERE chat = ".$chat_id." ORDER BY id DESC LIMIT $offset, $size_page");
        $totals = $totals->fetchAll();
		
		$msg .= 'Кабинет реферала
=========================
Ваши заявки на вывод средств:
<code>=========================</code>
';
if (empty($totals)):

$msg .= 'Запросов ещё небыло.';

else:

foreach ($totals as $key => $values):
$time_add = date('Y-m-d H:i:s', $values['date']);
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		
		

			$value = $values['sum_rub'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
		
		if ($values['currency'] == 'VISA'){
		
		$summa = '<b>'.$sum.'</b>';		
			
		} else {
			
		$summa = $values['sum_crypto']. ' ' . $values['currency'] . ' ' . '
Сумма в рублях: <b>'.$sum.'</b>'
		;
		
		}
		
$msg .= 'Заявка: # <b>'.$values['id'].':</b>
Сумма: '.$summa.'
Дата: <b>'.$datetime_create.'</b>
Статус: <b>'.$values['status'].'</b>
<code>=========================</code>
';

endforeach;
if ($total_pages > 1) {
         $prev = ($pageno <= 1) ? $total_pages - 0 : $pageno - 1;
         $next = ($pageno >= $total_pages) ? 1 : $pageno + 1;
			
            $buttons[] = [
                $this->buildInlineKeyBoardButton('<<', 'showCashBackRef_'. $prev),
                $this->buildInlineKeyBoardButton(($pageno) . ' из ' . $total_pages, '' . $total_pages),
                $this->buildInlineKeyBoardButton('>>', 'showCashBackRef_'. $next),
            ];
		 }
endif;
            
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "kabinetReferal_"),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}


		
		 private function kabinetShop($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		$this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=? ")->execute(array(1, $chat_id));
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE chat = '".$chat_id."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		$totalapishop = $this->pdo->query("SELECT * FROM shop WHERE chat = '".$chat_id."'");
        $totalapishop = $totalapishop->fetchAll();
		$all_balance_btc = $this->pdo->query("SELECT SUM(BTC) AS BTC FROM shop WHERE chat = '".$chat_id."'");
		$all_balance_btc =  $all_balance_btc->fetch(PDO::FETCH_ASSOC);
		if (!$all_balance_btc['BTC']):
		$all_balance_btc['BTC'] = 0;
		endif;
		$all_balance_ltc = $this->pdo->query("SELECT SUM(LTC) AS LTC FROM shop WHERE chat = '".$chat_id."'");
		$all_balance_ltc =  $all_balance_ltc->fetch(PDO::FETCH_ASSOC);
		if (!$all_balance_ltc['LTC']):
		$all_balance_ltc['LTC'] = 0;
		endif;
				$all_balance_eth = $this->pdo->query("SELECT SUM(ETH) AS ETH FROM shop WHERE chat = '".$chat_id."'");
		$all_balance_eth =  $all_balance_eth->fetch(PDO::FETCH_ASSOC);
		if (!$all_balance_eth['ETH']):
		$all_balance_eth['ETH'] = 0;
		endif;
				$all_balance_usdt = $this->pdo->query("SELECT SUM(USDT) AS USDT FROM shop WHERE chat = '".$chat_id."'");
		$all_balance_usdt =  $all_balance_usdt->fetch(PDO::FETCH_ASSOC);
		if (!$all_balance_usdt['USDT']):
		$all_balance_usdt['USDT'] = 0;
		endif;
		
        $BTC = $all_balance_btc['BTC'];
		$LTC = $all_balance_ltc['LTC'];
		$ETH = $all_balance_eth['ETH'];
		$USDT = $all_balance_usdt['USDT'];
		
		
		
	    $currencyBTC = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'BTC' ");
        $currencyBTC = $currencyBTC->fetch(PDO::FETCH_ASSOC);
		$priceBTC = $BTC;
		$kursBTC = $currencyBTC['kurs'];
		$itog_bez_procBTC = $priceBTC * $kursBTC;
		$scheckBTC = number_format($itogBTC, 2, '.', '');
		
		$currencyLTC = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'LTC' ");
        $currencyLTC = $currencyLTC->fetch(PDO::FETCH_ASSOC);
		$priceLTC = $LTC;
		$kursLTC = $currencyLTC['kurs'];
		$itog_bez_procLTC = $priceLTC * $kursLTC;
		$scheckLTC = number_format($itog_bez_procLTC, 2, '.', '');
		
		$currencyETH = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'ETH' ");
        $currencyETH = $currencyETH->fetch(PDO::FETCH_ASSOC);
		$priceETH = $ETH;
		$kursETH = $currencyETH['kurs'];
		$itog_bez_procETH = $priceETH * $kursETH;
		$scheckETH = number_format($itog_bez_procETH, 2, '.', '');
		
		$currencyUSDT = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'USDT' ");
        $currencyUSDT = $currencyUSDT->fetch(PDO::FETCH_ASSOC);
		$priceUSDT = $USDT;
		$kursUSDT = $currencyUSDT['kurs'];
		$itog_bez_procUSDT = $priceUSDT * $kursUSDT;
		$scheckUSDT = number_format($itog_bez_procUSDT, 2, '.', '');
		
		$wordsLTC = $this->num_word($scheckLTC, array('рубль', 'рубля', 'рублей'));
		$wordsBTC = $this->num_word($scheckBTC, array('рубль', 'рубля', 'рублей'));
		$wordsETH = $this->num_word($scheckETH, array('рубль', 'рубля', 'рублей'));
		$wordsUSDT = $this->num_word($scheckUSDT, array('рубль', 'рубля', 'рублей'));
				$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
		
            $msg = '<b>'.$get_set['page_one'].'</b>
=========================
┌ BTC: <code>'.$BTC.' ('.$wordsBTC.')*</code>
├ LTC: <code>'.$LTC.' ('.$wordsLTC.')*</code>
├ ETH: <code>'.$ETH.' ('.$wordsETH.')*</code>
├ USDT: <code>'.$USDT.' ('.$wordsUSDT.')*</code>
└ Магазинов: <code>'.count($totalapishop).'</code>
=========================
Выберите нужный магазин из списка ниже:';
            $date_now = date('Y-m-d');
			$res_data = $this->pdo->query("SELECT * FROM shop WHERE chat = '".$chat_id."' ORDER BY id DESC");
			while ($row = $res_data->fetch()) {
		    $all_cash = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE id_shop = '".$row['id']."' and status_payclient = 'Оплата получена' and date = '".$date_now."' ");
		    $all_cash =  $all_cash->fetch(PDO::FETCH_ASSOC);
		    if (!$all_cash['out_summ']):
		    $all_cash['out_summ'] = 0;
		    endif;
				
				
				$buttons[] = [
                    $this->buildInlineKeyBoardButton($row['name'] . ' ['. $all_cash['out_summ'].' ₽]', "showShop_".$row['id']),
            ];
				
			}
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "nochaloBot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}
		
		
		
		
		
		private function showTransRef($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
		
		if ($param[1] == '') {
		$pageno = 1;	
		} else {
        $pageno = $param[1];
		}
		
		$size_page = 5;
        $offset = ($pageno-1) * $size_page;
        
		$total = $this->pdo->query("SELECT * FROM transactions_referals WHERE chat = ".$chat_id." ");
        $total = $total->fetchAll();
		
		$total_rows = count($total);
        $total_pages = ceil($total_rows / $size_page);
		
		
		$totals = $this->pdo->query("SELECT * FROM transactions_referals WHERE chat = ".$chat_id." ORDER BY id DESC LIMIT $offset, $size_page");
        $totals = $totals->fetchAll();
		
		
		$msg .= 'Реферальный кабинет
=========================
Список твоих пополнений:
<code>=========================</code>
';
if (empty($totals)):

$msg .= 'Транзакций ещё небыло.';

else:

foreach ($totals as $key => $values):
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$values['id_shop']."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
$time_add = date('Y-m-d H:i:s', $values['date']);
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		
		

			$value = $values['sum_rub'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
		
		
$msg .= '# <code>'.$values['id'].'</code>: на сумму <b>'.$sum.'</b>
Дата: '.$datetime_create.'
Реферал: '.$get_shop['name'].'
Процент: '.$get_shop['percent_referal'].'%
<code>=========================</code>
';

endforeach;
if ($total_pages > 1) {
         $prev = ($pageno <= 1) ? $total_pages - 0 : $pageno - 1;
         $next = ($pageno >= $total_pages) ? 1 : $pageno + 1;
			
            $buttons[] = [
                $this->buildInlineKeyBoardButton('<<', 'showTransRef_'. $prev),
                $this->buildInlineKeyBoardButton(($pageno) . ' из ' . $total_pages, '' . $total_pages),
                $this->buildInlineKeyBoardButton('>>', 'showTransRef_'. $next),
            ];
		 }
endif;
            
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "kabinetReferal_"),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}
		
		
		
		
		private function showShop($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		$hideIcon = $get_shop['vivod_ico'] ? 'Моментальный' : 'Накопительный';
            
			
			$get_stat_trans = $this->pdo->query("SELECT COUNT(*) AS count FROM transactions WHERE id_shop = ".$param[1]." ");			
			$get_stat_trans =  $get_stat_trans->fetch(PDO::FETCH_ASSOC);
			if (!$get_stat_trans['count']){
			$get_stat_trans['count'] = 0;
			$get_stat_trans['count'] = 0;
			}
			$get_stat_vivod = $this->pdo->query("SELECT COUNT(*) AS count FROM conclusion_shops WHERE id_shop = ".$param[1]." ");			
			$get_stat_vivod =  $get_stat_vivod->fetch(PDO::FETCH_ASSOC);
			if (!$get_stat_vivod['count']){
			$get_stat_vivod['count'] = 0;
			$get_stat_vivod['count'] = 0;
			}
		
		
		$totalpaid = $this->pdo->query("SELECT * FROM conclusion_shops WHERE id_shop = '".$param[1]."' order by date desc limit 3");
        $totalpaid = $totalpaid->fetchAll();
		$month_list = array(
		1  => 'январь',
		2  => 'февраль',
		3  => 'март',
		4  => 'апрель',
		5  => 'май', 
		6  => 'июнь',
		7  => 'июль',
		8  => 'август',
		9  => 'сентябрь',
		10 => 'октябрь',
		11 => 'Ноябрь',
		12 => 'декабрь'
		);
		
		$top_data = $month_list[date('n')];
		
		
		$result = $this->pdo->query("SELECT * FROM transactions WHERE id_shop = '".$param[1]."'"); // Статус - 2 успешный платеж, можно формировать по своим данным в таблицах
    
    while ($row = $result->fetch()) {
    $u_balance = $u_balance + $row['out_summ']; // За все время

    $you_date_day = date('d.m.Y', $row['date_pay']); // Дата с бд
    $now_date_day = date('d.m.Y'); // Текущая дата
    $you_date_unix_day = strtotime($you_date_day);
    $now_date_unix_day = strtotime($now_date_day);

    $you_date_week = date('W.m.Y', $row['date_pay']); // Дата с бд
    $now_date_week = date('W.m.Y'); // Текущая дата
    $you_date_unix_week = strtotime($you_date_week);
    $now_date_unix_week = strtotime($now_date_week);

    $you_date_month = date('M.Y', $row['date_pay']); // Дата с бд
    $now_date_month = date('M.Y'); // Текущая дата
    $you_date_unix_month = strtotime($you_date_month);
    $now_date_unix_month = strtotime($now_date_month);

    if ($you_date_unix_day == $now_date_unix_day){ // За текущий день
        $u_balance_day = $u_balance_day + $row['out_summ'];
    }
    if ($you_date_unix_week == $now_date_unix_week){ // Зе текущую неделю
        $u_balance_week = $u_balance_week + $row['out_summ'];
    }
    if ($you_date_unix_month == $now_date_unix_month){ // За текущий месяц
        $u_balance_month = $u_balance_month + $row['out_summ'];
    }
	}
	//=======Заработано за текущий день======//
	if (!$u_balance_day){
		$money_today = 0;
	} else {
		$money_today = $u_balance_day;	
	}
	//=======Заработано за текущую неделю======//
	if (!$u_balance_week){
		$money_week = 0;
	} else {
		$money_week = $u_balance_week;	
	}
	//=======Заработано за текущий месяц======//
	if (!$u_balance_month){
		$money_month = 0;
	} else {
		$money_month = $u_balance_month;	
	}
	$date_yestoday = date('d',strtotime("-1 days"));
	$date_now = date('Y-m-d',strtotime("-1 days"));
		$money_yestoday = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE id_shop = '".$param[1]."' AND date = '".$date_now."'");
		$money_yestoday =  $money_yestoday->fetch(PDO::FETCH_ASSOC);
		if (!$money_yestoday['out_summ']):
		$money_yestoday['out_summ'] = 0;
		endif;
		
		$all_balance_btc = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_btc =  $all_balance_btc->fetch(PDO::FETCH_ASSOC);

		$all_balance_ltc = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_ltc =  $all_balance_ltc->fetch(PDO::FETCH_ASSOC);
		
		$all_balance_eth = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_eth =  $all_balance_eth->fetch(PDO::FETCH_ASSOC);
		
		$all_balance_usdt = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_usdt =  $all_balance_usdt->fetch(PDO::FETCH_ASSOC);
		
		
        $BTC = $all_balance_btc['BTC'];
		$LTC = $all_balance_ltc['LTC'];
		$ETH = $all_balance_eth['ETH'];
		$USDT = $all_balance_usdt['USDT'];
		
		
		$currencyBTC = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'BTC' ");
        $currencyBTC = $currencyBTC->fetch(PDO::FETCH_ASSOC);
		$priceBTC = $BTC;
		$kursBTC = $currencyBTC['kurs'];
		$itog_bez_procBTC = $priceBTC * $kursBTC;
		$scheckBTC = number_format($itogBTC, 2, '.', '');
		
		$currencyLTC = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'LTC' ");
        $currencyLTC = $currencyLTC->fetch(PDO::FETCH_ASSOC);
		$priceLTC = $LTC;
		$kursLTC = $currencyLTC['kurs'];
		$itog_bez_procLTC = $priceLTC * $kursLTC;
		$scheckLTC = number_format($itog_bez_procLTC, 2, '.', '');
		
		$currencyETH = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'ETH' ");
        $currencyETH = $currencyETH->fetch(PDO::FETCH_ASSOC);
		$priceETH = $ETH;
		$kursETH = $currencyETH['kurs'];
		$itog_bez_procETH = $priceETH * $kursETH;
		$scheckETH = number_format($itog_bez_procETH, 2, '.', '');
		
		$currencyUSDT = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'USDT' ");
        $currencyUSDT = $currencyUSDT->fetch(PDO::FETCH_ASSOC);
		$priceUSDT = $USDT;
		$kursUSDT = $currencyUSDT['kurs'];
		$itog_bez_procUSDT = $priceUSDT * $kursUSDT;
		$scheckUSDT = number_format($itog_bez_procUSDT, 2, '.', '');
		
		$wordsLTC = $this->num_word($scheckLTC, array('рубль', 'рубля', 'рублей'));
		$wordsBTC = $this->num_word($scheckBTC, array('рубль', 'рубля', 'рублей'));
		$wordsETH = $this->num_word($scheckETH, array('рубль', 'рубля', 'рублей'));
		$wordsUSDT = $this->num_word($scheckUSDT, array('рубль', 'рубля', 'рублей'));
		
		
		
            $msg .= 'Магазин - <b>'.$get_shop['name'].'</b>
=========================
<b>Баланс магазина:</b>
┌ BTC: <code>'.$BTC.' ('.$wordsBTC.')*</code>
├ LTC: <code>'.$LTC.' ('.$wordsLTC.')*</code>
├ ETH: <code>'.$ETH.' ('.$wordsETH.')*</code>
└ USDT: <code>'.$USDT.' ('.$wordsUSDT.')*</code>
<b>Статистика финансов ('.$top_data.')</b>
┌ За <b>'.date('d').'</b> число: <code>'.$money_today.' ₽</code>
├ За <b>'.$date_yestoday.'</b> число, вчерашний день: <code>'.$money_yestoday['out_summ'].' ₽</code>
├ За <b>текущую неделю</b> c понедельника: <code>'.$money_week.' ₽</code>
└ За <b>'.$top_data.'</b> с 1 числа: <code>'.$money_month.' ₽</code>
=========================';
if ($get_shop['currency_out'] == NULL){
			$valuta = 'Не выбрана';
		} else {
			$valuta = $get_shop['currency_out'];
		}
		
		if ($get_shop['address_out'] == NULL){
			$address = 'Не указан';
		} else {
			$address = $get_shop['address_out'];
		}
if ($get_shop['vivod'] == 'Моментальный'){
			$viv = '
Режим выплат: <b>Моментальный</b>, каждый платёж клиента моментально, с вычетом всех комиссий (обменника и биржи), пересылается на ваш криптовалютный счёт.';
		} else {
			$viv = '
Режим выплат: <b>Накопительный</b>, все средства оплаченные клиентами копятся на ваших счетех обменника, далее вы сможете их в любой момент вывести.';
		}
		$msg .= $viv;
if ($get_shop['vivod'] == 'Моментальный'){
$msg .= '
<code>=========================</code>
<b>Валюта выплаты:</b> ' . $valuta .'
<b>Кошелёк:</b> ' . $address;
}
$buttons[] = [
                    $this->buildInlineKeyBoardButton('Транзакции [' . $get_stat_trans['count'].']', "showTransShop_".$param[1].'_1'),
					$this->buildInlineKeyBoardButton('Выплаты [' . $get_stat_vivod['count'].']', "showCashBackShop_".$param[1].'_1'),
            ];
			
			        $buttons[] = [
		$this->buildInlineKeyBoardButton('Режим выплат: '.$hideIcon, "whatPays_".$param[1].'_'.$get_shop['vivod_ico']),
        ];
		
		
		if ($get_shop['vivod'] == 'Моментальный'){
			 $buttons[] = [
		$this->buildInlineKeyBoardButton('Валюта вывода: '.$valuta, "whatPaysCur_".$param[1]),
        ];
		$buttons[] = [
		$this->buildInlineKeyBoardButton('Кошелёк: '.$address, "goShopAddress_".$param[1]),
        ];
		}
		
		
			
	
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('Вывести средства', "vivod_".$param[1]),
            ];	
			
            
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "kabinetShop_"),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}
		
		
			 private function payFuck($data)
    {
        $this->notice($data['id'], "Сумма на балансе меньше минимально указанной обменником, для вывода.", true);
    }
	
	
	
	private function vivod($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        $obj = $data['data'];
        // разбиваем в массив
        $param = explode("_", $obj);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		
		
		$all_balance_btc = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_btc =  $all_balance_btc->fetch(PDO::FETCH_ASSOC);

		$all_balance_ltc = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_ltc =  $all_balance_ltc->fetch(PDO::FETCH_ASSOC);
		
		$all_balance_eth = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_eth =  $all_balance_eth->fetch(PDO::FETCH_ASSOC);
		
		$all_balance_usdt = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
		$all_balance_usdt =  $all_balance_usdt->fetch(PDO::FETCH_ASSOC);
		
		
        $BTC = $all_balance_btc['BTC'];
		$LTC = $all_balance_ltc['LTC'];
		$ETH = $all_balance_eth['ETH'];
		$USDT = $all_balance_usdt['USDT'];
		
		
		$currencyBTC = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'BTC' ");
        $currencyBTC = $currencyBTC->fetch(PDO::FETCH_ASSOC);
		$priceBTC = $BTC;
		$kursBTC = $currencyBTC['kurs'];
		$itog_bez_procBTC = $priceBTC * $kursBTC;
		$scheckBTC = number_format($itogBTC, 2, '.', '');
		
		$currencyLTC = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'LTC' ");
        $currencyLTC = $currencyLTC->fetch(PDO::FETCH_ASSOC);
		$priceLTC = $LTC;
		$kursLTC = $currencyLTC['kurs'];
		$itog_bez_procLTC = $priceLTC * $kursLTC;
		$scheckLTC = number_format($itog_bez_procLTC, 2, '.', '');
		
		$currencyETH = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'ETH' ");
        $currencyETH = $currencyETH->fetch(PDO::FETCH_ASSOC);
		$priceETH = $ETH;
		$kursETH = $currencyETH['kurs'];
		$itog_bez_procETH = $priceETH * $kursETH;
		$scheckETH = number_format($itog_bez_procETH, 2, '.', '');
		
		$currencyUSDT = $this->pdo->query("SELECT * FROM currency_api WHERE nominal = 'USDT' ");
        $currencyUSDT = $currencyUSDT->fetch(PDO::FETCH_ASSOC);
		$priceUSDT = $USDT;
		$kursUSDT = $currencyUSDT['kurs'];
		$itog_bez_procUSDT = $priceUSDT * $kursUSDT;
		$scheckUSDT = number_format($itog_bez_procUSDT, 2, '.', '');
		
		$wordsLTC = $this->num_word($scheckLTC, array('рубль', 'рубля', 'рублей'));
		$wordsBTC = $this->num_word($scheckBTC, array('рубль', 'рубля', 'рублей'));
		$wordsETH = $this->num_word($scheckETH, array('рубль', 'рубля', 'рублей'));
		$wordsUSDT = $this->num_word($scheckUSDT, array('рубль', 'рубля', 'рублей'));
		
		
					if ($scheckBTC < $get_shop['min_sum']){
		$balance = $get_shop['BTC'] . ' BTC';
		} elseif ($param[2] == 'LTC'){
			$balance = $get_shop['LTC'] . ' LTC';
		} elseif ($param[2] == 'ETH'){
			$balance = $get_shop['ETH'] . ' ETH';
		} elseif ($param[2] == 'USDT'){
			$balance = $get_shop['USDT'] . ' USDT';
		}
		
		
		$msg = 'Вывод средств с баланса магазина - <b>'.$get_shop['name'].'</b>
<code>=========================</code>
<b>Выберите валюту, куда будем выводить средства <i>(Отображены валюты на которых имеется минимальный баланс для вывода)</i>:</b>
		';
		
		if ($scheckBTC > $get_shop['min_sum']){
		$buttons[] = [
                    $this->buildInlineKeyBoardButton('Bitcoin ' . $BTC . ' ('.$wordsBTC.')', "cryptoVivod_".$param[1].'_BTC'),
            ];
		} 
		if ($scheckLTC > $get_shop['min_sum']){
			$buttons[] = [
			        $this->buildInlineKeyBoardButton('Litecoin ' . $LTC . ' ('.$wordsLTC.')', "cryptoVivod_".$param[1].'_LTC'),
            ];
		}
		
		if ($scheckETH > $get_shop['min_sum']){
			$buttons[] = [
			        $this->buildInlineKeyBoardButton('Etherium ' . $ETH . ' ('.$wordsETH.')', "cryptoVivod_".$param[1].'_ETH'),
			];
			
		} 
		
		if ($scheckUSDT > $get_shop['min_sum']){
						$buttons[] = [
			        $this->buildInlineKeyBoardButton('Tether (USDT) ' . $USDT . ' ('.$wordsUSDT.')', "cryptoVivod_".$param[1].'_USDT'),
			];
		}

          $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        
    }
	
	
	
		
		private function whatPaysCur($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        $obj = $data['data'];
        // разбиваем в массив
        $param = explode("_", $obj);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		if ($get_shop['currency_out'] == NULL){
			$valuta = 'Не выбрана';
		} else {
			$valuta = $get_shop['currency_out'];
		}
		
		
		$msg = 'Выберите валюту в которой хотите получать средства.
<code>=========================</code>
<b>Сейчас валюта для вывода:</b> ' . $valuta .'
		';
		$buttons[] = [
                    $this->buildInlineKeyBoardButton('BTC', "cryptoOn_".$param[1].'_BTC'),
					$this->buildInlineKeyBoardButton('LTC', "cryptoOn_".$param[1].'_LTC'),
            ];
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('ETH', "cryptoOn_".$param[1].'_ETH'),
					$this->buildInlineKeyBoardButton('USDT', "cryptoOn_".$param[1].'_USDT'),
            ];
          $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        
    }
	
	private function cryptoOn($data)
    {
				// получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        // меняем действие
        @$this->setActionUser("show_pokupki", $chat_id);
        // парсим callback_data
        $param = explode("_", $data['data']);
		
		$this->pdo->prepare("UPDATE shop SET currency_out=? WHERE id=? ")->execute(array($param[2], $param[1]));
		$this->pdo->prepare("UPDATE shop SET address_out=? WHERE id=? ")->execute(array(NULL, $param[1]));
		
		$msg = "Выплаты на '".$param[2]."' успешно <b>включены</b>. Не забудьте указать кошелёк для выплат.";
		$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
		
	   
        // отправляем в метод данные
        $this->editMessageText($chat_id, $message_id, $msg, $buttons);
        // уведомляем
        $this->notice($data['id']);
		
}





private function cryptoVivod($data)
    {
        $chat_id = $this->getChatId($data);
        @$this->setActionUser("step_1_crvivod", $chat_id);
        $this->insertcryptoVivod($chat_id, $data);

    }

       private function insertcryptoVivod($chat_id, $data)
    {
		
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET shop_red=? WHERE chat=?")->execute(array($param[1], $chat_id));


		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		if ($param[2] == 'BTC'){
		$balance = $get_shop['BTC'] . ' BTC';
		} elseif ($param[2] == 'LTC'){
			$balance = $get_shop['LTC'] . ' LTC';
		} elseif ($param[2] == 'ETH'){
			$balance = $get_shop['ETH'] . ' ETH';
		} elseif ($param[2] == 'USDT'){
			$balance = $get_shop['USDT'] . ' USDT';
		}
		
		$currency = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$param[2]."' ");
        $currency = $currency->fetch(PDO::FETCH_ASSOC);
		
        $price = $get_shop['balance'];
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price * $kurs;
		
		$price = $get_shop['balance'];
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price / $kurs;
		$scheck = number_format($itog_bez_proc, 8, '.', '');
		$this->pdo->prepare("UPDATE shop SET crypto_sum=? WHERE id=? ")->execute(array($balance, $param[1]));
		//$this->pdo->prepare("UPDATE shop SET rub_sum=? WHERE id=? ")->execute(array($get_shop['balance'], $param[1]));
		$this->pdo->prepare("UPDATE shop SET crypto_cur=? WHERE id=? ")->execute(array($param[2], $param[1]));
		$scheckcurs = number_format($currency['kurs'], 2, '.', '');
				$msg = 'Вывод средств с баланса магазина - <b>'.$get_shop['name'].'</b>
<code>=========================</code>
Баланс: <b>'.$balance.'</b>
Курс '.$param[2].': <b>'.$scheckcurs.'</b> руб.
<code>=========================</code>
<b>Введите адрес вашего <b>'.$param[2].'</b> кошелька или выберите из сохранённых:</b>
		';
		$res_data = $this->pdo->query("SELECT * FROM req_users WHERE chat = {$chat_id} and what = 'Крипта' and currency = '".$param[2]."' ORDER BY id DESC LIMIT 2");
		while ($row = $res_data->fetch()) {
		$buttons[] = [
                $this->buildInlineKeyBoardButton($row['wallet'], "savecryptoVivodSave_".$row['id']),
            ];	
		}
	
            $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
        $this->botApiQuery("editMessageText", [
            'chat_id' => $chat_id,
            'text' => $msg,
            'message_id' => $this->getMessageId($data),
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons),
        ]);
    }

 private function savecryptoVivod($msg, $data)
    {
        $chat_id = $this->getChatId($data);
	
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$user['shop_red']."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Магазины' and active = '1'");
        $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		
		 $cur = $this->pdo->query("SELECT * FROM `currency_api` WHERE nominal = '".$get_shop['crypto_cur']."' ");
		 $cur = $cur->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/^[-a-zA-Z0-9]+$/', $msg)) {
			
		$search_card = $this->pdo->query("SELECT * FROM req_users WHERE wallet = '".$msg."' and chat = {$chat_id} ");
	    $search_card = $search_card->fetchAll();
		
	    if(count($search_card) == 0){
		$newAddress = $this->pdo->prepare("INSERT INTO req_users SET what = :what, chat = :chat, wallet = :wallet, currency = :currency, bank = :bank");
            $newAddress->execute([
				'what' => 'Крипта',
                'chat' => $chat_id,
				'wallet' => $msg,
				'currency' => $get_shop['crypto_cur'],
				'bank' => 'NONE'
            ]);	
		}
			
		$this->pdo->prepare("UPDATE shop SET ".$get_shop['crypto_cur']."=? WHERE id=? ")->execute(array('0.0000000', $user['shop_red']));
			
			
	    $API_KEY = $coinbase['api_key'];
	    $API_SECRET = $coinbase['api_secret']; 
		$USER_ID = $cur['user_id'];
	    $timestamp = time();
	    $method = "POST";
	    $path = '/v2/accounts/' . $USER_ID . '/transactions';
	    $body = json_encode(array(
	    'type' => 'send',
	    'to' => $msg,
	    'amount' => $get_shop['crypto_sum'],
	    'currency' => $get_shop['crypto_cur']
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
			
	    $text_msg = "Ошибка автоматической выплаты, администратор уведомлён и скоро вам переведут ваши средства, приносим извинения.";
		
		    $newAddress = $this->pdo->prepare("INSERT INTO conclusion_shops SET id_shop = :id_shop, requisites = :requisites, status = :status, sum_crypto = :sum_crypto, sum_rub = :sum_rub, currency = :currency, date = :date, error = :error");
            $newAddress->execute([
				'id_shop' => $user['shop_red'],
                'requisites' => $msg,
				'status' => 'В ожидании',
				'sum_crypto' => $get_shop['crypto_sum'],
				'sum_rub' => $get_shop['rub_sum'],
				'currency' => $get_shop['crypto_cur'],
				'date' => time(),
				'error' => $arr['errors'][0]['message']
            ]);	
        $idZakaz = $this->pdo->lastInsertId();
		    $value = $get_shop['rub_sum'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
			
		$time_add = date('Y-m-d H:i:s', time());
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'Cегодня в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		$text_rew = '❗️ВНИМАНИЕ❗️Выплата по заявке <b>'. $idZakaz.'</b> завершилась неудачно. 
Текст ошибки <b>'.$arr['errors'][0]['message'].'</b>.
<code>===============</code>
Заявка: # <b>'.$idZakaz.'</b>
Сумма: '.$get_shop['crypto_sum'].'
Дата: <b>'.$datetime_create.'</b>
Статус: <b>В ожидании</b>		
';
		
        $admin_notify = $this->pdo->query("SELECT * FROM dle_users WHERE chat = ".$chat_id." and user_group = '1'");
        while ($row = $admin_notify->fetch()) {
		$data_sends = [
            'chat_id' => $row['chat'],
            'text' => $text_rew,
            'parse_mode' => 'html',
        ];	
		$this->botApiQuery("sendMessage", $data_sends);
		 }
		
	} else {
	
	
	
		$text_msg = "Операция прошла успешно, <b>".$get_shop['crypto_sum']."</b> ".$get_shop['crypto_cur']." отправлены на ваш кошелёк:
".$msg;

            $native_amount = $arr['data']['native_amount']['amount'];
	        $native_amount = mb_eregi_replace('[^0-9.]', '', $native_amount);
		
		    $newAddress = $this->pdo->prepare("INSERT INTO conclusion_shops SET sum_rub = :sum_rub, id_shop = :id_shop, requisites = :requisites, status = :status, sum_crypto = :sum_crypto, currency = :currency, date = :date");
            $newAddress->execute([
			    'sum_rub' => $native_amount,
				'id_shop' => $user['shop_red'],
                'requisites' => $msg,
				'status' => 'Выплачено',
				'sum_crypto' => $get_shop['crypto_sum'],
				'currency' => $get_shop['crypto_cur'],
				'date' => time()
            ]);	
			$idZak = $this->pdo->lastInsertId();
			
			$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arr['data']['resource_path']);
	        $str = preg_replace('/  */', ' ', $str);
	        $str = preg_replace('/\\s+/', ' ', $str);
	        $array = explode(' ', $str);
			
			$params = array('what' => 'Выплата магазину', 'uniq_zakaz' => $idZak, 'id_zakaz' => $idZak, 'date' => $arr['data']["created_at"], 'id_transaction' => $arr['data']['id'], 'address' => $arr['data']["to"]["address"], 'title' => $arr['data']['details']['title'], 'header' => $arr['data']['details']['header'], 'type' => $arr['data']["type"], 'status' => $arr['data']["status"], 'amount' => $arr['data']['amount']['amount'], 'native_amount' => $arr['data']['native_amount']['amount'], 'currency' => $arr['data']['amount']['currency'], 'native_curency' => $arr['data']['native_amount']['currency'], 'hash' => $arr['data']['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr['data']['network']['hash'], 'id_account' => $array[3] );   
	        $q = $this->pdo->prepare("INSERT INTO `transactions_crypto` (what, uniq_zakaz, id_zakaz, date, id_transaction, address, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:what, :uniq_zakaz, :id_zakaz, :date, :id_transaction, :address, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	        $q->execute($params);
			
		}
		
	
		} else {
            $text_msg = "Не верный кошелёк, укажите правильно.";
        }
		
		 $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$user['shop_red']),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	
	
	
	
	
	private function savecryptoVivodSave($data)
    {
        $chat_id = $this->getChatId($data);
	    $param = explode("_", $data['data']);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$req = $this->pdo->query("SELECT * FROM req_users WHERE id = '".$param[1]."'");
        $req = $req->fetch(PDO::FETCH_ASSOC);
		
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$user['shop_red']."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Магазины' and active = '1'");
        $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		
		 $cur = $this->pdo->query("SELECT * FROM `currency_api` WHERE nominal = '".$get_shop['crypto_cur']."' ");
		 $cur = $cur->fetch(PDO::FETCH_ASSOC);
		
			
		
		$this->pdo->prepare("UPDATE shop SET ".$get_shop['crypto_cur']."=? WHERE id=? ")->execute(array('0.0000000', $user['shop_red']));
			
			
	    $API_KEY = $coinbase['api_key'];
	    $API_SECRET = $coinbase['api_secret']; 
		$USER_ID = $cur['user_id'];
	    $timestamp = time();
	    $method = "POST";
	    $path = '/v2/accounts/' . $USER_ID . '/transactions';
	    $body = json_encode(array(
	    'type' => 'send',
	    'to' => $req['wallet'],
	    'amount' => $get_shop['crypto_sum'],
	    'currency' => $get_shop['crypto_cur']
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
			
	    $text_msg = "Ошибка автоматической выплаты, администратор уведомлён и скоро вам переведут ваши средства, приносим извинения.";
		
		    $newAddress = $this->pdo->prepare("INSERT INTO conclusion_shops SET id_shop = :id_shop, requisites = :requisites, status = :status, sum_crypto = :sum_crypto, sum_rub = :sum_rub, currency = :currency, date = :date, error = :error");
            $newAddress->execute([
				'id_shop' => $user['shop_red'],
                'requisites' => $req['wallet'],
				'status' => 'В ожидании',
				'sum_crypto' => $get_shop['crypto_sum'],
				'sum_rub' => $get_shop['rub_sum'],
				'currency' => $get_shop['crypto_cur'],
				'date' => time(),
				'error' => $arr['errors'][0]['message']
            ]);	
        $idZakaz = $this->pdo->lastInsertId();
		    $value = $get_shop['rub_sum'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
			
		$time_add = date('Y-m-d H:i:s', time());
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'Cегодня в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		$text_rew = '❗️ВНИМАНИЕ❗️Выплата по заявке <b>'. $idZakaz.'</b> завершилась неудачно. 
Текст ошибки <b>'.$arr['errors'][0]['message'].'</b>.
<code>===============</code>
Заявка: # <b>'.$idZakaz.'</b>
Сумма: '.$get_shop['crypto_sum'].'
Дата: <b>'.$datetime_create.'</b>
Статус: <b>В ожидании</b>		
';
		
        $admin_notify = $this->pdo->query("SELECT * FROM dle_users WHERE chat = ".$chat_id." and user_group = '1'");
        while ($row = $admin_notify->fetch()) {
		$data_sends = [
            'chat_id' => $row['chat'],
            'text' => $text_rew,
            'parse_mode' => 'html',
        ];	
		$this->botApiQuery("sendMessage", $data_sends);
		 }
		
	} else {
	
	
	
		$text_msg = "Операция прошла успешно, <b>".$get_shop['crypto_sum']."</b> ".$get_shop['crypto_cur']." отправлены на ваш кошелёк:
".$req['wallet'];

            $native_amount = $arr['data']['native_amount']['amount'];
	        $native_amount = mb_eregi_replace('[^0-9.]', '', $native_amount);
		
		    $newAddress = $this->pdo->prepare("INSERT INTO conclusion_shops SET sum_rub = :sum_rub, id_shop = :id_shop, requisites = :requisites, status = :status, sum_crypto = :sum_crypto, currency = :currency, date = :date");
            $newAddress->execute([
			    'sum_rub' => $native_amount,
				'id_shop' => $user['shop_red'],
                'requisites' => $req['wallet'],
				'status' => 'Выплачено',
				'sum_crypto' => $get_shop['crypto_sum'],
				'currency' => $get_shop['crypto_cur'],
				'date' => time()
            ]);	
			$idZak = $this->pdo->lastInsertId();
			
			$str = preg_replace('/[^A-Za-z0-9. -]/', ' ', $arr['data']['resource_path']);
	        $str = preg_replace('/  */', ' ', $str);
	        $str = preg_replace('/\\s+/', ' ', $str);
	        $array = explode(' ', $str);
			
			$params = array('what' => 'Выплата магазину', 'uniq_zakaz' => $idZak, 'id_zakaz' => $idZak, 'date' => $arr['data']["created_at"], 'id_transaction' => $arr['data']['id'], 'address' => $arr['data']["to"]["address"], 'title' => $arr['data']['details']['title'], 'header' => $arr['data']['details']['header'], 'type' => $arr['data']["type"], 'status' => $arr['data']["status"], 'amount' => $arr['data']['amount']['amount'], 'native_amount' => $arr['data']['native_amount']['amount'], 'currency' => $arr['data']['amount']['currency'], 'native_curency' => $arr['data']['native_amount']['currency'], 'hash' => $arr['data']['network']['hash'], 'url' => 'https://blockchair.com/litecoin/transaction/'.$arr['data']['network']['hash'], 'id_account' => $array[3] );   
	        $q = $this->pdo->prepare("INSERT INTO `transactions_crypto` (what, uniq_zakaz, id_zakaz, date, id_transaction, address, title, header, type, status, amount, native_amount, currency, native_curency, hash, url, id_account) VALUES (:what, :uniq_zakaz, :id_zakaz, :date, :id_transaction, :address, :title, :header, :type, :status, :amount, :native_amount, :currency, :native_curency, :hash, :url, :id_account)");  
	        $q->execute($params);
			
		}
		
		
		 $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$user['shop_red']),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}





	
	private function goShopAddress($data)
    {
        $chat_id = $this->getChatId($data);
        @$this->setActionUser("step_1_shopaddr", $chat_id);
        $this->insertgoShopAddress($chat_id, $data);

    }

       private function insertgoShopAddress($chat_id, $data)
    {
		
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET shop_red=? WHERE chat=?")->execute(array($param[1], $chat_id));


		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
        
		$msg = "<code>Смена кошелька</code>
<code>===============</code>
Введите ваш <b>{$get_shop['address_out']}</b> кошелёк, куда будут выводится средства.
";
	
            $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
        $this->botApiQuery("editMessageText", [
            'chat_id' => $chat_id,
            'text' => $msg,
            'message_id' => $this->getMessageId($data),
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons),
        ]);
    }

 private function saveShopAddress($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/^[-a-zA-Z0-9]+$/', $msg)) {
			$this->pdo->prepare("UPDATE shop SET address_out=? WHERE id=? ")->execute(array($msg, $user['shop_red']));
			
			
	    $text_msg = "Кошелёк <b>'".$msg."'</b> успешно установлен.";
		} else {
            $text_msg = "Не верный кошелёк, укажите правильно.";
        }
		
		 $buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$user['shop_red']),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	
		
		
		private function whatPays($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        $obj = $data['data'];
        // разбиваем в массив
        $param = explode("_", $obj);
            // определяем видимость если был 1 ставим 0 и наоборот
            $hide = $param[2] ? 0 : 1;
            // готовим запрос
			if ($param[2] == '1') {
			$re = 'Накопительный';	
			} else {
			$re = 'Моментальный';	
			}
            $updateSql = $this->pdo->prepare("UPDATE shop SET vivod_ico = :vivod_ico, vivod = :vivod WHERE id = '".$param[1]."'");
            // обновляем видимость
            if ($updateSql->execute(['vivod_ico' => $hide, 'vivod' => $re])) {
                // получаем массив данных для обновления
                $fields = $this->showShop($data);
                // добавляем к массиву id сообщения
                $fields['message_id'] = $data['message']['message_id'];
                // отправляем на изменение сообщения
                $upMessage = $this->botApiQuery("editMessageText", $fields);
                // если обновление прошло успешно
                if ($upMessage['ok']) {
                    $this->notice($data['id'], "Режим изменён");
                } else {
                    $this->notice($data['id'], "Режим изменён");
                }
            } else {
                $this->sendMessage($chat_id, "Ошиибка изменения режима");
            }
        
    }
		
		
		
		
				private function showTransShop($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		
		if ($param[2] == '') {
		$pageno = 1;	
		} else {
        $pageno = $param[2];
		}
		
		$size_page = 5;
        $offset = ($pageno-1) * $size_page;
        
		$total = $this->pdo->query("SELECT * FROM transactions WHERE id_shop = ".$param[1]." ");
        $total = $total->fetchAll();
		
		$total_rows = count($total);
        $total_pages = ceil($total_rows / $size_page);
		
		
		$totals = $this->pdo->query("SELECT * FROM transactions WHERE id_shop = ".$param[1]." ORDER BY id DESC LIMIT $offset, $size_page");
        $totals = $totals->fetchAll();
		
		$msg .= 'Магазин - <b>'.$get_shop['name'].'</b>
=========================
Список транзакций магазина:
<code>=========================</code>
';
if (empty($totals)):

$msg .= 'Транзакций ещё небыло.';

else:

foreach ($totals as $key => $values):
$time_add = date('Y-m-d H:i:s', $values['date_create']);
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		
		

			$value = $values['sum_rub'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
		
		
		
		if ($values['date_pay'] == NULL){
		
        $date_pay = '<b>'.$values['status'].'</b>';		
			
		} else {
		$date_str_pay = new DateTime($values['time_buy']);
		$date_pay = $date_str_pay->Format('d.m.Y');
		$date_month_pay = $date_str_pay->Format('d.m');
		$date_year_pay = $date_str_pay->Format('Y');
		$date_time_pay = $date_str_pay->Format('H:i');
		
		$ndate_pay = date('d.m.Y');
		$ndate_time_pay = date('H:i');
		$ndate_time_m_pay = date('i');
		$ndate_exp_pay = explode('.', $date_pay);
		$nmonth_pay = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_pay as $key_pay => $value_pay) {
			if($key_pay == intval($ndate_exp_pay[1])) $nmonth_name_pay = $value_pay;
		}
		
		if ($date_pay == date('d.m.Y')){
			$datetime_pay = 'в ' .$date_time_pay . '';
		}
		else if ($date_pay == date('d.m.Y', strtotime('-1 day'))){
			$datetime_pay = 'Вчера в ' .$date_time_pay . '';
		}
		else if ($date_pay != date('d.m.Y') && $date_year_pay != date('Y')){
			$datetime_pay = '' . $ndate_exp_pay[0].' '.$nmonth_name_pay.' '.$ndate_exp_pay[2]. ' в '.$date_time_pay . '';
		}
		else {
		    $datetime_pay = '' . $ndate_exp_pay[0].' '.$nmonth_name_pay.' в '.$date_time_pay . ', ';
		}
		
		$date_pay = '<code>'.$datetime_pay.'</code>';
		
		}
		
		if ($values['status'] == 'Выплачено'){
		
		$shop_req = $values['sendclient_crypto'].' '.$values['na_chto'].' ('.$values['out_summ'].' ₽) отправлено на: '.$values['client_requisites'];		
			
		} else {
			
		$shop_req = '<i>Зачислено на счёт</i>';		
		
		}
		
$msg .= '# <code>'.$values['id'].'</code>: на сумму <b>'.$sum.'</b>
Создана: <code>'.$datetime_create.':</code>
Оплачена: '.$date_pay.'
'.$shop_req.'
<code>=========================</code>
';

endforeach;
if ($total_pages > 1) {
         $prev = ($pageno <= 1) ? $total_pages - 0 : $pageno - 1;
         $next = ($pageno >= $total_pages) ? 1 : $pageno + 1;
			
            $buttons[] = [
                $this->buildInlineKeyBoardButton('<<', 'showTransShop_' . $param[1] . '_' . $prev),
                $this->buildInlineKeyBoardButton(($pageno) . ' из ' . $total_pages, '' . $total_pages),
                $this->buildInlineKeyBoardButton('>>', 'showTransShop_' . $param[1] . '_' . $next),
            ];
		 }
endif;
            
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}
		
		
		
		
		private function showCashBackShop($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		$get_shop = $this->pdo->query("SELECT * FROM shop WHERE id = '".$param[1]."'");
        $get_shop = $get_shop->fetch(PDO::FETCH_ASSOC);
		
		
		if ($param[2] == '') {
		$pageno = 1;	
		} else {
        $pageno = $param[2];
		}
		
		$size_page = 5;
        $offset = ($pageno-1) * $size_page;
        
		$total = $this->pdo->query("SELECT * FROM conclusion_shops WHERE id_shop = ".$param[1]." ");
        $total = $total->fetchAll();
		
		$total_rows = count($total);
        $total_pages = ceil($total_rows / $size_page);
		
		
		$totals = $this->pdo->query("SELECT * FROM conclusion_shops WHERE id_shop = ".$param[1]." ORDER BY id DESC LIMIT $offset, $size_page");
        $totals = $totals->fetchAll();
		
		$msg .= 'Магазин - <b>'.$get_shop['name'].'</b>
=========================
Ваши заявки на вывод средств:
<code>=========================</code>
';
if (empty($totals)):

$msg .= 'Запросов ещё небыло.';

else:

foreach ($totals as $key => $values):
$time_add = date('Y-m-d H:i:s', $values['date']);
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		
		

			$value = $values['sum_rub'];
		    $words = $this->num_word($value, array('рубль', 'рубля', 'рублей'));
			$sum = $words;
		
		if ($values['currency'] == 'VISA'){
		
		$summa = '<b>'.$sum.'</b>';		
			
		} else {
			
		$summa = $values['sum_crypto']. ' ' . $values['currency'] . ' ' . '
Сумма в рублях: <b>'.$sum.'</b>'
		;
		
		}
		
$msg .= 'Заявка: # <b>'.$values['id'].':</b>
Сумма: '.$summa.'
Дата: <b>'.$datetime_create.'</b>
Статус: <b>'.$values['status'].'</b>
<code>=========================</code>
';

endforeach;
if ($total_pages > 1) {
         $prev = ($pageno <= 1) ? $total_pages - 0 : $pageno - 1;
         $next = ($pageno >= $total_pages) ? 1 : $pageno + 1;
			
            $buttons[] = [
                $this->buildInlineKeyBoardButton('<<', 'showCashBackShop_' . $param[1] . '_' . $prev),
                $this->buildInlineKeyBoardButton(($pageno) . ' из ' . $total_pages, '' . $total_pages),
                $this->buildInlineKeyBoardButton('>>', 'showCashBackShop_' . $param[1] . '_' . $next),
            ];
		 }
endif;
            
			$buttons[] = [
                    $this->buildInlineKeyBoardButton('<< Назад', "showShop_".$param[1]),
					$this->buildInlineKeyBoardButton('На главную', "nochalobot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
		}
		
		
		
		
		
		 private function kabinet($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$totalobmen = $this->pdo->query("SELECT * FROM transactions WHERE chat = '".$chat_id."'");
        $totalobmen = $totalobmen->fetchAll();
		$totalgoodobmen = $this->pdo->query("SELECT * FROM transactions WHERE chat = '".$chat_id."' and status = 'Выплачено'");
        $totalgoodobmen = $totalgoodobmen->fetchAll();
		if ($user['btc_wallet'] == NULL) {
          $btc_wallet = 'У вас ещё нет BTC кошелька.'; 
		  $btc_balance = 'У вас ещё нет BTC кошелька.';
        } else {
          $btc_wallet = $user['btc_wallet'];
		  $btc_balance = $user['balance_btc'] . ' ₿';
		}
		if ($user['ltc_wallet'] == NULL) {
          $ltc_wallet = 'У вас ещё нет LTC кошелька.'; 
		  $ltc_balance = 'У вас ещё нет LTC кошелька.';
        } else {
          $ltc_wallet = $user['ltc_wallet'];
		  $ltc_balance = $user['balance_ltc'] . ' Ł';
		}		
		$msg .= '<b>Ваш личный кабинет</b>
=========================
┌ Ваш ID: <code>'.$chat_id.'</code>
';
$res_data = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} ORDER BY id DESC");
while ($row = $res_data->fetch()) {
$msg .= '├ '.$row['currency'].' баланс: '.$row['balance'].'
';
}
$msg .= '├ Успешных обменов: '.count($totalgoodobmen).'
└ Ссылка приглашения: <code>exorion.biz/ref32343</code> 
=========================
Вы можете пополнять свой баланс и пользоваться как полноценным, криптовалютным кошельком. Либо совершать у нас обмен прямо с вашего баланса.
';
        $buttons[] = [
                    $this->buildInlineKeyBoardButton("Заявки на обмен [".count($totalobmen).']', "MyTranz_"),
            ];
		$res_datas = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} ORDER BY id DESC");
		while ($rows = $res_datas->fetch()) {
		$buttons[] = [
                    $this->buildInlineKeyBoardButton('Показать '.$rows['currency']. ' кошелёк', 'sayWallet_' . $rows['currency']),
            ];	
		}
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Создать заявку на API", "GoApiStepOne_"),
            ];
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("В главное меню", "nochaloBot_"),
            ];
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        $this->notice($data['id'], "Главное меню");
		}
		
		 private function sayWallet($data)
    {
		$chat_id = $this->getChatId($data);
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
        
		$wallet = $this->pdo->query("SELECT * FROM wallets WHERE currency = '".$param[1]."' and chat = {$chat_id} ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);
		
        $msg = '==============
'.$wallet['address'].'
==============';
            $buttons[] = [
                $this->buildInlineKeyBoardButton("<< Назад", "kabinet_"),
            ];
		
                   // готовим данные для отображения
        $data_send = [
            'chat_id' => $chat_id,
            'photo' => $wallet['qr'],
			'caption' => $msg,
            'parse_mode' => 'html',
        ];
		
        // проверяем наличие кнопок
        if (is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
	    $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
        // отправляем сообщение
        $this->botApiQuery("sendPhoto", $data_send);
    }
		
		
		
private function MyTranz($data)
    {
		$chat_id = $this->getChatId($data);
		$param = explode("_", $data['data']);
		
		if ($param[1] == '') {
		$pageno = 1;	
		} else {
        $pageno = $param[1];
		}
       
	    $size_page = 5;
        $offset = ($pageno-1) * $size_page;
        
		$total = $this->pdo->query("SELECT * FROM transactions WHERE chat = ".$chat_id." ");
        $total = $total->fetchAll();

        $total_rows = count($total);
        $total_pages = ceil($total_rows / $size_page);   
   
		$msg = "<code>Заявки на обмен.</code>";	
		
		$res_data = $this->pdo->query("SELECT * FROM transactions  WHERE chat = ".$chat_id." ORDER BY id DESC LIMIT $offset, $size_page");
        while ($row = $res_data->fetch()) {
			if ($row['chto'] == 'LTC') {
					 $chto = 'Litecoin';
				 } elseif ($row['chto'] == 'BTC') {
					 $chto = 'Bitcoin';
				 } elseif ($row['chto'] == 'ETH') {
					 $chto = 'Etherium';
				 } elseif ($row['chto'] == 'VISA') {
					 $chto = 'RUB';
				 }
				 
				 if ($row['na_chto'] == 'LTC') {
					 $na_chto = 'Litecoin';
				 } elseif ($row['na_chto'] == 'BTC') {
					 $na_chto = 'Bitcoin';
				 } elseif ($row['na_chto'] == 'ETH') {
					 $na_chto = 'Etherium';
				 } elseif ($row['na_chto'] == 'VISA') {
					 $na_chto = 'RUB';
				 }
				 $time_add = date('Y-m-d H:i:s', $row['date_create']);
		$date_str_create = new DateTime($time_add);
		$date_create = $date_str_create->Format('d.m.Y');
		$date_month_create = $date_str_create->Format('d.m');
		$date_year_create = $date_str_create->Format('Y');
		$date_time_create = $date_str_create->Format('H:i');
		
		$ndate_create = date('d.m.Y');
		$ndate_time_create = date('H:i');
		$ndate_time_m_create = date('i');
		$ndate_exp_create = explode('.', $date_create);
		$nmonth_create = array(
		1 => 'янв',
		2 => 'фев',
		3 => 'мар',
		4 => 'апр',
		5 => 'мая',
		6 => 'июн',
		7 => 'июл',
		8 => 'авг',
		9 => 'сен',
		10 => 'окт',
		11 => 'ноя',
		12 => 'дек'
		);
		
		foreach ($nmonth_create as $key_create => $value_create) {
			if($key_create == intval($ndate_exp_create[1])) $nmonth_name_create = $value_create;
		}
		
		if ($date_create == date('d.m.Y')){
			$datetime_create = 'Cегодня в ' .$date_time_create;
		}
		else if ($date_create == date('d.m.Y', strtotime('-1 day'))){
			$datetime_create = 'Вчера в ' .$date_time_create;
		}
		else if ($date_create != date('d.m.Y') && $date_year_create != date('Y')){
			$datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' '.$ndate_exp_create[2]. ' в '.$date_time_create;
		}
		else {
		    $datetime_create = $ndate_exp_create[0].' '.$nmonth_name_create.' в '.$date_time_create;
		}
		 $buttons[] = [
            $this->buildInlineKeyBoardButton('#'.$row['id'].' '.$chto.' на '.$na_chto . ' '.$datetime_create, "PmMessUser_"),
			 ];
        }
		   if ($total_pages > 1) {
         $prev = ($pageno <= 1) ? $total_pages - 0 : $pageno - 1;
         $next = ($pageno >= $total_pages) ? 1 : $pageno + 1;
			
            $buttons[] = [
                $this->buildInlineKeyBoardButton('<<', 'MyTranz_'. $prev),
                $this->buildInlineKeyBoardButton('>>', 'MyTranz_'. $next),
            ];
		 }
		 $buttons[][] = $this->buildInlineKeyBoardButton("<< Назад", "nochaloBot_");
		 
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
    
    }
		
		
		
		
		
				private function GoApiStepOne($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
       
		
		$msg = '<code>Регистрация REST API для бизнеса.</code>
=========================
Правила регистрации в сервисе:
		';	
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Продолжить", "goSaveStepOne_"),
					$this->buildInlineKeyBoardButton("Отмена", "nochaloBot_"),
            ];
        $data_send = [
            'chat_id' => $chat_id,
            'text' => $msg,
            'parse_mode' => 'html',
        ];
        if (is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }	
		$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
        $this->botApiQuery("sendMessage", $data_send);
		}
		
		
		        private function apiSystems($data)
    {
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_catalog", $chat_id);
        $param = explode("_", $data['data']);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		
		
		$msg = '<b>Автоматизация вашего бизнеса</b>
┌ Самый низкий процент на рынке.
├ Множество криптовалют на вывод.
├ Моментальный приём оплаты.
├ Нативный API без заморочек.
├ Подключим, настроим, ваш магазин.
└ Двойная система вывода
  <i>1. Накопительный режим</i>
  <i>2. Моментальынй вывод каждого платежа</i>
=========================
Можете оставить заявку по кнопке ниже, мы рассмотрим в течении дня и ответим Вам. 
';
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Создать заявку на API", "GoApiStepOne_"),
            ];
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("В главное меню", "nochaloBot_"),
            ];
       $this->botApiQuery("sendVideo", [
                    'chat_id' => $chat_id,
                    'video' => 'http://exorion.biz/images/Final Comp_3.mp4',
					'parse_mode' => 'HTML',
					'caption' => $msg,
					'reply_markup' => $this->buildInlineKeyBoard($buttons)
                ]
            );	
		$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
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
			if ($user['zakaz'] == 1) {
			
		$msg = 'У вас уже есть активная заявка.';
		if ($user['chto'] == 'VISA') {
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("Перейти к заявке...", "activePayCrypto_"),
            ];
		} else {
		$buttons[] = [
                    $this->buildInlineKeyBoardButton("Перейти к заявке...", "activePayVisa_"),
            ];	
		}
		} else {

				
		$msg = '<code>Вы начали процедуру обмена.</code>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
<b>Что, на что Вы хотите поменять?</b>';
			$res_data = $this->pdo->query("SELECT * FROM currency_para ORDER BY id DESC");
			while ($row = $res_data->fetch()) {
				 if ($row['currency_in'] == 'LTC') {
					 $currency = 'Litecoin';
					 $currency_kurs = $this->kurs_ltc;
					 $link = 'goChangeCryptoPred_';
				 } elseif ($row['currency_in'] == 'BTC') {
					 $currency = 'Bitcoin';
					 $link = 'goChangeCryptoPred_';
					 $currency_kurs = $this->kurs_btc;
				 } elseif ($row['currency_in'] == 'ETH') {
					 $currency = 'Etherium';
					 $currency_kurs = $this->kurs_eth;
					 $link = 'goChangeCryptoPred_';
				 } elseif ($row['currency_in'] == 'VISA') {
					 $currency = 'Visa/MasterCard [RUB]';
					 $link = 'goChangeCryptoPred_';
				 } else {
					 $currency = $row['currency_in'];
					 $link = 'goChangeCryptoPred_';
				 }
				 
				 
				 if ($row['currency_out'] == 'LTC') {
					 $currency_out = 'Litecoin';
					 $currency_kurs = $this->kurs_ltc;
				 } elseif ($row['currency_out'] == 'BTC') {
					 $currency_out = 'Bitcoin';
					 $currency_kurs = $this->kurs_btc;
				 } elseif ($row['currency_out'] == 'ETH') {
					 $currency_out = 'Etherium';
					 $currency_kurs = $this->kurs_eth;
				 } elseif ($row['currency_out'] == 'VISA') {
					 $currency_out = 'Visa/MasterCard [RUB]';
					 $currency_kurs = '';
				 } else {
					 $currency_out = $row['currency_out'];
				 }

				 
			if ($row['currency_in'] == 'VISA') {
				$buttons[] = [
                    $this->buildInlineKeyBoardButton($currency . ' на '.$currency_out, $link . $row['currency_in'].'_' . $row['currency_out'].'_' . $row['id']),
            ];
				 } else {					 
			$buttons[] = [
                    $this->buildInlineKeyBoardButton($currency . ' на '.$currency_out, $link . $row['currency_in'].'_' . $row['currency_out'].'_' . $row['id']),
            ];
				 }
				 
			}
			
			$buttons[] = [
                    $this->buildInlineKeyBoardButton("<< В главное меню", "nochaloBot_"),
            ];
		}
			// готовим данные для отправки
            $fields = [
                'chat_id' => $chat_id,
                'message_id' => $data['message']['message_id'],
                'text' => $msg,
                'reply_markup' => $this->buildInlineKeyBoard($buttons),
				'parse_mode' => 'html',
            ];
            // отправляем на изменение сообщения
            $this->botApiQuery("editMessageText", $fields);
        $this->notice($data['id'], "Выберите что хотите поменять.");
		}
		
		private function goChangeCryptoPred($data)
    {
        $chat_id = $this->getChatId($data);
		$param = explode("_", $data['data']);
		$this->pdo->prepare("UPDATE dle_users SET na_chto=? WHERE chat=?")->execute(array($param[2], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET chto=? WHERE chat=?")->execute(array($param[1], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET chto_id=? WHERE chat=?")->execute(array($param[3], $chat_id));
	    $this->goChangeCrypto($data);
    }
		
		private function goChangeCrypto($data)
    {
        $chat_id = $this->getChatId($data);

		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		if ($user['chto'] == 'VISA') {
		if ($this->setActionUser("step_1_summ", $chat_id)) {
            $this->insertSummAny($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }	
			
		} else {
        if ($this->setActionUser("step_1_crypto", $chat_id)) {
            $this->insertSummCrypto($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
		}
    }


       private function goChangeLtcBtc($data)
    {
        $chat_id = $this->getChatId($data);
        if ($this->setActionUser("step_1_card", $chat_id)) {
            $this->insertgoChangeLtcBtc($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
    }

       private function insertgoChangeLtcBtc($chat_id, $data)
    {
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
        
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = '".$user['chto_id']."' ");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
        $msg = "asdsadsa
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


       private function insertSummCrypto($chat_id, $data)
    {
		$param = explode("_", $data['data']);
    
        $msg = '<code>Идёт процедура обмена.</code>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
<b>Шаг - 3:</b> Введите сумму которую хотите обменять, <b>в криптовалюте</b>.
<i>Например: 0.0032134</i>
=========================
';
        $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=?")->execute(array(1, $chat_id));
        $this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET na_chto=? WHERE chat=?")->execute(array($param[2], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET chto=? WHERE chat=?")->execute(array($param[1], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET chto_id=? WHERE chat=?")->execute(array($param[3], $chat_id));
        
            $buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "otmena_"),
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

     private function saveSummUserCrypto($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = '".$user['chto_id']."' ");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$currency = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['chto']."' ");
        $currency = $currency->fetch(PDO::FETCH_ASSOC);
		
		
		if (preg_match("/[ @]?(\d{1}\.\d{1})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{2})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{3})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{4})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{5})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{6})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{7})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{8})\b/", $msg)) {
		
		$price = $msg;
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price * $kurs;
		$percent = $currency_para['percent'];
		$itog = $itog_bez_proc - ($itog_bez_proc * ($percent / 100));
		$scheck = number_format($itog, 2, '.', '');
			$this->pdo->prepare("UPDATE dle_users SET amount_crypto=? WHERE chat=? ")->execute(array($msg, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET amount_rub=? WHERE chat=? ")->execute(array($scheck, $chat_id));
			
			$this->pdo->prepare("UPDATE dle_users SET amount_rub_orig=? WHERE chat=? ")->execute(array($itog_bez_proc, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET amount_crypto_orig=? WHERE chat=? ")->execute(array($msg, $chat_id));
			
			$text_msg = "<code>Внимательно проверьте все данные!</code>
<code>===============</code>
<b>Вы меняете:</b> {$user['chto']} на {$user['na_chto']}
<b>У вас есть:</b> {$msg} {$user['chto']}
<b>За них Вы получите:</b> {$scheck} RUB.
<code>===============</code>
<code>Если Вы хотите изменить сумму платежа, просто отправьте новую сумму и она заменит предыдущую.</code>";

					$buttons[] = [$this->buildInlineKeyBoardButton("Продолжить оплату", "goSaveMyCard_"),];
					$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];

	} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.\n\nУкажите сумму в крипте правильно!";
			$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];
        }
				$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

				$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
    }


private function goSaveMyCard($data)
    {
        $chat_id = $this->getChatId($data);
        if ($this->setActionUser("step_1_card", $chat_id)) {
            $this->insertMyCard($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
    }

       private function insertMyCard($chat_id, $data)
    {
		$chat_id = $this->getChatId($data);
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
        
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = '".$user['chto_id']."' ");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$this->pdo->prepare("UPDATE dle_users SET time_api=? WHERE chat=? ")->execute(array(time(), $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET time_rez=? WHERE chat=? ")->execute(array(60, $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
        
		$msg = "<code>Процедура обмена</code>
<code>===============</code>
У вас пока нет сохранённых карт <b>Visa/MasterCard</b>.
<code>===============</code>
<b>Шаг - 4:</b> Введите ваш <b>номер карты</b>, куда будет переведено <b>{$user['amount_rub']}</b> рублей.
";
        $actpm = $this->pdo->query("SELECT * FROM req_users WHERE chat = {$chat_id} and what = 'Карта'");
        $actpm = $actpm->fetchAll();
		if(count($actpm) == 0){
			        $msg = "<code>Процедура обмена</code>
<code>===============</code>
У вас пока нет сохранённых карт <b>Visa/MasterCard</b>.
<code>===============</code>
<b>Шаг - 4:</b> Введите ваш <b>номер карты</b>, куда будет переведено <b>{$user['amount_rub']}</b> рублей.
";
		} else {
		        $msg = "<code>Процедура обмена</code>
<code>===============</code>
<b>Шаг - 4:</b> Введите ваш <b>номер карты</b> или выберите из последних ваших операций, сохранённую карту, куда будет переведено <b>{$user['amount_rub']}</b> рублей.
";	
		}
		$res_data = $this->pdo->query("SELECT * FROM req_users WHERE chat = {$chat_id} and what = 'Карта' ORDER BY id DESC LIMIT 2");
		while ($row = $res_data->fetch()) {
		$buttons[] = [
                $this->buildInlineKeyBoardButton($row['wallet'], "nochaloBot_"),
            ];	
		}
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

     private function saveMyCard($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
        if (preg_match('/[0-9 ]{13,16}/', $msg)) {
		    $this->pdo->prepare("UPDATE dle_users SET my_card=? WHERE chat=? ")->execute(array($msg, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET time_api=? WHERE chat=? ")->execute(array(time(), $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET time_rez=? WHERE chat=? ")->execute(array(60, $chat_id));

			
			
			
			      $card = $msg;
                  $curl = curl_init();
				  curl_setopt_array($curl, array(
				  CURLOPT_URL => 'https://api.binking.io/form?apiKey=4b63d18184435ed655d3d397e11e0fef&cardNumber='.$card.'',
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => '',
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => 'GET',
				  ));
				  $response = curl_exec($curl);
				  curl_close($curl);
				  $jsonString = $response;
				  $api = json_decode( $jsonString );
				  
			if(empty($api->bankLocalName)) {
			$text_msg = "Введённая вами карта не определена, вы уверены что правильно вели данные карты и хотите продолжить обмен?";
			$buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "otmena_"),
				$this->buildInlineKeyBoardButton("Продолжить", "goPayVisa_"),
            ];
			$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);
			} else {
				$text_msg = "Карта определена: <b>" . $api->bankLocalName."</b>
Переходим к заявке.";
			$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);
			sleep(2);
			$wallet = $user['chto'];
			$this->goPayVisa($data, $wallet);
			}
			
		$search_card = $this->pdo->query("SELECT * FROM req_users WHERE wallet = '".$msg."' and chat = {$chat_id} ");
	    $search_card = $search_card->fetchAll();
		
	    if(count($search_card) == 0){
		$newAddress = $this->pdo->prepare("INSERT INTO req_users SET what = :what, chat = :chat, wallet = :wallet, currency = :currency, bank = :bank");
            $newAddress->execute([
				'what' => 'Карта',
                'chat' => $chat_id,
				'wallet' => $msg,
				'currency' => 'VISA',
				'bank' => $api->bankLocalName
            ]);	
		}
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз. Укажите карту в правильном формате, только цифры и без пробелов.";
			$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

        }
				$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
			
	}
		
		
		
private function goPayVisa($data)
    {
       $chat_id = $this->getChatId($data);
	   $message_id = $this->getMessageId($data);
	   $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
       $user = $user->fetch(PDO::FETCH_ASSOC);
       $wallet = $user['chto'];
	   $this->goObmenVisa($data, $wallet);
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
		$chat_id = $this->getChatId($data);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$cur = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['na_chto']."'");
        $cur = $cur->fetch(PDO::FETCH_ASSOC);
		$coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Клиенты' and active = '1'");
        $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		$search_wallet = $this->pdo->query("SELECT * FROM wallets WHERE currency = '".$user['na_chto']."' and chat = {$chat_id} ");
	    $search_wallet = $search_wallet->fetchAll();
	    if(count($search_wallet) == 0){
        $API_KEY = $coinbase['api_key'];
	    $API_SECRET = $coinbase['api_secret']; 
		$USER_ID = $cur['user_id'];
		$timestamp = time();
		$method = "POST";
		$path = '/v2/accounts/' . $USER_ID . '/addresses';
		$body = json_encode(array(
		'name' => 'New receive address'
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
		
		    $newAddress = $this->pdo->prepare("INSERT INTO wallets SET currency = :currency, address = :address, chat = :chat, wallet_id = :wallet_id, qr = :qr, network = :network");
            $newAddress->execute([
				'currency' => $user['na_chto'],
                'address' => $arr['data']['address'],
				'chat' => $chat_id,
				'wallet_id' => $arr['data']['id'],
				'qr' => "https://www.bitcoinqrcodemaker.com/api/?style=".$arr['data']['network']."&border=5&color=3&address=".$arr['data']['address'],
				'network' => $arr['data']['network']
            ]);
		}
		
        $msg = '<code>Идёт процедура обмена.</code>
=========================<code>
BTC = '.$this->kurs_btc.' RUB
LTC = '.$this->kurs_ltc.' RUB
ETH = '.$this->kurs_eth.' RUB</code>
=========================
<b>Шаг - 3:</b> Введите сумму <b>в рублях, либо введите сумму которая Вам нужна в криптовалюте</b>, система определит и выдаст Вам результат.
<i>Например: 1000 или 0.0032134</i>
=========================
';
        $this->pdo->prepare("UPDATE dle_users SET send=? WHERE chat=?")->execute(array(1, $chat_id));
        $this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET na_chto=? WHERE chat=?")->execute(array($param[2], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET chto=? WHERE chat=?")->execute(array($param[1], $chat_id));
		$this->pdo->prepare("UPDATE dle_users SET chto_id=? WHERE chat=?")->execute(array($param[3], $chat_id));
            $buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "otmena_"),
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
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = {$user['chto_id']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$currency = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['na_chto']."' ");
        $currency = $currency->fetch(PDO::FETCH_ASSOC);
		
		if ($currency_para['currency_in'] == 'VISA') {
		$cur = 	'Visa/MasterCard [RUB]';
		}
		
		if (preg_match("/[ @]?(\d{1}\.\d{1})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{2})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{3})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{4})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{5})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{6})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{7})\b/", $msg) or preg_match("/[ @]?(\d{1}\.\d{8})\b/", $msg)) {
	
		$price = $msg;
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price * $kurs;
		$percent = $currency_para['percent'];
		$itog = $itog_bez_proc + ($itog_bez_proc * ($percent / 100));
		$scheck = number_format($itog, 0, '.', '');
		
		if ($itog_bez_proc < $currency_para['min']) {
		$text_msg = "Сумма меньше минимальной, введите сумму крипты, чтоб вышло более " . $currency_para['min'] . ' рублей';	
		$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];	
		} else {
		
			$this->pdo->prepare("UPDATE dle_users SET time_api=? WHERE chat=? ")->execute(array(time(), $chat_id));
		    $this->pdo->prepare("UPDATE dle_users SET time_rez=? WHERE chat=? ")->execute(array(60, $chat_id));
		    $this->pdo->prepare("UPDATE dle_users SET amount_rub=? WHERE chat=? ")->execute(array($scheck, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET amount_crypto=? WHERE chat=? ")->execute(array($msg, $chat_id));
			
			$this->pdo->prepare("UPDATE dle_users SET amount_rub_orig=? WHERE chat=? ")->execute(array($itog_bez_proc, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET amount_crypto_orig=? WHERE chat=? ")->execute(array($msg, $chat_id));
			
			
			$text_msg = "<code>Внимательно проверьте все данные!</code>
<code>===============</code>
<b>Вы меняете:</b> {$cur} на {$user['na_chto']}
<b>Вам нужно:</b> {$msg} {$user['na_chto']}
<b>К оплате в рублях:</b> {$scheck} ₽
<code>===============</code>
<code>Если Вы хотите изменить сумму платежа, просто отправьте новую сумму и она заменит предыдущую.</code>";

					$buttons[] = [$this->buildInlineKeyBoardButton("Продолжить оплату", "goSaveMyAdress_"),];
					$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];
		}
		} elseif (preg_match("/^\d+$/", $msg)) {
		$price = $msg;
		$kurs = $currency['kurs'];
		$itog_bez_proc = $price / $kurs;
		$percent = $currency_para['percent'];
		$itog = $itog_bez_proc - ($itog_bez_proc * ($percent / 100));
		$scheck = number_format($itog, 8, '.', '');
		
		
		if ($msg < $currency_para['min']) {
		$text_msg = "Сумма меньше минимальной, введите сумму более " . $currency_para['min'] . ' рублей';	
		$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];	
		} else {
			$this->pdo->prepare("UPDATE dle_users SET time_api=? WHERE chat=? ")->execute(array(time(), $chat_id));
		    $this->pdo->prepare("UPDATE dle_users SET time_rez=? WHERE chat=? ")->execute(array(60, $chat_id));
		    $this->pdo->prepare("UPDATE dle_users SET amount_rub=? WHERE chat=? ")->execute(array($msg, $chat_id));
            $this->pdo->prepare("UPDATE dle_users SET amount_crypto=? WHERE chat=? ")->execute(array($scheck, $chat_id));
			
			$this->pdo->prepare("UPDATE dle_users SET amount_rub_orig=? WHERE chat=? ")->execute(array($msg, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET amount_crypto_orig=? WHERE chat=? ")->execute(array($itog_bez_proc, $chat_id));
			
			$text_msg = "<code>Внимательно проверьте все данные!</code>
<code>===============</code>
<b>Вы меняете:</b> {$cur} на {$user['na_chto']}
<b>У вас есть:</b> {$msg} рублей
<b>Вы получите:</b> {$scheck} {$user['na_chto']}
<code>===============</code>
<code>Если Вы хотите изменить сумму платежа, просто отправьте новую сумму и она заменит предыдущую.</code>";	
		

						
					$buttons[] = [$this->buildInlineKeyBoardButton("Продолжить оплату", "goSaveMyAdress_"),];
					$buttons[] = [$this->buildInlineKeyBoardButton("Главное меню", "nochaloBot_0"),];
		}
				} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.\n\nУкажите сумму числом! Без пробелов.";
			$buttons[] = [$this->buildInlineKeyBoardButton("Отменить заявку", "otmena_"),];

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
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = {$user['chto_id']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
		
        $msg = "<code>Процедура обмена</code>
<code>===============</code>
<b>Шаг - 4:</b> Введите ваш <b>{$currency_para['currency_out']}</b> кошелёк, куда будет переведено <b>{$user['amount_crypto']}</b> {$currency_para['currency_out']}.
";
		$search_wallet = $this->pdo->query("SELECT * FROM wallets WHERE chat = ".$chat_id." and currency = '".$currency_para['currency_out']."' ");
	    $search_wallet = $search_wallet->fetchAll();
		
	    if(count($search_wallet) == 0){
		    $buttons[] = [
                $this->buildInlineKeyBoardButton("Создать кошелёк '".$currency_para['currency_out']."'", "saveMyAddressCreate_"),
            ];	
		} else {
		    $buttons[] = [
                $this->buildInlineKeyBoardButton("На личный кошелёк EXORION", "saveMyAddressOrion_" . $currency_para['currency_out']),
            ];	
		}
            $buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "otmena_"),
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
	
	
	
	private function saveMyAddressOrion($data)
    {
		$chat_id = $this->getChatId($data);
		$param = explode("_", $data['data']);
        @$this->setActionUser("pay_crypto", $chat_id);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = {$user['chto_id']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$wallet = $this->pdo->query("SELECT * FROM wallets WHERE currency = '".$param[1]."' and chat = {$chat_id} ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);

		$this->pdo->prepare("UPDATE dle_users SET my_address=? WHERE chat=? ")->execute(array($wallet['address'], $chat_id));
			
			
	    $text_msg = "Идёт создание заявки";
			
		
 				$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);
				sleep(2);
				$this->goObmenCrypto($data);
    }
	
	
	
	

     private function saveMyAddress($msg, $data)
    {
		
        $chat_id = $this->getChatId($data);
		@$this->setActionUser("pay_crypto", $chat_id);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = {$user['chto_id']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/.*/', $msg)) {
		    $this->pdo->prepare("UPDATE dle_users SET my_address=? WHERE chat=? ")->execute(array($msg, $chat_id));
			$this->pdo->prepare("UPDATE dle_users SET time_api=? WHERE chat=? ")->execute(array(time(), $chat_id));
		    $this->pdo->prepare("UPDATE dle_users SET time_rez=? WHERE chat=? ")->execute(array(60, $chat_id));
			
			$text_msg = "Идёт создание заявки";
			
		$search_card = $this->pdo->query("SELECT * FROM req_users WHERE wallet = '".$msg."' and chat = {$chat_id} ");
	    $search_card = $search_card->fetchAll();
		
	    if(count($search_card) == 0){
		$newAddress = $this->pdo->prepare("INSERT INTO req_users SET what = :what, chat = :chat, wallet = :wallet, currency = :currency, bank = :bank");
            $newAddress->execute([
				'what' => 'Крипта',
                'chat' => $chat_id,
				'wallet' => $msg,
				'currency' => $user['na_chto'],
				'bank' => 'NONE'
            ]);	
		}
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.";
        }
 				$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);
				$this->goObmenCrypto($data);

	}
	
	
	
	private function goObmenCrypto($data)
    {
       // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
        $search_card = $this->pdo->query("SELECT * FROM card WHERE active = 'Активна' and what = 'clients' ");
	    $search_card = $search_card->fetchAll();
	    if(count($search_card) == 0){
		$text_msg = 'Нет свободных карт';	
		$buttons[] = [
                $this->buildInlineKeyBoardButton("В главное меню", "nochaloBot_"),
            ];	
		$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);	
		} else {
		
		$card = $this->pdo->query("SELECT * FROM card WHERE active = 'Активна' and what = 'clients' ");
        $card = $card->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = {$user['chto_id']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		$cur = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['chto']."'");
        $cur = $cur->fetch(PDO::FETCH_ASSOC);
		
		$curs = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['na_chto']."'");
        $curs = $curs->fetch(PDO::FETCH_ASSOC);
		
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
		
	    $search_address = $this->pdo->query("SELECT * FROM wallets WHERE currency = '".$user['na_chto']."' and chat = {$chat_id} and address = '".$user['my_address']."' ");
	    $search_address = $search_address->fetchAll();
		
	    if(count($search_address) == 0){
		$kuda = 'На отдельный кошелёк';	
		} else {
		$kuda = 'Личный кошелёк';		
		}
		
		$summ_verify = $this->pdo->prepare("SELECT * FROM transactions WHERE sum_rub = :sum_rub and status = :status");
		$summ_verify->execute(['sum_rub' => $user['amount_rub'], 'status' => 'Ждём оплату']);
		
		if ($summ_verify->rowCount() > 0) {
		$a = $user['amount_rub'];
		$b = $user['amount_rub']+50;
		$catalog_position = $this->pdo->query("SELECT max(sum_rub) as max FROM transactions WHERE `sum_rub` < '".$b."' AND `sum_rub` >= '".$a."' AND status = 'Ждём оплату'");
        $catalog_position = $catalog_position->fetch(PDO::FETCH_ASSOC);
		$maxid = $catalog_position['max']+1;
		$this->pdo->prepare("UPDATE dle_users SET amount_rub=? WHERE chat=? ")->execute(array($maxid, $chat_id));
		} else {
        $maxid = $user['amount_rub'];	
		}
		
		$uniq_id = uniqid(time());
        $time = time() + 3600;
		
		$_monthsList = array(
"1"=>"Январь","2"=>"Февраль","3"=>"Март",
"4"=>"Апрель","5"=>"Май", "6"=>"Июнь",
"7"=>"Июль","8"=>"Август","9"=>"Сентябрь",
"10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");
 
$month = $_monthsList[date("n")];
 
$days = array( 1 => "Понедельник" , "Вторник" , "Среда" , "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );		
		
		
		$params = array(
		'chislo' => date("d"),
		'month' => $month,
		'day' => $days[date( "N" )],
		'number_day_week' => date( "N" ),
		'sendclient_crypto' => $user['amount_crypto'],
		'original_crypto' => $user['amount_crypto_orig'],
		'card_id' => $card['id'],
		'id_bot' => $this->id_bot,
		'id_shop' => NULL, 
		'chat' => $chat_id, 
		'chto' => $user['chto'], 
		'na_chto' => $user['na_chto'], 
		'status' => 'Ждём оплату', 
		'user_id' => $user['id'], 
		'date_create' => time(), 
		'payer_requisites' => $card['number'], 
		'sum_rub' => $maxid, 
		'sum_crypto' => $user['amount_crypto'], 
		'client_requisites' => $user['my_address'], 
		'expire' => $time, 
		'port' => $card['temp'], 
		'uniq_id' => $uniq_id, 
		'wallet_client' => $kuda, 
		'logo_chto' => $cur['logo'], 
		'logo_nachto' => $curs['logo'], 
		'network_chto' => $cur['network'], 
		'network_nachto' => $curs['network'],
		'percent_obmen' => $currency_para['percent']
		);   
		 $q = $this->pdo->prepare("INSERT INTO transactions (
		 chislo,
		 month,
		 day,
		 number_day_week,
		 sendclient_crypto,
		 original_crypto,
		 card_id,
		 id_bot, 
		 id_shop,
		 chat, 
		 chto, 
		 na_chto, 
		 status, 
		 user_id, 
		 date_create, 
		 payer_requisites, 
		 sum_rub, 
		 sum_crypto, 
		 client_requisites, 
		 expire, 
		 port, 
		 uniq_id,
		 wallet_client, 
		 logo_chto, 
		 logo_nachto, 
		 network_chto, 
		 network_nachto,
		 percent_obmen
		 ) 
		 VALUES (
		 :chislo,
		 :month,
		 :day,
		 :number_day_week,
		 :sendclient_crypto,
		 :original_crypto,
		 :card_id,
		 :id_bot,
		 :id_shop, 
		 :chat, 
		 :chto, 
		 :na_chto, 
		 :status, 
		 :user_id, 
		 :date_create, 
		 :payer_requisites, 
		 :sum_rub, 
		 :sum_crypto, 
		 :client_requisites, 
		 :expire, 
		 :port, 
		 :uniq_id, 
		 :wallet_client, 
		 :logo_chto, 
		 :logo_nachto, 
		 :network_chto, 
		 :network_nachto,
		 :percent_obmen
		 )");  
		 $q->execute($params);
		 $idzakaz = $this->pdo->lastInsertId();
		 
		 $date_at_server = date('Y-m-d H:i:s', strtotime("-12 hour"));
		$date_at_user = date('Y-m-d H:i:s', strtotime("-2 hour"));
		$date = date("Y-m-d H:i:s");
		$date_cron = date('Y-m-d H:i:s', strtotime("-2 hour"));
		$date_stop = date('Y-m-d H:i:s', strtotime("+4 hour"));
		$params_cron = array('id' => $idzakaz, 'title' => $idzakaz, 'expression' => '* * * * *', 'status' => 'enabled', 'url' => 'https://exorion.biz/checkcard/'.$idzakaz.'/', 'created_at' => $date_cron, 'user_id' => '1', 'category_id' => '1', 'max_executions' => '100', 'send_at_server' => $date_at_server, 'send_at_user' => $date_at_user );   
        $qcron = $this->pdo->prepare("INSERT INTO webcron_schedule (id, title, expression, status, url, created_at, user_id, category_id, max_executions, send_at_server, send_at_user) 
		VALUES (:id, :title, :expression, :status, :url, :created_at, :user_id, :category_id, :max_executions, :send_at_server, :send_at_user)");  
        $qcron->execute($params_cron);

		$this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(1, $chat_id));
		 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array($idzakaz, $chat_id));
		 $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $user['message_id']]);
		 $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
         $this->activePayCrypto($data);
		}
		}
	
	
	
	private function activePayCrypto($data)
    {
       // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
		$msg = $msg ?? '';
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id} ");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);

        $zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = {$user['zakaz_number']}");
        $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);


        $wallet = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} and currency = '".$user['na_chto']."' ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);
		
		$zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = {$user['zakaz_number']} and chat = {$chat_id} ");
        $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);
		$bot_set = $this->pdo->query("SELECT * FROM bots WHERE id = ".$this->id_bot."");
        $bot_set = $bot_set->fetch(PDO::FETCH_ASSOC);
		
		
		
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
$msg = "Обмен на Ваш кошелёк ".$user['na_chto'].": <b>".$user['my_address']."</b>

До конца заявки: <b>".$minutesRemaining."</b> мин.

<b>Будьте внимательны при переводе, не ошибитесь в сумме и номере карты, можете их скопировать нажатием по сумме и номеру.</b>
";
		$mess = "Вы меняете: <b>".$user['amount_rub']." RUB</b> на <b>".$user['amount_crypto']." ".$user['na_chto']."</b>
┌ Номер заказа: # <code>".$zakaz['id']."</code>
├ Статус заявки: <b>".$zakaz['status']."</b>
├ Переведите: <code>".$zakaz['sum_rub']."</code> руб.
└ Номер карты: <code>".$zakaz['payer_requisites']."</code>

";		
	$buttons[] = [
            $this->buildInlineKeyBoardButton("Отменить заявку", "otmena_" . $user['zakaz_number']),
		];		
$ch = curl_init();
		curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$bot_set['token'].'/sendPhoto',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
			'caption' => $mess,
			'photo' => 'https://exorion.biz/card/nochalo.php?hello='.$zakaz['payer_requisites'].'&nal='.$minutesRemaining.'/'.$zakaz['id'].'&time='.$zakaz['sum_rub'].' RUB',
            'parse_mode' => 'html',
			),
			));
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
	        $this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=? ")->execute(array($array['result']['message_id'], $chat_id));
			
			$ch = curl_init();
		curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$bot_set['token'].'/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
			'text' => $msg,
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons)
			),
			));
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
	        $this->pdo->prepare("UPDATE dle_users SET mess_zak=? WHERE chat=? ")->execute(array($array['result']['message_id'], $chat_id));
	
		}
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	private function goSaveStepOne($data)
    {
        $chat_id = $this->getChatId($data);
        if ($this->setActionUser("step_1_oneapi", $chat_id)) {
            $this->insertSaveStepOne($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
    }

       private function insertSaveStepOne($chat_id, $data)
    {
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);

		$this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=?")->execute(array($data['message']['message_id'], $chat_id));
        $msg = "<code>Регистрация REST API для бизнеса.</code>
=========================
Введите название Вашего магазина.
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

 private function saveSaveStepOne($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE chto = {$user['chto']} and na_chto = {$user['na_chto']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/.*/', $msg)) {
			if ($this->setActionUser("step_1_twoapi", $chat_id)) {
                    $shopnew = $this->pdo->prepare("INSERT INTO shop SET name = :name, chat = :chat, createdate = :createdate");
                    $shopnew->execute([
					'name' => $msg,
					'chat' => $chat_id,
					'createdate' => time()
					]);	
				
				
			$text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
Название: {$msg}
<code>===============</code>
Оборот магазина?
";
		  } else {
			
		$this->sendMessage($chat_id, "Для перехода на главную нажмите /start");	
		}
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.";
        }
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	private function saveSaveStepTwo($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE chto = {$user['chto']} and na_chto = {$user['na_chto']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
		
		
        if (preg_match('/.*/', $msg)) {
			if ($this->setActionUser("step_1_threeapi", $chat_id)) {
		 $params = array('chat' => $chat_id, 'name' => $msg, 'createdate' => time());   
		 $q = $this->pdo->prepare("INSERT INTO shop (chat, name, createdate) 
		 VALUES (:chat, :name, :createdate)");  
		 $q->execute($params);
				
				
				   
			$text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
<b>Название:</b> {$msg}
<code>===============</code>
Оборот магазина?
";
		  } else {
			
		$this->sendMessage($chat_id, "Для перехода на главную нажмите /start");	
		}
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.";
        }
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	
	private function saveSaveStepThree($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$shopnew = $this->pdo->query("SELECT * FROM shop WHERE chat = {$chat_id} ORDER BY id DESC");
        $shopnew = $shopnew->fetch(PDO::FETCH_ASSOC);
		
        if (preg_match("/^\d+$/", $msg)) {
			if ($this->setActionUser("step_1_fourapi", $chat_id)) {

		 $this->pdo->prepare("UPDATE shop SET oborot=? WHERE chat=? ORDER BY id DESC")->execute(array($msg, $chat_id));
		
				
				   
			$text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
<b>Название:</b> {$shopnew['name']}
<b>Оборот:</b> {$msg}
<code>===============</code>
Ветка на форумах, если нету то напишите - нету.
";
		  } else {
			
		$this->sendMessage($chat_id, "Для перехода на главную нажмите /start");	
		}
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз. Оборот можно указать только числами.";
        }
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	private function saveSaveStepFour($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$shopnew = $this->pdo->query("SELECT * FROM shop WHERE chat = {$chat_id} ORDER BY id DESC");
        $shopnew = $shopnew->fetch(PDO::FETCH_ASSOC);
		
        if (preg_match("/.*/", $msg)) {
			if ($this->setActionUser("step_1_fiveapi", $chat_id)) {

		 $this->pdo->prepare("UPDATE shop SET vetka=? WHERE chat=? ORDER BY id DESC")->execute(array($msg, $chat_id));
		
				
				   
			$text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
<b>Название:</b> {$shopnew['name']}
<b>Оборот:</b> {$shopnew['oborot']}
<b>Ветка:</b> {$msg}
<code>===============</code>
Сайт магазина если есть, если нету, то так и пишите - нету.
";
		  } else {
			
		$this->sendMessage($chat_id, "Для перехода на главную нажмите /start");	
		}
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз. Оборот можно указать только числами.";
        }
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
		private function saveSaveStepFive($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$shopnew = $this->pdo->query("SELECT * FROM shop WHERE chat = {$chat_id} ORDER BY id DESC");
        $shopnew = $shopnew->fetch(PDO::FETCH_ASSOC);
		
        if (preg_match("/.*/", $msg)) {

		 $this->pdo->prepare("UPDATE shop SET site=? WHERE chat=? ORDER BY id DESC")->execute(array($msg, $chat_id));
		
				
				   
			$text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
<b>Название:</b> {$shopnew['name']}
<b>Оборот:</b> {$shopnew['oborot']}
<b>Ветка:</b> {$shopnew['vetka']}
<b>Сайт:</b> {$msg}
<code>===============</code>
Нужен ли вам бот и сайт автопродаж?
";
            $buttons[] = [
			    $this->buildInlineKeyBoardButton("Да, нужен", "goContact_yes"),
                $this->buildInlineKeyBoardButton("Нет, не нужен", "nochaloBot_no"),
            ];
		 
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз. Оборот можно указать только числами.";
        }
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

            $fields = $text_msg;
            $this->botApiQuery("sendMessage", $fields);
	}
	
	
	private function goContact($data)
    {
        $chat_id = $this->getChatId($data);
        if ($this->setActionUser("step_6_contact", $chat_id)) {
            $this->insertContact($chat_id, $data);
        } else {
            $this->notice($data['id'], "Ошибка");
        }
    }

       private function insertContact($chat_id, $data)
    {
		$param = explode("_", $data['data']);
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$this->pdo->prepare("UPDATE shop SET botandsite=? WHERE chat=? ORDER BY id DESC")->execute(array($param[1], $chat_id));
		$shopnew = $this->pdo->query("SELECT * FROM shop WHERE chat = {$chat_id} ORDER BY id DESC");
        $shopnew = $shopnew->fetch(PDO::FETCH_ASSOC);
		
        if ($param[1] == 'yes') {
		$bot = 	'Да, нужен';
		} elseif ($param[1] == 'no') {
		$bot = 	'Нет, не нужен';
		}
       $text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
<b>Название:</b> {$shopnew['name']}
<b>Оборот:</b> {$shopnew['oborot']}
<b>Ветка:</b> {$shopnew['vetka']}
<b>Сайт:</b> {$shopnew['site']}
<b>Нужен ли вам бот и сайт:</b> {$bot}
<code>===============</code>
Укажите Ваш контакт для связи.
";
            $buttons[] = [
                $this->buildInlineKeyBoardButton("Отменить", "nochaloBot_"),
            ];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

    }

 private function saveContact($msg, $data)
    {
        $chat_id = $this->getChatId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$shopnew = $this->pdo->query("SELECT * FROM shop WHERE chat = {$chat_id} ORDER BY id DESC");
        $shopnew = $shopnew->fetch(PDO::FETCH_ASSOC);
        if (preg_match('/.*/', $msg)) {
		$this->pdo->prepare("UPDATE shop SET contact=? WHERE chat=? ORDER BY id DESC")->execute(array($msg, $chat_id));
		   if ($shopnew['botandsite'] == 'yes') {
		$bot = 	'Да, нужен';
		} elseif ($shopnew['botandsite'] == 'no') {
		$bot = 	'Нет, не нужен';
		}		
				
			$text_msg = "<code>Регистрация REST API для бизнеса.</code>
<code>===============</code>
<b>Название:</b> {$shopnew['name']}
<b>Оборот:</b> {$shopnew['oborot']}
<b>Ветка:</b> {$shopnew['vetka']}
<b>Сайт:</b> {$shopnew['site']}
<b>Нужен ли вам бот и сайт:</b> {$bot}
<b>Контакт для связи:</b> {$msg}
<code>===============</code>
<b>Заявка успешно отправлена на рассмотрение админом, сегодня с Вами свяжутся.</b>
";
		} else {
            $text_msg = "Ошибка в веденных данных, попробуйте еще раз.";
        }
		    $buttons[] = [
                $this->buildInlineKeyBoardButton("Вернуться на главную", "nochaloBot_"),
            ];
		    $this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => $text_msg, 'message_id' => $user['message_id'], 'reply_markup' => $this->buildInlineKeyBoard($buttons), 'parse_mode' => 'html']);

	}
	

		
		
		
		private function goObmenVisa($data)
    {
       // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
		
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
		$wallet = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} and currency = '".$user['chto']."' ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);
		
		$card = $this->pdo->query("SELECT * FROM card WHERE active = 'Активна' and what = 'clients' ");
        $card = $card->fetch(PDO::FETCH_ASSOC);
		
		$currency_para = $this->pdo->query("SELECT * FROM currency_para WHERE id = {$user['chto_id']}");
        $currency_para = $currency_para->fetch(PDO::FETCH_ASSOC);
				$bot_set = $this->pdo->query("SELECT * FROM bots WHERE id = ".$this->id_bot."");
        $bot_set = $bot_set->fetch(PDO::FETCH_ASSOC);
         $cur = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['chto']."'");
         $cur = $cur->fetch(PDO::FETCH_ASSOC);
		 $coinbase = $this->pdo->query("SELECT * FROM exchanges WHERE what = 'Клиенты' and active = '1'");
         $coinbase = $coinbase->fetch(PDO::FETCH_ASSOC);
		  $curs = $this->pdo->query("SELECT * FROM currency_in WHERE nominal = '".$user['na_chto']."'");
          $curs = $curs->fetch(PDO::FETCH_ASSOC);
		  
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);

        $uniq_id = uniqid(time());
		$time = time() + 3600;
		$search_wallet = $this->pdo->query("SELECT * FROM wallets WHERE currency = '".$user['chto']."' and chat = {$chat_id} ");
	    $search_wallet = $search_wallet->fetchAll();
	    if(count($search_wallet) == 0){
        $API_KEY = $coinbase['api_key'];
	    $API_SECRET = $coinbase['api_secret']; 
		$USER_ID = $cur['user_id'];
		$timestamp = time();
		$method = "POST";
		$path = '/v2/accounts/' . $USER_ID . '/addresses';
		$body = json_encode(array(
		'name' => 'New receive address'
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
		
		    $newAddress = $this->pdo->prepare("INSERT INTO wallets SET currency = :currency, address = :address, chat = :chat, wallet_id = :wallet_id, qr = :qr, network = :network");
            $newAddress->execute([
				'currency' => $user['chto'],
                'address' => $arr['data']['address'],
				'chat' => $chat_id,
				'wallet_id' => $arr['data']['id'],
				'qr' => "https://www.bitcoinqrcodemaker.com/api/?style=".$arr['data']['network']."&border=5&color=3&address=".$arr['data']['address'],
				'network' => $arr['data']['network']
            ]);
			
         $wallet_client = $arr['data']['address'];
		} else {
		 $wallet_client = $wallet['address'];
		}
		
		$msg = 'Идёт создание заявки';	
		
				$_monthsList = array(
"1"=>"Январь","2"=>"Февраль","3"=>"Март",
"4"=>"Апрель","5"=>"Май", "6"=>"Июнь",
"7"=>"Июль","8"=>"Август","9"=>"Сентябрь",
"10"=>"Октябрь","11"=>"Ноябрь","12"=>"Декабрь");
 
$month = $_monthsList[date("n")];
 
$days = array( 1 => "Понедельник" , "Вторник" , "Среда" , "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );	
$prcie   = $user['amount_rub_orig'];
$percent = $currency_para['percent'];
$obmen_plus = $prcie * ($percent / 100);  // 200

		 $params = array(
		 'confirm' => $currency_para['confirm'],
		 'obmen_plus' => $obmen_plus,
		 'chislo' => date("d"),
		 'month' => $month,
		 'day' => $days[date( "N" )],
		 'number_day_week' => date( "N" ),
		 'id_bot' => $this->id_bot, 
		 'id_shop' => NULL, 
		 'chat' => $chat_id, 
		 'chto' => $user['chto'], 
		 'na_chto' => $user['na_chto'], 
		 'status' => 'Ждём оплату', 
		 'user_id' => $user['id'], 
		 'date_create' => time(), 
		 'payer_requisites' => $wallet_client, 
		 'sum_rub' => $user['amount_rub'], 
		 'sum_crypto' => $user['amount_crypto'], 
		 'client_requisites' => $user['my_card'], 
		 'logo_chto' => $cur['logo'], 
		 'logo_nachto' => $curs['logo'], 
		 'network_chto' => $cur['network'], 
		 'network_nachto' => $curs['network'], 
		 'uniq_id' => $uniq_id, 
		 'expire' => $time, 
		 'percent_obmen' => $currency_para['percent'] 
		 );   
		 $q = $this->pdo->prepare("INSERT INTO transactions (
		 confirm,
		 obmen_plus,
		 chislo,
		 month,
		 day,
		 number_day_week,
		 id_bot, 
		 id_shop, 
		 chat, 
		 chto, 
		 na_chto, 
		 status, 
		 user_id, 
		 date_create, 
		 payer_requisites, 
		 sum_rub, 
		 sum_crypto, 
		 client_requisites, 
		 logo_chto, 
		 logo_nachto, 
		 network_chto, 
		 network_nachto, 
		 uniq_id, 
		 expire, 
		 percent_obmen
		 ) 
		 VALUES (
		 :confirm,
		 :obmen_plus,
		 :chislo,
		 :month,
		 :day,
		 :number_day_week,
		 :id_bot, 
		 :id_shop, 
		 :chat, 
		 :chto, 
		 :na_chto, 
		 :status, 
		 :user_id, 
		 :date_create, 
		 :payer_requisites, 
		 :sum_rub, 
		 :sum_crypto, 
		 :client_requisites, 
		 :logo_chto, 
		 :logo_nachto, 
		 :network_chto, 
		 :network_nachto, 
		 :uniq_id, 
		 :expire, 
		 :percent_obmen
		 )");  
		 $q->execute($params);
		 $idzakaz = $this->pdo->lastInsertId();
		
		$date_at_server = date('Y-m-d H:i:s', strtotime("-12 hour"));
		$date_at_user = date('Y-m-d H:i:s', strtotime("-2 hour"));
		$date = date("Y-m-d H:i:s");
		$date_cron = date('Y-m-d H:i:s', strtotime("-2 hour"));
		$date_stop = date('Y-m-d H:i:s', strtotime("+4 hour"));
		$params_cron = array('id' => $idzakaz, 'title' => $idzakaz, 'expression' => '* * * * *', 'status' => 'enabled', 'url' => 'https://exorion.biz/check/'.$idzakaz.'/', 'created_at' => $date_cron, 'user_id' => '1', 'category_id' => '1', 'max_executions' => '100', 'send_at_server' => $date_at_server, 'send_at_user' => $date_at_user );   
        $qcron = $this->pdo->prepare("INSERT INTO webcron_schedule (id, title, expression, status, url, created_at, user_id, category_id, max_executions, send_at_server, send_at_user) 
		VALUES (:id, :title, :expression, :status, :url, :created_at, :user_id, :category_id, :max_executions, :send_at_server, :send_at_user)");  
        $qcron->execute($params_cron);

		 $this->pdo->prepare("UPDATE dle_users SET zakaz=? WHERE chat=?")->execute(array(1, $chat_id));
		 $this->pdo->prepare("UPDATE dle_users SET zakaz_number=? WHERE chat=?")->execute(array($idzakaz, $chat_id));
		 $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $user['message_id']]);
		 $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
			
			
			$ch = curl_init();
		curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$bot_set['token'].'/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
			'text' => $msg,
            'parse_mode' => 'html'
			),
			));
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			$this->pdo->prepare("UPDATE dle_users SET mess_zak3=? WHERE chat=? ")->execute(array($array['result']['message_id'], $chat_id));
			sleep(1);
			
            $this->activePayVisa($data);
		}




private function activePayVisa($data)
    {
       // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
        @$this->setActionUser("show_zakaz", $chat_id);

        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id}");
        $user = $user->fetch(PDO::FETCH_ASSOC);
				$bot_set = $this->pdo->query("SELECT * FROM bots WHERE id = ".$this->id_bot."");
        $bot_set = $bot_set->fetch(PDO::FETCH_ASSOC);
		$wallet = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} and currency = '".$user['chto']."' ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);
		
		$this->botApiQuery("editMessageText", ['chat_id' => $chat_id, 'text' => 'Заявка успешно создана...', 'message_id' => $user['mess_zak3'], 'parse_mode' => 'html']);
        
		$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $message_id]);
		$get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);
		
		   
		$msg = "
Вы меняете: <b>".$user['amount_crypto']." ".$user['chto']."</b> на <b>".$user['amount_rub']." ".$user['na_chto']." [RUB]</b>
На карту: <b>".$user['my_card']."</b>
";
		
		$ch = curl_init();
		curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$bot_set['token'].'/sendVideo',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
			'video' => 'http://exorion.biz/assets/pay_btc.mp4',
			'caption' => $msg,
            'parse_mode' => 'html',
			),
			));
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			$this->pdo->prepare("UPDATE dle_users SET mess_zak=? WHERE chat=? ")->execute(array($array['result']['message_id'], $chat_id));
        sleep(3);		
		$this->activePayVisaRezTime($data);
	
		}
private function activePayVisaRezTime($data)
    {
       // получаем данные
        $chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
		$msg = $msg ?? '';
        $user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id} ");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		$this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);

        $zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = {$user['zakaz_number']}");
        $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);
	
        $wallet = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} and currency = '".$user['chto']."' ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);
		
		$zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = {$user['zakaz_number']} and chat = {$chat_id} ");
        $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);

        
		$bot_set = $this->pdo->query("SELECT * FROM bots WHERE id = ".$this->id_bot."");
        $bot_set = $bot_set->fetch(PDO::FETCH_ASSOC);
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

		$mess = "
┌ Номер заказа: #<b>".$user['zakaz_number']."</b>
├ Статус заявки: <b>".$zakaz['status']."</b>
├ До конца заявки: <b>".$minutesRemaining."</b> мин.
└ Переведите: <b>".$user['amount_crypto']."</b> ".$user['chto']." на реквизиты ниже.

<code>".$wallet['address']."</code>

Если вы ошиблись суммой, ничего страшного, деньги зачислятся на ваш счёт в боте, далее вы сможете их обменять прямо со счёта.
";
$buttons[] = [
            $this->buildInlineKeyBoardButton("Оплатить по QR коду", "qrcode_"),
		];		
	$buttons[] = [
            $this->buildInlineKeyBoardButton("Отменить заявку", "otmena_" . $user['zakaz_number']),
		];		
	   $ch = curl_init();
		curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot'.$bot_set['token'].'/sendMessage',
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
			'text' => $mess,
            'parse_mode' => 'html',
			'reply_markup' => $this->buildInlineKeyBoard($buttons)
			),
			));
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
	        $this->pdo->prepare("UPDATE dle_users SET message_id=? WHERE chat=? ")->execute(array($array['result']['message_id'], $chat_id));
	
		}
		
		
		private function qrcode($data)
    {
		
		$chat_id = $this->getChatId($data);
        $message_id = $this->getMessageId($data);
		
		$user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = {$chat_id} ");
        $user = $user->fetch(PDO::FETCH_ASSOC);
		
        $get_set = $this->pdo->query("SELECT * FROM necro_setting");
        $get_set = $get_set->fetch(PDO::FETCH_ASSOC);

        $zakaz = $this->pdo->query("SELECT * FROM transactions WHERE id = {$user['zakaz_number']}");
        $zakaz = $zakaz->fetch(PDO::FETCH_ASSOC);


        $wallet = $this->pdo->query("SELECT * FROM wallets WHERE chat = {$chat_id} and currency = '".$user['chto']."' ");
        $wallet = $wallet->fetch(PDO::FETCH_ASSOC);

		$msg = $wallet['address'] . ' 
' . $user['amount_crypto'] . ' ' . $wallet['currency'];

	$buttons[] = [
            $this->buildInlineKeyBoardButton("Вернуться к заявке", "activePayVisaRezTime_"),
		];	

        $data_send = [
            'chat_id' => $chat_id,
            'photo' => $wallet['qr'],
			'caption' => $msg,
            'parse_mode' => 'html',
        ];
		
        // проверяем наличие кнопок
        if (is_array($buttons)) {
            $data_send['reply_markup'] = $this->buildInlineKeyBoard($buttons);
        }
        // отправляем сообщение
        $this->botApiQuery("sendPhoto", $data_send);
	    $this->botApiQuery("deleteMessage", ['chat_id' => $chat_id, 'message_id' => $data['message']['message_id']]);

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
				$wallet_id3 = 'qr_btc';
		        } elseif ($action == 'LTC') {
		        $crypto_id = $this->api_ltc_id;
				$wallet = 'ltc_wallet = :ltc_wallet';
				$wallet2 = 'ltc_wallet';
				$qr = 'litecoin';
				$wallet_id = 'ltc_id = :ltc_id';
				$wallet_id2 = 'ltc_id';
				$wallet_id3 = 'qr_ltc';
		        } elseif ($action == 'ETH') {
		        $crypto_id = $this->api_eth_id;
				$wallet = 'eth_wallet = :eth_wallet';
				$wallet2 = 'eth_wallet';
				$wallet_id2 = 'eth_id';
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
				
        $insertSql = $this->pdo->prepare("UPDATE dle_users SET ".$wallet.", ".$wallet_id.", ".$wallet_id3." = :".$wallet_id3." WHERE chat = :chat");
        return $insertSql->execute([$wallet2 => $arr['data']['address'], $wallet_id2 => $arr['data']['id'], $wallet_id3 => 'https://www.bitcoinqrcodemaker.com/api/?style='.$qr.'&border=5&color=3&address='.$arr['data']['address'],  'chat' => $chat_id]);
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
		$bot_set = $this->pdo->query("SELECT * FROM bots WHERE id = ".$this->id_bot."");
        $bot_set = $bot_set->fetch(PDO::FETCH_ASSOC);
		
        $ch = curl_init('https://api.telegram.org/bot' . $bot_set['token'] . '/' . $method);
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