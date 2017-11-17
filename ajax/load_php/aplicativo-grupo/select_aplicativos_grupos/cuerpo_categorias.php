<?php
require_once ('../../../../data/pid_view.php');
$object = new pid_view();
//$id_aplicativo = (isset($_GET['id_apli'])) ? "true" : "false";
$id_apli = $_GET['id_apli'];
$result_cat = $object->view_category_assoc($id_apli);
?>
<?php while ($row_cat = $result_cat->fetch_assoc()){ ?>
    <option value="<?= $row_cat['id_cat'] ?>" selected><?= $row_cat['nom_cat'] ?></option>
<?php } ?>
