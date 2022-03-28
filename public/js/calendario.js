

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendario');
        var calendar = new FullCalendar.Calendar(calendarEl, {

            initialView: 'dayGridMonth',

            locale: "es",
            displayEvenTime: false,
    
            headerToolbar: {
                right: "custom2 prev,next",
            },
            customButtons: {
              custom2: {
                  text: "Crear Cupo",
                  click: function () {
                  },
              },
          },
        });
        calendar.render();
      });
