<?php

class ConnectBDD
{
    public function connectBDD()
    {
        try {
            $dsn = "mysql:host=localhost;dbname=nationalpark;charset=utf8";
            $username = "root";
            $password = "";

            $connectBDD = new PDO($dsn, $username, $password);
            $connectBDD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Connexion réussie';
            return $connectBDD;

        } catch (PDOException $e) {
            echo 'Erreur PDO : ' . $e->getMessage();
            die();
        }
    }
}
?>
