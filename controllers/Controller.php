<?php

class Controller
{
    public function render($view, $data = [])
    {//In this case, $data is a default parameter
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
    public function redirect($url)
    {
        header('Location: /' . $url);
    }

    protected function checkAdmin()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
            $this->redirect('login');
            exit;
        }
    }
}