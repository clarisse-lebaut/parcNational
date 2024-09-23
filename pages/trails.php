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
                <button class="filter-btn" data-filter="Facile">Facile</button>
                <button class="filter-btn" data-filter="Moyen">Moyen</button>
                <button class="filter-btn" data-filter="Difficile">Difficile</button>
                
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
                <button class="filter-btn" data-filter="active">Ouvert</button>
                <button class="filter-btn" data-filter="work">En travaux</button>
                <button class="filter-btn" data-filter="hard">Fermé</button>
            </div>
        </section>

        <section>
            <!-- <h1>TEST FILTRE</h1>
            <p>On essaie déjà de juste récupérer les valeurs définies dans la requête</p>
            <?php
            // Appel à la fonction pour récupérer les résultats
            $data = get_data_difficulty($connectBDD);
            
            // Affichage de l'une des valeurs (par exemple, première difficulté)
            // OK en fait la j'accède avec l'index à la valeur correspondante à la ligne dans la base de données
            if (!empty($data)) {
                echo '<p>' . htmlspecialchars($data[9]['difficulty']) . '</p>';
            } else {
                echo '<p>Aucune donnée trouvée</p>';
            }
            ?> -->
            <script>
                function click() {
                    const buttons = document.getElementsByClassName('filter-btn');

                    for (let i = 0; i < buttons.length; i++) {
                        buttons[i].addEventListener('click', function () {
                            const difficulty = buttons[i].textContent;

                            switch (difficulty) {
                                // effacer toos les filtres
                                case 'Reset':
                                    alert('Tout remettre à 0');
                                    break;
                                // boutons des difficulté
                                case 'Facile':
                                    alert('Facile est cliqué');
                                    break;
                                case 'Moyen':
                                    alert('Moyen est cliqué');
                                    break;
                                case 'Difficile':
                                    alert('Difficile est cliqué');
                                    break;
                                // boutons des status
                                case 'Ouvert':
                                    alert('Sentier ouvert');
                                    break;
                                case 'En travaux':
                                    alert('Sentier en travaux');
                                    break;
                                case 'Fermé':
                                    alert('Sentier fermé');
                                    break;
                                // boutons pour les kms
                                    // ordre croissant et décroissant
                                case 'km ordre croissant':
                                    alert('Ordre croissant des kilomètres');
                                    break;
                                case 'km ordre décroissant':
                                    alert('Ordre décroissant des kilomètres');
                                    break;
                                    // select par km

                                // bouton pour le temps de marche
                                case 'temps ordre croissant':
                                    alert('Ordre croissant du temps de marche');
                                    break;
                                case 'temps ordre décroissant':
                                    alert('Ordre décroissant du temps de marche');
                                    break;
                                default:
                                    break;
                            }
                        });
                    }
                };
                click();
            </script>
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
            <div id="overflow" class="overflow">
                <?php foreach ($trails as $trail): ?>
                    <div class="card">
                        <div class="card_top">
                            <a href="">
                                <p><?php echo htmlspecialchars($trail['name']); ?></p>
                                <img src="../<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>" width="200">
                            </a>
                        </div>
                        <div class="card_details">
                            <div>
                                <img src="../assets/icon/hiking.svg" alt="icon lenght">
                                <p><?php echo htmlspecialchars($trail['length_km']); ?></p>
                            </div>
                            <div>
                                <img src="../assets/icon/time.svg" alt="icon time">
                                <p><?php echo htmlspecialchars($trail['time']); ?></p>

                            </div>
                            <div>
                                <?php
                                    $image_path ="";
                                    $difficulty = $trail['difficulty'];
                                    $easy = "shoes-green.svg";
                                    $medium = "shoes-orange.svg";
                                    $hard = "shoes-red.svg";
                                    $default = "shoes-default.svg";

                                    $alt_text = '';
                                    if ($easy) {
                                        $alt_text = 'icon green shoes';
                                    } elseif ($medium) {
                                        $alt_text = 'icon orange shoes';
                                    } else {
                                        $alt_text = 'icon red shoes';
                                    }

                                    switch ($difficulty) {
                                        case 'Facile':
                                            $image_path = "../assets/icon/$easy";
                                            break;
                                        case 'Moyen':
                                            $image_path = "../assets/icon/$medium";
                                            break;
                                        case 'Difficile':
                                            $image_path = "../assets/icon/$hard";
                                            break;
                                        default:
                                            $image_path = "../assets/icon/$default";
                                            break;
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($alt_text) ?>">
                                <p><?php echo htmlspecialchars($trail['difficulty']); ?></p>
                            </div>
                            <div>
                                <?php
                                    $image_path = "";
                                    $status = $trail['status'];
                                    $active = "circle-green.svg";
                                    $work = "circle-orange.svg";
                                    $inactive = "circle-red.svg";

                                    $alt_text = '';
                                    if ($active){
                                        $alt_text = 'icon green circle';
                                    } elseif ($work){
                                        $alt_text = 'icon orange circle';
                                    } elseif ($inactive) {
                                        $alt_text = 'icon red circle';
                                    } else {
                                        $alt_text = 'no info available';
                                    }

                                    switch ($status) {
                                        case 'active':
                                            $image_path = "../assets/icon/$active";
                                            break;
                                        case 'work' : 
                                            $image_path = "../assets/icon/$work";
                                            break;
                                        case 'inactive':
                                            $image_path = "../assets/icon/$inactive";
                                            break;
                                        default:
                                            $image_path = "../assets/icon/$active";
                                            break;
                                    }
                                ?>
                                <p><?php echo htmlspecialchars($trail['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                                <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($alt_text) ?>">
                            </div>
                        </div>
                        <button><img src="../assets/icon/favorite-fill.svg" alt="heart icon">Ajouter au favoris</button>
                        <button><img src="../assets/icon/hiking.svg" alt="">Ajouter à mes kilomètres</button>
                    </div>
                    <p><?php echo htmlspecialchars($trail['description']); ?></p>
                    <p><?php echo htmlspecialchars($trail['acces']); ?></p> 
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer></footer>
</body>
</html>