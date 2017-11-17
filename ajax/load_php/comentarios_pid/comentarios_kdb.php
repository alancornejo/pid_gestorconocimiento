<?php
session_start();
$_SESSION['filemanager_categoria'] = "comentario";
require_once ('../../../data/pid_data.php');
require_once ('../../../data/pid_access.php');
$id_tabla = $_GET['id'];
$comentario = $_GET['comentario'];
$id_user = $_SESSION['id_user_apl'];
$object = new comentarios_pid();
$object_permisos = new pid_permisos();
$result = $object->comentarios_kdb($id_tabla);
$result_permisos = $object_permisos->user_permisos($id_user);
$row_permisos = $result_permisos->fetch_assoc();
$n = 0;
?>
<?php if($comentario == 1) {?>
<div class="row">
    <form id="insertar_comentario" class="col-md-12">
        <textarea name="contenido_comentario" class="comentario_kdb"></textarea>
        <input name="id_tabla" class="id_tabla" type="text" value="<?= $id_tabla ?>"  hidden>
        <input name="id_user" class="id_user" type="text" value="<?= $id_user ?>"  hidden>
        <br>
        <center><input type="submit" class="btn btn-primary agregar_comentario" value="Agregar Comentario"></center>
        <br>
    </form>
</div>
<?php } ?>
<div class="col col-12">
    <section class="comment-list">
      <?php while($row = $result->fetch_assoc()){
      ++$n;
      if($row['funcion_user'] == "0"){
          $funcion_user = "<t class='label label-primary'>Analista</t>";
      }else if($row['funcion_user'] == "1"){
          $funcion_user = "<t class='label label-default' style='background-color:green'>G.Correo</t>";
      }else if($row['funcion_user'] == "2"){
          $funcion_user = "<t class='label label-success'>G.Conocimiento</t>";
      }else if($row['funcion_user'] == "4"){
          $funcion_user = "<t class='label label-danger'>Administrador</t>";
      }else if($row['funcion_user'] == "8"){
          $funcion_user = "<t class='label label-info'>Apoyo PID</t>";
      }else if($row['funcion_user'] == "9"){
          $funcion_user = "<t class='label label-info'>Escalado</t>";
      }else if($row['funcion_user'] == "6"){
          $funcion_user = "<t class='label label-default' style='background-color:lemon'>Cl.Proyecto</t>";
      }else if($row['funcion_user'] == "7"){
          $funcion_user = "<t class='label label-default' style='background-color:lemon'>Apoyo Cl.Pro.</t>";
      }else if($row['funcion_user'] == "5"){
          $funcion_user = "<t class='label label-default' style='background-color:black'>Desarrollador</t>";
      }
      
      /*if($row['nuevo_comentario'] == "1" && $row['comentario_calificado'] == "0" && $row['funcion_user'] == "0" || $row['funcion_user'] == "1" || $row['funcion_user'] == "6" || $row['funcion_user'] == "7" || $row['funcion_user'] == "8" || $row['funcion_user'] == "9"){
          $tipo_panel = 'panel-danger';
          $header_panel = '<div class="panel-heading right">Nuevo Comentario</div>';
      }elseif($row['nuevo_comentario'] == "0" && $row['comentario_calificado'] == "1"){
          $tipo_panel = 'panel-success';
          $header_panel = '<div class="panel-heading right">Comentario Calificado</div>';
      }else{
          $tipo_panel = 'panel-default';
          $header_panel = '';
      }*/
      
      if($row['nuevo_comentario'] == "0" & $row['comentario_calificado'] == "0"){
          $tipo_panel = 'panel-default';
          $header_panel = '';
      }else if($row['nuevo_comentario'] == "1" & $row['comentario_calificado'] == "0"){
          $tipo_panel = 'panel-danger';
          $header_panel = '<div class="panel-heading right">Nuevo Comentario</div>';
      }else if($row['nuevo_comentario'] == "0" & $row['comentario_calificado'] == "1"){
          $tipo_panel = 'panel-success';
          $header_panel = '<div class="panel-heading right">Comentario Calificado</div>';
      }else if($row['nuevo_comentario'] == "1" & $row['comentario_calificado'] == "1"){
          $tipo_panel = 'panel-success';
          $header_panel = '<div class="panel-heading right">Comentario Calificado</div>';
      }
      
      $fec_leido = $row['fec_leido'];
      
      if($row['funcion_user'] == "0" || $row['funcion_user'] == "1" || $row['funcion_user'] == "6" || $row['funcion_user'] == "7" || $row['funcion_user'] == "8" || $row['funcion_user'] == "9"){ ?>
      <article class="row">
        <div class="col-md-2 col-sm-2 hidden-xs">
          <figure class="thumbnail">
            <?php
                if($row['img_user'] == NULL || $row['img_user'] == ""){
                    $src = "assets/images/avatar_default.jpg";
                }else{ 
                    $src = "http://".$_SERVER['SERVER_NAME'].$row['img_user'];  
                }
            ?>
            <img class="img-responsive" src="<?= $src ?>" />
            <figcaption class="text-center"><b><?= $row['claro_user'] ?></b></figcaption>
            <figcaption class="text-center"><?= $funcion_user ?></figcaption>
          </figure>
        </div>
        <div class="col-md-10 col-sm-10">
          <div class="panel <?= $tipo_panel ?> arrow left">
            <?= $header_panel ?>
            <div class="panel-body">
              <header class="text-left">
                  <div class="comment-user">
                    <div><i class="fa fa-user"></i> <?= utf8_encode($row['nom_user']) ?></div>
                    <div><i class="fa fa-clock-o"></i> <?= date('d/m/y H:i a',  strtotime($row['fec_comentario'])) ?></div>
                  </div>
              </header>
              <div class="comment-post">
                <p>
                  <?= $row['contenido'] ?>
                </p>
              </div>
              <?php if($row_permisos['apro_comment'] == "true"){ ?>
                <?php if($row['comentario_calificado'] == '0'){ ?>
                <div class="text-right">
                    <a onclick="calificar_comentario(<?= $row['id_comentario'] ?>,<?= $row['id_user'] ?>)" class="btn btn-default btn-sm"><i class="fa fa-check"></i> Calificar</a>
                    <?php if($fec_leido == NULL || $fec_leido == "" || $fec_leido == "NULL"){ ?>
                    <a onclick="marcar_leido_comentario(<?= $row['id_comentario'] ?>,<?= $row['id_user'] ?>)" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Marcar como Visto</a>
                    <?php }else{ ?>
                    <a class="btn btn-default btn-sm" style="cursor:pointer"><i class="fa fa-check text-primary"></i><i class="fa fa-check text-primary"></i> Visto <?php if(date("Y-m-d") == date("Y-m-d", strtotime($fec_leido))){ echo "a las ".date("h:i a", strtotime($fec_leido)); }else{ echo "el ".date("d - m", strtotime($fec_leido))." a las ".date("h:i a", strtotime($fec_leido)); } ?></a>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                <div class="text-right">
                    <a onclick="descalificar_comentario(<?= $row['id_comentario'] ?>,<?= $row['id_user'] ?>)" class="btn btn-default btn-sm"><i class="fa fa-times"></i> Descalificar</a>
                    <?php if($fec_leido == NULL || $fec_leido == "" || $fec_leido == "NULL"){ ?>
                    <a onclick="marcar_leido_comentario(<?= $row['id_comentario'] ?>,<?= $row['id_user'] ?>)" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Marcar como Visto</a>
                    <?php }else{ ?>
                    <a class="btn btn-default btn-sm" style="cursor:pointer"><i class="fa fa-check text-primary"></i><i class="fa fa-check text-primary"></i> Visto <?php if(date("Y-m-d") == date("Y-m-d", strtotime($fec_leido))){ echo "a las ".date("h:i a", strtotime($fec_leido)); }else{ echo "el ".date("d - m", strtotime($fec_leido))." a las ".date("h:i a", strtotime($fec_leido)); } ?></a>
                    <?php } ?>
                </div>
                <?php } ?>
              <?php } ?>
                <?php if($row_permisos['apro_comment'] == "false"){ ?>
                <div class="text-right">
                    <?php if($fec_leido == NULL || $fec_leido == "" || $fec_leido == "NULL"){ echo ""; }else{ ?>
                    <a class="btn btn-default btn-sm" style="cursor:pointer"><i class="fa fa-check text-primary"></i><i class="fa fa-check text-primary"></i> Visto <?php if(date("Y-m-d") == date("Y-m-d", strtotime($fec_leido))){ echo "a las ".date("h:i a", strtotime($fec_leido)); }else{ echo "el ".date("d-m", strtotime($fec_leido))." a las "."el ".date("h:i a", strtotime($fec_leido)); } ?></a>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
          </div>
        </div>
      </article>
      <?php }else{ ?>
      <article class="row">
        <div class="col-md-10 col-sm-10">
          <div class="panel panel-default arrow right">
            <div class="panel-body">
                <header class="text-right">
                  <div class="comment-user">
                    <div><i class="fa fa-user"></i> <?= utf8_encode($row['nom_user']) ?></div>
                    <div><i class="fa fa-clock-o"></i> <?= date('d/m/y H:i a',  strtotime($row['fec_comentario'])) ?></div>
                  </div>
                </header>
                <div class="comment-post">
                  <p>
                    <?= $row['contenido'] ?>
                  </p>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 hidden-xs">
          <figure class="thumbnail">
            <?php
                if($row['img_user'] == NULL || $row['img_user'] == ""){
                    $src = "assets/images/avatar_default.jpg";
                }else{
                    $src = "http://".$_SERVER['SERVER_NAME'].$row['img_user'];
                }
            ?>
            <img class="img-responsive" src="<?= $src ?>" />
            <figcaption class="text-center"><b><?= $row['claro_user'] ?></b></figcaption>
            <figcaption class="text-center"><?= $funcion_user ?></figcaption>
          </figure>
        </div>
      </article>
      <?php }} ?>
    </section>
</div>
<?php if($comentario == 1) {
    if(0 == $n){ ?>
<div class="row center-block">
    <div class="col col-12">
        <div class="alert alert-warning" role="warning">
            <span class="fa fa-warning" aria-hidden="true"></span>
            <span class="sr-only">Sin Comentarios</span>
            Este documento no cuenta con comentarios.
        </div>
    </div>
</div>
<?php } 
    }else{
?>
<div class="row center-block">
    <div class="col col-12">
        <div class="alert alert-primary" role="warning">
            <span class="fa fa-info" aria-hidden="true"></span>
            <span class="sr-only">Comentarios Deshabilitado</span>
            Los comentarios se encuentran deshabilitados en este documento.
        </div>
    </div>
</div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('textarea.comentario_kdb').tinymce({
            extended_valid_elements: "table[class=table table-bordered table-striped],ul[class=custom-bullet],img[class=img-responsive image_fix_comment center-block|!src|border:0|alt|title|width|height|style]",
            theme: "modern",
            height: 150,
            font_formats: "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager smileys"
            ],
            auto_convert_smileys: true,
            toolbar1: "responsivefilemanager undo redo | styleselect | forecolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | image table | smileys",
            style_formats: [
                {title: 'Open Sans', inline: 'span', styles: { 'font-family':'Open Sans'}},
                {title: 'Arial', inline: 'span', styles: { 'font-family':'arial'}},
                {title: 'Book Antiqua', inline: 'span', styles: { 'font-family':'book antiqua'}},
                {title: 'Comic Sans MS', inline: 'span', styles: { 'font-family':'comic sans ms,sans-serif'}},
                {title: 'Courier New', inline: 'span', styles: { 'font-family':'courier new,courier'}},
                {title: 'Georgia', inline: 'span', styles: { 'font-family':'georgia,palatino'}},
                {title: 'Helvetica', inline: 'span', styles: { 'font-family':'helvetica'}},
                {title: 'Impact', inline: 'span', styles: { 'font-family':'impact,chicago'}},
                {title: 'Symbol', inline: 'span', styles: { 'font-family':'symbol'}},
                {title: 'Tahoma', inline: 'span', styles: { 'font-family':'tahoma'}},
                {title: 'Terminal', inline: 'span', styles: { 'font-family':'terminal,monaco'}},
                {title: 'Times New Roman', inline: 'span', styles: { 'font-family':'times new roman,times'}},
                {title: 'Verdana', inline: 'span', styles: { 'font-family':'Verdana'}}
            ],
            menubar: true,
            fullscreen_new_window : true,
            toolbar_items_size: 'small',
            image_advtab: true,
            fix_list_elements : true,
            external_filemanager_path: "assets/js/tinymce/filemanager/",
            filemanager_title: "Gestor de Archivos - PID - CLARO AN" ,
            external_plugins: { filemanager: "filemanager/plugin.min.js"}
        });

        $('#insertar_comentario').submit(function( event ) {
            if($('.comentario_kdb').val() == ""){
                swal({
                    title: "",
                    text: "Favor de llenar la caja de comentarios",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
                return false;
            }else{
                var datos = $(this).serialize();
                swal({
                    title: '',
                    text: "Deseas agregar este comentario?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-plus"></i> Agregar',
                    showLoaderOnConfirm: false,
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/insert/insert_comentario.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se agrego el comentario con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    });
                                }, 600);
                                $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id_tabla ?>&comentario=<?= $comentario ?>');
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al insertar el comentario, informalo al administrador y/o desarrollador",
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
                        text: "No se agrego ningun comentario",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                  }
                });
            }
            event.preventDefault();
        });
    });
    
    /* Funcion aprobar comentario */
    function calificar_comentario(id,user){
      var id_comentario = id;
      var id_user = user;
        swal({
            title: '',
            text: "Deseas calificar este comentario?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-check"></i> Calificar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "GET",
                url: "ajax/action_class/update/update_comentario_calificado.php",
                data: "id="+ id_comentario + "&user=" + id_user + "&estado=0",
                success: function(data) {
                    if(data == "sin_permiso"){
                        swal({
                            title: "",
                            text: "No cuentas con el permiso correspondiente",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }else{
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se califico el comentario escogido con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }, 600);
                            $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id_tabla ?>&comentario=<?= $comentario ?>');
                        }else{
                            swal({
                                title: "",
                                text: "Error al calificar el comentario escogido, informalo al administrador y/o desarrollador",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }
                    }
                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal({
                title: "",
                text: "No se califico el comentario escogido",
                type: "error",
                showCancelButton: false,
                showConfirmButton: true
            });
          }
        })
    };
    /* Fin Funcion calificar comentario */

    /* Funcion descalificar comentario */
    function descalificar_comentario(id,user){
      var id_comentario = id;
      var id_user = user;
        swal({
            title: '',
            text: "Deseas descalificar este comentario?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-check"></i> Calificar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "GET",
                url: "ajax/action_class/update/update_comentario_calificado.php",
                data: "id="+ id_comentario + "&user=" + id_user + "&estado=1",
                success: function(data) {
                    if(data == "sin_permiso"){
                        swal({
                            title: "",
                            text: "No cuentas con el permiso correspondiente",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }else{
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se descalifico el comentario escogido con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }, 600);
                            $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id_tabla ?>&comentario=<?= $comentario ?>');
                        }else{
                            swal({
                                title: "",
                                text: "Error al descalificar el comentario escogido, informalo al administrador y/o desarrollador",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }
                    }
                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal({
                title: "",
                text: "No se descalifico el comentario escogido",
                type: "error",
                showCancelButton: false,
                showConfirmButton: true
            });
          }
        })
    };
    /* Fin Funcion descalificar comentario */
    
    /* Funcion aprobar comentario */
    function marcar_leido_comentario(id,user){
      var id_comentario = id;
      var id_user = user;
        swal({
            title: '',
            text: "Deseas marcar como visto este comentario?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-eye"></i> Marcar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "GET",
                url: "ajax/action_class/update/update_comentario_leido.php",
                data: "id="+ id_comentario + "&user=" + id_user,
                success: function(data) {
                    if(data == "sin_permiso"){
                        swal({
                            title: "",
                            text: "No cuentas con el permiso correspondiente",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }else{
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se marco como leido el comentario escogido con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }, 600);
                            $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id_tabla ?>&comentario=<?= $comentario ?>');
                        }else{
                            swal({
                                title: "",
                                text: "Error al marcar como leido el comentario escogido, informalo al administrador y/o desarrollador",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }
                    }
                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal({
                title: "",
                text: "No se marco como leido el comentario escogido",
                type: "error",
                showCancelButton: false,
                showConfirmButton: true
            });
          }
        })
    };
    /* Fin Funcion calificar comentario */
    
</script>