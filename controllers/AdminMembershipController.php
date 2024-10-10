<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once ('Controller.php');
require_once __DIR__ . '/../model/Membership.php';
require_once __DIR__ . '/../model/User.php';

class AdminMembershipController extends Controller {
    
    public function viewMembership() {
        $this->checkAdmin();
        if (isset($_SESSION['user_id'])) {
            $membership = new Membership('membership');
            
            // Récupérer toutes les adhésions
            $allMemberships = $membership->getAllMemberships();
            
            // Récupérer le nombre total d'adhésions
            $totalMemberships = $membership->getTotalMemberships();
            
            // Récupérer une adhésion aléatoire
            $randomMembership = !empty($allMemberships) ? $allMemberships[array_rand($allMemberships)] : null;

            // Passer les données à la vue
            $this->render('admin/manage_ships', [
                'memberships' => $allMemberships,
                'totalMemberships' => $totalMemberships,
                'randomMembership' => $randomMembership
            ]);
        } else {
            $this->redirect('login');
        }
    }

    public function addMembership() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $membershipsName = $_POST['memberships_name'];
            $duration = $_POST['duration'];
            $price = $_POST['price'];
            $membershipModel = new Membership('membership');
            $membershipModel->addMembership($membershipsName, $duration, $price);
            $this->redirect('admin-memberships-list');
        } else {
            $this->render('admin/create_ships');
        }
    }
    
    public function editMembership() {
        $this->checkAdmin();
        $membershipModel = new Membership('membership');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $membershipsName = $_POST['memberships_name'];
            $membershipId = $_POST['card_id'];
            $duration = $_POST['duration'];
            $price = $_POST['price'];
            
            $membershipModel->updateMembership($membershipsName, $duration, $price, $membershipId);
            $this->redirect('admin-memberships-list');
        } else {
            $membershipId = $_GET['id'];
            $membership = $membershipModel->getMembershipById($membershipId);
            $this->render('admin/adminMembershipForm', ['membership' => $membership]);
        }
    }

    public function deleteMembership() {
        $this->checkAdmin();
        $membershipId = $_GET['id'];
        $membershipModel = new Membership('membership');
        $membershipModel->deleteMembership($membershipId);
        $this->redirect('admin-memberships-list');
    }

    public function viewActiveMemberships() {
        $this->checkAdmin();
        $membership = new Membership('membership');
        $activeMemberships = $membership->getAllActiveMembershipsForAdmin(); 
        $this->render('admin/adminActiveMembershipsList', ['activeMemberships' => $activeMemberships]);
    }

    protected function checkAdmin(){
        if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2){
            $this->redirect('login');
            exit;
        }
    }
    
}
