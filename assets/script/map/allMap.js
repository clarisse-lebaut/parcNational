// Initialisation de la carte Leaflet
var map = L.map("map", {
  center: [43.2, 5.4522], // Coordonnées de départ
  zoom: 11, // Niveau de zoom de départ
  scrollWheelZoom: false, // Désactive le zoom au scroll de la souris
});

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
  "data/data_map.php", // Contours ou zones
  "data/data_map_trails.php", // Sentiers
  "data/data_map_landmarks.php", // Points d'intérêt
];

// Fonction pour générer une couleur aléatoire
function getRandomColor() {
  const letters = "0123456789ABCDEF"; // Caractères hexadécimaux
  let color = "#"; // Commencer avec le symbole #
  for (let i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)]; // Générer un caractère aléatoire
  }
  return color; // Retourner la couleur générée
}

// Utiliser Promise.all pour charger plusieurs fichiers GeoJSON
Promise.all(geojsonFiles.map((url) => fetch(url).then((response) => response.json())))
  .then((geojsonDataArray) => {
    // Ajouter le premier fichier (data_map.php) à la carte (contours)
    L.geoJSON(geojsonDataArray[0], {
      style: function (feature) {
        return {
          color: "green", // Couleur des contours des frontières ou zones
          weight: 2, // Épaisseur des lignes
          opacity: 0.3, // Opacité des lignes
          fillColor: "lightgreen", // Couleur de remplissage (si c'est une zone fermée)
          fillOpacity: 0.1, // Opacité du remplissage
        };
      },
    }).addTo(map);

    // Ajouter tous les sentiers (data_map_trails.php) à la carte
    const trailData = geojsonDataArray[1];

    L.geoJSON(trailData, {
      style: function (feature) {
        return {
          color: getRandomColor(), // Couleur aléatoire pour chaque sentier
          weight: 5, // Épaisseur de la ligne
          opacity: 1, // Opacité de la ligne
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

    // Ajouter tous les points d'intérêt (data_map_landmarks.php) à la carte
    const landmarksData = geojsonDataArray[2];

    L.geoJSON(landmarksData, {
      pointToLayer: function (feature, latlng) {
        return L.marker(latlng);
      },
      onEachFeature: function (feature, layer) {
        let popupContent = `
            <div>
                <h3>${feature.properties.name}</h3>
                <br>
                <img src="${feature.properties.image || "default_image.jpg"}" alt="${
          feature.properties.name
        }" width="250px" />
            </div>
        `;
        layer.bindPopup(popupContent);
        layer.on("mouseover", function () {
          layer.openPopup();
        });
        layer.on("mouseout", function () {
          layer.closePopup();
        });
      },
    }).addTo(map);
  })
  .catch((error) => console.error("Erreur lors du chargement des GeoJSON:", error));

// Créer une couche de contrôle pour basculer entre les différents styles
var baseMaps = {
  "OSM Classique": osm,
  "OSM Clair": osmLight,
  "OSM Sombre": osmDark,
};

// Ajouter le contrôle à la carte
L.control.layers(baseMaps).addTo(map);
