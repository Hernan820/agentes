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
                            ")' class='form-control opciones'><option selected='selected' disabled selected>Acciones</option><option value='1'>Eliminar</option></selec></td></tr>"
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


function accionesCupos(option, id) {
    var opt = $(option).val();
    if (opt == "1") {
        $("#mant_cupos").trigger("reset");

        Swal.fire({
            title: "Eliminar Cupo",
            text: "¿Estas seguro de eliminar el cupo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {

                axios.post(principalUrl + "agente/eliminar/" + id)
                    .then((respuesta) => {
                        if (respuesta.data) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Cupo eliminado",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "Este cupo tiene registros",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                        }
                    })
                    .catch((error) => {
                        if (error.response) {
                            console.log(error.response.data);
                        }
                    });
            } 
        });
    } 
    $(option).prop("selectedIndex", 0);

}


 
