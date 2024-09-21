<?php

include '../class/connectBDD.php';
include '../request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

// Passer la connexion PDO aux fonctions
$trails = getAllTrails($connectBDD);
$trailsDifficulty = get_trails_difficulty($connectBDD);
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
        <h1>Titre : Détail < Nom du sentier ></h1>

        <section>
            <h1>Hero</h1>
            <p>image du sentier selon id de de l'url</p>
            <img src="" alt="">
            <div class="hero_trail">
                <img src="" alt="image du <nom du sentier>">
            </div>
            <div class="details_trail">
                <div>
                    <p>temps</p>
                    <img src="../assets/icon/time.svg" alt="icon time">
                </div>
                <div>
                    <p>longeur</p>
                    <img src="../assets/icon/hiking.svg" alt="icon length">
                </div>
                <div>
                    <p>difficuluté : condition selon la base de données</p>
                    <img src="../assets/icon/" alt="icon difficulty">
                </div>
                <div>
                    <p>état : condition selon la base de données</p>
                    <img src="" alt="icon status">
                </div>
            </div>
        </section>

        <section>
            <h2>Détails du sentier</h2>
            <p>Faire une requête pour récupérer la description du sentier</p>
        </section>

        <section>
            <h2>Map</h2>
            <p>Intégrer la map interactive</p>
        </section>

        <section>
            <h2>Points de vues</h2>
            <p>Faire une requête pour récupérer les points de vues prés de ce sentiers</p>
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
                        <div class="card">
                            <a href="">
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