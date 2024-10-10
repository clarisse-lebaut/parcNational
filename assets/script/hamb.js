const openHamburger = document.getElementById("hamb");
const popupDiv = document.getElementById("popUpHamb");
const closeHamburger = document.getElementById("close");

openHamburger.addEventListener("click", function () {
  // Alterne entre afficher et cacher la div
  if (popupDiv.style.display === "block") {
    popupDiv.style.display = "none"; // Affiche la div
  } else {
    popupDiv.style.display = "block"; // Cache la div si elle est déjà visible
  }
});

closeHamburger.addEventListener("click", function () {
  // Alterne entre afficher et cacher la div
  if (popupDiv.style.display === "block") {
    popupDiv.style.display = "none"; // Affiche la div
  } else {
    popupDiv.style.display = "block"; // Cache la div si elle est déjà visible
  }
});
