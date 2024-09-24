// Initialisation de la carte Leaflet
var map = L.map("map").setView([43.2, 5.4522], 11); // Coordonnées de départ

// Ajouter une couche de tuiles OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Liste des fichiers GeoJSON
var geojsonFiles = ["../data/data_map.php", "../data/data_map_trails.php"];

// Utiliser Promise.all pour charger plusieurs fichiers GeoJSON
Promise.all(geojsonFiles.map((url) => fetch(url).then((response) => response.json())))
  .then((geojsonDataArray) => {
    // Boucler sur chaque fichier GeoJSON et l'ajouter à la carte
    geojsonDataArray.forEach((data) => {
      L.geoJSON(data).addTo(map);
    });
  })
  .catch((error) => console.error("Erreur lors du chargement des GeoJSON:", error));
