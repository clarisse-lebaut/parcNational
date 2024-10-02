<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/AdminUsers.php';

class AdminPersonController extends Controller {

    private $model;
    private $bdd;
    
    public function __construct(){
        $this->model = new Users(); // Utiliser le modèle Users
        $this->bdd = $this->getDatabaseConnection(); // Connexion à la base de données
    }

    // Méthode pour afficher la vue des utilisateurs
    public function manageUsers() {
        $users = $this->model->get_users($this->bdd); // Récupère tous les utilisateurs
        $countUser = $this->model->count_users($this->bdd); // Compte le nombre d'utilisateurs

        // Vérifie si les utilisateurs ont bien été récupérés et si le comptage est correct
        if ($countUser !== false && !empty($users)) {
            $this->render('manage_users', [
                'total_users' => $countUser['total'],
                'users' => $users
            ]); // Passe les utilisateurs à la vue
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors du chargement des utilisateurs.";
        }
    }

    // Méthode pour afficher la vue des administrateurs
    public function manageAdmin(){
        $admin = $this->model->get_admin($this->bdd); // Récupère les administrateurs
        $countAdmin = $this->model->count_admin($this->bdd); // Compte le nombre d'administrateurs

        // Vérifie si les administrateurs et le comptage sont corrects
        if ($countAdmin !== false && !empty($admin)) {
            $this->render('manage_admin', [
                'total_admin' => $countAdmin['total'],
                'admin' => $admin
            ]); // Passe les administrateurs à la vue
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors du chargement des administrateurs.";
        }
    }


    public function deleteUser() {
        if ($_POST) {
            if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                $user_id = intval($_POST['user_id']);
                
                // Suppression d'un utilisateur
                $deleteSuccess = $this->model->delete_user($this->bdd, $user_id);

                if ($deleteSuccess) {
                    $this->redirect('manage_users'); // Utilisation de la méthode redirect
                    exit;
                } else {
                    echo "Erreur : Impossible de supprimer cet utilisateur.";
                }
            } else {
                echo "Erreur : ID de l'utilisateur manquant.";
            }
        }
    }

    public function deleteAdmin() {
        if ($_POST) {
            if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
                $admin_id = intval($_POST['user_id']);
                
                // Suppression d'un administrateur
                $deleteSuccess = $this->model->delete_admin($this->bdd, $admin_id);

                if ($deleteSuccess) {
                    $this->redirect('manage_admin'); // Utilisation de la méthode redirect
                    exit;
                } else {
                    echo "Erreur : Impossible de supprimer cet administrateur.";
                }
            } else {
                echo "Erreur : ID de l'administrateur manquant.";
            }
        }
    }



    // Méthode pour afficher la vue de création d'un admin
    public function createAdmin(){
        $this->render('create_admin');
    }

    // Connexion à la base de données
    public function getDatabaseConnection(){
        $connectBDD = new ConnectBDD();
        return $connectBDD->bdd;
    }
}
