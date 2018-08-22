<?php
include('bussiness/impuestos.php');
$objData = new clsImpuesto();

$strListItems = '';
$strListDelete = '';
$strListValids = '';

$validItems = false;
$arrayValid = array();
$arrayDelete = array();

$rpta = 0;

if ($_POST){
    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = $_POST['hdIdPrimary'];
        $txtNombre = $_POST['txtNombre'];

        $detalleI = array(  'Activo' => 1,
                            'IdUsuarioReg' => 1,
                            'FechaReg' => date("Y-m-d h:i:s")
                            );

        $detalleU = array(   'tm_idimpuesto' => $hdIdPrimary,
                            'tm_nombre' => $txtNombre,
                            'IdUsuarioAct' => 1,
                            'FechaAct' => date("Y-m-d h:i:s") );

        if ($hdIdPrimary == '0')
            $detalle = array_merge($detalleI, $detalleU);
        else
            $detalle = $detalleU;

        $rpta = $objData->Registrar($detalle);
        $jsondata = array("rpta" => $rpta);
    }
    elseif ($_POST['btnEliminar']) {
        $chkItem = $_POST['chkItem'];
        if (isset($chkItem))
            if (is_array($chkItem)) {
                $countCheckItems = count($chkItem);
                $strListItems = implode(',', $chkItem);
                /*$rsValidItems = $objData->Listar('VALID-VENTAS', $strListItems);
                $countValidItems = count($rsValidItems);
                
                if ($countValidItems > 0) {
                    for ($counterValidItems=0; $counterValidItems < $countValidItems; ++$counterValidItems)
                        array_push($arrayValid, $rsValidItems[$counterValidItems]['tm_idimpuesto']);
                    $arrayDelete = array_diff($chkItem, $arrayValid);
                    if (!empty($arrayDelete))
                        $strListItems = implode(',', $arrayDelete);
                    else
                        $strListItems = '';
                }
                if ($countCheckItems > $countValidItems)*/
                $rpta = $objData->MultiDelete($strListItems);
            }
        if (!empty($arrayValid))
            $strListValids = implode(',', $arrayValid);
        $jsondata = array('rpta' => $rpta, 'items_valid' => $strListValids);
    }
    
    echo json_encode($jsondata);
    exit(0);
}
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
        <div id="pnlMoneda" class="inner-page">
            <div id="gvDatos" class="listview"></div>
        </div>
    </div>
    <div class="appbar">
        <button id="btnEliminar" name="btnEliminar" type="button" class="cancel metro_button oculto float-right">
            <span class="content">
                <img src="images/trash.png" alt="<?php $translate->__('Eliminar'); ?>" />
                <span class="text"><?php $translate->__('Eliminar'); ?></span>
            </span>
        </button>
        <button id="btnEditar" type="button" class="metro_button oculto float-right">
            <span class="content">
                <img src="images/edit.png" alt="<?php $translate->__('Editar'); ?>" />
                <span class="text"><?php $translate->__('Editar'); ?></span>
            </span>
        </button>
        <button id="btnNuevo" type="button" class="metro_button float-right">
            <span class="content">
                <img src="images/add.png" alt="<?php $translate->__('Nuevo'); ?>" />
                <span class="text"><?php $translate->__('Nuevo'); ?></span>
            </span>
        </button>
        <button id="btnLimpiarSeleccion" type="button" class="metro_button oculto float-left">
            <span class="content">
                <img src="images/icon_uncheck.png" alt="<?php $translate->__('Limpiar selecci&oacute;n'); ?>" />
                <span class="text"><?php $translate->__('Limpiar selecci&oacute;n'); ?></span>
            </span>
        </button>
        <div class="clear"></div>
    </div>
    <div id="modalRegistro" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de datos
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtNombre"><?php $translate->__('Nombre'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre de impuesto" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardar" type="button" class="command-button mode-add success">Guardar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiar" type="button" class="command-button mode-add default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script>
    $(function () {
        //document.oncontextmenu = function() {return false;};

        $('#btnGuardar').on('click', function(event) {
            event.preventDefault();
            GuardarDatos();
        });

        $('#btnLimpiar').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
        });

        $('#btnEliminar').on('click', function () {
            Eliminar();
            return false;
        });

        $('#txtNombre').on('keydown', function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER){
                $('#btnGuardar').focus();
                return false;
            }
        });

        $('#btnLimpiarSeleccion').on('click', function(event) {
            event.preventDefault();
            limpiarSeleccionados();
            $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
            $('#btnNuevo').removeClass('oculto');
        });

        $('#btnEditar').on('click', function(event) {
            var id = $('.listview a.list.selected').attr('data-id');
            event.preventDefault();
            openCustomModal('#modalRegistro');
            GetDataById(id);
        });

        $('#btnEliminar').on('click', function(event) {
            event.preventDefault();
            var elem = $('.listview a.selected');
        });

        $('#btnNuevo').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
            openCustomModal('#modalRegistro');
        });

        $("#form1").validate({
            lang: 'es',
            showErrors: showErrorsInValidate,
            submitHandler: EnviarDatos
        });

        addValidForm();
        MostrarDatos();
    });

    function LimpiarForm () {
        $('#hdIdPrimary').val('0');
        $('#txtNombre').val('').focus();
    }

    function addValidForm () {
        $('#txtNombre').rules('add', {
            required: true,
            maxlength: 150
        });
    }

    function GuardarDatos () {
        $('#form1').submit();
    }

    function limpiarSeleccionados () {
        $('.listview .selected').removeClass('selected');
        $('.listview .list input:checkbox').removeAttr('checked');
    }

    function MostrarDatos () {
        $.ajax({
            url: 'services/impuestos/impuesto-search.php',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            var i = 0;
            var count = data.length;
            var strhtml = '';

            for (i = 0; i < count; i++) {
                strhtml += '<a href="#" class="list dato" data-id="' + data[i].tm_idimpuesto + '">';
                strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idimpuesto + '" />';
                strhtml += '<div class="list-content">';
                strhtml += '<div class="data">';
                strhtml += '<h2>' + data[i].tm_nombre + '</h2>';
                strhtml += '</div></div></a>';
            };

            $('.listview').html(strhtml);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function EnviarDatos (form) {
        $.ajax({
            type: "POST",
            url: '?pag=<?php echo $pag; ?>&subpag=<?php echo $subpag; ?>',
            cache: false,
            data: $(form).serialize() + "&btnGuardar=btnGuardar",
            success: function(data){
                datos = eval( "(" + data + ")" );
                if (Number(datos.rpta) > 0){
                    MessageBox('<?php $translate->__('Datos guardados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                        limpiarSeleccionados();
                        resetForm('form1');
                        closeCustomModal('#modalRegistro');
                        MostrarDatos();
                        $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
                        $('#btnNuevo').removeClass('oculto');
                    });
                }
            }
        });
    }

    function Eliminar () {
        var serializedReturn = $("#form1 input[type!=text]").serialize() + '&btnEliminar=btnEliminar';
        precargaExp('.page-region', true);
        $.ajax({
            type: "POST",
            url: '?pag=<?php echo $pag; ?>&subpag=<?php echo $subpag; ?>',
            cache: false,
            data: serializedReturn,
            success: function(data){
                var titleMensaje = '';
                var contentMensaje = '';
                var datos = eval( "(" + data + ")" );
                var validItems = datos.items_valid;
                var countValidItems = validItems.length;
                precargaExp('.page-region', false);
                if (Number(datos.rpta) > 0){
                    if (countValidItems > 0){
                        titleMensaje = '<?php $translate->__('Items eliminados correctamente'); ?>';
                        contentMensaje = '<?php $translate->__('Algunos items no se eliminaron. Click en "Aceptar" para ver detalle.'); ?>';
                    }
                    else {
                        titleMensaje = '<?php $translate->__('Items eliminados correctamente'); ?>';
                        contentMensaje = '<?php $translate->__('La operaci&oacute;n ha sido completada'); ?>';    
                    }
                }
                else {
                    titleMensaje = '<?php $translate->__('No se pudo eliminar'); ?>';
                    contentMensaje = '<?php $translate->__('La operaci&oacute;n no pudo completarse'); ?>';
                }
                MessageBox(titleMensaje, contentMensaje, "[<?php $translate->__('Aceptar'); ?>]", function () {
                    var arrayValid = validItems.split(',');
                    var dataSelected = $('.listview .list.selected');
                    var countDataSelected = dataSelected.length;
                    var i = 0;
                    var idItem = 0;
                    var $Notif = '';

                    if (countValidItems > 0){
                        $('.error-list').html('');
                        while(i < countDataSelected){
                            idItem = dataSelected[i].getAttribute('rel');
                            if (arrayValid.indexOf( idItem )>=0){
                                $Notif += '<div class="notification warning">';
                                $Notif += '<aside><i class="fa fa-warning"></i></aside>';
                                $Notif += '<main><p><strong>Error en item con ID: ' + $(dataSelected[i]).find('.list-status span.label').text() + '</strong>';
                                $Notif += 'El item no pudo ser eliminado por tener referencia con otras operaciones realizadas.</p></main>';
                                $Notif += '</div>';
                            }
                            else {
                                $(dataSelected[i]).fadeOut(400, function () {
                                    $(this).remove();
                                });
                            }
                            ++i;
                        }
                        $('.error-list').html($Notif);
                        $('#modalItemsError').show();
                        $.fn.custombox({
                            url: '#modalItemsError',
                            effect: 'slit'
                        });
                    }
                    else {
                        if (datos.rpta > 0){
                           dataSelected.fadeOut(400, function () {
                                $(this).remove();
                            }); 
                        }
                    }
                });
            }
        });
    }

    function GetDataById (idData) {
        $.ajax({
            url: 'services/impuestos/impuesto-getdetails.php',
            type: 'GET',
            dataType: 'json',
            data: {id: idData}
        })
        .done(function(data) {
            $('#hdIdPrimary').val(data[0].tm_idimpuesto);
            $('#txtNombre').val(data[0].tm_nombre);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
</script>