// Initialisation de la carte Leaflet
var map = L.map("map").setView([43.2, 5.4522], 11); // Coordonnées de départ

// Déclaration des styles de tuiles
var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
});

var osmLight = L.tileLayer("https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png", {
  attribution:
    '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
});

var osmDark = L.tileLayer(
  "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png",
  {
    attribution:
      '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
  }
);

// Ajouter le style de tuiles par défaut
osm.addTo(map);

// Liste des fichiers GeoJSON
var geojsonFiles = [
  "/parcNational/data/data_map.php", // Frontières ou zones
  "/parcNational/data/data_map_trails.php", // Sentiers
];

// Récupérer l'ID du sentier depuis l'URL (si nécessaire)
const urlParams = new URLSearchParams(window.location.search);
const trailId = urlParams.get("trail_id");

// Utiliser Promise.all pour charger plusieurs fichiers GeoJSON
Promise.all(geojsonFiles.map((url) => fetch(url).then((response) => response.json())))
  .then((geojsonDataArray) => {
    //* Ajouter le premier fichier (data_map.php) à la carte (contours)
    L.geoJSON(geojsonDataArray[0], {
      style: function (feature) {
        return {
          color: "green", // Couleur des contours des frontières ou zones
          weight: 3, // Épaisseur des lignes
          opacity: 0.5, // Opacité des lignes
          fillColor: "lightgreen", // Couleur de remplissage
          fillOpacity: 0.3, // Opacité du remplissage
        };
      },
    }).addTo(map);

    //* Boucler sur le second fichier (data_map_trails.php) pour récupérer uniquement le sentier spécifique
    const trailData = geojsonDataArray[1];

    if (trailData.features.length > 0) {
      // Filtrer les sentiers selon l'ID (si nécessaire)
      const filteredTrail = {
        type: "FeatureCollection",
        features: trailData.features.filter((feature) => feature.properties.trail_id == trailId), // Filtrer par trail_id
      };

      if (filteredTrail.features.length > 0) {
        // Ajouter le sentier filtré à la carte avec un popup au hover
        L.geoJSON(filteredTrail, {
          style: function (feature) {
            return {
              color: "blue", // Couleur de la ligne du sentier
              weight: 5, // Épaisseur de la ligne
              opacity: 0.7, // Opacité de la ligne
            };
          },
          onEachFeature: function (feature, layer) {
            let popupContent = `<div><p><strong>Nom du sentier :</strong> ${feature.properties.name}</p></div>`;

            layer.on("mouseover", function () {
              layer.bindPopup(popupContent).openPopup();
            });

            layer.on("mouseout", function () {
              layer.closePopup();
            });
          },
        }).addTo(map);
      } else {
        console.error("Aucun sentier trouvé pour l'ID spécifié dans le GeoJSON.");
      }
    } else {
      console.error("Aucun sentier trouvé dans le GeoJSON.");
    }
  })
  .catch((error) => console.error("Erreur lors du chargement des GeoJSON:", error));

// Groupe pour les éléments dessinés
const drawnItems = L.featureGroup().addTo(map);

// Contrôle de dessin
const drawControl = new L.Control.Draw({
  edit: {
    featureGroup: drawnItems,
  },
  draw: {
    polygon: true,
    polyline: true,
    rectangle: false,
    circle: false,
    marker: false,
  },
});

map.addControl(drawControl);

// Événement lorsque le dessin est créé
map.on(L.Draw.Event.CREATED, function (event) {
  const layer = event.layer;
  drawnItems.addLayer(layer);

  // Récupérer les coordonnées sous forme de tableaux de points
  const coordinates = layer.getLatLngs();

  // Fonction pour convertir les coordonnées en chaîne CSV
  function convertToCSV(coords) {
    let csv = "Latitude,Longitude\n"; // En-tête du CSV

    // Si l'objet est une polyligne (tableau de tableaux)
    coords.forEach(function (coordArray) {
      coordArray.forEach(function (coord) {
        csv += `${coord.lat},${coord.lng}\n`; // Ajout de chaque coordonnée dans le CSV
      });
    });

    return csv;
  }

  // Conversion des coordonnées en format CSV
  const csvString = convertToCSV(coordinates);

  // Assurez-vous que l'input caché a l'ID "trail_coords"
  document.getElementById("trail_coords").value = csvString;

  console.log("Coordonnées CSV du sentier :", csvString); // Affiche les coordonnées en CSV dans la console

  // Fonction pour envoyer les données au serveur
  function sendDataToServer(csvData) {
    fetch("/votre-endpoint.php", {
      // Remplacez par l'URL de votre endpoint
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ trail_coords: csvData }), // Envoi des données en JSON
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data); // Traitez la réponse du serveur ici
        alert("Sentier enregistré avec succès !");
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Erreur lors de l'enregistrement du sentier.");
      });
  }

  // Appel de la fonction pour envoyer les données au serveur
  sendDataToServer(csvString);
});

// Créer une couche de contrôle pour basculer entre les différents styles
var baseMaps = {
  "OSM Classique": osm,
  "OSM Clair": osmLight,
  "OSM Sombre": osmDark,
};

// Ajouter le contrôle à la carte
L.control.layers(baseMaps).addTo(map);
