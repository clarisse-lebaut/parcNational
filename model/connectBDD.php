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

// <?php
// class Model
// {
//     public $pdo;
//     public $table;

//     public function _construct($table)
//     {
//         $this->this = $table;
//         try {
//             $this->pdo = new PDO("mysql:host=localhost;dbname=nationalpark;charset=utf8", "root", "");
//         } catch (Exception $e) {
//             die('Erreur : ' . $e->getMessage());
//         }
//     }
// }