<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../model/AdminReports.php';

class AdminReportsController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageReports();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageReports() {
        // Vérifie si une requête POST a été effectuée pour supprimer un rapport
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id']) && !empty($_POST['report_id'])) {
            $report_id = intval($_POST['report_id']);
            
            $deleteSuccess = $this->model->delete($this->bdd, $report_id);

            if ($deleteSuccess) {
                // Rediriger vers la même page pour actualiser la liste des rapports
                $this->redirect('manage_reports');
                exit; // S'assurer que le script s'arrête ici
            } else {
                echo "Erreur : Impossible de supprimer ce rapport.";
            }
        }

        // Récupération du nombre total de rapports et des données associées
        $reportsCount = $this->model->count_reports($this->bdd);
        $namereports = $this->model->name_reports($this->bdd);
        // Récupération de tous les rapports
        $reports = $this->model->get_reports($this->bdd);

        if ($reportsCount !== false && !empty($reports)) {
            // Passe tous les rapports en une seule fois à la vue
            $this->render('manage_reports', [
                'total_reports' => $reportsCount['total'],
                'name_report' => $namereports,
                'reports' => $reports,  // Tous les rapports sont passés à la vue
            ]);
        } else { 
            echo "Erreur lors de la récupération des données.";
        }
    }

    public function createReports() {
        $isEdit = false;
        $reportData = [];
        $ressources = $this->model->name_ressource($this->bdd); // Récupérer toutes les ressources

        // Vérifier si un report_id est passé via POST (soumission du formulaire) ou GET (affichage pour édition)
        if (isset($_POST['report_id']) && !empty($_POST['report_id'])) {
            $isEdit = true;
            $report_id = intval($_POST['report_id']);  // Récupérer l'ID du rapport à modifier via POST
        } elseif (isset($_GET['report_id']) && !empty($_GET['report_id'])) {
            $isEdit = true;
            $report_id = intval($_GET['report_id']);  // En cas de requête GET (affichage du formulaire pour édition)
        }

        // Si en mode édition, récupérer les informations du rapport
        if ($isEdit) {
            // Récupérer le rapport par ID
            $report = $this->model->get_reports_by_id($this->bdd, $report_id);

            // Vérifier si le rapport a été trouvé
            if ($report) {
                // Pré-remplir les champs du formulaire avec les données récupérées
                $reportData = [
                    'report_id' => $report['report_id'] ?? '',
                    'name' => $report['name'] ?? '',
                    'description' => $report['description'] ?? '',
                    'ressource_id' => $report['resource_id'] ?? '' // Utiliser 'resource_id' ici pour correspondre à votre table
                ];
            } else {
                echo "Erreur : Rapport non trouvé.";
                return; // Sortie si le rapport n'est pas trouvé
            }
        }

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $ressource_id = $_POST['ressource_id'] ?? null;  // ID de la ressource associé au rapport
            $errors = [];

            // Validation des données
            if (empty($name)) {
                $errors[] = 'Le nom du rapport est requis.';
            }
            if (empty($description)) {
                $errors[] = 'La description du rapport est requise.';
            }
            if (empty($ressource_id)) {
                $errors[] = 'Une ressource doit être associée au rapport.';
            }

            // Si des erreurs existent, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            } else {
                // Mise à jour ou création du rapport
                if ($isEdit) {
                    // Mise à jour du rapport dans la base de données
                    $updateSuccess = $this->model->update_report(
                        $this->bdd,
                        $report_id,
                        $name,
                        $description,
                        $ressource_id  // Met à jour l'association avec la ressource
                    );

                    if ($updateSuccess) {
                        $this->redirect('manage_reports');
                        exit;
                    } else {
                        echo 'Erreur lors de la mise à jour du rapport.';
                    }
                } else {
                    // Création d'un nouveau rapport
                    if ($this->model->create_report(
                        $this->bdd,
                        $name,
                        $description,
                        $ressource_id)) {  // Associe la ressource lors de la création
                        $this->redirect('manage_reports');
                        exit;
                    } else {
                        echo 'Erreur lors de la création du rapport.';
                    }
                }
            }
        }

        // Rendre la vue avec les données du rapport (pour l'édition) et les ressources
        $this->render('create_reports', [
            'reportData' => $reportData,
            'isEdit' => $isEdit,
            'ressources' => $ressources // Passer les ressources à la vue
        ]);
    }


    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}