<?php

require_once('Controller.php');
require_once('AdminMembershipController.php');
require_once __DIR__ . '/../model/BlockIp.php';

class IpController extends Controller
{
    public function displayForm()
    {
        $this->checkAdmin();
        $this->render('ipForm');
    }

    public function saveIp()
    {
        $this->checkAdmin();
        $ip = $_POST['ip'];
        $message = '';
        $messageType = '';
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $blockIp = new BlockIp('block_ips');
            $blockIp->saveIp($ip);
            $message = 'IP successfully saved';
            $messageType = 'alert';
        } else {
            $message = 'Invalid IP address!';
            $messageType = 'alert-error';
        }
        $this->render('ipForm', ['message' => $message, 'messageType' => $messageType]);
    }

    public function getBlockIp()
    {
        $this->checkAdmin();
        $blockIp = new BlockIp('block_ips');
        $blockedIps = $blockIp->getAll();
        $this->render('listBlockedIps', ['blockedIps' => $blockedIps]);

    }
}