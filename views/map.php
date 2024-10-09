<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="asset/style/user/map.css">
    <script src="assets/script/allMap.js" defer></script>
</head>
<body>
    <header>
        <?php include "components/_header.php"; ?>
    </header>
    <main>
        <h1>La Carte</h1>
        <style>
            #map {
                height: 90vh; /* Ajustez en fonction de votre mise en page */
                width: 100%;   /* Assurez-vous que la carte utilise toute la largeur */
                box-shadow : lightgray 0 5px 10px 0; 
            }
            .map_container{
                margin : 0 100px 100px 100px;
            }            
        </style>
        <section class="map_container">
            <div id="map"></div>
        </section>
    </main>
    <footer>
        <?php include "components/_footer.php"; ?>
    </footer>
</body>
</html>

