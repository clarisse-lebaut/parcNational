<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/AdminHome.php';

class AdminController extends Controller
{
    private $model;

    public function __construct()
    {
        // Initialize the model with the correct table
        $this->model = new AdminData('users');
    }

    // Fonction qui permet d'afficher la page d'accueil de l'admin
    public function home()
    {
        // Récupérer le nombre total d'utilisateurs
        $adminCount = $this->model->count_admin();
        $userCount = $this->model->count_users();
        
        // Récupérer le nombre d'éléments total dans chacune des colonnes
        $trailsCount = $this->model->count_trails();
        $campsitesCount = $this->model->count_campsites();
        $ressourcesCount = $this->model->count_ressources();
        $rapportsCount = $this->model->count_rapports();
        $shipsCount = $this->model->count_ships();
        $articlesCount = $this->model->count_articles();

        // Vérifier si les nombres ont été récupérés avec succès
        if ($userCount !== false && $trailsCount !== false) {
            // Passer les totaux à la vue admin_home
            $this->render('admin_home', [
                'total_users' => $userCount['total'] ?? 0,
                'total_admin' => $adminCount['total'] ?? 0,
                'total_trails' => $trailsCount['total'] ?? 0,
                'total_campsites' => $campsitesCount['total'] ?? 0,
                'total_ressources' => $ressourcesCount['total'] ?? 0,
                'total_rapports' => $rapportsCount['total'] ?? 0,
                'total_ships' => $shipCount['total'] ?? 3,
                'total_articles' => $articlesCount['total'] ?? 0
            ]);
        } else {
            echo "Erreur lors de la récupération des données.";
        }
    }
}
