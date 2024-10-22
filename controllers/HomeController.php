<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/News.php';

class HomeController extends Controller
{
    private $newsModel;

    // Constructeur pour initialiser le modèle
    public function __construct($table)
    {
        // Initialisation de l'objet News (hérite de Model, qui gère la connexion à la base de données)
        $this->newsModel = new News($table);
    }

    // Méthode pour afficher toutes les news dans la page home
    public function news()
    {
        // Récupérer les news en utilisant le modèle
        $news = $this->newsModel->get_news();
        // Afficher la vue 'news' avec les données récupérées
        $this->render('home', ['news' => $news]);
    }
}
?>