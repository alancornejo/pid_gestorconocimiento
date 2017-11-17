<?php
require_once ('../../../../data/pid_view.php');
$object = new pid_view();
$result_asig = $object->view_grupo_asignado();
$ver_apli = (isset($_GET['id_apli'])) ? "true" : "false";
$id_grupo = (isset($_GET['id_grupo'])) ? "true" : "false";

if($ver_apli == "false"){
    if($id_grupo == "false"){
    ?>
        <option value="" disabled selected>Selecciona Aqui</option>
        <?php while ($row_asig = $result_asig->fetch_assoc()){ ?>
            <option value="<?= $row_asig['id_grupo'] ?>"><?= $row_asig['nom_grupo'] ?></option>
        <?php } ?>
    <?php }else{ ?>
        <option value="" disabled selected>Selecciona Aqui</option>
        <?php while ($row_asig = $result_asig->fetch_assoc()){ ?>
            <option value="<?= $row_asig['id_grupo'] ?>" 
                <?php if($row_asig['id_grupo'] == $_GET['id_grupo']){
                    echo "selected";
                } ?>><?= $row_asig['nom_grupo'] ?></option>
        <?php } ?>
    <?php } ?>
<?php }else{
    $id_apli = $_GET['id_apli'];
    $edit_kdb = (isset($_GET['edit_kdb'])) ? "true" : "false";
    $result_list_grupo = $object->view_grupo_asignado();
    $result_grupo = $object->view_grupo_assoc($id_apli);
    $row_g = $result_grupo->fetch_assoc();
?>
    <?php if($edit_kdb == "false"){ ?>
    <option value="" disabled selected>Selecciona Aqui</option>
    <?php } ?>
    <?php while ($row_grupo = $result_list_grupo->fetch_assoc()){ ?>
        <option value="<?= $row_grupo['id_grupo'] ?>" <?php if($row_grupo['id_grupo'] == $row_g['id_grupo']){ echo "selected"; }  ?>><?= $row_grupo['nom_grupo'] ?></option>
    <?php } ?>
<?php } ?>