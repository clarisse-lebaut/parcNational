//* Attache un event listener 'change' à chaque case à cocher
const checkboxes = document.getElementsByName("tag");
checkboxes.forEach(function (checkbox) {
  checkbox.addEventListener("change", function () {
    applyFilters(); // Applique le filtre dès qu'une case est cochée ou décochée
    manageTagDisplay(checkbox); // Gérer l'affichage des tags
  });
});

//* Fonction pour récupérer l'ID de l'URL
function getUrlId() {
  const params = new URLSearchParams(window.location.search);
  return params.get("id");
}

//* Fonction pour appliquer les filtres en temps réel
function applyFilters() {
  const selectedDifficulties = [];
  const selectedStatuses = [];
  const selectedLengths = [];
  const selectedTimes = [];

  // Vérifie quelles cases sont cochées
  checkboxes.forEach(function (checkbox) {
    if (checkbox.checked) {
      // Distinguer les types de filtres par classe
      if (checkbox.classList.contains("difficulty")) {
        selectedDifficulties.push(checkbox.value);
      } else if (checkbox.classList.contains("status")) {
        selectedStatuses.push(checkbox.value);
      } else if (checkbox.classList.contains("length")) {
        selectedLengths.push(checkbox.value);
      } else if (checkbox.classList.contains("time")) {
        selectedTimes.push(checkbox.value);
      }
    }
  });

  // Créer une chaîne de requête
  const queryParams = [];
  if (selectedDifficulties.length > 0) {
    queryParams.push(`difficulty=${encodeURIComponent(selectedDifficulties.join(","))}`);
  }
  if (selectedStatuses.length > 0) {
    queryParams.push(`status=${encodeURIComponent(selectedStatuses.join(","))}`);
  }
  if (selectedLengths.length > 0) {
    queryParams.push(`length_km=${encodeURIComponent(selectedLengths.join(","))}`);
  }
  if (selectedTimes.length > 0) {
    queryParams.push(`time=${encodeURIComponent(selectedTimes.join(","))}`);
  }

  const queryString = queryParams.join("&");

  fetch(`/parcNational/data/data_filter_trails.php?${queryString}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok: " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      updateTrailDisplay(data);
    })
    .catch((error) => console.error("Erreur:", error));
}

//* Fonction pour gérer l'affichage des tags en fonction des cases cochées
function manageTagDisplay(checkbox) {
  const tag = document.getElementById("active-filter");

  if (checkbox.checked) {
    // Si la case est cochée, créer un tag
    const card = document.createElement("div");
    card.className = "tags";
    card.id = `tag-${checkbox.value}`; // Assigner un ID unique basé sur la valeur de la checkbox
    card.innerHTML = `
      <p>${checkbox.value}</p>
      <img class="close-tag" src='assets/icon/cross.svg'/>
    `;
    tag.appendChild(card);
    // Ajouter un event listener pour l'icône de fermeture (croix)
    card.querySelector(".close-tag").addEventListener("click", function () {
      card.remove(); // Supprimer le tag entier lorsqu'on clique sur la croix
      checkbox.checked = false; // Décocher la case correspondante
      applyFilters(); // Appliquer les filtres après suppression du tag
    });
  } else {
    // Supprimer le tag correspondant quand la checkbox est décochée
    const tagToRemove = document.getElementById(`tag-${checkbox.value}`);
    if (tagToRemove) {
      tagToRemove.remove();
    }
  }
}

//* Fonction pour afficher les données filtrées dans la div
function updateTrailDisplay(data) {
  console.log(data);
  const resultsContainer = document.getElementById("overflow");
  resultsContainer.innerHTML = ""; // Vider le conteneur des résultats précédents

  if (data && data.length > 0) {
    data.forEach((item) => {
      const card = document.createElement("div");
      card.className = "card_trails";

      card.innerHTML = `
        <div class="card_top">
          <a href="details_trails?id=${encodeURIComponent(item.trail_id)}">
            <p>${item.name}</p>
            <img class="pic-trails" src="${item.image}" alt="${item.name}" width="200">
          </a>
        </div>
        <div class="card_details">
          
          <div class="lenght_trails">
            <img src="assets/icon/hiking.svg" alt="icon length">
            <p>${item.length_km} km</p>
          </div>
          
          <div class="time_trails">
            <img src="assets/icon/time.svg" alt="icon time">
            <p>${item.time}</p>
          </div>
          
          <div class="difficulty_trails">
            <img src="assets/icon/${getDifficultyIcon(item.difficulty)}" alt="${getDifficultyAlt(
        item.difficulty
      )}">
            <p>${item.difficulty}</p>
          </div>

          <div class="state_trails">
            <img src="assets/icon/${getStatusIcon(item.status)}" alt="${getStatusAlt(item.status)}">
            <p>${item.status}</p>
          </div>
        </div>

        <div class="access">
          <p>Description du sentier</p>
          <p>${item.description}</p>
          <p>Accéder au sentier</p>
          <p>${item.acces}</p>
        </div>

        <div class="fav-btn-container">
          <a href="/parcNational/manage-favorite-trail?trail_id=${item.trail_id}" class="fav-btn"><img src="assets/icon/favorite-fill.svg" alt="heart icon"></a>
          <button class="fav-btn"><img src="assets/icon/hiking.svg" alt=""></button>
        </div>       
      `;

      resultsContainer.appendChild(card);
    });
  } else {
    resultsContainer.textContent = "Aucune donnée disponible pour ce filtre.";
  }
}

// Fonction pour obtenir l'icône de difficulté
function getDifficultyIcon(difficulty) {
  switch (difficulty) {
    case "Facile":
      return "shoes-green.svg";
    case "Moyen":
      return "shoes-orange.svg";
    case "Difficile":
      return "shoes-red.svg";
    default:
      return "shoes-default.svg";
  }
}

// Fonction pour obtenir le texte alternatif de difficulté
function getDifficultyAlt(difficulty) {
  switch (difficulty) {
    case "Facile":
      return "icon green shoes";
    case "Moyen":
      return "icon orange shoes";
    case "Difficile":
      return "icon red shoes";
    default:
      return "icon default shoes";
  }
}

// Fonction pour obtenir l'icône de statut
function getStatusIcon(status) {
  switch (status) {
    case "active":
      return "circle-green.svg";
    case "work":
      return "circle-orange.svg";
    case "inactive":
      return "circle-red.svg";
    default:
      return "circle-default.svg";
  }
}

// Fonction pour obtenir le texte alternatif de statut
function getStatusAlt(status) {
  switch (status) {
    case "active":
      return "icon green circle";
    case "work":
      return "icon orange circle";
    case "inactive":
      return "icon red circle";
    default:
      return "no info available";
  }
}

// Fonction pour récupérer tous les sentiers
function fetchAllTrails() {
  fetch("/parcNational/data/data_filter_trails.php") // URL de récupération des données
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la récupération des données");
      }
      return response.json();
    })
    .then((data) => {
      updateTrailDisplay(data); // Met à jour l'affichage avec toutes les données
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
}

// Appelle la fonction pour récupérer tous les sentiers lors du chargement de la page
document.addEventListener("DOMContentLoaded", function () {
  fetchAllTrails(); // Récupère tous les sentiers par défaut
});

function removeAll() {
  const remove = document.getElementById("remove-filter");
  remove.addEventListener("click", function () {
    // Supprimer les tags et décocher les cases
    checkboxes.forEach(function (checkbox) {
      if (checkbox.checked) {
        checkbox.checked = false;
        const tagToRemove = document.getElementById(`tag-${checkbox.value}`);
        if (tagToRemove) {
          tagToRemove.remove();
        }
      }
    });

    // Récupérer toutes les données et les afficher
    fetch("/parcNational/data/data_filter_trails.php")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors de la récupération des données");
        }
        return response.json();
      })
      .then((data) => {
        updateTrailDisplay(data); // Met à jour l'affichage avec toutes les données
      })
      .catch((error) => {
        console.error("Erreur:", error);
      });
  });
}

// Appelle la fonction pour la configurer
removeAll();
