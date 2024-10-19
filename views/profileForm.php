<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de profil</title>
    <link rel="stylesheet" href="/parcNational/assets/style/user/profile_form.css">
</head>
<body>
    <header>
    <?php include "components/_header.php"; ?>
    </header>
    <h1>Modifier vos données</h1>
    <!--The profile form for current user's information updating -->
    <form class="form" action="/parcNational/update-profile" method="post">
        <section class="form_container">
            <!-- First section conteining civil datas-->  
            <section class="civil">
                <h2>Civilités</h2>
                <div>
                    <label for="inputLastname">Nom</label>
                    <input type="text" name="lastname" placeholder="Votre Nom" value="<?= isset($userData['lastname']) ? htmlspecialchars($userData['lastname']): '';  ?>" required>
                </div>
                <div>
                    <label for="inputFirstname">Prénom</label>
                    <input type="text" name="firstname" placeholder="Votre Prénom" value="<?= isset($userData['firstname']) ? htmlspecialchars($userData['firstname']): ''; ?>" required>
                </div>
                <div>
                    <label for="inputPhone">Téléphone</label>
                    <input type="tel" name="phone" placeholder="Votre numéro de téléphone" value="<?= isset($userData['phone']) ? htmlspecialchars($userData['phone']): ''; ?>">
                </div>
            </section>
            <!-- Second section conteining address datas--> 
            <section class="address">
                <h2>Adresse</h2>
                <div>
                    <label for="inputAddress">Adresse</label>
                    <input type="text" name="address" placeholder="Votre adresse" value="<?= isset($userData['address']) ? htmlspecialchars($userData['address']): ''; ?>" >
                </div>
                <div>
                    <label for="inputCity">Ville</label>
                    <input type="text" name="city" placeholder="Ville" value="<?= isset($userData['city']) ? htmlspecialchars($userData['city']): ''; ?>" >
                </div>
                <div>
                    <label for="inputZipcode"> Code postal</label>
                    <input type="text" name="zipcode" placeholder="Votre code postale" value="<?= isset($userData['zipcode']) ? htmlspecialchars($userData['zipcode']): ''; ?>">
                </div>

                <input class="button" type="submit" value= "Mettre à jour les données">
            </section>
        </section>
    </form>        
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>