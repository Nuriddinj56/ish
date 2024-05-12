<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$get_set = $this->pdo->query("SELECT * FROM `necro_setting` WHERE id = '1' ");
$get_set = $get_set->fetch(PDO::FETCH_ASSOC);

$category = $this->pdo->query("SELECT DISTINCT chat FROM transactions_referals");
while ($row = $category->fetch()) {
	
	    $date_now = date('Y-m-d');
    $sum_rub = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions_referals WHERE  chat = '".$row['chat']."' and date_full = '".$date_now."' ");
	$sum_rub =  $sum_rub->fetch(PDO::FETCH_ASSOC);
	if (!$sum_rub['sum_rub']):
	$sum_rub['sum_rub'] = 0;
	endif;
	
$get_ref = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$row['chat']."' ");
$get_ref = $get_ref->fetch(PDO::FETCH_ASSOC);
?>
<div class="wallet-balance" style="margin-top:0;">
<p style="font-size:0.8rem;">
<?=$get_ref['last_name'];?> <?=$get_ref['first_name'];?> (На счету <?=$get_ref['balance_referal'];?> ₽)
</p>
<p style="font-size:0.8rem;"><?=$sum_rub['sum_rub'];?> ₽</p>
</div>
<?
}
?>