<?php
//! Classe de base TestCase de PHPUnit pour écrire tests;accéder aux outils de test.
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../controllers/ReservationController.php';

class CreateReservationTest extends TestCase
{     //! dans la classe: instancier la fonction a test (non mocké)
    private $reservationController;    
    private $campsiteControllerMock; //! mock de camspite pour simuler son comportement 
 
    protected function setUp(): void
    {
        $this->campsiteControllerMock = $this->createMock(CampsiteController::class); //! version simulée de campsite pour contrôler son comportement dans les tests
        $this->reservationController = new ReservationController(); //! instance réelle de ReservationController

        //- Utiliser la réflexion pour remplacer CampsiteController par le mock dans ReservationController
        $campsiteControllerProperty = new ReflectionProperty(ReservationController::class, 'campsiteController');
        $campsiteControllerProperty->setAccessible(true);
        $campsiteControllerProperty->setValue($this->reservationController, $this->campsiteControllerMock);
    }
}
