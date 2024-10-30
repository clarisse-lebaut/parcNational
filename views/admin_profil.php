<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil Administrateur</title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'; ?>
    </header>

    <main>
        <p>Modifier mes informations</p>
        <section>
            <form action="" method="POST">
                <!-- ID caché pour identifier l'admin connecté -->
                <?php if (isset($adminData['user_id'])): ?>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($adminData['user_id']); ?>">
                <?php endif; ?>
                
                <section>

                <!-- Informations personnelles -->
                <div>
                    <p>Informations Personnelles</p>
                    
                    <label for="lastname">Nom :</label>
                    <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($adminData['lastname'] ?? ''); ?>" required>

                    <label for="firstname">Prénom :</label>
                    <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($adminData['firstname'] ?? ''); ?>" required>

                    <label for="phone">Téléphone :</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($adminData['phone'] ?? ''); ?>" required>
                </div>

                <!-- Informations habitation -->
                <div>
                    <p>Adresse</p>
                    <label for="address">Adresse :</label>
                    <input type="text" name="address" value="<?php echo htmlspecialchars($adminData['address'] ?? ''); ?>" required><br>

                    <label for="city">Ville :</label>
                    <input type="text" name="city" value="<?php echo htmlspecialchars($adminData['city'] ?? ''); ?>" required><br>

                    <label for="zipcode">Code Postal :</label>
                    <input type="text" name="zipcode" value="<?php echo htmlspecialchars($adminData['zipcode'] ?? ''); ?>" required><br>
                </div>

                <!-- Informations de connexion -->
                <div>
                    <p>Informations de Connexion</p>
                    
                    <label for="mail">Adresse e-mail :</label>
                    <input type="email" name="mail" id="mail" value="<?php echo htmlspecialchars($adminData['mail'] ?? ''); ?>" required>

                    <label for="password">Nouveau mot de passe :</label>
                    <input type="password" name="password" id="password">
                    <small>Laisser vide pour conserver le mot de passe actuel</small>
                </div>

                </section>

                <section>
                    <!-- Bouton de soumission -->
                    <button type="submit">Enregistrer les modifications</button>
                </section>

            </form>
        </section>
    </main>
</body>
</html>
