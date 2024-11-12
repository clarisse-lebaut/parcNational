<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../models/CoveModel.php';

class CoveModelTest extends TestCase
{
    private $coveModel;
    private $pdoMock;
    private $stmtMock;

    protected function setUp(): void
    {
        // Créer un mock pour PDO
        $this->pdoMock = $this->createMock(\PDO::class);

        // Créer un mock pour PDOStatement
        $this->stmtMock = $this->createMock(\PDOStatement::class);

        // Configurer le mock de PDO pour retourner le mock de PDOStatement quand `prepare` est appelé
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Initialiser CoveModel avec le mock de PDO
        $this->coveModel = new CoveModel();
        $this->coveModel->pdo = $this->pdoMock; // On remplace la vraie connexion PDO par notre mock
    }

    public function testGetAllCovesWhenNoCoveExists()
    {
        // Configurer le mock de PDOStatement pour retourner un tableau vide
        $this->stmtMock->method('fetchAll')->willReturn([]);

        // Appeler la méthode et vérifier que le résultat est un tableau vide
        $result = $this->coveModel->getAllCoves();
        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testGetAllCovesWithOneCove()
    {
        // Configurer le mock de PDOStatement pour retourner une calanque fictive
        $this->stmtMock->method('fetchAll')->willReturn([
            [
                'cove_id' => 1,
                'name' => 'Calanque de Sormiou',
                'description' => 'Une belle calanque',
                'location' => 'Marseille',
                'image' => 'sormiou.jpg'
            ]
        ]);

        // Appeler la méthode et vérifier le contenu du tableau
        $result = $this->coveModel->getAllCoves();
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals('Calanque de Sormiou', $result[0]['name']);
    }
}