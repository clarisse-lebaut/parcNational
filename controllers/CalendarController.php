<?php
require_once __DIR__ . '/../models/CampsiteModel.php'; 
require_once __DIR__ . '/../controllers/CampsiteController.php'; 

class CalendarController {
    public function showCalendar() {
        $campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;

        if ($campsite_id > 0) {
            $campsiteModel = new CampsiteModel();
            $campsiteController = new CampsiteController($campsiteModel);
            $campsite = $campsiteModel->getCampsiteById($campsite_id);
            $vacationEvents = $campsiteController->getVacationEvents($campsite_id);
        } else {
            $campsite = null;
            $vacationEvents = [];
        }

        // Inclure la vue du calendrier
        require __DIR__ . '/../views/calendar.php';
    }
}
