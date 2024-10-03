<?php
require_once __DIR__ . '/../models/ressourceModel.php';
require_once __DIR__ . '/../controllers/Controller.php';

class RessourceController extends Controller {

    private $ressourceModel;

    public function __construct() {
        $this->ressourceModel = new RessourceModel();
    }

    public function getAllRessources() {
        return $this->ressourceModel->getAllRessources(); // retourne directement le résultat
    }
    
    // 2. Récupérer une ressource par ID
    public function getRessourceById($ressource_id) {
        $ressource = $this->ressourceModel->getRessourceById($ressource_id);
        if ($ressource) {
            $this->render('ressourceDetails', ['ressource' => $ressource]);
        } else {
            return null;
        }
    }

    // 3. Créer une nouvelle ressource naturelle
    public function createRessource($name, $type, $location, $floraison, $description, $level, $precautions, $image) {
        if ($this->ressourceModel->createRessource($name, $type, $location, $floraison, $description, $level, $precautions, $image)) {
            return "La ressource naturelle a été créée avec succès.";
        } else {
            return "Erreur lors de la création de la ressource naturelle.";
        }
    }

    // 4. Mettre à jour une ressource naturelle
    public function updateRessource($ressource_id, $name, $type, $location, $floraison, $description, $level, $precautions, $image) {
        if ($this->ressourceModel->updateRessource($ressource_id, $name, $type, $location, $floraison, $description, $level, $precautions, $image)) {
            return "La ressource naturelle a été mise à jour avec succès.";
        } else {
            return "Erreur lors de la mise à jour de la ressource naturelle.";
        }
    }

    // 5. Supprimer une ressource naturelle
    public function deleteRessource($ressource_id) {
        if ($this->ressourceModel->deleteRessource($ressource_id)) {
            return "La ressource naturelle a été supprimée avec succès.";
        } else {
            return "Erreur lors de la suppression de la ressource naturelle.";
        }
    }
}
