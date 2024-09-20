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
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur, quidem fugiat dolorum illum doloremque autem!</p>
        </section>

        <section>
            <h2>Filtre</h2>
            <p>Faire la fonction pour le filtre en JavaScript</p>
        </section>

        <section>
            <h2>Overflow</h2>
            <p>pour rendre cliquable il faut d'abord mettre chaque sentier dans un card</p>
                <?php foreach ($trails as $trail): ?>
                    <div class="card">
                        <a href="">
                            <p><?php echo htmlspecialchars($trail['name']); ?></p>
                            <img src="<?php echo ($trail['image']); ?>" alt="<?php echo($trail['name']); ?>" width="200">
                        </a>
                            <p><?php echo htmlspecialchars($trail['length_km']); ?></p>
                            <p><?php echo htmlspecialchars($trail['time']); ?></p>
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