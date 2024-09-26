<?php

require_once 'Controller.php';

class HomePageController extends Controller{
    public function homePage(){
        ////////////////////////////
        $userIp = $_SERVER['REMOTE_ADDR'];
        $blockIpModel = new BlockIp('block_ips');
        $blockedIps = $blockIpModel->getAll();

        foreach ($blockedIps as $blocked){
            if($blocked['ip'] === $userIp){
                die (' Your IP is blocked! ');
            }
        }

        $this->render('homePageUser');//Calling the render method and assigning homePage to $view
    }
}