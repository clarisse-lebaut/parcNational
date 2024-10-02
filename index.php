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
    //Display home Page
    '' => [
        'controller'=> 'HomePageController',
        'method' => 'homePage',
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
        'method' => 'getBlockIp'
    ],
    'facebook-login' =>[
        'controller' => 'Logincontroller',
        'method' => 'loginUsingFacebook',
    ],
    'add-membership' =>[
        'controller' => 'UserMembershipController',
        'method' => 'addMember',
    ],
    'subscribe-3-months' => [
        'controller' => 'UserMembershipController',
        'method' => 'subscribe3Months',
    ],
    'subscribe-6-months' => [
        'controller' => 'UserMembershipController',
        'method' => 'subscribe6Months',
    ],
    'subscribe-12-months' => [
        'controller' => 'UserMembershipController',
        'method' => 'subscribe12Months',
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
    
];

$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);//Removal of the string 'parkNational' from the link
$urlArray = explode('?', $url);

var_dump($urlArray);
if(isset($routes[$urlArray[0]])){
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];
   // var_dump($methodName);
    require_once 'model/BlockIp.php';
    $blockIp = new BlockIp('block_ips');
    if($blockIp->isIpBlocked()){
        echo 'Your Ip is blocked';
        return;
    }
    require_once 'model/Log.php';
    $log = new Log('logs');
    $log->saveLog($url);
    require_once 'controllers/' . $className . '.php';

    $object = new $className; 
   // var_dump($object);

    $object->{$methodName}();
    
}else{
    var_dump("pas d'adresse");
}

//var_dump($url);