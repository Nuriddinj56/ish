<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$date_now = date('Y-m-d');
$get_stat_day = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE status_payclient = 'Оплата получена' and date = '".$date_now."' ");
$get_stat_day =  $get_stat_day->fetch(PDO::FETCH_ASSOC);
if (!$get_stat_day['sum_rub']):
	$get_stat_day['sum_rub'] = 0;
endif;
$get_out_day = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE status_payclient = 'Оплата получена' and date = '".$date_now."'");
$get_out_day =  $get_out_day->fetch(PDO::FETCH_ASSOC);
if (!$get_out_day['out_summ']):
	$get_out_day['out_summ'] = 0;
endif;

$get_stat_day = number_format($get_stat_day['sum_rub']);
$get_out_day = number_format($get_out_day['out_summ']);

?>
<div class="w-a-info funds-received">
<span><center>Поступления <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></center> </span>
<p><?=$get_stat_day?> ₽</p>
</div>
<div class="w-a-info funds-spent">
<span><center>Выплачено <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></center></span>
<p><?=$get_out_day?> ₽</p>
</div>