<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/User.php';

class RegisterController extends Controller{
    public function registerView(){
        $this->render('registerForm');
    }

    public function registerSaveForm(){
        if($_POST['password'] === $_POST['repeatpassword']){
            $user = new User('users');// Create a new user in users table
            $user->saveUser($_POST);
            $this->redirect('login');
        }else{
            $this->render('registerForm', ['error' => 'The password and repeatpassword are not the same']); 
        }
    }
}