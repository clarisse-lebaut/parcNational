<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/FavoriteTrail.php';
require_once __DIR__ . '/../models/Trails.php';
require_once __DIR__ . '/../models/Membership.php';
require_once __DIR__ . '/../models/CompletedTrails.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ReservationModel.php';


class ProfileController extends Controller
{
    public function viewProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->render('login');
            exit;
        }
        /*Fetching favorites trails for the current user to display on the profile page*/
        $favoriteTrailsObject = new FavoriteTrail('favorites_trails');
        $favoriteTrails = $favoriteTrailsObject->getFavoriteTrailByUser($_SESSION['user_id']);
       
        /*Fetching active membership details for the current user to display on the profile page*/
        $membershipObject = new Membership('membership');
        $availableMembership = $membershipObject->getMembershipByUserId($_SESSION['user_id']);

        /*Fetching completed trails for the current user to diplay on the profile page*/
        $completedTrailObject = new CompletedTrails('completed_trails');
        $completedTrails = $completedTrailObject->getCompletedTrailByUser();

        /*Fetching the current user's information to display on the profile page*/
        $userId = $_SESSION['user_id'];
        $User = new User('users');
        $userId = $User->getById($userId);

        /*Fetching the current user's reservations to display on the profile page*/
        $user_id = $_SESSION['user_id'];
        $reservedCampingObject = new User('c.campsite_id');
        $reservedCampings = $reservedCampingObject->getReservationsByUser($user_id);
        require_once __DIR__ . '/../views/profile.php';
    }

    public function ProfileForm(){
        if (!isset($_SESSION['user_id'])) {
        $this->render('login');
        exit;
    }
    /* Fetching the user's saved informations and rendering it in the profile form*/
    $userId = $_SESSION['user_id'];
    $userModel = new User('users');
    $userData = $userModel->getById($userId);

    $this->render('profileForm', ['userData' => $userData]);
    }


    public function updateProfile(){
        if (!isset($_SESSION['user_id'])) {
        $this->render('login');
        exit;
    }

    /* Preparing an array with the updated user data from the form*/ 
    $userId = $_SESSION['user_id'];
    $userModel = new User('users');
    $userData = $userModel->getById($userId);
    $updatedData = [
        'firstname' => htmlspecialchars(trim($_POST['firstname'])),
        'lastname' => htmlspecialchars(trim($_POST['lastname'])),
        'gender' => $_POST['gender'] ?? $userData['gender'],
        'phone' => htmlspecialchars(trim($_POST['phone'])),
        'address' => htmlspecialchars(trim($_POST['address'])),
        'city' => htmlspecialchars(trim($_POST['city'])),
        'zipcode' => htmlspecialchars(trim($_POST['zipcode'])),
        'mail' => filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)
    ];

    if (!empty($_POST['password'])) {
        if($_POST['password'] === $_POST['repeatpassword']){
            $updatedData['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }else{
            $errorMessage = "Les mots de passe saisis sont différents";
            $this->render('profileForm', ['userData' => $userData, 'errorMessage' => $errorMessage]);
            return;
        }
    } else {
        $updatedData['password'] = $userData['password'];
    }

    /*Updating user data using updateUser method*/
    $userModel = new User('users');
    $userModel->updateUser($userId, $updatedData);
    $_SESSION['firstname'] = $updatedData['firstname'];
    $_SESSION['lastname'] = $updatedData['lastname'];
    $_SESSION['gender'] = $updatedData['gender'];
    $_SESSION['phone'] = $updatedData['phone'];
    $_SESSION['address'] = $updatedData['address'];
    $_SESSION['city'] = $updatedData['city'];
    $_SESSION['zipcode'] = $updatedData['zipcode'];
    $_SESSION['mail'] = $updatedData['mail'];
    
    /* Redirection to the profile site after data updating*/
    header('Location: profile');
    exit;
    }

}