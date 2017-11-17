<?php
    session_start();
    date_default_timezone_set('America/Bogota');
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
    require_once ("../../data/pid_examen.php");
    $id_examen = $_GET['id'];
    $_SESSION['id_examen_usuario'] = $id_examen;
    $id_user = $_SESSION['id_user_apl'];
    $id_user_asig = $id_user;
    $id_examen_tomado = $_GET['id'];
    $num_facil = ($_GET['num_facil'])+1;
    $num_dificil = $_GET['num_dificil'];
    $nota_final = 0;
    $_SESSION['id_identificador'] = $_GET['id_identificador'];
    $id_identificador = $_GET['id_identificador'];
    $object = new examen_usuario();
    $result = $object->view_examen_user($id_examen, $num_facil, $num_dificil);
    $result_e = $object->view_examen_espc_user($id_examen);
    $result_asignado = $object->view_examen_identificado_user($id_identificador,$id_user);
    $row = $result->fetch_assoc();
    $row_asignado = $result_asignado->fetch_assoc();
    $row_examen = $result_e->fetch_assoc();
    $i = 0;
    $e = 0;
    $f = ($_GET['num_facil'] + $_GET['num_dificil']);
    $fecha_actual = strtotime(date("Y-m-d H:i:s"));
    $fecha_entrada = strtotime($row_asignado['fecha_examen']);
    $fecha_termino = strtotime($row_asignado['fecha_termino']);
    $tiempo_real_examen = $row_examen['tiempo_examen'];
?>
<?php if($row_asignado['examen_tomado'] == 1){ ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title text-center">Examen Conocimiento</h3>
        </div>
        <div class="modal-body">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">Ya tomaste este examen</h3>
                </div>
                <div class="panel-body text-center">
                    Ya has desarrollado este examen, debes de actualizar la tabla para ver tu nota.
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a data-dismiss="modal" class="btn btn-primary">Cerrar</a>
        </div>
    </div>
<?php }else{ ?>
    <?php if($fecha_actual < $fecha_entrada){ ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-center">Examen Conocimiento</h3>
            </div>
            <div class="modal-body">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Examen fuera de fecha y hora asignada</h3>
                    </div>
                    <div class="panel-body text-center">
                        Este examen se encuentra fuera del tiempo asignado, vuelve abrir esta ventana el <b class="text-danger"><?= date("d/m/Y", strtotime($row_asignado['fecha_examen'])) ?></b> a las <b class="text-danger"><?= date("h:i a", strtotime($row_asignado['fecha_examen'])) ?></b>.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary">Cerrar</a>
            </div>
        </div>
    <?php }elseif($fecha_termino < $fecha_actual){ ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title text-center">Examen Conocimiento</h3>
        </div>
        <div class="modal-body">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Examen ya culminado</h3>
                </div>
                <div class="panel-body text-center">
                    Este examen ya ha culminado el <?= date("d/m/Y", strtotime($row_asignado['fecha_termino'])) ?> a las <?= date("h:i a", strtotime($row_asignado['fecha_termino'])) ?>.
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a data-dismiss="modal" class="btn btn-primary">Cerrar</a>
        </div>
    </div>
    <?= $result_bloqueo = $object->desbloquear_pid($id_user_asig); ?>
    <?= $result_bloqueo = $object->update_termino_examen($id_user, $id_identificador, $nota_final); ?>
    <?php }else{ ?>
    <?= $result_bloqueo = $object->bloquear_pid($id_user); ?>
    <?= $result_bloqueo = $object->update_tomando_examen($id_user, $id_identificador); ?>
    <?php
        $ecuacion = ($fecha_termino - $fecha_actual);
        $tiempo_examen = floor(abs($ecuacion))/60;
    ?>
            <style type="text/css">
                .stepwizard-step p {
                    margin-top: 10px;
                }

                .stepwizard-row {
                    display: table-row;
                }

                .stepwizard {
                    display: table;
                    width: 100%;
                    position: relative;
                }

                .stepwizard-step button[disabled] {
                    opacity: 1 !important;
                    filter: alpha(opacity=100) !important;
                }

                .stepwizard-row:before {
                    top: 14px;
                    bottom: 0;
                    position: absolute;
                    content: " ";
                    width: 100%;
                    height: 1px;
                    background-color: #ccc;
                    z-order: 0;
                }

                .stepwizard-step {
                    display: table-cell;
                    text-align: center;
                    position: relative;
                }

                .btn-circle {
                  width: 30px;
                  height: 30px;
                  text-align: center;
                  padding: 6px 0;
                  font-size: 12px;
                  line-height: 1.428571429;
                  border-radius: 15px;
                }
            </style>
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center">Examen de Conocimiento</h3>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary text-right"> Tiempo : <span id='timer'></span> </h5>                            
                        </div>
                        <div class="col-md-12">
                            <h3 class="text-center text-primary"><u><?= $row_examen['titulo_examen'] ?></u></h3>                     
                        </div>
                    </div>
                    <br>
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <?php for($c = 1; $c <= $f; $c++){ ?>
                                <div class="stepwizard-step">
                                    <a id="btn_<?= $c ?>" type="button" class="btn btn-default btn-circle <?php if($c == 1){ echo "active"; } ?>"><?= $c ?></a>
                                    <p>Pregunta <?= $c ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <br>
                    <form id="finalizar_examen">                       
                        <div id="myTabContent5" class="tab-content">
                            <?php while ($reg = $result->fetch_assoc()) { $e = $e + 1;?>
                                <div class="row tab-pane fade <?php if($e == 1){ echo "active"; } ?> in" id="step-<?= $e ?>">
                                    <div class="col-xs-12">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <b class="text-primary"> <?= $e.") " ?></b> <b><?= $reg['nombre_pregunta'] ?></b>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>
                                                            <input type="radio" value="1" name="<?= $reg['id_pregunta'] ?>" id="radio_<?= $reg['id_pregunta'] ?>"> <?= utf8_decode($reg['respuesta_1']) ?>
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" value="2" name="<?= $reg['id_pregunta'] ?>" id="radio_<?= $reg['id_pregunta'] ?>"> <?= utf8_decode($reg['respuesta_2']) ?>
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" value="3" name="<?= $reg['id_pregunta'] ?>" id="radio_<?= $reg['id_pregunta'] ?>"> <?= utf8_decode($reg['respuesta_3']) ?>
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" value="4" name="<?= $reg['id_pregunta'] ?>" id="radio_<?= $reg['id_pregunta'] ?>"> <?= utf8_decode($reg['respuesta_4']) ?>
                                                        </label>
                                                        <br>
                                                        <label>
                                                            <input type="radio" checked='checked' value="nada" name="<?= $reg['id_pregunta'] ?>" id="radio_<?= $reg['id_pregunta'] ?>" hidden>
                                                        </label>
                                                        <br>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <?php if($e != $f){ ?>
                                            <?php if($e > 1 && $e < $f){ ?>
                                            <a id="form_wizard_2" data-id="<?= $e - 1 ?>" data-id-2="<?= ($e + 1)-1 ?>" href="#step-<?= $e - 1 ?>" type="button" data-toggle="tab" aria-expanded="true" class="btn btn-primary"><i class="fa fa-angle-left"></i> Anterior</a>
                                            <?php } ?>
                                            <a id="form_wizard" data-id="<?= $e + 1 ?>" href="#step-<?= $e + 1 ?>" type="button" data-toggle="tab" aria-expanded="true" class="btn btn-primary">Siguiente <i class="fa fa-angle-right"></i></a>
                                        <?php }else{ ?>
                                            <a id="form_wizard_2" data-id="<?= $e - 1 ?>" data-id-2="<?= ($e + 1)-1 ?>" href="#step-<?= $e - 1 ?>" type="button" data-toggle="tab" aria-expanded="true" class="btn btn-primary"><i class="fa fa-angle-left"></i> Anterior</a>
                                            <input class="btn btn-primary finalizar_examen" type="button" value="Finalizar">
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="modal-footer" hidden>
                            <input class="btn btn-primary termino_examen" type="button" value="Termino">
                        </div>
                    </form>
                </div>
            </div>
    <script>
                
        $('a#form_wizard').click(function(){
            var id = $(this).attr("data-id");
            $("#btn_"+id).addClass('active');
        });
        
        $('a#form_wizard_2').click(function(){
            var id = $(this).attr("data-id-2");
            $("#btn_"+id).removeClass('active');
        });


        $(document).ready(function (){
            $(".termino_examen").hide();
        });

        $(".finalizar_examen").click(function (event) {
            var datos = $("#finalizar_examen").serialize();
            swal({
                title: 'Seguro que deseas finalizar el examen?',
                text: "Recuerda que esta nota es importante !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1b9cdd',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-check"></i> Finalizar',
                showLoaderOnConfirm: false,
                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
            }).then(function() {
                $.ajax({
                    type: "POST",
                    url: "ajax/action_class/examen/finalizar_examen.php",
                    data: datos,
                    success: function(data) {
                        setTimeout(function(){
                            swal({
                                title: "",
                                text: "Haz finalizado el examen",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            }).then(function() {
                                setTimeout(function(){
                                    $(document.body).css('padding-right','');
                                    window.location.reload(true);
                                },200);
                            });
                            $("#modal_view_examen").modal('toggle');
                        },600);
                        tabla_examen_usuario.ajax.reload( null, false );
                    }
                });
            }, function(dismiss) {
              if (dismiss === 'cancel') {
                swal("PID - CLARO AN", "No se finalizo el examen", "error");
              }
            });
            event.preventDefault();
        });
        
        $(".termino_examen").click(function (event) {
            var datos = $("#finalizar_examen").serialize();
            $.ajax({
                type: "POST",
                url: "ajax/action_class/examen/finalizar_examen.php",
                data: datos,
                success: function(data) {
                    setTimeout(function(){
                        swal({
                            title: "",
                            text: "Se culmino el tiempo del examen",
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: true
                        }).then(function() {
                            setTimeout(function(){
                                $(document.body).css('padding-right','');
                                window.location.reload(true);
                            },200);
                        });
                        $("#modal_view_examen").modal('toggle');
                    },600);
                    tabla_examen_usuario.ajax.reload( null, false );
                }
            });
            event.preventDefault();
        });
        
        <?php
            if($tiempo_examen < ($tiempo_real_examen/60)){
                $tiempo = ($tiempo_examen*60);
            }else{
                $tiempo = $tiempo_real_examen;
            }
        ?>
        
        var c = <?= $tiempo ?>;
        var t;
        timedCount();
        function timedCount() {
            var hours = parseInt( c / 3600 ) % 24;
            var minutes = parseInt( c / 60 ) % 60;
            var seconds = c % 60;
            var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);
            $('#timer').html(result);
            if(c == 20){
                swal({
                    title: "",
                    text: "Quedan 20 segundos para finalizar el examen",
                    type: "warning",
                    timer: "2000",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }else if(c == 0){
                $(".termino_examen").click();
            }
            c = c - 1;
            t = setTimeout(function(){ timedCount() }, 1000);
        }
    </script>
    <?php } ?>
<?php } ?>
<?php } ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>