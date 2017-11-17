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
<table class="table table-hover">
    <tbody>
        <tr>
            <td>
                <i class="fa fa-mobile text-primary"></i> 
                <b>Telefono Celular :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['telefono_user'] == NULL){ 
                    echo "-";
                }else{ 
                    echo $row_profile['telefono_user']; 
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-phone text-primary"></i> 
                <b>Telefono Fijo :</b> 
            </td>
            <td class="text-right">
                <?php if($row_profile['telefono_fijo_user'] == NULL){ 
                    echo "-"; 
                }else{ 
                    echo $row_profile['telefono_fijo_user'];
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-phone text-primary"></i> 
                <b>Telefono Referencia :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['telefono_referencia_user'] == NULL){ 
                    echo "-"; 
                }else{ 
                    echo $row_profile['telefono_referencia_user'];
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-user text-primary"></i> 
                <b>Parentesco Tlf Referencia :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['ref_parentesco'] == NULL){ 
                    echo "-"; 
                }elseif($row_profile['ref_parentesco'] == "0"){ 
                    echo "Mamá";
                }elseif($row_profile['ref_parentesco'] == "1"){ 
                    echo "Papá";
                }elseif($row_profile['ref_parentesco'] == "2"){ 
                    echo "Hermano";
                }elseif($row_profile['ref_parentesco'] == "3"){ 
                    echo "Hermana";
                }elseif($row_profile['ref_parentesco'] == "4"){ 
                    echo "Esposo";
                }elseif($row_profile['ref_parentesco'] == "5"){ 
                    echo "Esposa";
                }elseif($row_profile['ref_parentesco'] == "6"){ 
                    echo "Hijo";
                }elseif($row_profile['ref_parentesco'] == "7"){ 
                    echo "Hija";
                }elseif($row_profile['ref_parentesco'] == "8"){ 
                    echo "Tio";
                }elseif($row_profile['ref_parentesco'] == "9"){ 
                    echo "Tia";
                }elseif($row_profile['ref_parentesco'] == "10"){ 
                    echo "Amigo";
                }elseif($row_profile['ref_parentesco'] == "11"){ 
                    echo "Amiga";
                } ?>
            </td>
        </tr>
    </tbody>
</table>