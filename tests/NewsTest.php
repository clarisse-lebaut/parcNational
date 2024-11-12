<?php 

// on importe PHPUnit
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../models/News.php';

class NewsTest extends TestCase 
{
    // On crée 3 propriétés de classe :
    private $news; // instance de la classe News, utilisée pour tester les méthodes orésente dans ce model
    private $mockPDO; // stocke le mock PDO
    private $mockStmt; // stocke le mock PDOStatement

    // 1. setup la création du mock pour toujours pouvoir l'appeler pour tous les tests
    //! cela permet de pas toucher le model de la connexion à la base de donnée
    //! cela permet de configurer les créations de mocks et de pouvoir les avoirs dispo et globaux
    
    protected function setUp(): void {
        // 1.1 Créer un mock pour PDO
        $this->mockPDO = $this->createMock(PDO::class);

        // 1.2 Créer un mock pour PDOStatement
        $this->mockStmt = $this->createMock(PDOStatement::class);

        // 1.3 Configurer le mock PDO pour qu'il retourne PDOStatement quand 'prepare' est appelé
        $this->mockPDO->method('prepare')->willReturn($this->mockStmt);

        // 1.4 Instancier le model News avec le mock PDO pour simuler une connexion à la base de données
        $this->news = new News();
        $this->news->pdo = $this->mockPDO;
    }

    // 2. Définir des données simulées
    //! ceci est une fonction pour tester si la requête dans le model marche bien
    public function testGetAllNews() {
        // 2.1 crée un tableau dans lequle je stock de fausse données
        $data = [
            ['id' => 1, 'title' => "Titre", 'content' => "Contenu"],
            ['id' => 2, 'title' => "Titre", 'content' => "Contenu"],
            ['id' => 3, 'title' => "Titre", 'content' => "Contenu"]
        ];

        // 2.3 Configurer le mock de PDOStatement pour qu'il retourne les données simulées
        $this->mockStmt->method('fetchAll')->willReturn($data);

        // 2.4 Appeler la méthode get_news() et vérifier le résultat
        $result = $this->news->get_news();
        // Comparer les résultats
        //? il existe d'autres assert pour vérifier d'autre choses
        $this->assertEquals($data, $result); 
    }
}
