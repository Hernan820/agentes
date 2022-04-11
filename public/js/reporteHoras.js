let fromfechas = document.getElementById("formFechas");

document.getElementById("btnReporte").addEventListener("click", function () {
    if (validacionfechas() == false) {
        return;
    }

    var datosfechas = new FormData(fromfechas);
    $("#insertadatoshoras").html("");
    $('#btnReporte').attr('disabled', true);

        var primero = new Promise((resolve, reject) => {
            axios.post(principalUrl + "registro/idusuario", datosfechas)
            .then((respuest) => {
    
                respuest.data.forEach(function (element, index,array) {
    
                    axios.post( principalUrl + "registro/reporte/" + element.id,datosfechas)
                        .then((respuesta) => {
    
                            respuesta.data.forEach(function (element) {
                                if (element.intervalo_ini == null &&
                                    element.intervalo_fin == null) {
                                    $("#insertadatoshoras").append(
                                        "<tr><td>" +
                                            element.name +
                                            "</td><td>" +
                                            moment(element.start).format( " D / MMMM / YYYY") +
                                            "</td><td>" +
                                            moment(element.hora_ini, "H:mm").format("hh:mm A") +
                                            " / " +
                                            moment(element.hora_fin, "H:mm").format( "hh:mm A") +
                                            "</td><td>" +
                                            element.total_horas +
                                            "</td><td>" +
                                            element.total_citas +
                                            "</td></tr>"
                                    );
                                } else {
                                    $("#insertadatoshoras").append(
                                        "<tr><td>" +
                                            element.name +
                                            "</td><td valign='middle'>" +
                                            moment(element.start).format(" D / MMMM / YYYY") +
                                            "</td><td>" + 
                                            moment(element.hora_ini, "H:mm").format("hh:mm A") +
                                            " / " +
                                            moment(element.hora_fin, "H:mm").format("hh:mm A") +
                                            "<br/>" +
                                            moment( element.intervalo_ini,"H:mm").format("hh:mm A") +
                                            " / " +
                                            moment(element.intervalo_fin,"H:mm").format("hh:mm A") +
                                            "</td><td>" +
                                            element.total_horas +
                                            "</td><td>" +
                                            element.total_citas +
                                            "</td></tr>"
                                    );
                                }
                            });
    
                            $("#insertadatoshoras").append(
                                "<tr class=''><td><b>TOTAL</td><td><b>-----------------</td><td><b>-----------------</td><td><b>" +
                                    respuesta.data[0].horasTotal +
                                    " Horas</td><td><b>" +
                                    respuesta.data[0].citasTotal +
                                    " Citas</td></tr>"
                            );
                            resolve('done');

                        })
                        .catch((error) => {
                            if (error.response) {
                                console.log(error.response.data);
                                reject('fail');
                            }
                        });
                });
                
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
        });
        
        primero.then(() => {
            axios.post( principalUrl + "registro/total",datosfechas)
            .then((resp) => {
    
                $("#insertadatoshoras").append(
                    "<tr class=''><td><b>TOTAL</td><td><b>*******************</td><td><b>****************</td><td><b>Total de Horas  &nbsp;" +
                    resp.data[0].totalhoras +
                        "</td><td><b> Total de Citas  &nbsp;" +
                        resp.data[0].totalcitas +
                        "</td></tr>");
                        $("#formFechas").trigger("reset");
                        $('#btnReporte').attr('disabled', false);

            })
            .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
            });       
        
        });



});


function validacionfechas() {
    var valido = true;
    var fechainicial = $("#fechainicio").val();
    var fechafinal = $("#fechafinal").val();

    if (fechainicial === "" || fechafinal === "") {
        Swal.fire("¡Debe completar todos los datos!");
        valido = false;
    }

    return valido;
}
