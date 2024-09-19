<?php

$routes = [
    //pokazuje strone logowania
    'login' => [
        'controller' => 'LoginController', 
        'method' => 'login',
    ],
    //pokazuje strone rejestracji
    'register' => [
        'controller' => 'RegisterController',
        'method' => 'registerView',
    ],
    //pokazuje strone glowna
    '' => [
        'controller'=> 'HomePageController',
        'method' => 'homePage',
    ],
    //zapisuje formularz rejestracji
    'registerForm' => [
        'controller' => 'RegisterController',
        'method' => 'registerSaveForm',
    ]
];

//$routes['login'];
$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);// Suppression du string ' parkNational ' du lien
var_dump($url);
if(isset($routes[$url])){
    $className = $routes[$url]['controller'];
    $methodName = $routes[$url]['method'];
   // var_dump($methodName);
    require_once 'controllers/' . $className . '.php';

    $object = new $className; 
   // var_dump($object);

    $object->{$methodName}();
    
}else{
    var_dump("pas d'adresse");
}

//var_dump($url);