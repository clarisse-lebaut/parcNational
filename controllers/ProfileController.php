<?php

require_once 'Controller.php';
require_once __DIR__ . '/../model/FavoriteTrail.php';
require_once __DIR__ . '/../models/Trails.php';
require_once __DIR__ . '/../model/Membership.php';


class ProfileController extends Controller{
    public function viewProfile() {
        if(!isset($_SESSION['user_id'])){
            $this->render('login');
            exit;
        }

        $favoriteTrailsObject = new FavoriteTrail('favorites_trails');
        $favoriteTrails = $favoriteTrailsObject->getFavoriteTrailByUser($_SESSION['user_id']);


        $membershipObject = new Membership('membership');
        $availableMembership = $membershipObject->getMembershipByUserId($_SESSION['user_id']);
        require_once __DIR__ . '/../views/profile.php';
    }

}