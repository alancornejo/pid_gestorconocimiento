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

            <!-- Navbar -->
            <div class="navbar navbar-default mega-menu bg-image-v1 parallaxBg" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="javascript:void(0)">
                            <img id="logo-header" class="img-responsive img-width-250" src="assets/images/pid_plataforma.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Navbar -->
        </div>
        <!--=== End Header v4 ===-->

        <!-- begin MegaNavbar-->
        <nav class="navbar navbar-default" id="main_navbar" role="navigation">
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
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="plataforma" class="dropdown-toggle" aria-expanded="true">
                                <i class="fa fa-wpforms"></i> <span class="hidden-sm">Ingresar al PID</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right dropdown-onhover">
                        <li class="dropdown-grid">
                            <a data-toggle="dropdown" href="javascript:void(0);" class="dropdown-toggle"><i class="fa fa-user"></i>&nbsp;<span class="hidden-sm">ANONIMO</span><span class="caret"></span></a>
                            <div class="dropdown-grid-wrapper" role="menu">
                                <ul class="dropdown-menu" style="background: transparent url('assets/images/patterns/15.png') repeat scroll 0% 0%;">
                                    <li>
                                        <div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ol class="carousel-indicators navbar-carousel-indicators">
                                                        <li>
                                                            <a href="plataforma"><i class="fa fa-chevron-left"></i> Ingresar al PID</a>
                                                        </li>
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
        <?php 
        $fecha_actual = strtotime(date("Y-m-d H:i:s"));
        $fecha_inicio = strtotime($row['fecha_inicio']);
        $fecha_termino = strtotime($row['fecha_termino']);
        if($fecha_actual > $fecha_inicio && $fecha_termino > $fecha_actual){ ?>
        <div class="tabla_examen"></div>
        <?php }else{ ?>
        <div class="container content">
            <div class="row margin-bottom-40">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Sin encuestas</h3>
                    </div>
                    <div class="panel-body text-center">
                        <b>No hay ninguna encuesta habilitado por el momento.</b>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br><br>
        <?php } ?>
        <br><br><br><br>
        <!--=== End Content ===-->

        <!-- Modal Dar Encuesta -->
        <div id="modal_dar_encuesta" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">
            <div class="body_dar_encuesta">
            </div>
          </div>
        </div>

        <!--=== Footer Version 1 ===-->
        <div class="footer-v1 sticky-footer">
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
                                    <a href="javascript:void(0)" class="tooltips plataforma_pid" data-toggle="tooltip" data-placement="top" title="" data-original-title="Plataforma PID">
                                        <i class="fa fa-codepen"></i> PID V.3.0
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
    <script type="text/javascript">
        $(document).ready(function() {
            App.init();
            setInterval('digiClock()', 1000);
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

        function dar_encuesta(id){
            $.ajax({
                beforeSend: function(){
                   $('.body_dar_encuesta').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                },
                cache: false,
                type: 'GET',
                url: 'ajax/view_pid/view_encuesta.php',
                data: 'id=' + id,
                success:function(data){
                   $('.body_dar_encuesta').html(data);
                }
            });
        }

    </script>
    <script>
        $(document).ready(function (){
            $(".tabla_examen").load("ajax/load_php/encuesta/tabla_encuesta_user.php");
            $('#modal_ver_conocimiento_grafico').on('hidden.bs.modal', function () {
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