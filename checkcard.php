<?php

$card = $_POST['number'];
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
				  $name = $api->bankLocalName;
				  $logo = $api->bankLogoBigInvertedPng;
				  $filename = $logo;
				  $filssss = basename($filename); // file.png
				  // Каталог files
				  $link = $filename;
				  $uploaddir = './images/';
				  $uploadfile = $uploaddir.basename($link);
				  // Копируем файл в files
				  if (copy($link, $uploadfile)){
					  }
				  $data['result'] = $name;
				  $data['logo'] = '/images/'.$filssss.'';
		if(!empty($api->bankLocalName)) {
		$home = $_SERVER['DOCUMENT_ROOT'].'/';
        require_once $home . "classes/Db.php";
		$db = new Db();
		$ordercard = $db->connect()->prepare("SELECT * FROM card WHERE number = :number");
		$ordercard->execute(['number' => $card]);
		$data['resultat'] = 'success';
	    $data['mess'] = '<img class="" width="35" src="'.$api->bankLogoSmallOriginalPng.'" alt=""> '.$api->bankLocalName.' карта определена.';
		if ($ordercard->rowCount() == 0) {
		$order = $db->connect()->prepare("SELECT * FROM banks WHERE name_rus = :name_rus");
		$order->execute(['name_rus' => $api->bankLocalName]);
		// если запись есть то работаем
		if ($order->rowCount() == 0) {
            $newUser = $db->connect()->prepare("INSERT INTO banks SET name_rus = :name_rus, name_lat = :name_lat, logo_mini = :logo_mini");
            $newUser->execute([
			    'name_rus' => $api->bankLocalName,
				'name_lat' => $api->bankName,
                'logo_mini' => $data['logo']
            ]);		
		}
		}
		}		
				  echo json_encode($data);