let fromfechas = document.getElementById("formFechas");

$(document).ready(function () {

    $('#excel').hide('hide');


    axios.post(principalUrl + "registro/accesoagentes")
    .then((respuesta) => {

        if(respuesta.data.acceso == 0){
            $('#desactivar').prop('checked', true);
        }else{
            $('#desactivar').prop('checked', false);
        }
    }).catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

  // $('#excel').css("display", "none");
});



    document.getElementById("btnReporte").addEventListener("click", function () {
        if (validacionfechas() == false) { return;}
    
        var datosfechas = new FormData(fromfechas);
        $("#insertadatoshoras").html("");
        $('#btnReporte').attr('disabled', true);
    
    
    
                        axios.post( principalUrl + "registro/reportehoras",datosfechas)
                            .then((respuesta) => {
    
                                if(respuesta.data.reportehoras.length != 0){
                                    var to = 0;

                                    respuesta.data.reportehoras.forEach(function (element,i) {

                                        if( element.id != respuesta.data.totales[to].id){
                                            $("#insertadatoshoras").append(
                                                "<tr class='reporte'><td><b>TOTAL</td><td><b>"+respuesta.data.totales[to].name+"</td><td><b>------------------------<b></td><td><b>" +
                                                    respuesta.data.totales[to].hours +
                                                    " Horas</td><td><b>" +
                                                    respuesta.data.totales[to].citas +
                                                    " Citas</td></tr>"
                                            );
                                            to++;
                                        }

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
                                                if(horai == "0" && horas2[h2] == "0"){
                                                    let td = $('#insertadatoshoras tr').eq(num).find('td').eq(2);
                                                    td.html("Este dia es OFF"); 
                                                 //   td.css("color", "#33ECFF");
                                                
                                                }else{
                                                    let td = $('#insertadatoshoras tr').eq(num).find('td').eq(2);
                                                    td.html(td.html()+moment(horai,'HH:mm:ss').format('hh:mm A')+" / "+moment(horas2[h2],'HH:mm:ss').format('hh:mm A')+"<br/>"); 
                                                }

                                                h2++;
                                                       })




                                                       if(i == respuesta.data.reportehoras.length - 1){
                                                        $("#insertadatoshoras").append(
                                                            "<tr class='reporte'><td><b>TOTAL</td><td><b>"+respuesta.data.totales[to].name+"</td><td><b>------------------------<b></td><td><b>" +
                                                                respuesta.data.totales[to].hours +
                                                                " Horas</td><td><b>" +
                                                                respuesta.data.totales[to].citas +
                                                                " Citas</td></tr>"
                                                        );
                                                    }
                                    });
            
                                    $("#insertadatoshoras").append(
                                        "<tr class='reporte'><td><b>TOTAL</td><td><b>********************</td><td><b>*******************</td><td><b>"+respuesta.data.totalfinal[0].hours+" Horas</td><td><b>"+respuesta.data.totalfinal[0].citas+"  Citas</td></tr>"
                                    );
                                }else{
                                    $("#insertadatoshoras").append(
                                        "<tr class='reporte'><td>No hay registros</td><td>No hay registros</td><td>No hay registros</td><td>No hay registros</td><td>No hay registros</td></tr>"
                                    );
                                }

                                $('#excel').hide();

                                $('#excel').show('show');
                                $('#btnReporte').attr('disabled', false);

                            })
                            .catch((error) => {
                                if (error.response) {
                                    console.log(error.response.data);
                                }
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




document.getElementById("desactivar").addEventListener("click", function () {

    

});

     
$('#desactivar').on('change', function() {


    if ($(this).is(':checked') ) {

        Swal.fire({
            title: "Desactivar Usuarios",
            text: "¿Estas seguro de desactivar los accesos a todos los agentes ?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
        
                axios.get(principalUrl + "registro/acceso/"+0)
                .then((respuesta) => {
            
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Acceso de agentes desactivado exitosamente!",
                        showConfirmButton: false,
                        
                    });


                }).catch((error) => {
                    if (error.response) {
                        console.log(error.response.data);
                    }
                });
            } else {
                $('#desactivar').prop('checked', false);

            }
        });
       

    } else {

        Swal.fire({
            title: "Activar Usuarios",
            text: "¿Estas seguro de activar los accesos a todos los agentes ?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
        
                axios.get(principalUrl + "registro/acceso/"+1)
                .then((respuesta) => {
            
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Acceso de agentes activados exitosamente!",
                        showConfirmButton: false,
                        
                    });


                }).catch((error) => {
                    if (error.response) {
                        console.log(error.response.data);
                    }
                });
            } else {
                $('#desactivar').prop('checked', true);

            }
        });

    }


});