<?
		$money_all = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' ");
		$money_all =  $money_all->fetch(PDO::FETCH_ASSOC);
		if (!$money_all['obmen_plus']):
		$money_all['obmen_plus'] = 0;
		endif;
	$sum_end = 10000000;
    $sum = $money_all['obmen_plus'];
 
    $percent = ($sum / $sum_end) * 100;
    $percent_cell = round($percent) . '%';  // 30%

?>

<div class="w-progress-stats">
<div class="progress">
<div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: <?=$percent_cell?>" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<div class="">
<div class="w-icon">
<p><?=$percent_cell?></p>
</div>
</div>
</div>