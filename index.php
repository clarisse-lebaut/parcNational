<?php
session_start();

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
    'registerForm' => [
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