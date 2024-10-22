<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/CoveModel.php';  

class CoveController extends Controller {
    private $coveModel;

    public function __construct() {
        $this->coveModel = new CoveModel();  
    }

    // Récupérer toutes les calanques et les afficher dans la vue
    public function getAllCoves() {
        $calanques = $this->coveModel->getAllCoves();
        $this->render('coves', ['calanques' => $calanques]);  // Affiche les calanques dans la vue 'coves'
    }

    // Créer une nouvelle calanque
    public function createCove($name, $description, $location, $image) {
        $this->coveModel->createCove($name, $description, $location, $image);
        $this->redirect('coves');  // Redirige vers la liste des calanques après la création
    }

    // Modifier une calanque existante
    public function updateCove($id, $name, $description, $location, $image) {
        $this->coveModel->updateCove($id, $name, $description, $location, $image);
        $this->redirect('coves');  // Redirige après modification
    }

    // Supprimer une calanque existante
    public function deleteCove($id) {
        $this->coveModel->deleteCove($id);
        $this->redirect('coves');  // Redirige après suppression
    }
}
