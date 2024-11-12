<?php

require_once __DIR__ . '/../models/Visites.php'; // Assure-toi que le chemin est correct

class Controller
{
    protected $visitesModel;

    public function __construct() {
        $this->visitesModel = new Visites(); // Initialisation du modèle Visites
    }

    public function render($view, $data = []) {
        // Rendre la vue et injecter les données
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }

    public function redirect($url) {
        header('Location: /parcNational/' . $url);
        exit;
    }

    protected function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
            $this->redirect('login');
            exit;
        }
    }

    // Nouvelle méthode pour enregistrer les visites
    protected function enregistrerVisite($page) {
        $this->visitesModel->incrementerCompteur($page); // Appel au modèle pour incrémenter le compteur
    }
}
