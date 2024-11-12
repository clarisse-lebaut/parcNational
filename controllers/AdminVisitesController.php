<?php

require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/Visites.php';

class AdminVisitesController extends Controller
{
    public $visitesModel;

    public function __construct() {
        $this->visitesModel = new Visites();
    }

    public function manageVisites ()
    {
        $visites = $this->visitesModel->get_visite();
        // Rendre la vue 'manage_visites' avec les données des visites
        $this->render('manage_visites', ['visites' => $visites]);
    }
}
