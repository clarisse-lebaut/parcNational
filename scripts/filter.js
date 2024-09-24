const filterButton = document.getElementById("filter-btn");
filterButton.addEventListener("click", function () {
  const checkboxes = document.getElementsByName("tag");
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

  fetch(`../data/data_all.php?${queryString}`)
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
});

function updateTrailDisplay(data) {
  const resultsContainer = document.getElementById("overflow");
  resultsContainer.innerHTML = ""; // Vider le conteneur des résultats précédents

  if (data && data.length > 0) {
    data.forEach((item) => {
      const div = document.createElement("div");
      div.textContent = `Difficulté: ${item.difficulty}, Longueur: ${item.length_km} km, Statut: ${item.status},Temps: ${item.time}`;
      resultsContainer.appendChild(div);
    });
  } else {
    resultsContainer.textContent = "Aucune donnée disponible pour ce filtre.";
  }
}

//* ----- ICI ON EST BON -----
const checkboxes = document.getElementsByName("tag");
// Boucle sur chaque checkbox pour ajouter un event listener
checkboxes.forEach(function (checkbox) {
  // Ajoute un listener sur chaque checkbox
  checkbox.addEventListener("click", function () {
    const tag = document.getElementById("active-filter");

    if (checkbox.checked) {
      // Si la case est cochée, créer un tag
      const card = document.createElement("div");
      card.className = "tags";
      card.id = `tag-${checkbox.value}`; // Assigner un ID unique basé sur la valeur de la checkbox
      card.innerHTML = `
        <p>${checkbox.value}</p>
        <img class="close-tag" src='../assets/icon/cross.svg'/>
      `;
      tag.appendChild(card);
      // Ajouter un event listener pour l'icône de fermeture (croix)
      card.querySelector(".close-tag").addEventListener("click", function () {
        card.remove(); // Supprimer le tag entier lorsqu'on clique sur la croix
        checkbox.checked = false; // Décocher la case correspondante
      });
    } else {
      // Supprimer le tag correspondant quand la checkbox est décochée
      const tagToRemove = document.getElementById(`tag-${checkbox.value}`);
      if (tagToRemove) {
        tagToRemove.remove();
      }
    }
  });
});
