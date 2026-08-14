//controla el numero de intervalos
const numSus = 14;
let formregistro = document.getElementById("registroHorario");

$(document).ready(function () {
    mostrarboton();
    $('#motivoscoincidencia').hide();
    var fecha = $('#fechas').val().split(' ')[0] ;
    
    axios.post(principalUrl + "horariovalida/usuario/"+fecha)
    .then((respuesta) => {
        $('#hiniciales').val(respuesta.data[0].horasiniciales);
        $('#hfinales').val(respuesta.data[0].horasfinales);
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

});

function mostrarboton(){
    var rol = $("#rol").val();
    if(rol == "administrador"){
        $(".inpCrearRegistro").show();
    }else{
        var idu = $("#usuario_log").val();
        var cupo = $("#id_cupo").val();
        
        axios.get(principalUrl + "registro/conteoregistros/"+ idu+"/"+cupo)
        .then((respuesta) => {
            if(respuesta.data > 0){
                $(".inpCrearRegistro").hide();
            }else{
                $(".inpCrearRegistro").show();
            }
        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });
    }
}

document.getElementById("registro").addEventListener("click", function () {
        $('.oculto').val('');
        $('#registroHorario').trigger("reset");
        $("#CollapseExample1").collapse('hide');
        $("#modal_registro").modal("show");
        $('.entrada').attr('readonly', false)
        $('#motivoscoincidencia').hide();
        $('#motivoshorario').val('');

        $('#btnagregar').attr('disabled', false);
        $('#tabla tr').slice(2).remove();
});

document.getElementById("guardar_registro").addEventListener("click", function () {

    if (validaciondatos() == false) {return;};

    if($('#hiniciales').val() != "" && $('#hfinales').val() != ""){

        if($('#hiniciales').val() != $('#horasiniciales').val() || $('#hfinales').val() != $('#horasfinales').val()){
            if($('#motivoshorario').val() == ''){
            $('#motivoscoincidencia').show();
            $('#motivoshorario').focus();
            Swal.fire("¡Sus horas registradas no coinciden con su horario!     Agregue un motivo");
            return;
            }else if($('#motivoshorario').val().length < 10){
                Swal.fire("¡Agrega un motivo valido");
                return;
            }
        }else{$('#motivoscoincidencia').hide();};
    }
    /*else{
        Swal.fire("¡Ponte en contacto con el administrador,   tu horario de esta semana no ha sido asignado");
        return; 
    }*/


    $('#guardar_registro').attr('disabled', true);

    var datosregistro = new FormData(formregistro);
    var id_registro = $("#id_registro").val();

    if(id_registro == ""){
        
        axios.post(principalUrl + "registro/registrohoras",datosregistro)
        .then((respuesta) => {
            if(respuesta.data == 1){
                $('#registroHorario').trigger("reset");
                $("#modal_registro").modal("hide");
                $('#registro_horas').DataTable().ajax.reload(null, false);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Datos guardados exitosamente!",
                    showConfirmButton: false,
                });  
                mostrarboton();  
            }else{
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Ya existe un registro!",
                    showConfirmButton: false,
                });  
            }
            $('#guardar_registro').attr('disabled', false);

            })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });

    }else if(id_registro != ""){

        axios.post(principalUrl + "registro/actualizar",datosregistro)
        .then((respuesta) => {
            $('#registroHorario').trigger("reset");
            $("#modal_registro").modal("hide");
            $('#registro_horas').DataTable().ajax.reload(null, false);
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Datos actalizados exitosamente!",
                showConfirmButton: false,
            });       
            $('#guardar_registro').attr('disabled', false);

        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });

    }

});

function limpiarcampos(){

   $("#intervalo_horaini").val("");
     $("#intervalo_minini").val("");
    $("#horario_intervalo1").val("");
 
   $("#intervalo_horafin").val("");
 $("#intervalo_minfin").val("");
  $("#horario_intervalo2").val("");
}


$(document).ready(function () {
var idcupo = $("#id_cupo").val();
var usuario = $("#usuario_log").val();
var rol = $("#rol").val();

$('#intervalo').attr('disabled', true);

   if(rol == "administrador"){

    $("#registro_horas").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        ajax: {
            url: principalUrl + "registro/datos/" + idcupo,
            dataSrc: "datos",
        },
        columns: [
            { data: "id",width: "0.5px",
                //contador de filas iniciando en 1 
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "name",width: "50px" },
            { data: "total_horas",width: "50px",    
            render: function (data, type, row) {

                if(data == null){
                    data = "Sin registro";
                }

                return (data+"  Horas");
            }, 
        },
            { data: "total_citas",width: "50px",
            render: function (data, type, row) {

                if(data == null){
                    data = "Sin registro";
                }
                return (data+"    Citas");
            }, },
            { data: "comentarios",width: "50px"},
            {
                data: "id",
                width: "50px",
                className: "text-center",
                render: function (data, type, row) {
                    var id_user = row["id_usuario"];

                    if(rol == "administrador"){
                        return (
                            '<button type="button" class="btn btn-success col-md-4" id="opcionesregistro" onclick="editar('+data+')">Editar</button> <button type="button" class="btn btn-success col-md-4" id="eliminar_regitro" onclick="eliminar('+data+')">Eliminar</button>'
                        );
                    }else if(rol == "agente"){
                        if (id_user == usuario) {
                            return (
                                '<button type="button" class="btn btn-success col-md-4" id="opcionesregistro" onclick="editar('+data+')">Editar</button> <button type="button" class="btn btn-success col-md-4" id="eliminar_regitro" onclick="eliminar('+data+')">Eliminar</button>'
                                );
                        } else {
                            return (
                                '<button type="button" class="btn btn-success col-md-4" id="opcionesregistro" onclick="editar('+data+')">Editar</button>'
                            );
                        }
                    }

                },
            },
        ], 

        // agreg color a las filas que vengan con valor null principalmente en la columna de total horas

        rowCallback: function (row, data) {
            if (data.total_horas == null) {
                $(row).css({
                    "background-color": "#f1e0e1"
                    // ,"display": "none"
                });
            }

        },


    });

   }else if( rol == "agente"){

    $("#registro_horas").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        ajax: {
            url: principalUrl + "registro/datosusuario/" + idcupo+"/"+ usuario,
            dataSrc: "",
        },
        columns: [
            { data: "id",width: "0.5px",
                //contador de filas iniciando en 1 
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "name",width: "50px",
            render: function (data, type, row) {
                return (data);
            }, 
        },
            { data: "total_horas",width: "50px",    
            render: function (data, type, row) {
                return (data+"  Horas");
            }, 
        },
            { data: "total_citas",width: "50px",
            render: function (data, type, row) {
                return (data+"    Citas");
            }, },
            { data: "comentarios",width: "50px",
        
            render: function (data, type, row) {
                return (data);
            },
        
        
        },
            {
                data: "id",
                width: "50px",
                className: "text-center",
                render: function (data, type, row) {
                    var id_user = row["id_usuario"];

                    if(rol == "administrador"){
                        return (
                            '<button type="button" class="btn btn-success col-md-4" id="opcionesregis" onclick="editar('+data+')">Editar</button> <button type="button" class="btn btn-success col-md-4" id="eliminar_regitro" onclick="eliminar('+data+')">Eliminar</button>'
                        );
                    }else if(rol == "agente"){
                        if (id_user == usuario) {
                            return (
                                '<button type="button" class="btn btn-success col-md-4" id="opcionesregis" onclick="editar('+data+')">Editar</button> <button type="button" class="btn btn-success col-md-4" id="eliminar_regitro" onclick="eliminar('+data+')">Eliminar</button>'
                                );
                        } else {
                            return ("");
                        }
                    }

                },
            },
        ],

      
    });
   }
});

function editar(id){

    $('.oculto').val('');
    $('#registroHorario').trigger("reset");

    axios.post(principalUrl + "registro/editaregistro/"+id)
    .then((respuesta) => {
        $('#tabla tr').slice(2).remove();

        if(respuesta.data.comentarios == "Este dia es OFF"){

            $("#diaoff").prop("checked", true);
            $('.entrada').attr('readonly', true)
            $('#btnagregar').attr('disabled', true);
            $("#total_horas").val("00 Horas 00 Minutos")
            $("#total_citas").val("0")
            $("#comentarios").val("Este dia es OFF")
            $("#TotaDeHoras").val("00:00:00")
            $("#horasfinales").val("0")
            $("#horasiniciales").val("0");
            $('.horas').val('')
        }else{
        var horasiniciales = respuesta.data.horasiniciales.split(",");
        var horasfinales = respuesta.data.horasfinales.split(",");

        var filas=0;
        horasiniciales.forEach(function (element) {
            if(filas >= 1){
                    $('#tabla tbody tr:eq(0)').clone().appendTo('#tabla');
                    $(`#tabla tbody tr.fila-fija:eq(${filas})`).addClass(' dinamico');
                    $(`#tabla tbody .masmenos:eq(${filas})`).addClass('elimina');
                    $(`#tabla tbody .masmenos:eq(${filas})`).val("elimina");
            }

            if(filas >= numSus){
                $('#btnagregar').attr('disabled', true);
                $("#btnagregar").attr('disabled','disabled');
            }else{
                $('#btnagregar').attr('disabled', false);
            }
            filas=filas+1;
        });

        var contador =0;
        horasiniciales.forEach(function (element) {
            var horas = $("form select[name='horaini[]']");
            var minutos = $("form input[name='minutosini[]']");
            var horarios = $("form select[name='horarioini[]']");
            if(element != ""){
                var horario = moment(element,'HH:mm:ss').format('hh:mm A').split(" ");
                var hora = horario[0].split(":");

                horas.eq(contador).val(hora[0]) ;
                minutos.eq(contador).val(hora[1]) ;
                horarios.eq(contador).val(horario[1]) ;
    
                contador=contador+1;
            }
        });


        var contadorf =0;
        horasfinales.forEach(function (element) {
            var horas2 = $("form select[name='horaini2[]']");
            var minutos2 = $("form input[name='minutosini2[]']");
            var horarios2 = $("form select[name='horarioini2[]']");
            if(element != ""){
                var horario = moment(element,'HH:mm:ss').format('hh:mm A').split(" ");
                var hora = horario[0].split(":");

                horas2.eq(contadorf).val(hora[0]) ;
                minutos2.eq(contadorf).val(hora[1]) ;
                horarios2.eq(contadorf).val(horario[1]) ;
    
                contadorf=contadorf+1;
            }
        });

        var totalh = respuesta.data.total_horas.split(":");

        formregistro.total_horas.value = totalh[0]+" Horas "+totalh[1]+" Minutos";
        formregistro.total_citas.value = respuesta.data.total_citas;
        formregistro.comentarios.value = respuesta.data.comentarios;
        formregistro.horasiniciales.value = respuesta.data.horasiniciales;
        formregistro.horasfinales.value = respuesta.data.horasfinales;
        if($('#hiniciales').val() != respuesta.data.horasiniciales || $('#hfinales').val() != respuesta.data.horasfinales){
            formregistro.motivoshorario.value = respuesta.data.motivo;
            $('#motivoscoincidencia').show();
        }else{$('#motivoscoincidencia').hide();}
        formregistro.TotaDeHoras.value = respuesta.data.total_horas;
    }
        formregistro.id_registro.value = respuesta.data.id;

        $("#modal_registro").modal("show");
          
    }).catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

}

//**************NUEVO CODIGO */

$('#agregar').on('click', function() {
     num = $('#tabla tbody tr.fila-fija').length;

    $('#tabla tbody tr:eq(0)').clone().appendTo('#tabla');
    $(`#tabla tbody tr.fila-fija:eq(${num})`).addClass(' dinamico');

    $(`#tabla tbody .masmenos:eq(${num})`).addClass('elimina');
    $(`#tabla tbody .masmenos:eq(${num})`).val("elimina");

    if(num == numSus) {
        $('#btnagregar').attr('disabled', true);
        $("#btnagregar").attr('disabled','disabled');

    }
});


$(document).on('click', '.elimina',function() {
    $(this).closest('tr').remove();
    $('#btnagregar').attr('disabled', false);
    $("#horasiniciales").val("");
    $("#horasfinales").val("");
    hora();
});

function hora(){

    $("#horasiniciales").val("");
    $("#horasfinales").val("");
    var sumatodashoras = moment.duration(0);

    var horas = $("form select[name='horaini[]']");
    var minutos = $("form input[name='minutosini[]']");
    var horarios = $("form select[name='horarioini[]']");

    var horas2 = $("form select[name='horaini2[]']");
    var minutos2 = $("form input[name='minutosini2[]']");
    var horarios2 = $("form select[name='horarioini2[]']");

    horas.each(function(i) {

        var hora =  $(this).val() ;
        var minuto = minutos.eq(i).val() ;
        var horario = horarios.eq(i).val() ;

        var hora2 = horas2.eq(i).val() ;
        var minuto2 = minutos2.eq(i).val() ;
        var horario2 = horarios2.eq(i).val() ;

        if(minuto > 59){
            minutos.eq(i).val("")
            Swal.fire({
                position: "top-end",
                icon: "info",
                title: "Los minutos no pueden ser mayor a 59 min!",
                showConfirmButton: false,
            }); 
        }

        if(minuto2 > 59){
            minutos2.eq(i).val("")
            Swal.fire({
                position: "top-end",
                icon: "info",
                title: "Los minutos no pueden ser mayor a 59 min!",
                showConfirmButton: false,
            }); 
        }
       
        var horaprocesada = moment.duration(moment(hora2+":"+minuto2+":00 "+horario2, "HH:mm:ss a").diff(moment(hora+":"+minuto+":00 "+horario, "HH:mm:ss a")));
        var totalrango = moment(horaprocesada.hours()+":"+horaprocesada.minutes()+":00","H:mm:ss").format("HH:mm:ss");
        var horasiniciales =   moment(hora+":"+minuto+":00 "+horario,"h:mm:ss A").format("HH:mm:ss");
        var horasfinales =   moment(hora2+":"+minuto2+":00 "+horario2,"h:mm:ss A").format("HH:mm:ss");

        if(i == 0 && hora != null && horario != null ){
            if(horasiniciales < "06:00:00"){
                horas.eq(i).val("") ;
                minutos.eq(i).val("") ;
                horarios.eq(i).val("") ;
                Swal.fire({
                    position: "top-center",
                    icon: "info",
                    title: "¡La hora inicial no puede ser menor a las 6 am!",
                    showConfirmButton: false,
                }); 
                return;
            }
        }

        if(hora2 != null  && horario2 != null){
           if(horasfinales <= horasiniciales){
                horas2.eq(i).val("") ;
                minutos2.eq(i).val("") ;
                horarios2.eq(i).val("") ;
                Swal.fire({
                    position: "top-end",
                    icon: "info",
                    title: "La hora final no puede ser menor o igual a la hora inicial!",
                    showConfirmButton: false,
                }); 
                return;
            }
        }

        if(hora2 != null  && horario2 != null){
            sumatodashoras.add(totalrango);

            if($("#horasiniciales").val() == ""){
                $("#horasiniciales").val(horasiniciales);
            }else {
                $("#horasiniciales").val(function(i, currVal) {
                    return currVal +","+ horasiniciales;
                });
            }

            if($("#horasfinales").val() == ""){
                $("#horasfinales").val(horasfinales)
            }else{
                $("#horasfinales").val(function(i, currVal) {
                    return currVal +"," +horasfinales;
                });
            }
        }
     
        if(i >= 1){

            if( $(this).val() != null  && horario != null){
                var horasfinales =   moment(horas2.eq(i-1).val()+":"+minutos2.eq(i-1).val()+":00 "+horarios2.eq(i-1).val(),"h:mm:ss A").format("HH:mm:ss");
            
                var horasiniciales =   moment(hora+":"+minuto+":00 "+horario,"h:mm:ss A").format("HH:mm:ss");
        
                if(horasiniciales <= horasfinales){
                    $(this).val("")  ;
                    minutos.eq(i).val("") ;
                    horarios.eq(i).val("") ;
                    Swal.fire({
                        position: "top-end",
                        icon: "info",
                        title: "Este intervalo no puede tener horas menores al anterior!",
                        showConfirmButton: false,
                    }); 
                }
            }
        }
    });
      
    formateada = moment.utc(sumatodashoras.asMilliseconds()).format("HH:mm:ss") 
    var arr= formateada.split(":");
     //console.log(arr);
    $("#total_horas").val(arr[0]+" Horas "+arr[1]+" Minutos")

    $("#TotaDeHoras").val(formateada)
};


$('tbody').on('change','tr.fila-fija',function() {
    hora();
});


function validaciondatos() {
    var valido = true;

    var horas = $("form select[name='horaini[]']");
    var minutos = $("form input[name='minutosini[]']");
    var horarios = $("form select[name='horarioini[]']");

    var horas2 = $("form select[name='horaini2[]']");
    var minutos2 = $("form input[name='minutosini2[]']");
    var horarios2 = $("form select[name='horarioini2[]']");

   var citas = $("#total_citas").val();

   if(citas == ""){
    Swal.fire("¡Debe ingresar una cantidad de citas!");
    valido = false;
   }

   if( !$('#diaoff').is(':checked') ) {

    horas.each(function(i) {
        if( $(this).val() == null){
            Swal.fire("¡Debe completar todas las horas!");
            valido = false;
        }
    });

    minutos.each(function(i) {
        if( $(this).val() > 59){
            $(this).val("")
            Swal.fire("¡Los minutos no pueden ser mayor a 59 min!");
            valido = false;
        }
    });
    
    horarios.each(function(i) {
        if( $(this).val() == null){
            Swal.fire("¡Debe completar el turno!");
            valido = false;
        }
    });

    horas2.each(function(i) {
        if( $(this).val() == null){
            Swal.fire("¡Debe completar todas las horas!");
            valido = false;
        }
    });

    minutos2.each(function(i) {
        if( $(this).val() > 59){
            $(this).val("")
            Swal.fire("¡Los minutos no pueden ser mayor a 59 min!");
            valido = false;
        }
    });

    horarios2.each(function(i) {
        if( $(this).val() == null){
            Swal.fire("¡Debe completar el turno!");
            valido = false;
        }
    });
   }

    return valido;
}


function eliminar(id){

    Swal.fire({
        title: "Eliminar",
        text: "¿Estas seguro de eliminar el registro?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Continuar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
    
            axios.put(principalUrl + "registro/"+id)
            .then((respuesta) => {
        
                if(respuesta.data == 1){
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "¡Registro eliminado exitosamente!",
                        showConfirmButton: false,
                    }); 
                }
                mostrarboton();
                $('#registro_horas').DataTable().ajax.reload(null, false);
               
            }).catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
        } else {
        }
    });
}

$('#diaoff').on('click', function() {
  
    if( $('#diaoff').is(':checked') ) {

Swal.fire({
        title: "Eliminar",
        text: "¿Quieres agregar tu registro en estado OFF ?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "SI",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $("#total_horas").val("00 Horas 00 Minutos")
            $("#total_citas").val("0")
            $("#comentarios").val("Este dia es OFF")
           $('.entrada').attr('readonly', true)
           $('#btnagregar').attr('disabled', true);
            $("#TotaDeHoras").val("00:00:00")
            $("#horasfinales").val("0")
            $("#horasiniciales").val("0");
            $('.horas').val('')
        } else {
            $("#diaoff").prop("checked", false);

        }
    });
    }else if(!$('#diaoff').is(':checked')){

        $('.entrada').attr('readonly', false)
        $('#btnagregar').attr('disabled', false);

        $("#total_horas").val("")
        $("#total_citas").val("")
        $("#comentarios").val("")


        $("#TotaDeHoras").val("")
        $("#horasfinales").val("")
        $("#horasiniciales").val("");

    }

});

function generarReporte(){

    var id_Cupo = $("#id_cupo").val();

    axios.get(principalUrl + "registro/datos/"+id_Cupo)
        .then(function(response){

            let usuarios = response.data.datos;

            let conHoras = [];
            let sinHoras = [];

            usuarios.forEach(usuario => {
                if(usuario.total_horas){
                    conHoras.push(
                        `${usuario.name}`
                    );
                }else{
                    sinHoras.push(usuario.name);
                }
            });

            let hoy = response.data.fecha_cupo_humanizada;
            let reporte = "";

            reporte += "📋 REPORTE DE HORAS\n";
            reporte += "Fecha: " + hoy + "\n\n";
            reporte += "✅ Con horas (" + conHoras.length + ")\n";

            if(conHoras.length){
                conHoras.forEach(nombre => {
                    reporte += "- " + nombre + "\n";
                });
            }else{
                reporte += "Ninguno\n";
            }

            reporte += "\n";
            reporte += "❌ Sin horas (" + sinHoras.length + ")\n";

            if(sinHoras.length){
                sinHoras.forEach(nombre => {
                    reporte += "- " + nombre + "\n";
                });
            }else{
                reporte += "Ninguno\n";
            }

            $("#txtReporte").val(reporte);
            $("#modalReporte").modal("show");

        });
}

function copiarReporte(){

    let texto = $("#txtReporte").val();

    navigator.clipboard.writeText(texto)
    .then(function(){

        swal.fire({
            title: "¡Copiado!",
            text: "El reporte ha sido copiado al portapapeles.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });

    });
}

$('#registro_habilitado').on('change', function () {

    let habilitado = $(this).is(':checked') ? 1 : 0;
    let cupoId = $("#id_cupo").val();

    axios.post( principalUrl+'cupo/registro-habilitado', {
        cupo_id: cupoId,
        registro_habilitado: habilitado
    })
    .then(function (response) {

        swal.fire({
            title: "Actualizado!",
            text: "Cupo actualizado correctamente!",
            icon: "success",
            timer: 1000,
            showConfirmButton: false
        });
        location.reload();
    })
    .catch(function (error) {
        console.error('Error al actualizar el estado:', error);
        $('#registro_habilitado').prop('checked', !habilitado);
    });
});
