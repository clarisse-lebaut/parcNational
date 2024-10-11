<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectDB.php';
require_once __DIR__ . '/../models/AdminUsers.php';

class AdminUsersController extends Controller
{

    private $model;
    private $bdd;

    public function __construct()
    {
        $this->model = new Users(); // Utiliser le modèle Users
        $this->bdd = $this->getDatabaseConnection(); // Connexion à la base de données
    }

    //* Méthode pour afficher la vue des administrateurs
    // il faut que toutes mes fonction de gestion soient dans cette méthode 
    //! parce que je ne peux faire qu'une seule route par méthode dans l'index !
    public function manageUsers()
    {
        // Vérifie si une requête POST a été effectuée pour supprimer un administrateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && !empty($_POST['user_id'])) {
            $user_id = intval($_POST['user_id']);

            $deleteSuccess = $this->model->delete($this->bdd, $user_id);

            if ($deleteSuccess) {
                // Rediriger vers la même page pour actualiser la liste des administrateurs
                $this->redirect('admin/manage_users');
                exit; // S'assurer que le script s'arrête ici
            } else {
                echo "Erreur : Impossible de supprimer cet administrateur.";
            }
        }

        // Si aucune suppression n'est demandée, on récupère et affiche les administrateurs
        $users = $this->model->get_users($this->bdd); // Récupère les administrateurs
        $countUsers = $this->model->count_users($this->bdd); // Compte le nombre d'administrateurs

        // Vérifie si les administrateurs et le comptage sont corrects
        if ($countUsers !== false && !empty($users)) {
            $this->render('admin/manage_users', [
                'total_users' => $countUsers['total'],
                'users' => $users
            ]); // Passe les administrateurs à la vue
        } else {
            // Gère le cas où les données ne sont pas récupérées correctement
            echo "Erreur lors du chargement des administrateurs.";
        }
    }

    // Connexion à la base de données
    public function getDatabaseConnection()
    {
        $connectBDD = new ConnectDB();
        return $connectBDD->bdd;
    }
}
