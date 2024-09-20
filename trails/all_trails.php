<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte Leaflet avec GeoJSON</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Carte Leaflet avec GeoJSON</h1>
    <div id="map"></div>

    <script>
        // Initialisation de la carte Leaflet
        var map = L.map('map').setView([43.2000, 5.4522], 11); // Coordonnées de départ

        // Ajouter une couche de tuiles OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Générer une couleur aléatoire
        function getRandomColor() {
            return '#' + Math.floor(Math.random() * 16777215).toString(16); // Génère une couleur hexadécimale
        }

        // Créer un objet qui stockera les couleurs attribuées à chaque sentier
        var trailColors = {};

        // Charger les données GeoJSON depuis le serveur
        fetch('./getalldata.php') // Remplacer par le chemin correct de ton fichier PHP
            .then(response => response.json())
            .then(data => {
                // Ajouter les sentiers (MultiLineString) sur la carte avec les données GeoJSON
                L.geoJSON(data, {
                    style: function (feature) {
                        // Vérifier si ce sentier a déjà une couleur attribuée
                        if (!trailColors[feature.properties.name]) {
                            // Si non, générer une nouvelle couleur et l'associer au sentier
                            trailColors[feature.properties.name] = getRandomColor();
                        }

                        // Appliquer la couleur associée à ce sentier
                        return {
                            color: trailColors[feature.properties.name], // Couleur unique par sentier
                            weight: 7
                        };
                    }
                }).addTo(map);
            })
            .catch(error => console.error('Erreur lors du chargement du GeoJSON:', error));
    </script>
</body>
</html>
