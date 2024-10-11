<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/FavoriteTrail.php';
require_once __DIR__ . '/../models/Trails.php';
require_once __DIR__ . '/../models/Membership.php';
require_once __DIR__ . '/../models/CompletedTrails.php';


class ProfileController extends Controller
{
    public function viewProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            exit;
        }

        $favoriteTrailsObject = new FavoriteTrail('favorites_trails');
        $favoriteTrails = $favoriteTrailsObject->getFavoriteTrailByUser($_SESSION['user_id']);
       

        $membershipObject = new Membership('membership');
        $availableMembership = $membershipObject->getMembershipByUserId($_SESSION['user_id']);

        $completedTrailObject = new CompletedTrails('completed_trails');
        $completedTrails = $completedTrailObject->getCompletedTrailByUser();

        require_once __DIR__ . '/../views/profile.php';
    }

}