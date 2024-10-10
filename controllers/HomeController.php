<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/News.php';

class HomeController extends Controller
{

    private $newsModel;
    private $bdd;

    // Constructeur pour initialiser le modèle et la base de données
    public function __construct()
    {
        // Initialisation de l'objet News
        $this->newsModel = new News();

        // Initialisation de la connexion à la base de données (supposons que tu aies une instance $bdd quelque part)
        // Exemple : $this->bdd = new PDO(...); ou récupérer la connexion via un service
        $this->bdd = $this->getDatabaseConnection(); // Méthode à créer si elle n'existe pas
    }

    // Méthode pour afficher toutes les news dans la page home
    public function news()
    {
        // Récupérer les news en utilisant le modèle
        $news = $this->newsModel->get_news($this->bdd);
        // Afficher la vue 'news' avec les données récupérées
        $this->render('home', ['news' => $news]);
    }

    public function getDatabaseConnection()
    {
        // Instancier la classe ConnectBDD
        $connectBDD = new ConnectBDD();
        // Retourner l'objet PDO
        return $connectBDD->bdd;
    }

}
