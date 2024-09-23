function click() {
  const buttons = document.getElementsByClassName("filter-btn");

  for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function () {
      const difficulty = buttons[i].getAttribute("data-filter-difficulty");

      if (difficulty) {
        fetch(`../scripts/data_difficulty.php?difficulty=${difficulty}`)
          .then((response) => response.json())
          .then((data) => {
            updateTrailDisplay(data);
          })
          .catch((error) => console.error("Erreur:", error));
      } else {
        // Réinitialiser l'affichage si "Reset" est cliqué
        overflow.innerHTML = ""; // Ou réafficher tous les sentiers
      }
    });
    
  }
}

function updateTrailDisplay(trails) {
  const overflow = document.getElementById("overflow");
  overflow.innerHTML = ""; // Réinitialiser l'affichage

  if (trails.length === 0) {
    overflow.innerHTML = "<p>Aucun sentier trouvé.</p>";
    return;
  }

  trails.forEach((trail) => {
    const card = document.createElement("div");
    card.className = "card";

    // Construction du contenu HTML
    card.innerHTML = `
      <div class="card_top">
        <a href="">
          <p>${trail.name}</p>
          <img src="../${trail.image}" alt="${trail.name}" width="200">
        </a>
      </div>
      <div class="card_details">
        <div>
          <img src="../assets/icon/hiking.svg" alt="icon length">
          <p>${trail.length_km} km</p>
        </div>
        <div>
          <img src="../assets/icon/time.svg" alt="icon time">
          <p>${trail.time}</p>
        </div>
        <div>
          <img src="../assets/icon/${getDifficultyIcon(trail.difficulty)}" alt="${
      trail.difficulty
    }">
          <p>${trail.difficulty}</p>
        </div>
        <div>
          <p>${trail.status}</p>
          <img src="../assets/icon/${getStatusIcon(trail.status)}" alt="${trail.status}">
        </div>
      </div>
      <button><img src="../assets/icon/favorite-fill.svg" alt="heart icon">Ajouter au favoris</button>
      <button><img src="../assets/icon/hiking.svg" alt="">Ajouter à mes kilomètres</button>
      <p>${trail.description}</p>
      <p>${trail.acces}</p>
    `;

    overflow.appendChild(card);
  });
}

// Fonctions utilitaires pour récupérer les icônes
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

function getStatusIcon(status) {
  switch (status) {
    case "active":
      return "circle-green.svg";
    case "work":
      return "circle-orange.svg";
    case "inactive":
      return "circle-red.svg";
    default:
      return "circle-green.svg";
  }
}

click();
