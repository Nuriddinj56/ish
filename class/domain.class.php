<?php

/**
*        Класс обработки домена и субдомена
*
*        $dmn = new domain();
*        
*        $domain = $dmn->check("vskut.ru",$_SERVER['HTTP_HOST']);
*
*        Возвращает 'domain' или имя субдомена
*
*/

	class domain
	{
		
		function check($my_domain,$domain) {

				$domain = str_replace($my_domain, "", $domain);

				$domain = (!empty($domain)) ? str_replace(".", "", $domain) : 'domain';

				return $domain;
				
		}
		
	}