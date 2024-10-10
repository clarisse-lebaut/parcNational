<?php
require_once __DIR__ . '/../models/CampsiteModel.php';
require_once __DIR__ . '/../controllers/CampsiteController.php';

$campsiteModel = new CampsiteModel();
$campsiteController = new CampsiteController($campsiteModel);
$campsites = $campsiteController->getAllCampsites();

// boucler chaque camping pour verif leur statut
foreach ($campsites as &$campsite) {
    $events = $campsiteController->getVacationEvents($campsite['campsite_id']);
    $campsite['isClosed'] = $campsiteController->isClosedToday($events);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campings</title>
    <link rel="stylesheet" href="../assets/styles/campsite.css">
    <link rel="stylesheet" href="../assets/styles/_global.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>

    <h1>Séjournez dans un camping près des Calanques</h1>
    <div class="campsite-subtitle">
        Séjournez dans nos campings proches des calanques, offrant un cadre naturel et paisible pour vos vacances.<br>
         Profitez de la nature, des paysages méditerranéens et d'une expérience inoubliable dans le sud de la France !
    </div>

    <?php if (!empty($campsites)): ?>
        <div class="camping-grid">
            <?php foreach ($campsites as $campsite): ?>
                <div class="camping-item">
                    <a href="campsiteDetails.php?id=<?= htmlspecialchars($campsite['campsite_id']); ?>">
                        <img src="../<?= htmlspecialchars($campsite['image']); ?>" alt="Image de <?= htmlspecialchars($campsite['name']); ?>">
                    </a>

                    <a href="campsiteDetails.php?id=<?= htmlspecialchars($campsite['campsite_id']); ?>" class="campsite-name">
                        <?= htmlspecialchars($campsite['name']); ?>
                    </a>
                    
                    <p>
                        <?php
                        $description = htmlspecialchars($campsite['description']);
                        if (strlen($description) > 100) {
                            echo '<span class="short-text">' . substr($description, 0, 100) . ' </span>';
                            echo '<span class="long-text">' . substr($description, 100) . '</span>';
                            echo '<span class="show-more" data-id="' . htmlspecialchars($campsite['campsite_id']) . '">Voir plus</span>';
                        } else {
                            echo $description;
                        }
                        ?>
                    </p>
                    
                    <p><span class="location-icon">&#x1F4CD;</span> <?= htmlspecialchars($campsite['address'] ?? '') . ', ' . htmlspecialchars($campsite['city'] ?? '') . ' ' . htmlspecialchars($campsite['zipcode'] ?? ''); ?></p>

                    <div class="campsite-status">
                        <?php if ($campsite['isClosed']): ?>
                            <span class="status-icon">&#x1F534;</span>
                            Fermé
                        <?php else: ?>
                            <span class="status-icon">&#x1F7E2;</span>
                            Ouvert
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun camping trouvé.</p>
    <?php endif; ?>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

    <script src="../assets/javascript/campsite.js"></script>
</body>
</html>
