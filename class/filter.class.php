<?php

/**
* Валидатор данных
*
* $ft = new filter();
*
* $ft->check($name,$type,$filter);
* $ft->check($name,$type,$filter,$option);
*
* $name - название поля
* $type - тип запроса (POST/GET)
* $filter - фильтрация по данным
*	- email
*	- int (целочисленный)
*	- float (число с плавающей точкой)
*	- url
*	- regexp
* $option - дополнительные параметры (не обязательно)
*	- при int: array('min' => 5, 'max' => 8)  - максимальное и минимальное число
*	- при regexp: передаём регулярное выражение заключая в ограничители
*
*
*
*/

	class filter
	{
		
		function check($name,$type,$filter,$options = null) {

			if ($type == 'get') {
				$type = INPUT_GET;
			} else if ($type == 'post') {
				$type = INPUT_POST;
			} else {
				return false;
			}

			if ($filter == 'email') {
				$filter = FILTER_VALIDATE_EMAIL;
				$options = null;
			} else if ($filter == 'float') {
				$filter = FILTER_VALIDATE_FLOAT;
				$options = null;
			} else if ($filter == 'int') {
				$filter = FILTER_VALIDATE_INT;

				if (isset($options['min']) and isset($options['max'])) {
					$options = array("options" => array("min_range" => $options['min'], "max_range" => $options['max']));
				} else {
					$options = null;
				}
			} else if ($filter == 'url') {
				$filter = FILTER_VALIDATE_URL;
				$options = null;
			} else if ($filter == 'regexp') {
				$filter = FILTER_VALIDATE_REGEXP;
				if (empty($options)) {
					return false;
				} else {
					$options = array("options" => array("regexp" => $options));
				}
			} else {
				return false;
			}

			$value = filter_input($type, $name, $filter, $options);
			return $value;
		}
	}