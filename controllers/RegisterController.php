<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/User.php';

class RegisterController extends Controller{
    public function registerView(){
        $this->render('registerForm');
    }

    public function registerSaveForm(){
        var_dump($_POST);
        if($_POST['password'] === $_POST['repeatpassword']){
            $user = new User('users');
            $user->saveUser($_POST);
        }
    }
    
}