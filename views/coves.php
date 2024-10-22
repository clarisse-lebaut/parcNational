<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calanques de Marseille</title>
    <link rel="stylesheet" href="../assets/styles/coves.css">
    <link rel="stylesheet" href="../assets/styles/_global.css">
</head>
<body>
    <header>
         <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>

    <main>
        <h1>Les Calanques de Marseille</h1>
        <section>
            <?php if (!empty($calanques)): ?>
                <div class="coves-grid">
                    <?php foreach ($calanques as $calanque): ?>
                        <div class="coves-item">
                            <?php if (!empty($calanque['image'])): ?>
                                <img src="../<?= htmlspecialchars($calanque['image']); ?>" alt="Image de <?= htmlspecialchars($calanque['name']); ?>" class="coves-image">
                            <?php endif; ?>

                            <h2 class="coves-title"><?= htmlspecialchars($calanque['name']); ?></h2>

                            <p class="coves-location"><?= htmlspecialchars($calanque['location']); ?></p>

                            <p class="coves-description"><?= htmlspecialchars($calanque['description']); ?></p>
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
