<?php
    session_start();
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    require_once ('../../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_auth();
    $result = $object->user_auth($id_user);
    $row_profile = $result->fetch_assoc();    
?>
<center>
    <?php
        if($row_profile['img_user'] == NULL || $row_profile['img_user'] == ""){
            $src = "assets/images/avatar_default.jpg";
        }else{ 
            $src = "http://".$_SERVER['SERVER_NAME'].$row_profile['img_user'];  
        }
    ?>
   <img class="img-responsive img-center" style="width: 90px;height: 90px" src="<?= $src ?>">
</center>