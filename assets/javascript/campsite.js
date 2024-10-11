document.addEventListener("DOMContentLoaded", function() {
    const showMoreLinks = document.querySelectorAll('.show-more');
    const longTextElements = document.querySelectorAll('.long-text');

    //longs txt cachés par défaut
    longTextElements.forEach(longText => {
        longText.style.display = "none"; 
    });

    showMoreLinks.forEach(link => { //click aux liens 'voir +'
        link.addEventListener('click', function() {
            const longText = this.previousElementSibling; 

            if (longText.style.display === "none" || !longText.style.display) {
                longText.style.display = "inline"; 
                this.textContent = "Voir moins";  
            } else {
                longText.style.display = "none";  
                this.textContent = "Voir plus";
            }
        });
    });
});
