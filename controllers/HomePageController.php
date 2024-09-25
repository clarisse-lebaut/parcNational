<?php

require_once 'Controller.php';

class HomePageController extends Controller{
    public function homePage(){
        $this->render('homePageUser');//Calling the render method and assigning homePage to $view
    }
}