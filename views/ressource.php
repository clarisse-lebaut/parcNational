<?php
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/ressourceModel.php';
require_once __DIR__ . '/../controllers/ressourceController.php';

$ressourceModel = new RessourceModel();
$ressourceController = new RessourceController($ressourceModel);

$ressources = $ressourceController->getAllRessources();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ressources Naturelles</title>
    <link rel="stylesheet" href="../assets/styles/ressource.css">
    <link rel="stylesheet" href="../assets/styles/_global.css">
</head>
<body>
<header>
<?php include __DIR__ . '/../components/_header.php'; ?>
    </header>
        <main>
                <h1>Ressources Naturelles des Calanques</h1>
        <section>
            <?php if (!empty($ressources)): ?>
                <div class="ressource-grid">
                    <?php foreach ($ressources as $ressource): ?>
                        <div class="ressource-item">
                            <?php if (!empty($ressource['image'])): ?>
                                <a href="ressourceDetails.php?id=<?= htmlspecialchars($ressource['ressource_id']); ?>">
                                    <img src="../<?= htmlspecialchars($ressource['image']); ?>" alt="Image de <?= htmlspecialchars($ressource['name'] ?? 'Ressource') ?>">
                                </a>
                            <?php endif; ?>

                            <a href="ressourceDetails.php?id=<?= htmlspecialchars($ressource['ressource_id']); ?>" class="ressource-name">
                                <?= htmlspecialchars($ressource['name'] ?? 'Nom non disponible'); ?>
                            </a>

                            <p>Type : <?= htmlspecialchars($ressource['type'] ?? 'Non spécifié'); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucune ressource naturelle trouvée.</p>
            <?php endif; ?>
        </section>
    </main>

    <script src="../assets/javascript/ressources.js"></script>
</body>
</html>
