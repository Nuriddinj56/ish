<?php
/**
*
* Субконтроллер, настройка самого магазина
*
* Файлы хранятся:
* \controller\general\shop\
* \template\general\shop\
*
*/
if (empty($_SESSION['user_id'])):
	header('Location: /');
	exit;
endif;

$db = $this->info_db;
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "Mobile_Detect.php";
$detect = new Mobile_Detect;
if (empty($_GET['page2']) or empty($_GET['shop'])):
	header("Location: /shops/");
	exit;
endif;

// Проверяем фильтром пришедшие данные
$check_page = new filter();
$page = $check_page->check('page2','get','regexp','~^[a-z]{1,20}$~');
$shop = $check_page->check('shop','get','regexp','~^[a-z0-9]{3,20}$~');
// Проверяем фильтром пришедшие данные

if (!$shop):
	header("Location: /shops/");
	exit;
else:
	$getshop_control = $db->row("SELECT * FROM shop WHERE domain = ? AND id_user = ?", array($_GET['shop'], $_SESSION["user_id"]));
	if (!$getshop_control):
		header("Location: /shops/");
		exit;
	endif;
endif;
$gets = $db->row("SELECT * FROM shop WHERE domain = ? AND id_user = ?", array($_GET['shop'], $_SESSION["user_id"]));
$gets_time = $db->row("SELECT * FROM template WHERE id_shop = ?", array($gets['id']));
date_default_timezone_set($gets_time['time_zone']);


function num_word($value, $words, $show = true) 
{
	$num = $value % 100;
	if ($num > 19) { 
		$num = $num % 10; 
	}
	
	$out = ($show) ?  $value . ' ' : '';
	switch ($num) {
		case 1:  $out .= $words[0]; break;
		case 2: 
		case 3: 
		case 4:  $out .= $words[1]; break;
		default: $out .= $words[2]; break;
	}
	
	return $out;
}

// Подгружаем нужный субконтроллер
if ($page):

	$sub_controller = $_SERVER["DOCUMENT_ROOT"].'/controller/general/shop/'.$page.'.php';
	if (file_exists($sub_controller)):
		require $sub_controller;
	else:
		//echo "Ошибка, субконтроллер не найден";
		header("Location: /");
	endif;
else:
	//echo "Ошибка, не пройдена валидация субконтроллера";
	header("Location: /");
endif;
// Подгружаем нужный субконтроллер
