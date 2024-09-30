<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminHome.php';

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
        
        // Récupérer le nombre d'élément total dans chacune des colonnes
        $trailsCount = $this->model->count_trails($this->bdd);
        $campsitesCount = $this->model->count_campsites($this->bdd);
        $ressourcesCount = $this->model->count_ressources($this->bdd);
        $rapportsCount = $this->model->count_rapports($this->bdd);

        // Récupérer les derniers éléments entrée dans la base de données
        $lastTrails = $this->model->last_trails($this->bdd);
        $lastCampsites = $this->model->last_campsites($this->bdd);
        $lastRessources = $this->model->last_ressources($this->bdd);
        $lastRapports = $this->model->last_rapports($this->bdd);


        // Vérifier si les nombres ont été récupérés avec succès
        if ($userCount !== false && $trailsCount !== false) {
            // Passer les totaux à la vue admin_home
            $this->render('admin_home', [
                // Assurez-vous que cela correspond à votre structure
                'total_users' => $userCount['total'], 
                
                // Nouveau total de sentiers
                'total_trails' => $trailsCount['total'], 
                // Nouveau total des ressources
                'total_campsites' => $campsitesCount['total'],
                // Nouveau total des ressources 
                'total_ressources' => $ressourcesCount['total'],
                // Nouveau total des ressources
                'total_rapports' => $rapportsCount['total'],

                // Nouveau total des ressources
                'last_trails' => $lastTrails,
                // Nouveau total des ressources
                'last_campsites' => $lastCampsites,
                // Nouveau total des ressources
                'last_ressources' => $lastRessources,
                // Nouveau total des ressources
                'last_rapports' => $lastRapports
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
