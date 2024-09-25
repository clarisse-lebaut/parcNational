<?php
require_once __DIR__ . '/../model/CampsiteModel.php';

$campsite_id = isset($_GET['campsite_id']) ? intval($_GET['campsite_id']) : 0;
if ($campsite_id > 0) {
    $campsiteModel = new CampsiteModel();
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
} else {
    $campsite = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Réservation - <?= $campsite ? htmlspecialchars($campsite['name']) : 'Camping'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/timegrid.min.css" />
    <link rel="stylesheet" href="../assets/styles/calendar.css">
</head>

<body>
    <?php if ($campsite): ?>
        <div class="calendar-info">
            <h1><?= htmlspecialchars($campsite['name']); ?></h1>
            <img src="../<?= htmlspecialchars($campsite['image']); ?>" alt="Photo de <?= htmlspecialchars($campsite['name']); ?>" class="calendar-img">
        </div>
    <?php else: ?>
        <p class="error">Erreur : Camping introuvable.</p>
    <?php endif; ?>
    
    <h2>Calendrier des Réservations</h2>

    <div id="calendar"></div>

    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.15/index.global.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rrule/2.6.8/rrule.min.js"></script>

    <script src="../assets/javascript/calendar.js"></script>
</body>
</html>
