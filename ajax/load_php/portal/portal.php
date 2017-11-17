<?php 
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_portal.php');
$object = new portal_pid();
$result = $object->ver_cumpleaños();
$result_casos = $object->analistas_mas_casos();
$result_casos_a = $object->analistas_area_negocios();
?>

<?php $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"); ?>
<div class="container content-md">
    <div class="row">
        <div class="cuerpo_portal">
            <!--=== Slider ===-->
            <div class="panel panel-u">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-birthday-cake"></i> Cumpleañeros del Mes de <?= $meses[date('n')-1] ?></h3>
                </div>
                <div class="panel-body">
                    <center>
                        <div class="owl-carousel-v2 owl-carousel-style-v2">
                            <div class="owl-slider-v3">
                                <?php while($row = $result->fetch_assoc()){ ?>
                                <div class="item <?php if(date("d") == date("d", strtotime($row['fecha_nacimiento']))){ echo "bg-color-blue"; } ?>">
                                    <center>
                                        <img class="img-responsive" src="<?php if($_SERVER['SERVER_NAME'] == "localhost"){ echo "http://".$_SERVER['SERVER_NAME'].":8080/apl/".$row['img_user']; }else if($_SERVER['SERVER_NAME'] == "10.200.10.90" || $_SERVER['SERVER_NAME'] == "10.200.10.90/"){ echo "http://".$_SERVER['SERVER_NAME']."/apl".$row['img_user']; }else{ echo "http://".$_SERVER['SERVER_NAME'].$row['img_user'];  } ?>" style="width: 200px; height: 200px;" alt="<?= $row['nom_user'] ?>">
                                        <h5 class="text-bold" <?php if(date("d") == date("d", strtotime($row['fecha_nacimiento']))){ echo 'style="color: white"'; } ?>><?= $row['nom_user'] ?></h5>
                                        <h5 class="text-bold" <?php if(date("d") == date("d", strtotime($row['fecha_nacimiento']))){ echo 'style="color: white"'; } ?>><?= date("d/m", strtotime($row['fecha_nacimiento'])) ?></h5>
                                    </center>
                                </div>
                                <?php } ?>
                            </div>
                            <br>
                            <div class="owl-navigation">
                                <div class="customNavigation">
                                    <a class="owl-btn prev-v3"><i class="fa fa-angle-left"></i></a>
                                    <a class="owl-btn next-v3"><i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-warning"></i> La metida de pata del Día</h3>
                    </div>
                    <div class="panel-body">
                        <div class="grey">
                            <center>
                                <span aria-hidden="true" class="fa fa-envelope fa-5x text-warning"></span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-medkit"></i> El Correo mas dificil del Día</h3>
                    </div>
                    <div class="panel-body">
                        <div class="grey">
                            <center>
                                <span aria-hidden="true" class="fa fa-envelope fa-5x text-danger"></span>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="panel panel-aqua">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-medkit"></i> Gráfico de Servicio</h3>
                    </div>
                    <div class="panel-body">
                        <div id="grafico_servicio">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-grey pagination__list">
                    <?php 
                        require_once ('../../../data/pid_portal.php');
                        $object_noticias = new portal_pid();
                        $result_noticias = $object_noticias->ver_noticias();
                        while($row_noticias = $result_noticias->fetch_assoc()){
                    ?>
                        <div class="funny-boxes funny-boxes-top-red bg-color-white pagination__item">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="easy-block-v2">
                                        <?php if(strtotime($row_noticias['fecha_noticia']) == strtotime(date("Y-m-d"))){ ?><div class="easy-bg-v2 rgba-red" style="letter-spacing: 0px;">Nuevo</div><?php } ?>
                                        <img class="img-responsive" src="<?php if($_SERVER['SERVER_NAME'] == "localhost"){ echo "http://".$_SERVER['SERVER_NAME'].":8080/apl/".$row_noticias['imagen_noticia']; }else if($_SERVER['SERVER_NAME'] == "10.200.10.90" || $_SERVER['SERVER_NAME'] == "10.200.10.90/"){ echo "http://".$_SERVER['SERVER_NAME']."/apl".$row_noticias['imagen_noticia']; }else{ echo "http://".$_SERVER['SERVER_NAME'].$row_noticias['imagen_noticia'];  } ?>">
                                    </div>
                                    <ul class="list-unstyled">
                                        <li><i class="fa-fw fa fa-calendar"></i> <?= date('d/m/y', strtotime($row_noticias['fecha_noticia'])) ?></li>
                                        <li><i class="fa-fw fa fa-globe"></i> <?= $row_noticias['fuente_noticia'] ?></li>
                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <h2 class="text-danger"><a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ver_noticia_portal" onclick="view_noticia_portal(<?= $row_noticias['id_noticia'] ?>)" class="text-danger"><?= utf8_encode($row_noticias['txt_noticia']) ?></a></h2>
                                    <ul class="list-unstyled funny-boxes-rating">
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                        <li><i class="fa fa-star"></i></li>
                                    </ul>
                                    <p><?= substr(strip_tags($row_noticias['contenido_noticia']), 0, 220) ?> <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_ver_noticia_portal" onclick="view_noticia_portal(<?= $row_noticias['id_noticia'] ?>)">Ver Más ....</a></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- <div class="funny-boxes funny-boxes-top-purple bg-color-white">
                        <div class="row">
                            <div class="col-md-4 funny-boxes-img">
                                <img class="img-responsive" src="assets/images/main/img3.jpg" alt="">
                                <ul class="list-unstyled">
                                    <li><i class="fa-fw fa fa-briefcase"></i> Dell, Google</li>
                                    <li><i class="fa-fw fa fa-map-marker"></i> New York, US</li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <h2><a href="#">Blanditiis Praesentium</a></h2>
                                <ul class="list-unstyled funny-boxes-rating">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                </ul>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="funny-boxes funny-boxes-top-sea bg-color-white">
                        <div class="row">
                            <div class="col-md-4 funny-boxes-img">
                                <img class="img-responsive" src="assets/images/main/img8.jpg" alt="">
                                <ul class="list-unstyled">
                                    <li><i class="fa-fw fa fa-briefcase"></i> Dell, Google</li>
                                    <li><i class="fa-fw fa fa-map-marker"></i> New York, US</li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <h2><a href="#">Blanditiis Praesentium</a></h2>
                                <ul class="list-unstyled funny-boxes-rating">
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                </ul>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum.</p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <ul class="pagination">
                            <li><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div> -->
                </div>
                <br><br>
            </div>
            <div class="col-md-3">
                <div class="panel panel-red equal-height-column">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-meh-o"></i> Analistas con más Casos</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>#Casos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row_c = $result_casos->fetch_assoc()){ ?>
                                <tr>
                                    <td><?= ucwords(utf8_encode(strtolower($row_c['generado_por']))) ?></td>
                                    <td><?= $row_c['total_casos'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-blue equal-height-column">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-frown-o"></i> #Casos Áreas de Negocio</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>#Casos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row_a = $result_casos_a->fetch_assoc()){ ?>
                                <tr>
                                    <td><?= ucwords(utf8_encode(strtolower($row_a['generado_por']))) ?></td>
                                    <td><?= $row_a['total_casos'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-tasks"></i> Mini-Encuesta</h3>
                    </div>
                    <?php 
                        require_once ('../../../data/pid_portal.php');
                        $object_encuesta = new portal_pid();
                        $result_encuesta = $object_encuesta->mini_encuesta();
                        $row_encuesta = $result_encuesta->fetch_assoc();
                        $id_encuesta = $row_encuesta['id_encuesta'];
                        $id_user = $_SESSION['id_user_apl'];
                        $result_mini_bloqueo = $object_encuesta->ver_mini_bloqueo($id_user, $id_encuesta);
                        $row_mini_bloqueo = $result_mini_bloqueo->num_rows;
                        /*while($row_noticias = $result_noticias->fetch_assoc()){*/
                    ?>
                    <form id="finalizar_mini_encuesta">
                        <?php if($row_mini_bloqueo == "0"){ ?>
                        <div class="panel-body">
                                <?php
                                $id_encuesta = $row_encuesta['id_encuesta'];
                                $_SESSION['portal_id_encuesta'] = $row_encuesta['id_encuesta'];
                                $result_enc_pregunta = $object_encuesta->mini_encuesta_pregunta($id_encuesta);
                                while($row_enc_preguntas = $result_enc_pregunta->fetch_assoc()){ ?>
                                    <h5>¿<?= $row_enc_preguntas['titulo_pregunta'] ?>?</h5>
                                    <input type="hidden" name="qid[]" id="qid[]" value="<?= $row_enc_preguntas['id_enc_pregunta']; ?>">
                                    <?php 
                                    $id_enc_pregunta = $row_enc_preguntas['id_enc_pregunta'];
                                    $result_enc_opc = $object->mini_encuesta_opciones($id_enc_pregunta);
                                    $i = 0;
                                    while($row_opc_preguntas = $result_enc_opc->fetch_assoc()){ $i = $i + 1;?>
                                        <label>
                                            <input type="radio" value="<?= $row_opc_preguntas['id_enc_opciones'] ?>" name="<?= $row_enc_preguntas['id_enc_pregunta'] ?>" id="radio_<?= $row_enc_preguntas['id_enc_pregunta'] ?>"> <?= $row_opc_preguntas['titulo_enc_opciones'] ?>
                                        </label>
                                        <br>
                                    <?php } ?>
                                <?php } ?>
                        </div>
                        <div class="panel-footer">
                            <input class="btn btn-primary finalizar_mini_encuesta" type="button" value="Finalizar Mini Encuesta">
                        </div>
                            <?php }else{ ?>
                        <div class="panel-body">
                            <?php
                                $id_encuesta = $row_encuesta['id_encuesta'];
                                $_SESSION['portal_id_encuesta'] = $row_encuesta['id_encuesta'];
                                $result_enc_pregunta = $object_encuesta->mini_encuesta_pregunta($id_encuesta);
                                $result_analistas = $object->verificar_cantidad_usuarios();
                                $analistas = $result_analistas->fetch_assoc();
                                while($row_enc_preguntas = $result_enc_pregunta->fetch_assoc()){ ?>
                                <h5>¿<?= $row_enc_preguntas['titulo_pregunta'] ?>?</h5>
                                    <?php 
                                    $id_enc_pregunta = $row_enc_preguntas['id_enc_pregunta'];
                                    $result_enc_opc = $object->mini_encuesta_opciones($id_enc_pregunta);
                                    $i = 0;
                                    while($row_opc_preguntas = $result_enc_opc->fetch_assoc()){ $i = $i + 1;
                                    $id_pregunta = $row_enc_preguntas['id_enc_pregunta'];
                                    $id_opcion = $row_opc_preguntas['id_enc_opciones'];
                                    $result_cantidad_opciones = $object->verificar_cantidad_opciones_mini($id_pregunta, $id_opcion);
                                    $row_cantidad_opciones = $result_cantidad_opciones->fetch_assoc();
                                    $cantidad_analistas = $analistas['cantidad'];
                                    $cantidad_opciones = $row_cantidad_opciones['cantidad_opciones'];
                                    $barra_porcentaje = intval($cantidad_opciones/$cantidad_analistas*100);
                                    ?>
                                        <b><?= $row_opc_preguntas['titulo_enc_opciones'] ?> - <?= $barra_porcentaje ?>%</b> 
                                        <div class="progress progress-u progress-xs">
                                            <div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="<?= $barra_porcentaje?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $barra_porcentaje?>%"></div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                        </div>
                            <?php } ?>
                    </form>
                    <?php /*}*/ ?>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <center>
                            <i class="fa fa-users fa-5x text-primary"></i> 
                            <h5 class="text-bold">Directorio Aplicaciones de Negocios</h5>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                OwlCarousel.initOwlCarousel();
                $('#grafico_servicio').highcharts({
                    chart: {
                        type: 'area'
                    },
                    title: {
                        text: 'Mes : Febrero'
                    },
                    /*subtitle: {
                        text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">' +
                            'thebulletin.metapress.com</a>'
                    },*/
                    xAxis: {
                        allowDecimals: false,
                        labels: {
                            formatter: function () {
                                return this.value; // clean, unformatted number for year
                            }
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Indicadores'
                        },
                        labels: {
                            formatter: function () {
                                return this.value / 1000 + 'k';
                            }
                        }
                    },
                    tooltip: {
                        pointFormat: '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
                    },
                    plotOptions: {
                        area: {
                            pointStart: 10,
                            marker: {
                                enabled: false,
                                symbol: 'circle',
                                radius: 2,
                                states: {
                                    hover: {
                                        enabled: true
                                    }
                                }
                            }
                        }
                    },
                    series: [{
                        name: 'Mes Pasado',
                        data: [null, null, null, null, null, 6, 11, 32, 110, 235, 369, 640,
                            1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468, 20434, 24126,
                            27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342, 26662,
                            26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
                            24304, 23464, 23708, 24099, 24357, 24237, 24401, 24344, 23586,
                            22380, 21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950,
                            10871, 10824, 10577, 10527, 10475, 10421, 10358, 10295, 10104]
                    }, {
                        name: 'Mes Actual',
                        data: [null, null, null, null, null, null, null, null, null, null,
                            5, 25, 50, 120, 150, 200, 426, 660, 869, 1060, 1605, 2471, 3322,
                            4238, 5221, 6129, 7089, 8339, 9399, 10538, 11643, 13092, 14478,
                            15915, 17385, 19055, 21205, 23044, 25393, 27935, 30062, 32049,
                            33952, 35804, 37431, 39197, 45000, 43000, 41000, 39000, 37000,
                            35000, 33000, 31000, 29000, 27000, 25000, 24000, 23000, 22000,
                            21000, 20000, 19000, 18000, 18000, 17000, 16000]
                    }]
                });
            });
    
            
            $('.pagination__list').paginate({
                items_per_page: 4,
                prev_next: true
            });
            
            $('.finalizar_mini_encuesta').click(function(e){
                var datos = $("#finalizar_mini_encuesta").serialize();
                swal({
                    title: 'Seguro que deseas finalizar la mini-encuesta?',
                    //text: "Recuerda haber llenado todo correctamente !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-check"></i> Finalizar',
                    showLoaderOnConfirm: false,
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/encuesta/finalizar_mini_encuesta.php",
                        data: datos,
                        success: function(data) {
                            //console.log(data);
                            if(data == "true"){
                                setTimeout(function(){
                                    swal({
                                        title: "",
                                        text: "<?= $row_encuesta['mensaje_encuesta'] ?>",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('.ver_portal').click();
                                },600);
                            }else{
                                swal({
                                    title: "",
                                    text: "Favor de llenar todos los campos correctamente, como tambien informarlo con el administrador y/o desarrollador",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }, function(dismiss) {
                  if (dismiss === 'cancel') {
                    swal("PID - CLARO AN", "No se finalizo la encuesta", "error");
                  }
                });
                e.preventDefault();
            });
        </script>
    </div>
</div>