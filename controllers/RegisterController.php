<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/User.php';

class RegisterController extends Controller
{
    public function registerView()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $this->render('registerForm', ['csrf_token' => $_SESSION['csrf_token']]);
    }

    public function registerSaveForm()
    {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $this->render('registerForm', ['error' => "Token CSRF n'est pas correct."]);
            return;
        }
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
        $password = trim($_POST['password']);
        $repeatPassword = trim($_POST['repeatpassword']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('registerForm', ['error' => "L'email doit contenir '@' et être au format correct."]);
            return;
        }
        if ($password != $repeatPassword) {
            $this->render('registerForm', ['error' => 'Les mots de passe ne sont pas les mêmes']);
            return;
        }
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $this->render('registerForm', ['error' => 'Le mot de passe doit contenir au moins 8 caractères, y compris des lettres majuscules et minuscules, des chiffres et des caractères spéciaux.']);
            return;
        }

        $user = new User('users');
        $user->saveUser($_POST);
        $this->redirect('login');
    }

}