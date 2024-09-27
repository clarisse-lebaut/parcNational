<?php

require_once 'Controller.php';

class AboutController extends Controller {

    public function about(){
        $this->render('about');
    }
    
}