document.addEventListener('DOMContentLoaded', function() { 
    let calendarEl = document.getElementById('calendar');

    const urlParams = new URLSearchParams(window.location.search);
    const campsite_id = urlParams.get('campsite_id');
    let events = [];
    const defaultColor = '#FF1473';

    const generateEvent = (title, start, end) => {
        return {
            title: title,
            start: start,
            end: end,
            color: defaultColor,
            allDay: true
        };
    };

    if (campsite_id == 1) {
        events.push(generateEvent('Fermeture - Camping Les Cigales', '2024-03-25', '2024-04-10'));
    } else if (campsite_id == 2) {
        events.push(generateEvent('Fermeture - Camping de Ceyreste', '2024-04-15', '2024-04-30'));
    } else if (campsite_id == 3) {
        events.push(generateEvent('Fermeture - Camping La Baie des Anges', '2024-03-29', '2024-09-15'));
    } else if (campsite_id == 4) {
        events.push(generateEvent('Fermeture - Camping Les Tamaris', '2024-11-01', '2025-04-20'));
    } else if (campsite_id == 5) {
        events.push(generateEvent('Fermeture - Camping Les Flots Bleus', '2024-05-15', '2024-05-31'));
    }

    // Récup prix/nuit
    const campsiteInfo = document.querySelector('.calendar-info');
    let pricePerNight = parseFloat(campsiteInfo.getAttribute('data-price-per-night'));

    let totalPriceElement = document.getElementById('total-price');
    let personsInput = document.getElementById('num_persons');
    let priceInput = document.getElementById('calculated_price');

    let selectedDays = 0;

    const calculateTotalPrice = () => {
        let numPersons = parseInt(personsInput.value, 10) || 1; // Par défaut : 1 personne
        let totalPrice = selectedDays * pricePerNight * numPersons;
        totalPriceElement.textContent = totalPrice.toFixed(2);
        priceInput.value = totalPrice.toFixed(2);
    };
    // maj du prix selon le nombre de personnes
    personsInput.addEventListener('input', calculateTotalPrice);

    let calendar = new FullCalendar.Calendar(calendarEl, { //initialisation FC
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            start: 'title',
            center: '',
            end: 'prev,next today'
        },
        events: events,
        selectable: true,
        validRange: function(nowDate) {
            let today = new Date();
            return {
                start: today, 
            };
        },

        select: function(info) {
            document.getElementById('start_date').value = info.startStr;
            document.getElementById('end_date').value = info.endStr;

            // date de début - date de fin = différence de jours   (1000 ms * 60 s * 60 min * 24 h)
            let startDate = new Date(info.startStr);
            let endDate = new Date(info.endStr);
            selectedDays = (endDate - startDate) / (1000 * 60 * 60 * 24);

            calculateTotalPrice();
        },

    });

    calendar.render();
});