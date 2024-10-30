<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/News.php';

class NewsController extends Controller
{
    private $newsModel;

    public function __construct()
    {
        $this->newsModel = new News('news');
    }

    public function get_all_news()
    {
        return $this->newsModel->get_news(); // Vous aurez déjà cette méthode pour récupérer tous les articles
    }

    public function details_news($id)
    {
        // Récupérer l'article spécifique en utilisant l'ID
        $news = $this->newsModel->get_news_by_id($id);
        
        // Récupérer tous les articles pour l'afficher dans la barre latérale
        $allNews = $this->get_all_news();

        // Vérifiez si l'article existe
        if ($news) {
            // Afficher la vue 'details_news' avec les données récupérées
            $this->render('details_news', [
                'news' => $news,
                'allNews' => $allNews // Passer tous les articles à la vue
            ]);
        } else {
            // Gérer le cas où l'article n'existe pas
            echo "Article non trouvé.";
        }
    }

}
