<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminRessources.php';

class AdminRessourcesController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageRessources();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageRessources() {
        $ressourcesCount = $this->model->count_ressources($this->bdd);
        $nameRessources = $this->model->name_ressources($this->bdd);
        // Récupération de tous les sentiers
        $ressources = $this->model->get_ressources($this->bdd);

        if ($ressourcesCount !== false && !empty($ressources)) {
            // Passe tous les sentiers en une seule fois à la vue
            $this->render('manage_ressources', [
                'total_ressources' => $ressourcesCount['total'],
                'name_ressources' => $nameRessources,
                'ressources' => $ressources,  // Tous les sentiers sont passés à la vue
            ]);
        } else { 
            echo "Erreur lors de la récupération des données.";
        }
    }

    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}