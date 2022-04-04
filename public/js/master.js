var principalUrl = "http://localhost/agentes/public/";

$('.modalmantenimiento').click(function(){
        if(window.location.href.indexOf('#Mantcupos') != -1) {
            $("#mostrarcupos").html("");

            axios.post(principalUrl + "agente/mostrarcupos")
            .then((respuesta) => {
                respuesta.data.forEach(function (element) {
                    moment.locale("es");
                    $("#mostrarcupos").append(
                        "<tr><td>" +
                            moment(element.start).format("D / MMMM / YYYY") +
                            "</td><td><select id='cupo_accion' onchange='accionesCupos(this," +
                            element.id +
                            ")' class='form-control opciones'><option selected='selected' disabled selected>Acciones</option><option value='1'>Editar</option><option value='2'>Eliminar</option><option value='3'>Cerrar cupo</option><option value='4'>Abrir cupo</option></selec></td></tr>"
                    );
                });
              })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
          $('#Mantcupos').modal('show');
        }
});




 
