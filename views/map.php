<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="assets/style/user/map.css">
    <script src="assets/script/map/allMap.js" defer></script>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <main>
        <h1 style='margin-bottom:0;'>La Carte</h1>
        <section class="description-page">
            <p>Retrouver tous les sentiers et tout les points de vue présent au Parc National des Calanques !</p>
            <p></p>
        </section>

        <section class="map-container">
            <div id="map"></div>
        </section>
    </main>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>

