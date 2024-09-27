<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trails</title>
    <link rel="stylesheet" href="/parcNational/assets/style/filter.css">
    <link rel="stylesheet" href="/parcNational/assets/style/trails.css">
    <script src="/parcNational/assets/script/filter.js" defer></script>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>

    <main>
        <section>
            <h2>Nos Sentiers</h2>
            <img src="assets/img/category_home/trails.jpg" alt="" width="200px">
            <p>
                Site naturel remarquable, le Parc national des Calanques – situé entre Marseille et Cassis – regorge d’endroits 
                d’exception. Arpenter les chemins est le meilleur moyen de découvrir les multiples facettes de ce parc national. 
                De nombreux chemins balisés sont accessibles pour les visiteurs en quête de randonnées. Quel que soit le niveau 
                de difficulté choisi, chaque itinéraire donne lieu à des paysages fabuleux entre mer et montagne.
            </p>
        </section>

        <section>
            <div class="filter">
                <p>Filtrer par :</p>
                <!-- Filtre pour les difficulté -->
                <div class="dropdown">
                    <button class="dropdown-btn"><div>Difficulté</div><img src="/parcNational/assets/icon/arrow-drop-down.svg" alt="icon arrow down"></button>
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
                    <button class="dropdown-btn"><div>Etats</div><img src="/parcNational/assets/icon/arrow-drop-down.svg" alt="icon arrow down"></button>
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
                    <button class="dropdown-btn"><div>Longueur du sentier</div><img src="/parcNational/assets/icon/arrow-drop-down.svg" alt="icon arrow down"></button>
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
                    <button class="dropdown-btn"><div>Temps de marche</div><img src="/parcNational/assets/icon/arrow-drop-down.svg" alt="icon arrow down"></button>
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
            <p>Filtre actif :</p>
            <div id="active-filter" class="active-filter">
                <div class="filter-check"></div>
            </div>
        </section>

        <section>
            <h2>Nos Sentiers</h2>
            <div id="overflow" class="overflow">
                <?php foreach ($trails as $trail): ?>
                    <div class="card_trails">
                        <div class="card_top">
                            <a href="details_trails?id=<?php echo urlencode($trail['trail_id']); ?>">
                                <p><?php echo htmlspecialchars($trail['name']); ?></p>
                                <img src="/parcNational/<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>" width="200">
                            </a>
                        </div>
                        <div class="card_details">
                            <div>
                                <img src="/parcNational/assets/icon/hiking.svg" alt="icon lenght">
                                <p><?php echo htmlspecialchars($trail['length_km']); ?></p>
                            </div>
                            <div>
                                <img src="/parcNational/assets/icon/time.svg" alt="icon time">
                                <p><?php echo htmlspecialchars($trail['time']); ?></p>

                            </div>
                            <div>
                                <?php
                                    $image_path ="";
                                    $difficulty = $trail['difficulty'];
                                    $easy = "/parcNational/assets/icon/shoes-green.svg";
                                    $medium = "/parcNational/assets/icon/shoes-orange.svg";
                                    $hard = "/parcNational/assets/icon/shoes-red.svg";
                                    $default = "/parcNational/assets/icon/shoes-default.svg";

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
                                            $image_path = "$easy";
                                            break;
                                        case 'Moyen':
                                            $image_path = "$medium";
                                            break;
                                        case 'Difficile':
                                            $image_path = "$hard";
                                            break;
                                        default:
                                            $image_path = "$default";
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
                                            $image_path = "/parcNational/assets/icon/$active";
                                            break;
                                        case 'work' : 
                                            $image_path = "/parcNational/assets/icon/$work";
                                            break;
                                        case 'inactive':
                                            $image_path = "/parcNational/assets/icon/$inactive";
                                            break;
                                        default:
                                            $image_path = "/parcNational/assets/icon/$active";
                                            break;
                                    }
                                ?>
                                <p><?php echo htmlspecialchars($trail['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                                <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($alt_text) ?>">
                            </div>
                        </div>
                        <button><img src="/parcNational/assets/icon/favorite-fill.svg" alt="heart icon">Ajouter au favoris</button>
                        <button><img src="/parcNational/assets/icon/hiking.svg" alt="">Ajouter à mes kilomètres</button>
                    </div>
                    <p><?php echo htmlspecialchars($trail['description']); ?></p>
                    <p><?php echo htmlspecialchars($trail['acces']); ?></p> 
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>