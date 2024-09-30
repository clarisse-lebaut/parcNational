<?php
$routes = [
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
    ]     
];

//* Removal of the string 'parkNational' from the link
$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);
$urlArray = explode('?', $url);
//? var_dump($urlArray);

if(isset($routes[$urlArray[0]])){
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];
    require_once 'controllers/' . $className . '.php';
    $object = new $className; 
    $object->{$methodName}();
}else{
    echo "error 404";
    //? var_dump("pas d'adresse");
}

?>