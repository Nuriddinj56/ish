<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$date_now = date('Y-m-d');
$get_stat_day = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions_referals WHERE status = 'Зачислено' and date_full = '".$date_now."' ");
$get_stat_day =  $get_stat_day->fetch(PDO::FETCH_ASSOC);
if (!$get_stat_day['sum_rub']):
	$get_stat_day['sum_rub'] = 0;
endif;
$get_out_day = $this->pdo->query("SELECT SUM(balance_referal) AS balance_referal FROM dle_users");
$get_out_day =  $get_out_day->fetch(PDO::FETCH_ASSOC);
if (!$get_out_day['balance_referal']):
	$get_out_day['balance_referal'] = 0;
endif;

$get_stat_day = number_format($get_stat_day['sum_rub']);
$get_out_day = number_format($get_out_day['balance_referal']);

?>
<div class="w-a-info funds-received">
<span><center>Поступления <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></center> </span>
<p style="font-size:0.8rem;"><?=$get_stat_day?> ₽</p>
</div>

<div class="w-a-info funds-spent">
<span><center>На счетах <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></center></span>
<p style="font-size:0.8rem;"><?=$get_out_day?> ₽</p>
</div>
