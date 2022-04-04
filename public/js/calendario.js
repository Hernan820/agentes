

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
                    $('#formcupo').trigger("reset");
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
        if (validarmodal() == false) {
          return;
       }
        var datoscupo = new FormData(formcupo);  
              
        axios.post(principalUrl + "agente/cupo", datoscupo)
        .then((respuesta) => {
          $("#modal_registro").modal("hide");
          location.reload();
        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });
      });

      function validarmodal(){
        var valido = true;
        var fechainicio = $("#start").val();
        var fechafinal = $("#end").val();

        if (
          fechainicio === "" ||
          fechafinal === "" 
      ) {
          Swal.fire("¡Error debe completar todos los datos!");
          valido = false;
      }
        return valido;
      }

