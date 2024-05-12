<?php

/**
*        Шаблонизатор
*
*        $tpl = new template();
*
*        $tpl->controller = $tpl->controller("main"); // Установка контроллера
*
*        $tpl->template = $tpl->template("template"); // Установка шаблона
*        echo $tpl->template; // Вывод в конце скрипта
*
*        $tpl->set("foo", 42); // Установить значение в хранилище (можно массивом)
*        $tpl->set("foo", array('abs' => 1, 'abc2' => 2)); // Записать массив
*
*        $this->__get("foo"); // Достать значение из хранилища значение (можно сразу в шаблон) или массив (нужно предварительно прогнать в контроллере)
* 
*        $this->__isset("foo"); // Проверка на существование
*
*/

class template
{
    protected $vars;

    public function __construct() {
        $this->vars = array();
    }

    public function __set($var, $value) {
        $this->vars[$var] = $value;
    }

    public function __get($var) {
        return $this->vars[$var];
    }

    public function __isset($var) {
        return isset($this->vars[$var]);
    }

    public function set() {
        $args = func_get_args();
        if (func_num_args() == 2) {
            $this->__set($args[0], $args[1]);
        }
        else {
            foreach ($args[0] as $var => $value) {
                $this->__set($var, $value);
            }
        }
    }

    public function template($template) {

        $file = $_SERVER["DOCUMENT_ROOT"] . "/template/" . $template . ".tpl";

        if (file_exists($file)) {
            ob_start();
            require $file;
            $content = ob_get_clean();
        } else {
            $content = false;
        }

        return $content;
    }


    public function controller($template) {

        $file = $_SERVER["DOCUMENT_ROOT"] . "/controller/" . $template . ".php";

        if (file_exists($file)) {
            ob_start();
            require $file;
            $content = ob_get_clean();
        } else {
            $content = false;
        }

        return $content;
    }

}