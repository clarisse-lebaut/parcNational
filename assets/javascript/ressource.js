// Fonction pour définir la couleur et la longueur de la barre en fonction du niveau de conservation
function setConservationLevel(level) {
    const bar = document.getElementById('conservation-level-bar');
    let width = 0;
    let color = '';


    switch (level.trim()) { 
        case 'Faible':
            width = '25%';
            color = '#8BC34A'; 
            break;
        case 'Moyen':
            width = '50%';
            color = '#FFEB3B';  
            break;
        case 'Fort':
            width = '75%';
            color = '#FF9800';  
            break;
        case 'Très Fort':
            width = '100%';
            color = '#F44336'; 
            break;
        default:
            console.warn("Niveau de conservation inconnu :", level); // Alerte si le niveau est inconnu
            width = '0';
            color = '#ddd';  
    }

    bar.style.width = width;
    bar.style.backgroundColor = color;
}

document.addEventListener('DOMContentLoaded', function() {
    const level = document.getElementById('conservation-level-bar').getAttribute('data-level');
    setConservationLevel(level);
});