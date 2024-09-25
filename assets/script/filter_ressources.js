//* Attache un event listener à chaque bouton
const buttons = document.querySelectorAll("[name='tag']"); // Utilise querySelectorAll pour récupérer tous les boutons ayant name="tag"
buttons.forEach(function (btn) {
  btn.addEventListener("click", function () {
    manageTagDisplay(btn); // Appeler la fonction principale ici avec le bouton cliqué
  });
});

//* Fonction pour récupérer l'ID de l'URL
function getUrlId() {
  const params = new URLSearchParams(window.location.search);
  return params.get("id");
}

//*Fonction pour afficher les données en temps réels
// Code here...

//* Fonction pour gérer l'affichage des tags en fonction des boutons cliqué
function manageTagDisplay(button) {
  const tagValue = button.value; // Récupérer la valeur associée au bouton (ou un autre attribut si nécessaire)

  // Vérifier si un tag existe déjà pour ce bouton
  const existingTag = document.getElementById(`tag-${tagValue}`);

  if (!existingTag) {
    // Si le tag n'existe pas, créer un nouveau tag
    const card = document.createElement("div");
    card.className = "tags";
    card.id = `tag-${tagValue}`; // Assigner un ID unique basé sur la valeur du bouton
    card.innerHTML = `
      <p>${tagValue}</p>
      <img class="close-tag" src='../assets/icon/cross.svg'/>
    `;

    // Ajouter le tag dans un conteneur spécifique
    const tagContainer = document.getElementById("active-filter");
    if (tagContainer) {
      tagContainer.appendChild(card); // Assurez-vous que le conteneur existe
    } else {
      console.error("Conteneur de tags 'active-filter' introuvable !");
    }

    // Ajouter un event listener pour l'icône de fermeture (croix)
    card.querySelector(".close-tag").addEventListener("click", function () {
      card.remove(); // Supprimer le tag entier lorsqu'on clique sur la croix
      //! applyFilters(); // Appliquer les filtres après suppression du tag si nécessaire
    });
  } else {
    // Si le tag existe déjà, le supprimer
    existingTag.remove();
    //! applyFilters(); // Appliquer les filtres après suppression du tag si nécessaire
  }
}
