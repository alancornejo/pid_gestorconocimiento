<?php
    session_start();
    $seconds = 0;
    sleep($seconds);
    if(empty($_SESSION['id_user_apl'])){
?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Su sesión ha culminado</h3>
        </div>
        <div class="modal-body">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">No te encuentras logeado</h3>
                </div>
                <div class="panel-body text-center">
                  La sesión ya ha culminado por el cual no podras visualizar nada en la plataforma, 
                  favor de actualizar la web para poder ingresar nuevamente o darle click al siguiente boton : <a data-dismiss="modal" class="btn btn-warning cierre_modal">Actualizar</a>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <a data-dismiss="modal" class="btn btn-default cierre_modal">Cerrar</a>
        </div>
    </div>
<?php
    }else{
    require_once ('../../../data/pid_encuesta.php');
    require_once ('../../../data/pid_access.php');
    $object_permisos = new pid_permisos();
    $object_encuesta = new Encuesta();
    $id_user = $_SESSION['id_user_apl'];
    $id_enc_pregunta = $_GET['id'];
    $result = $object_encuesta->view_enc_pregunta_opc($id_enc_pregunta);
    $result_opc = $object_encuesta->view_enc_opc($id_enc_pregunta);
    $num_opc = $result_opc->num_rows;
    $opciones = $result->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_opc_enc'] != "true"){
?> 
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Acceso Bloqueado</h3>
    </div>
    <div class="modal-body">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Sin permisos para el acceso al módulo</h3>
            </div>
            <div class="panel-body text-center">
              No cuentas con los permisos correspondientes para el acceso a este módulo, contacte con el desarrolador y/o administrador.
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<?php }else{ ?>
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">Editar Opciones</h3>
        </div>
        <div class="modal-body">
            <form id="edit_enc_opciones" class="sky-form">
                <fieldset>
                    <div class="contenido_opciones_edit"></div>
                    <div class="row modal-footer">
                        <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                        <input class="btn btn-primary" type="submit" value="Editar">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
<script>
    
    $('.contenido_opciones_edit').fadeIn(500).load("ajax/load_php/encuesta/opciones_enc_edit.php?id=<?= $id_enc_pregunta ?>");
            
    /* Funcion eliminar conocimiento */
    function eliminar_enc_opcion(id){
      var id_enc_opcion = id;
        swal({
            title: 'Deseas eliminar esta opción?',
            text: "Al eliminarlo se actualizara la cantidad de opciones",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "GET",
                url: "ajax/action_class/encuesta/delete_enc_opcion.php",
                data: "id="+ id_enc_opcion,
                success: function(data) {
                    if(data == "true"){
                        setTimeout(function(){  
                            swal("", "Se elimino la opción con exito.", "success");  
                        }, 600);
                        $('.contenido_opciones_edit').fadeIn(500).load("ajax/load_php/encuesta/opciones_enc_edit.php?id=<?= $id_enc_pregunta ?>");
                    }else if(data == "sin_permiso"){
                        swal("", "No cuentas con el permiso correspondiente.", "error");
                    }else{
                        swal("", "Error al eliminar la opción, informalo al administrador y/o desarrollador.", "error");
                    }

                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal("", "No se elimino la opción", "error");
          }
        })
    };
    /* Fin Funcion eliminar conocimiento */
            
    $('#edit_enc_opciones').submit(function( event ) {
        var datos = $(this).serialize();
        swal({
            title: 'Deseas editar estas opciones',
            text: "Recuerda haber llenado todo correctamente !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-edit"></i> Editar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "POST",
                url: "ajax/action_class/encuesta/edit_enc_opciones.php",
                data: datos,
                success: function(data) {
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se edito las opciones con exito, ahora favor de agregar las opciones",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            }).then(function() {
                                setTimeout(function(){
                                    $(document.body).css('padding-right','');
                                },200);
                            });
                            $('#modal_edit_enc_opciones').modal('toggle');
                        }, 600);
                        tabla_opciones_encuesta.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al editar las opciones, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }

                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal({
                title: "",
                text: "No se edito ningun opción",
                type: "error",
                showCancelButton: false,
                showConfirmButton: true
            });
          }
        });
        event.preventDefault();
    });
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>