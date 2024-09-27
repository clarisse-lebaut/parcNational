<?php
require_once 'Controller.php';
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/Trails.php';

class TrailsController extends Controller {

    private $newsModel;
    private $bdd;

    // Constructeur pour initialiser le modèle et la base de données
    public function __construct(){
        // Initialisation de l'objet Trails = c'est le nom de la classe que je donne le ficher dans le dossier Models
        $this->newsModel = new Trails();

        // Initialisation de la connexion à la base de données (supposons que tu aies une instance $bdd quelque part)
        // Exemple : $this->bdd = new PDO(...); ou récupérer la connexion via un service
        $this->bdd = $this->getDatabaseConnection(); // Méthode à créer si elle n'existe pas
    }

    public function trails(){
        // Récupérer les news en utilisant le modèle
        $trails = $this->newsModel->get_all_trails($this->bdd);
        // Afficher la vue 'trails' avec les données récupérées
        $this->render('trails', ['trails' => $trails]);
    }

    //* Fonction pour avoir la connexion à la base de donnée
    public function getDatabaseConnection(){
    // Instancier la classe ConnectBDD
    $connectBDD = new ConnectBDD();
    // Retourner l'objet PDO
    return $connectBDD->bdd;
    }
    
}