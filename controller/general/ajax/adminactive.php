<?php



$category = $this->pdo->query("SELECT * FROM activity_admin order by date DESC LIMIT 25");
while ($row = $category->fetch()) {
$get_admin = $this->pdo->query("SELECT * FROM `dle_users` WHERE id = '".$row['user_id']."' ");
$get_admin = $get_admin->fetch(PDO::FETCH_ASSOC);

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
		
$date = $row['date'];


if ( $row['action'] == 'active' ) {
	
	$active = '<div class="t-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div>';
	
} elseif ( $row['action'] == 'delete' ) {
	
		$active = '<div class="t-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></div>';

	
 } elseif ( $row['action'] == 'save' ) {
	
		$active = '<div class="t-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></div>';

	
}


?>
<div class="item-timeline timeline-new">
                                            <div class="t-dot">
											 <?=$active?>
                                            </div>
                                            <div class="t-content">
                                                <div class="t-uppercontent" style="margin-bottom:-7px;">
                                                    <small><b><?=$row['text']?></b></small>
                                                    <span class=""><small><b><?=$get_admin['username']?></b></small></span>
                                                </div>
                                               <small class="text-info"><?=showDate($date)?></small>
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