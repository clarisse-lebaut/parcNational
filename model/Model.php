<?php
class Model
{
    public $pdo;//It is a connector between the interface and the database
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

