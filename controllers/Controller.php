<?php

require_once 'Controller.php';

class Controller{
    public function render($view, $data = []){//In this case, $data is a default parameter
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
    public function redirect($url){
        header('Location: /parcNational/' . $url);
    }
}