<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/CampsiteController.php';

$campsiteModel = new CampsiteModel();
$campsiteController = new CampsiteController($campsiteModel);

// Récupérer l'ID du camping depuis l'URL puis ses details grâce au model
$campsite_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($campsite_id > 0) {
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
    // Récupérer les événements de vacances et vérifier le statut
    $events = $campsiteController->getVacationEvents($campsite_id);
    $isClosed = $campsiteController->isClosedToday($events);
} else {
    $campsite = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Camping</title>
    <link rel="stylesheet" href="../assets/styles/campsiteDetails.css">
    <link rel="stylesheet" href="../assets/styles/_global.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>

    <div class="campsite-details-container">
        <?php if ($campsite): ?>
            <!-- ROW TITRE -->
            <div class="campsite-details-row">
                <h1 class="campsite-details-title"><?= htmlspecialchars($campsite['name']); ?></h1>
            </div>

            <!-- ROW IMG & ADRESSE -->
            <div class="campsite-details-row">
                <img class="campsite-details-img" src="../<?= htmlspecialchars($campsite['image']); ?>" alt="Image de <?= htmlspecialchars($campsite['name']); ?>">
                <div class="campsite-details-adress">
                    <span class="location-icon">&#x1F4CD;</span> 
                    <p><?= htmlspecialchars($campsite['address']) . ', ' . htmlspecialchars($campsite['city']) . ' ' . htmlspecialchars($campsite['zipcode']); ?></p>
                </div>
            </div>

            <!-- ROW STATUT -->
            <div class="campsite-details-row campsite-details-rowicon">
                <p id="campsite-status">
                    <?php if ($isClosed): ?>
                        <span>&#x1F534;</span> Fermé 
                    <?php else: ?>
                        <span>&#x1F7E2;</span> Ouvert 
                    <?php endif; ?>
                </p>

                <div class="campsite-price">
                    <span class="price-icon">€</span> 
                    <?= number_format($campsite['price_per_night'], 2); ?> / nuit
                </div> 
            </div>

            <!-- ROW DESCRIPTION -->
            <div class="campsite-details-row">
                <div class="campsite-details-description">
                    <p><?= htmlspecialchars($campsite['description']); ?></p>
                </div>
            </div>

            <!-- ROW BOUTON RESERVER -->
            <div class="campsite-details-row">
                <a href="../views/calendar.php?campsite_id=<?= $campsite_id ?>" class="campsite-details-btn">Réserver</a>
            </div>
        <?php else: ?>
            <p class="campsite-details-error">Camping introuvable ou ID de camping non valide.</p>
        <?php endif; ?>
    </div>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

</body>
</html>
