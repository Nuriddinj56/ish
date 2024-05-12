<? include './template/template_header.tpl';
if (empty($_SESSION['user_id'])):
header('Location: /auth/');
exit;
endif;
	$insertSql = $this->pdo->prepare("INSERT INTO activity_admin SET user_id = :user_id, text = :text, date = :date");
	$insertSql->execute([
		'user_id' => $_SESSION['user_id'],
		'text' => 'На главной админки',
		'date' => time()
		]);
if (count($total_card) < 2) :
echo 'Что бы видеть статистику нужно сначала всё настроить.<br>Добавьте минимум 2 <b>активных</b> карты.';
else:
$getshops = $this->pdo->query("SELECT * FROM `shop` order by oborot DESC LIMIT 3");
$getshops = $getshops->fetch(PDO::FETCH_ASSOC);
$getcurrency = $this->pdo->query("SELECT * FROM `currency_in` WHERE id != '4'");
$getcurrency = $getcurrency->fetchAll();
$getcurrency_api = $this->pdo->query("SELECT * FROM `currency_in` WHERE id != '4'");
$getcurrency_api = $getcurrency_api->fetchAll();
$getcard_one = $this->pdo->query("SELECT * FROM card WHERE what = 'shops' and active = 'Активна' ");
$getcard_one = $getcard_one->fetch(PDO::FETCH_ASSOC);
$getcard_two = $this->pdo->query("SELECT * FROM card WHERE id != ".$getcard_one['id']." and active = 'Активна' ");
$getcard_two = $getcard_two->fetch(PDO::FETCH_ASSOC);
$get_user = $this->pdo->query("SELECT * FROM dle_users WHERE id = ".$_SESSION['user_id']." ");
$get_user = $get_user->fetch(PDO::FETCH_ASSOC);
$card_cashone = number_format($getcard_one['balance']); //output: 5,000,000
$card_cashtwo = number_format($getcard_two['balance']);
$date_now = date('Y-m-d');
$new_user = $this->pdo->query("SELECT * FROM dle_users WHERE reg_date = '".$date_now."' ");
$new_user = $new_user->fetchAll();
$total_new_user = count($new_user);
$date_now = date('Y-m-d',strtotime("-1 days"));
$new_user_yestuday = $this->pdo->query("SELECT * FROM dle_users WHERE reg_date = '".$date_now."' ");
$new_user_yestuday = $new_user_yestuday->fetchAll();
$total_new_user_yestuday = count($new_user_yestuday);
$date_now = date('Y-m-d');
$total_orders = $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders = $total_orders->fetchAll();
$total_orders_bro = count($total_orders);
$date_now = date('Y-m-d',strtotime("-1 days"));
$total_orders_yestuday= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_yestuday = $total_orders_yestuday->fetchAll();
$total_orders_bro_yestuday = count($total_orders_yestuday);
$date_now = date('Y-m-d',strtotime("-2 days"));
$total_orders_2day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_2day = $total_orders_2day->fetchAll();
$total_orders_bro_2day = count($total_orders_2day);
$date_now = date('Y-m-d',strtotime("-3 days"));
$total_orders_3day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_3day = $total_orders_3day->fetchAll();
$total_orders_bro_3day = count($total_orders_3day);
$date_now = date('Y-m-d',strtotime("-4 days"));
$total_orders_4day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_4day = $total_orders_4day->fetchAll();
$total_orders_bro_4day = count($total_orders_4day);
$date_now = date('Y-m-d',strtotime("-5 days"));
$total_orders_5day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_5day = $total_orders_5day->fetchAll();
$total_orders_bro_5day = count($total_orders_5day);
$date_now = date('Y-m-d',strtotime("-6 days"));
$total_orders_6day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_6day = $total_orders_6day->fetchAll();
$total_orders_bro_6day = count($total_orders_6day);
	$date_now = date('Y-m-d',strtotime("-7 days"));
$total_orders_7day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_7day = $total_orders_7day->fetchAll();
$total_orders_bro_7day = count($total_orders_7day);
	$date_now = date('Y-m-d',strtotime("-8 days"));
$total_orders_8day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_8day = $total_orders_8day->fetchAll();
$total_orders_bro_8day = count($total_orders_8day);
	$date_now = date('Y-m-d',strtotime("-9 days"));
$total_orders_9day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_9day = $total_orders_9day->fetchAll();
$total_orders_bro_9day = count($total_orders_9day);
		$date_now = date('Y-m-d',strtotime("-10 days"));
$total_orders_10day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' ");
$total_orders_10day = $total_orders_10day->fetchAll();
$total_orders_bro_10day = count($total_orders_10day);
$date_now = date('Y-m-d');
$total_orders_pay = $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay = $total_orders_pay->fetchAll();
$total_orders_pay_bro = count($total_orders_pay);
$date_now = date('Y-m-d',strtotime("-1 days"));
$total_orders_pay_yestuday= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_yestuday = $total_orders_pay_yestuday->fetchAll();
$total_orders_pay_bro_yestuday = count($total_orders_pay_yestuday);
$date_now = date('Y-m-d',strtotime("-2 days"));
$total_orders_pay_2day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_2day = $total_orders_pay_2day->fetchAll();
$total_orders_pay_bro_2day = count($total_orders_pay_2day);
$date_now = date('Y-m-d',strtotime("-3 days"));
$total_orders_pay_3day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_3day = $total_orders_pay_3day->fetchAll();
$total_orders_pay_bro_3day = count($total_orders_pay_3day);
$date_now = date('Y-m-d',strtotime("-4 days"));
$total_orders_pay_4day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_4day = $total_orders_pay_4day->fetchAll();
$total_orders_pay_bro_4day = count($total_orders_pay_4day);
$date_now = date('Y-m-d',strtotime("-5 days"));
$total_orders_pay_5day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_5day = $total_orders_pay_5day->fetchAll();
$total_orders_pay_bro_5day = count($total_orders_pay_5day);
$date_now = date('Y-m-d',strtotime("-6 days"));
$total_orders_pay_6day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_6day = $total_orders_pay_6day->fetchAll();
$total_orders_pay_bro_6day = count($total_orders_pay_6day);
	$date_now = date('Y-m-d',strtotime("-7 days"));
$total_orders_pay_7day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_7day = $total_orders_pay_7day->fetchAll();
$total_orders_pay_bro_7day = count($total_orders_pay_7day);
	$date_now = date('Y-m-d',strtotime("-8 days"));
$total_orders_pay_8day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_8day = $total_orders_pay_8day->fetchAll();
$total_orders_pay_bro_8day = count($total_orders_pay_8day);
	$date_now = date('Y-m-d',strtotime("-9 days"));
$total_orders_pay_9day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_9day = $total_orders_pay_9day->fetchAll();
$total_orders_pay_bro_9day = count($total_orders_pay_9day);
		$date_now = date('Y-m-d',strtotime("-10 days"));
$total_orders_pay_10day= $this->pdo->query("SELECT * FROM transactions WHERE date = '".$date_now."' and status_payclient = 'Оплата получена' ");
$total_orders_pay_10day = $total_orders_pay_10day->fetchAll();
$total_orders_pay_bro_10day = count($total_orders_pay_10day);
$result = $this->pdo->query("SELECT * FROM transactions WHERE status_payclient = 'Оплата получена'"); // Статус - 2 успешный платеж, можно формировать по своим данным в таблицах
while ($row = $result->fetch()) {
$u_balance = $u_balance + $row['date_pay']; // За все время
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
	$u_balance_day = $u_balance_day + $row['sum_rub'];
}
if ($you_date_unix_week == $now_date_unix_week){ // Зе текущую неделю
	$u_balance_week = $u_balance_week + $row['sum_rub'];
}
if ($you_date_unix_month == $now_date_unix_month){ // За текущий месяц
	$u_balance_month = $u_balance_month + $row['sum_rub'];
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
	$date_now = date('Y-m-d',strtotime("-1 month"));
	$money_pre_day1 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '1' ");
	$money_pre_day1 =  $money_pre_day1->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day1['obmen_plus']):
	$money_pre_day1['obmen_plus'] = 0;
	endif;
			$money_pre_day2 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '2' ");
	$money_pre_day2 =  $money_pre_day2->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day2['obmen_plus']):
	$money_pre_day2['obmen_plus'] = 0;
	endif;
			$money_pre_day3 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '3' ");
	$money_pre_day3 =  $money_pre_day3->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day3['obmen_plus']):
	$money_pre_day3['obmen_plus'] = 0;
	endif;
			$money_pre_day4 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '4' ");
	$money_pre_day4 =  $money_pre_day4->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day4['obmen_plus']):
	$money_pre_day4['obmen_plus'] = 0;
	endif;
			$money_pre_day5 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '5' ");
	$money_pre_day5 =  $money_pre_day5->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day5['obmen_plus']):
	$money_pre_day5['obmen_plus'] = 0;
	endif;
			$money_pre_day6 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '6' ");
	$money_pre_day6 =  $money_pre_day6->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day6['obmen_plus']):
	$money_pre_day6['obmen_plus'] = 0;
	endif;
			$money_pre_day7 = $this->pdo->query("SELECT SUM(obmen_plus) AS obmen_plus FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '7' ");
	$money_pre_day7 =  $money_pre_day7->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_day7['obmen_plus']):
	$money_pre_day7['obmen_plus'] = 0;
	endif;
	$money_cash_day1 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '1' ");
	$money_cash_day1 =  $money_cash_day1->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day1['sum_rub']):
	$money_cash_day1['sum_rub'] = 0;
	endif;
			$money_cash_day2 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '2' ");
	$money_cash_day2 =  $money_cash_day2->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day2['sum_rub']):
	$money_cash_day2['sum_rub'] = 0;
	endif;
			$money_cash_day3 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '3' ");
	$money_cash_day3 =  $money_cash_day3->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day3['sum_rub']):
	$money_cash_day3['sum_rub'] = 0;
	endif;
			$money_cash_day4 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '4' ");
	$money_cash_day4 =  $money_cash_day4->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day4['sum_rub']):
	$money_cash_day4['sum_rub'] = 0;
	endif;
			$money_cash_day5 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '5' ");
	$money_cash_day5 =  $money_cash_day5->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day5['sum_rub']):
	$money_cash_day5['sum_rub'] = 0;
	endif;
			$money_cash_day6 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '6' ");
	$money_cash_day6 =  $money_cash_day6->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day6['sum_rub']):
	$money_cash_day6['sum_rub'] = 0;
	endif;
			$money_cash_day7 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '7' ");
	$money_cash_day7 =  $money_cash_day7->fetch(PDO::FETCH_ASSOC);
	if (!$money_cash_day7['sum_rub']):
	$money_cash_day7['sum_rub'] = 0;
	endif;
	$money_pre_month1 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Январь' ");
	$money_pre_month1 =  $money_pre_month1->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month1['sum_rub']):
	$money_pre_month1['sum_rub'] = 0;
	endif;
			$money_pre_month2 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Февраль' ");
	$money_pre_month2 =  $money_pre_month2->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month2['sum_rub']):
	$money_pre_month2['sum_rub'] = 0;
	endif;
			$money_pre_month3 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Март' ");
	$money_pre_month3 =  $money_pre_month3->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month3['sum_rub']):
	$money_pre_month3['sum_rub'] = 0;
	endif;
			$money_pre_month4 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Апрель' ");
	$money_pre_month4 =  $money_pre_month4->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month4['sum_rub']):
	$money_pre_month4['sum_rub'] = 0;
	endif;
			$money_pre_month5 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Май' ");
	$money_pre_month5 =  $money_pre_month5->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month5['sum_rub']):
	$money_pre_month5['sum_rub'] = 0;
	endif;
			$money_pre_month6 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Июнь' ");
	$money_pre_month6 =  $money_pre_month6->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month6['sum_rub']):
	$money_pre_month6['sum_rub'] = 0;
	endif;
			$money_pre_month7 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Июль' ");
	$money_pre_month7 =  $money_pre_month7->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month7['sum_rub']):
	$money_pre_month7['sum_rub'] = 0;
	endif;
			$money_pre_month8 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Август' ");
	$money_pre_month8 =  $money_pre_month8->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month8['sum_rub']):
	$money_pre_month8['sum_rub'] = 0;
	endif;
			$money_pre_month9 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Сентябрь' ");
	$money_pre_month9 =  $money_pre_month9->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month9['sum_rub']):
	$money_pre_month9['sum_rub'] = 0;
	endif;
			$money_pre_month10 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Октябрь' ");
	$money_pre_month10 =  $money_pre_month10->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month10['sum_rub']):
	$money_pre_month10['sum_rub'] = 0;
	endif;
			$money_pre_month11 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Ноябрь' ");
	$money_pre_month11 =  $money_pre_month11->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month11['sum_rub']):
	$money_pre_month11['sum_rub'] = 0;
	endif;
			$money_pre_month12 = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Декабрь' ");
	$money_pre_month12 =  $money_pre_month12->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month12['sum_rub']):
	$money_pre_month12['sum_rub'] = 0;
	endif;
	$money_pre_month1 = round($money_pre_month1['sum_rub']); 
	$money_pre_month2 = round($money_pre_month2['sum_rub']); 
	$money_pre_month3 = round($money_pre_month3['sum_rub']); 
	$money_pre_month4 = round($money_pre_month4['sum_rub']); 
	$money_pre_month5 = round($money_pre_month5['sum_rub']); 
	$money_pre_month6 = round($money_pre_month6['sum_rub']); 
	$money_pre_month7 = round($money_pre_month7['sum_rub']); 
	$money_pre_month8 = round($money_pre_month8['sum_rub']); 
	$money_pre_month9 = round($money_pre_month9['sum_rub']); 
	$money_pre_month10 = round($money_pre_month10['sum_rub']); 
	$money_pre_month11 = round($money_pre_month11['sum_rub']); 
	$money_pre_month12 = round($money_pre_month12['sum_rub']); 
	$money_pre_month_send1 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Январь' ");
	$money_pre_month_send1 =  $money_pre_month_send1->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send1['out_summ']):
	$money_pre_month_send1['out_summ'] = 0;
	endif;
			$money_pre_month_send2 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Февраль' ");
	$money_pre_month_send2 =  $money_pre_month_send2->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send2['out_summ']):
	$money_pre_month_send2['out_summ'] = 0;
	endif;
			$money_pre_month_send3 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Март' ");
	$money_pre_month_send3 =  $money_pre_month_send3->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send3['out_summ']):
	$money_pre_month_send3['out_summ'] = 0;
	endif;
			$money_pre_month_send4 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Апрель' ");
	$money_pre_month_send4 =  $money_pre_month_send4->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send4['out_summ']):
	$money_pre_month_send4['out_summ'] = 0;
	endif;
			$money_pre_month_send5 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Май' ");
	$money_pre_month_send5 =  $money_pre_month_send5->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send5['out_summ']):
	$money_pre_month_send5['out_summ'] = 0;
	endif;
			$money_pre_month_send6 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Июнь' ");
	$money_pre_month_send6 =  $money_pre_month_send6->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send6['out_summ']):
	$money_pre_month_send6['out_summ'] = 0;
	endif;
			$money_pre_month_send7 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Июль' ");
	$money_pre_month_send7 =  $money_pre_month_send7->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send7['out_summ']):
	$money_pre_month_send7['out_summ'] = 0;
	endif;
			$money_pre_month_send8 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Август' ");
	$money_pre_month_send8 =  $money_pre_month_send8->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send8['out_summ']):
	$money_pre_month_send8['out_summ'] = 0;
	endif;
			$money_pre_month_send9 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Сентябрь' ");
	$money_pre_month_send9 =  $money_pre_month_send9->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send9['out_summ']):
	$money_pre_month_send9['out_summ'] = 0;
	endif;
			$money_pre_month_send10 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Октябрь' ");
	$money_pre_month_send10 =  $money_pre_month_send10->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send10['out_summ']):
	$money_pre_month_send10['out_summ'] = 0;
	endif;
			$money_pre_month_send11 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Ноябрь' ");
	$money_pre_month_send11 =  $money_pre_month_send11->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send11['out_summ']):
	$money_pre_month_send11['out_summ'] = 0;
	endif;
			$money_pre_month_send12 = $this->pdo->query("SELECT SUM(out_summ) AS out_summ FROM transactions WHERE  status_payclient = 'Оплата получена' and month = 'Декабрь' ");
	$money_pre_month_send12 =  $money_pre_month_send12->fetch(PDO::FETCH_ASSOC);
	if (!$money_pre_month_send12['out_summ']):
	$money_pre_month_send12['out_summ'] = 0;
	endif;
	$money_pre_month_send1 = round($money_pre_month_send1['out_summ']); 
	$money_pre_month_send2 = round($money_pre_month_send2['out_summ']); 
	$money_pre_month_send3 = round($money_pre_month_send3['out_summ']); 
	$money_pre_month_send4 = round($money_pre_month_send4['out_summ']); 
	$money_pre_month_send5 = round($money_pre_month_send5['out_summ']); 
	$money_pre_month_send6 = round($money_pre_month_send6['out_summ']); 
	$money_pre_month_send7 = round($money_pre_month_send7['out_summ']); 
	$money_pre_month_send8 = round($money_pre_month_send8['out_summ']); 
	$money_pre_month_send9 = round($money_pre_month_send9['out_summ']); 
	$money_pre_month_send10 = round($money_pre_month_send10['out_summ']); 
	$money_pre_month_send11 = round($money_pre_month_send11['out_summ']); 
	$money_pre_month_send12 = round($money_pre_month_send12['out_summ']);
	
	
	
	$money_referal_day1 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '1' ");
	$money_referal_day1 =  $money_referal_day1->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day1['ref_sum']):
	$money_referal_day1['ref_sum'] = 0;
	endif;
			$money_referal_day2 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '2' ");
	$money_referal_day2 =  $money_referal_day2->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day2['ref_sum']):
	$money_referal_day2['ref_sum'] = 0;
	endif;
			$money_referal_day3 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '3' ");
	$money_referal_day3 =  $money_referal_day3->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day3['ref_sum']):
	$money_referal_day3['ref_sum'] = 0;
	endif;
			$money_referal_day4 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '4' ");
	$money_referal_day4 =  $money_referal_day4->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day4['ref_sum']):
	$money_referal_day4['ref_sum'] = 0;
	endif;
			$money_referal_day5 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '5' ");
	$money_referal_day5 =  $money_referal_day5->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day5['ref_sum']):
	$money_referal_day5['ref_sum'] = 0;
	endif;
			$money_referal_day6 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '6' ");
	$money_referal_day6 =  $money_referal_day6->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day6['ref_sum']):
	$money_referal_day6['ref_sum'] = 0;
	endif;
			$money_referal_day7 = $this->pdo->query("SELECT SUM(ref_sum) AS ref_sum FROM transactions WHERE  status_payclient = 'Оплата получена' and number_day_week = '7' ");
	$money_referal_day7 =  $money_referal_day7->fetch(PDO::FETCH_ASSOC);
	if (!$money_referal_day7['ref_sum']):
	$money_referal_day7['ref_sum'] = 0;
	endif;
	
	
	
	
	$time = date('Y-m-d H:i:s', strtotime("-1 day"));
$time_now = date('Y-m-d 00:00:00', strtotime("-1 day"));
$time_today = date('Y-m-d H:i:s');
$time_now_today = date('Y-m-d 00:00:00');
	$money_live_vchera = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE FROM_UNIXTIME(date_pay) BETWEEN '".$time_now."' AND '".$time."'");
	$money_live_vchera =  $money_live_vchera->fetch(PDO::FETCH_ASSOC);
	if (!$money_live_vchera['sum_rub']):
	$money_live_vchera['sum_rub'] = 0;
	endif;
	$money_live_today = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE  FROM_UNIXTIME(date_pay) BETWEEN '".$time_now_today."' AND '".$time_today."'");
	$money_live_today =  $money_live_today->fetch(PDO::FETCH_ASSOC);
	if (!$money_live_today['sum_rub']):
	$money_live_today['sum_rub'] = 0;
	endif;
	$price = $money_live_today['sum_rub'];
	$sale  = $money_live_vchera['sum_rub'];
	$pririst = (($price - $sale) * 100) / $price; 
	if ( $sale > $price ) {
		$text = preg_replace('/\..+$/u', '', $pririst);
		$itog = '<span class="ms-1 font-13 text-danger">' . $text . '%<ion-icon name="arrow-down-outline"></ion-icon></span>';
		} if ( $sale < $price ) {
		$text = preg_replace('/\..+$/u', '', $pririst);
		$itog = '<span class="ms-1 font-13 text-success">+' . $text . '%<ion-icon name="arrow-up-outline"></ion-icon></span>';			
		}
		$time_serv = date('h:i');
	if ( $money_live_today['sum_rub'] > $money_live_vchera['sum_rub'] ) {
	$key_amount = '<span class="ms-1 font-13 text-success">+' . round($money_live_today['sum_rub'] - $money_live_vchera['sum_rub'] . '</span>');	
	} else {
	$key_amount = '<span class="ms-1 font-13 text-danger">' . round($money_live_today['sum_rub'] - $money_live_vchera['sum_rub'] . '</span>');	
	}
?>
<style>
.widget-activity-five .mt-container {
position: relative;
height: 400px;
overflow: auto;
padding: 15px 12px 0 12px;
}
.widget-two .w-numeric-value .w-icon {
display: inline-block;
background: #e2a03f;
padding: 13px 12px;
border-radius: 50%;
display: inline-flex;
align-self: center;
height: 45px;
width: 45px;
}
.widget-activity-four .mt-container {
position: relative;
height: 355px;
overflow: auto;
padding-right: 12px;    
}
.form_radio_group {
	display: inline-block;
	overflow: hidden;
}
.form_radio_group-item {
	display: inline-block;
	float: left;    
}
.form_radio_group input[type=radio] {
	display: none;
}
.form_radio_group label {
	display: inline-block;
	cursor: pointer;
	padding: 0px 15px;
	line-height: 34px;
	border: 0px solid #999;
	border-right: none;
	user-select: none;
}
 
.form_radio_group .form_radio_group-item:first-child label {
	border-radius: 6px 0 0 6px;
}
.form_radio_group .form_radio_group-item:last-child label {
	border-radius: 0 6px 6px 0;
	border-right: 0px solid #999;
}
 
/* Checked */
.form_radio_group input[type=radio]:checked + label {
	background: #4361ee;
	color: #FFF;
}
 
/* Hover */
.form_radio_group label:hover {
	color: #4361ee;
}
 
/* Disabled */
.form_radio_group input[type=radio]:disabled + label {
	background: #efefef;
	color: #666;
}
</style>
<link href="/assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/assets/css/elements/alert.css">
			<div class="row layout-top-spacing">
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
<div class="wrapper" style="margin-bottom:-18px;margin-top:-30px;">
<input id="option-1" class="radio" type="radio" name="radioname" value="radio-block-1" checked />
<label for="option-1" class="option option-1">
  <div class="dot"></div>
  <span style="font-size:0.7rem;font-weight:600;">Главное</span>
</label>
<input id="option-2" class="radio" type="radio" name="radioname" value="radio-block-2" />
<label for="option-2" class="option option-2">
  <div class="dot"></div>
  <span style="font-size:0.7rem;font-weight:600;">Рефералы</span>
</label>
</label>
</div> 
<div id="radio-block-1" class="radio-blocks">
<div class="widget widget-account-invoice-three" style="height:100%;">
						<div class="widget-heading">
							<div class="wallet-usr-info">
								<div class="usr-name">
									<span style="font-size:0.7rem;font-weight:600;"><img alt="avatar" class="img-fluid rounded-circle" src="<?=$get_user['image']?>"> <?=$get_user['username']?></span>
								</div>
								<div class="" style="font-size:1.2rem;color:#fff;">
								  <p style="font-size:0.7rem;">
								<script src="/assets/js/wellcome.js"></script><br>
								<script src="/assets/js/date.js"></script>
								</div>
							</div>
									   <div id="showcashall" style="margin-top:20px;font-weight:800;font-size:1.2rem;"></div>
						</div>
						<div class="widget-amount">
							<div id="showoutcash"></div>
						</div>
<div class="w-chart" style="margin-top:8px;">
<div id="hybrid_followers1"></div>
</div>
					</div>
</div>
<div id="radio-block-2" class="radio-blocks" style="display:none">
<div class="widget widget-account-invoice-three" style="height:100%;">
						<div class="widget-heading">
							<div class="wallet-usr-info">
								<div class="usr-name">
									<span style="font-size:0.7rem;font-weight:600;"><img alt="avatar" class="img-fluid rounded-circle" src="<?=$get_user['image']?>"> <?=$get_user['username']?></span>
								</div>
								<div class="" style="font-size:1.2rem;color:#fff;">
								  <p style="font-size:0.7rem;">
								<script src="/assets/js/wellcome.js"></script><br>
								<script src="/assets/js/date.js"></script>
								</div>
							</div>
							<div id="showcashbtc" style="margin-top:20px;font-weight:800;font-size:1.2rem;"></div>							
						</div>
<div class="widget-amount">
<div id="showrandcrypto"></div>
</div>
<div class="w-chart" style="margin-top:13px;">
<div id="hybrid_followers3"></div>
						</div>
					</div>
</div>
				</div>
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing" >
					<div class="widget widget-table-one" style="height:100%;" >
						<div class="widget-heading">
							<h5 class="">Лучшие магазины <span style="color:#e2a03f;">сегодня</span></h5>
						</div>
						<div class="widget-content">
						   <div id="showtopshop"></div>	 
						 </div>
					</div>
				</div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
					<div class="widget widget-activity-four" style="height:100%;">
						<div class="widget-heading">
							<h5 class="">Последние <span style="color:#e2a03f;">операции</span></h5>
						</div>
						<div class="widget-content">
							<div class="mt-container mx-auto">
								<div class="timeline-line">
									<div id="orderactive"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
<div class="widget-two" style="height:100%;">
<div class="widget-content">
<div class="w-numeric-value">
<div class="w-content">
<span class="w-value">Чистая прибыль</span>
<span class="w-numeric-title">Считается только процент обмена.</span>
</div>
<div class="w-icon">
<i class="fa-solid fa-ruble-sign fa-lg" style="margin-top:9px;margin-left:3px;color:#000;"></i>
</div>
</div>
<div class="w-chart">
<div id="daily-sales" style="margin-top:-70px;"></div>
</div>
</div>
</div>
</div>
<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					<div class="widget widget-one" style="height:100%;">
						<div class="w-chart">
							<div class="w-chart-section total-visits-content">
								<div class="w-detail" style="margin-top:-10px;">
									<p class="w-title">Всего счетов</p>
									<p class="w-stats" style="font-size:0.9rem;"><? echo $total_orders_bro;?></p>
								</div>
								<div class="w-chart-render-one">
									<div id="total-users"></div>
								</div>
							</div>
							<div class="w-chart-section paid-visits-content">
								<div class="w-detail" style="margin-top:-10px;">
									<p class="w-title">Оплаченных</p>
									<p class="w-stats" style="font-size:0.9rem;"><? echo $total_orders_pay_bro;?></p>
								</div>
								<div class="w-chart-render-one">
									<div id="paid-visits"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
<div class="widget widget-card-four">
<div class="widget-content">
<div class="w-header">
<div class="widget-heading">
<h6 class="" style="color:#FFF;font-weight:700;">За всё время<br><span style="color:#888ea8;font-size:0.8rem;font-weight:800;">Поставленная цель: 100,000,000 ₽</span></h6>
</div>
</div>
<div class="w-content" style="margin-top:-10px;">
<div class="w-info">
<p class="value" id="clearcash"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></p>
</div>
</div>
<div id="celcash"></div>
</div>
</div>
</div>

				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
					<div class="widget widget-activity-five">
						<div class="widget-heading">
							<h5 class="">Активность админов<br><span style="font-size:0.7rem;color:#999;">Последняя активность в админке</span></h5>
							<div class="task-action">
								<div class="dropdown">
									<a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask" style="will-change: transform;">
										<a class="dropdown-item" href="javascript:void(0);">Вся активность</a>
									</div>
								</div>
							</div>
						</div>
						<div class="widget-content">
							<div class="w-shadow-top"></div>
							<div class="mt-container mx-auto">
								<div class="timeline-line">
									<div id="adminactive"></div>
									</div>                                    
							</div>
							<div class="w-shadow-bottom"></div>
						</div>
					</div>
				</div>
				
				
				
				
				<!-- Modal -->
                                    <div class="modal fade" style="padding-top:50px;padding-bottom:40px;" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalCenterTitle">Выплата рефералам</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
												
												
												
												<div class="form-group">
												<select class="me-sm-2 default-select2 form-control form-control-sm selectpicker"  onchange="test(this)" id="chatref" name="chatref" required>
												<option value="" disabled selected >Выберите заявку для выплаты</option>
												<?
												$category = $this->pdo->query("SELECT * FROM conclusion_referals WHERE status = 'В ожидании' ");
												while ($row = $category->fetch()) {
											    $user_vivod = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$row['chat']."' ");
									            $user_vivod = $user_vivod->fetch(PDO::FETCH_ASSOC);
													?>
													<option value="<? echo $row['id'];?>">Заявка: #<? echo $row['id'];?><? echo $user_vivod['last_name'];?> <? echo $user_vivod['first_name'];?></option>
													<?
													}
													?>
													</select>
													</div>
	
<div class="form-group">
    <input id="btn" type="submit" class="btn btn-block btn-primary" onclick="chpok('text')" value="Посмотр данных заявки" disabled />
	</div>

<div class="form-group">
	<div id="showrefvivod"></div>
	</div>
	<div id="text" style="display:none;">
	<form method="POST" id="sendrefmoney" class="form" action="javascript:void(null);" onsubmit="sendrefmoney()">
<input type="hidden" name="hid" id="hid"/>	



<div class="form-group">
												<select class="me-sm-2 default-select2 form-control form-control-sm selectpicker"  id="exchange" name="exchange" required>
												<option value="" disabled selected >Выберите биржу</option>
												<?
												$categorys = $this->pdo->query("SELECT * FROM exchanges WHERE active = '1' ");
												while ($rowsss = $categorys->fetch()) {
													?>
													<option value="<? echo $rowsss['id'];?>"><? echo $rowsss['bir'];?> - <? echo $rowsss['name'];?></option>
													<?
													}
													?>
													</select>
													</div>



<div class="form-group">
	<select class="me-sm-2 default-select2 form-control form-control-sm selectpicker" id="statusref" name="statusref" required>
												<option value="" disabled selected >Сменить статус заявки</option>
													<option value="Выплачено">Выплачено</option>
													<option value="В ожидании">В ожидании</option>
													<option value="Отказано">Отказано</option>
													</select>
                                                </div>
	
	
	
	<div class="form-group">
	<select id="select" name="zayavka_in" class="me-sm-2 default-select2 form-control form-control-sm selectpicker">
	<option value="select-block-1" selected disabled>Выберите способ выплаты</option>
	<option value="noshops">Реквизиты из заявки</option>
	<option value="shops">Другие реквизиты</option>
</select>
</div>
<div id="select-block-1" class="select-blocks" style="display:none"></div>
<div id="noshops" class="select-blocks" style="display:none">

<input type="submit" class="btn btn-block btn-success" value="Отправить средства по заявке">
 
</div>
<div id="shops" class="select-blocks" style="display:none">

<div class="form_radio_group">
	<div class="form_radio_group-item">
		<input id="radio-1" type="radio" name="currencys" value="BTC" >
		<label for="radio-1">BTC</label>
	</div>
	<div class="form_radio_group-item">
		<input id="radio-2" type="radio" name="currencys" value="LTC">
		<label for="radio-2">LTC</label>
	</div>
	<div class="form_radio_group-item">
		<input id="radio-3" type="radio" name="currencys" value="ETH">
		<label for="radio-3">ETH</label>
	</div>
	<div class="form_radio_group-item">
		<input id="radio-4" type="radio" name="currencys" value="USDT">
		<label for="radio-4">USDT</label>
	</div>
</div>
<div class="form-group">
                                                <input type="text" name="summ" class="form-control form-control-sm mb-4 mask-phone" placeholder="Введите сумму">
                                            </div>

 <div class="input-group mb-4">
                                      <input type="text" class="form-control form-control-sm" placeholder="Введите адрес кошелька" aria-label="Введите адрес кошелька" name="adress_ref" id="adress_ref" required>
                                      <div class="input-group-append">
                                        <input type="submit" class="btn btn-success" value="Отправить">
                                      </div>
                                    </div>
</div>
	
                                   
	
                                       
                                      
	</form>
	</div>
	<div class="form-group">
	<div id="resultssendrefmoney"></div>
	<div id="loadingsend" class="spinner-border text-success  align-self-center" style='display:none;'></div>
	</div>
											</div>
                                            </div>
                                        </div>
                                    </div>
				
				
				
				<div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					<div class="widget widget-table-three">
						<div class="widget-heading">
<h6 class="">Выплаты (Рефералы)<br><span style="font-size:0.7rem;color:#999;">Последние заявки на выплату рефералов</span></h6>

<div class="task-action">

<button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#exampleModalCenter"><i class="fa-light fa-paper-plane-top"></i> Выплатить рефералу</button>

</div>
</div>
						<hr>
						<div class="widget-content">
							<div class="table-responsive">
								<table class="table table-striped mb-4">
									<tbody>
									<?
									$vivod_ref = $this->pdo->query("SELECT * FROM conclusion_referals ORDER BY id DESC LIMIT 6");
									$vivod_ref = $vivod_ref->fetchAll();
									if (empty($vivod_ref)):
									?>
									<h6>Заявок пока нет</h6>
									<?
									else:
									foreach ($vivod_ref as $key => $row):
									$currency_vivod = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$row['currency']."' ");
									$currency_vivod = $currency_vivod->fetch(PDO::FETCH_ASSOC);
									$user_vivod = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$row['chat']."' ");
									$user_vivod = $user_vivod->fetch(PDO::FETCH_ASSOC);
									$time_add = date('Y-m-d H:i:s', $row['date']);
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
										if ($row['status'] == 'В ожидании'){
											$status = '<span class="badge badge-warning" style="font-size:0.6rem;">В ожидании</span>';
											} elseif ($row['status'] == 'Выплачено'){
											$status = '<span class="badge badge-success" style="font-size:0.6rem;">Выплачено</span>';	
											} elseif ($row['status'] == 'Отказано'){
											$status = '<span class="badge badge-danger" style="font-size:0.6rem;">Отказано</span>';	
											}
											if ($row['currency'] == 'VISA'){
											$sum = number_format($row['sum_rub']).'₽';											
											} else {
											$sum = $row['sum_crypto'];
											}
											$sum_rub = number_format($row['sum_rub']);
									?>
										<tr>
										<td><div class="td-content product-name"><img src="<? echo $currency_vivod['logo'];?>" style="width:25px;height:25px;" alt="product"><div class="align-self-center"><p class="prd-name"><span style="font-size:0.6rem;"><? echo $user_vivod['last_name'];?> <? echo $user_vivod['first_name'];?></span></p></div></div></td>
											<td><div class="td-content pricing"><span style="font-size:0.6rem;"><b><? echo $sum;?></b></span></div></td>
											<td><div class="td-content pricing"><span class="badge badge-dark" style="font-size:0.6rem;"><? echo $datetime_create;?></span></div></td>
											<td><div class="td-content"><? echo $status;?></div></td>
										</tr>
									 <?
									 endforeach;
									 endif;
									 ?>   
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				 <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					<div class="widget widget-table-three">
												<div class="widget-heading">
<h6 class="">Выплаты (Магазины)<br><span style="font-size:0.7rem;color:#999;">Последние заявки на выплату магазинов</span></h6>

<div class="task-action">

<button type="button" class="btn btn-primary btn-sm"  data-toggle="modal" data-target="#exampleModal"><i class="fa-light fa-paper-plane-top"></i> Выплатить рефералу</button>

</div>
</div>
						<hr>
						<div class="widget-content">
							<div class="table-responsive">
								<table class="table table-striped mb-4">
									<tbody>
									<?
									$vivod_shop = $this->pdo->query("SELECT * FROM conclusion_shops ORDER BY id DESC LIMIT 6");
									$vivod_shop = $vivod_shop->fetchAll();
									if (empty($vivod_shop)):
									?>
									<h6>Заявок пока нет</h6>
									<?
									else:
									foreach ($vivod_shop as $keys => $rows):
									$currency_vivod = $this->pdo->query("SELECT * FROM `currency_in` WHERE nominal = '".$rows['currency']."' ");
									$currency_vivod = $currency_vivod->fetch(PDO::FETCH_ASSOC);
									$shop_vivod = $this->pdo->query("SELECT * FROM `shop` WHERE id = '".$rows['id_shop']."' ");
									$shop_vivod = $shop_vivod->fetch(PDO::FETCH_ASSOC);
									$time_add = date('Y-m-d H:i:s', $rows['date']);
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
										if ($rows['status'] == 'В ожидании'){
											$status = '<span class="badge badge-warning" style="font-size:0.6rem;">В ожидании</span>';
											} elseif ($rows['status'] == 'Выплачено'){
											$status = '<span class="badge badge-success" style="font-size:0.6rem;">Выплачено</span>';	
											} elseif ($rows['status'] == 'Отказано'){
											$status = '<span class="badge badge-danger" style="font-size:0.6rem;">Отказано</span>';	
											}
											if ($rows['currency'] == 'VISA'){
											$sum = number_format($rows['sum_rub']).'₽';											
											} else {
											$sum = $rows['sum_crypto'];
											}
											$sum_rub = number_format($rows['sum_rub']);
									?>
										<tr>
										<td><div class="td-content product-name"><img src="<? echo $currency_vivod['logo'];?>" style="width:25px;height:25px;" alt="product"><div class="align-self-center"><p class="prd-name" style="font-size:0.6rem;"><? echo $shop_vivod['name'];?></p></div></div></td>
											<td><div class="td-content product-invoice"><span style="font-size:0.6rem;"><b><? echo $sum;?></b></span></div></td>
											<td><div class="td-content pricing"><span class="badge badge-dark" style="font-size:0.6rem;"><? echo $datetime_create;?></span></div></td>
											<td><div class="td-content"><? echo $status;?></div></td>
										</tr>
										<?
									 endforeach;
									 endif;
									 ?> 
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<style>

				.w-icon1 {
    display: inline-block;
    background: transparent;
    padding: 13px 12px;
    border-radius: 50%;
	color: #0073ff;
    display: inline-flex;
    align-self: center;
    height: 45px;
    width: 45px;
}
.w-icon2 {
    display: inline-block;
    background: transparent;
    padding: 13px 12px;
    border-radius: 50%;
	color: #e7515a;
    display: inline-flex;
    align-self: center;
    height: 45px;
    width: 45px;
}
.w-icon3 {
    display: inline-block;
    background: transparent;
    padding: 13px 12px;
    border-radius: 50%;
	color: #e2a03f;
    display: inline-flex;
    align-self: center;
    height: 45px;
    width: 45px;
}
.w-icon4 {
    display: inline-block;
    background: transparent;
    padding: 13px 12px;
    border-radius: 50%;
	color: #28b17d;
    display: inline-flex;
    align-self: center;
    height: 45px;
    width: 45px;
}
				</style>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                        <div class="widget-four">
                            <div class="widget-heading">
                                <h5 class="">За сегодня прошло<br><span style="font-size:0.7rem;color:#999;">Общий кэш за сегодняшний день</span></h5>
                            </div>
							<hr>
                            <div class="widget-content">
                                <div class="vistorsBrowser">
                                    <div class="browser-list">
                                        <div class="w-icon1">
                                            <i class="fa-brands fa-btc fa-2x"></i>
                                        </div>
                                        <div class="w-browser-details">
                                            
                                           
<div id="crpercentbtc"></div>
                                            
                                        </div>
                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon2">
                                            <i class="fa-solid fa-litecoin-sign fa-2x"></i>
                                        </div>
                                        <div class="w-browser-details">
                                            <div id="crpercentltc"></div>
                                        </div>

                                    </div>

                                    <div class="browser-list">
                                        <div class="w-icon3">
										<i class="fa-solid fa-dollar-sign fa-2x"></i>
                                        </div>
                                        <div class="w-browser-details">
                                            <div id="crpercenteth"></div>
                                        </div>

                                    </div>
									
									<div class="browser-list">
                                        <div class="w-icon4">
										<i class="fa-brands fa-ethereum fa-2x"></i>
                                        </div>
                                        <div class="w-browser-details">
                                          <div id="crpercentusdt"></div>  
                                        </div>

                                    </div>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
				  <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
					<div class="widget widget-chart-one">
						<div class="widget-content">
							<div id="revenueMonthly"></div>
						</div>
					</div>
				</div>
			</div>
<?php
endif; 
?>
<? include './template/template_footer.tpl'; ?>

<script>


function chpok(id){
    elem = document.getElementById(id); //находим блок div по его id, который передали в функцию
    state = elem.style.display; //смотрим, включен ли сейчас элемент
    if (state =='') elem.style.display='none'; //если включен, то выключаем
    else elem.style.display=''; //иначе - включаем
}
</script>
<script>
$(function() {
	$("#" + $("#select option:selected").val()).show();
	$("#select").change(function(){
		$(".select-blocks").hide();
		$("#" + $(this).val()).show();
	});
});

$('#text').focus(function(){
	$(this).select();
});
function sendrefmoney() {
  var msg   = $('#sendrefmoney').serialize();
    $("#loadingsend").css("display", "block");
	$.ajax({
	  type: 'POST',
	  url: '/sendrefmoney/',
	  data: msg,
	  success: function(html){  
	  $("#resultssendrefmoney").html(html);  
	 },
	  complete: function(){
        $("#loadingsend").css("display", "none");
      }
	});

}

var timeoutId;
$('#statusref').on('input propertychange change', function() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
        // Runs 1 second (1000 ms) after the last change    
        saveToDBS();
    }, 1000);
});

function saveToDBS()
{
	 var msg = $('#refvivod').serialize();
     $.ajax({
        url: "/5.php",
        type: "POST",
        data: msg,
        success: function(data) {
 Snackbar.show({
        text: 'Сохранено в : ' + d.toLocaleTimeString(),
        pos: 'bottom-center',
		actionText: ''
    });
        }
    });
    var d = new Date();
    $('.form-status-holder').html('Сохранено в : ' + d.toLocaleTimeString());
}
	</script>


<script src="/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script>
$('select[name=chatref]').change(function() {
  if ($("#chatref :selected").val() == 'Выбрать сотрудника') {
    $('input[type="submit"]').attr('disabled', 'disabled');
  } else {
    $('input[type="submit"]').removeAttr('disabled');
  }
});



    $("select[name='chatref']").change(function() {
         
		 var select = document.getElementById("chatref");
         var value = select.value;
         $("input[name='hid']").val(value);
    });

function showrefvivod()  
		{ 
$('#btn').click(function(){
	var zakaz = $('#hid').val();		
			$.ajax({  
				url: "/showrefvivod/" + zakaz + "/",  
				cache: false,  
				success: function(html){  
					$("#showrefvivod").html(html);
				}  
			});  
			});
		}

 function test(obj){
if (obj == 'true') { document.all.btn.disabled = true }
else { document.all.btn.disabled = false };
  showrefvivod();     
    }
$(function() {
$("#" + $(".radio:checked").val()).show();
$(".radio").change(function(){
	$(".radio-blocks").hide();
	$("#" + $(this).val()).show();
});
});
		var cardone   = <? echo $getcard_one['id'];?>;
		var cardtwo   = <? echo $getcard_two['id'];?>;
		 function show()  
		{  
			$.ajax({  
				url: "/ajaxcartmain/" + cardone + "/",  
				cache: false,  
				success: function(html){  
					$("#balancecard").html(html);
				}  
			});  
		}
		function showtwo()  
		{  
			$.ajax({  
				url: "/ajaxcartmaintwo/" + cardtwo + "/",  
				cache: false,  
				success: function(html){  
					$("#balancecardtwo").html(html);
				}  
			});  
		} 
		function showcashall()  
		{  
			$.ajax({  
				url: "/showcashall/",  
				cache: false,  
				success: function(html){  
					$("#showcashall").html(html);
				}  
			});  
		}
					function showcashbtc()  
		{  
			$.ajax({  
				url: "/showcashbtc/",  
				cache: false,  
				success: function(html){  
					$("#showcashbtc").html(html);
				}  
			});  
		}
		function showoutcash()  
		{  
			$.ajax({  
				url: "/showoutcash/",  
				cache: false,  
				success: function(html){  
					$("#showoutcash").html(html);
				}  
			});  
		}
		function showrandcrypto()  
		{  
			$.ajax({  
				url: "/showrandcrypto/",  
				cache: false,  
				success: function(html){  
					$("#showrandcrypto").html(html);
				}  
			});  
		}
		function showtopshop()  
		{  
			$.ajax({  
				url: "/showtopshop/",  
				cache: false,  
				success: function(html){  
					$("#showtopshop").html(html);
				}  
			});  
		}
		function clearcash()  
		{  
			$.ajax({  
				url: "/clearcash/",  
				cache: false,  
				success: function(html){  
					$("#clearcash").html(html);
				}  
			});  
		}
		function adminactive()  
		{  
			$.ajax({  
				url: "/adminactive/",  
				cache: false,  
				success: function(html){  
					$("#adminactive").html(html);
				}  
			});  
		}
		function orderactive()  
		{  
			$.ajax({  
				url: "/orderactive/",  
				cache: false,  
				success: function(html){  
					$("#orderactive").html(html);
				}  
			});  
		}
		
		function celcash()  
		{  
			$.ajax({  
				url: "/celcash/",  
				cache: false,  
				success: function(html){  
					$("#celcash").html(html);
				}  
			});  
		}
		
				function crpercentbtc()  
		{  
			$.ajax({  
				url: "/crpercentbtc/",  
				cache: false,  
				success: function(html){  
					$("#crpercentbtc").html(html);
				}  
			});  
		}
		function crpercentltc()  
		{  
			$.ajax({  
				url: "/crpercentltc/",  
				cache: false,  
				success: function(html){  
					$("#crpercentltc").html(html);
				}  
			});  
		}
		function crpercenteth()  
		{  
			$.ajax({  
				url: "/crpercenteth/",  
				cache: false,  
				success: function(html){  
					$("#crpercenteth").html(html);
				}  
			});  
		}
		function crpercentusdt()  
		{  
			$.ajax({  
				url: "/crpercentusdt/",  
				cache: false,  
				success: function(html){  
					$("#crpercentusdt").html(html);
				}  
			});  
		}
		
		
		$(document).ready(function(){
			celcash();
			crpercentbtc();
			crpercentltc();
			crpercenteth();
			crpercentusdt();
			orderactive();
			adminactive();
			clearcash();
			showtopshop();
			showcashbtc();
			showrandcrypto();
			showoutcash();
			showcashall();	
			showtwo();				
			show();
			setInterval('celcash();',5000);
			setInterval('crpercentbtc();',5000);
			setInterval('crpercentltc();',5000);
			setInterval('crpercenteth();',5000);
			setInterval('crpercentusdt();',5000);
			setInterval('orderactive();',10000);
			setInterval('adminactive();',5000);
			setInterval('clearcash();',5000);
			setInterval('showtopshop();',5000);
			setInterval('showrandcrypto()',5000);
			setInterval('showoutcash()',5000);
			setInterval('showcashbtc()',5000);	
			setInterval('showcashall()',5000);	
			setInterval('showtwo()',5000);				
			setInterval('show()',5000);  
		});
	</script>  
<!-- BEGIN PAGE LEVEL /plugins/CUSTOM SCRIPTS -->
<script src="/plugins/apex/apexcharts.min.js"></script>
<script>
try {
Apex.tooltip = {
theme: 'dark'
}
/*
  ==============================
  |    @Options Charts Script   |
  ==============================
*/
/*
  ======================================
	  Visitor Statistics | Options
  ======================================
*/
// Total Visits
var spark1 = {
chart: {
	id: 'unique-visits',
	group: 'sparks2',
	type: 'line',
	height: 160,
	sparkline: {
		enabled: true
	},
	dropShadow: {
		enabled: true,
		top: 1,
		left: 1,
		blur: 2,
		color: '#e2a03f',
		opacity: 0.7,
	}
},
series: [{
	data: [<? echo $total_orders_bro;?>, <? echo $total_orders_bro_yestuday;?>, <? echo $total_orders_bro_2day;?>, <? echo $total_orders_bro_3day;?>, <? echo $total_orders_bro_4day;?>, <? echo $total_orders_bro_5day;?>, <? echo $total_orders_bro_6day;?>, <? echo $total_orders_bro_7day;?>, <? echo $total_orders_bro_8day;?>, <? echo $total_orders_bro_9day;?>]
}],
stroke: {
  curve: 'smooth',
  width: 2,
},
markers: {
	size: 0
},
grid: {
  padding: {
	top: 35,
	bottom: 0,
	left: 40
  }
},
colors: ['#e2a03f'],
tooltip: {
	x: {
		show: false
	},
	y: {
		title: {
			formatter: function formatter(val) {
				return '';
			}
		}
	}
},
responsive: [{
	breakpoint: 1351,
	options: {
	   chart: {
		  height: 95,
	  },
	  grid: {
		  padding: {
			top: 35,
			bottom: 0,
			left: 0
		  }
	  },
	},
},
{
	breakpoint: 1200,
	options: {
	   chart: {
		  height: 80,
	  },
	  grid: {
		  padding: {
			top: 35,
			bottom: 0,
			left: 40
		  }
	  },
	},
},
{
	breakpoint: 576,
	options: {
	   chart: {
		  height: 95,
	  },
	  grid: {
		  padding: {
			top: 45,
			bottom: 0,
			left: 0
		  }
	  },
	},
}
]
}
// Paid Visits
var spark2 = {
chart: {
  id: 'total-users',
  group: 'sparks1',
  type: 'line',
  height: 160,
  sparkline: {
	enabled: true
  },
  dropShadow: {
	enabled: true,
	top: 3,
	left: 1,
	blur: 3,
	color: '#009688',
	opacity: 0.7,
  }
},
series: [{
	data: [<? echo $total_orders_pay_bro;?>, <? echo $total_orders_pay_bro_yestuday;?>, <? echo $total_orders_pay_bro_2day;?>, <? echo $total_orders_pay_bro_3day;?>, <? echo $total_orders_pay_bro_4day;?>, <? echo $total_orders_pay_bro_5day;?>, <? echo $total_orders_pay_bro_6day;?>, <? echo $total_orders_pay_bro_7day;?>, <? echo $total_orders_pay_bro_8day;?>, <? echo $total_orders_pay_bro_9day;?>]
}],
stroke: {
  curve: 'smooth',
  width: 2,
},
markers: {
  size: 0
},
grid: {
  padding: {
	top: 35,
	bottom: 0,
	left: 40
  }
},
colors: ['#009688'],
tooltip: {
  x: {
	show: false
  },
  y: {
	title: {
	  formatter: function formatter(val) {
		return '';
	  }
	}
  }
},
responsive: [{
	breakpoint: 1351,
	options: {
	   chart: {
		  height: 95,
	  },
	  grid: {
		  padding: {
			top: 35,
			bottom: 0,
			left: 0
		  }
	  },
	},
},
{
	breakpoint: 1200,
	options: {
	   chart: {
		  height: 80,
	  },
	  grid: {
		  padding: {
			top: 35,
			bottom: 0,
			left: 40
		  }
	  },
	},
},
{
	breakpoint: 576,
	options: {
	   chart: {
		  height: 95,
	  },
	  grid: {
		  padding: {
			top: 35,
			bottom: 0,
			left: 0
		  }
	  },
	},
}
]
}
/*
  ===================================
	  Unique Visitors | Options
  ===================================
*/
  var d_1options1 = {
	chart: {
		height: 350,
		type: 'bar',
		toolbar: {
		  show: false,
		},
		dropShadow: {
			enabled: true,
			top: 1,
			left: 1,
			blur: 1,
			color: '#515365',
			opacity: 0.3,
		}
	},
	colors: ['#5c1ac3', '#ffbb44'],
	plotOptions: {
		bar: {
			horizontal: false,
			columnWidth: '55%',
			endingShape: 'rounded'  
		},
	},
	dataLabels: {
		enabled: false
	},
	legend: {
		  position: 'bottom',
		  horizontalAlign: 'center',
		  fontSize: '14px',
		  markers: {
			width: 10,
			height: 10,
		  },
		  itemMargin: {
			horizontal: 0,
			vertical: 8
		  }
	},
	grid: {
	  borderColor: '#191e3a',
	},
	stroke: {
		show: true,
		width: 2,
		colors: ['transparent']
	},
	series: [{
		name: 'Direct',
		data: [58, 44, 55, 57, 56, 61, 58, 63, 60, 66, 56, 63]
	}, {
		name: 'Organic',
		data: [91, 76, 85, 101, 98, 87, 105, 91, 114, 94, 66, 70]
	}],
	xaxis: {
		categories: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
	},
	fill: {
	  type: 'gradient',
	  gradient: {
		shade: 'dark',
		type: 'vertical',
		shadeIntensity: 0.3,
		inverseColors: false,
		opacityFrom: 1,
		opacityTo: 0.8,
		stops: [0, 100]
	  }
	},
	tooltip: {
	  theme: 'dark',
		y: {
			formatter: function (val) {
				return val
			}
		}
	}
  }
/*
  ==============================
	  Statistics | Options
  ==============================
*/
// Followers
var d_1options3 = {
chart: {
  id: 'sparkline1',
  type: 'area',
  height: 160,
  sparkline: {
	enabled: true
  },
},
stroke: {
	curve: 'smooth',
	width: 2,
},
series: [{
  name: 'Sales',
  data: [38, 60, 38, 52, 36, 40, 28 ]
}],
labels: ['1', '2', '3', '4', '5', '6', '7'],
yaxis: {
  min: 0
},
colors: ['#4361ee'],
tooltip: {
  x: {
	show: false,
  }
},
fill: {
  type:"gradient",
  gradient: {
	  type: "vertical",
	  shadeIntensity: 1,
	  inverseColors: !1,
	  opacityFrom: .30,
	  opacityTo: .05,
	  stops: [100, 100]
  }
}
}
// Referral
var d_1options4 = {
chart: {
  id: 'sparkline1',
  type: 'area',
  height: 140,
  sparkline: {
	enabled: true
  },
},
stroke: {
	curve: 'smooth',
	width: 2,
},
series: [{
  name: 'Поступления',
  data: [<?=$money_cash_day1['sum_rub']?>, <?=$money_cash_day2['sum_rub']?>, <?=$money_cash_day3['sum_rub']?>, <?=$money_cash_day4['sum_rub']?>, <?=$money_cash_day5['sum_rub']?>, <?=$money_cash_day6['sum_rub']?>, <?=$money_cash_day7['sum_rub']?>]
}],
labels: ['1', '2', '3', '4', '5', '6', '7'],
yaxis: {
  min: 0
},
colors: ['#e7515a'],
tooltip: {
  x: {
	show: false,
  }
},
fill: {
  type:"gradient",
  gradient: {
	  type: "vertical",
	  shadeIntensity: 1,
	  inverseColors: !1,
	  opacityFrom: .30,
	  opacityTo: .05,
	  stops: [100, 100]
  }
}
}
// Engagement Rate
var d_1options5 = {
chart: {
  id: 'sparkline1',
  type: 'area',
  height: 140,
  sparkline: {
	enabled: true
  },
},
stroke: {
	curve: 'smooth',
	width: 2,
},
fill: {
  opacity: 1,
},
series: [{
  name: 'Поступления',
  data: [<?=$money_referal_day1['ref_sum']?>, <?=$money_referal_day2['ref_sum']?>, <?=$money_referal_day3['ref_sum']?>, <?=$money_referal_day4['ref_sum']?>, <?=$money_referal_day5['ref_sum']?>, <?=$money_referal_day6['ref_sum']?>, <?=$money_referal_day7['ref_sum']?>]
}],
labels: ['1', '2', '3', '4', '5', '6', '7'],
yaxis: {
  min: 0
},
colors: ['#1abc9c'],
tooltip: {
  x: {
	show: false,
  }
},
fill: {
  type:"gradient",
  gradient: {
	  type: "vertical",
	  shadeIntensity: 1,
	  inverseColors: !1,
	  opacityFrom: .30,
	  opacityTo: .05,
	  stops: [100, 100]
  }
}
}
/*
  ==============================
  |    @Render Charts Script    |
  ==============================
*/
/*
  ======================================
	  Visitor Statistics | Script
  ======================================
*/
// Total Visits
d_1C_1 = new ApexCharts(document.querySelector("#total-users"), spark1);
d_1C_1.render();
// Paid Visits
d_1C_2 = new ApexCharts(document.querySelector("#paid-visits"), spark2);
d_1C_2.render();
/*
  ===================================
	  Unique Visitors | Script
  ===================================
*/
var d_1C_3 = new ApexCharts(
  document.querySelector("#uniqueVisits"),
  d_1options1
);
d_1C_3.render();
/*
  ==============================
	  Statistics | Script
  ==============================
*/
// Followers
var d_1C_5 = new ApexCharts(document.querySelector("#hybrid_followers"), d_1options3);
d_1C_5.render()
// Referral
var d_1C_6 = new ApexCharts(document.querySelector("#hybrid_followers1"), d_1options4);
d_1C_6.render()
// Engagement Rate
var d_1C_7 = new ApexCharts(document.querySelector("#hybrid_followers3"), d_1options5);
d_1C_7.render()
/*
=============================================
	Perfect Scrollbar | Notifications
=============================================
*/
const mtContainer = new PerfectScrollbar(document.querySelector('.mt-container'));
} catch(e) {
// statements
console.log(e);
}
try {
Apex.tooltip = {
theme: 'dark'
}
/*
  ==============================
  |    @Options Charts Script   |
  ==============================
*/
/*
  =============================
	  Daily Sales | Options
  =============================
*/
var d_2options1 = {
chart: {
	  height: 160,
	  type: 'bar',
	  stacked: true,
	  toolbar: {
		show: false,
	  }
  },
  dataLabels: {
	  enabled: false,
  },
  stroke: {
	  show: true,
	  width: 1,
  },
  colors: ['#e2a03f', '#e2a03f'],
  responsive: [{
	  breakpoint: 480,
	  options: {
		  legend: {
			  position: 'bottom',
			  offsetX: -10,
			  offsetY: 0
		  }
	  }
  }],
  series: [{
	  name: 'Заработано',
	  data: []
  },{
	  name: '',
	  data: [<?=$money_pre_day1['obmen_plus']?>, <?=$money_pre_day2['obmen_plus']?>, <?=$money_pre_day3['obmen_plus']?>, <?=$money_pre_day4['obmen_plus']?>, <?=$money_pre_day5['obmen_plus']?>, <?=$money_pre_day6['obmen_plus']?>, <?=$money_pre_day7['obmen_plus']?>]
  }],
  xaxis: {
	  labels: {
		  show: false,
	  },
	  categories: ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'],
	  crosshairs: {
		show: false
	  }
  },
  yaxis: {
	  show: false
  },
  fill: {
	  opacity: 1
  },
  plotOptions: {
	  bar: {
		  horizontal: false,
		  columnWidth: '25%',
	  }
  },
  legend: {
	  show: false,
  },
  grid: {
	  show: false,
	  xaxis: {
		  lines: {
			  show: false
		  }
	  },
	  padding: {
		top: 10,
		right: 0,
		bottom: -40,
		left: 0
	  }, 
  },
}
/*
  =============================
	  Total Orders | Options
  =============================
*/
var d_2options2 = {
chart: {
  id: 'sparkline1',
  group: 'sparklines',
  type: 'area',
  height: 315,
  sparkline: {
	enabled: true
  },
},
stroke: {
	curve: 'smooth',
	width: 2
},
fill: {
  type:"gradient",
  gradient: {
	  type: "vertical",
	  shadeIntensity: 1,
	  inverseColors: !1,
	  opacityFrom: .30,
	  opacityTo: .05,
	  stops: [100, 100]
  }
},
series: [{
  name: 'Sales',
  data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
}],
labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
yaxis: {
  min: 0
},
grid: {
  padding: {
	top: 125,
	right: 0,
	bottom: 0,
	left: 0
  }, 
},
tooltip: {
  x: {
	show: false,
  },
  theme: 'dark'
},
colors: ['#805dca']
}
/*
  =================================
	  Revenue Monthly | Options
  =================================
*/
var options1 = {
chart: {
  fontFamily: 'Nunito, sans-serif',
  height: 360,
  type: 'area',
  zoom: {
	  enabled: false
  },
  dropShadow: {
	enabled: true,
	opacity: 0.2,
	blur: 10,
	left: -7,
	top: 22
  },
  toolbar: {
	show: true
  },
  events: {
	mounted: function(ctx, config) {
	  const highest1 = ctx.getHighestValueInSeries(0);
	  const highest2 = ctx.getHighestValueInSeries(1);
	  ctx.addPointAnnotation({
		x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
		y: highest1,
		label: {
		  style: {
			cssClass: 'd-none'
		  }
		},
		customSVG: {
			SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#2196f3" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
			cssClass: undefined,
			offsetX: -8,
			offsetY: 5
		}
	  })
	  ctx.addPointAnnotation({
		x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
		y: highest2,
		label: {
		  style: {
			cssClass: 'd-none'
		  }
		},
		customSVG: {
			SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
			cssClass: undefined,
			offsetX: -8,
			offsetY: 5
		}
	  })
	},
  }
},
colors: ['#2196f3', '#e7515a'],
dataLabels: {
	enabled: true
},
markers: {
  discrete: [{
  seriesIndex: 0,
  dataPointIndex: 7,
  fillColor: '#000',
  strokeColor: '#000',
  size: 5
}, {
  seriesIndex: 2,
  dataPointIndex: 11,
  fillColor: '#000',
  strokeColor: '#000',
  size: 4
}]
},
subtitle: {
  text: '',
  align: 'left',
  margin: 0,
  offsetX: 95,
  offsetY: 0,
  floating: true,
  style: {
	fontSize: '18px',
	color:  '#4361ee'
  }
},
title: {
  text: '',
  align: 'left',
  margin: 0,
  offsetX: -10,
  offsetY: 0,
  floating: true,
  style: {
	fontSize: '18px',
	color:  '#bfc9d4'
  },
},
stroke: {
	show: true,
	curve: 'smooth',
	width: 2,
	lineCap: 'square'
},
series: [{
	name: 'Входящие',
	data: [<?=$money_pre_month1?>, <?=$money_pre_month2?>, <?=$money_pre_month3?>, <?=$money_pre_month4?>, <?=$money_pre_month5?>, <?=$money_pre_month6?>, <?=$money_pre_month7?>, <?=$money_pre_month8?>, <?=$money_pre_month9?>, <?=$money_pre_month10?>, <?=$money_pre_month11?>, <?=$money_pre_month12?>]
}, {
	name: 'Исходящие',
	data: [<?=$money_pre_month_send1?>, <?=$money_pre_month_send2?>, <?=$money_pre_month_send3?>, <?=$money_pre_month_send4?>, <?=$money_pre_month_send5?>, <?=$money_pre_month_send6?>, <?=$money_pre_month_send7?>, <?=$money_pre_month_send8?>, <?=$money_pre_month_send9?>, <?=$money_pre_month_send10?>, <?=$money_pre_month_send11?>, <?=$money_pre_month_send12?>]
}],
labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
xaxis: {
  axisBorder: {
	show: false
  },
  axisTicks: {
	show: false
  },
  crosshairs: {
	show: true
  },
  labels: {
	offsetX: 0,
	offsetY: 5,
	style: {
		fontSize: '12px',
		fontFamily: 'Nunito, sans-serif',
		cssClass: 'apexcharts-xaxis-title',
	},
  }
},
yaxis: {
  labels: {
	formatter: function(value, index) {
	  return (value / 1000) + 'K'
	},
	offsetX: -22,
	offsetY: 0,
	style: {
		fontSize: '12px',
		fontFamily: 'Nunito, sans-serif',
		cssClass: 'apexcharts-yaxis-title',
	},
  }
},
grid: {
  borderColor: '#FFF',
  strokeDashArray: 5,
  xaxis: {
	  lines: {
		  show: true
	  }
  },   
  yaxis: {
	  lines: {
		  show: false,
	  }
  },
  padding: {
	top: 0,
	right: 0,
	bottom: 0,
	left: -10
  }, 
}, 
legend: {
  position: 'top',
  horizontalAlign: 'right',
  offsetY: -50,
  fontSize: '16px',
  fontFamily: 'Quicksand, sans-serif',
  markers: {
	width: 10,
	height: 10,
	strokeWidth: 0,
	strokeColor: '#fff',
	fillColors: undefined,
	radius: 12,
	onClick: undefined,
	offsetX: 0,
	offsetY: 0
  },    
  itemMargin: {
	horizontal: 0,
	vertical: 20
  }
},
tooltip: {
  theme: 'dark',
  marker: {
	show: true,
  },
  x: {
	show: false,
  }
},
fill: {
	type:"gradient",
	gradient: {
		type: "vertical",
		shadeIntensity: 1,
		inverseColors: !1,
		opacityFrom: .19,
		opacityTo: .05,
		stops: [100, 100]
	}
},
responsive: [{
  breakpoint: 575,
  options: {
	legend: {
		offsetY: -30,
	},
  },
}]
}
/*
  ==================================
	  Sales By Category | Options
  ==================================
*/
var options = {
  chart: {
	  type: 'donut',
	  width: 397
  },
  colors: ['#5c1ac3', '#e2a03f', '#e7515a', '#e2a03f'],
  dataLabels: {
	enabled: false
  },
  legend: {
	  position: 'bottom',
	  horizontalAlign: 'center',
	  fontSize: '14px',
	  markers: {
		width: 10,
		height: 10,
	  },
	  itemMargin: {
		horizontal: 0,
		vertical: 8
	  }
  },
  plotOptions: {
	pie: {
	  donut: {
		size: '65%',
		background: 'transparent',
		labels: {
		  show: true,
		  name: {
			show: true,
			fontSize: '29px',
			fontFamily: 'Nunito, sans-serif',
			color: undefined,
			offsetY: -10
		  },
		  value: {
			show: true,
			fontSize: '26px',
			fontFamily: 'Nunito, sans-serif',
			color: '#bfc9d4',
			offsetY: 16,
			formatter: function (val) {
			  return val
			}
		  },
		  total: {
			show: true,
			showAlways: true,
			label: 'Total',
			color: '#888ea8',
			formatter: function (w) {
			  return w.globals.seriesTotals.reduce( function(a, b) {
				return a + b
			  }, 0)
			}
		  }
		}
	  }
	}
  },
  stroke: {
	show: true,
	width: 25,
	colors: '#0e1726'
  },
  series: [985, 737, 270],
  labels: ['Apparel', 'Sports', 'Others'],
  responsive: [{
	  breakpoint: 1599,
	  options: {
		  chart: {
			  width: '350px',
			  height: '400px'
		  },
		  legend: {
			  position: 'bottom'
		  }
	  },
	  breakpoint: 1439,
	  options: {
		  chart: {
			  width: '250px',
			  height: '390px'
		  },
		  legend: {
			  position: 'bottom'
		  },
		  plotOptions: {
			pie: {
			  donut: {
				size: '65%',
			  }
			}
		  }
	  },
  }]
}
/*
  ==============================
  |    @Render Charts Script    |
  ==============================
*/
/*
  ============================
	  Daily Sales | Render
  ============================
*/
var d_2C_1 = new ApexCharts(document.querySelector("#daily-sales"), d_2options1);
d_2C_1.render();
/*
  ============================
	  Total Orders | Render
  ============================
*/
var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
d_2C_2.render();
/*
  ================================
	  Revenue Monthly | Render
  ================================
*/
var chart1 = new ApexCharts(
  document.querySelector("#revenueMonthly"),
  options1
);
chart1.render();
/*
  =================================
	  Sales By Category | Render
  =================================
*/
var chart = new ApexCharts(
  document.querySelector("#chart-2"),
  options
);
chart.render();
/*
  =============================================
	  Perfect Scrollbar | Recent Activities
  =============================================
*/
$('.mt-container').each(function(){ const ps = new PerfectScrollbar($(this)[0]); });
const topSellingProduct = new PerfectScrollbar('.widget-table-three .table-scroll table', {
wheelSpeed:.5,
swipeEasing:!0,
minScrollbarLength:40,
maxScrollbarLength:100,
suppressScrollY: true
});
} catch(e) {
  console.log(e);
}
</script>
 <script src="/plugins/counter/jquery.countTo.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="/assets/js/components/custom-counter.js"></script>
<!--  END CUSTOM SCRIPTS FILE  -->
<script>
window.onload = function(){
window.setInterval(function(){
  var now = new Date();
   var clock = document.getElementById("clock");
 clock.innerHTML = now.toLocaleTimeString();
}, 1000);
};
</script>
</body>
</html>