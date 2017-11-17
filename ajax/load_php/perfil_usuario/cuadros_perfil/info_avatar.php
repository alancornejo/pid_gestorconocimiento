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
        }else if($_SERVER['SERVER_NAME'] == "localhost"){ 
            $src = "http://".$_SERVER['SERVER_NAME'].":8080/apl/".$row_profile['img_user']; 
        }else if($_SERVER['SERVER_NAME'] == "10.200.10.90" || $_SERVER['SERVER_NAME'] == "10.200.10.90/"){ 
            $src = "http://".$_SERVER['SERVER_NAME']."/apl".$row_profile['img_user']; 
        }else{ 
            $src = "http://".$_SERVER['SERVER_NAME'].$row_profile['img_user'];  
        }
    ?>
    <img style="width: 150px;height: 150px" title="profile image" class="img-responsive thumbnail" src="<?= $src ?>">
</center>