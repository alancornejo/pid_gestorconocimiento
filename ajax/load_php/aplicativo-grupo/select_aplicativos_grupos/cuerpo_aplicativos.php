<?php
require_once ('../../../../data/pid_view.php');
$object = new pid_view();
$result_apl = $object->view_category();
$id_aplicativo = (isset($_GET['id_aplicativo'])) ? "true" : "false";

if($id_aplicativo == "false"){
?>
    <option value="" disabled selected>Selecciona Aqui</option>
    <?php while ($row_cat = $result_apl->fetch_assoc()){ ?>
        <option value="<?= $row_cat['id_apli'] ?>"><?= $row_cat['nom_apli'] ?></option>
    <?php } ?>
<?php }else{ ?>
    <option value="" disabled selected>Selecciona Aqui</option>
    <?php while ($row_cat = $result_apl->fetch_assoc()){ ?>
        <option value="<?= $row_cat['id_apli'] ?>" 
            <?php if($row_cat['id_apli'] == $_GET['id_aplicativo']){
                echo "selected";
            } ?>><?= $row_cat['nom_apli'] ?></option>
    <?php } ?>
<?php } ?>
