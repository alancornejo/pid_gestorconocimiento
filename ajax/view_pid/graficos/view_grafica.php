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
    require_once ('../../../data/pid_examen.php');
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $tipo_servicio = $_SESSION['tipo_servicio'];
    $id_user_exam = $_GET['id_user'];
    $id_identificador = $_GET['id_identificador'];
    $object = new examen_usuario();
    $object_access = new pid_permisos();
    $result_access = $object_access->user_permisos($id_user);
    $result = $object->view_grafico($id_user_exam, $id_identificador);
    $result_obs = $object->view_nota_actual($id_identificador, $id_user_exam);
    $row = $result->fetch_assoc();
    $row_obs = $result_obs->fetch_assoc();
    $row_permisos = $result_access->fetch_assoc();
    $id_examen = $row['preguntas'];
    $i = 0;
    $result_preguntas = $object->validar_preguntas($id_examen, $tipo_servicio);
?>
<style>
    .highcharts-container {
        width: 100% !important;
        height: 100% !important;
        text-align: center !important;
    }
</style>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 class="modal-title">Examen : <?= $row['titulo_examen'] ?></h3>
  </div>
  <div class="modal-body">
    <?php if($row_obs['examen_tomado'] != 4){ ?>
        <div class="row">
            <section class="col col-12">
              <div id="grafico"></div>
            </section>
        </div>
        <div class="row">
          <section class="col col-12">
            <h3 class="text-center text-primary"><u>Preguntas del examen</u></h3>                     
          </section>
          <?php  
            if($row_permisos['graf_exam_usua'] == "true"){
                $rpta = 0;
                while($reg = $result_preguntas->fetch_array()){
                    $respuestas = explode(',',$row['respuestas']);
                    foreach($respuestas as $valor) {
                        $validacion[] = $valor;
                    }
               ?>
                <div class="col-md-12">
                    <b class="<?php
                    if($validacion[$i] == $reg['respuesta_correcta']){
                        echo "text-success";
                    }elseif($validacion[$i] == "nada"){
                        echo "text-default";
                    }else{
                        echo "text-danger";
                    }
                    $i = $i + 1;
                ?>"><?= $i.") " ?></b> <b><a style="cursor: pointer" data-toggle="modal" data-target="#modal_ver_conocimiento_grafico" onclick="view_atu_grafico(<?= $reg['id_tabla'] ?>)">[<?php if($tipo_servicio == "0"){ echo "APL".$reg['id_atu']; }elseif($tipo_servicio == "1"){ echo "BIO".$reg['id_atu']; } ?>]</a> <?= utf8_encode($reg['nombre_pregunta']) ?></b>
                    <br><br>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <b class="text-primary">Rpta Marcada : <?php if($validacion[$rpta] == "nada"){ echo ""; }else{ echo $validacion[$rpta].") "; } ?> <?php if($validacion[$rpta] == "nada"){ echo "Sin Respuesta Marcada"; }else{ echo utf8_decode(addslashes($reg['respuesta_'.$validacion[$rpta]]));} ?></b>
                            <br>
                            <b class="text-info">Rpta Correcta : <?= $reg['respuesta_correcta'].") " ?> <?= utf8_decode(addslashes($reg['respuesta_'.$reg['respuesta_correcta']])) ?></b>
                        </div>
                    </div>
                    <br><br>
                </div>
          <?php
                  $rpta ++;
              }
            }else{
                if($row['fecha_revision'] == NULL || $row['fecha_revision'] == ""){
                    $fec_revision = "1990-01-01 12:00:00";
                }else{
                    $fec_revision = $row['fecha_revision'];
                }
                if(strtotime($fec_revision) < strtotime(date("Y-m-d H:i:s")) ){
                  while($reg = $result_preguntas->fetch_array()){
                        $respuestas = explode(',',$row['respuestas']);
                        foreach($respuestas as $valor) {
                            $validacion[] = $valor;
                        }
                   ?>
                    <div class="col-md-12">
                        <b class="<?php
                        if($validacion[$i] == $reg['respuesta_correcta']){
                            echo "text-success";
                        }elseif($validacion[$i] == "nada"){
                            echo "text-default";
                        }else{
                            echo "text-danger";
                        }
                        $i = $i + 1;
                        ?>"><?= $i.") " ?></b> <b><a style="cursor: pointer" data-toggle="modal" data-target="#modal_ver_conocimiento_grafico" onclick="view_atu_grafico(<?= $reg['id_tabla'] ?>)">[<?php if($tipo_servicio == "0"){ echo "APL".$reg['id_atu']; }elseif($tipo_servicio == "1"){ echo "BIO".$reg['id_atu']; } ?>]</a> <?= utf8_encode($reg['nombre_pregunta']) ?></b>
                        <br><br>
                    </div>
          <?php
                  }
                }else{
          ?>
            <section class="col col-md-12">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                      <h3 class="panel-title">No puedes ver las respuestas de este examen</h3>
                  </div>
                  <div class="panel-body text-center">
                      Podras visualizar esta informacion, el <b><?= date('d/m/Y',  strtotime($row['fecha_revision'])); ?></b> a las <b><?= date('H:i a',  strtotime($row['fecha_revision'])); ?></b>
                  </div>
              </div>
            </section>
          <?php
                }
            }
          ?>
        </div>
    <?php }else{ ?>
        <div class="col col-md-12">
            <div class="col col-md-6">
                <center>
                    <h1 class="text-danger">Nota Actual</h1>
                    <h2 class="text-danger"><?= $row_obs['nota_final'] ?></h2>
                </center>
            </div>
            <div class="col col-md-6">
                <center>
                    <h1 class="text-primary">Nota Anterior</h1>
                    <h2 class="text-primary"><?= $row_obs['nota_observado'] ?></h2>
                </center>
            </div>
        </div>
        <br><br>
        <div class="col col-12">
          <section class="comment-list">
              <article class="row">
                  <div class="col-md-12 col-sm-12">
                      <div class="panel panel-primary left">
                          <div class="panel-heading right">¿Por qué estoy observado?</div>
                          <br>
                          <div class="panel-body">
                              <br>
                              <div class="comment-post">
                                  <p>
                                  <?= $row_obs['comentario_observado'] ?>
                                  </p>
                              </div>
                          </div>
                      </div>
                  </div>
              </article>
          </section>
        </div>
    <?php } ?>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
  </div>
</div>
<script>
    $(function () {
        $('#grafico').highcharts({
            chart: {
                type: 'pie',
                style: {
                    "fontFamily": "Roboto"
                },
                position: {
                    align: 'center'
                },
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: 'Resultado del Examen : <?= $row['titulo_examen'] ?>',
                style: {
                    "fontSize": '12px',
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            subtitle: {
                text: '<?= utf8_encode($row['nom_user']) ?>',
                style: {
                    "fontSize": '12px',
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            plotOptions: {
                pie: {
                    innerSize: 100,
                    depth: 45,
                    cursor: 'pointer',
                    showInLegend: true,
                    allowPointSelect: false,
                    point:{
                        events : {
                         legendItemClick: function(e){
                             e.preventDefault();
                         }
                        }
                    },
                    style: {
                        "fontSize": '12px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                }
            },
            exporting:{
                fallbackToExportServer: false
            },
            series: [{
                name: 'Cantidad',
                colorByPoint: true,
                data: [
                    {
                        name: 'Correctas [<?= $row['correctas'] ?>]',
                        y: <?= $row['correctas'] ?>,
                        color : '#267F00',
                        style: {
                            "fontSize": '12px',
                            "fontFamily": "Roboto",
                            "fontWeight": "bold"
                        }
                    },
                    {
                        name: 'Incorrectas [<?= $row['incorrectas'] ?>]',
                        y: <?= $row['incorrectas'] ?>,
                        color : '#FF2D2D',
                        style: {
                            "fontSize": '12px',
                            "fontFamily": "Roboto",
                            "fontWeight": "bold"
                        }
                    },
                    {
                        name: 'Sin Respuesta [<?= $row['sin_respuesta'] ?>]',
                        y: <?= $row['sin_respuesta'] ?>,
                        color : '#CCCCCC',
                        style: {
                            "fontSize": '12px',
                            "fontFamily": "Roboto",
                            "fontWeight": "bold"
                        }
                    }
                ]
            }]
        });
    });
    
    $('#modal_ver_conocimiento_grafico').on('hidden.bs.modal', function () {
        $(document.body).addClass('modal-open');
    });
    
</script>
<?php } ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>