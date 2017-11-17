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
    require_once ('../../data/pid_view.php');
    $object = new pid_view();
    $id = $_GET['id'];
    $result_view = $object->view_registro($id);
    $row = $result_view->fetch_assoc();
    
    if($row['modelo_registro'] == 1){
        if($row['tipo_registro'] == 1){
            $titulo = "CONOCIMIENTO CREADO - APL ".$row['id_modelo']."";
            $contenido = $row['contenido_registro'];
        }elseif($row['tipo_registro'] == 2){
            $titulo = "CONOCIMIENTO EDITADO - APL ".$row['id_modelo']."";
            $contenido = $row['contenido_registro'];
        }
    }
    
    if($row['modelo_registro'] == 2){
        if($row['tipo_registro'] == 1){
            $titulo = "BITÁCORA CREADA - N° CASO ".$row['id_modelo']."";
            $contenido = $row['contenido_registro'];
            $sub = "Esta Bitácora se creo en estado";
            if($row['estado_registro'] == "ASIGNADO"){
                $estado = '<a class="btn btn-warning" style="width: 121px;">ASIGNADO</a>';
            }elseif($row['estado_registro'] == "SOLUCIONADO"){
                $estado = '<a class="btn btn-success" style="width: 121px;">SOLUCIONADO</a>';
            }elseif($row['estado_registro'] == "RE-ASIGNADO"){
                $estado = '<a class="btn btn-primary" style="width: 121px;">RE-ASIGNADO</a>';
            }elseif($row['estado_registro'] == "CERRADO"){
                $estado = '<a class="btn btn-danger" style="width: 121px;">CERRADO</a>';
            }
            
        }elseif($row['tipo_registro'] == 2){
            $titulo = "BITÁCORA EDITADA - N° CASO ".$row['id_modelo']."";
            $contenido = $row['contenido_registro'];
            $sub = "Esta Bitácora se edito al estado";
            if($row['estado_registro'] == "ASIGNADO"){
                $estado = '<a class="btn btn-warning" style="width: 121px;">ASIGNADO</a>';
            }elseif($row['estado_registro'] == "SOLUCIONADO"){
                $estado = '<a class="btn btn-success" style="width: 121px;">SOLUCIONADO</a>';
            }elseif($row['estado_registro'] == "RE-ASIGNADO"){
                $estado = '<a class="btn btn-primary" style="width: 121px;">RE-ASIGNADO</a>';
            }elseif($row['estado_registro'] == "CERRADO"){
                $estado = '<a class="btn btn-danger" style="width: 121px;">CERRADO</a>';
            }
        }elseif($row['tipo_registro'] == 4){
            $titulo = "BITÁCORA ELIMINADA - N° ID ".$row['id_modelo']." - N° CASO ".$row['estado_registro']."";
            $contenido = $row['contenido_registro'];
        }
    }
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $titulo ?></h3>
    </div>
    <div class="modal-body">
        <?php
        if($row['tipo_registro'] == 1 || $row['tipo_registro'] == 2){
            if($row['modelo_registro'] == 2){ ?>
                <div class="text-center"><strong><?= $sub ?> : </strong><?= $estado ?></div>
            <hr>
            <?php 
                $contenido_original = explode("#", $row['bitacora_contenido']);
            ?>
            <div class="table-overflow-x">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Fecha Bitacora Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= date("d/m/Y",  strtotime($contenido_original[0])) ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Impacto Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[1] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Número de afectados Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[2] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Número de Correos Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[3] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Aplicativo Anterior</strong></span></td>
                            <td style="text-align: center;">
                                <b><?php 
                                    $id = $contenido_original[4];
                                    $result_aplicativo = $object->view_aplicativo($id);
                                    $row_aplicativo = $result_aplicativo->fetch_assoc();
                                    echo $row_aplicativo['nom_apli'];
                                ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Grupo Responsable Anterior</strong></span></td>
                            <td style="text-align: center;">
                                <b><?php 
                                    $id = $contenido_original[5];
                                    $result_grupo = $object->view_grupo($id);
                                    $row_grupo = $result_grupo->fetch_assoc();
                                    echo $row_grupo['nom_grupo'];
                                ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Titulo Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[6] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Responsable Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[7] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Número de Caso Anterior</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[8] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Estado Original</strong></span></td>
                            <td style="text-align: center;"><b><?= $contenido_original[9] ?></b></td>
                        </tr>
                        <tr>
                            <td style="background-color: #F9F9F9;"><span><strong>Fecha de estado Original</strong></span></td>
                            <td style="text-align: center;"><b><?= date("d/m/Y H:i a", strtotime($contenido_original[10])) ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } } ?>
            <span style="font-weight: bold">Contenido Anterior : </span>
        <div><?= $contenido ?></div>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<?php } ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>