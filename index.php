<?php

include 'class/connectBDD.php';
include 'request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$connectBDDInstance = new ConnectBDD();
$connectBDD = $connectBDDInstance->connectBDD();

// Passer la connexion PDO à la fonction getAllTrails
$trails = getAllTrails($connectBDD);
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
            <h2>Overflow</h2>
                <?php foreach ($trails as $trail): ?>
                    <div class="card">
                        <div class="card_top">
                            <a href="">
                                <p><?php echo htmlspecialchars($trail['name']); ?></p>
                                <img src="<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>" width="200">
                            </a>
                        </div>
                        <div class="card_details">
                            <p><?php echo htmlspecialchars($trail['length_km']); ?></p>
                            <p><?php echo htmlspecialchars($trail['time']); ?></p>
                        </div>
                        <!-- mettre des icônes -->
                        <button><img src="./assets/icon/favorite-fill.svg" alt="heart icon">Ajouter au favoris</button>
                        <button><img src="./assets/icon/hiking.svg" alt="">Ajouter à mes kilomètres</button>
                    </div>
                    <!-- <p><?php echo htmlspecialchars($trail['trail_id']); ?></p> -->
                    <!-- <p><?php echo htmlspecialchars($trail['description']); ?></p>
                    <p><?php echo htmlspecialchars($trail['status']); ?></p> -->
                    <!-- <p><?php echo htmlspecialchars($trail['infos']); ?></p>
                    <p><?php echo htmlspecialchars($trail['acces']); ?></p>  -->
                <?php endforeach; ?>
        </section>
    </main>
    <footer></footer>
</body>
</html>