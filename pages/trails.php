<?php

include '../class/connectBDD.php';
include '../request/request.php';

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
        <h1>Titre : Détail < Nom du sentier ></h1>

<?php

include '../class/connectBDD.php';
include '../request/request.php';

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
        <h1>Titre : Détail < Nom du sentier ></h1>

        <section>
            <h1>Hero</h1>
            <img src="" alt="image du <nom du sentier>">
            <p>Icones des détails du sentier : difficulté, temps, kilométrage, status</p>
        </section>

        <section>
            <h2>Détails du sentier</h2>
            <p>Faire une requête pour récupérer la description du sentier</p>
        </section>

        <section>
            <h2>Points de vues</h2>
            <p>Faire une requête pour récupérer les points de vues prés de ce sentiers</p>
        </section>

        <section>
            <h2>Slider des autres sentiers</h2>
            <p>Utiliser la requête getAllTrails pour récupérer tous les sentiers dans la base de données</p>
            <p>Les rendre cliquable afin de rediriger vers la page détails d'un autre sentier</p>
        </section>
    </main>
    <footer></footer>
</body>
</html>