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
  const selectedFaune = [];
  const selectedFlore = [];
  const selectedRessources = []; // Ajout de la variable pour les ressources

  // Vérifie quelles cases sont cochées
  checkboxes.forEach(function (checkbox) {
    if (checkbox.checked) {
      // Ajouter directement les valeurs sélectionnées
      if (checkbox.classList.contains("faune")) {
        selectedFaune.push(checkbox.value);
      } else if (checkbox.classList.contains("flore")) {
        selectedFlore.push(checkbox.value);
      } else if (checkbox.classList.contains("ressources")) {
        // Vérifier pour les ressources
        selectedRessources.push(checkbox.value);
      }
    }
  });

  // Créer une chaîne de requête basée sur les filtres
  const queryParams = [];

  // Créez une expression de recherche pour la colonne 'type'
  const searchTerms = [];
  if (selectedFaune.length > 0) {
    searchTerms.push(...selectedFaune);
  }
  if (selectedFlore.length > 0) {
    searchTerms.push(...selectedFlore);
  }
  if (selectedRessources.length > 0) {
    // Ajouter les ressources
    searchTerms.push(...selectedRessources);
  }

  if (searchTerms.length > 0) {
    queryParams.push(`type=${encodeURIComponent(searchTerms.join(","))}`);
  }

  const queryString = queryParams.join("&");

  // Envoie de la requête pour récupérer les données filtrées
  fetch(`/parcNational/data/data_filter_ressources.php?${queryString}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok: " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      updateRessourcesDisplay(data);
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
function updateRessourcesDisplay(data) {
  const resultsContainer = document.getElementById("overflow");
  resultsContainer.innerHTML = ""; // Vider le conteneur des résultats précédents

  if (data && data.length > 0) {
    data.forEach((item) => {
      const card = document.createElement("div");
      card.className = "card_ressources";

      card.innerHTML = `
        <div class="card_top">
          <a href="ressourceDetails?id=${encodeURIComponent(item.ressource_id)}">
            <img class="pic-ressources" src="${item.image}" alt="${item.name}">
          </a>
        </div>

        <div class="card_details">
            <div class="name_ressources">
                <p>${item.name}</p>
            </div>

            <div class="type_ressources">
                <p><strong>Type</strong> : ${item.type}</p>
            </div>
        </div>

        <div class="btn-container">
            <button class="btn-details">
                <a href="ressourceDetails?id=${encodeURIComponent(item.ressource_id)}">
                    En découvir plus !
                </a>
            </button>
        </div>
      `;

      resultsContainer.appendChild(card);
    });
  } else {
    resultsContainer.textContent = "Aucune donnée disponible pour ce filtre.";
  }
}

// Fonction pour récupérer tous les sentiers
function fetchAllressources() {
  fetch("/parcNational/data/data_filter_ressources.php") // URL de récupération des données
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la récupération des données");
      }
      return response.json();
    })
    .then((data) => {
      updateRessourcesDisplay(data); // Met à jour l'affichage avec toutes les données
    })
    .catch((error) => {
      console.error("Erreur:", error);
    });
}

// Appelle la fonction pour récupérer tous les sentiers lors du chargement de la page
document.addEventListener("DOMContentLoaded", function () {
  fetchAllressources(); // Récupère tous les sentiers par défaut
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
    fetch("/parcNational/data/data_filter_ressources.php")
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur lors de la récupération des données");
        }
        return response.json();
      })
      .then((data) => {
        updateRessourcesDisplay(data); // Met à jour l'affichage avec toutes les données
      })
      .catch((error) => {
        console.error("Erreur:", error);
      });
  });
}

// Appelle la fonction pour la configurer
removeAll();
