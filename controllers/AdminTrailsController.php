<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../model/AdminTrails.php';

class AdminTrailsController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageTrails();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageTrails() {
        // Vérifie si une requête POST a été effectuée pour supprimer un sentier
        if ($_POST && isset($_POST['trail_id']) && !empty($_POST['trail_id'])) {
            $trail_id = intval($_POST['trail_id']);
            
            // Supprime le sentier en utilisant le modèle
            $deleteSuccess = $this->model->delete($this->bdd, $trail_id);

            if ($deleteSuccess) {
                // Redirige vers la même page pour actualiser la liste des sentiers
                $this->redirect('manage_trails');
                exit; // Arrête l'exécution après la redirection
            } else {
                echo "Erreur : Impossible de supprimer ce sentier.";
            }
        }

        // Récupère et affiche les sentiers si aucune suppression n'est demandée
        $trails = $this->model->get_trails($this->bdd); // Récupère les sentiers
        $trailsCount = $this->model->count_trails($this->bdd); // Compte le nombre de sentiers

        // Vérifie si les sentiers et le comptage sont récupérés correctement
        if ($trailsCount !== false && !empty($trails)) {
            $nameTrail = $this->model->name_trails($this->bdd); // Optionnel : Récupère le nom d'un sentier

            // Passe les sentiers à la vue
            $this->render('manage_trails', [
                'total_trails' => $trailsCount['total'],
                'name_trail' => $nameTrail,
                'trails' => $trails
            ]);
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors de la récupération des sentiers.";
        }
    }

    public function createTrails() {
        $isEdit = false;
        $trailsData = [];

        // Vérifier si un trail_id est passé via POST (soumission du formulaire) ou GET (affichage pour édition)
        if (isset($_POST['trail_id']) && !empty($_POST['trail_id'])) {
            $isEdit = true;
            $trail_id = intval($_POST['trail_id']);  // Récupérer l'ID du sentier à modifier via POST
        } elseif (isset($_GET['trail_id']) && !empty($_GET['trail_id'])) {
            $isEdit = true;
            $trail_id = intval($_GET['trail_id']);  // En cas de requête GET (affichage du formulaire pour édition)
        }

        // Si en mode édition, récupérer les informations du sentier
        if ($isEdit) {
            // Récupérer le sentier par ID
            $trail = $this->model->get_trails_by_id($this->bdd, $trail_id);

            if ($trail) {
                // Pré-remplir les champs avec les données récupérées
                $trailsData = [
                    'trail_id' => $trail['trail_id'] ?? '',
                    'name' => $trail['name'] ?? '',
                    'description' => $trail['description'] ?? '',
                    'location' => $trail['location'] ?? '',
                    'distance' => $trail['distance'] ?? 0,
                    'difficulty' => $trail['difficulty'] ?? '',
                    'status' => $trail['status'] ?? '',
                    // Enlevez longitude et latitude si non nécessaire ici
                ];
            } else {
                echo "Erreur : Sentier non trouvé.";
                return;
            }
        }

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $distance = floatval($_POST['distance'] ?? 0);
            $difficulty = trim($_POST['difficulty'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $longitude = trim($_POST['longitude'] ?? '');
            $latitude = trim($_POST['latitude'] ?? '');
            $errors = [];

            // Validation des données
            if (empty($name)) {
                $errors[] = 'Le nom du sentier est requis.';
            }
            if (empty($description)) {
                $errors[] = 'La description du sentier est requise.';
            }
            if (empty($location)) {
                $errors[] = 'La localisation est requise.';
            }
            if ($distance <= 0) {
                $errors[] = 'La distance doit être supérieure à 0.';
            }
            if (!filter_var($longitude, FILTER_VALIDATE_FLOAT)) {
                $errors[] = 'La longitude est requise et doit être un nombre valide.';
            }
            if (!filter_var($latitude, FILTER_VALIDATE_FLOAT)) {
                $errors[] = 'La latitude est requise et doit être un nombre valide.';
            }

            // Si aucune erreur, procéder à l'insertion ou la mise à jour
            if (empty($errors)) {
                if ($isEdit) {
                    // Mise à jour du sentier
                    $updateSuccess = $this->model->update_trails(
                        $this->bdd,
                        $trail_id,
                        $name,
                        $description,
                        $distance,
                        $difficulty,
                        $status,
                        null,      // Image non traitée ici
                        null,      // Longitude non traitée ici
                        null       // Latitude non traitée ici
                    );

                    if ($updateSuccess) {
                        $this->redirect('manage_trails');
                        exit;
                    } else {
                        echo 'Erreur lors de la mise à jour du sentier.';
                    }
                } else {
                    // Création d'un nouveau sentier
                    if ($this->model->create_trails(
                        $this->bdd,
                        $name,
                        $description,
                        $location,
                        $distance,
                        $difficulty,
                        $status,
                        null      // Image non traitée ici
                    )) {
                        $this->redirect('manage_trails');
                        exit;
                    } else {
                        echo 'Erreur lors de la création du sentier.';
                    }
                }
            } else {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            }
        }

        // Rendre la vue pour créer ou modifier un sentier
        $this->render('create_trails', ['trailData' => $trailsData, 'isEdit' => $isEdit]);
    }

    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}
