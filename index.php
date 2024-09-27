<?php
session_start();
session_regenerate_id(true);//Session Fixation(Security)

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
    ]
    
];

//$routes['login'];
$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);//Removal of the string 'parkNational' from the link
$urlArray = explode('?', $url);

var_dump($urlArray);
if(isset($routes[$urlArray[0]])){
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];
   // var_dump($methodName);
    require_once 'controllers/' . $className . '.php';

    $object = new $className; 
   // var_dump($object);

    $object->{$methodName}();
    
}else{
    var_dump("pas d'adresse");
}

//var_dump($url);