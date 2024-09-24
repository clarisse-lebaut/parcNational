document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',

        // HEADER calendar
        headerToolbar: {
            start: 'title',
            center: 'dayGridMonth,timeGridWeek,timeGridDay',
            end: 'prev,next today'
        },

        events: [ //FERMETURE ANNUELLES DES CAMPINGS 
            {
                title: 'Fermeture - Camping Les Cigales',
                start: '2024-03-25',  
                end: '2024-11-06',    
                color: '#FF6347',    
                allDay: true,
                rendering: 'background',
                duration: { days: 226 },  // récurrence annuelle
                recurrenceRule: { freq: 'yearly' }
            },

            {
                title: 'Fermeture - Camping de Ceyreste',
                start: '2024-04-15',  
                end: '2024-10-01',    
                color: '#FF6377',     
                allDay: true,
                rendering: 'background',
                duration: { days: 168 }, 
                recurrenceRule: { freq: 'yearly' }
            },

            {
                title: 'Fermeture - Camping La Baie des Anges',
                start: '2024-03-29',  
                end: '2024-09-30',    
                color: '#32CD32',    
                allDay: true,
                rendering: 'background',
                duration: { days: 185 }, 
                recurrenceRule: { freq: 'yearly' }
            },

            {
                title: 'Fermeture - Camping Les Tamaris',
                start: '2024-04-01',  
                end: '2024-11-01',    
                color: '#4682B4',     // Bleu pour Les Tamaris
                allDay: true,
                rendering: 'background',
                duration: { days: 214 }, 
                recurrenceRule: { freq: 'yearly' }
            },

            {
                title: 'Fermeture - Camping Les Flots Bleus',
                start: '2024-05-15',  
                end: '2024-10-01',    
                color: '#8A2BE2',     // Violet pour Les Flots Bleus
                allDay: true,
                rendering: 'background',
                duration: { days: 138 }, 
                recurrenceRule: { freq: 'yearly' }
            }
        ],

        eventRender: function(info) {
            let tooltip = new Tooltip(info.el, {
                title: info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        }
    });

    calendar.render();
});
