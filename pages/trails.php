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
            <h2>Filtre</h2>
            <p>Insérer la fonction pour le filtre en JavaScript</p>
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
            <div class="overflow">
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
                                <!-- Pour la ligne status = le risque que le paramètre dans la base de donnée
                                 soit nul provoque une erreur =
                                 il faut donc mettre un opérateur de fusion pour éviter les problèmes de sécurité
                                 
                                 //? ENT_QUOTES est une constante utilisée avec la fonction htmlspecialchars() en PHP 
                                 spécifie le type de guillemets à convertir en entités HTML.
                                  -->
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