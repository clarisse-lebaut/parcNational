<?php
require_once __DIR__ . '/../model/CampsiteModel.php';

$campsiteModel = new CampsiteModel();

// Récupérer l'ID du camping depuis l'URL puis ses details grace au model
$campsite_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($campsite_id > 0) {
    $campsite = $campsiteModel->getCampsiteById($campsite_id);
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
</head>
<body>
    <div class="campsite-details-container">
        <?php if ($campsite): ?>
            <!-- ROW TITRE -->
            <div class="campsite-details-row">
                <h1 class="campsite-details-title"><?= htmlspecialchars($campsite['name']); ?></h1>
            </div>

            <!-- ROW IMG -->
            <div class="campsite-details-row">
                <img class="campsite-details-img" src="../<?= htmlspecialchars($campsite['image']); ?>" alt="Image de <?= htmlspecialchars($campsite['name']); ?>">
            </div>

            <!-- ROW ICONES -->
            <div class="campsite-details-row campsite-details-rowicon <?= ($campsite['status'] === 'Ouvert') ? 'status-open' : 'status-closed'; ?>">
                <p>
                    <?php if ($campsite['status'] === 'Ouvert'): ?>
                        <span class="status-icon">&#x1F7E2;</span> 
                        Ouvert
                    <?php else: ?>
                        <span class="status-icon">&#x1F534;</span> 
                        Fermé
                    <?php endif; ?>
                </p>
            </div>

            <!-- ROW ADRESSE ET DISPO -->
            <div class="campsite-details-row">
                <div class="campsite-details-info">
                    <div class="campsite-details-rowicon">
                        <p>Adresse : <?= htmlspecialchars($campsite['address']) . ', ' . htmlspecialchars($campsite['city']) . ' ' . htmlspecialchars($campsite['zipcode']); ?></p>
                    </div>
                    <div class="campsite-details-info-dispo">
                       CALDENDRIER DES DISPO
                    </div>
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
                <a href="#" class="campsite-details-btn">Faire une réservation</a>
            </div>
        <?php else: ?>
            <p class="campsite-details-error">Camping introuvable ou ID de camping non valide.</p>
        <?php endif; ?>
    </div>
</body>
</html>
