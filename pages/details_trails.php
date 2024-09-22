<?php

include '../class/connectBDD.php';
include '../request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

// Passer la connexion PDO aux fonctions
$trails = get_all_trails($connectBDD);

// Récupérer l'ID depuis l'URL
$trail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer le sentier correspondant à l'ID
$trail = null;
if ($trail_id > 0) {
    $trail = get_trails_id($connectBDD, $trail_id);
    $trail_time = get_trails_time($connectBDD, $trail_id);
    $trail_lenght = get_trails_km($connectBDD, $trail_id);
    $trail_description = get_trails_description($connectBDD, $trail_id);
    $trail_difficulty = get_trails_difficulty($connectBDD, $trail_id);
    $trail_state = get_trails_status($connectBDD, $trail_id);
    $landmarks = get_trails_landmarks($connectBDD, $trail_id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Trails</title>
</head>
<body>
    <header></header>
    <main>
        <h1><?php echo $trail ? htmlspecialchars($trail['name']) : "Sentier non trouvé"; ?></h1>

        <section>
            <div class="hero_trail">
                <h1>Hero</h1>
                <img src="../<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>" width="200">
            </div>
            <div class="details_trail">
                <div>
                    <img src="../assets/icon/time.svg" alt="icon time">
                    <p><?php echo ($trail['time']) ?></p>
                </div>
                <div>
                    <img src="../assets/icon/hiking.svg" alt="icon length">
                    <p><?php echo ($trail['length_km']) ?></p>
                </div>
                <div>
                    <?php
                        $image_path = "";
                        $difficulty_from_db = $trail['difficulty'];

                        switch ($difficulty_from_db) {
                            case "Facile":
                                $image_path = "../assets/icon/shoes-green.svg";
                                break;
                            case "Moyen":
                                $image_path = "../assets/icon/shoes-orange.svg";
                                break;
                            case "Difficile":
                                $image_path = "../assets/icon/shoes-red.svg";
                                break;
                            default:
                                // Image par défaut si difficulté inconnue
                                $image_path = "../assets/icon/shoes-default.svg";
                                break;
                        }
                    ?>
                    <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($trail['difficulty']) ?>">
                    <p><?php echo htmlspecialchars($trail['difficulty']); ?></p>
                </div>
                </div>
                <div>
                    <?php
                        $image_path = "";
                        $status_from_db = $trail['status'];

                        switch ($difficulty_from_db) {
                            case "active":
                                $image_path = "../assets/icon/circle-green.svg";
                                break;
                            case "work":
                                $image_path = "../assets/icon/circle-orange.svg"; // Peut-être une autre image ?
                                break;
                            case "inactive":
                                $image_path = "../assets/icon/circle-red.svg"; // Peut-être une autre image ?
                                break;
                            default:
                                // Image par défaut si difficulté inconnue
                                $image_path = "../assets/icon/circle-green.svg";
                                break;
                        }
                    ?>
                    <img src="<?php echo htmlspecialchars($image_path) ?>" alt="<?php echo htmlspecialchars($trail['status'] ?? 'Statut inconnu'); ?>">
                </div>
            </div>
        </section>

        <section>
            <h2>Détails du sentier</h2>
            <p><?php echo($trail['description']) ?></p>
        </section>

        <section>
            <h2>Map</h2>
            <p>Intégrer la map interactive</p>
        </section>

    <section>
        <h2>Points de vue</h2>
            <?php foreach ($landmarks as $landmark): ?>
            <div class="card_landmarks">
                <p><?php echo htmlspecialchars($landmark['name'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endforeach; ?>
    </section>

        <section>
            <style>
                .slider_elements{
                    display : flex;
                    flex-direction : row;
                    justify-content : center;
                    align-items : center;
                    gap : 20px;
                    overflow : scroll;
                    overflow-y : hidden;
                    height : 300px;                     
                }
            </style>
            <h2>Slider des autres sentiers</h2>
            <div class="slider">
                <div class="slider_elements">
                    <?php foreach ($trails as $trail): ?>
                        <div class="card_trails">
                            <a href="./details_trails.php?id=<?php echo urlencode($trail['trail_id']); ?>">
                                <p><?php echo htmlspecialchars($trail['name']); ?></p>
                                <img src="../<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>" width="200">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>
</body>
</html>