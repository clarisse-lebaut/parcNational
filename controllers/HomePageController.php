<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/BlockIp.php';

class HomePageController extends Controller{
    public function homePage(){
        var_dump($_SESSION);
        $this->render('homePageUser');//Calling the render method and assigning homePage to $view
    }
}