let fromfechas = document.getElementById("formFechas");

$(document).ready(function () {

    $('#excel').hide('hide');


  // $('#excel').css("display", "none");
});

document.getElementById("btnReporte").addEventListener("click", function () {
    if (validacionfechas() == false) { return;}

    var datosfechas = new FormData(fromfechas);
    $("#insertadatoshoras").html("");
    $('#btnReporte').attr('disabled', true);

        var primero = new Promise((resolve, reject) => {
            axios.post(principalUrl + "registro/idusuario", datosfechas)
            .then((respuest) => {
                
                respuest.data.forEach(function (element, index,array) {

                    axios.post( principalUrl + "registro/reporte/" + element.id,datosfechas)
                        .then((respuesta) => {

                            if(respuesta.data.length != 0){
                                respuesta.data.forEach(function (element) {
                                    var h2 =0;
                                  var horas1 =  element.horasiniciales.split(",");
                                  var horas2 =  element.horasfinales.split(",");
                                  num = $('#registro_horas tbody tr.reporte').length;
    
                                        $("#insertadatoshoras").append(
                                            "<tr class ='reporte'><td>" +
                                                element.name +
                                                "</td><td>" +
                                                moment(element.start).format( " D / MMMM / YYYY") +
                                                "</td><td></td><td>" +
                                                element.total_horas +
                                                "</td><td>" +
                                                element.total_citas +
                                                "</td></tr>"
                                        );
    
                                            
                                        horas1.forEach(function (horai) {
                                                let td = $('#insertadatoshoras tr').eq(num).find('td').eq(2);
                                                td.html(td.html()+moment(horai,'HH:mm:ss').format('hh:mm A')+" / "+moment(horas2[h2],'HH:mm:ss').format('hh:mm A')+"<br/>"); 
                                            h2++;
                                                   })
                                });
        
                                $("#insertadatoshoras").append(
                                    "<tr class='reporte'><td><b>TOTAL</td><td><b>-----------------</td><td><b>-----------------</td><td><b>" +
                                        respuesta.data[0].horasTotal +
                                        " Horas</td><td><b>" +
                                        respuesta.data[0].citasTotal +
                                        " Citas</td></tr>"
                                );
                            }else{
                            }

                           
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

             if(resp.data[0].totalhoras != null){
                $("#insertadatoshoras").append(
                    "<tr class='reporte'><td><b>TOTAL</td><td><b>*******************</td><td><b>****************</td><td><b>Total de Horas  &nbsp;" +
                    resp.data[0].totalhoras +
                        "</td><td><b> Total de Citas  &nbsp;" +
                        resp.data[0].totalcitas +
                        "</td></tr>");

                        $('#excel').hide('hide');

                        $('#excel').show('show'); 

             }else{
                $("#insertadatoshoras").append(
                    "<tr class='reporte'><td>Ningún dato disponible</td><td>Ningún dato disponible</td><td>Ningún dato disponible</td><td>Ningún dato disponible</td><td>Ningún dato disponible</td></tr>");
                        $("#formFechas").trigger("reset");
                        $('#btnReporte').attr('disabled', false);
                        $('#excel').hide('hide');
   
             }
            // $("#formFechas").trigger("reset");
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

    if(fechainicial > fechafinal){
        Swal.fire("¡La hora final debe ser mayor!");
        valido = false;
    }

    if (fechainicial === "" || fechafinal === "") {
        Swal.fire("¡Debe completar todos los datos!");
        valido = false;
    }
    return valido;
}

document.getElementById("excel").addEventListener("click", function () {
    if (validacionfechas() == false) { return;}
    
   var fecha1 = $("#fechainicio").val();
   var fecha2 = $("#fechafinal").val();
   var ruta = principalUrl+ "registro/excel/"+fecha1+"/"+fecha2;
    window.open(ruta, '_blank'  );

                           $("#formFechas").trigger("reset");

                           $('#excel').hide('hide');


   // window.open(, '_blank');
   // location.href= principalUrl+ "registro/excel",fechas;


});
