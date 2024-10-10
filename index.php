<?php
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
    //The login displays the login page, then selects the Controller and the method
    'login' => [
        'controller' => 'LoginController', 
        'method' => 'login',
    ],
    //Display register Page
    'register' => [
        'controller' => 'RegisterController',
        'method' => 'registerView',
    ],
    //Save register form
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
    'facebook-login' =>[
        'controller' => 'Logincontroller',
        'method' => 'loginUsingFacebook',
    ],
    'forgot-password' => [
        'controller' => 'loginController',
        'method' => 'forgotPassword',
    ],
    'reset-password' => [
        'controller' => 'loginController',
        'method' => 'resetPassword',
    ],
    'reset-password-request' => [
        'controller' => 'loginController',
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
    'add-membership' =>[
        'controller' => 'UserMembershipController',
        'method' => 'addMember',
    ],
    'payment-success' =>[
        'controller' => 'PaymentStatusController',
        'method' => 'paymentSuccess',
    ],
    'payment-failed' =>[
        'controller' => 'PaymentStatusController',
        'method' => 'paymentFailed',
    ],
    'user-membership' =>[
        'controller' => 'UserMembershipController',
        'method' => 'viewMembership',
    ],
    'user-memberships' => [
        'controller' => 'UserMembershipController',
        'method' => 'subscribeMembership',
    ],
    'subscribe-membership' =>[
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
    'manage_campsite' => [
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
    'manage_users' => [
        'controller' => 'AdminUsersController',
        'method' => 'manageUsers',
    ],
    'manage_admin' => [
        'controller' => 'AdminAdminController',
        'method' => 'manageAdmin',
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
    'manage-favorite-trail' => [
        'controller' => 'FavoritesTrailsController',
        'method' => 'manageFavoriteTrail',
    ],
    'profile' => [
        'controller' => 'ProfileController',
        'method' => 'viewProfile',
    ]
];

$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);//Removal of the string 'parkNational' from the link
$urlArray = explode('?', $url);
if(isset($routes[$urlArray[0]])){
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];
   // var_dump($methodName);

    require_once 'models/BlockIp.php';
    $blockIp = new BlockIp('block_ips');
    if($blockIp->isIpBlocked()){
        echo 'Your Ip is blocked';
        return;
    }
    require_once 'models/Log.php';
    $log = new Log('logs');
    $log->saveLog($url);
    require_once 'controllers/' . $className . '.php';

    $object = new $className; 
    $object->{$methodName}();
    
}else{
    var_dump("pas d'adresse");
}