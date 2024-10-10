<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/user/view-available-memberships.css">
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
    <h1>Carte d'adhésion</h1>
    <main>
        <p class="text"><strong>
            Carte d'adhésion du Parc National des Calanques : Profitez de la nature tout en économisant !</strong><br><br>
            Le Parc National des Calanques, célèbre pour ses paysages époustouflants et ses richesses naturelles,
            vous propose une carte d'adhésion unique avec abonnement. En tant que membre, vous bénéficiez d'avantages
            exclusifs, dont une réduction de 20 % sur une variété d'activités passionnantes.<br>
            Que vous soyez amateur d'aventure ou à la recherche de détente,
            l'adhésion vous ouvre les portes à des offres exceptionnelles, telles que :<br>
            <strong>Via Ferrata :</strong><strong>Via Ferrata :</strong> Pour ceux qui aiment l'escalade et les sensations fortes, explorez les magnifiques falaises des Calanques en toute sécurité. <a href="https://example.com/via-ferrata" target="_blank">Cliquez ici pour en savoir plus.</a><br><br>
            <strong>Location de kayaks : </strong> Naviguez à travers les eaux cristallines et découvrez des criques isolées et des plages secrètes.<a href="https://cassis-kayak-marseille.fr/" target="_blank">Cliquez ici pour en savoir plus.</a><br><br>
            <strong>Croisières autour des Calanques :</strong> Embarquez pour une aventure maritime inoubliable autour des plus beaux paysages côtiers de la région.<a href="https://www.croisieres-marseille-calanques.com/" target="_blank">Cliquez ici pour en savoir plus.</a><br><br>
            <strong>Choisissez parmi nos abonnements adaptés à tous les besoins :</strong><br><br>
            Abo 3 mois : Pour une découverte courte mais intense du parc.<br>
            Abo 6 mois : Idéal pour ceux qui souhaitent explorer les Calanques tout au long de l'année.<br>
            Abo 12 mois : L'option parfaite pour les passionnés de nature qui désirent profiter des avantages pendant toute une année.<br><br>
            Rejoignez la communauté des amoureux des Calanques et vivez des expériences mémorables tout en bénéficiant de réductions attractives sur les activités qui font la renommée de ce lieu magique !
        </p>
        <h1>Choisissez un abonnement</h1>
        <div class="main-container">
            <div class="hexagon-container">
                <?php foreach ($memberships as $membership): ?>
                    <div class="hexagon-border border-blue">
                        <div class="hexagon">
                            <form method="POST" action="subscribe-membership">
                                <input type="hidden" name="membership_id" value="<?= htmlspecialchars($membership['card_id']) ?>">
                                <input type="hidden" name="membership_name" value="<?= htmlspecialchars($membership['memberships_name']) ?>">
                                <input type="hidden" name="membership_price" value="<?= htmlspecialchars($membership['price'] * 100) ?>">
                                <button type="submit" style="background: none; border: none; color: white; cursor: pointer;">
                                    <?= htmlspecialchars($membership['memberships_name']) ?>
                                    <p><?= htmlspecialchars($membership['duration']) ?> mois</p>
                                    <p><?= htmlspecialchars($membership['price']) ?> EUR</p>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>   
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>
