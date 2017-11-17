$(document).ready(function () {
    console.log("%c Bienvenido a PID Claro Aplicaciones de Negocio","background:#444;color:#FFF;font-size:12px");

    var interval = null;
    var interval2 = null;
    
    function actualizar_tabla_usuarios() {
        interval = setInterval(function () {
            tabla_usuarios_gestor.ajax.reload( null, false ); 
        },5000);
    }
    
    function actualizar_tabla_asignados() {
        interval2 = setInterval(function () {
            tabla_examenes_asignados.ajax.reload( null, false ); 
        },5000);
    }
    
    function parar_tabla_usuarios() {
        clearInterval(interval);
    }
    
    function parar_tabla_asignados() {
        clearInterval(interval2);
    }

    /* Contador de Comentarios */
    $('.contador_comentarios').load("ajax/load_php/comentarios_pid/contador_comentarios.php");
    
    /* Efectos en las tablas */
    function esconder_todo(){
        $('.tabla_kdb_pid,.tabla_bitacora,.tabla_pid_kdb_borrador_gestor,.tabla_pid_usuarios,.tabla_pid_borrador,.tabla_pid_categorias,.tabla_pid_aplicativos,.tabla_pid_grupo_asignado,.tabla_pid_borrador_gestor,.tabla_pid_borrador,.tabla_pid_registro,.tabla_gestion_examen,.tabla_nas,.tabla_gestor_casos,.perfil_usuario,.cuerpo_pid').hide();
    }
    
    $('.ver_bitacora').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/inicio/tabla_bitacora.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_examen_pid').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/examen/tabla_examen.php");
            });
            actualizar_tabla_asignados();
            parar_tabla_usuarios();
        });
    });
    
    $('.ver_pid').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/inicio/tabla_kdb.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_pid_borrador').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/borrador/tabla_borrador_gestor.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_pid_usuarios').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/usuarios/tabla_usuarios.php");
            });
            actualizar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_borradores').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/borrador/tabla_borrador_user.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_pid_aplicativos').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/aplicativo-grupo/tabla_pid_categorias.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    /*$('.ver_pid_grupo').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/aplicativo-grupo/tabla_pid_grupo.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });*/
    
    $('.tabla_registro').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/registro/tabla_registro.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_nas').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/inicio/tabla_nas.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    $('.ver_perfil').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/perfil_usuario/perfil_usuario.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    });
    
    /* Funcion para lista de comentarios */

    $('a#prueba_mouse').mouseover(function(){
        $('.lista_comentarios').load("ajax/load_php/comentarios_pid/lista_comentarios_kdb.php");
        $('.contador_comentarios').load("ajax/load_php/comentarios_pid/contador_comentarios.php");
    });

    /* Fin Funcion para lista de comentarios */
    
    $('.gest_seguimiento_casos').click(function () {
        esconder_todo();
        $('.cuerpo_pid').fadeIn(function(){
            $('.cuerpo_pid').fadeOut(1000,function (){
                $('.tabla_plataforma').load("ajax/load_php/base_casos/tabla_casos_gestor.php");
            });
            parar_tabla_usuarios();
            parar_tabla_asignados();
        });
    }); 
    
    /* Fin Efectos en las tablas */
    
    /* Modal Insertar Conocimiento */
    $('.ins_conocimiento').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_conocimiento_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/insert/view_insert.php',
            success:function(data){
                $('.ins_conocimiento_body').html(data);
            }
        });
    });
    /* Fin Modal Insertar Conocimiento */
    
    /* Modal Insertar Bitacora */
    $('.ins_bitacora').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_bitacora_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/insert/view_insert_bitacora.php',
            success:function(data){
                $('.ins_bitacora_body').html(data);
            }
        });
    });
    /* Fin Modal Insertar Bitacora */
    
    /* Modal Insertar Borrador */
    $('.ins_borrador').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_borrador_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/insert/view_insert_borrador.php',
            success:function(data){
                $('.ins_borrador_body').html(data);
            }
        });
    });
    /* Fin Modal Insertar Borrador */
    
    /* Desconectarse KDB */
    $("#pid_logout").click(function (){  
        $.ajax({
            url: "ajax/action_class/login/logout_ajax.php",
            success: function(data){
                /*swal({
                     title: "",
                     text: "Te desconectaste con exito, espere un momento...",
                     type: "success",
                     showConfirmButton: false
                 });*/
                /*setTimeout(function (){*/
                 window.location.href = "logout";
                /*},1500);*/
            }
        });
    });
    /* Fin Desconectarse KDB */
    
    /* Modal Editar Ruta Speech */
    $('.edit_ruta_speech').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.edit_ruta_speech_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/edit/view_edit_ruta_speech.php',
            success:function(data){
                $('.edit_ruta_speech_body').html(data);
            }
        });
    });
    /* Fin Modal Editar Ruta Speech */
    
    /* Modal Editar Ruta Turnos */
    $('.edit_ruta_turnos').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.edit_ruta_turnos_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/edit/view_edit_ruta_turnos.php',
            success:function(data){
                $('.edit_ruta_turnos_body').html(data);
            }
        });
    });
    /* Fin Modal Editar Ruta Turnos */
    
    /* Modal Editar Ruta Horarios */
    $('.edit_ruta_horarios').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.edit_ruta_horarios_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/edit/view_edit_ruta_horarios.php',
            success:function(data){
                $('.edit_ruta_horarios_body').html(data);
            }
        });
    });
    /* Fin Modal Editar Ruta Horarios */
    
    /* Funciones para examenes 
    
    setInterval(function () {
       $("#bloqueo_examen").load('ajax/action_class/examen/verificar_bloqueo.php');
    },300000);
    
    setInterval(function () {
        var id = $("#bloqueo_examen").text();
        if (id == 1){
            location.reload();
        }
    },480000);
    
    Fin Funciones para examenes */
    
    /* Modal Insertar Matriz */
    $('.ins_matriz_responsables').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_responsable_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/insert/view_insert_responsable.php',
            success:function(data){
                $('.ins_responsable_body').html(data);
            }
        });
    });
    /* Fin Modal Insertar Matriz */
    
    /* Modal Insertar Matriz Jobs */
    $('.ins_matriz_jobs').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_jobs_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/insert/view_insert_jobs.php',
            success:function(data){
                $('.ins_jobs_body').html(data);
            }
        });
    });
    /* Fin Modal Insertar Matriz Jobs */
    
    /* Modal Insertar Seguimiento Casos */
    $('.ins_seguimiento_casos').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_seguimiento_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
             },
            url: 'ajax/view_pid/insert/view_insert_seguimiento.php',
            success:function(data){
                $('.ins_seguimiento_body').html(data);
            }
        });
    });
    /* Fin Modal Insertar Seguimiento Casos */
    
});

/* Funcion ver conocimiento */
function view_atu(id){
    var atu = id;
    $.ajax({
        beforeSend: function(){
           $('.view_conocimiento_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/view_atu.php',
        data: 'id=' + atu,
        success:function(data){
           $('.view_conocimiento_body').html(data);
        }
    });
}
/* Fin Funcion ver conocimiento */

/* Funcion ver conocimiento en grafico */
function view_atu_grafico(id){
    var atu = id;
    $.ajax({
        beforeSend: function(){
           $('.view_conocimiento_grafico_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/view_atu.php',
        data: 'id=' + atu,
        success:function(data){
           $('.view_conocimiento_grafico_body').html(data);
        }
    });
}
/* Fin Funcion ver conocimiento en grafico */

/* Funcion ver comunicado */
function view_comunicado(id){
    var atu = id;
    $.ajax({
        beforeSend: function(){
           $('.view_comunicado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/view_comunicado.php',
        data: 'id=' + atu,
        success:function(data){
           $('.view_comunicado_body').html(data);
        }
    });
}
/* Fin Funcion ver comunicado */

/* Funcion para ver grafica */
function ver_grafica(id_user,id_identificador){
    var id_us = id_user;
    var id_rs = id_identificador;
    $.ajax({
        beforeSend: function(){
           $('.view_grafica_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/graficos/view_grafica.php',
        data: "id_user="+ id_us + "&id_identificador=" + id_rs,
        success:function(data){
           $('.view_grafica_body').html(data);
        }
    });
}
/* Fin Funcion para ver grafica */

/* Funcion para ver grafica gestor */
function ver_grafico_gestor(id_examen){
    var id_ex = id_examen;
    $.ajax({
        beforeSend: function(){
           $('.view_grafica_gestor_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/graficos/view_grafica_gestor.php',
        data: "id_examen=" + id_ex,
        success:function(data){
           $('.view_grafica_gestor_body').html(data);
        }
    });
}
/* Fin Funcion para ver grafica gestor */

/* Funcion para ver grafica gestor pregunta */
function ver_grafico_pregunta_gestor(id_examen){
    var id_ex = id_examen;
    $.ajax({
        beforeSend: function(){
           $('.view_grafica_pregunta_gestor_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/graficos/view_grafica_pregunta_gestor.php',
        data: "id_examen=" + id_ex,
        success:function(data){
           $('.view_grafica_pregunta_gestor_body').html(data);
        }
    });
}
/* Fin Funcion para ver grafica gestor pregunta */

/* Funcion ver borrador */
function view_atu_borrador(id){
    var atu = id;
    $.ajax({
        beforeSend: function(){
           $('.view_borrador_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/view_atu_borrador.php',
        data: 'id=' + atu,
        success:function(data){
           $('.view_borrador_body').html(data);
        }
    });
}
/* Fin Funcion ver borrador */

/* Funcion ver grafico casos */
function view_grafico_casos(mes,ano){
    var mes = mes;
    var ano = ano;
    $.ajax({
        beforeSend: function(){
           $('.view_grafico_casos_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/graficos/view_grafica_casos.php',
        data: "mes="+ mes + "&ano=" + ano,
        success:function(data){
           $('.view_grafico_casos_body').html(data);
        }
    });
}
/* Fin Funcion ver grafico casos */

/* Funcion ver bitacora */
function view_bitacora(id){
    var atu = id;
    $.ajax({
        beforeSend: function(){
           $('.view_bitacora_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/view_bitacora.php',
        data: 'id=' + atu,
        success:function(data){
           $('.view_bitacora_body').html(data);
        }
    });
}
/* Fin Funcion ver bitacora */

/* Funcion editar conocimiento */
function edit_atu(id){
    var atu_edit = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_conocimiento_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit.php',
        data: 'id=' + atu_edit,
        success:function(data){
            $('.edit_conocimiento_body').html(data);
        }
    });
};
/* Fin Funcion editar conocimiento */

/* Funcion editar Responsable */
function edit_responsable(id){
    var atu_resp = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_responsable_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_responsable.php',
        data: 'id=' + atu_resp,
        success:function(data){
            $('.edit_responsable_body').html(data);
        }
    });
};
/* Fin Funcion editar Responsable */

/* Funcion editar Jobs */
function edit_jobs(id){
    var atu_resp = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_jobs_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_jobs.php',
        data: 'id=' + atu_resp,
        success:function(data){
            $('.edit_jobs_body').html(data);
        }
    });
};
/* Fin Funcion editar Jobs */

/* Funcion editar borrador */
function edit_atu_borrador(id){
    var atu_edit = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_borrador_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_borrador.php',
        data: 'id=' + atu_edit,
        success:function(data){
            $('.edit_borrador_body').html(data);
        }
    });
};
/* Fin Funcion editar borrador */

/* Funcion editar borrador usuario */
function edit_atu_borrador_user(id){
    var atu_edit = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_borradoruser_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_borrador_user.php',
        data: 'id=' + atu_edit,
        success:function(data){
            $('.edit_borradoruser_body').html(data);
        }
    });
};
/* Fin Funcion editar borrador usuario */

/* Funcion editar bitacora */
function edit_bitacora(id){
    var atu_edit = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_bitacora_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_bitacora.php',
        data: 'id=' + atu_edit,
        success:function(data){
            $('.edit_bitacora_body').html(data);
        }
    });
};
/* Fin Funcion editar bitacora */

/* Funcion editar usuario */
function edit_usuario(id){
    var id_usuario = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_usuario_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_usuario.php',
        data: 'id=' + id_usuario,
        success:function(data){
            $('.edit_usuario_body').html(data);
        }
    });
};
/* Fin Funcion editar bitacora */

/* Funcion editar aplicativo */
function edit_aplicativo(id){
    var id_aplicativo = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_aplicativo_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_aplicativo.php',
        data: 'id=' + id_aplicativo,
        success:function(data){
            $('.edit_aplicativo_body').html(data);
        }
    });
};
/* Fin Funcion editar aplicativo */

/* Funcion editar grupo */
function edit_grupo(id){
    var id_grupo = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_grupo_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_grupo.php',
        data: 'id=' + id_grupo,
        success:function(data){
            $('.edit_grupo_body').html(data);
        }
    });
};
/* Fin Funcion editar grupo */

/* Funcion editar examen */
function editar_examen(id){
    var id_examen = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_examen_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_examen.php',
        data: 'id=' + id_examen,
        success:function(data){
            $('.edit_examen_body').html(data);
        }
    });
};
/* Fin Funcion editar examen */

/* Funcion editar pregunta */
function editar_pregunta(id){
    var id_pregunta = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_pregunta_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_pregunta.php',
        data: 'id=' + id_pregunta,
        success:function(data){
            $('.edit_pregunta_body').html(data);
        }
    });
};
/* Fin Funcion editar pregunta */

/* Funcion estadistica pregunta */
function view_grafico_pregunta(id){
    var id_pregunta = id;
    $.ajax({
        beforeSend: function(){
           $('.grafico_pregunta_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/graficos/view_grafica_preguntas.php',
        data: 'id=' + id_pregunta,
        success:function(data){
            $('.grafico_pregunta_body').html(data);
        }
    });
};
/* Fin Funcion estadistica pregunta */

/* Funcion editar examen */
function editar_asignado(id){
    var id_asignado = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_asignado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_asignado.php',
        data: 'id=' + id_asignado,
        success:function(data){
            $('.edit_asignado_body').html(data);
        }
    });
};
/* Fin Funcion editar examen */

/* Funcion editar comunicado */
function editar_comunicado(id){
    var id_comunicado = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_comunicado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_comunicado.php',
        data: 'id=' + id_comunicado,
        success:function(data){
            $('.edit_comunicado_body').html(data);
        }
    });
};
/* Fin Funcion editar comunicado */

/* Funcion editar perfil usuario */
function editar_perfil_usuario(id){
    var id_user = id;
    $.ajax({
        beforeSend: function(){
           $('.edit_perfil_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        type: 'GET',
        url: 'ajax/view_pid/edit/view_edit_perfil.php',
        data: 'id=' + id_user,
        success:function(data){
            $('.edit_perfil_body').html(data);
        }
    });
};
/* Fin Funcion editar perfil usuario */

/* Funcion desconectar usuario */
function desconectar_usuario(id){
    var id_usuario = id;
    swal({
        title: 'Deseas desconectar a este usuario?',
        text: "Solo debera actualizar la pagina para que la sesión se restablezca",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-sign-out"></i> Desconectar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/update/update_estado_usuario.php",
            data: "id="+ id_usuario,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se desconecto al usuario con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_usuarios_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al desconectar al usuario, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se desconecto al usuario",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion desconectar usuario */

/* Funcion aprobar conocimiento */
function aprobar_conocimiento(id,estado){
    var id_aprobar = id;
    var estado = estado;
    swal({
        title: 'Deseas cambiar el estado?',
        text: "Recuerda que al cambiar el estado los analistas pueden ver o no ver los documentos",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> Cambiar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/update/update_estado_conocimiento.php",
            data: "id="+ id_aprobar + "&estado=" + estado,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se actualizo el estado del conocimiento con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_kdb_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al actualizar el estado del conocimiento, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se actualizo el estado del conocimiento",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion aprobar conocimiento */

/* Funcion Cambiar Estado Examen */
function cambiar_estado_examen(id,estado){
    var id_aprobar = id;
    var estado = estado;
    swal({
        title: 'Deseas cambiar el estado?',
        text: "Recuerda que al cambiar el estado, no se podra visualizar en el filtro de exámenes",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> Cambiar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/examen/update_estado_examen.php",
            data: "id="+ id_aprobar + "&estado=" + estado,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se actualizo el estado del examen con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_examen_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al actualizar el estado del examen, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se actualizo el estado del examen",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion Cambiar Estado Examen */

/* Funcion eliminar conocimiento
function eliminar_atu(id){
  var id_tabla = id;
    swal({
        title: 'Deseas eliminar este documento?',
        text: "Al eliminarlo su ID quedara libre para su uso",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/delete/delete_conocimiento.php",
            data: "id="+ id_tabla,
            success: function(data) {
                if(data == "true"){
                    setTimeout(function(){  
                        swal("PID - CLARO AN", "Se elimino el conocimiento.", "success");  
                    }, 600);
                    tabla_kdb_gestor.ajax.reload( null, false );
                }else{
                    swal("PID - CLARO AN", "Error al eliminar el conocimiento, informalo al administrador y/o desarrollador.", "error");
                }
                
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal("PID - CLARO AN", "No se elimino el conocimiento", "error");
      }
    })
};
Fin Funcion eliminar conocimiento */

/* Funcion eliminar borrador (solo cambia estado) */
function eliminar_atu_borrador(id){
  var id_borrador = id;
    swal({
        title: 'Deseas eliminar este borrador?',
        text: "Al eliminarlo solo se cambiara su estado",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/delete/delete_borrador.php",
            data: "id="+ id_borrador,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se elimino el borrador con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_borrador_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al eliminar el borrador, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se elimino el borrador",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion eliminar borrador (solo cambia estado) */

/* Funcion eliminar usuario */
function eliminar_usuario(id){
  var id_usuario = id;
    swal({
        title: 'Deseas eliminar este usuario?',
        text: "Recuerda, que al eliminarlo se podra volver a agregar",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/delete/delete_usuario.php",
            data: "id="+ id_usuario,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se elimino al usuario con exito",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_usuarios_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al eliminar al usuario, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se elimino al usuario",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion eliminar usuario */

/* Funcion eliminar bitacora */
function eliminar_bitacora(id){
  var id_bitacora = id;
    swal({
        title: 'Deseas eliminar esta bitácora?',
        text: "Recuerda, que no va a aparecer en la tabla",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/delete/delete_bitacora.php",
            data: "id="+ id_bitacora,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se elimino la bitácora con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_kdb_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al eliminar la bitácora, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se elimino la bitácora",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion eliminar bitácora */

/* Funcion eliminar aplicativo */
function eliminar_aplicativo(id){
  var id_aplicativo = id;
    swal({
        title: 'Deseas eliminar este aplicativo?',
        text: "Recuerda, que no va a aparecer en la tabla",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/delete/delete_aplicativo.php",
            data: "id="+ id_aplicativo,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se elimino el aplicativo con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_aplicativos.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al eliminar el aplicativo, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
                
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se elimino el aplicativo",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion eliminar aplicativo */

/* Funcion eliminar grupo asignado */
function eliminar_grupo(id){
  var id_grupo = id;
    swal({
        title: 'Deseas eliminar este grupo?',
        text: "Recuerda, que no va a aparecer en la tabla",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/delete/delete_grupo.php",
            data: "id="+ id_grupo,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal("PID - CLARO AN", "Se elimino el grupo", "success");  
                            swal({
                                title: "",
                                text: "Se elimino el grupo con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_grupo_asignado.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al eliminar el grupo asignado, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se elimino el grupo",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion eliminar grupo asignado */

/* Funcion eliminar asignado */
function eliminar_asignado(id,user){
  var id_asignado = id;
  var id_user = user;
    swal({
        title: 'Deseas eliminar a este usuario asignado?',
        text: "Al eliminarlo se podra asignar el mismo examen al usuario",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/examen/delete_asignado.php",
            data: "id="+ id_asignado + "&user=" + id_user,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se elimino al usuario asignado con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_examenes_asignados.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al eliminar al usuario asignado, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se elimino al usuario asignado",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion eliminar asignado */

/* Funcion reiniciar estadistica pregunta */
function reiniciar_estadistica_pregunta(id){
  var id_pregunta = id;
    swal({
        title: 'Deseas reiniciar la estadistica de esta pregunta?',
        text: "Se pondra en 0 sus valores",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-recycle"></i> Reiniciar',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/reset/reset_estadistica_pregunta.php",
            data: "id_pregunta="+ id_pregunta,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se reiniciaron las estadisticas de la pregunta con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_universo_preguntas.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al reiniciar las estadisticas, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se reinicio las estadisticas",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion reiniciar estadistica pregunta */

/* Funcion correguir usuario */
function correguir_usuario(id,user){
  var id_asignado = id;
  var id_user = user;
    swal({
        title: 'Deseas correguir a este usuario?',
        text: "Al realizar esta accion volvera a aparecer en la lista de usuarios",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-wrench"></i> Correguir',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/examen/correguir_usuario.php",
            data: "user="+ id_user + "&id="+ id_asignado,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se corrigio al usuario asignado con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_examenes_asignados.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al correguir al usuario asignado, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se corrigio al usuario asignado",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion correguir usuario */

/* Funcion resetear contraseÃ±a usuario */
function resetear_password(id){
  var id_usuario = id;
    swal({
        title: 'Deseas reiniciar la contraseÃ±a este usuario?',
        text: "Recuerda, que su contraseÃ±a sera su usuario de claro",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> Resetear',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/reset/reset_password.php",
            data: "id_user="+ id_usuario,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se reseteo la contraseÃ±a del usuario con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_usuarios_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al resetear la contraseÃ±a al usuario, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se reseteo la contraseÃ±a al usuario",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion resetear contraseÃ±a usuario */

/* Funcion para cerrar sesion */
    /*function aviso_sesion(){
        setTimeout(function(){
            swal({
                title: 'El tiempo de sesion ha caducado',
                text: "La sesion solo se establece cada 15 minutos",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1b9cdd',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-refresh"></i> Restablecer',
                showLoaderOnConfirm: false,
                cancelButtonText: '<i class="fa fa-sign-out"></i> Cerrar Sesion'
            }).then(function() {
                $.ajax({
                    url: "",
                    success: function(data){
                        swal({
                             title: "",
                             text: "Se restablecio el tiempo de conexion...",
                             type: "success",
                             timer: 1500,
                             showConfirmButton: false
                        });
                        setTimeout(function (){
                         location.reload();
                        },1500);
                    }
                });
            }, function(dismiss) {
              if (dismiss === 'cancel') {
                $.ajax({
                    url: "ajax/action_class/login/logout_ajax.php",
                    success: function(data){
                        swal({
                             title: "",
                             text: "Te desconectaste con exito, espere un momento...",
                             type: "success",
                             showConfirmButton: false
                        });
                        setTimeout(function (){
                         window.location.href = data;
                        },1500);
                    }
                });
              }
            })
        }, 1800000);
    }
    
    function sesion_cerrar(){
        setTimeout(function(){
            $.ajax({
                url: "ajax/action_class/login/logout_ajax.php",
                success: function(data){
                     window.location.href = data;
                }
            });
        }, 2400000);
    }*/
    
    function cierre_ventana(){
        window.location.href = "logout";
    };

/* Fin Funcion para cerrar sesion */

/* Funcion Tomar Examen */
function tomar_examen(id,facil,dificil,id_identificador){
    var examen = id;
    var num_facil = facil;
    var num_dificil = dificil;
    $.ajax({
        beforeSend: function(){
           $('.ins_verexamen_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
        },
        cache: false,
        type: 'GET',
        url: 'ajax/view_pid/view_examen.php',
        data: 'id=' + examen + "&num_facil=" + num_facil + "&num_dificil=" + num_dificil + "&id_identificador=" + id_identificador,
        success:function(data){
           $('.ins_verexamen_body').html(data);
        }
    });
}
/* Fin Funcion Tomar Examen */

/* Modal en Tinymce fix */
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});
/* Fin Modal en Tinymce fix */

/* Funcion para cierre de sesion */
var UIIdleTimeout=function(){
    return{
    init:function(){
    var o;
    $("body").append(""),
        $.idleTimeout("#idle-timeout-dialog",".modal-content button:last",{
            warningLength:15,
            idleAfter:1800,// "1800"
            pollingInterval:2,
            keepAliveURL:"plataforma",
            serverResponseEquals:"OK",
            titleMessage: 'Advertencia: %s segundos para desloguearse | ',
            onTimeout:function(){
                window.location="logout"
            },onIdle:function(){
                $("#idle-timeout-dialog").modal("show"),o=$("#idle-timeout-counter"),
                $("#idle-timeout-dialog-keepalive").on("click",function(){
                    $("#idle-timeout-dialog").modal("hide")
                }),$("#idle-timeout-dialog-logout").on("click",function(){
                    $("#idle-timeout-dialog").modal("hide"),$.idleTimeout.options.onTimeout.call(this)
                })
            },onCountdown:function(e){
                o.html(e)
            }
        })}
    }
}();

var UIIdleTimeout_escalado=function(){
    return{
    init:function(){
    var o;
    $("body").append(""),
        $.idleTimeout("#idle-timeout-dialog",".modal-content button:last",{
            warningLength:15,
            idleAfter:1800,// "1800"
            pollingInterval:2,
            keepAliveURL:"plataforma",
            serverResponseEquals:"OK",
            titleMessage: 'Advertencia: %s segundos para desloguearse | ',
            onTimeout:function(){
                window.location="logout"
            },onIdle:function(){
                $("#idle-timeout-dialog").modal("show"),o=$("#idle-timeout-counter"),
                $("#idle-timeout-dialog-keepalive").on("click",function(){
                    $("#idle-timeout-dialog").modal("hide")
                }),$("#idle-timeout-dialog-logout").on("click",function(){
                    $("#idle-timeout-dialog").modal("hide"),$.idleTimeout.options.onTimeout.call(this)
                })
            },onCountdown:function(e){
                o.html(e)
            }
        })}
    }
}();

/* Fin Funcion para el cierre de la ventana de expiracion */

/* Funcion resetear comentarios de documento */
function resetear_comentarios(id){
  var id_tabla = id;
    swal({
        title: 'Deseas reiniciar los comentarios de este documento?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> Resetear',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/reset/reset_comentarios.php",
            data: "id_tabla="+ id_tabla,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se reseteo los comentarios del documento con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_usuarios_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al resetear los comentarios del documento, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se reseteo los comentarios del documento",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion resetear comentarios de documento */

/* Funcion resetear comentarios calificados del usuario */
function resetear_comment_calificados_usuario(id_user){
  var user_id = id_user;
    swal({
        title: 'Deseas reiniciar los comentarios calificados de este usuario?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> Resetear',
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/reset/reset_comentarios_calificados_user.php",
            data: "user_id="+ user_id,
            success: function(data) {
                if(data == "sin_permiso"){
                    swal({
                        title: "",
                        text: "No cuentas con el permiso correspondiente",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se reseteo los comentarios calificados con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }, 600);
                        tabla_usuarios_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al resetear los comentarios calificados del usuario, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se reseteo los comentarios calificados del usuario",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
};
/* Fin Funcion resetear comentarios calificados del usuario */