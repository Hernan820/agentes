

let formcupo = document.getElementById("formcupohorario");

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('horarios');
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
              $('#formcupohorario').trigger("reset");
              $("#modal_cupo_horario").modal("show");
            },
        },
    },

    locale: "es",
    displayEventTime: false,
    events: principalUrl + "agente/horarios",

    eventClick: function (info) {
        var eventCupo = info.event._def;
        location.href = principalUrl + "horario/mostrar/" + eventCupo.publicId;
    },

  });
  calendar.render();
});


document.getElementById("guardarcupohorario").addEventListener("click", function () {
  if (validarmodal() == false) { return; }

  var datoscupo = new FormData(formcupo);  
        
  axios.post(principalUrl + "horario/cupo", datoscupo)
  .then((respuesta) => {


    $("#modal_cupo_horario").modal("hide");
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

