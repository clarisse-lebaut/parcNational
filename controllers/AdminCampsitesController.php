<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminCampsites.php';

class AdminCampsitesController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageCampsites();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageCampsites() {
        $campsitesCount = $this->model->count_campsites($this->bdd);
        $nameCampsite = $this->model->name_campsites($this->bdd);
        // Récupération de tous les campings
        $campsites = $this->model->get_campsites($this->bdd);

        if ($campsitesCount !== false && !empty($campsites)) {
            // Passe tous les sentiers en une seule fois à la vue
            $this->render('manage_campsites', [
                'total_campsites' => $campsitesCount['total'],
                'name_campsites' => $nameCampsite,
                'campsites' => $campsites,  // Tous les sentiers sont passés à la vue
            ]);
        } else { 
            echo "Erreur lors de la récupération des données.";
        }
    }

    public function createCampsites(){
        $this->render('create_campsites');
    }

    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}