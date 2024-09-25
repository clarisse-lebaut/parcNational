//* Attache un event listener à chaque bouton
const buttons = document.querySelectorAll("[name='tag']"); // Utilise querySelectorAll pour récupérer tous les boutons ayant name="tag"
buttons.forEach(function (btn) {
  btn.addEventListener("click", function () {
    manageTagDisplay(btn); // Appeler la fonction principale ici avec le bouton cliqué
  });
});
