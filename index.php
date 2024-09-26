<?php
echo getcwd();
echo "<br>";

include_once './config/config_routes.php';

$page = $_GET['p']; // Pas de valeur par défa

function loadPage($page): void
{
    switch ($page) {
        case 'home':            
            include_once CONTROLLER . 'HomeController.php';
            break;
            
            default:
            echo "error 404";
            break;
        }
    }
    
// Vérifiez la valeur de $page
echo "Page demandée : " . htmlspecialchars($page);
echo "<br>";

loadPage($page);