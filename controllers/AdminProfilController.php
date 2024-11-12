<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/AdminUsers.php';

class AdminProfilController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Users('users'); // Utiliser le modèle Users
    }

    /**
     * Méthode pour récupérer et modifier les informations de l'administrateur connecté
     */
    public function editAdminProfile()
    {
        $adminData = [];
        $user_id = $_SESSION['user_id'] ?? null; // Récupère l'ID de l'administrateur connecté

        if ($user_id) {
            // Récupérer les informations de l'administrateur connecté
            $admin = $this->model->get_admin($user_id);

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
                return;
            }
        } else {
            echo "Erreur : ID de l'administrateur non trouvé dans la session.";
            return;
        }

        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastname = $_POST['lastname'] ?? '';
            $firstname = $_POST['firstname'] ?? '';
            $mail = $_POST['mail'] ?? '';
            $password = $_POST['password'] ?? ''; // Le mot de passe peut être vide si inchangé
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

            // Si des erreurs existent, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>$error</p>"; // Affiche chaque erreur
                }
            } else {
                // Mise à jour de l'administrateur dans la base de données
                $updateSuccess = $this->model->update_admin(
                    $user_id,
                    $lastname,
                    $firstname,
                    $mail,
                    $phone,
                    $address,
                    $city,
                    $zipcode,
                    !empty($password) ? $password : null // Passe le mot de passe uniquement s'il est fourni
                );

                if ($updateSuccess) {
                    echo 'Profil administrateur modifié avec succès !';
                    $this->redirect('admin_profil'); // Redirection vers la page de profil
                    exit;
                } else {
                    echo 'Erreur lors de la mise à jour du profil de l\'administrateur.';
                }
            }
        }

        // Affiche la vue du formulaire de modification avec les données de l'administrateur
        $this->render('admin_profil', ['adminData' => $adminData]);
    }
}
