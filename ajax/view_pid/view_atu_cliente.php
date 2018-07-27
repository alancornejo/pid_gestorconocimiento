<?php
    require_once ('../../data/pid_view.php');
    require_once ('../../data/pid_data.php');
    require_once ('../../data/pid_examen.php');
    require_once ('../../data/pid_access.php');
    $object = new pid_view();
    $object_update = new update_pid();
    $object_access = new pid_auth();
    $object_permisos = new pid_permisos();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_view = $object->view_contenido($id);
    $result_access = $object_access->user_auth($id_user);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row = $result_view->fetch_assoc();
    $id_atu = $row['id_atu'];
    $object_bloqueo = new examen_usuario();
    $result_bloqueo = $object_bloqueo->bloquear_documento($id_atu);
    $row_bloqueo = $result_bloqueo->fetch_assoc();
    $row_access = $result_access->fetch_assoc();
    $row_permisos = $result_permisos->fetch_assoc();
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $row['titulo']; ?></h3>
    </div>
    <div class="modal-body">
        <div class="row center-block">
            <section class="col col-12">
            <?php
                $result_update = $object_update->update_contador($id);
                ?>
            <div id="counter" hidden>0</div>
            <div id="id_user" hidden><?= $id_user ?></div>
            <div><?= $row['contenido']; ?></div>
            <hr>
            </section>
        </div>
    </div>
</div>
<script>
    
    $(".print").on("click", function(event) {
        html2canvas($('.modal-content'), {
            onrendered: function(canvas) {
                var img = canvas.toDataURL("image/png")
                window.open(img);
            },
            allowTaint: true,
            letterRendering: true,
            taintTest: true,
            useCORS: true
        });
    });
    
    $.curCSS = function (element, attrib, val) {
        $(element).css(attrib, val);
    };
    
    $('#makeMeDraggable1').draggable({cancel:false});
    
    /* Funcion para cambiar estado de comentario */
function cambiar_estado_comentario(id,estado){
    var id_tabla = id;
    var estado_comentario = estado;
    
    if(estado_comentario == "1"){
        var estado_txt = "Deshabilitar";
        var estado_txt_dos = "deshabilito";
    }else{
        var estado_txt = "Habilitar";
        var estado_txt_dos = "habilito";
    }
    
    swal({
        title: 'Deseas ' + estado_txt + ' los comentarios de este documento?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> ' + estado_txt,
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/update/update_estado_comentario.php",
            data: "id="+ id_tabla + "&estado_comentario=" + estado_comentario,
            success: function(data) {
                if(data == "true"){
                    setTimeout(function(){     
                        swal({
                            title: "",
                            text: "Se " + estado_txt_dos + " los comentarios con exito",
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                        $('#modal_ver_conocimiento').modal('toggle');
                    }, 600);
                }else{
                    swal({
                        title: "",
                        text: "Error al " + estado_txt + " los comentarios, informalo al administrador y/o desarrollador",
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
            text: "No se " + estado_txt_dos + " los comentarios",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
}
/* Fin Funcion para cambiar estado de comentario */
</script>

<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>