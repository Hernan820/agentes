

let formcupo = document.getElementById("formcupo");

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

                    $("#modal_cupo").modal("show");

                    

                  },
              },
          },
 
          locale: "es",
          displayEventTime: false,
          events: principalUrl + "agente/mostrar",
 
          eventClick: function (info) {
              var eventCupo = info.event._def;
              location.href = principalUrl + "registro/" + eventCupo.publicId;
          },
        



        });
        calendar.render();
      });

      document.getElementById("guardarcupo").addEventListener("click", function () {

        var datoscupo = new FormData(formcupo);


        axios.post(principalUrl + "agente/cupo", datoscupo)
        .then((respuesta) => {
          respuesta.data

        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });
      });

