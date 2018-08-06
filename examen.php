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
                                <i class="fa fa-wpforms"></i> <span class="hidden-sm">Regresar al Portal</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#modal_ins_pregunta" href="javascript:void(0);" class="dropdown-toggle modal_add_pregunta" aria-expanded="true">
                                <i class="fa fa-question-circle"></i> <span class="hidden-sm">Proponer Preguntas</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right dropdown-onhover">
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
                                                                $src = "http://".$_SERVER['SERVER_NAME'].$row_access['img_user'];  
                                                            }
                                                        ?>
                                                        <img class="img-responsive img-center" style="width: 90px;height: 90px" src="<?= $src ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-7" style="border-left: 1px solid #555;">
                                                    <ol class="carousel-indicators navbar-carousel-indicators">
                                                        <li>
                                                            <a href="plataforma"><i class="fa fa-chevron-left"></i> REGRESAR</a>
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
        <div class="tabla_examen"></div>
        <!--=== End Content ===-->

        <!-- Modal Ver Examen -->
        <div id="modal_view_examen" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">
            <div class="ins_verexamen_body">
            </div>
          </div>
        </div>

        <!-- Modal Ver Grafica -->
        <div id="modal_view_grafica" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="z-index: 1400">
          <div class="modal-dialog modal-xl">
            <div class="view_grafica_body">
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

        <!-- Modal Insertar pregunta -->
        <div id="modal_ins_pregunta" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" style="">
          <div class="modal-dialog modal-lg">
            <div class="ins_pregunta_body">
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
        
        $(document).ready(function (){
            $(".tabla_examen").load("ajax/load_php/examen/tabla_examen_user.php");
            $('#modal_ver_conocimiento_grafico').on('hidden.bs.modal', function () {
                $(document.body).addClass('modal-open');
            });
        });        
        
        /* Modal Insertar Pregunta Examen */
        $('.modal_add_pregunta').click(function () {
            $.ajax({
                beforeSend: function(){
                    $('.ins_pregunta_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                 },
                url: 'ajax/view_pid/insert/view_insertar_propuesta_pre.php',
                success:function(data){
                    $('.ins_pregunta_body').html(data);
                }
            });
        });
        /* Fin Modal Insertar Pregunta Examen */
    </script>
    <!--[if lt IE 9]>
        <script src="assets/plugins/respond.js"></script>
        <script src="assets/plugins/html5shiv.js"></script>
        <script src="assets/plugins/placeholder-IE-fixes.js"></script>
    <![endif]-->
</body>
</html>