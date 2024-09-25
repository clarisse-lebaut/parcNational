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
         console.log(events);
    
         
         let calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              locale: 'fr',
              headerToolbar: {
                   start: 'title',
                   center: 'dayGridMonth,timeGridWeek,timeGridDay',
                   end: 'prev,next today'
              },
              events: events,
              selectable: true,
              select: function(info) {
                   console.log("Plage de dates sélectionnée : " + info.startStr + " à " + info.endStr);
                   document.getElementById('start_date').value = info.startStr;
                   document.getElementById('end_date').value = info.endStr;
              }
         });
    
         calendar.render();
    });