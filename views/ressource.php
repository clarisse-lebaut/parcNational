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
                <!-- Filtre par ressources-->
                <div class="dropdown">
                <button class="dropdown-btn">
                    <img src="assets/icon/hiking.svg" alt="Icon hiking">
                    <div>Ressources</div>
                    <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                </button>
                <div class="dropdown-content">
                    <input class="ressources" type="checkbox" id="tag-terrestre" name="tag" value="Terrestre">
                    <label for="tag-terrestre">Terrestres</label><br>

                    <input class="ressources" type="checkbox" id="tag-marine" name="tag" value="Marine">
                    <label for="tag-marine">Marines</label><br>

                    <input class="ressources" type="checkbox" id="tag-flore" name="tag" value="Flore">
                    <label for="tag-flore">Flore</label><br>

                    <input class="ressources" type="checkbox" id="tag-faune" name="tag" value="Faune">
                    <label for="tag-faune">Faune</label><br>
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
                        <input class="faune" type="checkbox" id="tag-faune-terrestre" name="tag" value="Faune Terrestre">
                        <label for="tag-faune-terrestre">Terrestres</label><br>

                        <input class="faune" type="checkbox" id="tag-faune-marine" name="tag" value="Faune Marine">
                        <label for="tag-faune-marine">Marines</label><br>
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
                        <input class="flore" type="checkbox" id="tag-flore-terrestre" name="tag" value="Flore Terrestre">
                        <label for="tag-flore-terrestre">Terrestres</label><br>

                        <input class="flore" type="checkbox" id="tag-flore-marine" name="tag" value="Flore Marine">
                        <label for="tag-flore-marine">Marines</label><br>
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
    </main>

    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>
</body>
</html>
