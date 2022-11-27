
let formhorarioprimero = document.getElementById("formdia1");
let formhorario2 = document.getElementById("formdia2");
let formhorario3 = document.getElementById("formdia3");
let formhorario4 = document.getElementById("formdia4");
let formhorario5 = document.getElementById("formdia5");
let formhorario6 = document.getElementById("formdia6");
let formhorario7 = document.getElementById("formdia7");

//controla el numero de intervalos
const numf = 4;

$(document).ready(function () {
  $('#tablahorarios').hide();

  var semana = moment(moment().toDate(), "MM-DD-YYYY").isoWeek()
  var ano = moment(moment().toDate(), "MM-DD-YYYY").format('YYYY')

  $("#semana").val(ano+"-W"+semana)  ;

  semanahorario(ano,semana);
});


function fechashorario(fecha1,fecha2){

  var f1 = fecha1.split("/");
  var f2 = fecha2.split("/");

var fechauno = f1[2]+"-"+f1[0]+"-"+f1[1];
var fechados= f2[2]+"-"+f2[0]+"-"+f2[1];

  var ini = moment(fechauno);
  var fin = moment(fechados);
  
  if(ini != undefined && fin != undefined){
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
  }
}




// FUNCIONES

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

 $(`#`+tablaid+` tbody .masmenos:eq(${num})`).addClass('elimina');
 $(`#`+tablaid+` tbody .masmenos:eq(${num})`).val("elimina"); 

 if(num == numf) {
     $(bton).attr('disabled', true);
     $(bton).attr('disabled','disabled');
 }
}


function btnelimina(btn){


  $(btn).closest('tr').remove();

  var numero = btn.id.slice(-1);


  $('#btnagregar'+numero).attr('disabled', false);
}

$('#semana').on('change', function() {
   var semana= $("#semana").val().split("-W");

   semanahorario(semana[0],semana[1]);  
});

function getWeekDaysByWeekNumber(weeknumber)
{   
  var dateformat = "dddd DD";
    $('#dias').empty();
   var contador=0;
    var date = moment().isoWeek(weeknumber||1).startOf("week"), weeklength=7, result=[];
    $("#dias").append('<th scope="col">Usuarios</th>');
    while(weeklength--)
    {
        result.push(date.format(dateformat));
        date.add(1,"day")
        $("#dias").append('<th scope="col">'+result[contador]+'</th>');
        contador++;
    }
    $("#dias").append('<th scope="col">Total de horas</th>');
}

// FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF

function semanahorario(ano,semana){

  getWeekDaysByWeekNumber(semana);
  $('#filausuario').empty();

  axios.post(principalUrl + "horarios/usuarios/"+ano+"/"+semana)
  .then((respuesta) => {

    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'cargando horarios',
      showConfirmButton: false,
      timer: 2000
    })
    
    if(respuesta.data.length == 0){

      $("#filausuario").append('<td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td>');
      return;
    }
    
    Promise.all(respuesta.data.map( item => { return axios.post(principalUrl + "horarios/semana/"+ano+"/"+semana+"/"+item.id) }))
    .then(nuevo_arreglo => {  // el resultado será un arreglo nuevo con los resultados de cada Promesa (siempre que todas hayan sido resueltas)
      nuevo_arreglo.forEach(result => {
        var tr = $('<tr style="font-size: 15px;color:black">');

        if(result.data.horasuser.length != 0){
          $("#filausuario").append(tr);
          tr.append('<td>'+result.data.horasuser[0].name+'</td>');
      
          result.data.horasuser.forEach((element,i) => {
      
            var hini = element.horasiniciales.split(",");
            var hfin = element.horasfinales.split(",");
            var horasformateadas = '';
      
            if(hini[0]== 0 && hfin[0]== 0){
              tr.append('<td class="diaoff"> OFF</td>');
      
            }else{
            if(hini.length == 1){
              tr.append('<td>'+moment(element.horasiniciales,"H:mm:ss").format('h:mm A')+'<br/>'+moment(element.horasfinales,"H:mm:ss").format('h:mm A')+'</td>');
      
            }else{
              hini.forEach(function (horasini, i) {   
                horasformateadas=  horasformateadas+ moment(horasini,"H:mm:ss").format('h:mm A')+'<br/>'+moment(hfin[i],"H:mm:ss").format('h:mm A')+'<br/>'
              })
              tr.append('<td>'+horasformateadas+'</td>');
            }
          }  

          });          
        tr.append('<td>'+result.data.totalhoras[0].TotalHoras+'</td></tr>');
        }

      });
    });
})
.catch((error) => {
    if (error.response) {
        console.log(error.response.data);
    }
});

}


//EJECUTAN BOTONES


$('#horariodeusuario').on('click', function() {

  $('#usuarios').empty();
  $("#rango_fechas").val("");
  limpiamodal();

  axios.post(principalUrl + "horarios/agentes")
    .then((respuesta) => {
      $("#usuarios").append("<option selected='selected' disabled selected value=''>usuarios</option>" );
      respuesta.data.forEach(function (element) {   
      $("#usuarios").append("<option value="+element.id+">"+element.name+"</option>" );
         })
      $('#modal_cupo_horario').modal('show');
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

});


function limpiamodal(){
  var array1 = [1,2,3,4,5,6,7];
  $('.entrada').val('');
  $("input[type=checkbox]").prop("checked", false);
  $('.entrada').attr('readonly', false)
 
  array1.forEach(function (numero) {
    $('#tabladia'+numero+' tr').slice(2).remove();
    $('#btnagregar'+numero).attr('disabled', false);
    $('.horas'+numero).attr('readonly', false);
    $('.horas'+numero).attr('disabled', false); 
    $("#fechadia"+numero).val('')
    $("#horas_iniciales_dia"+numero).val('')
    $("#horas_finales_dia"+numero).val('')
    $("#total_horasdia"+numero).val('')
    $("#totalhorasdia"+numero).val('')
  });
  $('#tablahorarios').hide();
}



$('#crearhorario').on('click', function() {

  if($("#rango_fechas").val() == ""){
    Swal.fire("¡Debe agregar un rango de fechas!");
    return;
  }
   if($("#usuarios").val() == null){
    Swal.fire("¡Debe agregar un usuario!");
    return;
  }
  var fechas = $("#rango_fechas").val().split(" - ");
  fechashorario(fechas[0],fechas[1]);
});



$('.offdia').on('click', function() {


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

document.getElementById("guardarhorariousuario").addEventListener("click", function () {

    var array1 = [1,2,3,4,5,6,7];

    var horarios = new FormData();

    array1.forEach(function (numero) {
      horarios.append("fechadia"+numero, $("#fechadia"+numero).val());
      horarios.append("horas_iniciales_dia"+numero, $("#horas_iniciales_dia"+numero).val());
      horarios.append("horas_finales_dia"+numero, $("#horas_finales_dia"+numero).val());
      horarios.append("total_horasdia"+numero, $("#total_horasdia"+numero).val());

  });
  horarios.append("usuarios", $("#usuarios").val());

  var nombre = $('select[id="usuarios"] option:selected').text();

  Swal.fire({
    title: "HORARIOS",
    text: "¿Estas seguro de guardar los horarios de "+nombre+" ?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "SI",
    cancelButtonText: "Cancelar",
}).then((result) => {
    if (result.isConfirmed) {


      axios.post(principalUrl + "horarios/guarda",horarios)
      .then((respuesta) => {

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Horarios guardados!",
          showConfirmButton: false,
          timer: 1000
      });
        $('#modal_cupo_horario').modal('hide');
      })
      .catch((error) => {
          if (error.response) {
              console.log(error.response.data);
          }
      });


    }
});


});

//   BOTONES DE AGREAR INTERVALO, ELIMINA INTERVALO Y CHANGE DE TABLA


// BTNELIMINA

$(document).on('click', '.elimina',function() {
  var numero = this.id.slice(-1);

  btnelimina(this);

  var totalhmuestra = $("form input[name=totalhorasdia"+numero+"]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia"+numero+"]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia"+numero+"]").prop("id");
  var totalh = $("form input[name=total_horasdia"+numero+"]").prop("id");
  hora('#tabladia'+numero,totalhmuestra,hiniciales,hfinales,totalh);
});




// CHANGE DE TABLAS

$('.tablehoras ').on('change',function() {
  var numero = this.id.slice(-1);
  var totalhmuestra = $("form input[name=totalhorasdia"+numero+"]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia"+numero+"]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia"+numero+"]").prop("id");
  var totalh = $("form input[name=total_horasdia"+numero+"]").prop("id");
  hora('#tabladia'+numero,totalhmuestra,hiniciales,hfinales,totalh);
});

// BTN  AGREGA INTERNVALO


$('.botonagrega').on('click', function() {

  var numero = this.id.slice(-1);
  var tablaid = 'tabladia'+numero;
  var boton = '#btnagregar'+numero;
btonagrega(tablaid,boton)
});
