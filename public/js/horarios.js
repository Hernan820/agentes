//controla el numero de intervalos
const numf = 4;

$(document).ready(function () {

  $('#tablahorarios').hide();
});


function fechashorario(fecha1,fecha2){

  var f1 = fecha1.split("/");
  var f2 = fecha2.split("/");

var fechauno = f1[2]+"-"+f1[0]+"-"+f1[1];
var fechados= f2[2]+"-"+f2[0]+"-"+f2[1];

  var ini = moment(fechauno);
  var fin = moment(fechados);
  
  if(ini != undefined && fin != undefined){
    $('#dias').empty();
    var fechas = [];
    
    while (ini.isSameOrBefore(fin)) {
      fechas.push(ini.format('M/D/YYYY'));
      ini.add(1, 'days');
    }

    $("#lunes").html(moment(fechas[0]).format('dddd DD'));
    $("#martes").html(moment(fechas[1]).format('dddd DD'));
    $("#miercoles").html(moment(fechas[2]).format('dddd DD'));
    $("#jueves").html(moment(fechas[3]).format('dddd DD'));
    $("#viernes").html(moment(fechas[4]).format('dddd DD'));
    $("#sabado").html(moment(fechas[5]).format('dddd DD'));
    $("#domingo").html(moment(fechas[6]).format('dddd DD'));

    $("#titulo1").html(moment(fechas[0]).format('dddd'));
    $("#titulo2").html(moment(fechas[1]).format('dddd'));
    $("#titulo3").html(moment(fechas[2]).format('dddd'));
    $("#titulo4").html(moment(fechas[3]).format('dddd'));
    $("#titulo5").html(moment(fechas[4]).format('dddd'));
    $("#titulo6").html(moment(fechas[5]).format('dddd'));
    $("#titulo7").html(moment(fechas[6]).format('dddd'));
    
    $("#fechadia1").val(moment(fechas[0]).format('YYYY-MM-DD'));
    $("#fechadia2").val(moment(fechas[1]).format('YYYY-MM-DD'));
    $("#fechadia3").val(moment(fechas[2]).format('YYYY-MM-DD'));
    $("#fechadia4").val(moment(fechas[3]).format('YYYY-MM-DD'));
    $("#fechadia5").val(moment(fechas[4]).format('YYYY-MM-DD'));
    $("#fechadia6").val(moment(fechas[5]).format('YYYY-MM-DD'));
    $("#fechadia7").val(moment(fechas[6]).format('YYYY-MM-DD'));

    $('#tablahorarios').show();


    $("#dias").append('<th scope="col">Usuarios</th>');

      fechas.forEach(function (element) {   

      var d = moment(element).format('dddd DD');
      $("#dias").append('<th scope="col">'+d+'</th>');
    })
    $("#dias").append('<th scope="col">Total de horas</th>');

  }
}


$('#crearhorario').on('click', function() {
    var fechas = $("#rango_fechas").val().split(" - ");
    fechashorario(fechas[0],fechas[1]);
});


$('#horariodeusuario').on('click', function() {
  $('#usuarios').empty();
  $("#rango_fechas").val("");

  axios.post(principalUrl + "hoarios/agentes")
    .then((respuesta) => {
  
      $("#usuarios").append("<option selected='selected' disabled selected value=''>usuarios</option>" );
  
      respuesta.data.forEach(function (element) {   
  
      $("#usuarios").append("<option value="+element.id+">"+element.name+"</option>" );
         })
  
      $('#modal_cupo_horario').show();
  
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});




// LOGICA DE FORMULARIO DEL DIA 1



function hora(id,muestrahoras,hini,hfin,htotal){

 
$("#"+hini).val("");
$("#"+hfin).val("");
var sumatodashoras = moment.duration(0);

var horas = $(id+" tbody  select[name='horaini[]']");
var minutos = $(id+" tbody  input[name='minutosini[]']");
var horarios = $(id+" tbody  select[name='horarioini[]']");

var horas2 = $(id+" tbody  select[name='horaini2[]']");
var minutos2 = $(id+" tbody  input[name='minutosini2[]']");
var horarios2 = $(id+" tbody  select[name='horarioini2[]']");

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

    if($("#"+hini).val() == ""){
        $("#"+hini).val(horasiniciales);
    }else {
        $("#"+hini).val(function(i, currVal) {
            return currVal +","+ horasiniciales;
         });
    }

    if($("#"+hfin).val() == ""){
        $("#"+hfin).val(horasfinales)
    }else{
        $("#"+hfin).val(function(i, currVal) {
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

  
  })

  
  formateada = moment.utc(sumatodashoras.asMilliseconds()).format("HH:mm:ss") 
 var arr= formateada.split(":");
  $("#"+muestrahoras).val(arr[0]+" Horas "+arr[1]+" Minutos")

  $("#"+htotal).val(formateada)


}


function btonagrega(tablaid,bton){
  var numero =tablaid.slice(-1);
  num = $('#'+tablaid+' tbody tr.fila-fija').length;

 $('#'+tablaid+' tbody tr:eq(0)').clone().appendTo('#'+tablaid+'');
 $(`#`+tablaid+` tbody tr.fila-fija:eq(${num})`).addClass(' dinamico');

 $(`#`+tablaid+` tbody .masmenos:eq(${num})`).addClass('elimina'+numero);
 $(`#`+tablaid+` tbody .masmenos:eq(${num})`).val("elimina"); 

 if(num == numf) {
     $(bton).attr('disabled', true);
     $(bton).attr('disabled','disabled');
 }
}


function btnelimina(btn){

  $(btn).closest('tr').remove();
  $('#btnagregar1').attr('disabled', false);
}




$('.offdia').on('click', function() {

    console.log(this.id);

    var numero = this.id.slice(-1);
    
  if( $('#diaoff'+numero).is(':checked') ) {

Swal.fire({
      title: "OFF",
      text: "¿Quieres agregar este dia en estado OFF ?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "SI",
      cancelButtonText: "Cancelar",
  }).then((result) => {
      if (result.isConfirmed) {

          $("#totalhorasdia"+numero).val("00 Horas 00 Minutos");
          $("#horas_iniciales_dia"+numero).val("0");
          $("#horas_finales_dia"+numero).val("0");
          $("#total_horasdia"+numero).val("00:00:00");

          $('.elimina'+numero).attr('readonly', true);
          $('.elimina'+numero).attr('disabled', true);
         // $('.elimina'+numero).remove();
          $('.horas'+numero).attr('readonly', true);
           $('.horas'+numero).attr('disabled', true);  

          $('#btnagregar'+numero).attr('disabled', true);
          $('.horas'+numero).val('');
      } else {
          $("#diaoff").prop("checked", false);

      }
  });
  }else if(!$('#diaoff'+numero).is(':checked')){


          $('.elimina'+numero).attr('readonly', false);
          $('.elimina'+numero).attr('disabled', false);
         // $('.elimina'+numero).remove();
          $('.horas'+numero).attr('readonly', false);
           $('.horas'+numero).attr('disabled', false);  

      $('#btnagregar'+numero).attr('disabled', false);

      $("#horas_iniciales_dia"+numero).val("");
      $("#horas_finales_dia"+numero).val("")
      $("#total_horasdia"+numero).val("")

  }

});










//   BOTONES DE AGREAR INTERVALO, ELIMINA INTERVALO Y CHANGE DE TABLA


// BTNELIMINA
$(document).on('click', '.elimina1',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia1]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia1]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia1]").prop("id");
  var totalh = $("form input[name=total_horasdia1]").prop("id");
  hora('#tabladia1',totalhmuestra,hiniciales,hfinales,totalh);
});

$(document).on('click', '.elimina2',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia2]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia2]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia2]").prop("id");
  var totalh = $("form input[name=total_horasdia2]").prop("id");
  hora('#tabladia2',totalhmuestra,hiniciales,hfinales,totalh);
});

$(document).on('click', '.elimina3',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia3]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia3]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia3]").prop("id");
  var totalh = $("form input[name=total_horasdia3]").prop("id");
  hora('#tabladia3',totalhmuestra,hiniciales,hfinales,totalh);
});

$(document).on('click', '.elimina4',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia4]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia4]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia4]").prop("id");
  var totalh = $("form input[name=total_horasdia4]").prop("id");
  hora('#tabladia4',totalhmuestra,hiniciales,hfinales,totalh);
});

$(document).on('click', '.elimina5',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia5]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia5]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia5]").prop("id");
  var totalh = $("form input[name=total_horasdia5]").prop("id");
  hora('#tabladia5',totalhmuestra,hiniciales,hfinales,totalh);
});

$(document).on('click', '.elimina6',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia6]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia6]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia6]").prop("id");
  var totalh = $("form input[name=total_horasdia6]").prop("id");
  hora('#tabladia6',totalhmuestra,hiniciales,hfinales,totalh);
});

$(document).on('click', '.elimina7',function() {
  btnelimina(this);
  var totalhmuestra = $("form input[name=totalhorasdia7]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia7]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia7]").prop("id");
  var totalh = $("form input[name=total_horasdia7]").prop("id");
  hora('#tabladia7',totalhmuestra,hiniciales,hfinales,totalh);
});

// CHANGE DE TABLAS

$('#tabladia1 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia1]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia1]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia1]").prop("id");
  var totalh = $("form input[name=total_horasdia1]").prop("id");
  hora('#tabladia1',totalhmuestra,hiniciales,hfinales,totalh);
});

$('#tabladia2 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia2]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia2]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia2]").prop("id");
  var totalh = $("form input[name=total_horasdia2]").prop("id");
  hora('#tabladia2',totalhmuestra,hiniciales,hfinales,totalh);
});

$('#tabladia3 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia3]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia3]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia3]").prop("id");
  var totalh = $("form input[name=total_horasdia3]").prop("id");
  hora('#tabladia3',totalhmuestra,hiniciales,hfinales,totalh);
});


$('#tabladia4 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia4]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia4]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia4]").prop("id");
  var totalh = $("form input[name=total_horasdia4]").prop("id");
  hora('#tabladia4',totalhmuestra,hiniciales,hfinales,totalh);
});

$('#tabladia5 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia5]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia5]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia5]").prop("id");
  var totalh = $("form input[name=total_horasdia5]").prop("id");
  hora('#tabladia5',totalhmuestra,hiniciales,hfinales,totalh);
});

$('#tabladia6 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia6]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia6]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia6]").prop("id");
  var totalh = $("form input[name=total_horasdia6]").prop("id");
  hora('#tabladia6',totalhmuestra,hiniciales,hfinales,totalh);
});

$('#tabladia7 tbody').on('change','tr.fila-fija',function() {
  var totalhmuestra = $("form input[name=totalhorasdia7]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia7]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia7]").prop("id");
  var totalh = $("form input[name=total_horasdia7]").prop("id");
  hora('#tabladia7',totalhmuestra,hiniciales,hfinales,totalh);
});
// BTN  AGREGA INTERNVALO

$('#agregar1').on('click', function() {
  var tablaid = 'tabladia1';
  var boton = '#btnagregar1';
btonagrega(tablaid,boton)
});

$('#agregar2').on('click', function() {
  var tablaid = 'tabladia2';
  var boton = '#btnagregar2';
btonagrega(tablaid,boton)
});

$('#agregar3').on('click', function() {
  var tablaid = 'tabladia3';
  var boton = '#btnagregar3';
btonagrega(tablaid,boton)
});

$('#agregar4').on('click', function() {
  var tablaid = 'tabladia4';
  var boton = '#btnagregar4';
btonagrega(tablaid,boton)
});

$('#agregar5').on('click', function() {
  var tablaid = 'tabladia5';
  var boton = '#btnagregar5';
btonagrega(tablaid,boton)
});

$('#agregar6').on('click', function() {
  var tablaid = 'tabladia6';
  var boton = '#btnagregar6';
btonagrega(tablaid,boton)
});

$('#agregar7').on('click', function() {
  var tablaid = 'tabladia7';
  var boton = '#btnagregar7';
btonagrega(tablaid,boton)
});