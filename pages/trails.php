<?php

include '../class/connectBDD.php';
include '../request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

// Passer la connexion PDO à la fonction getAllTrails
$trails = get_trails_all($connectBDD);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trails</title>
    <script src="../scripts/filter_difficulty.js" defer></script>
    <script src="../scripts/filter_status.js" defer></script>
</head>
<body>
    <header></header>
    <main>
        <h1>Titre : Les Sentiers</h1>

        <section>
            <h2>Présentation de la page</h2>
            <p>
                Site naturel remarquable, le Parc national des Calanques – situé entre Marseille et Cassis – regorge d’endroits 
                d’exception. Arpenter les chemins est le meilleur moyen de découvrir les multiples facettes de ce parc national. 
                De nombreux chemins balisés sont accessibles pour les visiteurs en quête de randonnées. Quel que soit le niveau 
                de difficulté choisi, chaque itinéraire donne lieu à des paysages fabuleux entre mer et montagne.
            </p>
        </section>

        <section>
            <style>
                .filter{
                    display : flex;
                    flex-direction : row;
                    align-items: center;
                    gap: 10px;
                }
            </style>

            <div class="filter">
                <button class="filter-btn">Reset</button>
                <!-- difficulté -->
                <button class="filter-btn" data-filter-difficulty="Facile">Facile</button>
                <button class="filter-btn" data-filter-difficulty="Moyen">Moyen</button>
                <button class="filter-btn" data-filter-difficulty="Difficile">Difficile</button>
                
                <!-- km -->
                <button class="filter-btn" data-filter="km-up">km ordre croissant</button>
                <button class="filter-btn" data-filter="km-down">km ordre décroissant</button>           
                <div class="search-km">
                    <label for="km">Nombre de km</label>
                    <select name="km" id="lenght">
                        <option value="">-- distance</option>
                        <option value="">1km</option>
                        <option value="">2km</option>
                        <option value="">3km</option>
                        <option value="">4km</option>
                        <option value="">5km</option>
                        <option value="">6km</option>
                        <option value="">7km</option>
                        <option value="">8km</option>
                        <option value="">9km</option>
                        <option value="">10km</option>
                        <option value="">11km</option>
                        <option value="">12km</option>
                    </select>
                </div>
                
                <!-- temps -->
                <button class="filter-btn" data-filter="time-up">temps ordre croissant</button>
                <button class="filter-btn" data-filter="time-down">temps ordre décroissant</button>
                <div class="search-time">
                    <label for="km">Temps de marche</label>
                    <select name="time" id="time">
                        <option value="">--temps</option>
                        <option value="">1h</option>
                        <option value="">2h</option>
                        <option value="">3h</option>
                        <option value="">4h</option>
                        <option value="">5h</option>
                        <option value="">6h</option>
                        <option value="">7h</option>
                        <option value="">8h</option>
                        <option value="">9h</option>
                        <option value="">10h</option>
                        <option value="">11h</option>
                        <option value="">12h</option>
                    </select>
                </div>
                
                <!-- satus -->
                <button class="filter-btn" data-filter-status="active">Ouvert</button>
                <button class="filter-btn" data-filter-status="work">En travaux</button>
                <button class="filter-btn" data-filter-status="inactive">Fermé</button>
            </div>
        </section>

        <section>
            <style>
                .overflow{
                    height: 750px;
                    overflow: scroll;
                    overflow-x: hidden;
                }
            </style>
            <h2>Overflow</h2>
            <div id="overflow" class="overflow"></div>
        </section>
    </main>
    <footer></footer>
</body>
</html>