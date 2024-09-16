<?php
class ConnectBDD
{
    public function connectBDD()
    {
        try {
            $connectBDD = new PDO("mysql:host=localhost;dbname=nationalpark;charset=utf8", "root", "");
            echo "Connexion réussi !";
            return $connectBDD;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}