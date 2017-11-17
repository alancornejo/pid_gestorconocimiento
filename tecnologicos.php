<?php
    require_once ('data/pid_encuesta.php');
    session_start();
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
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
        <link type="text/css" rel="stylesheet" href="/min/b=apl/assets&amp;f=plugins/bootstrap/css/bootstrap.css,css/style.css,plugins/animate.css,plugins/line-icons/line-icons.css,plugins/font-awesome/css/font-awesome.min.css,css/pages/page_log_reg_v2.css,css/theme-colors/default.css,css/theme-colors/blue.css,css/ingresar.css,css/custom.css,plugins/sweetalert/sweetalert.css" />
        
    </head>

    <body>
        <div class="form_login reg-block fondo_transparente_login">                      
            <div id="access_box_tec">
                <div class="access_box_interior_tec">
                    <div class="login_elements">
                        <form id="login_formulario" method="post">
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario fix_responsive">
                                <img class="logo_web" src="assets/images/pid_plataforma.png">
                            </div>
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="margin-bottom-20 login_fondo_formulario">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <center>
                                            <span class="text-primary">El KDB ya no se encontrara disponible, ahora sera sustituido por la plataforma PID.</span><br><br>
                                            <span class="text-primary">Muchas Gracias por haber estado con nosotros todo este tiempo<br> <b><h3>ATU Servicios Tecnologicos</h3></b></span>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group input-group margin-bottom-20 login_fondo_formulario">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group input-group margin-bottom-20 fix_responsive">
                                <a href="../apl"><input type="button" class="btn btn-primary" value="Ir al PID"></a>
                            </div>
                        </form>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <!-- JS Global Compulsory -->
    <script type="text/javascript" src="/min/b=apl/assets&amp;f=plugins/jquery/jquery.min.js,plugins/jquery/jquery-migrate.min.js,js/plugins/pid/js/jquery-ui.js,plugins/bootstrap/js/bootstrap.min.js,plugins/back-to-top.js,plugins/backstretch/jquery.backstretch.min.js,js/app.js,js/pid_login.js,plugins/sweetalert/sweetalert.min.js,js/plugins/snowfall.jquery.min.js"></script>

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