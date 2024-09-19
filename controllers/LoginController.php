<?php
require_once 'Controller.php';
class LoginController extends Controller{
    public function login(){
        $this->render('login');
    }
}

