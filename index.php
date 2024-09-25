<!-- <?php
// Tableau de routes
$routes = [
    'Home' => [
        'controller' => 'HomeController',
        'method' => 'Home',
    ]
];

//$routes['login'];
//Removal of the string 'parkNational' from the link
$url = str_replace("/parcNational/", '', $_SERVER['REQUEST_URI']);
$urlArray = explode('?', $url);

//? var_dump($urlArray);

if(isset($routes[$urlArray[0]])){
    $className = $routes[$urlArray[0]]['controller'];
    $methodName = $routes[$urlArray[0]]['method'];

    //? var_dump($methodName);
    require_once 'controller/' . $className . '.php';

    $object = new $className; 
    $object->{$methodName}();
    //? var_dump($object);
    
}else{
    echo 'Error 404 : Page introuvable';
    //? var_dump("pas d'adresse");
}

//? var_dump($url);
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="./view/Home.php">Voir la page d'accueil</a>
</body>
</html>