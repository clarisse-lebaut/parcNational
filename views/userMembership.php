
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Membership</title>
</head>
<body>
    <?php if (isset($membership)): ?>
        <h3>Votre adhésion active:</h3>
        <p>Date de début: <?php echo htmlspecialchars($membership['delivery_date']); ?></p>
        <p>Date d'expiration: <?php echo htmlspecialchars($membership['expiry_date']); ?></p>
    <?php else: ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

</body>
</html>