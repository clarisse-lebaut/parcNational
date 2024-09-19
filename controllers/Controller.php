<?php

class Controller{
    public function render($view){
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}