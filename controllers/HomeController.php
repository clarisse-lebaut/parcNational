<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/News.php';

class HomeController extends Controller
{
    private $newsModel;

    // Constructeur pour initialiser le modèle
    public function __construct($table)
    {
        parent::__construct(); // Appel au constructeur de la classe parente
        $this->newsModel = new News($table);
    }

    // Méthode pour afficher toutes les news dans la page d'accueil
    public function news()
    {
        // Enregistrer la visite pour la page d'accueil uniquement
        $this->enregistrerVisite('accueil');

        // Récupérer toutes les actualités
        $news = $this->newsModel->get_news();

        // Afficher la vue 'home' avec les données récupérées
        $this->render('home', ['news' => $news]);
    }

    // Méthode pour afficher les détails d'une news par ID
    public function newsDetail($id)
    {
        // Récupérer l'article par son ID en utilisant le modèle
        $article = $this->newsModel->get_news_by_id($id);

        if ($article) {
            // Passer l'article récupéré à la vue
            $this->render('details_news', ['article' => $article]);
        } else {
            // Gérer le cas où l'article n'existe pas
            echo "Article non trouvé.";
        }
    }
}
