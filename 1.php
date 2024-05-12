<?php
/*         $price = 2000;
		$percent = 20;
		$its = $price - ($price * ($percent / 100));
		$kurs = '7507.41749999996824500700000003307388';
		$itog_bez_proc = $its / $kurs;
		$scheck = number_format($itog_bez_proc, 8, '.', '');
echo $_POST['end']; */

$order_id = 618073;
$curl = curl_init();
			  curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://orionbtc.xyz/api_v1/order/',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => array('id' => $order_id),
			  CURLOPT_HTTPHEADER => array(
			  'Authorization: Api-Key P9r2HiPu.fjCq7ccttuXotZ1qNBEOkK5v6ltnrQl1'
			  ),
			  ));
			      $response = curl_exec($curl);
				  curl_close($curl);
				  $jsonString = $response;
				  $api = json_decode( $jsonString );

echo $response;