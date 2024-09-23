document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Vue par défaut
        locale: 'fr', 

        // HEADER calendar
        headerToolbar: {
            start: 'title', //reculer/avancer/aujourd'hui
            center: 'dayGridMonth,timeGridWeek,timeGridDay', 
            end: 'prev,next today' // boutons des vues
        },

        events: [] 
    });

    calendar.render();
});