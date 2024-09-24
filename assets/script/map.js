// Initialisation de la carte Leaflet
var map = L.map("map").setView([43.2, 5.4522], 11); // Coordonnées de départ

// Ajouter une couche de tuiles OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

// Liste des fichiers GeoJSON
var geojsonFiles = [
  "../data/data_map.php",
  "../data/data_map_trails.php",
  "../data/data_map_landmarks.php",
];

// Récupérer l'ID du sentier depuis l'URL
const urlParams = new URLSearchParams(window.location.search);
const trailId = urlParams.get("id");

// Utiliser Promise.all pour charger plusieurs fichiers GeoJSON
Promise.all(geojsonFiles.map((url) => fetch(url).then((response) => response.json())))
  .then((geojsonDataArray) => {
    //* Ajouter le premier fichier (data_map.php) à la carte (contours)
    L.geoJSON(geojsonDataArray[0]).addTo(map);

    //* Boucler sur le second fichier (data_map_trails.php) pour récupérer uniquement le sentier spécifique
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
        // Ajouter le sentier filtré à la carte avec un popup au hover
        L.geoJSON(filteredTrail, {
          onEachFeature: function (feature, layer) {
            // Créer un contenu pour le popup (nom du sentier par exemple)
            let popupContent = `
              <div>
                <p><strong>Nom du sentier :</strong> ${feature.properties.name}</p>
              </div>
            `;

            // Ajout d'un événement au survol (mouseover) pour afficher le popup
            layer.on("mouseover", function () {
              // Affiche un popup temporaire au survol
              layer.bindPopup(popupContent).openPopup();
            });

            // Optionnel : fermer le popup quand la souris quitte le sentier
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

    //* Récupérer les données du fichier landmarks (data_map_landmarks.php)
    const landmarksData = geojsonDataArray[2]; // Récupération des données landmarks

    // Filtrer les landmarks selon l'ID de sentier
    const filteredLandmarks = {
      type: "FeatureCollection",
      features: landmarksData.features.filter((feature) => feature.properties.trail_id == trailId), // Filtrer par trail_id
    };

    // Vérifier si des landmarks filtrés existent
    if (filteredLandmarks.features.length > 0) {
      // Ajouter les points d'intérêt filtrés à la carte
      L.geoJSON(filteredLandmarks, {
        onEachFeature: function (feature, layer) {
          // Bind a popup with the landmark name (when clicked)
          layer.bindPopup(feature.properties.name);

          // Image URL associated with the landmark (you may have this data in your GeoJSON)
          var imageUrl = feature.properties.image; // Assuming 'image_url' property exists
          var namePoi = feature.properties.name;

          // Add hover event to show image
          layer.on("mouseover", function () {
            var imagePopup = L.popup({
              offset: L.point(0, -20), // Adjust position of the popup
              closeButton: false,
            }).setLatLng(layer.getLatLng()).setContent(`
              <div>
                <img src="../${imageUrl}" alt="${feature.properties.name}" width="250px"/>
                <p>${namePoi}</p>
              </div>  
              `);

            map.openPopup(imagePopup); // Ouvrir l'image avec le pop-up au passage de la souris
          });

          // Fermer l'image quand la souris n'est plus dessus
          layer.on("mouseout", function () {
            map.closePopup();
          });
        },
      }).addTo(map);
    } else {
      console.error("Aucun point d'intérêt trouvé pour l'ID de sentier spécifié dans le GeoJSON.");
    }
  })
  .catch((error) => console.error("Erreur lors du chargement des GeoJSON:", error));
