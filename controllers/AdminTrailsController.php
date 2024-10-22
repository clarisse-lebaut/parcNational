<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/AdminTrails.php';

class AdminTrailsController extends Controller
{
    private $model;

    public function __construct()
    {
        // Initialisation du modèle
        $this->model = new ManageTrails('trails'); // Spécifiez le nom de la table
    }

    public function manageTrails()
    {
        // Vérification de la suppression d'un sentier via POST
        if ($_POST && isset($_POST['trail_id']) && !empty($_POST['trail_id'])) {
            $trail_id = intval($_POST['trail_id']);
            $deleteSuccess = $this->model->delete($trail_id);

            if ($deleteSuccess) {
                $this->redirect('manage_trails');
                exit;
            } else {
                echo "Erreur : Impossible de supprimer ce sentier.";
            }
        }

        // Récupération des sentiers
        $trails = $this->model->get_trails(); // Récupération des sentiers
        $trailsCount = $this->model->count_trails(); // Compte des sentiers

        // Vérification des résultats
        if ($trailsCount !== false && !empty($trails)) {
            $nameTrail = $this->model->name_trails(); // Récupération du nom d'un sentier

            // Passage des sentiers à la vue
            $this->render('manage_trails', [
                'total_trails' => $trailsCount['total'],
                'name_trail' => $nameTrail,
                'trails' => $trails
            ]);
        } else {
            echo "Erreur lors de la récupération des sentiers.";
        }
    }

    public function createTrails()
    {
        $isEdit = false;
        $trailsData = [];

        // Vérification de l'ID du sentier pour édition
        if (isset($_POST['trail_id']) && !empty($_POST['trail_id'])) {
            $isEdit = true;
            $trail_id = intval($_POST['trail_id']);
        } elseif (isset($_GET['trail_id']) && !empty($_GET['trail_id'])) {
            $isEdit = true;
            $trail_id = intval($_GET['trail_id']);
        }

        // Récupération des informations du sentier pour édition
        if ($isEdit) {
            $trail = $this->model->get_trails_by_id($trail_id);
            if ($trail) {
                $trailsData = $trail;
            } else {
                echo "Erreur : Sentier non trouvé.";
                return;
            }
        }

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $length_km = floatval($_POST['length_km'] ?? '');
            $time = trim($_POST['time'] ?? '');
            $difficulty = trim($_POST['difficulty'] ?? '');
            $status = trim($_POST['status'] ?? '');
            $infos = trim($_POST['infos'] ?? '');
            $acces = trim($_POST['acces'] ?? '');
            $errors = [];

            // Validation des données
            if (empty($name)) {
                $errors[] = 'Le nom du sentier est requis.';
            }
            if (empty($description)) {
                $errors[] = 'La description du sentier est requise.';
            }
            if ($length_km <= 0) {
                $errors[] = 'La longueur doit être supérieure à 0.';
            }
            if (empty($time)) {
                $errors[] = 'La durée est requise.';
            }

            // Gestion de l'upload d'image (facultatif)
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/'; // Dossier où stocker les images
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = basename($_FILES['image']['name']);
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                // Vérification du type de fichier
                if (in_array($fileExtension, $allowedExtensions)) {
                    // Déplacer le fichier dans le dossier de destination
                    $newFileName = uniqid() . '.' . $fileExtension;
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $imagePath = '/uploads/' . $newFileName; // Stocker le chemin relatif
                    } else {
                        $errors[] = "Erreur lors du téléchargement de l'image.";
                    }
                } else {
                    $errors[] = "Type de fichier non valide. Les types acceptés sont : jpg, jpeg, png, gif.";
                }
            }

            // Si aucune erreur, procéder à l'insertion ou la mise à jour
            if (empty($errors)) {
                if ($isEdit) {
                    // Mise à jour du sentier
                    $updateSuccess = $this->model->update_trails(
                        $trail_id,
                        $name,
                        $difficulty,
                        $length_km,
                        $time,
                        $description,
                        $status,
                        $imagePath,
                        $infos,
                        $acces
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
                        $name,
                        $difficulty,
                        $length_km,
                        $time,
                        $description,
                        $status,
                        $imagePath,
                        $infos,
                        $acces
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
}
