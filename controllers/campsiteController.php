<?php
require_once __DIR__ . '/../models/CampsiteModel.php';

class CampsiteController {

    private $campsiteModel;

    public function __construct() {
        $this->campsiteModel = new CampsiteModel(); 
    }

    // 1. Récupérer tous les campings
    public function getAllCampsites() {
        $campsites = $this->campsiteModel->getAllCampsites();
        if ($campsites) {
            return $campsites;  // tableau de campings
        } else {
            return [];
        }
    }

    // 2. Récupérer un camping par ID
    public function getCampsiteById($campsite_id) {
        $campsite = $this->campsiteModel->getCampsiteById($campsite_id);
        if ($campsite) {
            return $campsite;  // 1 seul camping
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
