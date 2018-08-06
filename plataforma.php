<?php
session_start();
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
header('Content-type: text/html; charset=UTF-8');
if(empty($_SESSION['id_user_apl']))
{
header('Location: login');
}
require_once ('data/pid_access.php');
require_once ('data/pid_data.php');
$ip_user = $_SERVER['REMOTE_ADDR'];
$id_user = $_SESSION['id_user_apl'];
$inicio_sesion = date("Y-m-d H:i:s");
$object = new pid_auth();
$object_permisos = new pid_permisos();
$object_update = new update_pid();
$result = $object->user_auth($id_user);
$result_permisos = $object_permisos->user_permisos($id_user);
$row_access = $result->fetch_assoc();
$row_permisos = $result_permisos->fetch_assoc();
if($row_access['estado_pid'] == 0 || $row_access['inicio_sesion'] == NULL){
    $result_update = $object_update->update_inicio_sesion($inicio_sesion, $id_user, $ip_user);
    $result_sesion = $object_update->update_ingreso($id_user);
}

if($row_access['estado_pid'] == 1 && $row_access['ip_user'] != $ip_user){
    header('Location: bloqueo');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<title>PID | Interbank</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.png">

	<!-- CSS Global Compulsory -->
	<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">

	<!-- CSS Header and Footer -->
        <link rel="stylesheet" href="assets/css/headers/header-v4-centered.css">
	<link rel="stylesheet" href="assets/css/footers/footer-v1.css">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="assets/plugins/animate.css">
	<link rel="stylesheet" href="assets/plugins/line-icons-pro/styles.css">
	<link rel="stylesheet" href="assets/plugins/line-icons/line-icons.css">
	<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/plugins/fancybox/source/jquery.fancybox.css">
	<link rel="stylesheet" href="assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" href="assets/plugins/revolution-slider/rs-plugin/css/settings.css" type="text/css" media="screen">
        <link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css">
        <link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css">
        
	<!-- CSS Theme -->
	<link rel="stylesheet" href="assets/css/theme-colors/default.css" id="style_color">
	<link rel="stylesheet" href="assets/css/theme-colors/blue.css" id="style_color">

	<!-- CSS Customization -->
	<link rel="stylesheet" href="assets/css/custom.css">
        <link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="assets/plugins/meganavbar/MegaNavbar.css">
        <link rel="stylesheet" href="assets/plugins/meganavbar/skins/navbar-default.css">
        <link rel="stylesheet" href="assets/plugins/meganavbar/animation/animation.css">
        <link rel="stylesheet" href="assets/plugins/datatables/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="assets/plugins/datatables/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="assets/plugins/datatables/css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" href="assets/plugins/datatables/css/fixedColumns.dataTables.min.css">
        <link rel="stylesheet" href="assets/plugins/datatables/css/scroller.dataTables.min.css">
        <link rel="stylesheet" href="assets/plugins/datatables/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="assets/js/plugins/pid/css/bootstrap-select.css">
        <link rel="stylesheet" href="assets/js/plugins/pid/css/daterangepicker.css">
        <link rel="stylesheet" href="assets/js/plugins/pid/css/DateTimePicker.css">
        <link rel="stylesheet" href="assets/js/plugins/pid/css/select.bootstrap.min.css">
        <link rel="stylesheet" href="assets/js/plugins/pid/css/bootstrap-switch.css">
        <link rel="stylesheet" href="assets/js/plugins/pid/css/bootcards-desktop.css">
</head>

<body>
    <div class="wrapper">
        <!--=== Header v4 ===-->
        <div class="header-v4">
            <!-- Topbar -->
            <div class="topbar-v1" style="background: #1B9CDD;border-top: solid 1px #1B9CDD;border-bottom: solid 1px #1B9CDD;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline top-v1-contacts">
                                <li style="color: white">
                                    <i class="fa fa-user" style="color: white"></i> Bienvenido, <b class="cuerpo_nombre_completo_menu"></b>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-inline top-v1-data">
                                <li style="border-right: solid 1px #1B9CDD;border-left: 1px solid #1B9CDD!important;border-top: 1px solid #1B9CDD!important;color: white">
                                    <i class="fa fa-calendar" style="color: white"></i> <?= $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ?>
                                </li>
                                <li style="border-right: solid 1px #1B9CDD;border-left: 1px solid #1B9CDD!important;border-top: 1px solid #1B9CDD!important;color: white">
                                    <i class="fa fa-clock-o" style="color: white"></i> <t id="clock"><?= date("g:i:s A") ?></t>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Topbar -->

      
        </div>
        <!--=== End Header v4 ===-->
        
        <!-- begin MegaNavbar-->
        <nav class="navbar navbar-default" id="main_navbar" role="navigation" style="margin-bottom: 0px;border-radius: 0px">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <!-- <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="javascript:void(0);" class="toggle_fixing"><i class="fa fa-chevron-down"></i></a>
                        </li>
                    </ul> -->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left dropdown-onhover">
                        <?php if($row_access['funcion_user'] == 6 || $row_access['funcion_user'] == 7){ echo ''; }else{ ?>
                        <li>
                            <a href="javascript:void(0);" class="ver_portal" aria-expanded="true">
                                <i class="fa fa-home"></i> <span class="hidden-sm">Portal</span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($row_access['funcion_user'] == 4 || $row_access['funcion_user'] == 5 || $row_permisos['gest_cono'] == "true" || $row_permisos['gest_borra'] == "true" || $row_permisos['gest_bita'] == "true" || $row_permisos['gest_cat'] == "true" || $row_permisos['gest_usua'] == "true" || $row_permisos['gest_exam'] == "true" || $row_permisos['gest_log_reg'] == "true" || $row_permisos['gest_nas'] == "true"){ ?>
                            <?php if($row_access['bloqueo_examen'] == 0){?>
                                <li class="divider"></li>
                                <li class="dropdown-grid">
                                    <a data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle" aria-expanded="true">
                                        <i class="fa fa-gears"></i> <span class="hidden-sm">Gestionar Plataforma</span><span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu no-padding" style="background: transparent url('assets/images/patterns/15.png') repeat scroll 0% 0%;">
                                        <ul>
                                            <li class="dropdown-header text-center panel_opciones_plataforma" id="todos_paneles">
                                                <div class="">
                                                    <div class="table-overflow-x">
                                                        <table class="table" style="width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <?php if($row_permisos['gest_cono'] == "true" || $row_permisos['gest_borra'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_conocimiento panel-body tooltips" data-id="conocimiento" data-toggle="tooltip" data-placement="bottom" title="Gestionar Conocimiento">
                                                                                    <i class="icon-communication-101 text-primary" style="font-size: 68px;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_bita'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_incidentes panel-body tooltips" data-id="incidentes" data-toggle="tooltip" data-placement="bottom" title="Gestionar Incidencias Masivas">
                                                                                    <i class="icon-medical-073 text-danger" style="font-size: 68px;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_nas'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_rd panel-body tooltips" data-id="rd" data-toggle="tooltip" data-placement="bottom" title="Gestionar Repositorio de Documentos">
                                                                                    <i class="icon-communication-164 text-warning" style="font-size: 68px;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_exam'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="ver_examen_pid">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_examenes panel-body tooltips" data-id="examenes" data-toggle="tooltip" data-placement="bottom" title="Gestionar Exámenes">
                                                                                    <i class="icon-education-025 text-success" style="font-size: 68px;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_enc'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="ver_encuesta_pid">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_encuesta panel-body tooltips" data-id="encuesta" data-toggle="tooltip" data-placement="bottom" title="Gestionar Encuesta">
                                                                                    <i class="icon-education-008 text-info" style="font-size: 68px;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_usua'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="ver_pid_usuarios">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_rrhh panel-body tooltips" data-id="rrhh" data-toggle="tooltip" data-placement="bottom" title="Gestionar Usuarios / RRHH">
                                                                                    <i class="icon-communication-109 text-primary" style="font-size: 68px;color: #0055FF;"></i>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_cat'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="ver_pid_aplicativos">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_bid panel-body tooltips" data-id="bid" data-toggle="tooltip" data-placement="bottom" title="Gestionar Base de Incidencias y Derivaciones">
                                                                                    <i class="icon-communication-159 text-primary" style="font-size: 68px;color: #3E3335;"></i>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_port'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="ver_portal_pid">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_portal_pid panel-body tooltips" data-id="portal_pid" data-toggle="tooltip" data-placement="bottom" title="Gestionar Portal PID">
                                                                                    <i class="icon-education-064 text-primary" style="font-size: 68px;color: #6075FF;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_log_reg'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="tabla_registro">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_reg_pid panel-body tooltips" data-id="reg_pid" data-toggle="tooltip" data-placement="bottom" title="Registros PID">
                                                                                    <i class="icon-electronics-037 text-primary" style="font-size: 68px;color: #744800;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="tabla_bloqueo">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="ef_reg_bloq_pid panel-body tooltips" data-id="reg_bloq_pid" data-toggle="tooltip" data-placement="bottom" title="Registros Bloqueos">
                                                                                    <i class="icon-electronics-037 text-primary" style="font-size: 68px;color: #744800;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="col-sm-12 dropdown-header text-center sub_opciones_plataforma sub_opc_conocimiento" id="conocimiento">
                                                <div class="col-sm-12">
                                                    <div class="table-overflow-x">
                                                        <table class="table" style="width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <?php if($row_permisos['crea_cono'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ins_conocimiento" class="ins_conocimiento">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_agregar_conocimiento panel-body tooltips" data-id="agregar_conocimiento" data-toggle="tooltip" data-placement="bottom" title="Agregar Conocimiento">
                                                                                    <i class="fa fa-plus text-primary" style="font-size: 68px;color: #1b9cdd;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['gest_borra'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="ver_pid_borrador">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_gestionar_borradores panel-body tooltips" data-id="gestionar_borradores" data-toggle="tooltip" data-placement="bottom" title="Gestionar Borradores">
                                                                                    <i class="fa fa-stack-overflow text-primary" style="font-size: 68px;color: #FF4800;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <center><a class="btn-u btn-u-blue rounded regresar_opciones_plataforma" data-id="conocimiento" style="color:#FFFFFF"><i class="fa fa-angle-double-left"></i> Regresar a las opciones generales</a></center>
                                                </div>
                                            </li>
                                            <li class="col-sm-12 dropdown-header text-center sub_opciones_plataforma sub_opc_incidentes" id="incidentes">
                                                <div class="col-sm-12">
                                                    <div class="table-overflow-x">
                                                        <table class="table" style="width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <?php if($row_permisos['crea_bita'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ins_bitacora" class="ins_bitacora">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_agregar_conocimiento panel-body tooltips" data-id="agregar_bitacora" data-toggle="tooltip" data-placement="bottom" title="Agregar Bitacora">
                                                                                    <i class="fa fa-plus text-primary" style="font-size: 68px;color: #1b9cdd;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <center><a class="btn-u btn-u-blue rounded regresar_opciones_plataforma" data-id="incidentes" style="color:#FFFFFF"><i class="fa fa-angle-double-left"></i> Regresar a las opciones generales</a></center>
                                                </div>
                                            </li>
                                            <li class="col-sm-12 dropdown-header text-center sub_opciones_plataforma sub_opc_rd" id="rd">
                                                <div class="col-sm-12">
                                                    <div class="table-overflow-x">
                                                        <table class="table" style="width: 100%">
                                                            <tbody>
                                                                <tr>
                                                                    <?php if($row_permisos['gest_seg_casos'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" class="gest_seguimiento_casos">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_gest_seguimiento panel-body tooltips" data-id="gest_seguimiento" data-toggle="tooltip" data-placement="bottom" title="Gestionar Seguimiento de Casos">
                                                                                    <i class="icon-finance-030 text-primary" style="font-size: 68px;color: #00932A;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['add_ma_resp'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ins_responsable" class="ins_matriz_responsables">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_agregar_ma_responsable panel-body tooltips" data-id="agregar_ma_responsable" data-toggle="tooltip" data-placement="bottom" title="Agregar Matriz de Responsables">
                                                                                    <i class="icon-finance-214 text-primary" style="font-size: 68px;color: #008591;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['add_ma_jobs'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ins_jobs" class="ins_matriz_jobs">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_agregar_ma_jobs panel-body tooltips" data-id="agregar_ma_jobs" data-toggle="tooltip" data-placement="bottom" title="Agregar Matriz de Jobs">
                                                                                    <i class="icon-finance-214 text-primary" style="font-size: 68px;color: #007FFF;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['edit_dir_spee'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_edit_ruta_speech" class="edit_ruta_speech">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_editar_rut_speech panel-body tooltips" data-id="editar_rut_speech" data-toggle="tooltip" data-placement="bottom" title="Editar Ruta de Speech">
                                                                                    <i class="icon-note text-primary" style="font-size: 68px;color: #5B4CFF;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['edit_dir_tur'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_edit_ruta_turnos" class="edit_ruta_turnos">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_editar_rut_turnos panel-body tooltips" data-id="editar_rut_turnos" data-toggle="tooltip" data-placement="bottom" title="Editar Ruta de Turnos Analistas Claro">
                                                                                    <i class="icon-note text-primary" style="font-size: 68px;color: #9C56FF;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                    <?php if($row_permisos['edit_dir_cac'] == "true"){ ?>
                                                                    <td>
                                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_edit_ruta_horarios" class="edit_ruta_horarios">
                                                                            <div class="panel panel-default" style="border-color: transparent !important;background: transparent none repeat scroll 0% 0%;">
                                                                                <div class="opciones_plataforma ef_editar_rut_horarios panel-body tooltips" data-id="editar_rut_horarios" data-toggle="tooltip" data-placement="bottom" title="Editar Ruta Horarios y Responsables">
                                                                                    <i class="icon-note text-primary" style="font-size: 68px;color: #7D56FF;"></i> 
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                    <?php } ?>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <center><a class="btn-u btn-u-blue rounded regresar_opciones_plataforma" data-id="rd" style="color:#FFFFFF"><i class="fa fa-angle-double-left"></i> Regresar a las opciones generales</a></center>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if($row_access['bloqueo_examen'] == 0){?>
                        <li class="divider"></li>
                        <li class="dropdown-short">
                            <a data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle" aria-expanded="true">
                                <i class="fa fa-stack-overflow"></i> <span class="hidden-sm">KDB Borrador</span><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" style="background: transparent url('assets/images/patterns/15.png') repeat scroll 0% 0%;">
                                <li>
                                    <a data-toggle="modal" data-target="#modal_ins_borrador" class="ins_borrador" href="javascript:void(0);">
                                        <i class="fa fa-plus"></i> Agregar Borrador
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a class="ver_borradores" href="javascript:void(0);">
                                        <i class="fa fa-stack-overflow"></i> Mis borradores
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right dropdown-onhover no-fix">
                        <li class="divider"></li>
                        <li class="dropdown-short">
                            <a data-toggle="dropdown" id="prueba_mouse" class="dropdown-toggle ver_pid" href="javascript:void(0);" aria-expanded="true">
                                <i class="fa fa-archive"></i> <span class="hidden-sm">KDB</span> <span class="badge rounded-2x badge-blue contador_comentarios dropdown-toggle" style="margin-top: -3px;">0</span>
                            </a>
                            <ul class="dropdown-menu lista_comentarios" style="background: transparent url('assets/images/patterns/15.png') repeat scroll 0% 0%;">
                                <li>
                                    <a style="cursor: pointer;font-size: 12px">
                                        <i class="fa fa-spin fa-spinner"></i> <b>Cargando...</b>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php if($row_access['tipo_user'] == '0'){ ?>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0);" class="ver_bitacora" aria-expanded="true">
                                <i class="fa fa-life-ring"></i> <span class="hidden-sm">BITÁCORAS</span>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if($row_access['tipo_user'] == '0'){ ?>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:void(0);" class="ver_nas" aria-expanded="true">
                                <i class="fa fa-folder-open"></i> <span class="hidden-sm">RD</span>
                            </a>
                        </li>
                        <?php }} ?>
                        <li class="divider"></li>
                        <li class="dropdown-grid">
                            <a data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle"><i class="fa fa-user"></i>&nbsp;<span class="hidden-sm"><?= $row_access['claro_user'] ?></span><span class="caret"></span></a>
                            <div class="dropdown-grid-wrapper" role="menu">
                                <ul class="dropdown-menu" style="background: transparent url('assets/images/patterns/15.png') repeat scroll 0% 0%;">
                                    <li>
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="item active">
                                                        <?php 
                                                            if($row_access['img_user'] == NULL || $row_access['img_user'] == ""){
                                                                $src = "assets/images/avatar_default.jpg";
                                                            }else{
                                                                $src = $row_access['img_user'];
                                                            }
                                                        ?>
                                                        <div class="cuerpo_avatar_menu"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7" style="border-left: 1px solid #555;">
                                                    <ol class="carousel-indicators navbar-carousel-indicators">
                                                        <?php if($row_access['bloqueo_examen'] == 0){?>
                                                        <li>
                                                            <a class="ver_perfil" href="javascript:void(0);"><i class="fa fa-code-fork"></i> Editar Perfil</a>
                                                        </li>
                                                        <?php } ?>
                                                        <?php if($row_access['funcion_user'] == 6 || $row_access['funcion_user'] == 7){ echo ""; }else{ ?>
                                                        <li>
                                                            <a href="examen"><i class="fa fa-wpforms"></i> KDB Examen</a>
                                                        </li>
                                                        <?php } ?>
                                                        <?php if($row_access['bloqueo_examen'] == 0){?>
                                                        <li>
                                                            <a href="javascript:void(0);" id="pid_logout"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                                                        </li>
                                                        <?php } ?>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- end MegaNavbar-->

        <!--=== Content ===-->
        <?php if($row_access['bloqueo_examen'] == 0){ ?>
            <div class="cuerpo_pid" hidden>
                <div class="container content-md">
                    <div class="row">
                        <div class="cssload-container">
                            <div class="cssload-lt"></div>
                            <div class="cssload-rt"></div>
                            <div class="cssload-lb"></div>
                            <div class="cssload-rb"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tabla_plataforma"></div>
        <?php }else{ ?>
            <div class="container content-md">
                <div class="row">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tienes un Examen Pendiente - Ir hacia el examen <a href="examen"><b>Aqui</b></a></h3>
                        </div>
                        <div class="panel-body text-center">
                          Cuentas con un examen pendiente, por el cual la plataforma se encontrara bloqueada hasta entonces.
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--=== End Content ===-->
        
        <!-- Modal Insertar Conocimiento -->
        <div id="modal_ins_conocimiento" class="modal fade"data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-lg">
            <div class="ins_conocimiento_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Categoria -->
        <div id="modal_ins_categoria" class="modal fade" role="dialog" style="z-index: 1800">
          <div class="modal-dialog modal-sm">
            <div class="ins_categoria_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Aplicativo -->
        <div id="modal_ins_aplicativo" class="modal fade" role="dialog" style="z-index: 1800">
          <div class="modal-dialog modal-sm">
            <div class="ins_aplicativo_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Grupo Asignado -->
        <div id="modal_ins_grupo_asignado" class="modal fade" role="dialog" style="z-index: 1800">
          <div class="modal-dialog modal-sm">
            <div class="ins_grupo_asignado_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Usuario Resolutor -->
        <div id="modal_ins_resolutor" class="modal fade" role="dialog" style="z-index: 1800">
          <div class="modal-dialog modal-sm">
            <div class="ins_resolutor_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Bitacora -->
        <div id="modal_ins_bitacora" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-lg">
            <div class="ins_bitacora_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Borrador -->
        <div id="modal_ins_borrador" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_borrador_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Usuario -->
        <div id="modal_ins_usuario" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_usuario_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Examen -->
        <div id="modal_ins_examen" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_examen_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Encuesta -->
        <div id="modal_ins_encuesta" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_encuesta_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Responsable -->
        <div id="modal_ins_responsable" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_responsable_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Jobs -->
        <div id="modal_ins_jobs" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_jobs_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Seguimiento -->
        <div id="modal_ins_seguimiento" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_seguimiento_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Comunicado -->
        <div id="modal_ins_comunicado" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_comunicado_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar pregunta -->
        <div id="modal_ins_pregunta" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_pregunta_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar encuesta pregunta -->
        <div id="modal_ins_enc_pregunta" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_enc_pregunta_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar encuesta pregunta -->
        <div id="modal_edit_enc_pregunta" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_enc_pregunta_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar encuesta opciones -->
        <div id="modal_edit_enc_opciones" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_enc_opciones_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar encuesta pregunta -->
        <div id="modal_ins_enc_opciones" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_enc_opciones_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Encuestas -->
        <div id="modal_ins_encuestas" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_encuestas_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar preguntas encuestas -->
        <div id="modal_ins_pregunta_encuestas" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_pregunta_encuestas_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Asignado -->
        <div id="modal_ins_asignado" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_asignado_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Noticias -->
        <div id="modal_ins_portal_noticia" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_noticias_portal_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Conocimiento -->
        <div id="modal_ver_conocimiento" class="modal fade" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-lg-fix">
            <div class="view_conocimiento_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Conocimiento en Gráfico -->
        <div id="modal_ver_conocimiento_grafico" class="modal fade" tabindex="-1" role="dialog" style="z-index: 1800">
          <div class="modal-dialog modal-lg">
            <div class="view_conocimiento_grafico_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Comunicado -->
        <div id="modal_ver_comunicado" class="modal fade" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="view_comunicado_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Borrador -->
        <div id="modal_ver_borrador" class="modal fade" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="view_borrador_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Bitacora -->
        <div id="modal_ver_bitacora" class="modal fade" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="view_bitacora_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Gráfico Casos -->
        <div id="modal_ver_grafico_casos" class="modal fade" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-xl">
            <div class="view_grafico_casos_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Gráfico Encuesta -->
        <div id="modal_grafico_encuesta" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-xl">
            <div class="view_grafico_encuesta_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Noticia Portal -->
        <div id="modal_ver_noticia_portal" class="modal fade" tabindex="-1" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="view_noticia_portal_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Conocimiento -->
        <div id="modal_edit_conocimiento" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_conocimiento_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Responsable -->
        <div id="modal_edit_responsable" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_responsable_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Jobs -->
        <div id="modal_edit_jobs" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_jobs_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Borrador -->
        <div id="modal_edit_borrador" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-lg">
            <div class="edit_borrador_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Borrador User -->
        <div id="modal_edit_borrador_user" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_borradoruser_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Bitacora -->
        <div id="modal_edit_bitacora" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-lg">
            <div class="edit_bitacora_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Fecha Bitacora -->
        <div id="modal_edit_fecha_bitacora" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-lg">
            <div class="edit_fecha_bitacora_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Usuarios -->
        <div id="modal_edit_usuario" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_usuario_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Categoria -->
        <div id="modal_edit_categoria" class="modal fade" role="dialog" style=""> 
          <div class="modal-dialog modal-sm">
            <div class="edit_categoria_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Aplicativo -->
        <div id="modal_edit_aplicativo" class="modal fade" role="dialog" style=""> 
          <div class="modal-dialog modal-sm">
            <div class="edit_aplicativo_body">
            </div>
          </div>
        </div>

         <!-- Modal Editar Aplicativo -->
        <div id="modal_edit_grupo" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-sm">
            <div class="edit_grupo_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Usuario Resolutor -->
        <div id="modal_edit_resolutor" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-sm">
            <div class="edit_resolutor_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Contraseña -->
        <div id="modal_edit_password" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-sm">
            <div class="edit_password_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Examen -->
        <div id="modal_edit_examen" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_examen_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Encuesta -->
        <div id="modal_edit_encuesta" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_encuesta_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Pregunta -->
        <div id="modal_edit_pregunta" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_pregunta_body">
            </div>
          </div>
        </div>

        <!-- Modal Estadistica Pregunta -->
        <div id="modal_grafico_preguntas" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="grafico_pregunta_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Asignado -->
        <div id="modal_edit_asignado" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_asignado_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Comunicado -->
        <div id="modal_edit_comunicado" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_comunicado_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Ruta Speech -->
        <div id="modal_edit_ruta_speech" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_ruta_speech_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Ruta Turnos -->
        <div id="modal_edit_ruta_turnos" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_ruta_turnos_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Ruta Horarios -->
        <div id="modal_edit_ruta_horarios" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_ruta_horarios_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Perfil -->
        <div id="modal_edit_perfil" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_perfil_body">
            </div>
          </div>
        </div>

        <!-- Modal Editar Noticias -->
        <div id="modal_edit_portal_noticia" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="edit_noticias_portal_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Grafica -->
        <div id="modal_view_grafica" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-xl">
            <div class="view_grafica_body">
            </div>
          </div>
        </div>

        <!-- Modal Insertar Observación -->
        <div id="modal_view_observacion" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-xl">
            <div class="view_observacion_body">
            </div>
          </div>
        </div>

        <!-- Modal Eliminar Borrador -->
        <div id="modal_view_elim_borrador" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1600">
          <div class="modal-dialog modal-xl">
            <div class="view_elim_borrador_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Grafica Gestor -->
        <div id="modal_view_grafica_gestor" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-xl">
            <div class="view_grafica_gestor_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Grafica Gestor Preguntas -->
        <div id="modal_view_grafica_pregunta_gestor" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-xl">
            <div class="view_grafica_pregunta_gestor_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Grafica Seguimiento Gestion -->
        <div id="modal_grafico_seguimiento" class="modal fade" role="dialog" style="">
          <div class="modal-dialog modal-xl">
            <div class="view_grafico_seguimiento">
            </div>
          </div>
        </div>

        <div class="modal fade" id="idle-timeout-dialog" data-backdrop="static" style="top: calc(50% - 150px) ! important;z-index: 2000">
            <div class="modal-dialog modal-lg" style="max-width: 455px">
                <div class="modal-content" style="border: 0px solid transparent;">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title">El tiempo de sesión ha expirado</h3>
                        </div>
                        <div class="panel-body text-center">
                            <span><i class="fa fa-warning text-danger"></i> Se cerrara la sesión en :</span>
                            <span id="idle-timeout-counter"></span> segundos.
                            <span> Quieres continuar conectado? </span>
                        </div>
                        <div class="panel-footer">
                            <button id="idle-timeout-dialog-logout" type="button" class="btn btn-danger"><i class="fa fa-sign-out"></i> Cerrar Sesión</button>
                            <button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-sign-in"></i> Seguir Conectado</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--=== Footer Version 1 ===-->
        <div class="footer-v1">
            <div class="copyright">
                <div class="container">
                    <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <?= date("Y") ?> &copy; Todos los Derechos Reservados.
                                </p>
                            </div>

                            <!-- Social Links -->
                            <div class="col-md-6">
                                <ul class="footer-socials list-inline">
                                    <li>
                                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Plataforma PID">
                                            <i class="fa fa-codepen"></i> PID 4.0
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Social Links -->
                    </div>
                </div>
            </div><!--/copyright-->
        </div>
        <!--=== End Footer Version 1 ===-->
    </div><!--/wrapper-->

    <!--=== Style Switcher ===-->
    <!-- <i class="style-switcher-btn fa fa-cogs hidden-xs"></i> -->
    <!-- <div class="style-switcher animated fadeInRight">
        <div class="style-swticher-header">
            <div class="style-switcher-heading">Opciones de Tema</div>
            <div class="theme-close"><i class="icon-close"></i></div>
        </div>

        <div class="style-swticher-body"> -->
            <!-- Theme Colors
            <div class="style-switcher-heading">Cambiar Colores</div>
            <ul class="list-unstyled">
                <li class="theme-default theme-active" data-style="default" data-header="light"></li>
                <li class="theme-blue" data-style="blue" data-header="light"></li>
                <li class="theme-orange" data-style="orange" data-header="light"></li>
                <li class="theme-red" data-style="red" data-header="light"></li>
                <li class="theme-light" data-style="light" data-header="light"></li>
                <li class="theme-purple last" data-style="purple" data-header="light"></li>
                <li class="theme-aqua" data-style="aqua" data-header="light"></li>
                <li class="theme-brown" data-style="brown" data-header="light"></li>
                <li class="theme-dark-blue" data-style="dark-blue" data-header="light"></li>
                <li class="theme-light-green" data-style="light-green" data-header="light"></li>
                <li class="theme-dark-red" data-style="dark-red" data-header="light"></li>
                <li class="theme-teal last" data-style="teal" data-header="light"></li>
            </ul> -->

            <!-- Theme Skins
            <div class="style-switcher-heading">Ambiente</div>
            <div class="row no-col-space margin-bottom-20 skins-section">
                <div class="col-xs-6">
                    <button data-skins="default" class="btn-u btn-u-xs btn-u-dark btn-block active-switcher-btn handle-skins-btn">Claro</button>
                </div>
                <div class="col-xs-6">
                    <button data-skins="dark" class="btn-u btn-u-xs btn-u-dark btn-block skins-btn">Oscuro</button>
                </div>
            </div>

            <hr> -->

            <!-- Layout Styles 
            <div class="style-switcher-heading">Estilo de Tema</div>
            <div class="row no-col-space margin-bottom-20">
                <div class="col-xs-6">
                    <a href="javascript:void(0);" class="btn-u btn-u-xs btn-u-dark btn-block active-switcher-btn wide-layout-btn">Wide</a>
                </div>
                <div class="col-xs-6">
                    <a href="javascript:void(0);" class="btn-u btn-u-xs btn-u-dark btn-block boxed-layout-btn">Boxed</a>
                </div>
            </div>
            -->

            <!-- <hr> -->

            <!-- Theme Type
            <div class="style-switcher-heading">Theme Types and Versions</div>
            <div class="row no-col-space margin-bottom-10">
                <div class="col-xs-6">
                    <a href="E-Commerce/index.html" class="btn-u btn-u-xs btn-u-dark btn-block">Shop UI <small class="dp-block">Template</small></a>
                </div>
                <div class="col-xs-6">
                    <a href="One-Pages/Classic/index.html" class="btn-u btn-u-xs btn-u-dark btn-block">One Page <small class="dp-block">Template</small></a>
                </div>
            </div>

            <div class="row no-col-space">
                <div class="col-xs-6">
                    <a href="Blog-Magazine/index.html" class="btn-u btn-u-xs btn-u-dark btn-block">Blog <small class="dp-block">Template</small></a>
                </div>
                <div class="col-xs-6">
                    <a href="RTL/index.html" class="btn-u btn-u-xs btn-u-dark btn-block">RTL <small class="dp-block">Version</small></a>
                </div>
            </div>
        </div>
    </div>
            -->
    <!--=== End Style Switcher ===-->


    <!-- JS Global Compulsory -->
    <script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS Implementing Plugins -->
    <script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
    <script type="text/javascript" src="assets/plugins/smoothScroll.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery.parallax.js"></script>
    <script type="text/javascript" src="assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="assets/plugins/layer-slider/layerslider/js/greensock.js"></script>
    <script type="text/javascript" src="assets/plugins/backstretch/jquery.backstretch.min.js"></script>
    <script type="text/javascript" src="assets/plugins/layer-slider/layerslider/js/layerslider.transitions.js"></script>
    <script type="text/javascript" src="assets/plugins/layer-slider/layerslider/js/layerslider.kreaturamedia.jquery.js"></script>
    <!-- JS Page Level -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/plugins/owl-carousel.js"></script>
    <script src="assets/js/plugins/layer-slider.js"></script>
    <script src="assets/js/plugins/style-switcher.js"></script>
    <!-- JS Customization -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pid_plataforma.js?v=<?= date("His") ?>"></script>
    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="assets/js/tinymce/tinymce.min.js"></script>
    <script src="assets/js/tinymce/jquery.tinymce.min.js"></script>
    <script src="assets/js/plugins/pid/js/jquery.placeholder.min.js"></script>
    <script src="assets/js/plugins/pid/js/timer.jquery.js"></script>
    <script src="assets/js/plugins/pid/js/bootstrap-select.js"></script>
    <script src="assets/js/plugins/pid/js/moment.min.js"></script>
    <script src="assets/js/plugins/pid/js/daterangepicker.js"></script>
    <script src="assets/js/plugins/pid/js/DateTimePicker.js"></script>
    <script src="assets/js/plugins/pid/js/DateTimePicker-i18n-es.js"></script>
    <script src="assets/js/plugins/pid/js/bootstrap-switch.js"></script>
    <script src="assets/js/plugins/pid/js/jquery.idletimer.js"></script>
    <script src="assets/js/plugins/pid/js/jquery.idletimeout.js"></script>
    <script src="assets/js/plugins/pid/js/bootcards.js"></script>
    <script src="assets/js/highcharts/highcharts.js"></script>
    <script src="assets/js/highcharts/highcharts-3d.js"></script>
    <script src="assets/js/highcharts/modules/exporting.js"></script>
    <script src="assets/js/highcharts/modules/offline-exporting.js"></script>
    <script src="assets/js/highcharts/themes/grid-light.js"></script>
    <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/js/currency.js"></script>
    <script src="assets/plugins/datatables/js/buttons.colVis.min.js"></script>
    <script src="assets/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="assets/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/js/jszip.min.js"></script>
    <script src="assets/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/js/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/js/date-uk.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.select.min.js"></script>
    <script src="assets/plugins/datatables/js/full_numbers_no_ellipses.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.scroller.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js"></script>
    <script src="assets/plugins/slimScroll/jquery.slimscroll.js"></script>
    <script src="assets/plugins/mfancytitle/jquery.mfancytitle-0.4.1.min.js"></script>
    <script src="assets/plugins/validatejs/jquery.validate.js"></script>
    <script src="assets/plugins/validatejs/additional-methods.js"></script>
    <script src="assets/plugins/jpaginate/jQuery.paginate.js"></script>
    <script src="assets/plugins/html2canvas/html2canvas.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            App.init();
            App.initParallaxBg();
            setInterval('digiClock()', 1000);
            StyleSwitcher.initStyleSwitcher();
            <?php if(date("m") == 12 || date("m") == 11){ ?>
            $('div.mega-menu').backstretch([
                'assets/images/bg/diciembre/bg_diciembre_1.jpg',
                'assets/images/bg/diciembre/bg_diciembre_2.jpg',
                'assets/images/bg/diciembre/bg_diciembre_3.jpg',
                'assets/images/bg/diciembre/bg_diciembre_4.jpg',
                'assets/images/bg/diciembre/bg_diciembre_5.jpg'
                ], {
                    fade: 4000,
                    duration: 4000
            }).on("backstretch.show", function () { 
                $(document.body).css('padding-right','');
            });
            <?php }else{ ?>
            $('div.mega-menu').backstretch([
                "assets/images/bg/pid_bg_5.jpg",
                "assets/images/bg/pid_bg_6.jpg",
                "assets/images/bg/pid_bg_7.jpg",
                "assets/images/bg/pid_bg_8.jpg",
                "assets/images/bg/pid_bg_10.jpg",
                "assets/images/bg/pid_bg_11.jpg",
                "assets/images/bg/pid_bg_12.jpg"
                ], {
                    fade: 4000,
                    duration: 4000
            }).on("backstretch.show", function () { 
                $(document.body).css('padding-right','');
            });
            <?php } ?>
        });
    </script>
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
    <![endif]-->
    <?php if($row_access['funcion_user'] == 0 || $row_access['funcion_user'] == 6 || $row_access['funcion_user'] == 7) {?>
        <script>
            $(document).ready(function(){
                UIIdleTimeout.init();     
                /* Funcion para el cerrado de la venta */
                $('#idle-timeout-dialog').on('hidden.bs.modal', function () {
                    $(document.body).addClass('modal-open');
                });
                /* Fin Funcion para el cierre de la ventana de expiracion */
            });
        </script>
    <?php } ?>
    <?php if($row_access['funcion_user'] == 9 || $row_access['funcion_user'] == 8) {?>
        <script>
            $(document).ready(function(){
                UIIdleTimeout_escalado.init();
                /* Funcion para el cerrado de la venta */
                $('#idle-timeout-dialog').on('hidden.bs.modal', function () {
                    $(document.body).addClass('modal-open');
                });
                /* Fin Funcion para el cierre de la ventana de expiracion */
            });
        </script>
    <?php } ?>
    <?php if($row_access['funcion_user'] == 6 || $row_access['funcion_user'] == 7){ ?>
        <script>
            $(document).bind('copy', function(e){
                e.preventDefault();
            });
            $(document).bind('paste', function(e){
                e.preventDefault();
            });
            $(document).bind('cut', function(e){
                e.preventDefault();
            });
            $(document).bind('contextmenu', function(e){
                e.preventDefault();
            });
        </script>
    <?php } ?>
</body>
</html>
