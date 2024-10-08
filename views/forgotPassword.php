<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
</head>
<body>
    <?php if (isset($message)): ?>
        <div style="color: green;"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="/parcNational/reset-password-request">
    <input type="email" name="email" placeholder="Votre adres e-mail" required>
    <button type="submit">Réinitialiser le mot de passe.</button>
</form>
</body>
</html>



