// Récupérer les cases à cocher et le bouton de filtrage
const filterButton = document.getElementById("filter-btn");
filterButton.addEventListener("click", function () {
  // Vérifie quelles cases sont cochées
  const facileChecked = document.getElementById("facile").checked;
  const moyenChecked = document.getElementById("moyen").checked;
  const difficileChecked = document.getElementById("difficile").checked;

  // Afficher les valeurs cochées dans la console
  console.log("Facile:", facileChecked);
  console.log("Moyen:", moyenChecked);
  console.log("Difficile:", difficileChecked);

  // Ici, tu peux ajouter ton code pour appliquer les filtres selon les cases cochées.
});

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
