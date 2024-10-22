<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/view-available-memberships.css">
    <title>Abonnements Disponibles</title>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>


    <?php if (isset($message)): ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    
    <main>
        <h1>Nos abonnements</h1>

        <section>  
            <h2>Cartes d'adhésion</h2>
        
            <p><strong>Carte d'adhésion du Parc National des Calanques : Profitez de la nature tout en économisant !</strong></p>
            <p>
                Le Parc National des Calanques, célèbre pour ses paysages époustouflants et ses richesses naturelles,
                vous propose une carte d'adhésion unique avec abonnement. En tant que membre, vous bénéficiez d'avantages
                exclusifs, dont une réduction de 20 % sur une variété d'activités passionnantes.
            </p>
            <p>Que vous soyez amateur d'aventure ou à la recherche de détente, l'adhésion vous ouvre les portes à des offres exceptionnelles, telles que :</p>
                
            <section>
                <div>
                    <p><strong>Via Ferrata</strong></p>
                    <p>Pour ceux qui aiment l'escalade et les sensations fortes, explorez les magnifiques falaises des Calanques en toute sécurité.</p>                        <a href="https://example.com/via-ferrata" target="_blank">Cliquez ici pour en savoir plus.</a><br><br>
                </div>
                <div>
                    <p><strong>Location de kayaks</strong></p>
                    <p>Naviguez à travers les eaux cristallines et découvrez des criques isolées et des plages secrètes.</p>
                    <a href="https://cassis-kayak-marseille.fr/" target="_blank">Cliquez ici pour en savoir plus.</a>
                </div>
                <div>
                    <p><strong>Croisières autour des Calanques</strong></p>
                    <p>Embarquez pour une aventure maritime inoubliable autour des plus beaux paysages côtiers de la région.</p>
                    <a href="https://www.croisieres-marseille-calanques.com/" target="_blank">Cliquez ici pour en savoir plus.</a>
                </div>
            </section>
                
            <h2>Choisissez parmi nos abonnements adaptés à tous les besoins</h2>
                
            <section>
                <ul>
                    <li>
                        <strong>Abonnement de 3 mois</strong>
                        <p>Pour une découverte courte mais intense du parc.</p>
                    </li>
                    <li>
                        <p><strong>Abonnement de 6 mois</strong></p>
                        <p>Idéal pour ceux qui souhaitent explorer les Calanques tout au long de l'année.</p>
                    </li>
                    <li>
                        <p><strong>Abonnement de 12 mois</strong></p>
                        <p>L'option parfaite pour les passionnés de nature qui désirent profiter des avantages pendant toute une année.</p>
                    </li>
                </ul>
            </section>

            <p>
                Rejoignez la communauté des amoureux des Calanques et vivez des expériences mémorables tout en bénéficiant de réductions attractives sur les activités qui font la renommée de ce lieu magique !
            </p>
        </section>

        
        <h2>Sourscrire à un abonnement</h2>
        <div class="card_ship_container">
            <?php foreach ($memberships as $membership): ?>
                <div class="card_ship">
                    <form method="POST" action="subscribe-membership">
                        <input type="hidden" name="membership_id" value="<?= htmlspecialchars($membership['card_id']) ?>">
                        <input type="hidden" name="membership_name" value="<?= htmlspecialchars($membership['memberships_name']) ?>">
                        <input type="hidden" name="membership_price" value="<?= htmlspecialchars($membership['price'] * 100) ?>">
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">
                            <p><strong><?= htmlspecialchars($membership['memberships_name']) ?></strong></p>
                            <p><?= htmlspecialchars($membership['duration']) ?> mois</p>
                            <p><?= htmlspecialchars($membership['price']) ?> EUR</p>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>

    <script>
        // Sélectionner toutes les cartes
        const cards = document.querySelectorAll('.card_ship');

        // Fonction pour suivre la souris
        function moveCard(event) {
            const card = event.currentTarget; // L'élément sur lequel l'événement a été déclenché
            const { clientX, clientY } = event; // Récupère la position de la souris
            const { offsetWidth, offsetHeight } = card; // Dimensions de la carte
            const x = clientX - card.getBoundingClientRect().left; // Position X de la souris par rapport à la carte
            const y = clientY - card.getBoundingClientRect().top; // Position Y de la souris par rapport à la carte

            // Calculer l'angle de rotation
            const rotationX = ((y / offsetHeight) - 0.5) * 20; // Ajuster la valeur pour modifier l'effet
            const rotationY = ((x / offsetWidth) - 0.5) * -20; // Ajuster la valeur pour modifier l'effet

            // Appliquer la transformation
            card.style.transform = `rotateX(${rotationX}deg) rotateY(${rotationY}deg)`;
        }

        // Ajouter les événements pour chaque carte
        cards.forEach(card => {
            card.addEventListener('mousemove', moveCard);

            // Remettre la carte à sa position d'origine lorsque la souris quitte l'élément
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'rotateX(0deg) rotateY(0deg)';
            });
        });
    </script>

</body>
</html>
