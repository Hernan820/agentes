
let fromfechas = document.getElementById("formFechas");



document.getElementById("btnReporte").addEventListener("click", function () {
    if (validacionfechas() == false) { return; }

    console.log(fromfechas.fechainicio.value);

var datosfechas = new FormData(fromfechas);
$("#insertadatoshoras").html("");

    axios.post(principalUrl + "registro/reporte",datosfechas)
    .then((respuesta) => {
        $('#formFechas').trigger("reset");

        respuesta.data.forEach(function (element) {
            $("#insertadatoshoras").append(
                "<tr><td>" +
                    element.name +
                    "</td><td>" +
                    element.fecha_inicio+
                    "</td><td>" +
                    element.fecha_final +
                    "</td><td>" +
                    element.horas +
                    "</td><td>" +
                    element.citas +
                    "</td></tr>"
            );
        });

        $("#insertadatoshoras").append(
            "<tr class=''><td><b>TOTAL</td><td><b>-----------------</td><td><b>-----------------</td><td><b>" 
            + respuesta.data[0].total_tiempo +" Horas</td><td><b>" +respuesta.data[0].total_citas +" Citas</td></tr>"
        );

        })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

});



 function validacionfechas(){
    var valido = true;
    var fechainicial = $("#fechainicio").val();
    var fechafinal = $("#fechafinal").val();

        if (
            fechainicial === "" ||
            fechafinal === "" 
        ) {
            Swal.fire("¡Debe completar todos los datos!");
            valido = false;
        }
    
    return valido;
 }
