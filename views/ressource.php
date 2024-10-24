<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ressources Naturelles</title>
    <link rel="stylesheet" href="assets/style/user/ressource.css">
    <link rel="stylesheet" href="assets/style/config/_global.css">
    <link rel="stylesheet" href="assets/style/config/_filter.css">
    <script src="assets/script/filter/filter-ressources.js" defer></script>
</head>
<body>
    <main>
        <section>
            <div class="hero-page">
                <header><?php include "components/_header.php"; ?></header>    
                <hgroup class="text-overlay">
                    <h1 class="title-page">Les Ressources Naturelles</h1>
                    <p>
                        De nombreuses espèces végétales et animales rares habitent ces lieux, accessibles aux visiteurs curieux de la faune et de la flore locales.
                        Que vous soyez amateur de biodiversité ou simplement en quête de connaissances,
                        <br>
                        chaque visite offre un aperçu fascinant des écosystèmes uniques entre terre et mer.
                    </p>
                </hgroup>
            </div>
        </section>

        <section>
            <div class="filter">
                <p>Filtrer par :</p>
                <!-- Filtre pour toutes ressources terrestre -->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/hiking.svg" alt="Icon hiking">
                        <div>Ressources</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">
                        <input class="difficulty" type="checkbox" id="tag-facile" name="tag" value="Facile">
                        <label for="facile">Toutes</label><br>

                        <input class="difficulty" type="checkbox" id="tag-moyen" name="tag" value="Moyen">
                        <label for="moyen">Terrestres</label><br>

                        <input class="difficulty" type="checkbox" id="tag-difficile" name="tag" value="Difficile">
                        <label for="difficile">Marines</label><br>
                    </div>
                </div>

                <!-- Filtre par faune -->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/hiking.svg" alt="Icon hiking">
                        <div>Faune</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">
                        <input class="difficulty" type="checkbox" id="tag-facile" name="tag" value="Facile">
                        <label for="facile">Toutes</label><br>

                        <input class="difficulty" type="checkbox" id="tag-moyen" name="tag" value="Moyen">
                        <label for="moyen">Terrestres</label><br>

                        <input class="difficulty" type="checkbox" id="tag-difficile" name="tag" value="Difficile">
                        <label for="difficile">Marines</label><br>
                    </div>
                </div>
                <!-- Filtre par flore -->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/circle-default.svg" alt="Icon State">
                        <div>Flore</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">
                        <input class="difficulty" type="checkbox" id="tag-facile" name="tag" value="Facile">
                        <label for="facile">Toutes</label><br>

                        <input class="difficulty" type="checkbox" id="tag-moyen" name="tag" value="Moyen">
                        <label for="moyen">Terrestres</label><br>

                        <input class="difficulty" type="checkbox" id="tag-difficile" name="tag" value="Difficile">
                        <label for="difficile">Marines</label><br>
                    </div>
                </div>

                <button id="remove-filter" class="filter-btn">Retirer tous les filtres</button>
            </div>
        </section>

        <section>
            <div class="active-filter-container">
                <p>Filtres actif</p>
                <div id="active-filter" class="active-filter">
                    <div class="filter-check"></div>
                </div>
            </div>
        </section>

        <section>
            <div id="overflow" class="ressources-container">
            </div>
        </section>

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

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>

    <script src="../assets/javascript/ressources.js"></script>
</body>
</html>
