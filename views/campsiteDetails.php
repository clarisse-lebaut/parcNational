<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/CampsiteController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$campsite_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($campsite_id > 0) {
    $campsiteModel = new CampsiteModel();
    $campsiteController = new CampsiteController($campsiteModel);
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
    $events = $campsiteController->getVacationEvents($campsite_id);
    $isClosed = $campsiteController->isClosedToday($events);
    $availability = $campsiteController->checkAvailability($campsite_id);
} else {
    $campsite = null;
}

// si user pas connecté
$errorMessage = null;
if ($user_id === null) {
    $errorMessage = "Vous devez être connecté pour effectuer une réservation.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Camping</title>
    <link rel="stylesheet" href="assets/style/user/campsiteDetails.css">
    <link rel="stylesheet" href="assets/style/_global.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>

    <main>
        <div class="campsite-details-container">
            <?php if ($errorMessage): ?>
                <div class="error-message">
                    <?= htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <?php if ($campsite): ?>

                <div class="campsite-details-row">
                    <h1 class="campsite-details-title"><?= htmlspecialchars($campsite['name']); ?></h1>
                </div>

                <div class="campsite-details-row">
                    <img class="campsite-details-img" src="../parcNational/<?= htmlspecialchars($campsite['image']); ?>" alt="Image de <?= htmlspecialchars($campsite['name']); ?>">
                    <div class="campsite-details-adress">
                        <span class="location-icon">&#x1F4CD;</span> 
                        <p><?= htmlspecialchars($campsite['address']) . ', ' . htmlspecialchars($campsite['city']) . ' ' . htmlspecialchars($campsite['zipcode']); ?></p>
                    </div>
                </div>

                <!-- ROW STATUT -->
                <div class="campsite-details-row campsite-details-rowicon campsite-details-price">
                    <p id="campsite-status">
                        <?php if ($isClosed): ?>
                            <span>&#x1F534;</span> Fermé (Vacances) 
                        <?php elseif ($availability === 'Camping complet'): ?>
                            <span>&#x1F534;</span> Complet
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

                <!-- BOUTON RESERVER -->
                <?php if (!$isClosed && $availability !== 'Camping complet'): ?>
                    <div class="campsite-details-row campsite-details-btn">
                        <?php if ($user_id !== null): ?>
                            <a href="calendar?campsite_id=<?= htmlspecialchars($campsite['campsite_id']); ?>">Réserver</a>
                        <?php else: ?>
                            <a href="#" class="disabled-link" onclick="alert('Vous devez être connecté pour effectuer une réservation.'); return false;">Réserver</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <p class="campsite-details-error">Camping introuvable ou ID de camping non valide.</p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>
</body>
</html>
