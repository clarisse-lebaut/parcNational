
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiment réussi</title>
    <link rel="stylesheet" href="/assets/style/payment-succes.css">
    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = 'profile'; 
        }, 5000); 
    </script>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <main>
        <div class="main-container">
            <h2> Paiement réussi !</h2>
            <p><?php echo htmlspecialchars($message); ?></p>
            <p>Vous serez redirigé vers la page de profil dans quelques secondes...</p>
            <a href="profile">Cliquez ici si vous n'êtes pas redirigé automatiquement</a>
        </div>
    </main>
    <footer>
      <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>