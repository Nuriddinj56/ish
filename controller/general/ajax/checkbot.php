<?php
 $ch = curl_init('https://api.telegram.org/bot'.$_POST['token'].'/GetMe');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, false);
			$html = curl_exec($ch);
			curl_close($ch);
			$jsonString = $html;
			$array = json_decode($jsonString, true);
			if($array['ok'] == true){
				echo '<div class="alert alert-light-success border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>';
				echo '<b>Есть такой бот:</b></strong><br>';
				echo 'ID: '.$array['result']['id'].'<br>';
				echo 'Имя: '.$array['result']['first_name'].'<br>';
				echo 'Username: '.$array['result']['username'].'<br>';
                echo '<hr><b>Вы можете добавить и активировать бота</b>';
				echo '</div>';				
			} else {
				echo '<div class="alert alert-light-danger border-0 mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>';
				echo '<b>Ошибка:</b></strong><br>';
				echo 'Номер ошибки: '.$array['error_code'].'<br>';
				echo 'Описание ошибки: '.$array['description'].'<br>';
				echo '</div>';
			}