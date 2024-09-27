<?php
class ConnectBDD
{
    protected $db; //co stockée

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=nationalpark;charset=utf8", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion réussie !";
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // méthode qui recup la co et retourne l'objet pdo pour utiliser ailleurs 
    public function getDb() {
        return $this->db;  
    }
}