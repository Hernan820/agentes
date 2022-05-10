var principalUrl = "http://localhost/agentes/public/";
//var principalUrl = "https://mydailyhours.com/";


$('#modalmantenimiento').on('click', function() {
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

$('#modalmishoras').on('click', function() {
    $("#horasusuario").trigger("reset");
    $('#mishoras').modal('show');
});

$('#calcular').on('click', function() {

    var id = userID;
    var ini = $('#fecha_ini').val();
    var fin = $('#fecha_fin').val();

if( ini == "" || fin == "" ){
     Swal.fire("¡Debe ingresar una cantidad de citas!");  return;
}
$('#totalhoras').val("")
$('#totalcitas').val("")
    axios.post(principalUrl + "registro/horasusuario/"+ini+"/"+fin+"/"+id)
    .then((respuesta) => {
        if(respuesta.data.length != 0){
            var horas = respuesta.data[0].totalhoras.split(':');
        $('#totalhoras').val(respuesta.data[0].name+" total horas: "+ horas[0]+" minutos: "+horas[1]);
        $('#totalcitas').val(respuesta.data[0].name+" total citas: "+respuesta.data[0].totalcitas);
        }else{
            $('#totalhoras').val("No tiene registros");
            $('#totalcitas').val("No tiene registros");    
        }
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});

