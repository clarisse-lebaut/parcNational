<?php

require_once 'Controller.php';

class HomePageAdminController extends Controller{
    public function homePageAdmin(){
        if($_SESSION['user_role'] != 2){
            return $this->redirect('');
        }else{
            $this->render('homePageAdmin');
        }
    }
}