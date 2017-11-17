<?php
    session_start();
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    require_once ('../../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object_colaboracion = new pid_perfil_usuario();
    $result_colaboracion = $object_colaboracion->colaboracion_plataforma($id_user);
    $row_colaboracion = $result_colaboracion->fetch_assoc();
?>
<table class="table table-hover">
    <tbody>
        <tr>
            <td>
                <i class="fa fa-trash text-primary"></i> 
                <b>Borradores Aprobados :</b>
            </td>
            <td class="text-right">
                <?php if($row_colaboracion['cantidad_borradores'] == NULL || $row_colaboracion['cantidad_borradores'] == "0"){ 
                    echo "Ninguno";
                }else{ 
                    echo $row_colaboracion['cantidad_borradores']; 
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-comment text-primary"></i> 
                <b>Comentarios Calificados :</b> 
            </td>
            <td class="text-right">
                <?php if($row_colaboracion['cantidad_comentarios'] == NULL || $row_colaboracion['cantidad_comentarios'] == "0"){ 
                    echo "Ninguno"; 
                }else{ 
                    echo $row_colaboracion['cantidad_comentarios'];
                } ?>
            </td>
        </tr>
    </tbody>
</table>