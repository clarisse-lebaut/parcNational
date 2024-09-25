<?php
// Inclure les fichiers nécessaires
include_once '../class/ConnectBDD.php';
include_once '../model/News.php';

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
        include '../view/Home.php';
    }
}

// Utilisation du contrôleur pour afficher les news
$controller = new HomeController();
$controller->display_all_news();
?>
