<?php
    require_once ('data/pid_encuesta.php');
    session_start();
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    if(!empty($_SESSION['id_user_apl']))
    {
    header('Location: plataforma');
    }
    $object = new Encuesta();
    $result = $object->verificar_encuesta();
    $row = $result->fetch_assoc();
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
        <link rel="shortcut icon" href="assets/images/favicon.png">

        <!-- CSS Global Compulsory -->
        <link type="text/css" rel="stylesheet" href="/min/index.php?b=assets&amp;f=plugins/bootstrap/css/bootstrap.css,css/style.css,plugins/animate.css,plugins/line-icons/line-icons.css,plugins/font-awesome/css/font-awesome.min.css,css/pages/page_log_reg_v2.css,css/theme-colors/default.css,css/theme-colors/blue.css,css/ingresar.css,css/custom.css,plugins/sweetalert/sweetalert.css" />

    </head>

    <body style="background: transparent none repeat scroll 0% 0%;">
        <div class="contenedor effectBounce">
            <button class="botonF1 abrir">
                <span><img id="draggable3" src="assets/images/boton_login.png" style="width: 55px;height: 55px;margin-top: -9px;"></span>
            </button>
            <button class="botonF1 cerrar" hidden>
                <span><img src="assets/images/boton_login.png" style="width: 55px;height: 55px;margin-top: -9px;"></span>
            </button>
        </div>
        <div class="form_login reg-block fondo_transparente_login" hidden>
            <div id="access_box">
                <div class="access_box_interior" style="background: transparent /*url('assets/images/patterns/15.png')*/;">
                    <div class="login_elements">
                        <form id="login_formulario" method="post">
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario fix_responsive">
                                <img class="logo_web" src="assets/images/pid_plataforma.png">
                            </div>
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario">
                                <span class="input-group-addon" style="background: #F2F2F2 no-repeat scroll right center;"><i class="fa fa-user"></i></span>
                                <input id="username" name="username" type="text" class="form-control" placeholder="Usuario">
                            </div>
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario">
                                <span class="input-group-addon" style="background: #F2F2F2 no-repeat scroll right center;"><i class="fa fa-lock"></i></span>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña">
                            </div>
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group input-group margin-bottom-20 fix_responsive">
                                <input id="login" type="submit" class="btn btn-primary" value="Iniciar Sesión">
                            </div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $fecha_actual = strtotime(date("Y-m-d H:i:s"));
        $fecha_inicio = strtotime($row['fecha_inicio']);
        $fecha_termino = strtotime($row['fecha_termino']);
        if($fecha_actual > $fecha_inicio && $fecha_termino > $fecha_actual){ ?>
        <!-- Modal Encuesta -->
        <div id="modal_encuesta" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="z-index: 9999999">
            <div class="modal-dialog modal-lg">
                <div class="view_conocimiento_grafico_body">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">Se encuentra habilitada una nueva encuesta</h3>
                        </div>
                        <div class="modal-body">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $row['titulo_encuesta'] ?></h3>
                                </div>
                                <div class="panel-body text-center">
                                    Hay una nueva encuesta, habilitada desde el : <b class="text-success"><?= date("d/m/Y H:i a",  strtotime($row['fecha_inicio'])) ?></b> hasta el : <b class="text-danger"><?= date("d/m/Y H:i a",  strtotime($row['fecha_termino'])) ?></b> , para poder acceder a la encuesta favor de dar clic al boton de abajo : <a href="encuesta"><b class="text-primary">Ir a la Encuesta</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <a href="encuesta" class="btn btn-primary">Ir a la Encuesta</a>
                          <a data-dismiss="modal" class="btn btn-default">Cerrar Aviso</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </body>

    <!-- JS Global Compulsory -->
    <script type="text/javascript" src="/min/index.php?b=assets&amp;f=plugins/jquery/jquery.min.js,plugins/jquery/jquery-migrate.min.js,js/plugins/pid/js/jquery-ui.js,plugins/bootstrap/js/bootstrap.min.js,plugins/back-to-top.js,plugins/backstretch/jquery.backstretch.min.js,js/app.js,js/pid_login.js,plugins/sweetalert/sweetalert.min.js,js/plugins/snowfall.jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $(window).load(function(){
                $('#modal_encuesta').modal('show');
            });

            App.init();
            <?php if(date("m") == 12 || date("m") == 11){ ?>
            var images = [
                'assets/images/bg/diciembre/bg_diciembre_1.jpg',
                'assets/images/bg/diciembre/bg_diciembre_2.jpg',
                'assets/images/bg/diciembre/bg_diciembre_3.jpg',
                'assets/images/bg/diciembre/bg_diciembre_4.jpg',
                'assets/images/bg/diciembre/bg_diciembre_5.jpg'
            ];
            <?php }else if(date("m") == 02){ ?>
            var images = [
                'assets/images/bg/febrero/bg_febrero_1.jpg',
                'assets/images/bg/febrero/bg_febrero_2.jpg',
                'assets/images/bg/febrero/bg_febrero_3.jpg',
                'assets/images/bg/febrero/bg_febrero_4.jpg',
                'assets/images/bg/febrero/bg_febrero_5.jpg'
            ];
            <?php }else{ ?>
            var images = [
                'assets/images/bg/pid_bg_1.jpg',
                'assets/images/bg/pid_bg_2.jpg',
                'assets/images/bg/pid_bg_3.jpg',
                'assets/images/bg/pid_bg_4.jpg',
                'assets/images/bg/pid_bg_5.jpg',
                'assets/images/bg/pid_bg_6.jpg',
                'assets/images/bg/pid_bg_7.jpg',
                'assets/images/bg/pid_bg_8.jpg',
                'assets/images/bg/pid_bg_9.jpg',
                'assets/images/bg/pid_bg_10.jpg',
                'assets/images/bg/pid_bg_11.jpg',
                'assets/images/bg/pid_bg_12.jpg',
                'assets/images/bg/pid_bg_13.jpg',
                'assets/images/bg/pid_bg_14.jpg',
                'assets/images/bg/pid_bg_15.jpg',
                'assets/images/bg/pid_bg_16.jpg',
                'assets/images/bg/pid_bg_17.jpg',
                'assets/images/bg/pid_bg_18.jpg',
                'assets/images/bg/pid_bg_19.jpg',
                'assets/images/bg/pid_bg_20.jpg'
            ];
            <?php } ?>

            var index = 0,oldIndex;

            index = Math.floor((Math.random()*images.length));
            $.backstretch(images[index], {
                fade: 1500,
                duration: 8000,
                centeredX: true,
                centeredY: true
            });

            setInterval(function() {
                oldIndex = index;
                 while (oldIndex == index) {
                     index = Math.floor((Math.random()*images.length));
                 }
                 $.backstretch(images[index]);
             }, 8000);

             // A little script for preloading all of the images
             // It"s not necessary, but generally a good idea
             $(images).each(function() {
                 $("<img/>")[0].src = this;
             });

            /*var randomNumber = Math.floor( Math.random() * images.length );

            console.log(images[randomNumber]);

            $.backstretch([
                images[randomNumber]
                ], {
                    fade: 1500,
                    duration: 4000,
                    centeredX: true,
                    centeredY: true
            });*/

            $('button.abrir').click(function(){
                $('div.contenedor').removeClass('effectBounce');
                $('.form_login').fadeIn('fade');
                $('button.abrir').hide();
                $('button.cerrar').show();
            });

            $('button.cerrar').click(function(){
                $('div.contenedor').addClass('effectBounce');
                $('.form_login').fadeOut('fade');
                $('button.cerrar').hide();
                $('button.abrir').show();
            });

        });
        /*$(document).snowfall({
            image :"assets/images/flake.png", minSize: 10, maxSize:32
        });*/
    </script>
    <!--[if lt IE 9]>
        <script src="assets/plugins/respond.js"></script>
        <script src="assets/plugins/html5shiv.js"></script>
        <script src="assets/plugins/placeholder-IE-fixes.js"></script>
    <![endif]-->
</html>