<?php
    header('Content-type: text/javascript');
    require('../../../common/class.translation.php');
    $lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
    $translate = new Translator($lang);
?>
var TipoBusqueda = '00';
$(function () {
    $('#btnBack').on('click', function(event) {
        event.preventDefault();
        $('#pnlListVentas', parent.document).fadeOut(400, function() {
            
        });
    });

    $("#form1").validate({
        ignore: '',
        lang: 'es',
        showErrors: showErrorsInValidate
    });

    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        Guardar();
    });

    $('#btnCancelar, #btnBackList').on('click', function (event) {
        event.preventDefault();
        removeValidVenta(); 
        resetForm('form1');
        Limpiar();
        BackToList();
        $('#btnGuardar, #btnBuscarItems, #btnCancelar').addClass('oculto');
        $('#btnNuevo').removeClass('oculto');
        return false;
    });

    $('#btnBackForm').on('click', function (event) {
        event.preventDefault();
        $('#btnGuardar, #btnBuscarItems, #btnFormaPago, #btnCancelar').removeClass('oculto');
        $('#btnMoreFilter').addClass('oculto');
        BackToForm();
        return false;
    });

    $('#btnNuevo, #btnEditar').on('click', function (event) {
        event.preventDefault();
        resetForm('form1');
        Limpiar();
        addValidVenta();
        ExtraerTipoCambio('#ddlMoneda', '#txtTipoCambio');
        ExtraerTipoCambio('#ddlMonedaTarjeta', '#txtTipoCambioEfectivo');
        GoToEdit();
    });

    $('#ddlMoneda').on('change', function(event) {
        event.preventDefault();
        ExtraerTipoCambio('#ddlMoneda', '#txtTipoCambio');
        ExtraerSimboloMoneda();
    });

    $('#ddlMonedaTarjeta').on('change', function(event) {
        event.preventDefault();
        ExtraerTipoCambio('#ddlMonedaTarjeta', '#txtTipoCambioEfectivo');
    });

    $('#ddlNombreTarjeta').on('change', function(event) {
        event.preventDefault();
        ExtraerComisionTarjeta();
    });

    $('#txtImporteRecibido').on({
        keyup: function () {
            var importeRecibido = Number(($(this).val().trim().length == 0 ? '0' : $(this).val()));
            var cambioPedido = 0;
            cambioPedido =  calcularCambio(importeRecibido);
            $('#txtImporteCambio').val(cambioPedido.toFixed(2));
            //CalcularTotalConImpuestoPorVenta();
            CalcularTotal();
        },
        mouseup: function(){
            return false;
        },
        focus: function () {
            $(this).select();
            return false;
        },
        click: function() {
            $(this).select();
            return false;
        }
    });

    $('#txtImporteTarjeta').on('keyup', function(event) {
        var importeComision = 0;
        
        event.preventDefault();

        if (Number($(this).val()) > 0)
            importeComision = ($('#txtComisionTarjeta').val().trim().length == 0 ? 0 : Number($('#txtComisionTarjeta').val()));

        $('#pnlInfoImporte .grid .row[data-codigo="005"] .total').text(Number($(this).val()).toFixed(2));
        $('#pnlInfoImporte .grid .row[data-codigo="comision"] .total').text(importeComision.toFixed(2));
        //MostrarTotalPorVenta();
        //CalcularTotalConImpuestoPorVenta();
        CalcularTotal();
    });

    $('#ddlTipoComprobante').on('change', function(event) {
        event.preventDefault();
        
        //GenerarNumVenta();
       // CalcularTotalConImpuestoPorVenta();
       CalcularTotal();
    });

    $('#pnlInfoCliente').on('click', function(event) {
        event.preventDefault();
        ShowPanelClientes();
    });

    $('#btnInfoImporte').on('click', function(event) {
        event.preventDefault();

        if (!$(this).hasClass('active')){
            //$('#pnlInfoImporte').slideDown();
            $(this).addClass('active');

            $('#pnlInfoImporte').stop(true, true)
            .show( "clip",{direction: "vertical"}, 400 )
            .animate({ opacity : 1 }, { duration: 400, queue: false });
        }
        else {
            //$('#pnlInfoImporte').slideUp();
            $(this).removeClass('active');

            $('#pnlInfoImporte').stop(true, true)
            .hide( "clip",{direction: "vertical"}, 400 )
            .animate({ opacity : 0 }, { duration: 400, queue: false });
        }
        
    });

    $('#gvClientes .items-area').on('click', '.list', function(event) {
        var tipocliente = '',
            idcliente = '0',
            nrodoc = '',
            descripcion = '',
            direccion = '';

        event.preventDefault();
        $('#hdIdCliente').val($(this).attr('data-idcliente'));
        tipocliente = $(this).attr('data-tipocliente');
        idcliente = $(this).attr('data-idcliente');
        nrodoc = $(this).find('main p .docidentidad').text();
        descripcion = $(this).find('main p .descripcion').text();
        direccion = $(this).find('main p .direccion').text();

        setCliente(tipocliente, idcliente, nrodoc, descripcion, direccion);
    });

    $('#txtSearchCliente').on('keyup', function(event) {
        LoadClienteWithForm($('#txtSearchCliente').val(), '', '1');
        extraerNombresCliente($(this).val());
    });

    $('#btnSearchCliente').on('click', function(event) {
        event.preventDefault();
        LoadClienteWithForm($('#txtSearchCliente').val(), '', '1');
    });

    $('#btnNewCliente').on('click', function(event) {
        event.preventDefault();

        LimpiarFormCliente();
        $('#btnSaveCliente, #btnCancelCliente').removeClass('oculto');
        $('#gvClientes').hide();
        $('#frmClientes').show(400, function() {
            
        });
    });

    setTipoDocIdentidad();

    $('#btnSaveCliente').on('click', function(event) {
        var tipocliente = '';
        var nrodoc = '';
        var descripcion = '';
        var direccion = '';
        
        event.preventDefault();

        if ($('#tabDNI').is(':visible')){
            tipocliente = 'NA';
            nrodoc = $('#txtNroDocNatural').val();
            direccion = $('#txtDireccionNat').val();
        }
        else {
            tipocliente = 'JU';
            nrodoc = $('#txtRucEmpresa').val();
            direccion = $('#txtDireccionJur').val();
        }

        $('#hdCodigoCliente').val(nrodoc);
    
        if (tipocliente == 'NA')
            descripcion = $('#txtNombres').val() + ' ' + $('#txtApePaterno').val() + ' ' + $('#txtApeMaterno').val();
        else
            descripcion = $('#txtRazonSocial').val();

        setCliente(tipocliente, '0', nrodoc, descripcion, direccion);
    });

    $('#btnCancelCliente').on('click', function(event) {
        event.preventDefault();
        LoadClienteWithForm($('#txtSearchCliente').val(), '', '1');
    });

    setSpecialTab('#pnlFormaPago', function () {
        
    });

    $('#pnlFormaPago ul').on('click', 'li', function(){
        LimpiarFormaPago();
        $('#pnlFormaPago .content .panels').addClass('oculto');
        var idPanel = $(this).find('a').attr('data-panel'); 
        $('#pnlFormaPago .content #' + idPanel).removeClass('oculto');
    });

    setSpecialTab('#tabClientes', function () {
        extraerNombresCliente($('#txtSearchCliente').val());
        setTipoDocIdentidad();});

    $('#btnFormaPago').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalFormaPago');
    });

    $('#btnHideFormaPago').on('click', function (event) {
        event.preventDefault();
        closeCustomModal('#modalFormaPago');
    });

    $('#btnAplicarFormaPago').on('click', function(event) {
        event.preventDefault();
        closeCustomModal('#modalFormaPago');
    });

    $('#btbCancelarFormaPago').on('click', function(event) {
        event.preventDefault();
        LimpiarFormaPago();
    });

    $('#btnBuscarItems').on('click', function (event) {
        event.preventDefault();
        MostrarPanelItems();
    });

    $('#gvProductos .tile-area').on('click', '.tile', function(event) {
        var idproducto = '0';
        event.preventDefault();
        LimpiarInputProducto();
        idproducto = $(this).attr('data-idproducto');
        $('#hdIdProducto').val(idproducto);
        //$('#headerInfoProduct').html($(this).html());
        $('#lblDescripProducto').text($(this).find('.tile_true_content .label').text());
        $('#imgProducto').attr('src',($(this).find('.tile_true_content .image img').attr('src')));
        $('#imgProducto').css({'width':'100%', 'height':'160'})
        //listarPresentaciones(idproducto);
        openCustomModal('#pnlInfoProducto');
    });

    $('#txtSearchProd').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#btnSearchProducts').trigger('click');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchProducts').on('click', function(event) {
        event.preventDefault();
        listarProductos('1');
    });

    $('#btnProductoAdd').on('click', function(event) {
        event.preventDefault();
        AddDetalle();
    });

    $('#btnHidePnlInfoProducto').on('click', function (event) {
        event.preventDefault();

        closeCustomModal('#pnlInfoProducto');
        //removeValidInfoProd();
    });

    BuscarDatos('1');
});

function AplicarFormaPago () {
    
}

function LimpiarFormaPago () {
    $('#txtCodigoRecibo').val('');
    $('#txtValeDescuento').val('');
    $('#txtImporteTarjeta').val('0.00');
    $('#txtImporteRecibido').val('0.00');
    $('#txtImporteCambio').val('0.00');
    $('#ddlMonedaTarjeta')[0].selectedIndex = 0;
    $('#ddlNombreTarjeta')[0].selectedIndex = 0;
    ExtraerTipoCambio('#ddlMoneda', '#txtTipoCambio');
    ExtraerTipoCambio('#ddlMonedaTarjeta', '#txtTipoCambioEfectivo');
    ExtraerComisionTarjeta();
    ExtraerSimboloMoneda();
}

function LimpiarFormCliente () {
    $('#txtApePaterno').val('');
    $('#txtApeMaterno').val('');
    $('#txtNombres').val('');
    $('#txtRazonSocial').val('');
    $('#txtRucEmpresa').val('');
    $('#txtNroDocNatural').val('');
}

function LimpiarInfoCliente () {
    $('#pnlInfoCliente .info .descripcion').text('CLIENTE GENERICO');
    $('#pnlInfoCliente .info .docidentidad').text('NA: 000');
    $('#pnlInfoCliente .info .direccion').text('No especificada');
}

function Limpiar () {
    $('#txtFecha').val(GetToday());
    $('#ddlTipoComprobante')[0].selectedIndex = 0;
    $('#ddlMoneda')[0].selectedIndex = 0;
    $('#txtSerieComprobante').val('');
    $('#txtNroComprobante').val('');
    ExtraerSimboloMoneda();
    ExtraerTipoCambio('#ddlMoneda', '#txtTipoCambio');
    ExtraerTipoCambio('#ddlMonedaTarjeta', '#txtTipoCambioEfectivo');
    LimpiarFormaPago();
    $('#lblImporteCobro').text('0.00');
}

function LimpiarInputProducto () {
    $('#ddlUnidadMedida option[data-simbolo="und."]').prop('selected', true);
    $('#txtCantidad').val('');
    $('#txtPrecioRef').val('');
    addValidInfoProd();
}

function calcularCambio (importeRecibido) {
    var totalPedido = Number($('#lblImporteCobro').text());
    var cambioPedido = 0;

    if (importeRecibido > totalPedido)
        cambioPedido = importeRecibido - totalPedido;
    else {
        cambioPedido = 0;
        totalPedido = importeRecibido;
    }
    $('#pnlInfoImporte .grid .row[data-codigo="009"] .total').text(totalPedido.toFixed(2));
    return cambioPedido;
}

function CalcularTotal () {
    var rows = $('#tableDetalle tbody tr');
    var count = rows.length;
    var i = 0;
    var countItemsImp = 0;
    var impuestoPorCompra = 0;
    var totalSinImpuesto = 0;
    var totalConImpuesto = 0;
    var totalImpuesto = 0;

    var idtipocomprobante = '0';

    var list = $('#pnlInfoImporte h3.total.impuesto');
    idtipocomprobante = $('#ddlTipoComprobante option:selected').attr('data-codigosunat');
    countItemsImp = list.length;

    for (i = 0; i < count; i++) {
        totalConImpuesto = totalConImpuesto + Number($(rows[i]).find('td.subtotal').text());
    };

    if (countItemsImp > 0){
        for (i = 0; i < countItemsImp; i++){
            var impuesto = Number(list[i].getAttribute("data-valorimpuesto"));
            var subtotalImpuesto = totalConImpuesto - (totalConImpuesto / (1 + impuesto));
            totalImpuesto = totalImpuesto + subtotalImpuesto;
            if (list[i].innerText != null){
                list[i].innerText  = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
            }
            else{
                list[i].textContent = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
            }
        }
        if (idtipocomprobante == "01")
            totalSinImpuesto = totalConImpuesto - totalImpuesto;
        else
            totalSinImpuesto = totalConImpuesto;
    }

    $('#hdImpuesto').val(totalImpuesto.toFixed(2));
    $('#hdTotalSinImpuesto').val(totalSinImpuesto.toFixed(2));
    $('#hdTotalConImpuesto').val(totalConImpuesto.toFixed(2));

    $('#lblImporteCobro').text(totalConImpuesto.toFixed(2));
}

function ExtraerDetalle () {
    var detalle = '';
    var listaDetalle = [];
    var idDetalle = '0';
    var idproducto = '0';
    var idunidadmedida = '0';
    var codtipoproducto = '';
    var precio = 0;
    var cantidad = 0;
    var subtotal = 0;
    var i = 0;

    var itemsDetalle = $('#tableDetalle tbody tr');
    var countDetalle = itemsDetalle.length;

    if (countDetalle > 0){
        while(i < countDetalle){
            idDetalle = itemsDetalle[i].getAttribute('data-iddetalle');
            idproducto = itemsDetalle[i].getAttribute('data-idproducto');
            idunidadmedida = itemsDetalle[i].getAttribute('data-idunidadmedida');
            codtipoproducto = itemsDetalle[i].getAttribute('data-tipoproducto');
            precio = $(itemsDetalle[i]).find('.precio').text();
            cantidad = $(itemsDetalle[i]).find('.cantidad').text();
            subtotal = $(itemsDetalle[i]).find('.precio').text();
            var detalle = new Detalle (idDetalle, idproducto, idunidadmedida, codtipoproducto, cantidad, precio, subtotal);
            listaDetalle.push(detalle);
            ++i;
        }
    }

    detalle = JSON.stringify(listaDetalle);
    return detalle;
}

function Detalle (idDetalle, idproducto, idunidadmedida, codtipoproducto, cantidad, precio, subtotal) {
    this.idDetalle = idDetalle;
    this.idproducto = idproducto;
    this.idunidadmedida = idunidadmedida;
    this.codtipoproducto = codtipoproducto;
    this.cantidad = cantidad;
    this.precio = precio;
    this.subtotal = subtotal;
}

function Guardar () {
    var detalle = '';
    var Id = $('#hdIdPrimary').val();
    var idCliente = $('#hdIdCliente').val();
    var idFormaPago = $('#pnlFormaPago ul li a.active').attr('data-idformapago');
    var datosEnvio = '';
    if ($('#form1').valid()){
        detalle = ExtraerDetalle();
        if(detalle.length != 2 ){
            datosEnvio = 'fnPost=fnPost&hdIdPrimary=' + Id + '&hdIdCliente='+ idCliente + '&ddlFormaPago=' + idFormaPago + '&';
            datosEnvio += $('#frmRegistro').find('input:text, input:hidden, select').serialize() + '&';
            datosEnvio += $('#frmClientes').find('input:text, input:hidden, select').serialize() + '&';
            datosEnvio += $('#pnlFormaPago').find('input:text, input:hidden, select').serialize() + '&';
            datosEnvio += '&detalle=' + detalle;
            $.ajax({
                type: "POST",
                url: 'services/ventas/ventas-post.php',
                cache: false,
                data: datosEnvio,
                success: function(data){
                    console.log(data);
                    var datos = eval( "(" + data + ")" );
                    var Rpta = datos.rpta;
                    if (Number(Rpta) > 0){
                        MessageBox('<?php $translate->__('Venta realizada'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', '[<?php $translate->__('Aceptar'); ?>]', function () {
                            removeValidVenta();
                            BackToList();
                            BuscarDatos('1');
                        });
                    }
                },error: function(err){
                    console.log(err.responseText);
                }
            });
        }
    };
}

function addValidInfoProd () {
    $('#txtCantidad').rules('add', {
        required: true,
        number: true
    });
    $('#txtPrecioRef').rules('add', {
        required: true,
        number: true
    });
}

function removeValidInfoProd () {
    $('#txtCantidad').rules('remove');
    $('#txtPrecioRef').rules('remove');
}

function addValidVenta() {
    $('#txtSerieComprobante').rules('add', {
        required: true,
        maxlength: 30
    });

    $('#txtNroComprobante').rules('add', {
        required: true,
        maxlength: 30
    });

    $('#hdIdCliente').rules('add', {
        required: true,
        number: true,
        min: 1
    });
}

function removeValidVenta () {
    $('#txtSerieComprobante').rules('remove');
    $('#txtNroComprobante').rules('remove');
    $('#hdIdCliente').rules('remove');
}

function AddDetalle () {
    var idproducto = '0';
    var nombre = '';
    var idunidadmedida = '0';
    var unidadmedida = '';
    var codtipoproducto = '';
    var cantidad = 0;
    var precio = 0;
    var subtotal = 0;
    var content = '';

    if ($('#form1').valid()){
        idproducto = $('#hdIdProducto').val();
        codtipoproducto = $('#hdTipoProducto').val();
        nombre = $('#lblDescripProducto').text();
        idunidadmedida = $('#ddlUnidadMedida').val();
        unidadmedida = $('#ddlUnidadMedida option:selected').attr('data-simbolo');
        cantidad = Number($('#txtCantidad').val());
        precio = Number($('#txtPrecioRef').val());
        subtotal = cantidad * precio;

        content = '<tr data-iddetalle="0" data-idproducto="' + idproducto + '" data-idunidadmedida="' + idunidadmedida + '" data-tipoproducto="' + codtipoproducto + '">';
        content += '<td stye="width:60%" class="nombreProducto text-left">' + nombre + '</td>';
        content += '<td stye="width:10%" class="unidadmedida text-center">' + unidadmedida + '</td>';
        content += '<td stye="width:10%" class="cantidad text-right">' + cantidad.toFixed(3) + '</td>';
        content += '<td stye="width:10%" class="precio text-right">' + precio.toFixed(2) + '</td>';
        content += '<td stye="width:10%" class="subtotal text-right">' + subtotal.toFixed(2) + '</td>';
        content += '</tr>';

        $('#tableDetalle tbody').append(content);
        closeCustomModal('#pnlInfoProducto');

        CalcularTotal();

        $.Notify({style: {background: 'green', color: 'white'}, content: "<?php $translate->__('Item agregado correctamente.'); ?>"});
    }
}

function ShowPanelClientes () {
    $('#pnlClientes').fadeIn(400, function () {
        //$('#hdVista').val('LISTACLIENTES');
        if ($("#gvClientes .gridview .tile").length == 0)
            LoadClienteWithForm($('#txtSearchCliente').val(), '', '1');
    });
}

function setCliente (tipocliente, idcliente, nrodoc, descripcion, direccion) {
    $('#hdTipoCliente').val(tipocliente);
    $('#hdIdCliente').val(idcliente);
    $('#hdCodigoCliente').val('000');

    $('#pnlInfoCliente').attr('data-idcliente', idcliente);
    $('#pnlInfoCliente .info .descripcion').text(descripcion);
    $('#pnlInfoCliente .info .docidentidad').text(nrodoc);
    $('#pnlInfoCliente .info .direccion').text(direccion);

    setTipoDocIdentidad();

    $('#pnlClientes').fadeOut('400', function() {
        
    });
}

function ExtraerSimboloMoneda () {
    var valor = '';
    valor = $('#ddlMoneda option:selected').attr('data-simbolo');
    $('#lblMonedaCobro').text(valor);
}

function ExtraerTipoCambio (dropdown, textbox) {
    var valor = '';
    valor = $(dropdown + ' option:selected').attr('data-tipocambio');
    $(textbox).val(valor);
}

function ExtraerComisionTarjeta () {
    var valor = '';
    valor = $('#ddlNombreTarjeta option:selected').attr('data-comision');
    $('#txtComisionTarjeta').val(valor);
}

function setTipoDocIdentidad () {
    var iddocident = '0';
    iddocident = $('#tabClientes .menu a.active').parent().attr('data-iddocident');
    $('#hdIdDocIdent').val(iddocident);
}

function extraerNombresCliente (nameVal) {
    var nombres = '';
    var apellido = '';
    var apellido_paterno = '';
    var apellido_materno = '';
    var arrayName = [];
    var apellidoSplit = [];
    var cantidadEspacios = 0;
    var posicionCentral = 0;
    

    if ($('#tabDNI').is(':visible')){
        arrayName = nameVal.split(' ');
        cantidadEspacios = arrayName.length;
        posicionCentral = Math.floor(cantidadEspacios / 2);

        apellido_paterno = arrayName[posicionCentral];
        apellido_materno = nameVal.substring(nameVal.lastIndexOf(apellido_paterno));
        nombres = nameVal.substring(0, nameVal.length - apellido_materno.length);
        apellido_materno = apellido_materno.substring(apellido_materno.indexOf(' '));

        $('#hdTipoCliente').val('NA');
        
        $('#txtNombres').val(nombres.trim());
        $('#txtApePaterno').val(apellido_paterno.trim());
        $('#txtApeMaterno').val(apellido_materno.trim());
    }
    else {
        $('#hdTipoCliente').val('JU');
        $('#txtRazonSocial').val(nameVal);
    }
}

function CargarFiltroCategoria (idreferencia, idControl) {
    $(idControl + ' ul li:not(:first)').remove();
    $.ajax({
        type: "GET",
        url: "services/categorias/categorias-search.php",
        cache: false,
        data: "idref=" + idreferencia,
        success: function(data){
            i = 0;
            datos = eval( "(" + data + ")" );
            countDatos = datos.length;
            while(i < countDatos){
                eLi = $('<li></li>');
                aLink = $('<a></a>')
                aLink.attr({'href':'#', 'rel':datos[i].id});
                content = $('<h3 class="fg-white"></h3>')
                content.text(datos[i].value);
                aLink.append(content).appendTo(eLi).on('click', function (event) {
                    event.preventDefault();

                    setActiveCategoria(this);
                    if (idreferencia == '0'){
                        $('#hdIdCategoria').val($(this).attr('rel'));
                        $('#hdIdSubCategoria').val('0');
                        if ($(this).attr('rel') != '0')
                            CargarSubCategorias(this);
                    }
                    else
                        $('#hdIdSubCategoria').val($(this).attr('rel'));
                    BuscarProductos('1');
                });
                $(idControl + ' ul').append(eLi);
                ++i;
            }
        }
    });
}

function setActiveCategoria (obj) {
    $(obj).parent().parent().find('a').removeClass('active');
    $(obj).addClass('active');
}

function CargarSubCategorias (obj) {
    setActiveCategoria('#lstSubCategorias li:first a');
    CargarFiltroCategoria($(obj).attr('rel'), '#lstSubCategorias');
}

function BackToList () {
    $('#btnBuscarItems, #btnFormaPago, #btnGuardar, #btnCancelar').addClass('oculto');
    $('#btnNuevo').removeClass('oculto');
    $('#pnlForm').fadeOut(500, function () {
        $('#pnlListado').fadeIn(500, function () {
            
        });
    });
}

function BackToForm () {
    $('#pnlProductos').fadeOut(500, function () {
        $('#pnlForm').fadeIn(500, function () {
            
        });
    });
}

function MostrarPanelItems () {
    //clearSelection();
    $('#btnBuscarItems, #btnFormaPago, #btnGuardar, #btnCancelar').addClass('oculto');
    $('#btnMoreFilter').removeClass('oculto');
    $('#pnlForm').fadeOut(400, function () {
        $('#pnlProductos').fadeIn(400, function () {
            if ($("#gvProductos .tile-area .tile").length == 0){
                CargarFiltroCategoria('0', '#lstCategorias');
                listarProductos('1');
            }
        });
    });
}

function ExtraerSimboloMoneda () {
    var valor = '';
    valor = $('#ddlMoneda option:selected').attr('data-simbolo');
    $('#lblMonedaCobro').text(valor);
}

function GoToEdit () {
    Limpiar();
    $('#pnlListado').fadeOut(500, function () {
        $('#btnNuevo, #btnLimpiarSeleccion, #btnEliminar, #btnEditar').addClass('oculto');
        $('#btnBuscarItems, #btnFormaPago, #btnGuardar, #btnCancelar').removeClass('oculto');
        $('#pnlForm').fadeIn(500, function () {
            var itemSelected = $('#gvDatos .gridview .dato.selected');
            if (itemSelected.length > 0){
                var idItem = itemSelected[0].getAttribute('rel');
                $.ajax({
                    type: "GET",
                    url: '',
                    cache: false,
                    data: 'id=' + idItem,
                    success: function (data) {
                        var datos = eval( "(" + data + ")" );
                        var foto = datos[0].tm_foto;

                        //$('#hdIdPrimary').val(datos[0].tm_idpersonal);
                    }
                });
            }
            $('#txtCodigo').focus();
        });
    });
}

function listarProductos (pagina) {
    precargaExp('#gvProductos', true);
    datos = {tipobusqueda:'00',idcategoria: $('#hdIdCategoria').val(), idsubcategoria: $('#hdIdSubCategoria').val(), criterio: $('#txtSearchProd').val(), pagina: pagina};
    $.ajax({
        url: 'services/productos/productos-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: datos,
        success: function (data) {
            var count = data.length;
            var i = 0;
            var strhtml = '';
            var imagen = '';
            var cssbgtile = '';
            var cssdisplay = '';

            if (count > 0) {
                while(i < count){
                    if (data[i].tm_foto == 'no-set'){
                        imagen = 'images/food-48.png';
                        cssbgtile = ' bg-olive';
                        cssdisplay = 'icon';
                    }
                    else {
                        imagen = data[i].tm_foto;
                        cssdisplay = 'image';
                    }

                    strhtml += '<div class="tile dato double' + cssbgtile + '" data-idproducto="' + data[i].tm_idproducto + '">';
                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content ' + cssdisplay + '">';
                    strhtml += '<img src="' + imagen + '" alt="" />';;
                    strhtml += '</div>';
                    strhtml += '<div class="tile-status bg-dark opacity">';
                    strhtml += '<span class="label">' + data[i].tm_nombre + '</span>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    ++i;
                }
                $('#gvProductos .tile-area').on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPageProd').val();
                        listarProductos(pagina);
                    }
                });
                $('#hdPageProd').val(Number($('#hdPageProd').val()) + 1);
                if (pagina == '1')
                    $('#gvProductos .tile-area').html(strhtml);
                else
                    $('#gvProductos .tile-area').append(strhtml);
            }
            else {
                if (pagina == '1')
                    $('#gvProductos').html('<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>');
            }
            precargaExp('#gvProductos', false);
        }, error: function (err) {
            console.log(err.responseText);
        }
    });
}

function BuscarDatos (pagina) {
    precargaExp('#gvDatos', true);

    $.ajax({
        url: 'services/ventas/ventas-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function (data) {
            var count = data.length;
            var i = 0;
            var strhtml = '';

            if (count > 0) {
                while(i < count){
                    strhtml += '<div class="tile double shadow double-vertical bg-green" data-id="' + data[i].tm_idventa + '">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10">';
                    strhtml += '<h2 class="fg-white no-margin">' + ConvertMySQLDate(data[i].tm_fecha_emision) + '</h2>';
                    strhtml += '<h4 class="fg-white">' + data[i].tm_vserie_documento + '-' + data[i].tm_vnumero_documento + '</h4>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="text-background">';
                    strhtml += '<h2 class="fg-white no-margin">' + data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2) + '</h2>';
                    strhtml += '</div>';
                    strhtml += '<div class="tile-status bg-dark opacity">';
                    strhtml += '<span class="label">' + data[i].Cliente + '</span>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    ++i;
                }
                $('#gvDatos .tile-area').on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPage').val();
                        BuscarDatos(pagina);
                    }
                });
                $('#hdPage').val(Number($('#hdPage').val()) + 1);
                if (pagina == '1')
                    $('#gvDatos .tile-area').html(strhtml);
                else
                    $('#gvDatos .tile-area').append(strhtml);
            }
            else {
                if (pagina == '1')
                    $('#gvDatos .tile-area').html('<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>');
            }
            precargaExp('#gvDatos', false);
        }
    });
}