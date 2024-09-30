<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminReports.php';

class AdminReportsController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageReports();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageReports() {
        $reportsCount = $this->model->count_reports($this->bdd);
        $namereports = $this->model->name_reports($this->bdd);
        // Récupération de tous les sentiers
        $reports = $this->model->get_reports($this->bdd);

        if ($reportsCount !== false && !empty($reports)) {
            // Passe tous les sentiers en une seule fois à la vue
            $this->render('manage_reports', [
                'total_reports' => $reportsCount['total'],
                'name_report' => $namereports,
                'reports' => $reports,  // Tous les sentiers sont passés à la vue
            ]);
        } else { 
            echo "Erreur lors de la récupération des données.";
        }
    }

    public function createReports(){
        $this->render('create_reports');
    }

    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}