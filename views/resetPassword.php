<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer votre mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Changer votre mot de passe</h1>
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="/parcNational/reset-password" autocomplete="off">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']?? ''); ?>" required>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Mot de passe</label>
            <input type="password" name="new_password" class="form-control" id="inputPassword" placeholder="Nouveau mot de passe" required autocomplete="new-password">
        </div>
        <div class="mb-3">
            <label for="inputRepeatPassword" class="form-label">Répétez le mot de passe</label>
            <input type="password" name="repeat_password" class="form-control" id="inputRepeatPassword" placeholder="Répétez le mot de passe" required autocomplete="new-password">
            <div id="passwordError" class="error-message">Les mots de passe ne correspondent pas.</div>
        </div>
        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
    </form>
</body>
</html>
