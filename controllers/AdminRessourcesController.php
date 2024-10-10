<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminRessources.php';

class AdminRessourcesController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new ManageRessources();
        $this->bdd = $this->getDatabaseConnection();
    }

    public function manageRessources() {
        // Vérifie si une requête POST a été effectuée pour supprimer une ressource
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ressource_id']) && !empty($_POST['ressource_id'])) {
            $ressource_id = intval($_POST['ressource_id']);
            
            $deleteSuccess = $this->model->delete($this->bdd, $ressource_id);

            if ($deleteSuccess) {
                // Rediriger vers la même page pour actualiser la liste des ressources
                $this->redirect('admin/manage_ressources');
                exit; // S'assurer que le script s'arrête ici
            } else {
                echo "Erreur : Impossible de supprimer cette ressource.";
            }
        }

        // Récupération du nombre total de ressources et des données associées
        $ressourcesCount = $this->model->count_ressources($this->bdd);
        $nameRessources = $this->model->name_ressources($this->bdd);
        // Récupération de toutes les ressources
        $ressources = $this->model->get_ressources($this->bdd);

        if ($ressourcesCount !== false && !empty($ressources)) {
            // Passe toutes les ressources en une seule fois à la vue
            $this->render('admin/manage_ressources', [
                'total_ressources' => $ressourcesCount['total'],
                'name_ressources' => $nameRessources,
                'ressources' => $ressources,  // Toutes les ressources sont passées à la vue
            ]);
        } else { 
            echo "Erreur lors de la récupération des données.";
        }
    }
    
    public function createRessources() {
        $isEdit = false;
        $ressourcesData = [];

        // Vérifier si un ressource_id est passé via POST (soumission du formulaire) ou GET (affichage pour édition)
        if (isset($_POST['ressource_id']) && !empty($_POST['ressource_id'])) {
            $isEdit = true;
            $ressource_id = intval($_POST['ressource_id']);  // Récupérer l'ID de la ressource à modifier via POST
        } elseif (isset($_GET['ressource_id']) && !empty($_GET['ressource_id'])) {
            $isEdit = true;
            $ressource_id = intval($_GET['ressource_id']);  // En cas de requête GET (affichage du formulaire pour édition)
        }

        // Si en mode édition, récupérer les informations de la ressource
        if ($isEdit) {
            // Récupérer la ressource par ID
            $resource = $this->model->get_ressources_by_id($this->bdd, $ressource_id);

            // Vérifier si la ressource a été trouvée
            if ($resource) {
                // Pré-remplir les champs du formulaire avec les données récupérées
                $ressourcesData = [
                    'ressource_id' => $resource['ressource_id'] ?? '', // Utiliser ?? pour éviter des erreurs
                    'name' => $resource['name'] ?? '',  // Assurer que la clé existe
                    'type' => $resource['type'] ?? '',
                    'location' => $resource['location'] ?? '',
                    'floraison' => $resource['floraison'] ?? '',
                    'description' => $resource['description'] ?? '',
                    'level' => $resource['level'] ?? '',
                    'precaution' => $resource['precaution'] ?? '',
                    'image' => $resource['image'] ?? '' // Si vous avez une colonne pour l'image
                ];
            } else {
                echo "Erreur : Ressource non trouvée.";
                return; // Sortie si la ressource n'est pas trouvée
            }
        }

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $type = $_POST['type'] ?? '';
            $location = $_POST['location'] ?? '';
            $floraison = $_POST['floraison'] ?? '';
            $description = $_POST['description'] ?? '';
            $level = $_POST['level'] ?? '';
            $precaution = $_POST['precaution'] ?? '';
            $errors = []; 

            // Gérer l'image si elle est soumise
            $image = null;  // Initialise la variable image à null
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['image']['tmp_name'];
                $imageName = basename($_FILES['image']['name']);
                $uploadDir = 'uploads/';  // Dossier où vous voulez enregistrer les images
                $imagePath = $uploadDir . $imageName;

                // Vérifiez si le dossier d'upload existe, sinon le créer
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Déplacer l'image vers le dossier d'upload
                if (move_uploaded_file($imageTmpPath, $imagePath)) {
                    $image = $imagePath;  // Si le déplacement est réussi, on stocke le chemin de l'image
                } else {
                    $errors[] = "Erreur lors de l'upload de l'image.";
                }
            }

            // Validation des autres données
            if (empty($name)) {
                $errors[] = 'Le nom de la ressource est requis.';
            }
            if (empty($type)) {
                $errors[] = 'Le type de la ressource est requis.';
            }
            if (empty($location)) {
                $errors[] = 'L\'emplacement est requis.';
            }
            if (empty($floraison)) {
                $errors[] = 'La période de floraison est requise.';
            }
            if (empty($description)) {
                $errors[] = 'La description de la ressource est requise.';
            }
            if (empty($level)) {
                $errors[] = 'Le niveau de la ressource est requis.';
            }
            if (empty($precaution)) {
                $errors[] = 'Les précautions à prendre sont requises.';
            }

            // Si des erreurs existent, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            } else {
                // Mise à jour ou création de la ressource
                if ($isEdit) {
                    // Mise à jour de la ressource dans la base de données
                    $updateSuccess = $this->model->update_ressources(
                        $this->bdd,
                        $ressource_id,
                        $name,
                        $type,
                        $location,
                        $floraison,
                        $description,
                        $level,
                        $precaution,
                        $image // Ajout de l'image ici
                    );

                    if ($updateSuccess) {
                        $this->redirect('admin/manage_ressources');
                        exit;
                    } else {
                        echo 'Erreur lors de la mise à jour de la ressource.';
                    }
                } else {
                    // Création d'une nouvelle ressource
                    if ($this->model->create_ressource(
                        $this->bdd,
                        $name,
                        $type,
                        $location,
                        $floraison,
                        $description,
                        $level,
                        $precaution,
                        $image)) {
                        $this->redirect('admin/manage_ressources');
                        exit;
                    } else {
                        echo 'Erreur lors de la création de la ressource.';
                    }
                }
            }
        }

        // Rendre la vue avec les données de la ressource (pour l'édition)
        $this->render('admin/create_ressources', ['ressourceData' => $ressourcesData, 'isEdit' => $isEdit]);
    }

    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}