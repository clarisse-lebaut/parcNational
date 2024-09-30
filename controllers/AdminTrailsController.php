<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminTrails.php';

class AdminTrailsController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageTrails();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageTrails() {
        $trailsCount = $this->model->count_trails($this->bdd);
        $nameTrail = $this->model->name_trails($this->bdd);
        // Récupération de tous les sentiers
        $trails = $this->model->get_trails($this->bdd);

        if ($trailsCount !== false && !empty($trails)) {
            // Passe tous les sentiers en une seule fois à la vue
            $this->render('manage_trails', [
                'total_trails' => $trailsCount['total'],
                'name_trail' => $nameTrail,
                'trails' => $trails,  // Tous les sentiers sont passés à la vue
            ]);
        } else { 
            echo "Erreur lors de la récupération des données.";
        }
    }

    public function createTrails(){
        $this->render('create_trails');
    }

    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}