<?php
// session_start();

$routes = [
    '' => [
        'controller' => 'HomeController', 
        'method' => 'home',
    ],
    '' => [
        'controller' => 'HomeController', 
        'method' => 'news',
    ]
];

//* Removal of the string 'parkNational' from the link
$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);
$urlArray = explode('?', $url);
var_dump($urlArray);

if(isset($routes[$urlArray[0]])){
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];
    require_once 'controllers/' . $className . '.php';
    $object = new $className; 
    $object->{$methodName}();
}else{
    var_dump("pas d'adresse");
}

?>