let formregistro = document.getElementById("formregistrousuarios");

document.getElementById("guardarusuario").addEventListener("click", function () {
    if (validardatos() == false) {
        return;
    }
    var datosUsuario = new FormData(formregistro);

    var idusuario =$("#id_user").val();

    if(idusuario ==""){

        axios.post(principalUrl + "registro/usuarios", datosUsuario)
            .then((respuesta) => {
                if(respuesta.data == true){
                    tablaagentes(); 

                    $('#formregistrousuarios').trigger("reset");
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Usuario guardado exitosamente!",
                        showConfirmButton: false,
                    });
                }else if(respuesta.data == false){
                    tablaagentes(); 
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Este usuario ya existe",
                        showConfirmButton: false,
                    });
                }
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
    }else{

        axios.post(principalUrl + "registro/actualizarusuario", datosUsuario)
        .then((respuesta) => {
            $('#formregistrousuarios').trigger("reset");
            limpiarForm();
            tablaagentes(); 
            if(respuesta.data == 1){
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Usuario actualizado exitosamente!",
                    showConfirmButton: false,
                });
            }
        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });


    }    
    });


    const validateEmail = (email) => {
        var format =
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return format.test(email);
    };
    
    function validardatos() {
        var valido = true;
    
        var nombre = $("#name").val();
        var correo = $("#email").val();
        var rol = $("#rol").val();
        var password = $("#password").val();
        var passwordconfirm = $("#password-confirm").val();
    

        if (password != passwordconfirm) {
            Swal.fire("¡Error la contraseña confirmacion no es la misma!");
            valido = false;
        }
        
        if (password.length < 8) {
            Swal.fire("¡Error la contraseña debe tener minimo 8 cararteres!");
            valido = false;
        }

        if (validateEmail(correo) == false) {
            Swal.fire("¡Error formato de correo no correcto!");
            valido = false;
        }
        
        if (
            nombre === "" ||
            correo === "" ||
            rol === "" ||
            password === "" ||
            passwordconfirm === ""
        ) {
            Swal.fire("¡Error debe completar todos los datos!");
            valido = false;
        }
        return valido;
    }


    $(document).ready(function () {
        tablaagentes(); 
        });

        function tablaagentes(){
            $("#insertardatos").html("");

            axios.post(principalUrl + "registro/datosusuarios")
            .then((respuesta) => {
                respuesta.data.forEach(function (element) {
                    $("#insertardatos").append(
                        "<tr><td>" +
                            element.nombre +
                            "</td><td>" +
                            element.email +
                            "</td><td>" +
                            element.name +
                            "</td><td><select id='usuario_accion' onchange='accionesUsuarios(this," +
                            element.iduser +
                            ")' class='form-control opciones'><option selected='selected' disabled selected>Acciones</option><option value='1'>Editar</option><option value='2'>Eliminar</option></selec></td></tr>"
                    );
                });
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
        }



        function accionesUsuarios(option, id) {

            var opt = $(option).val();
            if (opt == 1) {
                $('#formregistrousuarios').trigger("reset");
                axios.post(principalUrl + "registro/editarusuarios/" + id)
                    .then((respuesta) => {
                        formregistro.name.value = respuesta.data.datosusuario.name;
                        formregistro.email.value = respuesta.data.datosusuario.email;
                        formregistro.rol.value = respuesta.data.rol.name;
                        formregistro.password.value = respuesta.data.datosusuario.password;
        
                        formregistro.password_confirm.value =
                            respuesta.data.datosusuario.password;
                        document.getElementById("password").readOnly = true;
                        document.getElementById("password-confirm").readOnly = true;
        
                        document.getElementById("guardarusuario").innerText = "Actualizar";
                        $("#btnNuevo").show();
                        formregistro.id_user.value = respuesta.data.datosusuario.id;
                    })
                    .catch((error) => {
                        if (error.response) {
                            console.log(error.response.data);
                        }
                    });
            } else if (opt == 2) {
                Swal.fire({
                    title: "Eliminar",
                    text: "¿Estas seguro de eliminar usuario?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Continuar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post(principalUrl + "registro/eliminarUsuario/" + id)
                            .then((respuesta) => {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Usuario eliminado",
                                    showConfirmButton: false,
                                    timer: 1200,
                                });
                                tablaagentes(); 
                            })
                            .catch((error) => {
                                if (error.response) {
                                    console.log(error.response.data);
                                }
                            });
                    } else {
                    }
                });
            }
            $(option).prop("selectedIndex", 0);
        }

        function limpiarForm() {
            $("#formregistrousuarios").trigger("reset");
            $("#id_user").val("");
            document.getElementById("password").readOnly = false;
            document.getElementById("password-confirm").readOnly = false;
            document.getElementById("guardarusuario").innerText = "Registrar";
            $("#btnNuevo").hide();
        }
        