<?php



$category = $this->pdo->query("SELECT * FROM transactions order by id DESC LIMIT 20");
while ($row = $category->fetch()) {

$time_add = date('Y-m-d H:i:s', $row['date_create']);
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
		
$date = $row['date_create'];


if ( $row['status'] == 'Ждём оплату' ) {
	
	$status_dot = 'timeline-warning';
	$dot_color = 'dd9c3e';
	
} elseif ( $row['status'] == 'Зачислено на счёт' ) {
	
	$status_dot = 'timeline-success';
	$dot_color = '009688';

	
 } elseif ( $row['status'] == 'Просрочено' ) {
	
	$status_dot = 'timeline-danger';
	$dot_color = 'e7515a';

	
} elseif ( $row['status'] == 'Выплачено' ) {
	
	$status_dot = 'timeline-success';
	$dot_color = '009688';

	
} elseif ( $row['status'] == 'Видим оплату' ) {
	
	$status_dot = 'timeline-success';
	$dot_color = '009688';

	
} elseif ( $row['status'] == 'Переводим средства' ) {
	
	$status_dot = 'timeline-secondary';
	$dot_color = '009688';

	
} elseif ( $row['status'] == 'Отменён' ) {
	
	$status_dot = 'timeline-danger';
	$dot_color = '009688';

	
}

if ( $row['kto'] == 'shop' ) {
$live_shop = $this->pdo->query("SELECT * FROM `shop` WHERE id = '".$row['id_shop']."' ");
$live_shop = $live_shop->fetch(PDO::FETCH_ASSOC);
	$kto = $live_shop['name'];
	$gde = 'API:';

	
} elseif ( $row['kto'] == 'clients' ) {
	
$live_user = $this->pdo->query("SELECT * FROM `dle_users` WHERE chat = '".$row['chat']."' ");
$live_user = $live_user->fetch(PDO::FETCH_ASSOC);
	$kto = $live_user['last_name'].' '.$live_user['first_name'];
	$gde = 'БОТ:';
}


?>
                                        <div class="item-timeline <?=$status_dot?>">
                                            <div class="t-dot" data-original-title="" title="">
                                            </div>
                                            <div class="t-text">
                                                <p><span>Заявка <b><span style="color:#<?=$dot_color?>;">#<?=$row['id']?></span></b></span> <?=$gde?> <span style="color:#<?=$dot_color?>;"><b><?=$kto?></b></span></p>
                                                <span class="badge"><?=$row['status']?></span>
                                                <p class="t-time"><?=showDate($date)?></p>
                                            </div>
                                        </div>

<?php
}

function showDate( $date ) // $date --> время в формате Unix time
{
    $stf      = 0;
    $cur_time = time();
    $diff     = $cur_time - $date;
 
    $seconds = array( 'секунда', 'секунды', 'секунд' );
    $minutes = array( 'минута', 'минуты', 'минут' );
    $hours   = array( 'час', 'часа', 'часов' );
    $days    = array( 'день', 'дня', 'дней' );
    $weeks   = array( 'неделя', 'недели', 'недель' );
    $months  = array( 'месяц', 'месяца', 'месяцев' );
    $years   = array( 'год', 'года', 'лет' );
    $decades = array( 'десятилетие', 'десятилетия', 'десятилетий' );
 
    $phrase = array( $seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades );
    $length = array( 1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600 );
 
    for ( $i = sizeof( $length ) - 1; ( $i >= 0 ) && ( ( $no = $diff / $length[ $i ] ) <= 1 ); $i -- ) {
        ;
    }
    if ( $i < 0 ) {
        $i = 0;
    }
    $_time = $cur_time - ( $diff % $length[ $i ] );
    $no    = floor( $no );
    $value = sprintf( "%d %s ", $no, getPhrase( $no, $phrase[ $i ] ) );
 
    if ( ( $stf == 1 ) && ( $i >= 1 ) && ( ( $cur_time - $_time ) > 0 ) ) {
        $value .= time_ago( $_time );
    }
 
    return $value . ' назад';
}
 
function getPhrase( $number, $titles ) {
    $cases = array( 2, 0, 1, 1, 1, 2 );
 
    return $titles[ ( $number % 100 > 4 && $number % 100 < 20 ) ? 2 : $cases[ min( $number % 10, 5 ) ] ];
}
?>