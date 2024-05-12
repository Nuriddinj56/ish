<?
		$money_all = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' ");
		$money_all =  $money_all->fetch(PDO::FETCH_ASSOC);
		if (!$money_all['obmen_plus']):
		$money_all['obmen_plus'] = 0;
		endif;
		
		$money_all = number_format($money_all['obmen_plus']);
		echo $money_all . ' ₽';
?>