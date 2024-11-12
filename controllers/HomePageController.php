<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/BlockIp.php';

class HomePageController extends Controller{
    public function homePage(){
        $this->render('homePageUser');//Calling the render method and assigning homePage to $view
    }
}