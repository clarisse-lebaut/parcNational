<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once ('Controller.php');
require_once __DIR__ . '/../model/Membership.php';
require_once __DIR__ . '/../model/User.php';

class AdminMembershipController extends Controller {
    
    public function viewMemberships() {
        $membershipModel = new Membership('membership');
        $memberships = $membershipModel->getAllMemberships();
        $this->render('adminMemberships', ['memberships' => $memberships]);
    }

    public function addMembership() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $membershipsName = $_POST['memberships_name'];
            $duration = $_POST['duration'];
            $price = $_POST['price'];
            
            $membershipModel = new Membership('membership');
            $membershipModel->addMembership($membershipsName, $duration, $price);
            $this->redirect('admin-memberships');
        } else {
            $this->render('adminMembershipForm');
        }
    }

    public function editMembership() {
        $membershipModel = new Membership('membership');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $membershipsName = $_POST['memberships_name'];
            $membershipId = $_POST['card_id'];
            $duration = $_POST['duration'];
            $price = $_POST['price'];
            
            $membershipModel->updateMembership($membershipId, $membershipsName, $duration, $price);
            $this->redirect('admin-memberships');
        } else {
            $membershipId = $_GET['id'];
            $membership = $membershipModel->getMembershipById($membershipId);
            $this->render('adminMembershipForm', ['membership' => $membership]);
        }
    }

    public function deleteMembership() {
        $membershipId = $_GET['id'];
        $membershipModel = new Membership('membership');
        $membershipModel->deleteMembership($membershipId);
        $this->redirect('admin-memberships');
    }
}