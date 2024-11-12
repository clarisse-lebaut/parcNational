<?php
require_once 'Controller.php';
require_once __DIR__ . '/../models/Trails.php';
require_once __DIR__ . '/../models/FavoriteTrail.php';
require_once __DIR__ . '/../models/CompletedTrails.php';

class TrailsController extends Controller
{
    private $trailsModel; // Renommé pour correspondre à la classe du modèle

    // Constructeur pour initialiser le modèle
    public function __construct()
    {
        parent::__construct();
        $this->trailsModel = new Trails('trails'); // Assurez-vous que le nom de la table soit correct
    }

    public function trails()
    {
        // Récupérer tous les sentiers en utilisant le modèle
        $trails = $this->trailsModel->get_all_trails();
        // Enregistrer la visite pour la page d'accueil uniquement
        $this->enregistrerVisite('trails');
        // Afficher la vue 'trails' avec les données récupérées
        if (isset($_SESSION['user_id'])) {

            // Créer des objets pour les sentiers favoris et complétés
            $favoriteTrailObject = new FavoriteTrail('favorites_trails');
            $completedTrailObject = new CompletedTrails('completed_trails');

            // Récupérer la liste des sentiers favoris et complétés de l'utilisateur
            $favoriteTrails = $favoriteTrailObject->getFavoriteTrailByUser($_SESSION['user_id']);
            $completedTrails = $completedTrailObject->getCompletedTrailByUser($_SESSION['user_id']);

            // Extraire uniquement les identifiants de sentiers (trail_id)
            $favoriteTrailIds = array_column($favoriteTrails, 'trail_id');
            $completedTrailIds = array_column($completedTrails,'trail_id');
        } else {

            // Si l'utilisateur n'est pas connecté, définir des listes vides
            $favoriteTrailIds = [];
            $completedTrailIds = [];
        }

        // Afficher la vue 'trails' avec les données récupérées
        $this->render('trails', [
            'trails' => $trails,
            'favoriteTrailIds' => $favoriteTrailIds,
            'completedTrailIds' => $completedTrailIds
        ]);
    }

    public function details_trails()
    {
        // Récupérer l'ID depuis l'URL
        $trail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Si l'ID du sentier est invalide, afficher un message et sortir
        if ($trail_id <= 0) {
            echo "ID de sentier invalide.";
            return;
        }

        // Récupérer le sentier correspondant à l'ID
        $trail = $this->trailsModel->get_trail_id($trail_id); // Méthode du modèle pour récupérer un sentier par ID

        // Si le sentier n'existe pas, afficher un message et sortir
        if (!$trail) {
            echo "Sentier non trouvé.";
            return;
        }

        // Récupérer les autres détails du sentier
        $trail_time = $this->trailsModel->get_trails_time($trail['time']);
        $trail_length = $this->trailsModel->get_trails_km($trail['length_km']);
        $trail_description = $this->trailsModel->get_trails_description($trail['description']);
        $trail_difficulty = $this->trailsModel->get_trails_difficulty($trail['difficulty']);
        $trail_status = $this->trailsModel->get_trails_status($trail['status']);
        $trail_infos = $this->trailsModel->get_trails_infos($trail['infos']);
        $trail_access = $this->trailsModel->get_trails_acces($trail['acces']);
        $landmarks = $this->trailsModel->get_trails_landmarks($trail_id);

        // Récupérer tous les sentiers pour le slider
        $trails = $this->trailsModel->get_all_trails();

        // Afficher la vue 'details_trails' avec les données récupérées
        $this->render('details_trails', [
            'trail' => $trail,
            'trail_time' => $trail_time,
            'trail_length' => $trail_length,
            'trail_description' => $trail_description,
            'trail_difficulty' => $trail_difficulty,
            'trail_status' => $trail_status,
            'trail_infos' => $trail_infos,
            'trail_access' => $trail_access,
            'landmarks' => $landmarks,
            'trails' => $trails // Ajoute cette ligne pour passer la liste des sentiers
        ]);
    }
}
