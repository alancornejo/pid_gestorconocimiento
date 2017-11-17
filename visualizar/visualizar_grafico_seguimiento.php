<?php
session_start();
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes_get = $_GET['mes'];
$ano_get = $_GET['ano'];
$mes = date("m");
$ano = date("Y");
if($mes == $mes_get && $ano == $ano_get){
    echo "";
}else{
    header("Location: ".$mes."-".$ano."");
}
/*if($mes_get != $mes && $ano_get != $ano){
    
}*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <title>PID - Claro Aplicaciones de Negocio</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.png">

        <!-- CSS Global Compulsory -->
        <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">

        <!-- CSS Header and Footer -->
        <link rel="stylesheet" href="../assets/css/headers/header-v4-centered.css">
        <link rel="stylesheet" href="../assets/css/footers/footer-v1.css">
        
        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="../assets/plugins/animate.css">
        <link rel="stylesheet" href="../assets/plugins/line-icons/line-icons.css">
        <link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css">
	<link rel="stylesheet" href="../assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css">
        <link rel="stylesheet" href="../assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">

        <!-- CSS Theme -->
        <link rel="stylesheet" href="../assets/css/theme-colors/default.css" id="style_color">
        <link rel="stylesheet" href="../assets/css/theme-colors/blue.css" id="style_color">
        <link rel="stylesheet" href="../assets/css/pages/page_misc_sticky_footer.css">

        <!-- CSS Customization -->
        <link rel="stylesheet" href="../assets/css/custom.css">
        <link rel="stylesheet" href="../assets/plugins/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="../assets/plugins/meganavbar/MegaNavbar.css">
        <link rel="stylesheet" href="../assets/plugins/meganavbar/skins/navbar-default.css">
        <link rel="stylesheet" href="../assets/plugins/meganavbar/animation/animation.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/buttons.dataTables.min.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/fixedColumns.dataTables.min.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/scroller.dataTables.min.css">
        <link rel="stylesheet" href="../assets/plugins/datatables/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="../assets/js/plugins/pid/css/bootstrap-select.css">
        <link rel="stylesheet" href="../assets/js/plugins/pid/css/daterangepicker.css">
        <link rel="stylesheet" href="../assets/js/plugins/pid/css/DateTimePicker.css">
        <link rel="stylesheet" href="../assets/js/plugins/pid/css/select.bootstrap.min.css">
        <link rel="stylesheet" href="../assets/js/plugins/pid/css/bootstrap-switch.css">
        <link rel="stylesheet" href="../assets/js/plugins/pid/css/bootcards-desktop.css">
        <link rel="stylesheet" href="../assets/plugins/flipclock/css/flipclock.css">
        <style>
            .clock{
                zoom: 0.7;
                -moz-transform: scale(0.7);
                margin: 0 auto;
                width: 550px;
                margin-left: -50px;
            }
        </style>
    </head>

    <body>
        <?php
            require_once ('../data/pid_data.php');
            require_once ('../data/pid_access.php');
            $mes_subida = $_GET['mes'];
            if($mes_subida == "1"){
                $id_mes = "Enero";
            }elseif($mes_subida == "2"){
                $id_mes = "Febrero";
            }elseif($mes_subida == "3"){
                $id_mes = "Marzo";
            }elseif($mes_subida == "4"){
                $id_mes = "Abril";
            }elseif($mes_subida == "5"){
                $id_mes = "Mayo";
            }elseif($mes_subida == "6"){
                $id_mes = "Junio";
            }elseif($mes_subida == "7"){
                $id_mes = "Julio";
            }elseif($mes_subida == "8"){
                $id_mes = "Agosto";
            }elseif($mes_subida == "9"){
                $id_mes = "Setiembre";
            }elseif($mes_subida == "10"){
                $id_mes = "Octubre";
            }elseif($mes_subida == "11"){
                $id_mes = "Noviembre";
            }elseif($mes_subida == "12"){
                $id_mes = "Diciembre";
            }
            $object = new seguimiento_casos();
            $mes = $id_mes;
            $ano = $_GET['ano'];
        ?>
        <div class="header-v4" style="background: #1B9CDD">
            <div class="container">
                <!-- Topbar -->
                <div class="topbar-v1" style="background: #1B9CDD;border-top: solid 1px #1B9CDD;border-bottom: solid 1px #1B9CDD;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-inline top-v1-contacts" style="font-size: 15px;">
                                    <li style="color: white">
                                        <i class="fa fa-bar-chart" style="color:#FFF"></i> Gráfico Mensual de <?= $id_mes ?> del <?= $ano ?> 
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-inline top-v1-data" style="font-size: 15px;">
                                    <li style="border-right: solid 1px #1B9CDD;border-left: 1px solid #1B9CDD!important;border-top: 1px solid #1B9CDD!important;color: white">
                                        &nbsp;
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Topbar -->
            </div><!--/end container-->
        </div>
        <div class="wrapper boxed-layout">
            <div class="content">
                <div class="row margin-bottom-90" style="margin-right: 0px;margin-left: 0px;">
                    <div class="col-md-12">
                        <div class="col-md-6 pull-left">
                            <span class="pull-right" style="margin-right: 38px;"><img style="width: 150px" src="../assets/images/pid_plataforma_verano.png"></span>
                            <span class="pull-left">&nbsp;</span>
                        </div>
                        <div class="col-md-6">
                            <input id="moj_cas" value="<?= time(); ?>" hidden>
                            <span class="pull-left"><div class="clock"></div></span>
                            <span class="pull-right">&nbsp;</span>
                        </div>
                    </div>
                    
                    <input class="mes_actual" value="<?= date("m") ?>" hidden>
                    <input class="ano_actual" value="<?= date("Y") ?>" hidden>
                    <div class="center-block">
                        <div class="col-md-6">
                            <div class="panel panel-default bootcards-chart">
                                <div class="panel-heading">
                                    <div class="panel-title pull-left">
                                        <h5 class="titulo_casos_asig"></h5>
                                    </div>
                                    <div class="panel-title pull-right"><img src='../assets/images/loading.gif'></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="load_asigpen"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default bootcards-chart">
                                <div class="panel-heading">
                                    <div class="panel-title pull-left">
                                        <h5 class="titulo_casos_solu"></h5>
                                    </div>
                                    <div class="panel-title pull-right"><img src='../assets/images/loading.gif'></div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="load_solu"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
    
    <!-- JS Global Compulsory -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/jquery/jquery-migrate.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS Implementing Plugins -->
    <script src="../assets/plugins/back-to-top.js"></script>
    <script src="../assets/plugins/smoothScroll.js"></script>
    <script src="../assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
    <script src="../assets/plugins/layer-slider/layerslider/js/greensock.js"></script>
    <script src="../assets/plugins/backstretch/jquery.backstretch.min.js"></script>
    <script src="../assets/plugins/layer-slider/layerslider/js/layerslider.transitions.js"></script>
    <script src="../assets/plugins/layer-slider/layerslider/js/layerslider.kreaturamedia.jquery.js"></script>
    <!-- JS Page Level -->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/plugins/owl-carousel.js"></script>
    <script src="../assets/js/plugins/layer-slider.js"></script>
    <script src="../assets/js/plugins/style-switcher.js"></script>
    <!-- JS Customization -->
    <script src="../assets/js/pid_plataforma.js?v=<?= date("His") ?>"></script>
    <script src="../assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="../assets/js/tinymce/tinymce.min.js"></script>
    <script src="../assets/js/tinymce/jquery.tinymce.min.js"></script>
    <script src="../assets/js/plugins/pid/js/jquery.placeholder.min.js"></script>
    <script src="../assets/js/plugins/pid/js/timer.jquery.js"></script>
    <script src="../assets/js/plugins/pid/js/bootstrap-select.js"></script>
    <script src="../assets/js/plugins/pid/js/moment.min.js"></script>
    <script src="../assets/js/plugins/pid/js/daterangepicker.js"></script>
    <script src="../assets/js/plugins/pid/js/DateTimePicker.js"></script>
    <script src="../assets/js/plugins/pid/js/DateTimePicker-i18n-es.js"></script>
    <script src="../assets/js/plugins/pid/js/bootstrap-switch.js"></script>
    <script src="../assets/js/plugins/pid/js/jquery.idletimer.js"></script>
    <script src="../assets/js/plugins/pid/js/jquery.idletimeout.js"></script>
    <script src="../assets/js/plugins/pid/js/bootcards.js"></script>
    <script src="../assets/js/highcharts/highcharts.js"></script>
    <script src="../assets/js/highcharts/highcharts-3d.js"></script>
    <script src="../assets/js/highcharts/modules/exporting.js"></script>
    <script src="../assets/js/highcharts/modules/offline-exporting.js"></script>
    <script src="../assets/js/highcharts/themes/grid-light.js"></script>
    <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/js/dataTables.bootstrap.min.js"></script>
    <script src="../assets/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables/js/currency.js"></script>
    <script src="../assets/plugins/datatables/js/buttons.colVis.min.js"></script>
    <script src="../assets/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="../assets/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatables/js/jszip.min.js"></script>
    <script src="../assets/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="../assets/plugins/datatables/js/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables/js/date-uk.js"></script>
    <script src="../assets/plugins/datatables/js/dataTables.select.min.js"></script>
    <script src="../assets/plugins/datatables/js/full_numbers_no_ellipses.js"></script>
    <script src="../assets/plugins/datatables/js/dataTables.fixedHeader.min.js"></script>
    <script src="../assets/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="../assets/plugins/datatables/js/dataTables.scroller.min.js"></script>
    <script src="../assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js"></script>
    <script src="../assets/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js"></script>
    <script src="../assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js"></script>
    <script src="../assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js"></script>
    <script src="../assets/plugins/slimScroll/jquery.slimscroll.js"></script>
    <script src="../assets/plugins/mfancytitle/jquery.mfancytitle-0.4.1.min.js"></script>
    <script src="../assets/plugins/flipclock/js/flipclock.js"></script>
    <script type="text/javascript">
        var serverTime = <?= time(); ?>;
        var timeDifference = new Date + serverTime;
        
        var clock = $('.clock').FlipClock(timeDifference,{
            clockFace: 'TwelveHourClock'
	});
        
        $('.titulo_casos_asig').html("<center><img src='../assets/images/loading.gif'><b> Cargando...</b></center>");    
        $('.titulo_casos_solu').html("<center><img src='../assets/images/loading.gif'><b> Cargando...</b></center>");    
        $('.load_asigpen').html("<br><center><img src='../assets/images/loading.gif'><b> Cargando...</b></center><br>");
        $('.load_solu').html("<br><center><img src='../assets/images/loading.gif'><b> Cargando...</b></center><br>");

        setTimeout(function(){
            $('.load_asigpen').load("../ajax/load_php/base_casos/graficos_casos/grafico_casos_asigpen.php?mes=<?= $mes_subida ?>&ano=<?= $ano ?>");
            $('.load_solu').load("../ajax/load_php/base_casos/graficos_casos/grafico_casos_solu.php?mes=<?= $mes_subida ?>&ano=<?= $ano ?>");
        },100);
        
        setInterval(function(){
            $('.load_asigpen').load("../ajax/load_php/base_casos/graficos_casos/grafico_casos_asigpen.php?mes=<?= $mes_subida ?>&ano=<?= $ano ?>");
            $('.load_solu').load("../ajax/load_php/base_casos/graficos_casos/grafico_casos_solu.php?mes=<?= $mes_subida ?>&ano=<?= $ano ?>");
        },3600000);
        
        setInterval(function(){
            location.reload();
        },18000000);
        
    </script>