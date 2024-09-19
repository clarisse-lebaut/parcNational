<?php
class Model
{
    public $pdo;//jest lacznikiem miedzy interfejsem i baza danych
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=nationalpark;charset=utf8", "root", "");

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}

