<?php

require_once ('Controller.php');
require_once ('AdminMembershipController.php');
require_once __DIR__ . '/../model/BlockIp.php';

class IpController extends Controller {
    public function displayForm(){
        $this->checkAdmin();
        $this->render('ipForm');
    }
    public function saveIp(){
        $this->checkAdmin();
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
        $this->checkAdmin();
        $blockIp = new BlockIp('block_ips');
        $blockedIps = $blockIp->getAll();
        $this->render('listBlockedIps', ['blockedIps' => $blockedIps]);

    }
}