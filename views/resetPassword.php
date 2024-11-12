<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement de mot de passe</title>
    <link rel="stylesheet" href="assets/style/reset-password.css">
    <script src="assets/script/resetPassword.js" defer></script>
</head>
<body>
    <body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>

    <?php if (isset($message)): ?>
        <div class="alert-container">
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        </div>
    <?php endif; ?>
    <main>
        <div class="main-container">
            <h2>Changer votre mot de passe</h2>
            <div class="form-container">
                <form method="POST" action="/parcNational/reset-password" autocomplete="off">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? $_POST['token']); ?>" required>
                    <div class="form-group">
                        <label for="inputPassword"><p>Nouveau mot de passe</p></label>
                        <input type="password" name="new_password" class="form-control" id="inputPassword2" required autocomplete="new-password">
                    </div>
                    
                    <div class="form-group">
                        <label for="inputRepeatPassword"><p>Répétez le mot de passe</p></label>
                        <input type="password" name="repeat_password" class="form-control" id="inputRepeatPassword2"  required autocomplete="new-password">
                        <div id="passwordError" class="error-message">Les mots de passe ne correspondent pas.</div>
                    </div>
                    <button class="register-button" type="submit"><p>Changer le mot de passe</p></button>
                </form>
            </div>
        </div>
    </main>
    <footer>
          <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>
