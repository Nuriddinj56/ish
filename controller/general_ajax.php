<?php
/**
*
* Контроллер AJAX
*
* Файлы хранятся:
* \controller\general\ajax\
*
*/
$home = $_SERVER['DOCUMENT_ROOT'].'/';
require_once $home . "classes/Db.php";
$db = new Db();
$this->pdo = $db->connect();

$db = $this->info_db;


if (empty($_GET['page'])):
	header("Location: /main/");
endif;

// Проверяем фильтром пришедшие данные
$check_page = new filter();
$page = $check_page->check('page','get','regexp','~^[a-z]{1,20}$~');
// Проверяем фильтром пришедшие данные

if ($page):

	$sub_controller = $_SERVER["DOCUMENT_ROOT"].'/controller/general/ajax/'.$page.'.php';

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