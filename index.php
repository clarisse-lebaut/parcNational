<?php
include_once './config/config_routes.php';

// Ici on va faire une sorte de router

//* On va faire des routes de ce type 
//http://localhost/MyBasics-API/fullstack-php-js-natif/index.php?p=home
//* Ensuite on fera une réécriture de ça dans le htaccess 
// pour avoir juste http://localhost/MyBasics-API/fullstack-php-js-natif/home

$page = isset($_GET['p']) ? $_GET['p'] : '';
function loadPage($page): void
{
    switch ($page) {
        case "";
        case 'home';            
            include_once CONTROLLER . 'HomeController.php';
            break;

        default:
            echo "error 404";
            break;
    }
}

loadPage($page);