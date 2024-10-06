<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Sentier avec Leaflet</title>
    <!-- <link rel="stylesheet" href="assets/style/manage.css"> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js" defer></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js" defer></script>
    <script src="assets/script/adminMap.js" defer></script>
</head>
<body>
    <header>
        <?php include 'components/_header-admin.php'?>
    </header>
    <main>
        <h1>Crée un nouveau sentier</h1>
        <style>
            .create_map_container{
                display:flex;
                flex-direction : row;
                justify-content : center;
                align-items:center;
                gap:25px;
            }
            form{
                display:flex;
                flex-direction : column;  
            }
            #map {
            height: 400px;
            width: 900px;
        }
        </style>
        <section class="create_map_container">
            <div id="form">
                <form action="">
                    <label for="">Nom du sentier</label>
                    <input type="text">
                    <label for="">Information</label>
                    <input type="text">
                    <label for="">Accès</label>
                    <input type="text">
                    <label for="">Km</label>
                    <input type="number">
                    <label for="">Temps</label>
                    <input type="datetime">
                    <label for="">Difficulté</label>
                    <select name="" id="">
                        <option value="">Chosir une ifficulté</option>
                        <option value="">Facile</option>
                        <option value="">Moyen</option>
                        <option value="">Difficile</option>
                    </select>
                    <label for="">Image</label>
                    <input type="file" accept="image/png, image/jpeg">
                    <label for="">Etat</label>
                    <select name="" id="">
                        <option value="">Etat</option>
                        <option value="">Ouvert</option>
                        <option value="">Fermé</option>
                    </select>
                </form>    
            </div>

            <div id="map"></div>
        </section>
    </main>
</body>
</html>
