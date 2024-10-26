//* Fonction pour récupérer l'ID de l'URL
function getUrlId() {
  const params = new URLSearchParams(window.location.search);
  return params.get("id");
}

//* Attache un event listener au toggle
const toggle = document.getElementById("toggle");
toggle.addEventListener("change", () => {
  fetch("/data/data_filter_campsites.php") // URL de récupération des données
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la récupération des données");
      }
      return response.json();
    })
    .then((data) => {
      // Vérifie l'état du toggle et filtre les données si nécessaire
      let filteredData;
      if (toggle.checked) {
        // Filtre les campings avec le statut "ouvert"
        filteredData = data.filter((camping) => camping.status === "Ouvert");
      } else {
        // Utilise toutes les données si le toggle est désactivé
        filteredData = data;
      }
      // Met à jour l'affichage avec les données filtrées
      updateCampsitesDisplay(filteredData);
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
});

//* Fonction pour afficher les données filtrées dans la div
function updateCampsitesDisplay(data) {
  const resultsContainer = document.getElementById("overflow");
  resultsContainer.innerHTML = ""; // Vider le conteneur des résultats précédents

  if (data && data.length > 0) {
    data.forEach((item) => {
      const card = document.createElement("div");
      card.className = "camping-item";

      // Tronquer la description pour l'affichage
      const shortDescription =
        item.description.length > 100
          ? item.description.substring(0, 100) + "..."
          : item.description;

      card.innerHTML = `
        <div class="card_top">
          <a href="campsiteDetails?id=${encodeURIComponent(item.campsite_id)}">
            <img class="pic-campiste" src="${item.image}" alt="${item.name}">
          </a>
        </div>

        <div class="card_details">
            <div class="campsite-name">
                ${item.name}
            </div>

            <div>
                <p>&#x1F4CD; ${item.address}</p>
            </div>

            <div>
                <p class="shortText">${shortDescription}</p>
                ${
                  item.description.length > 100
                    ? `<span class="longText" style="display: none;">${item.description}</span>
                     <span class="show-more" data-id="${item.campsites_id}">Voir plus</span>`
                    : ""
                }
            </div>

            <div class="campsite-status">
                <img class="status-icons" src="assets/icon/${getStatusIcon(
                  item.status
                )}" alt="${getStatusAlt(item.status)}">
                <p>${item.status}</p>
            </div>
        </div>
      `;

      resultsContainer.appendChild(card);
    });

    // Ajoute un gestionnaire d'événements pour les "Voir plus"
    const showMoreButtons = resultsContainer.querySelectorAll(".show-more");
    showMoreButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const longText = this.previousElementSibling; // la span contenant le texte long
        const shortText = longText.previousElementSibling; // la span contenant le texte court

        // Bascule l'affichage entre le texte court et long
        if (longText.style.display === "none") {
          longText.style.display = "inline"; // Affiche le texte long
          shortText.style.display = "none"; // Cache le texte court
          this.textContent = "Voir moins"; // Change le texte du bouton
        } else {
          longText.style.display = "none"; // Cache le texte long
          shortText.style.display = "inline"; // Affiche le texte court
          this.textContent = "Voir plus"; // Change le texte du bouton
        }
      });
    });
  } else {
    resultsContainer.textContent = "Aucune donnée disponible pour ce filtre.";
  }
}

// Fonction pour obtenir uniquement l'icône du statut du camping
function getStatusIcon(status) {
  switch (status) {
    case "Ouvert":
      return "circle-green.svg";
    case "Fermé":
      return "circle-red.svg";
    case "Complet":
      return "circle-red.svg";
    default:
      return "circle-default.svg";
  }
}

// Fonction pour obtenir le texte alternatif de difficulté
function getStatusAlt(status) {
  switch (status) {
    case "Ouvert":
      return "icon green circle";
    case "Fermé":
      return "icon orange circle";
    case "Complet":
      return "icon red circle";
    default:
      return "icon default circle";
  }
}

// Fonction pour récupérer tous les sentiers
function fetchAllressources() {
  fetch("/data/data_filter_campsites.php") // URL de récupération des données
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la récupération des données");
      }
      return response.json();
    })
    .then((data) => {
      updateCampsitesDisplay(data); // Met à jour l'affichage avec toutes les données
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
}

// Appelle la fonction pour récupérer tous les sentiers lors du chargement de la page
document.addEventListener("DOMContentLoaded", function () {
  fetchAllressources(); // Récupère tous les sentiers par défaut
});
