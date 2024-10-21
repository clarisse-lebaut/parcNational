<?php
require_once 'Controller.php';
require_once  __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/AdminCampsites.php';

class AdminCampsitesController extends Controller
{

    private $model;

    public function __construct()
    {
        $this->model = new ManageCampsites('campsites');
    }

    //* Méthode pour afficher la vue des administrateurs
    public function manageCampsites()
    {
        // Vérifie si une requête POST a été effectuée pour supprimer un administrateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campsite_id']) && !empty($_POST['campsite_id'])) {
            $campsite_id = intval($_POST['campsite_id']);

            $deleteSuccess = $this->model->delete($campsite_id);

            if ($deleteSuccess) {
                // Rediriger vers la même page pour actualiser la liste des campings
                $this->redirect('manage_campsites');
                exit; // S'assurer que le script s'arrête ici
            } else {
                echo "Erreur : Impossible de supprimer ce camping.";
            }
        }

        // Si aucune suppression n'est demandée, on récupère et affiche les campings
        $campsites = $this->model->get_campsites(); // Récupère les campings
        $countCampsites = $this->model->count_campsites(); // Compte le nombre de campings

        // Vérifie si les campings et le comptage sont corrects
        if ($countCampsites !== false && !empty($campsites)) {
            $this->render('manage_campsites', [
                'total_campsites' => $countCampsites['total'],
                'campsites' => $campsites
            ]); // Passe les campings à la vue
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors du chargement des campings.";
        }
    }

    public function createCampsites()
    {
        $isEdit = false;
        $campsitesData = [];

        // Vérifier si un campsite_id est passé via POST (soumission du formulaire) ou GET (affichage pour édition)
        if (isset($_POST['campsite_id']) && !empty($_POST['campsite_id'])) {
            $isEdit = true;
            $campsite_id = intval($_POST['campsite_id']);  // Récupérer l'ID du camping à modifier via POST
        } elseif (isset($_GET['campsite_id']) && !empty($_GET['campsite_id'])) {
            $isEdit = true;
            $campsite_id = intval($_GET['campsite_id']);  // En cas de requête GET (affichage du formulaire pour édition)
        }

        // Si en mode édition, récupérer les informations du camping
        if ($isEdit) {
            // Récupérer le camping par ID
            $campsite = $this->model->get_campsites_by_id($campsite_id);

            // Vérifier si le camping a été trouvé
            if ($campsite) {
                // Pré-remplir les champs du formulaire avec les données récupérées
                $campsitesData = [
                    'campsite_id' => $campsite['campsite_id'] ?? '', // Utiliser ?? pour éviter des erreurs
                    'name' => $campsite['name'] ?? '',  // Assurer que la clé existe
                    'description' => $campsite['description'] ?? '',
                    'address' => $campsite['address'] ?? '',
                    'city' => $campsite['city'] ?? '',
                    'zipcode' => $campsite['zipcode'] ?? '',
                    'status' => $campsite['status'] ?? '',
                    'max_capacity' => $campsite['max_capacity'] ?? 0 // Valeur par défaut
                ];
            } else {
                echo "Erreur : Camping non trouvé.";
                return; // Sortie si le camping n'est pas trouvé
            }
        }

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $zipcode = $_POST['zipcode'] ?? '';
            $max_capacity = $_POST['max_capacity'] ?? 0;
            $status = $_POST['status'] ?? '';
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
                $errors[] = 'Le nom du camping est requis.';
            }
            if (empty($description)) {
                $errors[] = 'La description du camping est requise.';
            }
            if (empty($address)) {
                $errors[] = 'L\'adresse est requise.';
            }
            if (empty($city)) {
                $errors[] = 'La ville est requise.';
            }
            if (empty($zipcode)) {
                $errors[] = 'Le code postal est requis.';
            }
            if ($max_capacity <= 0) {
                $errors[] = 'La capacité maximale doit être supérieure à 0.';
            }

            // Si des erreurs existent, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>";
                }
            } else {
                // Mise à jour ou création du camping
                if ($isEdit) {
                    // Mise à jour du camping dans la base de données
                    $updateSuccess = $this->model->update_campsites(
                        $campsite_id,
                        $name,
                        $description,
                        $address,
                        $city,
                        $zipcode,
                        $max_capacity,
                        $status,
                        $image // Ajout de l'image ici
                    );

                    if ($updateSuccess) {
                        $this->redirect('manage_campsites');
                        exit;
                    } else {
                        echo 'Erreur lors de la mise à jour du camping.';
                    }
                } else {
                    // Création d'un nouveau camping
                    if ($this->model->create_campsites($name, $description, $address, $city, $zipcode, $max_capacity, $status, $image)) {
                        $this->redirect('manage_campsites');
                        exit;
                    } else {
                        echo 'Erreur lors de la création du camping.';
                    }
                }
            }
        }

        // Rendre la vue avec les données du camping (pour l'édition)
        $this->render('create_campsites', ['campsiteData' => $campsitesData, 'isEdit' => $isEdit]);
    }
}
