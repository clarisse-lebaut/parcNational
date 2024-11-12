<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $isEdit ? 'Modifier Administrateur' : 'Créer Administrateur'; ?></title>
    <link rel="stylesheet" href="assets/style/admin/manage.css">
    <link rel="stylesheet" href="assets/style/admin/create.css">
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    
    <main>
        
        <p><?php echo $isEdit ? 'Modifier un Administrateur' : 'Créer un Administrateur'; ?></p>
        <section>
            <form action="" method="POST">
                <?php if ($isEdit && isset($adminData['user_id'])): ?>
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($adminData['user_id']); ?>">
                <?php endif; ?>
                <section>
                    <div>
                        <p>Adresse</p>
                        <label for="address">Adresse :</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($isEdit ? $adminData['address'] : ''); ?>" required><br>

                        <label for="city">Ville :</label>
                        <input type="text" name="city" value="<?php echo htmlspecialchars($isEdit ? $adminData['city'] : ''); ?>" required><br>

                        <label for="zipcode">Code Postal :</label>
                        <input type="text" name="zipcode" value="<?php echo htmlspecialchars($isEdit ? $adminData['zipcode'] : ''); ?>" required><br>
                    </div>
                    
                    <div>
                        <p>Profil admin</p>
                        <label for="lastname">Nom de famille :</label>
                        <input type="text" name="lastname" value="<?php echo htmlspecialchars($isEdit ? $adminData['lastname'] : ''); ?>" required><br>
                    
                        <label for="firstname">Prénom :</label>
                        <input type="text" name="firstname" value="<?php echo htmlspecialchars($isEdit ? $adminData['firstname'] : ''); ?>" required><br>
                        
                        <label for="phone">Téléphone :</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($isEdit ? $adminData['phone'] : ''); ?>" required><br>
                    </div>

                    <div>
                        <p>Infomration de connexion</p>
                        <label for="mail">Email :</label>
                        <input type="email" name="mail" value="<?php echo htmlspecialchars($isEdit ? $adminData['mail'] : ''); ?>" required><br>
                        
                        <label for="password">Mot de passe (laisser vide pour conserver) :</label>
                        <input type="password" name="password"><br>
                    </div>
                </section>

                <section>
                    <button type="submit"><?php echo $isEdit ? 'Modifier' : 'Créer'; ?></button>
                </section>
            </form>
        </section>
    </main>
</body>
</html>
