<?php

/**
*        Автозагрузчик классов
*
*        require '/class/autoloader.class.php';
*
*        spl_autoload_register(array('autoloader', 'loadPackages'));
*
*/

class autoloader
{  
     public static function loadPackages($className) {
         require_once($_SERVER["DOCUMENT_ROOT"]."/class/" . $className . '.class.php');
     }

}