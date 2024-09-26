<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

// J'utilise des variables SERVER dans des constantes pour avoir les liens absolus
$root = $_SERVER['DOCUMENT_ROOT'];
$host = $_SERVER['HTTP_HOST'];

define('HOST','http://' . $host . '/parcNational/');
define('ROOT', $root . '/parcNational/');

define('CONTROLLER', ROOT . 'controller/');
define('VIEW', ROOT . 'view/');
define('MODEL', ROOT . 'model/');

// On part de HOST et pas de ROOT pour assets car l'acces au css se fait via une URL et pas un Emplacement dans un dossier
define( 'ASSETS', HOST . 'assets/');