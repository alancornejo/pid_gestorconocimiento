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
                <i class="fa fa-user text-primary"></i> 
                <b>Nombre Completo :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['nom_user'] == NULL){ 
                    echo "-"; 
                }else{ 
                    echo utf8_encode($row_profile['nom_user']); 
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-credit-card text-primary"></i> 
                <b>DNI :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['dni_user'] == NULL){ 
                    echo "-"; 
                }else{ 
                    echo $row_profile['dni_user']; 
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-transgender text-primary"></i>
                <b>Genero :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['genero_user'] == NULL){ 
                    echo "-"; 
                }elseif($row_profile['genero_user'] == "0"){
                    echo "<i class='fa fa-male' style='color:green'></i> Hombre";
                }elseif($row_profile['genero_user'] == "1"){
                    echo "<i class='fa fa-female' style='color:pink'></i> Mujer";
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-child text-primary"></i>
                <b>Situación Familiar :</b> 
            </td>
            <td class="text-right">
                <?php if($row_profile['situacion_familiar'] == NULL){ 
                    echo "-";
                }elseif($row_profile['situacion_familiar'] == "0") {
                    echo "<i class='fa fa-close' style='color:red'></i> Sin Hijos";
                }elseif($row_profile['situacion_familiar'] == "1") {
                    echo "<i class='fa fa-check' style='color:green'></i> Con Hijos";
                } ?>
            </td>
        </tr>
        <?php if($row_profile['situacion_familiar'] == "1"){ ?>
        <tr>
            <td>
                <i class="fa fa-home text-primary"></i>
                <b>N° de Hijos :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['num_hijos'] == NULL){ 
                    echo "-"; 
                }elseif($row_profile['num_hijos'] == "1"){
                    echo $row_profile['num_hijos']." Hijo";
                }else{
                    echo $row_profile['num_hijos']." Hijos";
                } ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>
                <i class="fa fa-graduation-cap text-primary"></i>
                <b>Nivel de Estudio :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['estado_academico'] == NULL){ 
                    echo "-";
                }elseif($row_profile['estado_academico'] == "0"){ 
                    echo "Técnica";
                }elseif($row_profile['estado_academico'] == "1"){ 
                    echo "Universitaria";
                }?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-university text-primary"></i>
                <b>Situación Académica :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['situacion_academica'] == NULL){ 
                    echo "-";
                }elseif($row_profile['situacion_academica'] == "0"){ 
                    echo "En Curso";
                }elseif($row_profile['situacion_academica'] == "1"){ 
                    echo "Trunco";
                }elseif($row_profile['situacion_academica'] == "2"){ 
                    echo "Egresado";
                }elseif($row_profile['situacion_academica'] == "3"){ 
                    echo "Titulado";
                }?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-calendar text-primary"></i>
                <b>Fecha de Nacimiento :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['fecha_nacimiento'] == NULL){ 
                    echo "-";
                }else{
                    echo date("d/m/Y", strtotime($row_profile['fecha_nacimiento']));
                }?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-calendar-check-o text-primary"></i>
                <b>Fecha de Inicio Laboral :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['fec_ingreso'] == NULL){ 
                    echo "-";
                }else{
                    echo date("d/m/Y", strtotime($row_profile['fec_ingreso']));
                }?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-credit-card-alt text-primary"></i>
                <b>Código de Empleado :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['cod_empleado'] == NULL){ 
                    echo "-";
                }else{
                    echo $row_profile['cod_empleado'];
                }?>
            </td>
        </tr>
        <tr>
            <td>
                <i class="fa fa-envelope text-primary"></i>
                <b>Correo Personal :</b>
            </td>
            <td class="text-right">
                <?php if($row_profile['correo_personal'] == NULL){ 
                    echo "-";
                }else{
                    echo $row_profile['correo_personal'];
                }?>
            </td>
        </tr>
    </tbody>
</table>