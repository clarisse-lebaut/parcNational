<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/Trails.php';

class TrailsController extends Controller
{

    private $newsModel;
    private $bdd;

    // Constructeur pour initialiser le modèle et la base de données
    public function __construct()
    {
        // Initialisation de l'objet Trails = c'est le nom de la classe que je donne le ficher dans le dossier Models
        $this->newsModel = new Trails();

        // Initialisation de la connexion à la base de données (supposons que tu aies une instance $bdd quelque part)
        $this->bdd = $this->getDatabaseConnection(); // Méthode à créer si elle n'existe pas
    }

    public function trails()
    {
        // Récupérer les news en utilisant le modèle
        $trails = $this->newsModel->get_all_trails($this->bdd);
        // Afficher la vue 'trails' avec les données récupérées
        $this->render('trails', ['trails' => $trails]);
    }

    public function details_trails()
    {
        // Récupérer l'ID depuis l'URL
        $trail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Récupérer tous les sentiers
        $trails = $this->newsModel->get_all_trails($this->bdd);

        // Récupérer le sentier correspondant à l'ID
        if ($trail_id > 0) {
            // Récupérer les données du sentier
            $trail = $this->newsModel->get_trails_id($this->bdd, $trail_id);

            // Si le sentier n'existe pas, afficher un message et sortir
            if (!$trail) {
                echo "Sentier non trouvé.";
                return;
            }

            // Récupérer les autres détails du sentier
            $trail_time = $this->newsModel->get_trails_time($this->bdd, $trail['time']);
            $trail_length = $this->newsModel->get_trails_km($this->bdd, $trail['length_km']);
            $trail_description = $this->newsModel->get_trails_description($this->bdd, $trail['description']);
            $trail_difficulty = $this->newsModel->get_trails_difficulty($this->bdd, $trail['difficulty']);
            $trail_status = $this->newsModel->get_trails_status($this->bdd, $trail['status']);
            $trail_infos = $this->newsModel->get_trails_info($this->bdd, $trail['infos']);
            $trail_access = $this->newsModel->get_trails_access($this->bdd, $trail['acces']);
            $landmarks = $this->newsModel->get_trails_landmarks($this->bdd, $trail_id);
        }

        // Afficher la vue 'details_trails' avec les données récupérées
        $this->render('details_trails', [
            'trails' => $trails,
            'trail' => $trail,
            'trail_time' => $trail_time,
            'trail_length' => $trail_length,
            'trail_description' => $trail_description,
            'trail_difficulty' => $trail_difficulty,
            'trail_status' => $trail_status,
            'trail_infos' => $trail_infos,
            'trail_access' => $trail_access,
            'landmarks' => $landmarks
        ]);
    }

    //* Fonction pour avoir la connexion à la base de donnée
    public function getDatabaseConnection()
    {
        // Instancier la classe ConnectBDD
        $connectBDD = new ConnectBDD();
        // Retourner l'objet PDO
        return $connectBDD->bdd;
    }

}