<?php

require_once 'Controller.php';

class HomePageController extends Controller{
    public function homePage(){
        $this->render('homePage');
    }
}