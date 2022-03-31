
let formregistro = document.getElementById("registroHora");

    var formatoHora1 = document.getElementById("minutosini");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora1, maskrecord);

    var formatoHora2 = document.getElementById("minutosfin");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora2, maskrecord);

    var formatoHora = document.getElementById("intervalo_minini");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora, maskrecord);

    var formatoHora = document.getElementById("intervalo_minfin");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora, maskrecord);


document.getElementById("registro").addEventListener("click", function () {  
    $("#modal_registro").modal("show");
});


document.getElementById("intervalo").addEventListener("click", function () {
    
    if($("#CollapseExample1").hasClass("collapse show")){
        limpiarcampos();
        conteo_horas();
        $("#intervalo_activo").val("");

        $("#CollapseExample1").collapse('hide');
    }else if($("#CollapseExample1").hasClass("collapse")){
        $("#intervalo_activo").val("1");

        $("#CollapseExample1").collapse('show');

    }
});

document.getElementById("guardar_registro").addEventListener("click", function () {

    if (validaciondatos() == false) {
        return;
    }
    
    var datosregistro = new FormData(formregistro);

    axios.post(principalUrl + "registro/registrohoras",datosregistro)
    .then((respuesta) => {
        $("#modal_registro").modal("hide");
       respuesta.data
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
});


function conteo_horas(){

    //obteniendo valores de los input
   hora1= $("#horaini").val();
   minutos1= $("#minutosini").val();
   horario1= $("#horario1").val();

   hora2= $("#horafin").val();
   minutos2= $("#minutosfin").val();
   horario2= $("#horario2").val();

   hora_intervalo1= $("#intervalo_horaini").val();
   min_intervalo1= $("#intervalo_minini").val();
   horario3= $("#horario_intervalo1").val();

   hora_intervalo2= $("#intervalo_horafin").val();
   min_intervalo2= $("#intervalo_minfin").val();
   horario4= $("#horario_intervalo2").val();



   // formato de la hora inicio
   if(horario1 == "PM"){
    var hora_completa1 = hora1 +":"+ minutos1+":00"+" "+horario1 ;

    horalimpia =  moment(hora_completa1,"h:mm:ss A").format("HH:mm:ss");

   }else if(horario1 == "AM"){
    var hora_completa1 = hora1 +":"+ minutos1+":00";

    var horalimpia =hora_completa1;
   }

   //formato de la hora fin 
   if(horario2 == "PM"){

    var hora_completa2 = hora2 +":"+ minutos2+":00"+" "+horario2 ;

    horafinal =  moment(hora_completa2,"h:mm:ss A").format("HH:mm:ss");

   }else if(horario2 == "AM"){
    var hora_completa2 = hora2 +":"+ minutos2+":00";

    var horafinal =hora_completa2;
   }
   
      // formato de la hora de intervalo uno
      if(horario3 != null){
        if(horario3 == "PM"){
            var hora33_completa = hora_intervalo1 +":"+ min_intervalo1+":00"+" "+horario3 ;
        
            horaini_intervalo =  moment(hora33_completa,"h:mm:ss A").format("HH:mm:ss");
        
           }else if(horario3 == "AM"){
            var hora33_completa = hora_intervalo1 +":"+ min_intervalo1+":00";
        
            var horaini_intervalo =hora33_completa;
           }
      }else {
        var horaini_intervalo ="";
      }


     //formato de la hora de intervalo dos

     if(horario4 != null){
        if(horario4 == "PM"){

            var hora44_completa = hora_intervalo2 +":"+ min_intervalo2+":00"+" "+horario4 ;
        
            var horafin_intervalo =  moment(hora44_completa,"h:mm:ss A").format("HH:mm:ss");
        
           }else if(horario4 == "AM"){
            var hora44_completa = hora_intervalo2 +":"+ min_intervalo2+":00";
        
            var horafin_intervalo = hora44_completa;
           }
     }else{
        var horafin_intervalo = "";  
     }


   //insertando valores a input
  $("#horainicio").val(horalimpia);
  $("#horafinal").val(horafinal);
  $("#intervaloinicio").val(horaini_intervalo);
  $("#intervalofinal").val(horafin_intervalo);

  //mandando datos a la funcionde calcular el total de horas

  calcular_hora(horalimpia,horafinal,horaini_intervalo,horafin_intervalo);
  
}

function calcular_hora(h1,h2,h3,h4){

        //obteniendo valores de los input
   horas1= $("#horaini").val();
   min1= $("#minutosini").val();
   horario1= $("#horario1").val();

   horas2= $("#horafin").val();
   min2= $("#minutosfin").val();
   horario2= $("#horario2").val();

   horas3= $("#intervalo_horaini").val();
   min3= $("#intervalo_minini").val();
   horario3= $("#horario_intervalo1").val();

   horas4= $("#intervalo_horafin").val();
   min4= $("#intervalo_minfin").val();
   horario4= $("#horario_intervalo2").val();


    var horareal1 = horas1 +":"+ min1+":00"+" "+horario1 ;
    var horareal2 = horas2 +":"+ min2+":00"+" "+horario2 ;
    var horareal3 = horas3 +":"+ min3+":00"+" "+horario3 ;
    var horareal4 = horas4 +":"+ min4+":00"+" "+horario4 ;


       //calculando la cantidad de horas realizadas

   if( h1 != "00:00:00" && h2 != "00:00:00" && h3 == "" && h4 == ""){

          var horaprocesada = moment.duration(moment(horareal2, "HH:mm:ss a").diff(moment(horareal1, "HH:mm:ss a")));

          $("#total_horas_realizadas").val(horaprocesada.hours()+":"+horaprocesada.minutes()+":00");

        $("#total_horas").val(horaprocesada.hours()+" Horas "+horaprocesada.minutes()+" Minutos");
    
       }else if(h1 != "00:00:00" && h2 != "00:00:00" && h3 != "" && h4 != "") {
        
        var horaprocesada1 = moment.duration(moment(horareal2, "HH:mm:ss a").diff(moment(horareal1, "HH:mm:ss a")));

        var horaprocesada2 = moment.duration(moment(horareal4, "HH:mm:ss a").diff(moment(horareal3, "HH:mm:ss a")));


        var total_horas = (parseInt(horaprocesada1.hours()) + parseInt(horaprocesada2.hours()));
        var total_minutos = (parseInt(horaprocesada1.minutes()) + parseInt(horaprocesada2.minutes()));

        if(total_minutos <= 59){

            $("#total_horas_realizadas").val(total_horas+":"+total_minutos+":00");

            $("#total_horas").val(total_horas+" Horas "+total_minutos+" Minutos");

        }else if(total_minutos > 59 ){

           var horas_Residuo = Math.floor(total_minutos / 60) ;

           var minutos_residuo = total_minutos % 60;

           var horasTotal= (parseInt(total_horas) + parseInt(horas_Residuo));
           var minutosTotal= minutos_residuo;

           $("#total_horas_realizadas").val(horasTotal+":"+minutosTotal+":00");

           $("#total_horas").val(horasTotal+" Horas "+minutosTotal+" Minutos");

        }


   
       }

}

function validaciondatos() {
    var valido = true;

    var horaini = $("#horaini").val();
    var horario1 = $("#horario1").val();
    var horafin = $("#horafin").val();
    var horario2 = $("#horario2").val();

    var intervalo1 = $("#intervalo_horaini").val();
    var horario_inter1 = $("#horario_intervalo1").val();
    var intervalo2 = $("#intervalo_horafin").val();
    var horario_inter2 = $("#horario_intervalo2").val();

    var citas = $("#total_citas").val();
    var comentarios = $("#comentarios").val();
    var intervalo = $("#intervalo_activo").val();

    



    if(intervalo == "1"){
        if (
            horaini === "" ||
            horario1 === "" ||
            horafin === "" ||
            horario2 === "" ||
            
            intervalo1 === "" ||
            horario_inter1 === null ||
            intervalo2 === "" ||
            horario_inter2 === null||
            citas          === ""||
            comentarios    === ""
        ) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
        }
    }else {

        if (
            horaini === "" ||
            horario1 === "" ||
            horafin === "" ||
            horario2 === "" ||
            citas          === ""||
            comentarios    === ""

        ) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
        }
    }


    return valido;
}


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


    $("#registro_horas").DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        lengthChange: false,
        pageLength: 20,
        bInfo: false,
        ajax: {
            url: principalUrl + "registro/datos/" + idcupo,
            dataSrc: "",
        },
        columns: [
            { data: "name",width: "75px" },
            { data: "total_horas",width: "75px" },
            { data: "total_citas",width: "75px" },
            { data: "comentarios",width: "75px" },
            {
                data: "id",
                width: "100px",
                render: function (data, type, row) {
                    var id_user = row["id_usuario"];

                    if (id_user == usuario) {
                        return (
                            '<button type="button" class="btn btn-success col-md-4" id="guardar_registro">Editar</button>'
                        );
                    } else {
                        return (
                            '<button type="button" class="btn btn-success" id="guardar_registro" enabled >Editar</button>'
                        );
                    }
                },
            },


        ],
      
    });
 
});





