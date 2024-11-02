<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Paiement</title>
    <link rel="stylesheet" href="assets/style/_global.css">
    <link rel="stylesheet" href="assets/style/payment.css">
    <script src="assets/script/payment.js" defer></script>
</head>
<body>
    <header>
        <?php include __DIR__ . '/../components/_header.php'; ?>
    </header>
    <main>
        <h1 class="payment-title">Récapitulatif de la commande</h1>

        <div class="payment-container">
            <div class="payment-card">
                <h2>Informations sur la réservation</h2>
                <b><?= htmlspecialchars($campsite['name']); ?></b>
                <p>Du <b><?= htmlspecialchars($start_date); ?></b> au <b> <?= htmlspecialchars($end_date); ?> </b> </p>
                <p> <b> <?= htmlspecialchars($num_persons); ?></b> personnes </p>
                <p>Prix total : <span id="payment-total_price"><?= htmlspecialchars($price); ?> €</span></p>
            </div>

            <div class="payment-card">
                <h2>Ajouter un code promo</h2>
                <form id="promo-form" method="POST">
                    <label for="promo_code">Code promo :</label>
                    <input type="text" id="promo_code" name="promo_code">
                    <button type="button" id="apply-promo">Appliquer</button>
                    <input type="hidden" id="final_price" name="price" value="<?= htmlspecialchars($price); ?>">
                    <p id="promo_error" style="color: red;"></p>
                </form>
            </div>

            <form id="payment-form" action="payment" method="POST">
            <input type="hidden" name="campsite_id" value="<?= $campsite_id; ?>">
                <input type="hidden" name="start_date" value="<?= htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?= htmlspecialchars($end_date); ?>">
                <input type="hidden" name="num_persons" value="<?= htmlspecialchars($num_persons); ?>">
                <input type="hidden" id="final_price_input" name="price" value="<?= htmlspecialchars($price); ?>">
                <button type="submit" name="confirm_payment">Payer</button>
            </form>
        </div>
    </main>
    <footer>
        <?php include __DIR__ . '/../components/_footer.php'; ?>
    </footer>
</body>
</html>
