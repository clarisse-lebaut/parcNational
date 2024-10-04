<?php
require_once __DIR__ . '/../config/connectBDD.php';
require_once __DIR__ . '/../models/CoveModel.php';  
require_once __DIR__ . '/../controllers/coveController.php';  

$coveController = new CoveController(new CoveModel());
$calanques = $coveController->getAllCoves();  
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calanques</title>
    <link rel="stylesheet" href="../assets/styles/coves.css">
    <link rel="stylesheet" href="../assets/styles/_global.css">
</head>
<body>
    <header>
    </header>
        <h1>Les Calanques de Marseille</h1>

    <main>
        <section>
            <?php if (!empty($calanques)): ?>
                <div class="calanques-grid">
                    <?php foreach ($calanques as $calanque): ?>
                        <div class="calanque-item">
                            <?php if (!empty($calanque['image'])): ?>
                                <img src="../<?= htmlspecialchars($calanque['image']); ?>" alt="Image de <?= htmlspecialchars($calanque['name']); ?>">
                            <?php endif; ?>

                            <h2><?= htmlspecialchars($calanque['name']); ?></h2>

                            <p><?= htmlspecialchars($calanque['location']); ?></p>

                            <p><?= htmlspecialchars($calanque['description']); ?></p>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucune calanque disponible.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
