
let formhorarioprimero = document.getElementById("formdia1");
let formhorario2 = document.getElementById("formdia2");
let formhorario3 = document.getElementById("formdia3");
let formhorario4 = document.getElementById("formdia4");
let formhorario5 = document.getElementById("formdia5");
let formhorario6 = document.getElementById("formdia6");
let formhorario7 = document.getElementById("formdia7");
let formedita = document.getElementById("edithorario");   

//controla el numero de intervalos
const numf = 4;

$(document).ready(function () {
 // select('#usuarios').selectpicker({ title:'Usuarios' });

  $('#tablahorarios').hide();
  $('#guardarhorariousuario').hide();

  var numerosemana = moment(moment().format()).format("GGGG-[W]WW");  

  $("#semana").val(numerosemana)  ;//"2023-W01"

  semanahorario(numerosemana.split("-W")[0],numerosemana.split("-W")[1]);
});

const myChoices = new Array();
select('#usuarios').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
  var selected = document.getElementById("usuarios").options[clickedIndex].value;
  if (myChoices.indexOf(selected) == -1) {
    myChoices.push(selected);
  } else {
    myChoices.splice(myChoices.indexOf(selected), 1);
  }
});

function getISOWeek(w, y) {
  $('#usuarios').attr('readonly', true);
  $('#usuarios').attr('disabled', true);
  $('#semanausuario').attr('readonly', true);
  $('#semanausuario').attr('disabled', true);
  select('#usuarios').multiselect('disable');

  var simple = new Date(y, 0, 1 + (w - 1) * 7);
  var dow = simple.getDay();
  var ISOweekStart = simple;
  if (dow <= 4)
      ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
  else
      ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
  const temp = {
    d: ISOweekStart.getDate(),
    m: ISOweekStart.getMonth(),
    y: ISOweekStart.getFullYear(),
  }
  const numDaysInMonth = new Date(temp.y, temp.m + 1, 0).getDate()

  var arraydias=['lunes','martes','miercoles','jueves','viernes','sabado','domingo'];
    var fechitas =[];
    arraydias.forEach((dia,i) => { 

      if (temp.d > numDaysInMonth){
        temp.m +=1;
        temp.d = 1;
      }
      fechitas.push(new Date(temp.y, temp.m, temp.d++).toLocaleString());
    });

    fechitas.forEach((dia,i) => { 
      var numero = i+1;

      $("#"+arraydias[i]).html(moment(dia.split(',')[0],'DD/MM/YYYY').format('dddd DD'));

      $("#titulo"+numero).html(moment(dia.split(',')[0],'DD/MM/YYYY').format('dddd'));
  
      $("#fechadia"+numero).val(moment(dia.split(',')[0],'DD/MM/YYYY').format('YYYY-MM-DD'));

    });

    $('#tablahorarios').show();
    $('#guardarhorariousuario').show();

    return fechitas;

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

 if(num >= numf) {
     $(bton).attr('disabled', true);
     $(bton).attr('disabled','disabled');
 }
}


function btnelimina(btn){
  $(btn).closest('tr').remove();

  if(btn.id =='btnintervaloedicion'){
    $('#'+btn.id).attr('disabled', false);
  }else{
  var numero = btn.id.slice(-1);
  $('#btnagregar'+numero).attr('disabled', false);
  }
}

$('#semana').on('change', function() {
   var semana= $("#semana").val().split("-W");
   semanahorario(semana[0],semana[1]);  
});

function getWeekDaysByWeekNumber(weeknumber, ano)
{   
  var dateformat = "dddd DD";
    $('#dias').empty();
    $('#diasvenezuela').empty();  

   var contador=0;
   var dia1 = '';
   var dia2 = '';

    $("#dias").append('<th scope="col" style="background:#b6d7a8">#</th>');
    $("#dias").append('<th scope="col" style="background:#b6d7a8">Usuarios</th>');
    $("#diasvenezuela").append('<th scope="col" style="background:#b6d7a8">#</th>');
    $("#diasvenezuela").append('<th scope="col" style="background:#b6d7a8">Usuarios</th>');
    let d = moment(String(ano).padStart(4, '0') + 'W' + String(weeknumber).padStart(2,'0'));

    for (var dates=[], i=0; i < 7; i++) {

        if(i == 0){
            dia1= d.format('dddd DD MMMM');
        }
        if(i == 6){
          dia2= d.format('dddd DD MMMM');
        } 


      dates.push(d.format('dddd DD '));
      d.add(1, 'day');
      $("#dias").append('<th scope="col" style="background:#b6d7a8">'+dates[i]+'</th>');
      $("#diasvenezuela").append('<th scope="col" style="background:#b6d7a8">'+dates[i]+'</th>');
    }


    $("#dias").append('<th scope="col" style="background:#b6d7a8">Total de horas</th>');
    $("#dias").append('<th scope="col" style="background:#b6d7a8"></th>');

    $("#titulohorario").text('Semana '+weeknumber+' (Leads) , '+' '+dia1+' - '+dia2+' EL SALVADOR ☆HORA DE EL SALVADOR☆');

    $("#diasvenezuela").append('<th scope="col" style="background:#b6d7a8">Total de horas</th>');
    $("#diasvenezuela").append('<th scope="col" style="background:#b6d7a8"></th>');

    $("#titulohorariovenezuela").text('Semana '+weeknumber+' (Leads) , '+' '+dia1+' - '+dia2+' VENZUELA ☆NEW YORK TIME☆' );

  }

function horarioedita(btn,idhorarios,nombre){

  var datoshorario = new FormData();
  datoshorario.append("idhorarios",idhorarios);

  Swal.fire({
    title: "ELIMINAR",
    text: "¿Quieres eliminar los horarios de esta semana de "+nombre+"?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "SI",
    cancelButtonText: "Cancelar",
}).then((result) => {
    if (result.isConfirmed) {

      axios.post(principalUrl + "horarios/eliminar",datoshorario)
.then((respuesta) => {

  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'registros de esta semana eliminados',
    showConfirmButton: false,
    timer: 1000,
  });
  location.reload();

 })
 .catch((error) => {
  if (error.response) {
      console.log(error.response.data);
  }
});       

    }
});

}

const tbody = document.querySelector('#tablehorariosusario tbody');
tbody.addEventListener('click', function (e) {
  editahorario(e);
});

const tablebody = document.querySelector('#tablehorariosusariovenezuela tbody');
tablebody.addEventListener('click', function (e) {
  editahorario(e);
});


function editahorario(e){
  const cell = e.target.closest('td');
  if (cell.cellIndex == 0 || cell.cellIndex == 1 || cell.cellIndex == 9 || cell.cellIndex == 10 ) {return;} // Quit, not clicked on a cell
  const row = cell.parentElement;
 // console.log(cell.innerHTML, row.rowIndex, cell.cellIndex);

    var idshorarios = new FormData();

    idshorarios.append("idhorarios",cell.children.registroid.value);

  axios.post(principalUrl + "horarios/registros",idshorarios)
  .then((respuesta) => {

    $('#tablaedicion tr').slice(2).remove();
  
    var horasiniciales = respuesta.data[0].horasiniciales.split(",");
    var horasfinales = respuesta.data[0].horasfinales.split(",");
    var totaldehoras = respuesta.data[0].total_horas.split(":");

    if(horasiniciales[0] == 0 && horasfinales[0] == 0){
  
        $("#diaoffedicion").prop("checked", true);
        $('.entrada').attr('readonly', true);
        $('#btnintervaloedicion').attr('disabled', true);
        $("#total_de_horas").val("00 Horas 00 Minutos");
        $("#comentarios").val("Este dia es OFF");
        $("#TotaDeHoras").val("00:00:00");
        $("#horasfinales").val("0");
        $("#horasiniciales").val("0");
        $('.horas').val('');
        $("#id_registro").val(respuesta.data[0].id);
        $("#fechaedicion").text(moment(respuesta.data[0].fecha_horario.split(" ")[0]).format('dddd DD [de] MMMM [del] YYYY'));
        $('.agregaedi').val('agregar intervalo');
        $('#exampleModal').modal('show');
  
    }else{
      $('.agregaedi').val('agregar intervalo');
      $("#diaoffedicion").prop("checked", false);
      $('.entrada').attr('readonly', false)
      $('#btnintervaloedicion').attr('disabled', false);

    horasiniciales.forEach(function (element, i) {
        if(i >= 1){
                $('#tablaedicion tbody tr:eq(0)').clone().appendTo('#tablaedicion');
                $(`#tablaedicion tbody tr.fila-fija:eq(${i})`).addClass(' dinamico');
                $(`#tablaedicion tbody .masmenos:eq(${i})`).addClass('elimina');
                $(`#tablaedicion tbody .masmenos:eq(${i})`).val("elimina");
        }
  
        if(i >= numf){
            $('#btnagregar').attr('disabled', true);
            $("#btnagregar").attr('disabled','disabled');
        }else{
            $('#btnagregar').attr('disabled', false);
        }
    });
  
    horasiniciales.forEach(function (element, i) {
        var horas = $("#tablaedicion tbody select[name='horaini[]']");
        var minutos = $("#tablaedicion tbody input[name='minutosini[]']");
        var horarios = $("#tablaedicion tbody select[name='horarioini[]']");
        if(element != ""){
            var horario = moment(element,'HH:mm:ss').format('hh:mm A').split(" ");
            var hora = horario[0].split(":");
  
            horas.eq(i).val(hora[0]) ;
            minutos.eq(i).val(hora[1]) ;
            horarios.eq(i).val(horario[1]) ;
  
        }
    });
  
    horasfinales.forEach(function (element, i) {
        var horas2 = $("#tablaedicion tbody select[name='horaini2[]']");
        var minutos2 = $("#tablaedicion tbody input[name='minutosini2[]']");
        var horarios2 = $("#tablaedicion tbody select[name='horarioini2[]']");
        if(element != ""){
            var horario = moment(element,'HH:mm:ss').format('hh:mm A').split(" ");
            var hora = horario[0].split(":");
  
            horas2.eq(i).val(hora[0]) ;
            minutos2.eq(i).val(hora[1]) ;
            horarios2.eq(i).val(horario[1]) ;
        }
    });

    var fehcatituio = respuesta.data[0].fecha_horario.split(" ")[0];
    fehcatituio
    $("#fechaedicion").text(moment(respuesta.data[0].fecha_horario.split(" ")[0]).format('dddd DD [de] MMMM [del] YYYY'));

    $("#horasiniciales").val(respuesta.data[0].horasiniciales);
    $("#horasfinales").val(respuesta.data[0].horasfinales);
    $("#TotaDeHoras").val(respuesta.data[0].total_horas);
    //$("#fecharegistro").val(moment(fechas[0]).format('YYYY-MM-DD'));
    $("#id_registro").val(respuesta.data[0].id);
    $("#total_de_horas").val(totaldehoras[0]+" Horas con "+totaldehoras[1]+" minutos");

    $('#exampleModal').modal('show');
  }
  
   })
   .catch((error) => {
    if (error.response) {
        console.log(error.response.data);
    }
  });

}

// FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF

function semanahorario(ano,semana){

  getWeekDaysByWeekNumber(semana,ano);
  $('#filausuario').empty();
  $('#filausuariovenezuela').empty();

  axios.post(principalUrl + "horarios/usuarios/"+ano+"/"+semana)
  .then((respuesta) => {

    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'cargando horarios',
      showConfirmButton: false,
      timer: 1000,
    })
    
    if(respuesta.data.length == 0){

      $("#filausuario").append('<td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td><td>No registro</td>');
      return;
    }
    
    Promise.all(respuesta.data.map( item => { return axios.post(principalUrl + "horarios/semana/"+ano+"/"+semana+"/"+item.id) }))
    .then(nuevo_arreglo => {  // el resultado será un arreglo nuevo con los resultados de cada Promesa (siempre que todas hayan sido resueltas)
        var cotadorusers=1;
      nuevo_arreglo.forEach(result => {

        if(result.data.horasuser[0].pais == 1){


        var tr = $('<tr style="font-size: 15px;color:black">');

        if(result.data.horasuser.length != 0){
          $("#filausuario").append(tr);
          tr.append('<td style="background:#">'+cotadorusers+'</td>');
          cotadorusers++;
          tr.append('<td style="background:#b6d7a8">'+result.data.horasuser[0].name+'</td>');
          var idusuarios = '';

          result.data.horasuser.forEach((element,i) => { 
      
            var hini = element.horasiniciales.split(",");
            var hfin = element.horasfinales.split(",");
            var horasformateadas = '';

            if(hini[0]== 0 && hfin[0]== 0){
              tr.append('<td class="diaoff" style=" text-align: center !important" ><input type="hidden" value='+element.idh+' id="registroid" name="registroid"></input><span style="background:#33ECFF;" > OFF</span></td>');
      
            }else{
            if(hini.length == 1){
              tr.append('<td style=" text-align: center !important"><input type="hidden" value='+element.idh+' id="registroid" name="registroid"></input>'+moment(element.horasiniciales,"H:mm:ss").format('h:mm A')+'<br/>'+moment(element.horasfinales,"H:mm:ss").format('h:mm A')+'</td>');
      
            }else{
              hini.forEach(function (horasini, i) {   
                horasformateadas=  horasformateadas+ moment(horasini,"H:mm:ss").format('h:mm A')+'<br/>'+moment(hfin[i],"H:mm:ss").format('h:mm A')+'<br/>'
              })
              tr.append('<td style=" text-align: center !important"><input type="hidden" value='+element.idh+' id="registroid" name="registroid"></input>'+horasformateadas+'</td>');
            }
          }  
          if(i == result.data.horasuser.length-1){
            idusuarios = idusuarios+element.idh;

          }else{
          idusuarios = idusuarios+element.idh+",";
          }
        });          
        tr.append('<td style=" text-align: center !important">'+result.data.totalhoras[0].TotalHoras+'</td></tr>');
       tr.append('<td><button type="button" class="btn btn-primary " id="editarhorarios" onclick="horarioedita(this,`'+idusuarios+'`,`'+result.data.horasuser[0].name+'`)">Eliminar</button> </td></tr>');
        }

      }else if(result.data.horasuser[0].pais == 2){

        var tr = $('<tr style="font-size: 15px;color:black">');

        if(result.data.horasuser.length != 0){
          $("#filausuariovenezuela").append(tr);
          tr.append('<td style="background:#">'+cotadorusers+'</td>');
          cotadorusers++;
          tr.append('<td style="background:#b6d7a8">'+result.data.horasuser[0].name+'</td>');
          var idusuarios = '';

          result.data.horasuser.forEach((element,i) => { 
      
            var hini = element.horasiniciales.split(",");
            var hfin = element.horasfinales.split(",");
            var horasformateadas = '';

            if(hini[0]== 0 && hfin[0]== 0){
              tr.append('<td class="diaoff" style=" text-align: center !important" ><input type="hidden" value='+element.idh+' id="registroid" name="registroid"></input><span style="background:#33ECFF;" > OFF</span></td>');
      
            }else{
            if(hini.length == 1){
              tr.append('<td style=" text-align: center !important"><input type="hidden" value='+element.idh+' id="registroid" name="registroid"></input>'+moment(element.horasiniciales,"H:mm:ss").format('h:mm A')+'<br/>'+moment(element.horasfinales,"H:mm:ss").format('h:mm A')+'</td>');
      
            }else{
              hini.forEach(function (horasini, i) {   
                horasformateadas=  horasformateadas+ moment(horasini,"H:mm:ss").format('h:mm A')+'<br/>'+moment(hfin[i],"H:mm:ss").format('h:mm A')+'<br/>'
              })
              tr.append('<td style=" text-align: center !important"><input type="hidden" value='+element.idh+' id="registroid" name="registroid"></input>'+horasformateadas+'</td>');
            }
          }  
          if(i == result.data.horasuser.length-1){
            idusuarios = idusuarios+element.idh;

          }else{
          idusuarios = idusuarios+element.idh+",";
          }
        });          
        tr.append('<td style=" text-align: center !important" >'+result.data.totalhoras[0].TotalHoras+'</td></tr>');
       tr.append('<td><button type="button" class="btn btn-primary " id="editarhorarios" onclick="horarioedita(this,`'+idusuarios+'`,`'+result.data.horasuser[0].name+'`)">Eliminar</button> </td></tr>');

        }
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
  $('#guardarhorariousuario').hide();

  $('#usuarios').empty();
  $("#semanausuario").val("");
  limpiamodal();
  var usuarioselect = [];
  axios.post(principalUrl + "horarios/agentes")
    .then((respuesta) => {
      respuesta.data.forEach(function (element) { 
        usuarioselect.push(
                {label: element.name, value: element.id},
        );
      })
      select('#usuarios').multiselect('dataprovider', usuarioselect);

    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });

    select('#usuarios').multiselect({
      buttonClass: '<div class="form-control border rounded multiselect dropdown-toggle btn btn-default" />',
      nonSelectedText: 'Seleccione Usuarios',
      selectAllText:'Todos',
      nSelectedText: 'seleccionados',
      allSelectedText: 'Todos seleccionados',
      enableCollapsibleOptGroups: true,
      includeSelectAllOption: true,
      //enableFiltering: true,
      maxHeight: 450   ,
     // enableFiltering:true,
    }); 
    $('#modal_cupo_horario').modal('show');
});


function limpiamodal(){
  var array1 = [1,2,3,4,5,6,7];
  $('.entrada').val('');
  $("input[type=checkbox]").prop("checked", false);
  $('.entrada').attr('readonly', false)
 
  $('#usuarios').attr('readonly', false);
  $('#usuarios').attr('disabled', false);
  $('#semanausuario').attr('readonly', false);
  $('#semanausuario').attr('disabled', false);
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

  if($("#semanausuario").val() == ""){
    Swal.fire("¡Debe agregar un rango de fechas!");
    return;
  }
if($("#usuarios").val() == null){
      Swal.fire("¡Debe agregar un usuario!");
    return;
  }
  var seman_ano = $("#semanausuario").val().split("-W");

  validahorariouser(seman_ano[1], seman_ano[0]);
});

function validahorariouser(semana, ano){
  var iduser = $('#usuarios option:selected').toArray().map(item => item.value ).join();
  var nombre =[];
  //console.log(nombre);
  axios.post(principalUrl + "horarios/semana/"+ano+"/"+semana+"/"+iduser)
  .then((respuesta) => {

    if(respuesta.data.horasuser.length == 0 ){
      getISOWeek(semana,ano)
    }else{
      respuesta.data.horasuser.forEach(function (element ,i) { 
        if(nombre.indexOf(element.name) === -1){
          nombre.push(element.name);
        }
      })
      Swal.fire("¡El agente "+nombre+" ya tiene horario en la semana "+semana+" del año "+ano+"!");
      //$("#usuarios").val('');
    }
  })
  .catch((error) => {
      if (error.response) {
          console.log(error.response.data);
      }
  });
}


$('.offdia').on('click', function() {

    var numero = this.id.slice(-1);

    if(this.id == 'diaoffedicion'){

      if( $('#'+this.id).is(':checked') ) {

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
                $('#tablaedicion tr').slice(2).remove();

                $("#diaoff").prop("checked", true);
                $('.entrada').attr('readonly', true);
                $('.entrada').attr('disabled', true);
                $('#btnintervaloedicion').attr('disabled', true);
                $("#total_de_horas").val("00 Horas 00 Minutos");
                $("#comentarios").val("Este dia es OFF");
                $("#TotaDeHoras").val("00:00:00");
                $("#hfinales").val("0");
                $("#hiniciales").val("0");
                $('.horas').val('');
              }
          });
          }else if(!$('#'+this.id).is(':checked')){
            $('.entrada').attr('disabled', false);
            $("#diaoff").prop("checked", false);
            $('.entrada').attr('readonly', false);
            $('#btnintervaloedicion').attr('disabled', false);
          }
    }else{
    
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
        $("#horas_finales_dia"+numero).val("");
        $("#total_horasdia"+numero).val("");
    }
   }

});

document.getElementById("guardarhorariousuario").addEventListener("click", function () {
  if (validacionhorarios() == false) {return;}

    var array1 = [1,2,3,4,5,6,7];

    var horarios = new FormData();
    array1.forEach(function (numero) {
      horarios.append("fechadia"+numero, $("#fechadia"+numero).val());
      horarios.append("horas_iniciales_dia"+numero, $("#horas_iniciales_dia"+numero).val());
      horarios.append("horas_finales_dia"+numero, $("#horas_finales_dia"+numero).val());
      horarios.append("total_horasdia"+numero, $("#total_horasdia"+numero).val());

  });
  horarios.append("usuarios", $("#usuarios").val());
 
  var nombre =  $('#usuarios option:selected').toArray().map(item => item.text ).join();
  var semanaeditando = $('#semanausuario').val();
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

      $('#guardarhorariousuario').attr('disabled', true);

      axios.post(principalUrl + "horarios/guarda",horarios)
      .then((respuesta) => {

       // select('#usuarios').multiselect('enable');
        $('#guardarhorariousuario').attr('disabled', false);

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: "Horarios guardados!",
          showConfirmButton: false,
          timer: 1000
      });
        $('#modal_cupo_horario').modal('hide');

        $("#semana").val(semanaeditando)  ;//"2023-W01"
        semanahorario(semanaeditando.split("-W")[0],semanaeditando.split("-W")[1]);
        //location.reload();
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

  if(this.id =='btnintervaloedicion'){
    var totalhmuestra = $("form input[name=total_de_horas]").prop("id");
    var hiniciales = $("form input[name=hiniciales]").prop("id");
    var hfinales = $("form input[name=hfinales]").prop("id");
    var totalh = $("form input[name=TotaDeHoras]").prop("id");
    
    hora('#tablaedicion',totalhmuestra,hiniciales,hfinales,totalh);
  }else{
  var totalhmuestra = $("form input[name=totalhorasdia"+numero+"]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia"+numero+"]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia"+numero+"]").prop("id");
  var totalh = $("form input[name=total_horasdia"+numero+"]").prop("id");
  hora('#tabladia'+numero,totalhmuestra,hiniciales,hfinales,totalh);
  }
});

// CHANGE DE TABLAS

$('.tablehoras ').on('change',function() {

  var numero = this.id.slice(-1);
  if(this.id == 'tablaedicion'){
    var totalhmuestra = $("form input[name=total_de_horas]").prop("id");
    var hiniciales = $("form input[name=hiniciales]").prop("id");
    var hfinales = $("form input[name=hfinales]").prop("id");
    var totalh = $("form input[name=TotaDeHoras]").prop("id");
    
    hora('#tablaedicion',totalhmuestra,hiniciales,hfinales,totalh);
  }else{
  var totalhmuestra = $("form input[name=totalhorasdia"+numero+"]").prop("id");
  var hiniciales = $("form input[name=horas_iniciales_dia"+numero+"]").prop("id");
  var hfinales = $("form input[name=horas_finales_dia"+numero+"]").prop("id");
  var totalh = $("form input[name=total_horasdia"+numero+"]").prop("id");
  hora('#tabladia'+numero,totalhmuestra,hiniciales,hfinales,totalh);
  }
});

// BTN  AGREGA INTERNVALO


$('.botonagrega').on('click', function() {

  if(this.id == 'intervaloedicion'){
    var tablaid = 'tablaedicion';
    var boton = '#btnintervaloedicion';
  btonagrega(tablaid,boton)
  }else{
    var numero = this.id.slice(-1);
    var tablaid = 'tabladia'+numero;
    var boton = '#btnagregar'+numero;
  btonagrega(tablaid,boton)
  }
});

// GUARDA EDICION DE HORARIOS DE UN USUARIO

document.getElementById("gurdaedcionhorario").addEventListener("click", function () {
  if (validaciondatosedita() == false) {return;}

  var datosregistro = new FormData(formedita);
  datosregistro.append("hfin",$('#hfinales').val());
  datosregistro.append("hinicial",$('#hiniciales').val());


  $('#guardar_registro').attr('disabled', false);
  console.log($('#horasiniciales').val());

Swal.fire({
  title: "ACTUALIZAR",
  text: "¿Estas seguro de guardar los cambios?",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "SI",
  cancelButtonText: "Cancelar",
}).then((result) => {
  if (result.isConfirmed) {

    axios.post(principalUrl + "horario/actualizar",datosregistro)
    .then((respuesta) => {
      location.reload();
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Datos actalizados exitosamente!",
            showConfirmButton: false,
        });       
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
  }
});
});


function validaciondatosedita(){
  var valido = true;

  var horas = $("#tablaedicion tbody select[name='horaini[]']");
  var minutos = $("#tablaedicion tbody input[name='minutosini[]']");
  var horarios = $("#tablaedicion tbody select[name='horarioini[]']");

  var horas2 = $("#tablaedicion tbody select[name='horaini2[]']");
  var minutos2 = $("#tablaedicion tbody input[name='minutosini2[]']");
  var horarios2 = $("#tablaedicion tbody select[name='horarioini2[]']");

 if( !$('#diaoffedicion').is(':checked') ) {

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

function validacionhorarios(){
  var valido = true;

 var dias =[7,6,5,4,3,2,1];

 dias.forEach(function (numero) {

var horas = $("#tabladia"+numero+" tbody  select[name='horaini[]']");
var minutos = $("#tabladia"+numero+" tbody  input[name='minutosini[]']");
var horarios = $("#tabladia"+numero+" tbody  select[name='horarioini[]']");

var horas2 = $("#tabladia"+numero+" tbody  select[name='horaini2[]']");
var minutos2 = $("#tabladia"+numero+" tbody  input[name='minutosini2[]']");
var horarios2 = $("#tabladia"+numero+" tbody  select[name='horarioini2[]']");

if( !$('#diaoff'+numero).is(':checked') ) {

  horas.each(function(i) {
      if( $(this).val() == null){
          Swal.fire("¡Debe completar todas las horas del dia "+numero+"!");
           valido = false;
      }
  });

  minutos.each(function(i) {
      if( $(this).val() > 59){
          $(this).val("")
          Swal.fire("¡Los minutos no pueden ser mayor a 59 min del dia "+numero+"!");
           valido = false;
      }
  });
  
  horarios.each(function(i) {
      if( $(this).val() == null){
          Swal.fire("¡Debe completar el turno del dia "+numero+"!");
           valido = false;
      }
  });

  horas2.each(function(i) {
      if( $(this).val() == null){
          Swal.fire("¡Debe completar todas las horas del dia "+numero+"!");
           valido = false;
      }
  });

  minutos2.each(function(i) {
      if( $(this).val() > 59){
          $(this).val("")
          Swal.fire("¡Los minutos no pueden ser mayor a 59 min del dia "+numero+"!");
           valido = false;
      }
  });

  horarios2.each(function(i) {
      if( $(this).val() == null){
          Swal.fire("¡Debe completar el turno del dia "+numero+"!");
           valido = false;
      }
  });
 }

});

return valido;
}

