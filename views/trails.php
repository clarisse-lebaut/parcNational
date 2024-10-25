<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trails</title>
    <link rel="stylesheet" href="assets/style/_global.css">
    <link rel="stylesheet" href="assets/style/config/_filter.css">
    <link rel="stylesheet" href="assets/style/user/trails.css">
    <script src="assets/script/filter/filter-trails.js" defer></script>
</head>
<body>
    <main>
        <section>
            <div class="hero-page">
                <header><?php include "components/_header.php"; ?></header>    
                <hgroup class="text-overlay">
                    <h1 class="title-page">Les Sentiers</h1>
                    <p>
                        Arpenter les chemins est le meilleur moyen de
                        <br>
                        découvrir les multiples facettes de ce parc national.
                    </p>
                    <p>
                        De nombreux chemins balisés sont accessibles pour les visiteurs en quête de randonnées. 
                        Quel que soit le niveau de difficulté choisi, 
                        <br>
                        chaque itinéraire donne lieu à des paysages fabuleux entre mer et montagne.
                    </p>
                </hgroup>
            </div>
        </section>

        <section>
            <div class="filter">
                <p>Filtrer par :</p>
                <!-- Filtre pour les difficulté -->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/hiking.svg" alt="Icon hiking">
                        <div>Difficulté</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">
                        <input class="difficulty" type="checkbox" id="tag-facile" name="tag" value="Facile">
                        <label for="facile">Facile</label><br>

                        <input class="difficulty" type="checkbox" id="tag-moyen" name="tag" value="Moyen">
                        <label for="moyen">Moyen</label><br>

                        <input class="difficulty" type="checkbox" id="tag-difficile" name="tag" value="Difficile">
                        <label for="difficile">Difficile</label><br>
                    </div>
                </div>
                <!-- Filtre pour les états du sentier-->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/circle-default.svg" alt="Icon State">
                        <div>Etats</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">
                        <input class="status" type="checkbox" id="active" name="tag" value="active">
                        <label for="active">Ouvert</label><br>

                        <input class="status" type="checkbox" id="work" name="tag" value="work">
                        <label for="work">En travaux</label><br>

                        <input class="status" type="checkbox" id="inactive" name="tag" value="inactive">
                        <label for="inactive">Fermé</label><br>
                    </div>
                </div>
                <!-- Filtre pour les km-->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/shoes-default.svg" alt="Icon Lenght">
                        <div>Longueur du sentier</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">  
                        <!-- Boucle pour afficher toutes les distances -->
                        <div class="distance-options">
                            <label><input class="length" type="checkbox" id="1km" name="tag" value="1">1km</label>
                            <label><input class="length" type="checkbox" id="2km" name="tag" value="2">2km</label>
                            <label><input class="length" type="checkbox" id="3km" name="tag" value="3">3km</label>
                            <label><input class="length" type="checkbox" id="4km" name="tag" value="4">4km</label>
                            <label><input class="length" type="checkbox" id="5km" name="tag" value="5">5km</label>
                            <label><input class="length" type="checkbox" id="6km" name="tag" value="6">6km</label>
                            <label><input class="length" type="checkbox" id="7km" name="tag" value="7">7km</label>
                            <label><input class="length" type="checkbox" id="8km" name="tag" value="8">8km</label>
                            <label><input class="length" type="checkbox" id="9km" name="tag" value="9">9km</label>
                            <label><input class="length" type="checkbox" id="10km" name="tag" value="10">10km</label>
                            <label><input class="length" type="checkbox" id="11km" name="tag" value="11">11km</label>
                            <label><input class="length" type="checkbox" id="12km" name="tag" value="12">12km</label>
                        </div>
                    </div>
                </div>
                <!-- Filtre pour le temps de marche -->
                <div class="dropdown">
                    <button class="dropdown-btn">
                        <img src="assets/icon/time.svg" alt="Icon Time">
                        <div>Temps de marche</div>
                        <img src="assets/icon/arrow-drop-down.svg" alt="icon arrow down">
                    </button>
                    <div class="dropdown-content">  
                        <!-- Boucle pour afficher toutes les distances -->
                        <div class="distance-options">
                            <label><input class="time" type="checkbox" id="1:00:00" name="tag" value="1:00:00">1h</label>
                            <label><input class="time" type="checkbox" id="2:00:00" name="tag" value="2:00:00">2h</label>
                            <label><input class="time" type="checkbox" id="3:00:00" name="tag" value="3:00:00">3h</label>
                            <label><input class="time" type="checkbox" id="4:00:00" name="tag" value="4:00:00">4h</label>
                            <label><input class="time" type="checkbox" id="5:00:00" name="tag" value="5:00:00">5h</label>
                            <label><input class="time" type="checkbox" id="6:00:00" name="tag" value="6:00:00">6h</label>
                            <label><input class="time" type="checkbox" id="7:00:00" name="tag" value="7:00:00">7h</label>
                            <label><input class="time" type="checkbox" id="8:00:00" name="tag" value="8:00:00" >8h</label>
                            <label><input class="time" type="checkbox" id="9:00:00" name="tag" value="9:00:00">9h</label>
                            <label><input class="time" type="checkbox" id="10:00:00" name="tag" value="10:00:00">10h</label>
                            <label><input class="time" type="checkbox" id="11:00:00" name="tag" value="11:00:00">11h</label>
                            <label><input class="time" type="checkbox" id="12:00:00" name="tag" value="12:00:00">12h</label>
                            <!-- Répéter pour les autres distances -->
                        </div>
                    </div>
                </div>
                <button id="remove-filter" class="filter-btn">Retirer tous les filtres</button>
            </div>
        </section>

        <section>
            <div class="active-filter-container">
                <p>Filtres actifs :</p>
                <div id="active-filter" class="active-filter">
                    <div class="filter-check"></div>
                </div>
            </div>
        </section>

        <hr>
        
        <section>
            <h2 style="margin-left: 25px;">Nos Sentiers</h2>
            <div id="overflow" class="trails-container"></div>
        </section>
    </main>

    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>