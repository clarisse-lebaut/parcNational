// Initialisation de la carte Leaflet
var map = L.map("map").setView([43.2, 5.4522], 11); // Coordonnées de départ

// Ajouter une couche de tuiles OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Liste des fichiers GeoJSON
var geojsonFiles = ["../data/data_map.php", "../data/data_map_trails.php"];

// Récupérer l'ID du sentier depuis l'URL
const urlParams = new URLSearchParams(window.location.search);
const trailId = urlParams.get("id");

// Utiliser Promise.all pour charger plusieurs fichiers GeoJSON
Promise.all(geojsonFiles.map((url) => fetch(url).then((response) => response.json())))
  .then((geojsonDataArray) => {
    // Ajouter le premier fichier (data_map.php) à la carte (contours)
    L.geoJSON(geojsonDataArray[0]).addTo(map);

    // Boucler sur le second fichier (data_map_trails.php) pour récupérer uniquement le sentier spécifique
    const trailData = geojsonDataArray[1];

    // Vérifier si le sentier est présent dans le GeoJSON
    if (trailData.features.length > 0) {
      // Filtrer les sentiers selon l'ID
      const filteredTrail = {
        type: "FeatureCollection",
        features: trailData.features.filter((feature) => feature.properties.trail_id == trailId), // Filtrer par trail_id
      };

      // Vérifier si le sentier filtré n'est pas vide
      if (filteredTrail.features.length > 0) {
        // Ajouter le sentier filtré à la carte
        L.geoJSON(filteredTrail).addTo(map);
      } else {
        console.error("Aucun sentier trouvé pour l'ID spécifié dans le GeoJSON.");
      }
    } else {
      console.error("Aucun sentier trouvé dans le GeoJSON.");
    }
  })
  .catch((error) => console.error("Erreur lors du chargement des GeoJSON:", error));
