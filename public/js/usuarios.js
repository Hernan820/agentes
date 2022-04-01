let formregistro = document.getElementById("formregistrousuarios");

document.getElementById("guardarusuario").addEventListener("click", function () {
    if (validardatos() == false) {
        return;
    }
    var datosUsuario = new FormData(formregistro);

        axios.post(principalUrl + "registro/usuarios", datosUsuario)
            .then((respuesta) => {
                if(respuesta.data == true){
                    $('#formregistrousuarios').trigger("reset");
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Usuario guardado exitosamente!",
                        showConfirmButton: false,
                    });
                }else if(respuesta.data == false){
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