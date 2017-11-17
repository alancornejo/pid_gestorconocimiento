<?php 
session_start();
$seconds = 0;
sleep($seconds);
require_once ('../../../data/pid_encuesta.php');
$id_encuesta = $_GET['id'];
$object = new Encuesta();
$result = $object->view_encuesta($id_encuesta);
$result_comentario = $object->view_encuesta_comentario($id_encuesta);
$result_analistas = $object->view_usuarios_conta();
$result_encuestas = $object->view_encuestas_conta($id_encuesta);
$analistas = $result_analistas->fetch_assoc();
$row = $result->fetch_assoc();
$cantidad_encuestas = $result_encuestas->fetch_assoc();
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $row['titulo_encuesta'] ?></h3>
    </div>
    <div class="modal-body">
        <div class="col col-12">
            <center><b class="text-danger">Aproximadamente se ha realizado <?= $cantidad_encuestas['cantidad_encuestas'] ?> veces esta encuesta</b></center>
            <br>
            <center>
                <div class="btn-group" role="group">
                    <a class="btn btn-primary ver_todo"><i class="fa fa-anchor"></i> Ver Todo</a>
                    <a class="btn btn-success ver_pregunta"><i class="fa fa-question"></i> Ver Preguntas</a>
                    <a class="btn btn-info ver_comentario"><i class="fa fa-comment"></i> Ver Comentarios</a>
                </div>
            </center>
            <br>
            <div class="seccion_preguntas seccion_todo">
                <center><h1>Preguntas de <?= $row['titulo_encuesta'] ?></h1></center>
                <br>
                <div class="col-md-12">
                    <div class="col-md-6">&nbsp;</div>
                    <div class="col-md-6 text-right"><label class="text-primary">Hay <b><?= $analistas['cantidad'] ?></b> analistas</label></div>
                </div>
                <?php 
                    $result_preguntas = $object->view_preguntas_encuesta($id_encuesta);
                    $u = 0;
                    while($row_preguntas = $result_preguntas->fetch_assoc()){ $u = $u + 1;
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <b class="text-primary"> <?= $u.") " ?></b> <b><?= $row_preguntas['titulo_pregunta'] ?></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php 
                            $id_enc_pregunta = $row_preguntas['id_enc_pregunta'];
                            $result_opciones = $object->view_enc_opc($id_enc_pregunta);
                            $i = 0;
                            while($row_opciones = $result_opciones->fetch_assoc()){ $i = $i + 1;
                                if($i == 1){
                                    $vocal = "a";
                                }else if($i == 2){
                                    $vocal = "b";
                                }else if($i == 3){
                                    $vocal = "c";
                                }else if($i == 4){
                                    $vocal = "d";
                                }else if($i == 5){
                                    $vocal = "e";
                                }else if($i == 6){
                                    $vocal = "f";
                                }else if($i == 7){
                                    $vocal = "g";
                                }else if($i == 8){
                                    $vocal = "h";
                                }else if($i == 9){
                                    $vocal = "i";
                                }else if($i == 10){
                                    $vocal = "j";
                                }
                            ?>
                                <label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="text-primary"> <?= $vocal.") " ?></b> <?= $row_opciones['titulo_enc_opciones'] ?>
                                </label>
                                <?php 
                                    $id_pregunta = $row_preguntas['id_enc_pregunta'];
                                    $id_opcion = $row_opciones['id_enc_opciones'];
                                    $result_cantidad_opciones = $object->verificar_cantidad_opciones($id_pregunta, $id_opcion);
                                    $row_cantidad_opciones = $result_cantidad_opciones->fetch_assoc();
                                    $cantidad_analistas = $analistas['cantidad'];
                                    $cantidad_opciones = $row_cantidad_opciones['cantidad_opciones'];
                                    $barra_porcentaje = round(($cantidad_opciones*100)/$cantidad_analistas);
                                ?>
                                <br>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <label class="text-primary"> - Esta opción se ha escogido <?= $cantidad_opciones ?> veces</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="<?= $barra_porcentaje?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $barra_porcentaje?>%;border-radius:4px !important;">
                                                <span class="sr-only"><?= $barra_porcentaje?>% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <b class="text-success"><?= $barra_porcentaje ?> %</b>
                                    </div>
                                </div>
                                <br>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <div class="seccion_todo seccion_separacion">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <hr style="min-width:85%; background-color:#a1a1a1 !important; height:1px;"/>
                </div>
            </div>
        </div>
        <div class="seccion_comentario seccion_todo">
            <div class="col col-12">
                <center><h1>Comentarios de <?= $row['titulo_encuesta'] ?></h1></center>
                <br>
                <center>
                    <select class="sl_filtro_enc selectpicker show-tick" data-header="Filtrar por :" data-width="50%">
                        <option value="sl_todo" selected>Ver todos los comentarios</option>
                        <option value="clim_satis">Clima y Satisfacción laboral</option>
                        <option value="cal_con">Calidad y Conocimiento</option>
                        <option value="inf_cond">Infraestructura y condiciones de trabajo</option>
                        <option value="jef_ges">Jefatura y Gestión de Operaciones</option>
                    </select>
                </center>
                <br><br>
                <section class="comment-list">
                    <?php 
                    while($row_comentario = $result_comentario->fetch_assoc()){
                        if($row_comentario['sl_comentario'] == "0"){
                            $header_panel = '<div class="panel-heading right">Clima y Satisfacción laboral</div>';
                            $class_panel = "clim_satis";
                        }else if($row_comentario['sl_comentario'] == "1"){
                            $header_panel = '<div class="panel-heading right">Calidad y Conocimiento</div>';
                            $class_panel = "cal_con";
                        }else if($row_comentario['sl_comentario'] == "2"){
                            $header_panel = '<div class="panel-heading right">Infraestructura y condiciones de trabajo</div>';
                            $class_panel = "inf_cond";
                        }else if($row_comentario['sl_comentario'] == "3"){
                            $header_panel = '<div class="panel-heading right">Jefatura y Gestión de Operaciones</div>';
                            $class_panel = "jef_ges";
                        }
                    ?>
                    <article class="row <?= $class_panel ?> sl_todo">
                        <div class="col-md-12 col-sm-12">
                            <div class="panel panel-primary left">
                                <?= $header_panel ?>
                                <br>
                                <div class="panel-body">
                                    <header class="text-left">
                                        <div class="comment-user">
                                            <div class="col-md-6"><i class="fa fa-windows"></i> <?= $row_comentario['ip_comentario'] ?></div>
                                            <div class="col-md-6 text-right"><i class="fa fa-clock-o"></i> <?= date('d/m/y H:i a',  strtotime($row_comentario['fecha_comentario'])) ?></div>
                                        </div>
                                    </header>
                                    <br>
                                    <div class="comment-post">
                                        <p>
                                        <?php
                                            if($row_comentario['text_comentario'] == NULL || $row_comentario['text_comentario'] == ""){
                                                echo "<b class='text-danger'>Comentario vacio</b>";
                                            }else{
                                                echo $row_comentario['text_comentario'];
                                            }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php } ?>
                </section>
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default cierre_modal">Cerrar</a>
    </div>
</div>
<script>
    
    $('.selectpicker').selectpicker();
    
    $('select.sl_filtro_enc').on('changed.bs.select', function(){
        $('.sl_todo').hide();
        $('.' + $(this).val()).fadeIn("blind");
    });
    
    $('.ver_pregunta').click(function(){
        $('.seccion_comentario,.seccion_separacion').fadeOut(function(){
            $('.seccion_preguntas').fadeIn();
        });
    });
    
    $('.ver_comentario').click(function(){
        $('.seccion_preguntas,.seccion_separacion').fadeOut(function(){
            $('.seccion_comentario').fadeIn();
        });
    });
    
    $('.ver_todo').click(function(){
        $('.seccion_todo').fadeOut(function(){
            $('.seccion_todo').fadeIn();
        });
    });
</script>