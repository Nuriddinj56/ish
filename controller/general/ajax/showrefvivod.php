<?PHP
$text = $_GET["zakaz"];
$zayavka = $this->pdo->query("SELECT * FROM conclusion_referals WHERE id = '".$text."'");
$zayavka = $zayavka->fetch(PDO::FETCH_ASSOC);
$ref_user = $this->pdo->query("SELECT * FROM dle_users WHERE chat = '".$zayavka['chat']."'");
$ref_user = $ref_user->fetch(PDO::FETCH_ASSOC);

 if($zayavka['currency'] == 'VISA'){

$sum = $zayavka['sum_rub'] . ' ₽';
$req = '<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">На карту:</span><br><span style="color:#bfc9d4;font-weight:600;">'.$zayavka['requisites'].'</span>';	 
 } else {
	
$sum = $zayavka['sum_rub'].' ₽, ('.$zayavka['sum_crypto'].' '.$zayavka['currency'].')';
$req = '<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">На  '.$zayavka['currency'].' кошелёк:</span><br><span style="color:#bfc9d4;font-weight:600;">'.$zayavka['requisites'].'</span><br><button id="btns" class="btn btn-sm btn-dark">Вставить в поле перевода</button>';		
 }

$time_add = date('Y-m-d H:i:s', $zayavka['date']);
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
?>
<?php
$saleone = $zayavka['requisites'];
?>

<div
  class='hiddensss'
  data-eithing='<?= $saleone ?>'
></div>
<ul class="list-group list-group-icons-meta">
<li class="list-group-item list-group-item-action active">
<div class="media">
<div class="media-body">
<h6 class="tx-inverse"><span style="color:#009688;font-weight:600;font-size:0.8rem;">Заявка номер: #<?php echo $zayavka['id'];?> </span></h6>
<p class="mg-b-0">
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Пользователь:</span><br><span style="color:#bfc9d4;font-weight:600;"><?php echo $ref_user['last_name'];?> <?php echo $ref_user['first_name'];?></span><br>
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Сумма вывода:</span><br><span style="color:#bfc9d4;font-weight:600;"><?php echo $sum;?></span><br>
<?php echo $req;?><br>
<span style="font-weight:600;font-size:0.7rem;color:#607d8b;">Дата обновления заявки:</span><br><span style="color:#bfc9d4;font-weight:600;"><?php echo $datetime_create;?></span>

<script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
<script>
var myEithing = $('div.hiddensss').data('eithing');
$('#btns').click(function(){
	$('#adress_ref').val(myEithing);
});
</script>
</p>
</div>
</div>
</li>
</ul>

								