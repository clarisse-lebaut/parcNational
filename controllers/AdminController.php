<?php

require_once 'Controller.php';

class AdminController extends Controller {

    // fonction qui permet de faire apparaitre la page
    public function all_data(){
        $this->render('admin_home');
    }
}