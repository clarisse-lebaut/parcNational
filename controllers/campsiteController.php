<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../models/ReservationModel.php';
require_once __DIR__ . '/../controllers/Controller.php';  

class CampsiteController extends Controller {

    private $campsiteModel;
    private $reservationModel;

    public function __construct() {
        parent::__construct();
        $this->campsiteModel = new CampsiteModel();
        $this->reservationModel = new ReservationModel(); 
    }

    // 1. Récupérer tous les campings
    public function getAllCampsites() {
        // Enregistrer la visite pour la page d'accueil uniquement
        $this->enregistrerVisite('campsites');
        
        $campsites = $this->campsiteModel->getAllCampsites();

        // Mise à jour de la disponibilité et statut
        foreach ($campsites as &$campsite) {
            $events = $this->getVacationEvents($campsite['campsite_id']);
            $campsite['isClosed'] = $this->isClosedToday($events);
            $campsite['availability'] = $this->checkAvailability($campsite['campsite_id']);
        }

        $this->render('campsite', ['campsites' => $campsites]);
    }            

    public function getCampsiteById($campsite_id) {
        $campsite = $this->campsiteModel->getCampsiteById($campsite_id);
        if ($campsite) { //MAJ du statut + rendu de la view
            $this->updateStatusBasedOnVacation($campsite_id, $campsite); 
            $this->render('campsiteDetails', ['campsite' => $campsite]); 
        } else {
            echo "Camping non trouvé.";
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

    // 6. Mise à jour du statut (en fonction des vacances)
    public function updateStatusBasedOnVacation($campsite_id, &$campsite) {
        $events = $this->getVacationEvents($campsite_id);
        $isClosed = $this->isClosedToday($events);
        $newStatus = $isClosed ? 'Fermé' : 'Ouvert';
        
        if ($campsite['status'] !== $newStatus) {
            $this->campsiteModel->updateStatus($campsite_id, $newStatus);
            $campsite['status'] = $newStatus;
        }
    }

    // 7. Obtenir les vacances d'un camping
    public function getVacationEvents($campsite_id) {
        $events = [];
    
        if ($campsite_id == 1) {
            $events[] = ['start' => '2024-03-25', 'end' => '2024-04-10'];
        } else if ($campsite_id == 2) {
            $events[] = ['start' => '2024-10-01', 'end' => '2025-04-30'];
        } else if ($campsite_id == 3) {
            $events[] = ['start' => '2024-03-29', 'end' => '2024-09-15'];
        } else if ($campsite_id == 4) {
            $events[] = ['start' => '2024-11-01', 'end' => '2025-04-20'];
        } else if ($campsite_id == 5) {
            $events[] = ['start' => '2024-05-15', 'end' => '2024-05-31'];
        }
    
        return $events;
    }

    // 8. Vérifier si aujourd'hui se trouve dans une période de fermeture
    public function isClosedToday($events) {
        $today = date('Y-m-d'); 
        foreach ($events as $event) {
            if ($today >= $event['start'] && $today <= $event['end']) {
                return true;
            }
        }
        return false;
    }

    // 9. Vérifier la disponibilité d'un camping
    public function checkAvailability($campsite_id) {
        $campsite = $this->campsiteModel->getCampsiteById($campsite_id);
        $currentReservations = $this->reservationModel->getCurrentReservations($campsite_id);

        if ($currentReservations >= $campsite['max_capacity']) {
            $this->campsiteModel->updateAvailability($campsite_id, 0); 
            return 'Camping complet';
        } else {
            $this->campsiteModel->updateAvailability($campsite_id, 1);
            return 'Disponible';
        }
    }
}
