document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

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

        events: function(fetchInfo, successCallback, failureCallback) {
            let events = [];

            if (campsite_id == 1) {
                events = [
                    {
                        title: 'Fermeture - Camping Les Cigales',
                        start: '2024-03-25',
                        end: '2024-11-06',
                        color: '#FF6347',
                        allDay: true
                    }
                ];
            } else if (campsite_id == 2) {
                events = [
                    {
                        title: 'Fermeture - Camping de Ceyreste',
                        start: '2024-04-15',
                        end: '2024-10-01',
                        color: '#FF6377',
                        allDay: true
                    }
                ];
            } else if (campsite_id == 3) {
                events = [
                    {
                        title: 'Fermeture - Camping La Baie des Anges',
                        start: '2024-03-29',
                        end: '2024-09-30',
                        color: '#32CD32',
                        allDay: true
                    }
                ];
            } else if (campsite_id == 4) {
                events = [
                    {
                        title: 'Fermeture - Camping Les Tamaris',
                        start: '2024-04-01',
                        end: '2024-11-01',
                        color: '#4682B4',
                        allDay: true
                    }
                ];
            } else if (campsite_id == 5) {
                events = [
                    {
                        title: 'Fermeture - Camping Les Flots Bleus',
                        start: '2024-05-15',
                        end: '2024-10-01',
                        color: '#8A2BE2',
                        allDay: true
                    }
                ];
            }

            successCallback(events);
        }
    });

    calendar.render();
});
