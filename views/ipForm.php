<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/ip-form.css">
</head>
<body>
    <header>
        <?php include "components/_header-admin.php"; ?>
    </header>
    <?php if (isset($message)): ?>
        <div class="<?php echo htmlspecialchars($messageType); ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>
    <div class="container">
        <form method="post" action="/parcNational/ip-save">
            <input name="ip" placeholder=' Enter IP ' type='text'/>
            <button class="button-submit" type='submit'>Add IP</button>
        </form>
    </div>
</body>
</html>