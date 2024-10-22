<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/AdminUsers.php';

class AdminUsersController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Users('users'); // Utiliser le modèle Users
    }

    //* Méthode pour afficher la vue des administrateurs
    public function manageUsers()
    {
        // Vérifie si une requête POST a été effectuée pour supprimer un administrateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            $user_id = intval($_POST['user_id']);
            $deleteSuccess = $this->model->delete($user_id);

            if ($deleteSuccess) {
                // Rediriger vers la même page pour actualiser la liste des administrateurs
                $this->redirect('manage_users');
                exit; // S'assurer que le script s'arrête ici
            } else {
                echo "Erreur : Impossible de supprimer cet administrateur.";
            }
        }

        // Récupère les administrateurs
        $users = $this->model->get_users_by_role(2); // 2 correspond au rôle d'administrateur
        $countUsers = $this->model->count_users(); // Compte le nombre total d'utilisateurs

        // Vérifie si les administrateurs et le comptage sont corrects
        if ($countUsers !== false && !empty($users)) {
            $this->render('manage_users', [
                'total_users' => $countUsers['total'],
                'users' => $users
            ]); // Passe les administrateurs et le compte à la vue
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors du chargement des administrateurs.";
        }
    }
}
