<?php
    session_start();
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_auth();
    $object_colaboracion = new pid_perfil_usuario();
    $result = $object->user_auth($id_user);
    $result_colaboracion = $object_colaboracion->colaboracion_plataforma($id_user);
    $row_profile = $result->fetch_assoc();
    $row_colaboracion = $result_colaboracion->fetch_assoc();
    
    if($row_profile['funcion_user'] == "0"){
        $funcion_user = "<t class='label label-primary'>Analista</t>";
    }else if($row_profile['funcion_user'] == "1"){
        $funcion_user = "<t class='label label-default' style='background-color:green'>G.Correo</t>";
    }else if($row_profile['funcion_user'] == "2"){
        $funcion_user = "<t class='label label-success'>G.Conocimiento</t>";
    }else if($row_profile['funcion_user'] == "4"){
        $funcion_user = "<t class='label label-danger'>Administrador</t>";
    }else if($row_profile['funcion_user'] == "8"){
        $funcion_user = "<t class='label label-info'>Apoyo PID</t>";
    }else if($row_profile['funcion_user'] == "9"){
        $funcion_user = "<t class='label label-info'>Escalado</t>";
    }else if($row_profile['funcion_user'] == "6"){
        $funcion_user = "<t class='label label-default' style='background-color:lemon'>Cl.Proyecto</t>";
    }else if($row_profile['funcion_user'] == "7"){
        $funcion_user = "<t class='label label-default' style='background-color:lemon'>Apoyo Cl.Pro.</t>";
    }else if($row_profile['funcion_user'] == "5"){
        $funcion_user = "<t class='label label-default' style='background-color:black'>Desarrollador</t>";
    }
    
?>
<div class="container content-md">
    <div class="row">
        <div class="perfil_usuario">
            <div class="col-md-3">
                <div class="center-block">
                    <div class="cuerpo_avatar"></div>
                    <div class="panel panel-primary bootcards-table" style="display: block;">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Menu de Usuario</h3>							
                        </div>	
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td style="cursor: pointer" data-toggle="modal" data-target="#modal_edit_perfil" data-user-id="<?= $row_profile['id_user'] ?>" colspan="2" class="edit_perfil text-center"><i class="fa fa-edit"></i> Editar Informacion Personal</td>
                                </tr>
                                <tr>
                                    <td style="cursor: pointer" data-toggle="modal" data-target="#modal_edit_password" data-user-id="<?= $row_profile['id_user'] ?>" colspan="2" class="edit_password text-center"><i class="fa fa-key"></i> Editar Contraseña</td>
                                </tr>
                                <tr>
                                    <td style="cursor: pointer" colspan="2" class="actualizar_paneles_perfil text-center"><i class="fa fa-refresh"></i> Actualizar todos los paneles</td>
                                </tr>
                            </tbody>
                        </table>												
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="cuerpo_nombre_completo"></div>
                <t style="font-size: 140%;"><?= $funcion_user ?></t>
                <br><br>
                <div class="panel panel-primary bootcards-table" style="display: block;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informacion Personal <a class="actualizar_info_personal pull-right" style="cursor: pointer"><i class="fa fa-refresh"></i></a></h3>
                    </div>
                    <div class="cuerpo_info_personal"></div>
                </div>
            </div>
            <div class="col-md-4">
                <h1></h1>
                <t style="font-size: 140%;"></t>
                <br><br>
                <br><br>
                <div class="panel panel-primary bootcards-table" style="display: block;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informacion de Contacto <a class="actualizar_info_contacto pull-right" style="cursor: pointer"><i class="fa fa-refresh"></i></a></h3>							
                    </div>
                    <div class="cuerpo_info_contacto"></div>
                </div>
                <div class="panel panel-primary bootcards-table" style="display: block;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Colaboracion con Plataforma <a class="actualizar_colaboracion pull-right" style="cursor: pointer"><i class="fa fa-refresh"></i></a></h3>							
                    </div>
                    <div class="cuerpo_colaboracion"></div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-sm-3">
                    <ul class="list-group">
                        <li class="list-group-item text-muted">
                            Profile
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Joined</strong>
                            </span> 2.13.2014
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Last seen</strong>
                            </span> Yesterday
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Real name</strong>
                            </span> Joseph Doe
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Role: </strong>
                            </span> Pet Sitter
                        </li>
                    </ul>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Insured / Bonded?
                        </div>
                        <div class="panel-body">
                            <i style="color:green" class="fa fa-check-square"></i> 
                            Yes, I am insured and bonded.
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Website <i class="fa fa-link fa-1x"></i>
                        </div>
                        <div class="panel-body">
                            <a href="http://bootply.com" class="">bootply.com</a>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item text-muted">
                            Activity <i class="fa fa-dashboard fa-1x"></i>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Shares</strong>
                            </span> 125
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Likes</strong>
                            </span> 13
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Posts</strong>
                            </span> 37
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Followers</strong>
                            </span> 78
                        </li>
                    </ul>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Social Media
                        </div>
                        <div class="panel-body">	
                            <i class="fa fa-facebook fa-2x"></i>
                            <i class="fa fa-github fa-2x"></i>
                            <i class="fa fa-twitter fa-2x"></i>
                            <i class="fa fa-pinterest fa-2x"></i>
                            <i class="fa fa-google-plus fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Starfox221's Bio
                        </div>
                        <div class="panel-body"> 
                            A long description about me.
                        </div>
                    </div>
                    <div class="panel panel-default target">
                        <div class="panel-heading">
                            Pets I Own
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <img alt="300x200" src="http://lorempixel.com/600/200/people">
                                        <div class="caption">
                                                <h3>Rover</h3>
                                                <p>Cocker Spaniel who loves treats.</p>
                                                <p></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <img alt="300x200" src="http://lorempixel.com/600/200/city">
                                        <div class="caption">
                                                <h3>Marmaduke</h3>
                                                <p>Is just another friendly dog.</p>
                                                <p></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="thumbnail">
                                        <img alt="300x200" src="http://lorempixel.com/600/200/sports">
                                        <div class="caption">
                                                <h3>Rocky</h3>
                                                <p>Loves catnip and naps. Not fond of children.</p>
                                                <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Starfox221's Bio
                        </div>
                        <div class="panel-body"> 
                            A long description about me.
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <script>
            $('.cuerpo_avatar').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_avatar.php",function(){}).hide().fadeIn("blind");
            $('.cuerpo_nombre_completo').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_nombre_completo.php",function(){}).hide().fadeIn("blind");
            $('.cuerpo_info_personal').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_personal.php",function(){}).hide().fadeIn("blind");
            $('.cuerpo_info_contacto').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_contacto.php",function(){}).hide().fadeIn("blind");
            $('.cuerpo_colaboracion').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_colaboracion.php",function(){}).hide().fadeIn("blind");

            $('.actualizar_paneles_perfil').click(function() {
                $('.cuerpo_avatar').html("<center><img src='assets/images/loading.gif'><b> Cargando...</b></center><br>");
                $('.cuerpo_nombre_completo').html("<img src='assets/images/loading.gif'><b> Cargando...</b><br>");
                $('.cuerpo_info_personal').html("<table class='table table-hover'><tbody><tr><td><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></td></tr></tbody></table>");
                $('.cuerpo_info_contacto').html("<table class='table table-hover'><tbody><tr><td><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></td></tr></tbody></table>");
                $('.cuerpo_colaboracion').html("<table class='table table-hover'><tbody><tr><td><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></td></tr></tbody></table>");
                setTimeout(function() {
                    $('.cuerpo_avatar').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_avatar.php",function(){}).hide().fadeIn("blind");
                    $('.cuerpo_nombre_completo').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_nombre_completo.php",function(){}).hide().fadeIn("blind");
                    $('.cuerpo_info_personal').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_personal.php",function(){}).hide().fadeIn("blind");
                    $('.cuerpo_info_contacto').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_contacto.php",function(){}).hide().fadeIn("blind");
                    $('.cuerpo_colaboracion').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_colaboracion.php",function(){}).hide().fadeIn("blind");
                },1000);
            });

            $('.actualizar_info_personal').click(function(){
                $('.cuerpo_info_personal').html("<table class='table table-hover'><tbody><tr><td><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></td></tr></tbody></table>");
                setTimeout(function() {
                    $('.cuerpo_info_personal').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_personal.php",function(){}).hide().fadeIn("blind");
                },1000);    
            });

            $('.actualizar_info_contacto').click(function(){
                $('.cuerpo_info_contacto').html("<table class='table table-hover'><tbody><tr><td><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></td></tr></tbody></table>");
                setTimeout(function() {
                    $('.cuerpo_info_contacto').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_contacto.php",function(){}).hide().fadeIn("blind");
                },1000);   
            });

            $('.actualizar_colaboracion').click(function(){
                $('.cuerpo_colaboracion').html("<table class='table table-hover'><tbody><tr><td><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></td></tr></tbody></table>");
                setTimeout(function() {
                    $('.cuerpo_colaboracion').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_colaboracion.php",function(){}).hide().fadeIn("blind");
                },1000);   
            });

            /* Modal Editar Password */
            $('.edit_password').click(function () {
                var id_atu = $(this).data("user-id");
                $.ajax({
                    beforeSend: function(){
                        $('.edit_password_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    cache: false,
                    type: 'GET',
                    url: 'ajax/view_pid/edit/view_edit_password.php',
                    data: 'id=' + id_atu,
                    success:function(data){
                        $('.edit_password_body').html(data);
                    }
                });
            });
            /* Fin Modal Editar Password */

            /* Modal Editar Perfil */
            $('.edit_perfil').click(function () {
                var id_atu = $(this).data("user-id");
                $.ajax({
                    beforeSend: function(){
                        $('.edit_perfil_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    cache: false,
                    type: 'GET',
                    url: 'ajax/view_pid/edit/view_edit_perfil.php',
                    data: 'id=' + id_atu,
                    success:function(data){
                        $('.edit_perfil_body').html(data);
                    }
                });
            });
            /* Fin Modal Editar Perfil */

        </script>
    </div>
</div>