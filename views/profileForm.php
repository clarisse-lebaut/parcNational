<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de profil</title>
    <link rel="stylesheet" href="/assets/style/user/profile_form.css">
    <script src="/assets/script/register.js" defer></script>
</head>
<body>
    <header>
    <?php include "components/_header.php"; ?>
    </header>
    <h1>Modifier vos données</h1>
    <?php if (isset($errorMessage)): ?>
    <div class="error-message" style="color: red;">
        <?= htmlspecialchars($errorMessage); ?>
    </div>
    <?php endif; ?>
    <!--The profile form for current user's information updating -->
    <form class="form" action="/update-profile" method="post">
        <section class="form_container">
            <!-- First section conteining civil data-->  
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
            <!-- Second section conteining address data--> 
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
            </section>
            <!-- Third section conteining connection data--> 
            <section class= "connect-data">
            <h2>Les données de connection</h2>
                <div class="connect-email">
                    <label for= "inputEmail">E-mail</label>
                    <input type="email" name="mail" id="inputEmail" placeholder="Votre e-mail" value="<?= isset($userData['mail']) ? htmlspecialchars($userData['mail']): ''; ?>">
                    <div id="emailError" class="error-message" style="display:none;"> L'email doit contenir '@' et être au format correct.</div>
                </div>
                <div class="connect-password">
                    <label for="inputPassword">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Mot de passe">
                    <div id="passwordError" class="error-message" style="display:none"> Le mot de passe doit contenir au moins 8 caractèrs, une majuscule, une minuscule, un chiffre et un caractère spécial.</div>
                </div>
                <div class="connect-repeat-password">
                    <label for="inputRepeatPassword">Répétez le mot de passes</label>
                    <input type="password" name="repeatpassword" class="form-control" id="inputRepeatPassword" placeholder="Répétez le mot de passe">
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