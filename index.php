<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost', 
    'httponly' => true, 
]);

session_start();
session_regenerate_id(true);
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$routes = [
    
    'login' => [
        'controller' => 'LoginController', 
        'method' => 'login',
    ],
    'register' => [
        'controller' => 'RegisterController',
        'method' => 'registerView',
    ],
    'register-form' => [
        'controller' => 'RegisterController',
        'method' => 'registerSaveForm',
    ],
    'loginForm' => [
        'controller' => 'LoginController',
        'method' => 'loginSaveForm',
    ],
    'homePageAdmin' => [
        'controller' => 'HomePageAdminController',
        'method' => 'homePageAdmin',
    ],
    'logout' => [
        'controller' => 'LoginController',
        'method' => 'logout',
    ],
    'login-using-google' => [
        'controller' => 'LoginController',
        'method' => 'loginUsingGoogle',
    ],
    'google-login' => [
        'controller' => 'LoginController',
        'method' => 'getDataFromGoogle',
    ],
    'ip-form' => [
        'controller' => 'IpController',
        'method' => 'displayForm',
    ],
    'ip-save' => [
        'controller' => 'IpController',
        'method' => 'saveIp',
    ],
    'ip-block' => [
        'controller' => 'IpController',
        'method' => 'getBlockIp',
    ],
    'facebook-login' => [
        'controller' => 'LoginController',
        'method' => 'loginUsingFacebook',
    ],
    'forgot-password' => [
        'controller' => 'LoginController',
        'method' => 'forgotPassword',
    ],
    'reset-password' => [
        'controller' => 'LoginController',
        'method' => 'resetPassword',
    ],
    'reset-password-request' => [
        'controller' => 'LoginController',
        'method' => 'resetPasswordRequest',
    ],
    'all-memberships' => [
        'controller' => 'UserMembershipController',
        'method' => 'viewAllMemberships'
    ],
    'admin-active-memberships-list' => [
        'controller' => 'AdminMembershipController',
        'method' => 'viewActiveMemberships'
    ],
    'add-membership' => [
        'controller' => 'UserMembershipController',
        'method' => 'addMember',
    ],
    'payment-success' => [
        'controller' => 'PaymentStatusController',
        'method' => 'paymentSuccess',
    ],
    'payment-failed' => [
        'controller' => 'PaymentStatusController',
        'method' => 'paymentFailed',
    ],
    'user-membership' => [
        'controller' => 'UserMembershipController',
        'method' => 'viewMembership',
    ],
    'user-memberships' => [
        'controller' => 'UserMembershipController',
        'method' => 'subscribeMembership',
    ],
    'subscribe-membership' => [
        'controller' => 'UserMembershipController',
        'method' => 'subscribeMembership',
    ],
    'view-available-memberships' => [
        'controller' => 'UserMembershipController',
        'method' => 'viewAvailableMemberships',
    ],
    'admin-memberships-list' => [
        'controller' => 'AdminMembershipController',
        'method' => 'viewMembership',
    ],
    'admin-memberships-add' => [
        'controller' => 'AdminMembershipController',
        'method' => 'addMembership',
    ],
    'admin-memberships-edit' => [
        'controller' => 'AdminMembershipController',
        'method' => 'editMembership',
    ],
    'admin-memberships-delete' => [
        'controller' => 'AdminMembershipController',
        'method' => 'deleteMembership',
    ],    
    '' => [
        'controller' => 'HomeController', 
        'method' => 'news',
    ],
    'home' => [
        'controller' => 'HomeController', 
        'method' => 'news',
    ],
    'details_news' => [
        'controller' => 'NewsController', 
        'method' => 'details_news',
    ],
    'about' => [
        'controller' => 'AboutController',
        'method' => 'about',
    ],
    'trails' => [
        'controller' => 'TrailsController',
        'method' => 'trails',
    ],
    'details_trails' => [
        'controller' => 'TrailsController',
        'method' => 'details_trails',
    ],
    'map' => [
        'controller' => 'MapController',
        'method' => 'map',
    ],
    'admin_home' => [
        'controller' => 'AdminController',
        'method' => 'home',
    ],
    'manage_trails' => [
        'controller' => 'AdminTrailsController',
        'method' => 'manageTrails',
    ],
    'manage_campsites' => [
        'controller' => 'AdminCampsitesController',
        'method' => 'manageCampsites',
    ],
    'manage_ressources' => [
        'controller' => 'AdminRessourcesController',
        'method' => 'manageRessources',
    ],
    'manage_reports' => [
        'controller' => 'AdminReportsController',
        'method' => 'manageReports',
    ],
    'manage_ship' => [
        'controller' => 'AdminMembershipController',
        'method' => 'viewMembership',
    ],
    'manage_article' => [
        'controller' => 'AdminArticleController',
        'method' => 'manageArticles',
    ],
    'manage_users' => [
        'controller' => 'AdminUsersController',
        'method' => 'manageUsers',
    ],
    'manage_admin' => [
        'controller' => 'AdminAdminController',
        'method' => 'manageAdmin',
    ],
    'admin_profil' => [
        'controller' => 'AdminProfilController',
        'method' => 'editAdminProfile',
    ],
    'create_trails' => [
        'controller' => 'AdminTrailsController',
        'method' => 'createTrails',
    ],
    'create_campsite' => [
        'controller' => 'AdminCampsitesController',
        'method' => 'createCampsites',
    ],
    'create_ressources' => [
        'controller' => 'AdminRessourcesController',
        'method' => 'createRessources',
    ],
    'create_reports' => [
        'controller' => 'AdminReportsController',
        'method' => 'createReports',
    ],
    'create_admin' => [
        'controller' => 'AdminAdminController',
        'method' => 'createAdmin',
    ],
    'create_ship' => [
        'controller' => 'AdminAdminController',
        'method' => 'addMembership',
    ],
    'create_articles' => [
        'controller' => 'AdminArticleController',
        'method' => 'createArticle',
    ],
    'manage-favorite-trail' => [
        'controller' => 'FavoritesTrailsController',
        'method' => 'manageFavoriteTrail',
    ],
    'profile' => [
        'controller' => 'ProfileController',
        'method' => 'viewProfile',
    ],
    'manage-completed-trail' => [
        'controller' => 'CompletedTrailsController',
        'method' => 'manageCompletedTrail',
    ],
    'campsite' => [
        'controller' => 'campsiteController',
        'method' => 'getCampsiteById',
    ],
    'reservationHistory' => [
        'controller' => 'reservationController',
        'method' => 'createReservation',
    ],
    'update-profile' => [
        'controller' => 'ProfileController',
        'method' => 'updateProfile',
    ],
    'profile-form' =>[
        'controller' => 'ProfileController',
        'method' => 'ProfileForm',
    ],
    'deleteReservation' =>[
        'controller' => 'ProfileController',
        'method' => 'deleteReservation',
        'params' => ['reservation_id']
    ],

    'campsite' => [
        'controller' => 'campsiteController',
        'method' => 'getAllCampsites',
    ],
    'campsiteDetails' => [
        'controller' => 'campsiteController',
        'method' => 'getCampsiteById',
    ],

    'reservation_history' => [
        'controller' => 'ReservationController',
        'method' => 'getReservationsByUser',
    ],

    'calendar' => [
        'controller' => 'CalendarController',
        'method' => 'showCalendar',
    ],
    'coves' => [
        'controller' => 'CoveController',
        'method' => 'getAllCoves',
    ],

    'ressources' => [
        'controller' => 'RessourceController',
        'method' => 'getAllRessources',
    ],
    'ressourceDetails' => [
        'controller' => 'RessourceController',
        'method' => 'getRessourceById',
    ],
    'payment' => [
        'controller' => 'PaymentController',
        'method' => 'processPayment',
    ]
];

// * Nettoyage et traitement de l'URL via le virutalhost
// $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $url = trim($url, '/');
// $url = str_replace('.php', '', $url);
// $urlArray = explode('?', $url);

// //* Nettoyage et traitement de l'URL via localhost/parcNational/
$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);//Removal of the string 'parkNational' from the link
$urlArray = explode('?', $url);

if (isset($routes[$urlArray[0]])) { 
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];

    require_once 'models/BlockIp.php';
    $blockIp = new BlockIp('block_ips');
    if ($blockIp->isIpBlocked()) {
        echo 'Your IP is blocked';
        return;
    }

    require_once 'models/Log.php';
    $log = new Log('logs');
    $log->saveLog($url);
    require_once 'controllers/' . $className . '.php';

    // Création de l'objet en fonction de la classe
    if ($className == 'HomeController') {
        $object = new $className('news');
    } elseif ($className == 'TrailsController') {
        $object = new $className('trails');
    } else {
        $object = new $className; // Pour les autres contrôleurs
    }

    // Vérification si la méthode nécessite un ID
    if ($methodName === 'details_news') {
        // Vérifiez si un ID est passé dans l'URL, par exemple : /details_news?id=123
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $object->{$methodName}($id); // Appel de la méthode avec l'ID
        } else {
            echo "Erreur : ID manquant.";
            return;
        }
    } elseif (in_array($methodName, ['getCampsiteById', 'getRessourceById'])) {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $object->{$methodName}($id); // Appel avec l'ID
        } else {
            echo "Erreur : ID manquant.";
            return;
        }
    } elseif ($methodName === 'getReservationsByUser') {
        $user_id = 1; // Remplacez par l'ID de l'utilisateur connecté
        $object->{$methodName}($user_id); 
    } else {
        $object->{$methodName}();
    }
} else {
    echo "Pas d'adresse valide.";
}