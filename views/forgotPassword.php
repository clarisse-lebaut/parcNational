<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="assets/style/forgot-password.css">
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <?php if (isset($message)): ?>
        <div class="message-container">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <div class="main-container">
        <form method="POST" action="/parcNational/reset-password-request">
            <input type="email" name="email" placeholder="Votre adres e-mail" required>
            <button type="submit">Réinitialiser le mot de passe.</button>
        </form>
    </div>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>    
</body>
</html>



