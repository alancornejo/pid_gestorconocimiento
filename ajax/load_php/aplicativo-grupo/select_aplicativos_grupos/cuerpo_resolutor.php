<?php
require_once ('../../../../data/pid_view.php');
$object = new pid_view();
$result_res = $object->view_usuario_resolutor();
$ver_res = (isset($_GET['id_res'])) ? "true" : "false";
if($ver_res == "false"){
?>
    <option value="" disabled selected>Selecciona Aqui</option>
    <?php while ($row_res = $result_res->fetch_assoc()){ ?>
        <option value="<?= $row_res['id_res'] ?>"><?= $row_res['nom_res'] ?></option>
    <?php } ?>
<?php }else{ ?>
    <?php while ($row_reso = $result_res->fetch_assoc()){ ?>
        <option value="<?= $row_reso['id_res'] ?>" <?php if($row_reso['id_res'] == $_GET['id_res']){ echo "selected"; } ?>><?= $row_reso['nom_res'] ?></option>
    <?php } ?>
<?php } ?>
