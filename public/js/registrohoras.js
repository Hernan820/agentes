
let formregistro = document.getElementById("registroHora");


/*

    var formatoHora1 = document.getElementById("horaini");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora1, maskrecord);

    var formatoHora2 = document.getElementById("minutosini");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora2, maskrecord);

    var formatoHora = document.getElementById("horafin");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora, maskrecord);

    var formatoHora = document.getElementById("minutosfin");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora, maskrecord);


    //888888888888
    var formatoHora1 = document.getElementById("horaini_intervalo");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora1, maskrecord);

    var formatoHora2 = document.getElementById("minutosini_intervalo");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora2, maskrecord);

    var formatoHora = document.getElementById("horafin_intervalo");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora, maskrecord);

    var formatoHora = document.getElementById("minutosfin_intervalo");
    var maskrecord = {
        mask: "00",
    }; 
    IMask(formatoHora, maskrecord);

    */



document.getElementById("registro").addEventListener("click", function () {  
    $("#modal_registro").modal("show");
});


document.getElementById("intervalo").addEventListener("click", function () {
    


    
    if($("#CollapseExample1").collapse('show')){
        $("#CollapseExample1").collapse('hide');
    }else{
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
    var hora_completa = hora1 +":"+ minutos1+":00"+" "+horario1 ;

    horalimpia =  moment(hora_completa,"h:mm:ss A").format("HH:mm:ss");

   }else if(horario1 == "AM"){
    var hora_completa = hora1 +":"+ minutos1+":00";

    var horalimpia =hora_completa;
   }

   //formato de la hora fin 
   if(horario2 == "PM"){

    var hora_completa = hora2 +":"+ minutos2+":00"+" "+horario2 ;

    horafinal =  moment(hora_completa,"h:mm:ss A").format("HH:mm:ss");

   }else if(horario2 == "AM"){
    var hora_completa = hora2 +":"+ minutos2+":00";

    var horafinal =hora_completa;
   }
   
      // formato de la hora de intervalo uno
      if(horario3 == "PM"){
        var hora33_completa = hora_intervalo1 +":"+ min_intervalo1+":00"+" "+horario3 ;
    
        horaini_intervalo =  moment(hora33_completa,"h:mm:ss A").format("HH:mm:ss");
    
       }else if(horario3 == "AM"){
        var hora33_completa = hora_intervalo1 +":"+ min_intervalo1+":00";
    
        var horaini_intervalo =hora33_completa;
       }

     //formato de la hora de intervalo dos

   if(horario4 == "PM"){

    var hora44_completa = hora_intervalo2 +":"+ min_intervalo2+":00"+" "+horario4 ;

    var horafin_intervalo =  moment(hora44_completa,"h:mm:ss A").format("HH:mm:ss");

   }else if(horario4 == "AM"){
    var hora44_completa = hora_intervalo2 +":"+ min_intervalo2+":00";

    var horafin_intervalo = hora44_completa;
   }

   //insertando valores a input
  $("#horainicio").val(horalimpia);
  $("#horafinal").val(horafinal);

  if(horaini_intervalo == "00:00:00" && horafin_intervalo == "00:00:00"){

    $("#intervaloinicio").val("");
    $("#intervalofinal").val("");
  }else{
    $("#intervaloinicio").val(horaini_intervalo);
    $("#intervalofinal").val(horafin_intervalo);
  }



   //calculando la cantidad de horas realizadas

   if( horalimpia != "00:00:00" && horafinal != "00:00:00" 
   && horaini_intervalo == "00:00:00" && horafin_intervalo == "00:00:00"){

    var horauno = moment("11/11/11 "+horalimpia);
    var horados = moment("11/11/11 "+horafinal);

    var horareal1= horados.diff(horauno, 'hours')
    $("#total_horas").val(horareal1);

   }else if(horalimpia != "00:00:00" && horafinal != "00:00:00" 
   && horaini_intervalo != "00:00:00" && horafin_intervalo != "00:00:00") {


    var horauno = moment("11/11/11 "+horalimpia);
    var horados = moment("11/11/11 "+horafinal);
    var horareal1= horados.diff(horauno, 'hours')

    var horatres = moment("11/11/11 "+horaini_intervalo);
    var horacuatro = moment("11/11/11 "+horafin_intervalo);
   var horareal2= horacuatro.diff(horatres, 'hours')
 
   var suma =  (parseInt(horareal1) + parseInt(horareal2));
   $("#total_horas").val(suma);
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


    if($("#CollapseExample1").collapse('show')){
        if (
            horaini === "" ||
            horario1 === "" ||
            horafin === "" ||
            horario2 === "" ||
            
            intervalo1 === "" ||
            horario_inter1 === "" ||
            intervalo2 === "" ||
            horario_inter2 === ""
        ) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
        }
    }else {

        if (
            horaini === "" ||
            horario1 === "" ||
            horafin === "" ||
            horario2 === "" 

        ) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
        }
    }


    return valido;
}







