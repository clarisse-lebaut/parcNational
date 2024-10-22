<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La page d'accueil</title>
    <link rel="stylesheet" href="assets/style/config/_global.css">
    <link rel="stylesheet" href="assets/style/user/home.css">
</head>
<body>
    <main>
        <div>
            <div class="hero-container">
                <header><?php include "components/_header.php"; ?></header>
                <hgroup class="text-overlay">
                    <h1>Parc National des Calanques</h1>
                    <h2>Découvrir Marseille et ses merveilles</h2>
                </hgroup>
            </div>
        </div>
        
        <section class="presentation"> 
            <h3 class="presentation-title">Bonjour et bienvenue sur Parc'Appli, votre compagnon idéal pour explorer les plus beaux sentiers de randonnée et de camping des Calanques Marseillaises !</h3>
            <div>
                <p>Notre plateforme vous permet de vous connecter et de créer un compte personnalisé pour une expérience sur mesure.</p>
                <p>En tant qu'utilisateur enregistré, vous aurez la possibilité de :</p>
            </div>
            <article>
                <div>
                    <li>Sauvegarder et favoriser vos sentiers préférés afin de les retrouver facilement pour de futures aventures.</li>
                </div>
                <div>
                    <li>Accéder à une page dédiée aux ressources, où vous trouverez toutes les informations pratiques pour planifier vos 
                    excursions en toute sérénité.</li>
                </div>
                <div>
                    <li>Explorer les campings à proximité des sentiers, et même vous abonner pour recevoir des mises à jour et 
                    des recommandations sur les meilleurs spots où planter votre tente.</li>
                </div>
                <div>
                    <li>Consulter les détails des sentiers : distance, durée, difficulté et bien plus encore ! 
                    Vous aurez aussi accès à des points d'intérêttout au long du parcours, illustrés par des images pour mieux préparer vos découvertes.
                    </li>
                </div>
            </article>
            <div>
                <p>Rejoignez notre communauté de passionnés de plein air et commencez à planifier vos prochaines aventures dès aujourd'hui.</p>
                <p>Que vous soyez randonneur occasionnel ou aventurier chevronné, Parc'Appli est là pour vous guider pas à pas vers des moments inoubliables en pleine nature.</p>
            </div>
        </section>

        <section>
            <h2>Catégories</h2>
            <hr>
            <div class="container-category">

                <div class="card-home">
                    <a href="coves">
                        <div class="card-title">
                            <p>Les Calanques</p>
                        </div>
                    </a>
                </div>

                <div class="card-home">
                    <a href="ressources">
                        <div class="card-title">
                            <p>Les Ressources</p>
                        </div>
                    </a>
                </div>

                <div class="card-home">
                    <a href="trails">
                        <div class="card-title">
                            <p>Les Sentiers</p>
                        </div>
                    </a>
                </div>

                <div class="card-home">
                    <a href="campsite">
                        <div class="card-title">
                            <p>Les Campings</p>
                        </div>
                    </a>
                </div>

                <div class="card-home">
                    <a href="map">
                        <div class="card-title">
                            <p>La Carte</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section>
            <h2>Actualités</h2>
            <hr>
            <div class="news-container">
                <?php if (!empty($news)): ?>
                    <?php foreach($news as $datas): ?>
                        <article class="news-item"> <!-- Un conteneur pour chaque actualité -->
                            <img class="news-pic" src="<?php echo htmlspecialchars($datas['picture']); ?>" alt="Image de l'actualité" />
                            <p class="news-title"><?php echo htmlspecialchars($datas['title']); ?></p>
                            <div class="news-datetime">
                                <time class="news-date" datetime="<?php echo htmlspecialchars($datas['published_date']); ?>">le <i><?php echo htmlspecialchars($datas['published_date']); ?></i></time>
                                <time class="news-time" datetime="<?php echo htmlspecialchars($datas['published_time']); ?>">à <i><?php echo htmlspecialchars($datas['published_time']); ?></i></time>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune actualité à afficher.</p>
                <?php endif; ?>
            </div>
        </section>

    </main>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>