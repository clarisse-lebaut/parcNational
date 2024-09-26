<?php

class ConnectBDD
{
    public $bdd;

    function __construct()
    {
        try {
            $dsn = "mysql:host=localhost;dbname=nationalpark;charset=utf8";
            $username = "root";
            $password = "";

            $this->bdd = new PDO($dsn, $username, $password);
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur PDO : ' . $e->getMessage();
            die();
        }
    }
}
?>
