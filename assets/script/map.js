// Initialisation de la carte Leaflet
var map = L.map("map").setView([43.2, 5.4522], 11); // Coordonnées de départ

// Ajouter une couche de tuiles OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Charger les données GeoJSON depuis le serveur
fetch("../data/data_map.php") // Remplacer par le chemin correct de ton fichier PHP
  .then((response) => response.json())
  .then((data) => {
    // Ajouter le polygone sur la carte avec les données GeoJSON
    L.geoJSON(data).addTo(map);
  })
  .catch((error) => console.error("Erreur lors du chargement du GeoJSON:", error));
