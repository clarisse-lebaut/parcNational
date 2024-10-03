<?php
require_once __DIR__ . '/../models/ressourceModel.php';

$ressourceModel = new RessourceModel();

// Récupérer l'ID de la ressource depuis l'URL puis ses détails grâce au modèle
$ressource_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ressource_id > 0) {
    $ressource = $ressourceModel->getRessourceById($ressource_id);
} else {
    $ressource = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Ressource Naturelle</title>
    <link rel="stylesheet" href="../assets/styles/ressourceDetails.css">
</head>
<body>
    <div class="ressource-details-container">
        <?php if ($ressource): ?>
            <!-- ROW TITRE -->
            <div class="ressource-details-row">
                <h1 class="ressource-details-title"><?= htmlspecialchars($ressource['name']); ?></h1>
            </div>

            <!-- ROW IMG & TYPE -->
            <div class="ressource-details-row">
                <img class="ressource-details-img" src="../<?= htmlspecialchars($ressource['image']); ?>" alt="Image de <?= htmlspecialchars($ressource['name']); ?>">
                <div class="ressource-details-type">
                    <?php if ($ressource['type'] === 'Faune Terrestre'): ?>
                        <img src="../assets/icons/faune_terrestre_icon.png" alt="Icône Faune Terrestre">
                    <?php elseif ($ressource['type'] === 'Faune Marine'): ?>
                        <img src="../assets/icons/faune_marine_icon.png" alt="Icône Faune Marine">
                    <?php elseif ($ressource['type'] === 'Flore Terrestre'): ?>
                        <img src="../assets/icons/flore_terrestre_icon.png" alt="Icône Flore Terrestre">
                    <?php elseif ($ressource['type'] === 'Flore Marine'): ?>
                        <img src="../assets/icons/flore_marine_icon.png" alt="Icône Flore Marine">
                    <?php endif; ?>
                    <p>Type : <?= htmlspecialchars($ressource['type']); ?></p>
                </div>
            </div>

            <!-- ROW DESCRIPTION -->
            <div class="ressource-details-row">
                <div class="ressource-details-description">
                    <p><?= htmlspecialchars($ressource['description']); ?></p>
                </div>
            </div>

            <!-- ROW PRECAUTIONS -->
            <?php if (!empty($ressource['precautions'])): ?>
                <div class="ressource-details-row">
                    <div class="ressource-details-precautions">
                        <h3>Précautions</h3>
                        <p><?= htmlspecialchars($ressource['precautions']); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!--ENJEU DE CONSERVATION -->
            <div class="conservation-bar-container">
                <div class="conservation-bar">
                    <div class="conservation-bar-fill" id="conservation-level-bar" data-level="<?= htmlspecialchars($ressource['level']); ?>"></div>
                </div>
                <div class="conservation-levels">
                    <span>Faible</span>
                    <span>Moyen</span>
                    <span>Fort</span>
                    <span>Très fort</span>
                </div>
            </div>

            <p>Niveau de conservation : <?= htmlspecialchars($ressource['level']); ?></p>

        <?php else: ?>
            <p class="ressource-details-error">Ressource naturelle introuvable ou ID de ressource non valide.</p>
        <?php endif; ?>
    </div>

    <script src="../assets/javascript/ressource.js"></script>
</body>
</html>
