<?php
include('bussiness/numeracionventa.php');
$objData = new clsNumeracionVenta();

$IdEmpresa = 1;
$IdCentro = 1;

$strListItems = '';
$strListDelete = '';
$strListValids = '';

$validItems = false;
$arrayValid = array();
$arrayDelete = array();

if ($_POST){
    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = $_POST['hdIdPrimary'];
        $ddlTerminal = $_POST['ddlTerminal'];
        $ddlTipoComprobante = $_POST['ddlTipoComprobante'];
        $txtSerieDoc = $_POST['txtSerieDoc'];
        $txtNroInicial = $_POST['txtNroInicial'];
        $txtNroFinal = $_POST['txtNroFinal'];
        
        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $ddlTipoComprobante, $ddlTerminal, $txtSerieDoc, $txtNroInicial, $txtNroFinal, $idusuario);
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
                        array_push($arrayValid, $rsValidItems[$counterValidItems]['tm_idformapago']);
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
        <div id="pnlSerie" class="inner-page">
            <div id="gvDatos" class="tile-area"></div>
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
            <div class="grid fluid">
                <div class="row">
                    <label for="ddlTerminal"><?php $translate->__('Terminal'); ?></label>
                    <div class="span11 no-margin">
                        <div class="input-control select fa-caret-down">
                            <select name="ddlTerminal" id="ddlTerminal">
                            </select>
                        </div>
                    </div>
                    <div class="span1 no-margin span-update">
                        <button id="btnUpdateTerminal" type="button" class="btn-update">
                            <i class="icon-cycle"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlTipoComprobante"><?php $translate->__('Tipo de comprobante'); ?></label>
                    <div class="span11 no-margin">
                        <div class="input-control select fa-caret-down">
                            <select name="ddlTipoComprobante" id="ddlTipoComprobante">
                            </select>
                        </div>
                    </div>
                    <div class="span1 no-margin span-update">
                        <button id="btnUpdateTipoComprobante" type="button" class="btn-update">
                            <i class="icon-cycle"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtSerieDoc"><?php $translate->__('Serie'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtSerieDoc" name="txtSerieDoc" type="text" placeholder="Ingrese serie" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtNroInicial"><?php $translate->__('N&uacute;mero inicial'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNroInicial" name="txtNroInicial" type="text" placeholder="Ingrese n&uacute;mero inicial" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtNroFinal"><?php $translate->__('N&uacute;mero final'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNroFinal" name="txtNroFinal" type="text" placeholder="Ingrese n&uacute;mero final" />
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
        $('#btnGuardar').on('click', function(event) {
            event.preventDefault();
            GuardarDatos();
        });

        $('#btnLimpiar').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
        });

        $('#btnEditar').on('click', function(event) {
            var id = $('#gvDatos .dato.selected').attr('data-id');
            event.preventDefault();
            openCustomModal('#modalRegistro');
            GetDataById(id);
        });

        $('#btnEliminar').on('click', function(event) {
            Eliminar();
            return false;
        });

        $('#txtSerieDoc').on('keydown', function(event) {
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

        $('#btnNuevo').on('click', function(event) {
            event.preventDefault();
            LimpiarForm();
            openCustomModal('#modalRegistro');
        });

        $('#btnUpdateTerminal').on('click', function(event) {
            event.preventDefault();
            ListarTerminal();
        });

        $('#btnUpdateTipoComprobante').on('click', function(event) {
            event.preventDefault();
            ListarTipoComprobante();
        });

        $("#form1").validate({
            lang: 'es',
            showErrors: showErrorsInValidate,
            submitHandler: EnviarDatos
        });
        
        addValidForm();
        MostrarDatos();
        ListarTerminal();
        ListarTipoComprobante();
    });

    function LimpiarForm () {
        $('#hdIdPrimary').val('0');
        $('#ddlTerminal')[0].selectedIndex = 0;
        $('#ddlTipoComprobante')[0].selectedIndex = 0;
        $('#txtNroInicial').val('');
        $('#txtNroFinal').val('');
        $('#txtSerieDoc').val('').focus();
    }

    function addValidForm () {
        $('#txtSerieDoc').rules('add', {
            required: true,
            maxlength: 11
        });
    }

    function GuardarDatos () {
        $('#form1').submit();
    }

    function limpiarSeleccionados () {
        $('#gvDatos .selected').removeClass('selected');
        $('#gvDatos input:checkbox').removeAttr('checked');
    }

    function MostrarDatos () {
        $.ajax({
            url: 'services/numeracion/numventa-search.php',
            type: 'GET',
            dataType: 'json'
        })
        .done(function(data) {
            var i = 0;
            var count = data.length;
            var strhtml = '';

            if (count > 0){
                for (i = 0; i < count; i++) {
                    strhtml += '<div data-id="' + data[i].td_idnumeraciondoc + '" class="tile dato double bg-transparent" data-click="transform">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].td_idnumeraciondoc + '" />';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2>' + data[i].TipoComprobante + '</span></h2>';
                    strhtml += '<h3># Actual: ' + data[i].td_nroactual + '</span></h3>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="brand">';
                    strhtml += '<div class="label fg-darker">Serie: ' + data[i].td_seriedoc + ' / Inicio: ' + data[i].td_nroinicial + ' / Final: ' + data[i].td_nrofinal + '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                };
            };

            $('.tile-area').html(strhtml);
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
            url: 'services/numeracion/numventa-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '2',
                id: idData
            }
        })
        .done(function(data) {
            $('#hdIdPrimary').val(data[0].td_idnumeraciondoc);
            $('#ddlTerminal').val(data[0].tm_idterminal);
            $('#ddlTipoComprobante').val(data[0].tm_idtipocomprobante);
            $('#txtSerieDoc').val(data[0].td_seriedoc);
            $('#txtNroInicial').val(data[0].td_nroinicial);
            $('#txtNroFinal').val(data[0].td_nrofinal);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function ListarTerminal () {
        $.ajax({
            url: 'services/terminal/terminal-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '1',
                criterio: ''
            }
        })
        .done(function(data) {
            var i = 0;
            var count = 0;
            var strhtml = '';

            count = data.length;

            if (count > 0){
                for (i = 0; i < count; i++) {
                    strhtml += '<option value="' + data[i].tm_idterminal + '">' + data[i].tm_nombre + '</option>';
                };
            }
            else
                strhtml = '<option value="0">NO EXISTEN TERMINALES REGISTRADAS</option>';

            $('#ddlTerminal').html(strhtml);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function ListarTipoComprobante () {
        $.ajax({
            url: 'services/tipocomprobante/tipocomprobante-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '1',
                criterio: ''
            }
        })
        .done(function(data) {
            var i = 0;
            var count = 0;
            var strhtml = '';

            count = data.length;

            if (count > 0){
                for (i = 0; i < count; i++) {
                    strhtml += '<option value="' + data[i].tm_idtipocomprobante + '">' + data[i].tm_nombre + '</option>';
                };
            }
            else
                strhtml = '<option value="0">NO EXISTEN TIPOS DE COMPROBANTE REGISTRADOS</option>';

            $('#ddlTipoComprobante').html(strhtml);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
</script>