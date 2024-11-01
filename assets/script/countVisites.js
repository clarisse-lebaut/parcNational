// Appeler le script PHP pour incrémenter le compteur
fetch("/parcNational/models/Visites.php")
  .then((response) => response.text())
  .then((data) => {
    console.log(data); // Afficher la réponse du serveur dans la console
  })
  .catch((error) => {
    console.error("Erreur:", error);
  });
