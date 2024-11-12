<?php
//- Classe de base TestCase de PHPUnit pour écrire tests;accéder aux outils de test.
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../controllers/ReservationController.php';

class CreateReservationTest extends TestCase
{     //? dans la classe: instancier la fonction a test (non mocké)
    private $reservationController;    
    private $campsiteControllerMock; //? mock de camspite pour simuler son comportement 
 
    protected function setUp(): void
    {
        $this->campsiteControllerMock = $this->createMock(CampsiteController::class); //? version simulée de campsite pour contrôler son comportement dans les tests
        $this->reservationController = new ReservationController(); //? instance réelle de ReservationController

        //? réflexion pour remplacer CampsiteController par le mock dans ReservationController
        $campsiteControllerProperty = new ReflectionProperty(ReservationController::class, 'campsiteController');
        $campsiteControllerProperty->setAccessible(true);
        $campsiteControllerProperty->setValue($this->reservationController, $this->campsiteControllerMock);
    }
    
        public function testCreateReservation_Successful()
        {
            //  -mock qui simule "disponible"
            $this->campsiteControllerMock->method('checkAvailability')->willReturn('disponible');

            //-mock de ReservationModel, simule un id pour l'user
            $reservationModelMock = $this->createMock(ReservationModel::class);
            $reservationModelMock->method('createReservation')->willReturn(1); 

            // -injecter le modèle simulé 
            $reservationModelProperty = new ReflectionProperty(ReservationController::class, 'reservationModel');
            $reservationModelProperty->setAccessible(true);
            $reservationModelProperty->setValue($this->reservationController, $reservationModelMock);

            //- variable nécessaires à createReservation avec des paramètres de test
            $user_id = 1;
            $campsite_id = 1;
            $start_date = '2024-11-15';
            $end_date = '2024-11-20';
            $price = 100.0;

            // Vérifie que la méthode retourne bien l'ID de la réservation
            //- appel de createReservation avec les parametres de test qui va utiliser le mock ReservationModel
            $result = $this->reservationController->createReservation($user_id, $campsite_id, $start_date, $end_date, $price);
            $this->assertEquals(1, $result); //! attend l'ID 1 pour confirmer le succès
        }
    }