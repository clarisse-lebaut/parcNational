<!DOCTYPE html>
<html lang="fr">
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
        <img src="../assets/img/hero.jpg" alt="Bandeau du site du Parc National des Calanques" width="200px">
        <p>Présentation du site</p>
        <section>
            <h1>Catégories</h1>
            <style>
                .container-category{
                    display:flex;
                    flex-direction:row;
                    align-items:center;
                    justify-content:center;
                    gap:10px;
                }
                .card-home > img{
                    object-fit:cover;
                }
            </style>
            <div class="container-category">
                <div class="card-home">
                    <a href="#">
                        <p>Les calanques</p>
                        <img src="../assets/img/calanques.jpg" alt="image de présentation des calanques" width="200px">
                    </a>
                </div>
                <div>
                    <a href="#">
                        <p>Les ressources</p>
                        <img src="../assets/img/ressources.png" alt="image de présentation des ressources" width="200px">
                    </a>
                </div>
                <div>
                    <a href="#">
                        <p>Les sentiers</p>
                        <img src="../assets/img/trails.jpg" alt="image de présentation des trails" width="200px">
                    </a>
                </div>
                <div>
                    <a href="#">
                        <p>Les campings</p>
                        <img src="../assets/img/campsite.png" alt="image de présentation des campsite" width="200px">
                    </a>
                </div>
                <div>
                    <a href="#">
                        <p>La carte</p>
                        <img src="../assets/img/map.png" alt="image de présentation des map" width="200px">
                    </a>
                </div>
            </div>
        </section>
        <section>
            <h1>Actualités</h1>
            <div class="grid-container">
                <!-- faire une boucle qui récupére toute les actualités dans la base de donnée  -->
                <?php 
                
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>Faire le footer</p>
    </footer>
</body>
</html>