<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/Admin_home.php';

class AdminController extends Controller {

    private $model;
    private $bdd;

    public function __construct(){
        $this->model = new AdminData();
        $this->bdd = $this->getDatabaseConnection();
    }

    // Fonction qui permet d'afficher la page d'accueil de l'admin
    public function home(){
        // Récupérer le nombre total d'utilisateurs
        $userCount = $this->model->count_users($this->bdd);
        
        // Récupérer le nombre total de sentiers
        $trailsCount = $this->model->count_trails($this->bdd);

        // Vérifier si les nombres ont été récupérés avec succès
        if ($userCount !== false && $trailsCount !== false) {
            // Passer les totaux à la vue admin_home
            $this->render('admin_home', [
                'total_users' => $userCount['total'], // Assurez-vous que cela correspond à votre structure
                'total_trails' => $trailsCount['total'] // Nouveau total de sentiers
            ]);
        } else {
            echo "Erreur lors de la récupération des données.";
        }
    }

    // Fonction pour établir la connexion à la base de données
    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}
