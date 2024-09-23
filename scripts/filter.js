/*
* Pour le filtre
? faire en sorte d'attribuer une valeur à chaque data-filter des buttons du filtre
? ajouter également des valeurs pour les options des selects
? récupérer les filtres
? récupérer les valeurs des data-filter
? il faut écouter ce qui se passe sur chacun des boutons au moment du click
? lire les valeurs des données récupérer dans la base de données
    _ il faut donc faire en sorte que les éléments de la base de donnée soient lu pour ne récupérer que selon le filtre
    _ est-ce que je fais une requête dans laquelle je détail toutes les données afin de les récupérer ?
? n'afficher que les valeurs attendue en fonction du bouton cliqué
? mettre toute les données par défaut au chargement de la page
? ajouter un bouton pour supprimer les filtres --> quand cliker les données ont remise à 0 et tout les sentiers sont de nouveau disponible
? additionner les filtres pour permettre une multi filtrage


+ pour les kilomètres, peut etre faire des requête qui trie les kilomètres dans un certain ordre
+ idem pour les heures
 */

// Fonction pour récupérer les données
function fetchTrails() {
  fetch("../request/request.php")
    .then((response) => response.json())
    .then((data) => {
      // Stocker les données dans une variable globale
      window.trailsData = data; // Accessible dans d'autres fonctions
      console.log(data); // Pour voir les données récupérées
      displayTrails(data); // Afficher tous les sentiers par défaut
    })
    .catch((error) => console.error("Erreur:", error));
}

// //Fonction pour afficher les sentiers
// function displayTrails(trails) {
//   const resultatDiv = document.getElementById("overflow");
//   resultatDiv.innerHTML = ""; // Réinitialiser le contenu

//   trails.forEach((trail) => {
//     const p = document.createElement("p");
//     p.textContent = `${trail.name} - ${trail.difficulty}`;
//     resultatDiv.appendChild(p);
//   });
// }

// // Écouter les clics sur les boutons
// document.querySelectorAll("button").forEach((button) => {
//   button.addEventListener("click", function () {
//     const selectedDifficulty = this.value;

//     // Filtrer les résultats selon la difficulté sélectionnée
//     const filteredTrails = window.trailsData.filter(
//       (trail) => trail.difficulty === selectedDifficulty
//     );

//     displayTrails(filteredTrails);
//   });
// });

// Appeler la fonction pour récupérer les sentiers au chargement de la page
fetchTrails(); //on pour récupérer les sentiers au chargement de la page
