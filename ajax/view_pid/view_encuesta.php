<?php
    session_start();
    date_default_timezone_set('America/Bogota');
    $seconds = 0;
    sleep($seconds);
    require_once ('../../data/pid_encuesta.php');
    $id_encuesta = $_GET['id'];
    $object = new Encuesta();
    $result = $object->dar_encuesta($id_encuesta);
    $result_c = $object->dar_encuesta_com($id_encuesta);
    $result_enc = $object->view_encuesta($id_encuesta);
    $row_enc = $result_enc->fetch_assoc();
    $e = 0;
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title text-center">Encuesta PID</h3>
    </div>
    <div class="modal-body">
        <form id="finalizar_encuesta">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center text-primary"><u><?= $row_enc['titulo_encuesta'] ?></u></h3>                     
                </div>
            </div>
            <?php while ($reg = $result->fetch_assoc()) { $e = $e + 1;?>
            <div class="row">
                <div class="col-md-12">
                    <b class="text-primary"> <?= $e.") " ?></b> <b><?= $reg['titulo_pregunta'] ?></b>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="qid[]" id="qid[]" value="<?= $reg['id_enc_pregunta']; ?>">
                    <?php 
                    $id_enc_pregunta = $reg['id_enc_pregunta'];
                    $result_enc_opc = $object->view_enc_opc($id_enc_pregunta);
                    $i = 0;
                    while($reg_opc = $result_enc_opc->fetch_assoc()){ $i = $i + 1;?>
                        <label>
                            <input type="radio" value="<?= $reg_opc['id_enc_opciones'] ?>" name="<?= $reg['id_enc_pregunta'] ?>" id="radio_<?= $reg['id_enc_pregunta'] ?>"> <?= $reg_opc['titulo_enc_opciones'] ?>
                        </label>
                        <br>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php if($row_enc['habilitar_comentario'] == 1){ ?>
                <?php while ($reg_c = $result_c->fetch_assoc()) { $e = $e + 1;?>
                <div class="row">
                    <div class="col-md-12">
                        <b class="text-primary"> <?= $e.") " ?></b> <b><?= $reg_c['titulo_pregunta'] ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input name="id_encuesta" value="<?= $id_encuesta ?>" hidden>
                        <input name="id_enc_pre_comentario" value="<?= $reg_c['id_enc_pregunta'] ?>" hidden>
                        <br>
                        Dirigido a : 
                        <select class="selectpicker show-tick" name="sl_comentario" data-header="Dirigido a :">
                            <option disabled selected>Seleccionar Aqui</option>
                            <option value="0">Clima y Satisfacción laboral</option>
                            <option value="1">Calidad y Conocimiento</option>
                            <option value="2">Infraestructura y condiciones de trabajo</option>
                            <option value="3">Jefatura y Gestión de Operaciones</option>
                        </select>
                        <br><br>
                        <textarea name="enc_comentario" class="form-control textarea_enc" style="resize:none"></textarea>
                        <br>
                        <b style="float: right !important;">Máx <b class="limit">0</b>/250 Caracteres</b>
                        <br>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            <div class="modal-footer">
                <input class="btn btn-primary finalizar_encuesta" type="button" value="Finalizar">
            </div>
        </form>
    </div>
</div>
<script>
    
    $('.selectpicker').selectpicker();
    
    var maxchars = 250;

    $('.textarea_enc').keyup(function () {
        var tlength = $(this).val().length;
        $(this).val($(this).val().substring(0, maxchars));
        var tlength = $(this).val().length;
        remain = maxchars - parseInt(tlength);
        remain2 = 0 + parseInt(tlength);
        $('.limit').text(remain2);
    });
    
    $('.finalizar_encuesta').click(function(e){
        var datos = $("#finalizar_encuesta").serialize();
        swal({
            title: 'Seguro que deseas finalizar la encuesta?',
            text: "Recuerda haber llenado todo correctamente !",
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
                url: "ajax/action_class/encuesta/finalizar_encuesta.php",
                data: datos,
                success: function(data) {
                    //console.log(data);
                    if(data == "true"){
                        setTimeout(function(){
                            swal({
                                title: "",
                                text: "<?= $row_enc['mensaje_encuesta'] ?>",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            }).then(function() {
                                setTimeout(function(){
                                    $(document.body).css('padding-right','');
                                },200);
                            });
                            $("#modal_dar_encuesta").modal('toggle');
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
