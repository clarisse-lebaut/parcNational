<?php
//* permte de faire apparaitre le chemin du dossier dans lequel je suis actuellement.
echo getcwd(); 

// Inclure les fichiers de configuration dans chaque controllers
include 'config/connectBDD.php';
include 'config/config_routes.php';
// Inclure le modèle necessaire pour le bon focntionnement
include 'model/News.php';

class HomeController {
    //* Propriété pour les instances
    private $newsModel;
    private $bdd;

    //* Constructeur pour initialiser le modèle et la connexion
    public function __construct(){
        $connectBDD = new ConnectBDD();
        $this->bdd = $connectBDD->bdd;
        $this->newsModel = new News();
    }
    
    //* Méthode pour afficher les actualitées
    public function display_all_news(){
        $news = $this->newsModel->get_news($this->bdd);
        include_once VIEW . 'home.php';
    }
}

// Utilisation du contrôleur pour afficher les news
$controller = new HomeController();
$controller->display_all_news();
?>
