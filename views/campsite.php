<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campings</title>
    <link rel="stylesheet" href="assets/style/user/campsite.css">
    <link rel="stylesheet" href="assets/style/config/_filter.css">
    <link rel="stylesheet" href="assets/style/_global.css">
    <script src="assets/script/filter/filter-campsite.js" defer></script>
</head>
<body>
  <main>
    <section>
        <div class="hero-page">
            <header><?php include "components/_header.php"; ?></header>    
            <hgroup class="text-overlay">
                <h1 class="title-page">Les Campings</h1>
                <p>
                    Profitez de la nature, des paysages méditerranéens et d'une expérience inoubliable dans le sud de la France en
                    séjournant dans l'un nos campings proches des calanques, offrant un cadre naturel et paisible pour vos vacances.
                </p>
            </hgroup>
        </div>
    </section>

    <section class="title-and-toggle-container">
        <h2>Séjournez dans un camping près des Calanques</h2>
        <div class="container-toggle">
            <p>Uniquement campings ouverts</p>
            <label class="toggle">
                <input class="toggle-checkbox" type="checkbox" id="toggle">
                <span class="toggle-switch"></span>
            </label>
        </div>
    </section>
    
    <!-- <?php if (!empty($campsites)): ?>
        <div class="camping-grid">
            <?php foreach ($campsites as $campsite): ?>
                <div class="camping-item">
                <a href="campsiteDetails?id=<?= htmlspecialchars($campsite['campsite_id']); ?>">
                    <img src="../<?= htmlspecialchars($campsite['image']); ?>" alt="Image de <?= htmlspecialchars($campsite['name']); ?>">
                </a>

                <a href="campsiteDetails?id=<?= htmlspecialchars($campsite['campsite_id']); ?>" class="campsite-name">
                    <?= htmlspecialchars($campsite['name']); ?>
                </a>
                
                <p><span class="location-icon">&#x1F4CD;</span> <?= htmlspecialchars($campsite['address'] ?? '') . ', ' . htmlspecialchars($campsite['city'] ?? '') . ' ' . htmlspecialchars($campsite['zipcode'] ?? ''); ?></p>
                    
                <p>
                    <span class="shortText"><?= substr(htmlspecialchars($campsite['description']), 0, 100); ?></span>
                    <span class="longText" style="display: none;"><?= substr(htmlspecialchars($campsite['description']), 100); ?></span>
                    <span class="show-more" data-id="<?= htmlspecialchars($campsite['campsite_id']); ?>">Voir plus</span>
                </p>
                    

                    <div class="campsite-status">
                        <?php if ($campsite['isClosed']): ?>
                            <span class="status-icon">&#x1F534;</span>
                            Fermé
                        <?php elseif ($campsite['availability'] === 'Camping complet'): ?>
                            <span class="status-icon">&#x1F534;</span>
                            Complet
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
    <?php endif; ?> -->
    
</main>


    <section id="overflow" class="camping-grid">
        <!-- Les éléments seront injectés ici -->
    </section>


    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

    <script src="assets/script/campsite.js"></script>
</body>
</html>
