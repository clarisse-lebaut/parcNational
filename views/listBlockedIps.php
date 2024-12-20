<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List des IPs bloqués</title>
    <link rel="stylesheet" href="/assets/style/ip-block.css">
</head>
<body>
    <header>
        <?php include "components/_header-admin.php"; ?>
    </header>
    <h2>List of Blocked IPs</h2>
    <ul>
        <?php if(!empty($blockedIps)): ?>
            <?php foreach($blockedIps as $ip): ?>
                <li><?php echo htmlspecialchars($ip['ip']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No blocked IPs found.</li>
        <?php endif; ?>
    </ul>
</body>
</html>
