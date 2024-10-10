const openHamburger = document.getElementById("hamb");
const popupDiv = document.getElementById("popUpHamb");
const closeHamburger = document.getElementById("close");

openHamburger.addEventListener("click", function (e) {
  e.stopPropagation(); // Empêche la propagation de l'événement
  popupDiv.style.display = "block"; // Assure que le menu est visible

  // On utilise un petit délai pour permettre au navigateur de "rafraîchir" l'affichage avant d'appliquer la classe 'show'
  setTimeout(() => {
    popupDiv.classList.add("show"); // Ajoute la classe pour animer l'apparition
  }, 10); // Délai très court pour garantir la fluidité de l'animation
});

closeHamburger.addEventListener("click", function (e) {
  e.stopPropagation(); // Empêche la propagation de l'événement
  popupDiv.classList.remove("show"); // Retire la classe pour animer la disparition
  setTimeout(() => {
    popupDiv.style.display = "none"; // Cache le menu après l'animation
  }, 500); // Délai correspondant à la durée de la transition
});

document.addEventListener("click", function (e) {
  if (!popupDiv.contains(e.target) && !openHamburger.contains(e.target)) {
    popupDiv.classList.remove("show"); // Retire la classe pour animer la disparition
    setTimeout(() => {
      popupDiv.style.display = "none"; // Cache le menu après l'animation
    }, 500); // Délai correspondant à la durée de la transition
  }
});
