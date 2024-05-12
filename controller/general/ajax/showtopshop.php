<?php
$home = $_SERVER['DOCUMENT_ROOT'].'/';


$get_set = $this->pdo->query("SELECT * FROM `necro_setting` WHERE id = '1' ");
$get_set = $get_set->fetch(PDO::FETCH_ASSOC);

$shop_top = $this->pdo->query("SELECT * FROM shop ORDER BY oborot DESC LIMIT 7");
$shop_top = $shop_top->fetchAll();
if (empty($shop_top)):
?>
<h6>Вы еще не создали ни одного магазина</h6>
<?
else:
foreach ($shop_top as $key => $row):
	$time_add = date('Y-m-d H:i:s', $row['createdate']);
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
		
		$date_now = date('Y-m-d');
		$money_today = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE status_payclient = 'Оплата получена' and id_shop = ".$row['id']." AND date = '".$date_now."'");
		$money_today =  $money_today->fetch(PDO::FETCH_ASSOC);
		if (!$money_today['sum_rub']):
		$money_today['sum_rub'] = 0;
		endif;
		
        $date_now = date('Y-m-d',strtotime("-1 days"));
		$money_yestoday = $this->pdo->query("SELECT SUM(sum_rub) AS sum_rub FROM transactions WHERE status_payclient = 'Оплата получена' and id_shop = ".$row['id']." AND date = '".$date_now."'");
		$money_yestoday =  $money_yestoday->fetch(PDO::FETCH_ASSOC);
		if (!$money_yestoday['sum_rub']):
		$money_yestoday['sum_rub'] = 0;
		endif;
		
		$price = $money_yestoday['sum_rub'];
		$price_old = $money_today['sum_rub'];
        $perc = (($price - $price_old) * 100) / $price;
		$num = number_format($perc, 1, ',', '');
		$name = mb_substr($row['name'],0,2,'UTF-8');
		$name = mb_strtoupper($name);
		
		$color="t-secondary";
		if($color=='t-secondary'){
			$color = 't-info';
			} else {
			$color = 't-secondary';
		}
		
		$money_today = number_format($money_today['sum_rub']);
		$text = $row['name'];

$first = substr($text,0,2);
$first = mb_strtoupper($first);
?>
<div style="margin-top:-5px;" class="transactions-list <?php if ($bgcol == 't-info') {$bgcol = 't-secondary';} else {$bgcol = 't-info';} echo $bgcol; ?>">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-icon">
                                                <div class="avatar avatar-xl">
                                                    <span class="avatar-title"><?=$first?></span>
                                                </div>
                                            </div>
                                            <div class="t-name">
                                                <h4><?=$row['name']?></h4>
                                                <p class="meta-date"><?=$datetime_create?></p>
                                            </div>

                                        </div>
                                        <div class="t-rate rate-inc">
                                            <p><span><? echo $money_today;?> ₽</span></p>
                                        </div>
                                    </div>
                                </div>
<?
endforeach;
endif;
?>