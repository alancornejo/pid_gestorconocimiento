<?php
session_start();
require_once ('../../../data/pid_encuesta.php');
$object = new Encuesta();
$id_enc_pregunta = $_POST['id'];
$result = $object->view_enc_pregunta_opc($id_enc_pregunta);
$result_opc = $object->view_enc_opc($id_enc_pregunta);
$opciones = $result->fetch_assoc();
$num_opc = $result_opc->num_rows;

if($num_opc == 0 || $opciones['cantidad_opciones'] > $num_opc){
    $num_opc_enc = ($opciones['cantidad_opciones'] - $num_opc);
    for($i=0; $i<$num_opc_enc; $i++) { $i2 = $i + 1; ?>
        <div class="row">
            <section class="col col-12">
                <label>Opcion <?= $i2 ?> :</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                    <input name="txt_opcion[]" type="text" class="txt_opcion_<?= $i ?> form-control" id="inputEOpcion_<?= $i ?>" placeholder="Opcion <?= $i2 ?>">
                </div>
            </section>
        </div>
    <?php } ?>
<?php }else{ ?>
    <div class="row">
        <section class="col col-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Opciones ya registradas</h3>
                </div>
                <div class="panel-body text-center">
                    Favor de editar la pregunta, ya cuenta con opciones registrados en PID.
                </div>
            </div>
        </section>
    </div>
<?php } ?>
