<?php
session_start();
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
header('Content-type: text/html; charset=UTF-8');
require_once ('data/pid_access.php');
require_once ('data/pid_data.php');
require_once ('data/pid_encuesta.php');
$ip_user = $_SERVER['REMOTE_ADDR'];
$inicio_sesion = date("Y-m-d H:i:s");
$object = new Encuesta();
$result = $object->verificar_encuesta();
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<title>PID | Claro Aplicaciones de Negocio</title>

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
        <div class="header-v4" style="background: #1B9CDD">
            <!-- Topbar -->
            <div class="topbar-v1" style="background: #1B9CDD;border-top: solid 1px #1B9CDD;border-bottom: solid 1px #1B9CDD;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline top-v1-contacts">
                                <li style="color: white">
                                    <i class="fa fa-user" style="color: white"></i> Bienvenido <b class="cuerpo_nombre_completo_menu"></b>
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

        <!--=== Content ===-->
        <div class="cuerpo_pid" hidden>
            <div class="container content">
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
        <div class="tabla_kdb"></div>

        <!-- Modal Ver Conocimiento -->
        <div id="modal_ver_conocimiento_cliente" class="modal fade" tabindex="-1" role="dialog" style="">
            <div class="modal-dialog modal-lg-fix">
                <div class="view_conocimiento_body">
                </div>
            </div>
        </div>
        <!--=== End Content ===-->

    </div>
    
    <!-- JS Global Compulsory -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/jquery/jquery-migrate.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS Implementing Plugins -->
    <script src="assets/plugins/back-to-top.js"></script>
    <script src="assets/plugins/smoothScroll.js"></script>
    <script src="assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
    <script src="assets/plugins/layer-slider/layerslider/js/greensock.js"></script>
    <script src="assets/plugins/backstretch/jquery.backstretch.min.js"></script>
    <script src="assets/plugins/layer-slider/layerslider/js/layerslider.transitions.js"></script>
    <script src="assets/plugins/layer-slider/layerslider/js/layerslider.kreaturamedia.jquery.js"></script>
    <!-- JS Page Level -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/plugins/owl-carousel.js"></script>
    <script src="assets/js/plugins/layer-slider.js"></script>
    <script src="assets/js/plugins/style-switcher.js"></script>
    <!-- JS Customization -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pid_plataforma_examen.js?v=<?= date("His") ?>"></script>
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
    <script src="assets/plugins/datatables/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/js/dataTables.scroller.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js"></script>
    <script src="assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js"></script>
    <script src="assets/plugins/slimScroll/jquery.slimscroll.js"></script>
    <script src="assets/plugins/mfancytitle/jquery.mfancytitle-0.4.1.min.js"></script>
    <script>
        $(document).ready(function (){
            $(".tabla_kdb").load("ajax/load_php/inicio/tabla_kdb_cliente.php");
            $('#modal_ver_conocimiento_cliente').on('hidden.bs.modal', function () {
                $(document.body).addClass('modal-open');
            });
        });
    </script>
    <!--[if lt IE 9]>
        <script src="assets/plugins/respond.js"></script>
        <script src="assets/plugins/html5shiv.js"></script>
        <script src="assets/plugins/placeholder-IE-fixes.js"></script>
    <![endif]-->
</body>
</html>