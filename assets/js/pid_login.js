/* Login */
$('#login_formulario').submit(function( event ){
    var dataString = $(this).serialize();
    if($("#username").val() == '' || $("#password").val() == ''){
        swal({
            title: "",
            text: "Favor de llenar todos los campos",
            type: "warning",
            timer: 1500,
            showConfirmButton: false
        }).then(
           function(result) {
             // handle Confirm button click
             // result is an optional parameter, needed for modals with input
           }, function(dismiss) {
             // dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
           }
        );
    }else{
        $.ajax({
            type: "POST",
            url: "ajax/action_class/login/login_ajax.php",
            data: dataString,
            cache: false,
            beforeSend: function(){ $("#login").val('Iniciando...');},
            success: function(data){
                if(data == "conectado"){
                    swal({
                       title: "",
                       text: "Ingresaste con exito, espere un momento...",
                       type: "success",
                       timer: 1500,
                       showConfirmButton: false
                    }).then(
                        function(result) {
                          // handle Confirm button click
                          // result is an optional parameter, needed for modals with input
                        }, function(dismiss) {
                          // dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
                        }
                      );
                    setTimeout(function (){
                        window.location.href = "plataforma";
                    },1500);
                }else if(data == "incorrecto"){
                    /*$('#box').shake();*/
                    $("#login").val('Iniciar Sesión')
                    swal({
                       title: "",
                       text: "Usuario y/o contraseña incorrectos",
                       type: "error",
                       timer: 1000,
                       showConfirmButton: false
                    }).then(
                        function(result) {
                          // handle Confirm button click
                          // result is an optional parameter, needed for modals with input
                        }, function(dismiss) {
                          // dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
                        }
                      );
                }else{
                    $("#login").val('Iniciar Sesión')
                    swal({
                       title: "Usuario Bloqueado",
                       text: "El usuario se desbloqueara el " + data,
                       type: "error",
                       timer: 9000,
                       showConfirmButton: false
                    }).then(
                        function(result) {
                          // handle Confirm button click
                          // result is an optional parameter, needed for modals with input
                        }, function(dismiss) {
                          // dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
                        }
                      );
                }
            }
        });
    }
    event.preventDefault();
});
/* Fin Login */