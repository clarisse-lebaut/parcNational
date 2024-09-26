<?php

require_once ('Controller.php');
require_once __DIR__ . '/../model/BlockIp.php';

class IpController extends Controller {
    public function displayForm(){
        $this->render('ipForm');
    }/////////////////
    public function saveIp(){
        $ip = $_POST['ip'];

        if(filter_var($ip, FILTER_VALIDATE_IP)){
            $blockIp = new BlockIp('block_ips');
            $blockIp->saveIp($ip);
            echo 'IP successfully saved';
        }else {
            echo 'Invalid IP address!';
        }

    
    }
    public function getBlockIp(){

    }
}