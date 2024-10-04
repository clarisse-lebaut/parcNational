<?php
require_once 'Controller.php';

class CoveController extends Controller {
    private $coveModel;

    public function __construct($coveModel) {
        $this->coveModel = $coveModel;
    }

    // Récupérer toutes les calanques
    public function getAllCoves() {
        return $this->coveModel->getAllCoves();
    }

    // Créer une calanque
    public function createCove($name, $description, $location, $image) {
        $this->coveModel->createCove($name, $description, $location, $image);
        $this->redirect('coves');  
    }

    // Modifier une calanque
    public function updateCove($id, $name, $description, $location, $image) {
        $this->coveModel->updateCove($id, $name, $description, $location, $image);
        $this->redirect('coves');  
    }

    // Supprimer une calanque
    public function deleteCove($id) {
        $this->coveModel->deleteCove($id);
        $this->redirect('coves');  
    }
}
