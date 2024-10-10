<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminUsers.php';

class AdminAdminController extends Controller
{

    private $model;
    private $bdd;

    public function __construct()
    {
        $this->model = new Users(); // Utiliser le modèle Users
        $this->bdd = $this->getDatabaseConnection(); // Connexion à la base de données
    }

    //* Méthode pour afficher la vue des administrateurs
    public function manageAdmin()
    {
        // Vérifie si une requête POST a été effectuée pour supprimer un administrateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            $admin_id = intval($_POST['user_id']);

            $deleteSuccess = $this->model->delete($this->bdd, $admin_id);

            if ($deleteSuccess) {
                // Rediriger vers la même page pour actualiser la liste des administrateurs
                $this->redirect('admin/manage_admin');
                exit; // S'assurer que le script s'arrête ici
            } else {
                echo "Erreur : Impossible de supprimer cet administrateur.";
            }
        }

        // Si aucune suppression n'est demandée, on récupère et affiche les administrateurs
        $admin = $this->model->get_admin($this->bdd); // Récupère les administrateurs
        $countAdmin = $this->model->count_admin($this->bdd); // Compte le nombre d'administrateurs

        // Vérifie si les administrateurs et le comptage sont corrects
        if ($countAdmin !== false && !empty($admin)) {
            $this->render('admin/manage_admin', [
                'total_admin' => $countAdmin['total'],
                'admin' => $admin
            ]); // Passe les administrateurs à la vue
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors du chargement des administrateurs.";
        }
    }

    public function createAdmin()
    {
        $isEdit = false;
        $adminData = [];

        // Vérifiez si un user_id est passé, soit via POST (soumission du formulaire) ou via GET (affichage pour édition)
        if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            $isEdit = true;
            $user_id = intval($_POST['user_id']);  // On récupère l'ID de l'utilisateur à modifier via POST
        } elseif (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
            $isEdit = true;
            $user_id = intval($_GET['user_id']);  // En cas de requête GET (affichage du formulaire pour édition)
        }

        // Si en mode édition, récupérer les informations de l'administrateur
        if ($isEdit) {
            $admin = $this->model->get_admin($this->bdd, $user_id);  // Méthode pour récupérer un admin par ID

            if ($admin) {
                // Pré-remplir les champs du formulaire avec les données récupérées
                $adminData = [
                    'user_id' => $admin['user_id'],
                    'lastname' => $admin['lastname'],
                    'firstname' => $admin['firstname'],
                    'mail' => $admin['mail'],
                    'phone' => $admin['phone'],
                    'address' => $admin['address'],
                    'city' => $admin['city'],
                    'zipcode' => $admin['zipcode']
                ];
            } else {
                echo "Erreur : Administrateur non trouvé.";
                return; // Sortie si l'administrateur n'est pas trouvé
            }
        }

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastname = $_POST['lastname'] ?? '';
            $firstname = $_POST['firstname'] ?? '';
            $mail = $_POST['mail'] ?? '';
            $password = $_POST['password'] ?? ''; // Le mot de passe peut être vide lors de l'édition
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $city = $_POST['city'] ?? '';
            $zipcode = $_POST['zipcode'] ?? '';
            $errors = []; // Tableau d'erreurs

            // Validation des données
            if (empty($lastname)) {
                $errors[] = 'Le nom de famille est requis.';
            }
            if (empty($firstname)) {
                $errors[] = 'Le prénom est requis.';
            }
            if (empty($mail) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Un email valide est requis.';
            }
            if (empty($phone)) {
                $errors[] = 'Le numéro de téléphone est requis.';
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

            // Pour la création, le mot de passe est obligatoire et doit être d'une certaine longueur
            if (!$isEdit && (empty($password) || strlen($password) < 6)) {
                $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
            }

            // Si des erreurs existent, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>"; // Affiche chaque erreur
                }
            } else {
                // Mise à jour ou création de l'administrateur dans la base de données
                if ($isEdit) {
                    // Mise à jour de l'administrateur dans la base de données
                    $updateSuccess = $this->model->update_admin(
                        $this->bdd,
                        $user_id,
                        $lastname,
                        $firstname,
                        $mail,
                        $phone,
                        $address,
                        $city,
                        $zipcode,
                        !empty($password) ? $password : null // Passez le mot de passe uniquement s'il est fourni
                    );

                    if ($updateSuccess) {
                        echo 'Administrateur modifié avec succès !';
                        $this->redirect('admin/manage_admin');
                        exit;
                    } else {
                        echo 'Erreur lors de la mise à jour de l\'administrateur.';
                    }
                } else {
                    // Création d'un nouvel administrateur
                    if ($this->model->create_admin($this->bdd, $lastname, $firstname, $mail, password_hash($password, PASSWORD_BCRYPT), $phone, $address, $city, $zipcode, $registration_date)) {
                        echo 'Administrateur créé avec succès !';
                        $this->redirect('admin/manage_admin');
                        exit;
                    } else {
                        echo 'Erreur lors de la création de l\'administrateur.';
                    }
                }
            }
        }

        // Rendre la vue avec les données de l'administrateur (pour l'édition)
        $this->render('admin/create_admin', ['adminData' => $adminData, 'isEdit' => $isEdit]);
    }

    // Connexion à la base de données
    public function getDatabaseConnection()
    {
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}
