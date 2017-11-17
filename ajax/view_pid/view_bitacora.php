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
    require_once ('../../data/pid_access.php');
    $object = new pid_view();
    $object_access = new pid_auth();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_view = $object->view_contenido_bitacora($id);
    $result_access = $object_access->user_auth($id_user);
    $row = $result_view->fetch_assoc();
    $row_access = $result_access->fetch_assoc();

?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $row['txt_bitacora']; ?> - <?php if(substr($row['num_caso'], 0, -12) == "INC"){ echo "[IDM ".$row['num_caso']."]"; }else{ echo "[SDM ".$row['num_caso']."]"; }?></h3>
    </div>
    <div class="modal-body">
        <?php if($row_access['bloqueo_examen'] == 0){ ?>
        <div>
            <?= $row['contenido']; ?>
        </div>
        <br>
        <div class="row">
            <?php if($row['id_estado'] == "ASIGNADO") { ?>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="panel panel-warning text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"></i> Asignado</h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_apertura'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4"></div>
            <?php }else if($row['id_estado'] == "SOLUCIONADO"){
                if($row['fec_reasi'] == '' || $row['fec_reasi'] == NULL){
            ?>
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="panel panel-warning text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_apertura'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Solucionado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_solucion'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2"></div>
            <?php }else{ ?>
            <div class="col-md-4">
                <div class="panel panel-warning text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_apertura'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Re-Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_reasi'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Solucionado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_solucion'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php }
            }else if($row['id_estado'] == "RE-ASIGNADO"){ ?>
            <div class="col-md-2"></div>
            <div class="col-md-4">
                <div class="panel panel-warning text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_apertura'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Re-Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_reasi'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2"></div>
            <?php }else if($row['id_estado'] == "CERRADO") {
                if($row['fec_reasi'] == '' || $row['fec_reasi'] == NULL){
            ?>
            <div class="col-md-4">
                <div class="panel panel-warning text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_apertura'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Solucionado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_solucion'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Cerrado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_cierre'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php }else{ ?>
            <div class="col-md-3">
                <div class="panel panel-warning text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_apertura'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Re-Asignado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_reasi'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Solucionado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_solucion'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Cerrado</b></h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= date('d/m/Y H:i a', strtotime($row['fec_cierre'])) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php }
            } ?>
        </div>
        <?php }else{ ?>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Ya has iniciado un examen</h3>
            </div>
            <div class="panel-body text-center">
              Empezaste tu examen de conocimiento, por el cual el KDB se encontrara bloqueado.
            </div>
        </div>
        <?php } ?>
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