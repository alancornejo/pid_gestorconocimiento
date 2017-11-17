<?php
session_start();
require_once ('../../../data/pid_encuesta.php');
$object = new Encuesta();
$id_enc_pregunta = $_GET['id'];
$result = $object->view_enc_pregunta_opc($id_enc_pregunta);
$result_opc = $object->view_enc_opc($id_enc_pregunta);
$opciones = $result->fetch_assoc();
$num_opc = $result_opc->num_rows;
$i = 0;
while($enc_opciones = $result_opc->fetch_array()){ 
    $i++;
 ?>
    <div class="row">
        <section class="col <?php if($opciones['cantidad_opciones'] < $num_opc){ echo "col-11"; }else{ echo"col-12"; }?>">
            <label>Opcion <?= $i ?> :</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                <input name="id_opcion[]" type="text" value="<?= $enc_opciones['id_enc_opciones'] ?>" hidden>
                <input name="txt_opcion[]" type="text" class="txt_opcion_<?= $i ?> form-control" id="inputEOpcion_<?= $i ?>" placeholder="Opcion <?= $i ?>" value="<?= $enc_opciones['titulo_enc_opciones'] ?>">
            </div>
        </section>
        <?php if($opciones['cantidad_opciones'] < $num_opc){ ?>
        <section class="col col-1">
            <label>&nbsp;</label>
            <div class="input-group">
                <span class="input-group-addon" style="border: 1px solid #CCC;width: 10px;height: 33px !important;">
                    <i onclick="eliminar_enc_opcion(<?= $enc_opciones['id_enc_opciones'] ?>)" class="fa fa-close text-danger" style="cursor: pointer"></i>
                </span>
                <input type="text" class="form-control" style="display: none;">
            </div>
        </section>
        <?php } ?>
    </div>
<?php } ?>


<?php 
    if($num_opc < $opciones['cantidad_opciones']){ 
        $cantidad_opcion = $opciones['cantidad_opciones'] - $num_opc;
?>
<div class="row">
    <section class="col col-12">
        <div class="alert alert-danger">
            <i class="fa fa-warning"></i> <b>Esta pregunta tiene <?= $opciones['cantidad_opciones'] ?> de opciones habilitadas, favor de agregar <?= $cantidad_opcion ?> opción(es) faltante(s)</b>
        </div>
    </section>
</div>
<?php } ?>