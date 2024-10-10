<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="/parcNational/assets/style/profile.css">
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <h1>Bienvenue sur ton profile</h1>
    <section>
        <div class="top-container">
            <div class="profile">
                <h3>Les données d'utilisateur</h3>
                <a href="profile-form">Modifier</a>
            </div>
            <div class="membership">
                <h2> Votre adhésion</h2>
                <?php if(!empty($availableMembership)): ?>
                    <div class="subscription">
                        <h3>Votre adhésion active:</h3>
                        <p> Mdme/M : 
                        <?php
                            echo !empty($availableMembership['lastname']) ? htmlspecialchars($availableMembership['lastname']) : 'N/A';
                        ?></p>       
                        <p>Identificateur: 
                        <?php
                            echo htmlspecialchars($availableMembership['random_id']); 
                        ?></p>
                        <p>Date de début: 
                        <?php 
                            $deliveryDate = new DateTime($availableMembership['delivery_date']);
                            echo htmlspecialchars($deliveryDate->format('Y-m-d H:i')); 
                        ?>
                        </p>
                        <p>Date d'expiration: 
                        <?php 
                            $expiryDate = new DateTime($availableMembership['expiry_date']);
                            echo htmlspecialchars($expiryDate->format('Y-m-d H:i'));
                        ?>
                        </p>
                    </div>
                <?php endif; ?>  
            </div>
        </div>
    </section>
    <section>
        <div class="favorites-trails">
            <h2> Tes favoris Sentiers </h2>
            <?php if(!empty($favoriteTrails)): ?>
                <?php foreach($favoriteTrails as $trail): ?>
                    <div class="trail-image">
                        <a href="details_trails?trail_id=<?= htmlspecialchars($trail['trail_id']) ?>">
                            <img class="img-profil" src="/parcNational/<?= htmlspecialchars($trail['image']) ?>" alt="la photo de sentier">
                        </a>
                        <div class="lien-container">
                        <a href="/parcNational/manage-favorite-trail?trail_id=<?= htmlspecialchars($trail['trail_id']) ?>">
                            <p class="delete">Supprimer</p>
                        </a>
                        </div>    
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p> Pas de sentiers dans le favoris</p>
            <?php endif; ?>                       
        </div>   
    </section>
    <footer>
      <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>