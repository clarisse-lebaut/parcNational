<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/Controller.php';  

class CampsiteController {

    private $campsiteModel;

    public function __construct(CampsiteModel $campsiteModel) {
        $this->campsiteModel = $campsiteModel; 
    }

    // 1. Récupérer tous les campings
    public function getAllCampsites() {
        return $this->campsiteModel->getAllCampsites();
    }
    
    // 2. Récupérer un camping par ID
    public function getCampsiteById($campsite_id) {
        $campsite = $this->campsiteModel->getCampsiteById($campsite_id);
        if ($campsite) {
            $this->render('campsiteDetails', ['campsite' => $campsite]);
        } else {
            return null;
        }
    }

    // 3. Créer un nouveau camping
    public function createCampsite($name, $description, $address, $city, $zipcode, $image, $status) {
        if ($this->campsiteModel->createCampsite($name, $description, $address, $city, $zipcode, $image, $status)) {
            return "Le camping a été créé avec succès.";
        } else {
            return "Erreur lors de la création du camping.";
        }
    }

    // 4. Mettre à jour un camping
    public function updateCampsite($campsite_id, $name, $description, $address, $city, $zipcode, $image, $status) {
        if ($this->campsiteModel->updateCampsite($campsite_id, $name, $description, $address, $city, $zipcode, $image, $status)) {
            return "Le camping a été mis à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour du camping.";
        }
    }

    // 5. Supprimer un camping
    public function deleteCampsite($campsite_id) {
        if ($this->campsiteModel->deleteCampsite($campsite_id)) {
            return "Le camping a été supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression du camping.";
        }
    }
}