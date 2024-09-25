document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    // Récupération de l'ID du camping depuis l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const campsite_id = urlParams.get('campsite_id');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',

        // HEADER calendar
        headerToolbar: {
            start: 'title',
            center: 'dayGridMonth,timeGridWeek,timeGridDay',
            end: 'prev,next today'
        },

        events: function(successCallback) {
            let events = [];
            const defaultColor = '#FF6347'; 

            // plugin rrule : regle de récurrence
            const generateRRuleEvent = (title, start) => {
                return {
                    title: title,
                    color: defaultColor, 
                    allDay: true,
                    rendering: 'background', 
                    rrule: {
                        freq: 'yearly', 
                        dtstart: start, 
                        until: '2040-12-31' 
                    }
                };
            };

            if (campsite_id == 1) {
                events.push(generateRRuleEvent(
                    'Fermeture - Camping Les Cigales',
                    '2024-03-25'
                ));
            } else if (campsite_id == 2) {
                events.push(generateRRuleEvent(
                    'Fermeture - Camping de Ceyreste',
                    '2024-04-15'
                ));
            } else if (campsite_id == 3) {
                events.push(generateRRuleEvent(
                    'Fermeture - Camping La Baie des Anges',
                    '2024-03-29'
                ));
            } else if (campsite_id == 4) {
                events.push(generateRRuleEvent(
                    'Fermeture - Camping Les Tamaris',
                    '2024-04-01'
                ));
            } else if (campsite_id == 5) {
                events.push(generateRRuleEvent(
                    'Fermeture - Camping Les Flots Bleus',
                    '2024-05-15'
                ));
            }

            successCallback(events);
        }
    });
// successCallback: rendre events dans FC - render: rendre calndar sur la page 

    calendar.render();
});
