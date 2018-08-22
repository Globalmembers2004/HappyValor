<?php
header('Content-type: text/javascript');
require('../../../common/class.translation.php');
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);
?>
$(function () {
    BuscarDatos(1);

    cargarDatePicker('#txtFecha', function (dateText, inst) {
        $('#txtFechaRecepcion').focus();
    });

    cargarDatePicker('#txtFechaRecepcion', function (dateText, inst) {
        $('#txtSerieComprobante').focus();
    });

    $('#btnStockAlmacen').on('click', function(event) {
        event.preventDefault();
        mostrarPanel('#pnlAdminAlmacen', '?pag=admin&subpag=almacen&op=list');
    });

    $('#btnCancelar, #btnBackList').on('click', function (event) {
        event.preventDefault(); 
        resetForm('form1');
        BackToList();
        $('#tableDetalle tbody').html('');
        $('#btnGuardar, #btnBuscarItems, #btnCancelar').addClass('oculto');
        $('#btnNuevo').removeClass('oculto');
        return false;
    });

    $('#btnBackForm').on('click', function (event) {
        event.preventDefault();
        $('#btnGuardar, #btnBuscarItems, #btnCancelar').removeClass('oculto');
        $('#btnMoreFilter').addClass('oculto');
        BackToForm();
        return false;
    });

    $('#btnIngreso').on('click', function (event) {
        event.preventDefault();
        resetForm('form1');
        GoToEdit();
    });

    $('#btnBuscarItems').on('click', function (event) {
        event.preventDefault();
        MostrarPanelItems();
    });

    $('#pnlProductos .title-window').on('click', 'button', function (event) {
        var codtipoproducto = '';
        
        event.preventDefault();

        codtipoproducto = $(this).attr('data-item');
        
        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');
        
        if (codtipoproducto == '00'){
            $('#precargaInsu').fadeIn(function () {
                if ($('#gvInsumo .tile-area .tile').length == 0)
                    listarInsumos();
            });
            $('#precargaProd').hide();
        }
        else {
            $('#precargaProd').fadeIn(function () {
                if ($('#gvProductos .tile-area .tile').length == 0)
                    listarProductos('1');
            });
            $('#precargaInsu').hide();
        }

        $('#hdTipoProducto').val(codtipoproducto);
    });

    $('#pnlInfoProveedor').on('click', function(event) {
        event.preventDefault();
        ShowPanelProveedor();
    });

    $('#btnInfoImporte').on('click', function(event) {
        event.preventDefault();

        if (!$(this).hasClass('active')){
            $(this).addClass('active');

            $('#pnlInfoImporte').stop(true, true)
            .show( "clip",{direction: "vertical"}, 400 )
            .animate({ opacity : 1 }, { duration: 400, queue: false });
        }
        else {
            $(this).removeClass('active');

            $('#pnlInfoImporte').stop(true, true)
            .hide( "clip",{direction: "vertical"}, 400 )
            .animate({ opacity : 0 }, { duration: 400, queue: false });
        }
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
        if ($('#btnArticulo').hasClass('success'))
            listarProductos('1');
        else
            listarInsumos('1');
    });

    $('#btnExitProvider').on('click', function(event) {
        event.preventDefault();
        $('#pnlProveedor').fadeOut(400);
    });

    $('#gvProveedor .items-area').on('click', '.list', function(event) {
        var idproveedor = '0',
            nrodoc = '',
            descripcion = '',
            direccion = '';

        event.preventDefault();
        
        idproveedor = $(this).attr('data-idproveedor');
        nrodoc = $(this).find('main p .docidentidad').text();
        descripcion = $(this).find('main p .descripcion').text();
        direccion = $(this).find('main p .direccion').text();

        setProveedor(idproveedor, nrodoc, descripcion, direccion);
    });

    $('#txtSearchProveedor').on('keyup', function(event) {
        LoadProveedorWithForm($('#txtSearchProveedor').val(), '1');
        extraerNombresProveedor($(this).val());
    });

    $('#btnSearchProveedor').on('click', function(event) {
        event.preventDefault();
        LoadProveedorWithForm($('#txtSearchProveedor').val(), '1');
    });

    $('#btnNewProveedor').on('click', function(event) {
        event.preventDefault();

        LimpiarFormProveedor();
        $('#btnSaveProveedor, #btnCancelProveedor').removeClass('oculto');
        $('#gvProveedor').hide();
        $('#frmProveedor').show(400, function() {
            
        });
    });

    $('#btnSaveProveedor').on('click', function(event) {
        var nrodoc = '';
        var descripcion = '';
        var direccion = '';
        
        event.preventDefault();

        nrodoc = $('#txtRucEmpresa').val();
        direccion = $('#txtDireccionJur').val();    
        descripcion = $('#txtRazonSocial').val();

        $('#hdCodigoProveedor').val(nrodoc);

        setProveedor('0', nrodoc, descripcion, direccion);
    });

    $('#btnCancelProveedor').on('click', function(event) {
        event.preventDefault();
        LoadProveedorWithForm($('#txtSearchProveedor').val(), '1');
    });

    $('#gvInsumo .tile-area').on('click', '.tile', function(event) {
        var idinsumo = '0';

        event.preventDefault();

        idinsumo = $(this).attr('data-idproducto');

        LimpiarInputProducto();
        $('#hdIdProducto').val(idinsumo);
        $('#lblDescripProducto').text($(this).find('p strong').text());
        listarPresentaciones(idinsumo);
        openCustomModal('#pnlInfoProducto');
    });

    $('#gvProductos .tile-area').on('click', '.tile', function(event) {
        event.preventDefault();

        LimpiarInputProducto();
        $('#hdIdProducto').val($(this).attr('data-idproducto'));
        $('#lblDescripProducto').text($(this).find('span.label').text());
        openCustomModal('#pnlInfoProducto');
    });

    $('#btnProductoAdd').on('click', function(event) {
        event.preventDefault();
        AddDetalle();
    });

    $('#btnHidePnlInfoProducto').on('click', function (event) {
        event.preventDefault();

        closeCustomModal('#pnlInfoProducto');
        removeValidInfoProd();
    });

    $('#btnMoreFilter').on('click', function (event) {
        toggleSlideButton(this, '#pnlCategoria', {
            msje_active: '<?php $translate->__('Mostrar filtros de b&uacute;squeda'); ?>',
            icon_active: 'images/find.png',
            msje_deactive: '<?php $translate->__('Ocultar filtros de b&uacute;squeda'); ?>',
            icon_deactive: 'images/find-remove.png'
        });
        return false;
    });

    $('#btnLimpiarSeleccion').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('oculto');
        if ($('#pnlListado').is(':visible')){
            $('#gvDatos .tile-area .tile.selected').removeClass('selected');
        }
        else {
            $('#tableDetalle tbody tr.selected').removeClass('selected');
            $('#btnQuitarItem').addClass('oculto');
            $('#btnBuscarItems').removeClass('oculto');
        }
    });

    $('#tableDetalle tbody').on('click', 'tr', function(event) {
        event.preventDefault();
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            if ($('#tableDetalle tbody tr.selected').length == 0){
                $('#btnQuitarItem, #btnLimpiarSeleccion').addClass('oculto');
                $('#btnBuscarItems').removeClass('oculto');
            }
        }
        else {
            $(this).addClass('selected');
            $('#btnQuitarItem, #btnLimpiarSeleccion').removeClass('oculto');
            $('#btnBuscarItems').addClass('oculto');
        }
    });

    $('#btnQuitarItem').on('click', function(event) {
        event.preventDefault();
        $('#tableDetalle tbody tr.selected').fadeOut('400', function() {
            $(this).remove();
        });
        $('#btnQuitarItem, #btnLimpiarSeleccion').addClass('oculto');
        $('#btnBuscarItems').removeClass('oculto');
        CalcularTotal();
    });

    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        Guardar();
    });

    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate
    });
});

function LimpiarInfoProveedor () {
    $('#pnlInfoProveedor .info .descripcion').text('Elegir proveedor...');
    $('#pnlInfoProveedor .info .docidentidad').text('');
    $('#pnlInfoProveedor .info .direccion').text('');
}

function LimpiarFormProveedor () {
    $('#txtRazonSocial').val('');
    $('#txtRucEmpresa').val('');
    $('#txtDireccionJur').val('');
}

function Limpiar () {
    $('#txtFecha').val(GetToday());
    $('#txtFechaRecepcion').val(GetToday());
    $('#ddlTipoComprobante')[0].selectedIndex = 0;
    $('#ddlFormaPago')[0].selectedIndex = 0;
    $('#txtSerieComprobante').val('');
    $('#txtNroComprobante').val('');
    LimpiarInfoProveedor();
    $('#lblImporteCobro').text('0.00');
}

function LimpiarInputProducto () {
    $('#ddlUnidadMedida')[0].selectedIndex = 0;
    $('#txtCantidad').val('');
    //$('#txtPrecioRef').val('');
    addValidInfoProd();
}

function listarPresentaciones (idinsumo) {
    $.ajax({
        type: "GET",
        url: 'services/presentacion/presentacion-search.php',
        cache: false,
        data: 'tipobusqueda=1&idinsumo=' + idinsumo,
        success: function(data){
            var datos = eval( "(" + data + ")" );
            var countDatos = datos.length;
            var i = 0;
            var content = '';
            if (countDatos > 0){
                while(i < countDatos){
                    content += '<option data-medida="' + datos[i].td_medida + '" data-idunidadmedida="' + datos[i].tm_idunidadmedida + '" value="' + datos[i].tm_idpresentacion + '">' + datos[i].Presentacion + ' DE ' + datos[i].td_medida + ' ' + datos[i].UnidadMedida + '</option>';
                    ++i;
                }
            }
            else {
                if ($('#hdTipoProducto').val() == '00')
                    content += '<option data-medida="0" data-idunidadmedida="0" value="0">NO SE HAN CONFIGURADO PRESENTACIONES</option>';
                else
                    content += '<option data-medida="1" data-idunidadmedida="19" value="1">UNIDAD</option>';
            }
            $('#ddlPresentacion').html(content);
        }
    });
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
            if (list[i].innerText != null)
                list[i].innerText  = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
            else
                list[i].textContent = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
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
    var idpresentacion = '0';
    var idunidadmedidapre = '0';
    var medidapre = '0';
    var idunidadmedida = '0';
    var codtipoproducto = '';
    var cantidad = 0;
    //var precio = 0;
    //var subtotal = 0;
    var i = 0;

    var itemsDetalle = $('#tableDetalle tbody tr');
    var countDetalle = itemsDetalle.length;

    if (countDetalle > 0){
        while(i < countDetalle){
            idDetalle = itemsDetalle[i].getAttribute('data-iddetalle');
            idproducto = itemsDetalle[i].getAttribute('data-idproducto');
            idpresentacion = itemsDetalle[i].getAttribute('data-idpresentacion');
            idunidadmedidapre = itemsDetalle[i].getAttribute('data-idunidadmedidapre');
            medidapre = itemsDetalle[i].getAttribute('data-medidapre');
            idunidadmedida = itemsDetalle[i].getAttribute('data-idunidadmedida');
            codtipoproducto = itemsDetalle[i].getAttribute('data-tipoproducto');
            cantidad = $(itemsDetalle[i]).find('.cantidad').text();
            //precio = $(itemsDetalle[i]).find('.precio').text();
            //subtotal = $(itemsDetalle[i]).find('.precio').text();
            var detalle = new Detalle (idDetalle, idproducto, idpresentacion, idunidadmedidapre, medidapre, idunidadmedida, codtipoproducto, cantidad);
            listaDetalle.push(detalle);
            ++i;
        }
    }

    detalle = JSON.stringify(listaDetalle);
    return detalle;
}

function Detalle (idDetalle, idproducto, idpresentacion, idunidadmedidapre, medidapre, idunidadmedida, codtipoproducto, cantidad) {
    this.idDetalle = idDetalle;
    this.idproducto = idproducto;
    this.idpresentacion = idpresentacion;
    this.idunidadmedidapre = idunidadmedidapre;
    this.medidapre = medidapre;
    this.idunidadmedida = idunidadmedida;
    this.codtipoproducto = codtipoproducto;
    this.cantidad = cantidad;
    //this.precio = precio;
    //this.subtotal = subtotal;
}

function BuscarDatos (pagina) {
    $.ajax({
        type: 'GET',
        url: 'services/almacen/kardex-search.php',
        cache: false,
        dataType: 'json',
        data: 'tipobusqueda=1&pagina='+pagina,
    })
    .done(function (data) {
        var countdata = 0;
        var i = 0, x = 0;
        var strhtml = '';

        countdata = data.length;

        if (countdata > 0){
            while(i < countdata){
                strhtml += '<tr>';
                strhtml += '<th style="width:5%; padding-left:10px" class="text-left">' + (++x) + '</th>';
                strhtml += '<td style="width:30%; text-transform: uppercase;" class="nombreInsumo">' + data[i].insumo + '</td>';
                strhtml += '<td style="width:25%;" class="nombreInsumo">' + data[i].almacen + '</td>';
                strhtml += '<td style="width:10%" class="unidadmedida">' + data[i].umedida + '</td>';
                strhtml += '<td style="width:10%" class="cantidad text-right">' + Number(data[i].ingreso).toFixed(3) + '</td>';
                strhtml += '<td style="width:10%" class="cantidad text-right">' + Number(data[i].salida).toFixed(3) + '</td>';
                strhtml += '<td style="width:10%" class="cantidad text-right">' + Number(data[i].stock).toFixed(3) + '</td>';
                strhtml += '</tr>';
                ++i;
            };
        };
        $('#tableDatos tbody').html(strhtml);
    })
    .fail(function(err) {
        console.log(err);
    })
    .always(function() {
        console.log("complete");
    });
}

function Guardar () {
    var detalle = '';
    var Id = $('#hdIdPrimary').val();
    
    var datosEnvio = '';
    
    detalle = ExtraerDetalle();

    datosEnvio = 'fnPost=fnPost&hdIdPrimary=' + Id + '&';
    datosEnvio += $('#frmRegistro').find('input:text, input:hidden, select').serialize() + '&';
    datosEnvio += $('#frmProveedor').find('input:text, input:hidden, select').serialize();
    datosEnvio += '&detalle=' + detalle;
    console.log(datosEnvio);
    $.ajax({
        type: "POST",
        url: 'services/almacen/kardex-post.php',
        cache: false,
        data: datosEnvio,
        success: function(data){
            console.log(data);
            var datos = eval( "(" + data + ")" );
            var Rpta = datos.rpta;
            if (Number(Rpta) > 0){
                MessageBox('<?php $translate->__('Ingreso a almacen realizado'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', '[<?php $translate->__('Aceptar'); ?>]', function () {
                    BackToList();
                    BuscarDatos('1');
                    $('#tableDetalle tbody').html('');
                });
            }
        }, error: function(err){
            console.log(err.responseText);
        }
    });
}

function addValidInfoProd () {
    $('#txtCantidad').rules('add', {
        required: true,
        number: true
    });
    /*$('#txtPrecioRef').rules('add', {
        required: true,
        number: true
    });*/
}
function removeValidInfoProd () {
    $('#txtCantidad').rules('remove');
    //$('#txtPrecioRef').rules('remove');
}

function AddDetalle () {
    var idproducto = '0';
    var nombre = '';
    var idpresentacion = '0';
    var presentacion = '0';
    var idunidadmedidapre = '0';
    var medidapre = '0';
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
        idpresentacion = $('#ddlPresentacion').val();
        presentacion = $('#ddlPresentacion option:selected').text();
        idunidadmedidapre = $('#ddlPresentacion option:selected').attr('data-idunidadmedida');
        medidapre = $('#ddlPresentacion option:selected').attr('data-medida');
        idunidadmedida = $('#ddlUnidadMedida').val();
        unidadmedida = $('#ddlUnidadMedida option:selected').attr('data-simbolo');
        cantidad = Number($('#txtCantidad').val());
        //precio = Number($('#txtPrecioRef').val());
        //subtotal = cantidad * precio;

        content = '<tr data-iddetalle="0" data-idproducto="' + idproducto + '" data-idpresentacion="' + idpresentacion + '" data-idunidadmedidapre="' + idunidadmedidapre + '" data-medidapre="' + medidapre + '" data-idunidadmedida="' + idunidadmedida + '" data-tipoproducto="' + codtipoproducto + '">';
        content += '<td class="nombreProducto">' + nombre + '</td>';
        content += '<td class="presentacion">' + presentacion + '</td>';
        content += '<td class="unidadmedida">' + unidadmedida + '</td>';
        content += '<td class="cantidad text-right">' + cantidad.toFixed(3) + '</td>';
        content += '</tr>';

        $('#tableDetalle tbody').append(content);
        closeCustomModal('#pnlInfoProducto');

        CalcularTotal();

        $.Notify({style: {background: 'green', color: 'white'}, content: "<?php $translate->__('Item agregado correctamente.'); ?>"});
    }
}

function ShowPanelProveedor () {
    $('#pnlProveedor').fadeIn(400, function () {
        if ($("#gvProveedor .gridview .tile").length == 0)
            LoadProveedorWithForm($('#txtSearchProveedor').val(), '1');
    });
}

function extraerNombresProveedor (nameVal) {
    $('#txtRazonSocial').val(nameVal);
}

function setProveedor (idproveedor, nrodoc, descripcion, direccion) {
    $('#hdIdProveedor').val(idproveedor);
    $('#hdCodigoProveedor').val('000');

    $('#pnlInfoProveedor').attr('data-idproveedor', idproveedor);
    $('#pnlInfoProveedor .info .descripcion').text(descripcion);
    $('#pnlInfoProveedor .info .docidentidad').text(nrodoc);
    $('#pnlInfoProveedor .info .direccion').text(direccion);

    $('#pnlProveedor').fadeOut('400', function() {
        
    });
}

function BackToList () {
    $('#btnBuscarItems, #btnGuardar, #btnCancelar').addClass('oculto');
    $('#btnIngreso, #btnOrdenCompra, #btnStockAlmacen').removeClass('oculto');
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
    $('#btnBuscarItems, #btnGuardar, #btnCancelar').addClass('oculto');
    $('#btnMoreFilter').removeClass('oculto');
    $('#pnlForm').fadeOut(400, function () {
        $('#pnlProductos').fadeIn(400, function () {
            if ($("#gvProductos .tile-area .tile").length == 0){
                listarInsumos('1');
            }
        });
    });
}

function GoToEdit () {
    Limpiar();
    $('#pnlListado').fadeOut(500, function () {
        $('#btnIngreso, #btnOrdenCompra, #btnStockAlmacen').addClass('oculto');
        $('#btnBuscarItems, #btnGuardar, #btnCancelar').removeClass('oculto');
        $('#pnlForm').fadeIn(500, function () {
            var itemSelected = $('#gvDatos .gridview .dato.selected');
            if (itemSelected.length > 0){
                var idItem = itemSelected[0].getAttribute('rel');
                $.ajax({
                    type: "GET",
                    //url: '<?php //echo $path_URLEditService; ?>',
                    url:'',
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

function listarInsumos (pagina) {
    precargaExp('#gvInsumo', true);
    
    $.ajax({
        url: 'services/insumos/insumos-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            criterio: $('#txtSearchProd').val(),
            pagina: pagina
        },
        success: function (data) {
            var count = data.length;
            var i = 0;
            var strhtml = '';
            if (count > 0) {
                while(i < count){
                    strhtml += '<div class="tile double dato bg-olive" data-idproducto="' + data[i].tm_idinsumo + '">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idinsumo + '" />';
                    strhtml += '<p class="fg-white margin10"><strong>' + data[i].tm_nombre + '</strong></p>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    ++i;
                }
                $('#gvInsumo .tile-area').on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPageInsu').val();
                        listarInsumos(pagina);
                    }
                });
                $('#hdPageInsu').val(Number($('#hdPageInsu').val()) + 1);
                if (pagina == '1')
                    $('#gvInsumo .tile-area').html(strhtml);
                else
                    $('#gvInsumo .tile-area').append(strhtml);
            }
            else {
                if (pagina == '1')
                    $('#gvInsumo').html('<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>');
            }
            precargaExp('#gvInsumo', false);
        },error: function(err){
            console.log(err.responseText);
        }
    });
}

function listarProductos (pagina) {
    precargaExp('#gvProductos', true);

    $.ajax({
        url: 'services/productos/productos-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'00',
            idcategoria: $('#hdIdCategoria').val(),
            idsubcategoria: $('#hdIdSubCategoria').val(),
            criterio: $('#txtSearchProd').val(),
            pagina: pagina
        },
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
        }
    });
}