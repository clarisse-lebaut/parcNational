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

// Charger le fichier GeoJSON data_map.php pour afficher les contours ou zones
fetch("/parcNational/data/data_map.php")
  .then((response) => response.json())
  .then((geojsonData) => {
    // Ajouter le fichier GeoJSON à la carte
    L.geoJSON(geojsonData, {
      style: function (feature) {
        return {
          color: "gray", // Couleur des contours des frontières ou zones
          weight: 2, // Épaisseur des lignes
          opacity: 0.3, // Opacité des lignes
          fillColor: "gray", // Couleur de remplissage (si c'est une zone fermée)
          fillOpacity: 0.5, // Opacité du remplissage
        };
      },
    }).addTo(map);
  })
  .catch((error) => console.error("Erreur lors du chargement du GeoJSON:", error));

// Créer une couche de contrôle pour basculer entre les différents styles
var baseMaps = {
  "OSM Classique": osm,
  "OSM Clair": osmLight,
  "OSM Sombre": osmDark,
};

// Ajouter le contrôle à la carte
L.control.layers(baseMaps).addTo(map);

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

  // Récupération des coordonnées
  const coordinates = layer.getLatLngs();
  console.log("Coordonnées du sentier :", coordinates);
});
