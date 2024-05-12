<?php
/**
*
* Контроллер магазина (главной части)
*
* Файлы хранятся:
* \controller\general\
* \template\general\
*
*/
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/Db.php";
$db = new Db();
$this->pdo = $db->connect();

$total_order = $this->pdo->query("SELECT * FROM transactions");
$total_order = $total_order->fetchAll();

$total_card = $this->pdo->query("SELECT * FROM card WHERE active = 'Активна'");
$total_card = $total_card->fetchAll();

$get_setting = $this->pdo->query("SELECT * FROM `necro_setting` WHERE id = '1' ");
$get_setting = $get_setting->fetch(PDO::FETCH_ASSOC);

// Если не передан, то отправляем на main
if (empty($_GET['page'])):
	$_GET['page'] = 'main';
	$page = 'main';
endif;
// Если не передан, то отправляем на main

// Проверяем фильтром пришедшие данные
$check_page = new filter();
if (empty($page)):
	$page = $check_page->check('page','get','regexp','~^[a-z]{1,20}$~');
endif;
// Проверяем фильтром пришедшие данны

$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "Mobile_Detect.php";
$detect = new Mobile_Detect;
// Подгружаем нужный субконтроллер
if ($page):
	$sub_controller = $_SERVER["DOCUMENT_ROOT"].'/controller/general/'.$page.'.php';
	if (file_exists($sub_controller)):
		require $sub_controller;
	else:
		//echo "Ошибка, субконтроллер не найден";
		header('Location: /');
	endif;
else:
	//echo "Ошибка, не пройдена валидация субконтроллера";
	header('Location: /');
endif;
// Подгружаем нужный субконтроллер