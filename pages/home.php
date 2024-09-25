<?php
include_once '../request/request.php';

// Instancier la classe ConnectBDD et obtenir la connexion PDO
$pdo = new ConnectBDD();
$connectBDD = $pdo->connectBDD();

// Passer la connexion PDO à la fonction getAllTrails
$data = get_news($connectBDD);
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <header>
        <p>Faire la navabar</p>
    </header>
    <main>
        <h1>Parc National des Calanques</h1>
        <h2>Décrouvrez Marseille et ses merveilles</h2>
        <img src="../assets/img/category_home/hero.jpg" alt="Bandeau du site du Parc National des Calanques" width="200px">
        <p>Présentation du site</p>
        <section>
            <h1>Catégories</h1>
            <style>
                .container-category{
                    display:flex;
                    flex-direction:row;
                    justify-content:center;
                    gap:10px;
                    width: 100%;
                }
                .pic{
                    width: 150px;
                }
            </style>
            <div class="container-category">
                <div class="card-home">
                    <a href="#">
                        <p>Les calanques</p>
                        <div class="container-pic">
                            <img class="pic" src="../assets/img/category_home/calanques.jpg" alt="image de présentation des calanques">
                        </div>
                    </a>
                </div>
                <div class="card-home">
                    <a href="#">
                        <p>Les ressources</p>
                        <img class="pic" src="../assets/img/category_home/ressources.png" alt="image de présentation des ressources">
                    </a>
                </div>
                <div class="card-home">
                    <a href="#">
                        <p>Les sentiers</p>
                        <img class="pic" src="../assets/img/category_home/trails.jpg" alt="image de présentation des trails">
                    </a>
                </div>
                <div class="card-home">
                    <a href="#">
                        <p>Les campings</p>
                        <img class="pic" src="../assets/img/category_home/campsite.png" alt="image de présentation des campsite">
                    </a>
                </div>
                <div class="card-home">
                    <a href="#">
                        <p>La carte</p>
                        <img class="pic" src="../assets/img/category_home/map.png" alt="image de présentation des map">
                    </a>
                </div>
            </div>
        </section>
        <section>
            <h1>Actualités</h1>
            <div class="grid-container">
                <!-- faire une boucle qui récupére toute les actualités dans la base de donnée  -->
                <?php foreach($data as $datas){; ?>
                    <p><?php echo htmlspecialchars($datas['title']); ?></p>
                    <p><?php echo htmlspecialchars($datas['published_date']); ?></p>
                    <p><?php echo htmlspecialchars($datas['published_time']); ?></p>
                    <img class="pic" src="../<?php echo htmlspecialchars($datas['picture']); ?>" />
                <?php }?>
            </div>
        </section>
    </main>
    <footer>
        <p>Faire le footer</p>
    </footer>
</body>
</html>