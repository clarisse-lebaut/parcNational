<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Trails</title>
    <!-- pour la carte leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" defer></script>
    <!-- réalisé -->
    <script src="/parcNational/assets/script/map.js" defer></script>
    <link rel="stylesheet" href="assets/style/user/details_trails.css">
    <link rel="stylesheet" href="assets/style/user/map.css">
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <main>
        <section class="hero_container">
            <h1><?php echo $trail ? htmlspecialchars($trail['name']) : "Sentier non trouvé"; ?></h1>

            <div class="trails_hero">
                <img class="trail_image" src="<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>">
            </div>
            
            <div class="trails_main_info">
                
                
                <div class="trails_infos">
                    <!-- Description du sentier -->
                    <div>
                        <h2>Description du sentier</h2>
                        <p><?php echo($trail['description']) ?></p>
                    </div>
                    <!-- Informations sur le sentier -->
                    <div>
                        <h2>Informations sur le sentier</h2>
                        <p><?php echo htmlspecialchars($trail['infos']); ?></p>
                    </div>
                    <!-- Accéder au sentier -->
                    <div>
                        <h2>Accéder au sentier</h2>
                        <p><?php echo htmlspecialchars($trail['acces']); ?></p>
                    </div>
                    <!-- Détails des conditions du sentier -->
                    <div>
                        <h2>Détails du sentier</h2>
                        <div class="trails_icons">
                            <!-- Icon du temps -->
                            <div>
                                <img src="assets/icon/time.svg" alt="icon time">
                                <p><?php echo ($trail['time']) ?></p>
                            </div>
                            <!-- Icon de la longueur -->
                            <div>
                                <img src="assets/icon/hiking.svg" alt="icon length">
                                <p><?php echo ($trail['length_km']) ?></p>
                            </div>
                            <!-- Icone de la difficilté -->
                            <div>
                                <?php
                                    $image_path = "";
                                    $difficulty_from_db = $trail['difficulty'];

                                    switch ($difficulty_from_db) {
                                        case "Facile":
                                            $image_path = "assets/icon/shoes-green.svg";
                                            break;
                                        case "Moyen":
                                            $image_path = "assets/icon/shoes-orange.svg";
                                            break;
                                        case "Difficile":
                                            $image_path = "assets/icon/shoes-red.svg";
                                            break;
                                        default:
                                            // Image par défaut si difficulté inconnue
                                            $image_path = "assets/icon/shoes-default.svg";
                                            break;
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($trail['difficulty']) ?>">
                                <p><?php echo htmlspecialchars($trail['difficulty']); ?></p>
                            </div>
                            <!-- Icone du statut -->
                            <div>
                                <?php
                                    $image_path = "";
                                    $status_from_db = $trail['status'];

                                    switch ($difficulty_from_db) {
                                        case "active":
                                            $image_path = "assets/icon/circle-green.svg";
                                            break;
                                        case "work":
                                            $image_path = "assets/icon/circle-orange.svg"; // Peut-être une autre image ?
                                            break;
                                        case "inactive":
                                            $image_path = "assets/icon/circle-red.svg"; // Peut-être une autre image ?
                                            break;
                                        default:
                                            // Image par défaut si difficulté inconnue
                                            $image_path = "assets/icon/circle-green.svg";
                                            break;
                                    }
                                ?>
                                <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($trail['status'] ?? 'Statut inconnu'); ?>">
                                <p><?php echo htmlspecialchars($trail['status']);?></p>
                            </div>
                        </div>
                    </div>


                    <div class="trails_icons">

                    </div>
                </div>
           
            </div>

        </section>

        <section class="map_container">
            <h2>Map</h2>
            <div id="map"></div>
        </section>

        <section class="landmark_container">
            <h2>Points de vue</h2>
            <div class="card_landmarks_container">
                <?php foreach ($landmarks as $landmark): ?>
                    <div class="card_landmarks">
                        <div class="card_landmarks_title">
                            <p><?php echo htmlspecialchars($landmark['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div>
                            <p><i><?php echo htmlspecialchars($landmark['location'], ENT_QUOTES, 'UTF-8'); ?></i></p>
                        </div>
                        <div>
                            <p><?php echo htmlspecialchars($landmark['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

<section class="other_trails">
    <h2>Slider des autres sentiers</h2>
    <div class="slider">
        <div class="slider_elements">
            <?php foreach ($trails as $trail): ?>
                <div class="card_trails">
                    <a href="details_trails?id=<?php echo urlencode($trail['trail_id']); ?>">
                        <p><?php echo htmlspecialchars($trail['name']); ?></p> <!-- Affiche le nom -->
                        <img class="pic-slider" src="<?php echo htmlspecialchars($trail['image']); ?>" alt="<?php echo htmlspecialchars($trail['name']); ?>" width="200"> <!-- Affiche l'image -->
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    </main>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>