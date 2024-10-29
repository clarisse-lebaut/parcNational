<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($ressource['name'] ?? 'Ressource Naturelle') ?></title>
    <link rel="stylesheet" href="assets/style/user/ressourceDetails.css">
    <link rel="stylesheet" href="assets/style/config/_global.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>

    <main>
        <section>
            <h1 class="ressource-details-title"><?= htmlspecialchars($ressource['name']); ?></h1>
            <div class="ressource-details-row">
                <div class="ressource-details-type">
                    <?php if ($ressource['type'] === 'Faune Terrestre'): ?>
                        <div class="ressources_details_type_title">
                            <span class="type-icon">&#x1F98C;</span>
                            <p>Faune Terrestre</p>
                        </div>
                    <?php elseif ($ressource['type'] === 'Faune Marine'): ?>
                        <span class="type-icon">&#x1F420;</span> Faune Marine
                    <?php elseif ($ressource['type'] === 'Flore Terrestre'): ?>
                        <span class="type-icon">&#x1F333;</span> Flore Terrestre
                    <?php elseif ($ressource['type'] === 'Flore Marine'): ?>
                        <span class="type-icon">&#x1FAB8;</span> Flore Marine
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section>
            <div class="ressource-details-description">
                <p><?= htmlspecialchars($ressource['description']); ?></p>
            </div>
        </section>


        <section class="ressource-details-container">
            <div class="ressource-details-row">
                <img class="ressource-details-img" src="../<?= htmlspecialchars($ressource['image']); ?>" alt="Image de <?= htmlspecialchars($ressource['name']); ?>">
            </div>
        </section>


        <section>
            <div>
                <?php if ($ressource): ?>
                    <div class="ressource-details-main">
                        <?php if (!empty($ressource['precautions'])): ?>
                            <div class="ressource-details-precautions">
                                <h3>Précautions</h3>
                                <p><?= htmlspecialchars($ressource['precautions']); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="conservation-bar-container">
                            <p><i>Importance de conservation</i></p>
                            <div class="conservation-bar">
                                <div class="conservation-bar-fill" id="conservation-level-bar" data-level="<?= htmlspecialchars($ressource['level']); ?>"></div>
                            </div>
                            <div class="conservation-levels">
                                <p style="color:green;"><span>Faible</span></p>
                                <p style="color:yellow;"><span>Moyen</span></p>
                                <p style="color:orange;"><span>Fort</span></p>
                                <p style="color:red;"><span>Très fort</span></p>
                            </div>
                        </div>
                    </div>

                    <?php else: ?>
                        <p class="ressource-details-error">Ressource naturelle introuvable ou ID de ressource non valide.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="other_ressources">
            <h2>Autres ressources</h2>
            <div class="slider">
                <div class="slider_elements">
                    <?php foreach ($all_ressources as $all_ressource): ?>
                        <div class="card_trails">
                            <a href="ressourceDetails?id=<?php echo urlencode($all_ressource['ressource_id']); ?>">
                                <p><?php echo htmlspecialchars($all_ressource['name']); ?></p>
                                <img class="pic-slider" src="<?php echo htmlspecialchars($all_ressource['image']); ?>" alt="<?php echo htmlspecialchars($all_ressource['name']); ?>" width="200">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </main>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

    <script src="assets/script/ressource.js"></script>
</body>
</html>
