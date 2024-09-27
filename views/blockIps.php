<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Blocked IPs</title>
</head>
<body>
    <h1>Blocked IPs</h1>
    <ul>
        <?php foreach($blockedIps as $ip): ?>
            <li><?php echo $ip['ip']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
