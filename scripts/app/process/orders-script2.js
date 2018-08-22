/** javascript **/


$(window).load(function () {
    var startTime, endTime;
    var longpress = false;

    MostrarMesas($('#sliderAmbientes ul li:first').addClass('visible').attr('data-idcontainer'));
    makeCuentaDroppable($('#sliderCuentas ul li:first').addClass('visible').attr('data-idcontainer'));
    initEventCuentaSlider();
    setTipoDocIdentidad();
    ComprobarApertura();
    //gridEvents('#sliderAmbientes .mesas', '.dato');

    $('.actionbar-edit').on('click', 'div[data-action="more"]', function(event) {
        event.preventDefault();
        
    });
    
    setSpecialTab('#pnlFormaPago', function () {
        
    });

    setSpecialTab('#tabClientes', function () {
        extraerNombresCliente($('#txtSearchCliente').val());
        setTipoDocIdentidad();
    });

    configValidate();

    $('#btnCobrarPedido').on('click', function(event) {
        event.preventDefault();
        if (Number($('#lblImporteCuenta').text()) > 0){
            addValidVenta();
            openCustomModal('#pnlVenta');
            $('#lblMonedaCobro').text($('#lblMonedaCuenta').text());
            habilitarControl('#btnGenerarVenta', true);
            $('#btnGenerarVenta').addClass('success');
            LimpiarVenta();
        }
        else {
            MessageBox('Importe no v&aacute;lido', 'Para proceder a cobrar, este importe debe ser mayor a cero.', '[Aceptar]', function () {
            });
        };
    });

    $('#btnGenerarVenta').on('click', function(event) {
        event.preventDefault();
        CobrarPedido();
    });

    $('#btnDividirCuenta').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#pnlDivision');
    });

    $('#btnDividir').on('click', function(event) {
        var nroCuentas = 0;
        
        event.preventDefault();

        nroCuentas = Number($('#txtNroCuentas').val());

        buildSliderCuenta(nroCuentas, function () {
            $('#btnTodoUnaCuenta').addClass('oculto');
            closeCustomModal('#pnlDivision');
            dividirCuentas();
            initEventCuentaSlider();
        });
    });

    /*$('#sliderAmbientes').on('contextmenu', '.dato', function(event) {
        event.preventDefault();
        selectMesas(this);
        $('#hdTipoAgrupacion').val('00');
    });*/

    /*$('#sliderAmbientes').on('click', '.dato', function (event) {
        if (longpress){
            selectMesas(this);
            $('#hdTipoAgrupacion').val('00');
            
        }
        else {
            var IdMesa = $(this).attr('data-idmesa');
            var IdAtencion = $(this).attr('data-idatencion');
            var EstadoMesa = $(this).attr('data-state');
            var TipoUbicacion = $(this).attr('data-tipoubicacion');

            $('#hdIdPrimary').val(IdAtencion);
            $('#hdIdMesa').val(IdMesa);
            $('#hdEstadoMesa').val(EstadoMesa);
            $('#hdTipoUbicacion').val(TipoUbicacion);               

            listarDetallePedido(IdAtencion);
            selectOnClickMesa();
            $('#hdTipoAgrupacion').val('00');
            
        };
        return false;
    }).disableSelection();*/

    
    $('#sliderAmbientes .mesas').on('click touchend', '.dato', function(event) {
        event.preventDefault();

        var parent;
        var element_dataid = '0';

        parent = $(this);

        if (event.type == 'touchend'){
            endTime = new Date().getTime();
            longpress = (endTime - startTime < 300) ? false : true;
        };

        if (isScroll === false){
            if (longpress){
                showAppBar('#sliderAmbientes .mesas', true);
                setSelecting('#sliderAmbientes .mesas', 'true', 'some');
                selectMesas(this);
                //doRippleEffect(this);
            }
            else {
                if ($('#sliderAmbientes .mesas').attr('data-multiselect') == 'true') {
                    selectMesas(this);
                }
                else {
                    var IdMesa = parent.attr('data-idmesa');
                    var IdAtencion = parent.attr('data-idatencion');
                    var EstadoMesa = parent.attr('data-state');
                    var TipoUbicacion = parent.attr('data-tipoubicacion');

                    if (!$(this).hasClass('selected')){
                        $('#hdIdPrimary').val(IdAtencion);
                        $('#hdIdMesa').val(IdMesa);
                        $('#hdEstadoMesa').val(EstadoMesa);
                        $('#hdTipoUbicacion').val(TipoUbicacion);               

                        listarDetallePedido(IdAtencion);
                        selectOnClickMesa();
                        $('#hdTipoAgrupacion').val('00');
                    };
                };
                // else {
                //     element_dataid = parent.attr('data-idmodel');
                //     FiltrarPorIdItem(element_dataid);
                // };
            };
        };
    }).disableSelection();

    $('#sliderAmbientes').on('mousedown touchstart', '.dato', function (event) {
        startTime = new Date().getTime();
    });

    $('#sliderAmbientes').on('mouseup', '.dato', function (event) {
        endTime = new Date().getTime();
        longpress = (endTime - startTime < 300) ? false : true;
    });
    
    habilitarLink('#sliderAmbientes .control_prev', false);

    $('#sliderAmbientes').on('click', '.control_prev', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')){
            $('#sliderAmbientes ul li:visible').fadeOut(300, function () {
                $(this).removeClass('visible');
                
                $(this).prev().fadeIn(300, function () {
                    var flag = false;
                    var idcontainer = '0';
                    
                    flag = $(this).is(':first-child');
                    idcontainer = $(this).attr('data-idcontainer');

                    $(this).addClass('visible');
                    
                    if ($(this).find('.dato').length == 0)
                        MostrarMesas(idcontainer);
                    
                    habilitarLink('#sliderAmbientes a.control_prev', !flag);
                    habilitarLink('#sliderAmbientes a.control_next', true);
                });
            });
        };
    });

    $('#sliderAmbientes').on('click', '.control_next', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')){
            $('#sliderAmbientes ul li:visible').fadeOut(300, function () {
                $(this).removeClass('visible');
                
                $(this).next().fadeIn(300, function () {
                    var flag = false;
                    var idcontainer = '0';
                    
                    flag = $(this).is(':last-child');
                    idcontainer = $(this).attr('data-idcontainer');
                    
                    $(this).addClass('visible');

                    if ($(this).find('.dato').length == 0)
                        MostrarMesas(idcontainer);
                    
                    habilitarLink('#sliderAmbientes a.control_next', !flag);
                    habilitarLink('#sliderAmbientes a.control_prev', true);
                });
            });
        };
    });

    $('#pnlProductos .sectionHeader').on('click', 'button', function(event) {
        var targedId = '';
        var tipomenudia = '';

        event.preventDefault();

        tipomenudia = $(this).attr('data-tipomenu');

        if (tipomenudia == '03')
            targedId = '#pnlGrupos';
        else {
            targedId = '#pnlIndividual';
            if (tipomenudia == '00'){
                $('#gvCartaProd').show();
                $('#gvMenuProd').hide();
            }
            else {
                $('#gvMenuProd').show();
                $('#gvCartaProd').hide();
            };
            
            if ($('#pnlIndividual .tile.selected').length > 0)
                $('#btnAddOrder').removeClass('oculto');
            else
                $('#btnAddOrder').addClass('oculto');
        };

        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');

        $('#pnlProductos .sectionContent > section').hide();
        
        $(targedId).fadeIn(400, function() {
            if (tipomenudia == '03')
                ListarGrupos('1');
            else
                BuscarProductos('1');
        });
    });

    $('#gvGrupos').on('click', '.tile > .tile_true_content', function(event) {
        var idgrupo = '0';
        var tile;
        var inputSpinner;

        event.preventDefault();

        tile = $(this).parent();
        inputSpinner = tile.find('.input_spinner');
        
        idgrupo = tile.attr('data-idProducto');
        
        $('#hdIdGrupo').val(idgrupo);
        
        tile.siblings('.selected').find('.input_spinner').hide();
        tile.siblings('.selected').find('input:checkbox').each(function() {
            this.checked = false;
        });

        tile.siblings('.selected').removeClass('selected');
        tile.addClass('selected').find('input:checkbox')[0].checked = true;
        inputSpinner.show();

        ListarSecciones(idgrupo);
    });

    $('#gvSecciones').on('click', '.tile > .tile_true_content', function(event) {
        var tile;
        var selectorButtons = '#btnClearSelection';

        event.preventDefault();

        tile = $(this).parent();

        $('#btnAddOrder').removeClass('oculto');
        tile.siblings('.selected').removeClass('selected');
        tile.addClass('selected').find('input:checkbox')[0].checked = true;
        return false;
    });

    $('#pnlIndividual').on('click', '.tile > .tile_true_content', function(event) {
        var tile;
        var inputSpinner;

        event.preventDefault();

        tile = $(this).parent();
        inputSpinner = tile.find('.input_spinner');

        if (tile.hasClass('selected')){
            tile.find('input:checkbox')[0].checked = false;
            tile.removeClass('selected');
            if (tile.siblings('.selected').length > 0){
                $('#btnViewOrder').addClass('oculto');
                $('#btnClearSelection, #btnAddOrder').removeClass('oculto');
            }
            else {
                $('#btnViewOrder').removeClass('oculto');
                $('#btnClearSelection, #btnAddOrder').addClass('oculto');
            }
            inputSpinner.hide();
        }
        else {
            tile.find('input:checkbox')[0].checked = true;
            tile.addClass('selected');
            $('#btnViewOrder').addClass('oculto');
            $('#btnClearSelection, #btnAddOrder').removeClass('oculto');
            inputSpinner.show();
        };

        return false;
    });

    $('#pnlProductos').on('blur', '.inputCantidad', function(event) {
        event.preventDefault();
        if ($(this).val().trim().length == 0)
            $(this).val('0');
        else
            $(this).val(Number($(this).val()));
    }).numeric(".");

    $('#pnlProductos').on('click', 'button.up', function(event) {
        event.preventDefault();
        var inputSpinText = $(this).parent().parent().find('input');
        var idProducto = $(this).parent().parent().parent().attr('data-idProducto');
        var stock = Number(inputSpinText.val());
        
        if (stock < 999){
            stock = stock + 1;
            inputSpinText.val(stock);
        };

        return false;
    });

    $('#pnlProductos').on('click', 'button.down', function(event) {
        var inputSpinText = $(this).parent().parent().find('input');
        var idProducto = $(this).parent().parent().parent().attr('data-idProducto');
        var stock = Number(inputSpinText.val());

        if (stock > 1){
            stock = stock - 1;
            inputSpinText.val(stock);
        };

        return false;
    });

    $('#btnViewOrder').on('click', function (event) {
        var IdAtencion = '0';
        var IdMesa = '0';
        var EstadoMesa = '00';
        var selectedMesa = $('#pnlMesas .tile.selected');

        event.preventDefault();

        if ($('#pnlMesas').is(':visible')){
            
            IdAtencion = selectedMesa.attr('data-idatencion');
            IdMesa = selectedMesa.attr('data-idmesa');
            EstadoMesa = selectedMesa.attr('data-state');
            $('#hdIdPrimary').val(IdAtencion);
            $('#hdIdMesa').val(IdMesa);
            $('#hdEstadoMesa').val(EstadoMesa);
            if (IdAtencion != null)
                listarDetallePedido(IdAtencion);
        };

        VerPedido();
    });

    $('#btnAddOrder').on('click', function (event) {
        event.preventDefault();
        addDetallePedido();
    });

    $('#btnBackTables').on('click', function (event) {
        event.preventDefault();
        backToTables();
    });
    
    $('#btnBackProducts').on('click', function (event) {
        var EstadoMesa = '00';

        event.preventDefault();

        EstadoMesa = $('#hdEstadoMesa').val();
        
        if ((EstadoMesa == '00') || (EstadoMesa == '01') || (EstadoMesa == '02') || (EstadoMesa == '03')){
            $('#pnlOrden').fadeOut(400, function () {
                $('#pnlProductos').fadeIn(400, function () {
                    $('#hdVista').val('PRODUCTOS');
                    if ($("div#pnlProductos .gridview .tile").length == 0){
                        BuscarProductos('1');
                    }
                });
            });
            $('#btnViewOrder').removeClass('oculto');
            $('#btnGuardarCambios, #btnBackToTables, #btnDividirCuenta').addClass('oculto');
        }
        else
            backToTables();
    });

    $('#btnSepararMesas').on('click', function(event) {
        event.preventDefault();
        SepararMesas();
    });

    $('#pnlOrden .contentPedido table tbody').on('click', 'tr td.colProducto, tr td.colPrecio, tr td.colSubTotal', function(event) {
        var parentRow = $(this).parent();

        event.preventDefault();
        selectArticulo(parentRow);
    });

    $('#pnlOrden .contentPedido table tbody').liveDraggable({
        containment:'document',
        distance: 10,
        helper: 'clone',
        position: 'absolute',
        appendTo: 'body',
        opacity: 0.55,
        zIndex: 10000
    }, 'tr');

    $('#pnlMesas').liveDraggable({
        containment:'window',
        distance: 10,
        helper: 'clone',
        opacity: 0.55,
        zIndex: 1100
    }, '.tile');

    $('#pnlOrden .contentPedido table tbody').on('click', 'tr .button-observacion', function(event) {
        var inputControl = $(this).next().find('.input-control');
        var headerNomProducto = $(this).next().find('.nombreProducto');
        var txtObservaciones = inputControl.find('textarea');
        
        event.preventDefault();

        if ($(this).hasClass('active')) {
            inputControl.addClass('oculto');
            headerNomProducto.text(txtObservaciones.val());
            headerNomProducto.removeClass('oculto');
        } 
        else {
            inputControl.removeClass('oculto');
            txtObservaciones.focus();
            headerNomProducto.addClass('oculto');
        };

        $(this).toggleClass('active');
    }).disableSelection();

    $('#pnlOrden .contentPedido table tbody').on({
        click: function  (event) {
            event.preventDefault();
            return false;
        },
        focus: function () {
            $(this).autogrow();
        }
    }, 'tr textarea[rel="txtObservaciones"]');

    $('#btnQuitarItem').on('click', function (event) {
        event.preventDefault();
        removeArticulos();
    });

    $('#btnClearSelection').on('click', function (event) {
        event.preventDefault();
        resetSelection();
    });

    $('#btnBuscarArticulos').on('click', function (event) {
        var IdAtencion = '0';
        var IdMesa = '0';
        var EstadoMesa = '00';
        var selectedMesa = $('#pnlMesas .tile.selected');

        event.preventDefault();
        
        IdAtencion = selectedMesa.attr('data-idatencion');
        IdMesa = selectedMesa.attr('data-idmesa');
        EstadoMesa = selectedMesa.attr('data-state');
        
        $('#hdIdPrimary').val(IdAtencion);
        $('#hdIdMesa').val(IdMesa);
        $('#hdEstadoMesa').val(EstadoMesa);
        
        AgregarArticulos();
    });

    $('#btnUnirMesas').on('click', function (event) {
        event.preventDefault();
        UnirMesas();
    });

    $('#btnGuardarCambios').on('click', function (event) {
        event.preventDefault();
        GuardarCambios();
    });

    $('#txtSearch').keydown(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            BuscarProductos('1');
            return false;
        }
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearchProducts').on('click', function (event) {
        event.preventDefault();
        BuscarProductos('1');
    });
    
    $('#btnReserva').on('click', function (event) {
        event.preventDefault();
        Reservar();
    });

    $('#btnLiberarMesa').on('click', function (event) {
        event.preventDefault();
        LiberarMesas();
    });

    $('#btnImprimirVenta').on('click', function (event) {
        event.preventDefault();
        ImprimirVenta();
    });

    $('#btnBackAtencion').on('click', function(event) {
        event.preventDefault();
        closeCustomModal('#pnlVenta');
        backToTables();
    });

    $('#btnHidePnlDivision').on('click', function (event) {
        event.preventDefault();
        closeCustomModal('#pnlDivision');
    });

    $('#btnExitCustomer').on('click', function(event) {
        event.preventDefault();
        $('#pnlClientes').fadeOut(400);
    });

    $('#btnLeyendaMesas').on('click', function (event) {
        event.preventDefault();
        toggleSlideButton(this, '#pnlEstadoMesa', {
            msje_active: 'Leyenda de etapas',
            icon_active: 'images/legend-info.png',
            msje_deactive: 'Ocultar leyenda',
            icon_deactive: 'images/legend-info-remove.png'
        });
    });

    $('#pnlEstadoMesa').on('click', '.tile', function (event) {
        var estadoMesa = $(this).attr('data-codigo');
        var selector = '#pnlMesas .tile[data-state="' + estadoMesa + '"]';
        var selectorNot = '#pnlMesas .tile[data-state!="' + estadoMesa + '"]';
        
        event.preventDefault();
        
        if (estadoMesa == '*')
            $('#pnlMesas .tile').show(300);
        else {
            $(selectorNot).hide(300);
            if (!$(selector).is(':visible'))
                $(selector).show(300);
        };
        
        $(this).siblings('.selected').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#btnTodoUnaCuenta').on('click', function (event) {
        event.preventDefault();
        
        $(this).addClass('oculto');
        TodoUnaCuenta();
    });

    $('#sliderCuentas').on('click', 'ul li:visible .delete', function(event) {
        event.preventDefault();

        if ($(this).parent().siblings().length == 0)
            $('#btnTodoUnaCuenta').removeClass('oculto');
        
        $(this).parent().remove();
        CalcularTotalPorCuenta();
    });

    $('#ddlMonedaTarjeta').on('change', function(event) {
        event.preventDefault();
        ExtraerTipoCambio();
    });

    $('#ddlNombreTarjeta').on('change', function(event) {
        event.preventDefault();
        ExtraerComisionTarjeta();
    });

    $('#txtImporteRecibido').on({
        keyup: function () {
            var TipoCobro = '';
            var importeRecibido = 0;
            var cambioPedido = 0;

            TipoCobro = $('#ddlTipoCobro').val();
            importeRecibido = Number(($(this).val().trim().length == 0 ? '0' : $(this).val()));
            cambioPedido =  calcularCambio(importeRecibido);
            
            $('#txtImporteCambio').val(cambioPedido.toFixed(2));
            
            CalcularTotalConImpuestoPorVenta(TipoCobro);
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
        var TipoCobro = '';
        var importeComision = 0;
        
        event.preventDefault();

        TipoCobro = $('#ddlTipoCobro').val();
        
        if (Number($(this).val()) > 0)
            importeComision = ($('#txtComisionTarjeta').val().trim().length == 0 ? 0 : Number($('#txtComisionTarjeta').val()));

        $('#pnlInfoImporte .grid .row[data-codigo="005"] .total').text(Number($(this).val()).toFixed(2));
        $('#pnlInfoImporte .grid .row[data-codigo="comision"] .total').text(importeComision.toFixed(2));
        
        CalcularTotalConImpuestoPorVenta(TipoCobro);
    });

    cargarDatePicker('#txtFechaVenta', function (dateText, inst) {
        $('#txtSerieComprobante').focus();
    });

    $('#ddlTipoComprobante').on('change', function(event) {
        var TipoCobro = '';
        event.preventDefault();
        
        TipoCobro = $('#ddlTipoCobro').val();

        GenerarNumVenta();
        CalcularTotalConImpuestoPorVenta(TipoCobro);
    });

    $('#ddlTipoCobro').on('change', function(event) {
        var TipoCobro = '';
        event.preventDefault();

        TipoCobro = $(this).val();
        
        if (TipoCobro == '00'){
            $('#pnlFormaPago').fadeIn(300, function () {
                addValidFormaPago('00');
                if ($('#tab009').is(':visible'))
                    $('#ddlMoneda').focus();
                else
                    $('#ddlMonedaTarjeta').focus();
            });
        }
        else {
            removeValidFormaPago('00');
            $('#pnlFormaPago').fadeOut(300);
            $('#lblMonedaCobro').text($('#lblMonedaCuenta').text());
        };
        
        CalcularTotalConImpuestoPorVenta(TipoCobro);
    });

    $('#pnlInfoCliente').on('click', function(event) {
        event.preventDefault();
        ShowPanelClientes();
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
        };
    });

    $('#gvClientes .items-area').on('click', '.list', function(event) {
        var tipocliente = '',
            idcliente = '0',
            descripcion = '',
            direccion = '',
            nrodoc = '';

        event.preventDefault();
        
        tipocliente = $(this).attr('data-tipocliente');
        idcliente = $(this).attr('data-idcliente');
        nrodoc = $(this).find('main p .docidentidad').text();
        descripcion = $(this).find('main p .descripcion').text();
        direccion = $(this).find('main p .direccion').text();

        setCliente(tipocliente, idcliente, nrodoc, nrodoc, descripcion, direccion);
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
        };
    
        if (tipocliente == 'NA')
            descripcion = $('#txtNombres').val() + ' ' + $('#txtApePaterno').val() + ' ' + $('#txtApeMaterno').val();
        else
            descripcion = $('#txtRazonSocial').val();

        setCliente(tipocliente, '0', '000', nrodoc, descripcion, direccion);
    });

    $('#btnCancelCliente').on('click', function(event) {
        event.preventDefault();
        LoadClienteWithForm($('#txtSearchCliente').val(), '', '1');
    });

    $('#btnAperturarCaja').on('click', function(event) {
        event.preventDefault();
        window.top.$('.modern-wrappanel .gridview .tile[data-url="' + $(this).attr('data-url') + '"]').trigger('click');
    });

    $('#btnComprobarCaja').on('click', function(event) {
        event.preventDefault();
        ComprobarApertura();        
    });
});

var progressError = false;
var timestamp = null;
var TipoBusqueda = '00';
var monedaState = false;
var checkState = false;

function NotificarAtencion () {
    var idempresa = '0';
    var idcentro = '0';

    idempresa = $('#hdIdEmpresa').val();
    idcentro = $('#hdIdCentro').val();

    $.ajax({
        type: 'GET',
        url: 'services/atencion/atencion-update.php',
        async: true,
        cache: false,
        data: {
            idempresa: idempresa,
            idcentro: idcentro,
            estado: '03',
            timestamp: timestamp
        },
        dataType: 'json',
        success: function(data){
            var countdata = 0;
            var strhtml = '';
            var tile;

            countdata = data.length;

            if (countdata > 0){
                tile = $('#pnlMesas .tile[data-idmesa="' + data[0].tm_idmesa);

                if (data[0].ta_tipoubicacion == '01'){
                    csssize = 'double';
                    tagheader = 'h3';
                }
                else {
                    csssize = '';
                    tagheader = 'h1';
                };

                strhtml = '<div class="tile dato ' + csssize + '" ';
                strhtml += 'data-idmesa="' + data[0].tm_idmesa + '" ';
                strhtml += 'data-idatencion="' + data[0].tm_idatencion + '" ';
                strhtml += 'data-state="' + data[0].ta_estadoatencion + '" ';
                strhtml += 'data-tipoubicacion="' + data[0].ta_tipoubicacion + '" ';
                strhtml += 'style="background-color: ' + data[0].ta_colorleyenda + ';">';

                strhtml += '<div class="tile-content">';
                strhtml += '<div class="text-right padding10 ntp">';
                strhtml += '<' + tagheader + ' class="white-text">' + data[0].tm_codigo + '</' + tagheader + '>';
                strhtml += '</div></div>';
                strhtml += '<div class="brand"><span class="badge bg-dark">' + data[0].tm_nrocomensales + '</span></div>';
                
                strhtml += '</div>';

                if (tile.length > 0){
                    tile.replaceWith(strhtml);
                }
                else {
                    //$('#pnlMesas .gridview').append(strhtml);
                    
                };
                
                timestamp = data[0].fechamaxmov;

                setTimeout(function () {
                    NotificarAtencion();
                }, 5000);
            };
        },
        complete: function (data) {
            if (progressError){
                setTimeout(function () {
                    NotificarAtencion();
                }, 10000);
            };
        },
        error: function (data) {
            progressError = true;
            console.log(data);
        }
    });
    
}

function ComprobarApertura () {
    $.ajax({
        url: 'services/ventas/aperturacaja-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            fecha: GetToday()
        }
    })
    .done(function(data) {
        var countdata = 0;
        var flag = false;
        
        countdata = data.length;
        flag = (countdata > 0 ? true : false);

        habilitarDiv('#pnlOrden .moduloTwoPanel .colTwoPanel2', flag);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function initEventCuentaSlider () {
    $('#sliderCuentas .control_prev').off('click');
    $('#sliderCuentas .control_prev').on('click', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')){
            $('#sliderCuentas ul li.visible').fadeOut(300, function () {
                $(this).removeClass('visible');

                $(this).prev().fadeIn(300, function () {
                    var flag = false;
                    var idcontainer = '0';
                    
                    flag = $(this).is(':first-child');
                    idcontainer = $(this).attr('data-idcontainer');

                    $(this).addClass('visible');
                    
                    makeCuentaDroppable(idcontainer);
                    
                    habilitarLink('#sliderCuentas a.control_prev', !flag);
                    habilitarLink('#sliderCuentas a.control_next', true);
                });
            });
        };
    });

    $('#sliderCuentas .control_next').off('click');
    $('#sliderCuentas .control_next').on('click', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('disabled')){
            $('#sliderCuentas ul li.visible').fadeOut(300, function () {
                $(this).removeClass('visible');

                $(this).next().fadeIn(300, function () {
                    var flag = false;
                    var idcontainer = '0';
                    
                    flag = $(this).is(':last-child');
                    idcontainer = $(this).attr('data-idcontainer');

                    //alert(flag);
                    
                    $(this).addClass('visible');
                    
                    makeCuentaDroppable(idcontainer);
                    
                    habilitarLink('#sliderCuentas a.control_next', !flag);
                    habilitarLink('#sliderCuentas a.control_prev', true);
                });
            });
        };
    });
}

function SepararMesas () {
    var Id = '0';
    var TipoSave = '01';
    var TipoSeleccion = '03';
    var idambiente = '0';
                
    Id = $('#sliderAmbientes .tile.selected:first').attr('data-idatencion');
    idambiente = $('#sliderAmbientes.slider ul li.visible').attr('data-idcontainer');

    $.ajax({
        type: "POST",
        url: 'services/atencion/atencion-post.php',
        cache: false,
        dataType: 'json',
        data: {
            fnPost: 'fnPost',
            hdIdPrimary: Id,
            hdIdAmbiente: idambiente,
            hdTipoSave: TipoSave,
            hdTipoSeleccion: TipoSeleccion,
            hdIdMesa: '',
            hdEstadoAtencion: ''
        },
        success: function(data){
            if (Number(data.rpta) > 0){
                $('#btnLeyendaMesas').removeClass('oculto');
                $('#btnClearSelection, #btnBuscarArticulos, #btnUnirMesas, #btnViewOrder, #btnSepararMesas, #btnReserva').addClass('oculto');

                MostrarMesas(idambiente);
            };
        }
    });
}



function ListarSecciones (idgrupo) {
    $.ajax({
        type: "GET",
        url: 'services/grupos/grupos-getsections.php',
        cache: false,
        dataType: 'json',
        data: {
            tipo: '00',
            id: idgrupo
        },
        success: function(data){
            var nrosecciones = 0;
            var i = 0;
            var strhtml = '';

            nrosecciones = data.length;
            
            if (nrosecciones > 0){
                while(i < nrosecciones){
                    strhtml += '<li>';
                    strhtml += '<a href="#" data-idseccion="' + data[i].td_orden + '"><h2>Seccion ' + data[i].td_orden + '</h2></a>';
                    strhtml += '<section>';
                    strhtml += '<div class="gridview gridview">';
                    strhtml += '</div>';
                    strhtml += '</section>';
                    strhtml += '</li>';
                    ++i;
                };
                
                $('#btnAddOrder').removeClass('oculto');
                $('#gvSecciones').html(strhtml);

                BuscarProductos('1');
            }
            else {
                $('#btnAddOrder').addClass('oculto');
                $('#gvSecciones').html('<h2>Las secciones no est&aacute;n asignadass</h2>');
            };
        }
    });
}

function ListarGrupos (pagina) {
    var selector = '#gvGrupos .gridview';

    precargaExp('#gvGrupos', true);
    
    $.ajax({
        type: 'GET',
        url: 'services/grupos/grupos-search.php',
        cache: false,
        dataType: 'json',
        data: 'tipobusqueda=3&criterio=&pagina=' + pagina,
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var emptyMessage = '';
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<div data-idProducto="' + data[i].tm_idgrupoarticulo + '" data-idMoneda="' + data[i].tm_idmoneda + '" class="tile dato double bg-olive" data-click="transform">';

                    strhtml += '<div class="flag_tipocarta bd_color-grupo">';
                    strhtml += '<i class="icon-grid-view"></i>';
                    strhtml += '</div>';
                    
                    strhtml += '<input type="checkbox" style="display:none;" name="chkItemGrupo[]" value="' + data[i].tm_idcarta + '">';
                    
                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="white-text"><span class="moneda">' + data[i].tm_simbolo + ' </span><span class="precio">' + Number(data[i].td_precio).toFixed(2) + '</span></h2>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="brand">';
                    strhtml += '<div class="label">' + data[i].tm_nombre + '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="input_spinner">';
                    strhtml += '<input type="text" name="txtCantidadInTile" class="inputCantidad" value="1" />';
                    strhtml += '<div class="buttons">';
                    strhtml += '<button type="button" class="up bg-green white-text">+</button>';
                    strhtml += '<button type="button" class="down bg-red white-text">-</button>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    ++i;
                }
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPageGrupo').val(Number($('#hdPageGrupo').val()) + 1);

                $(selector).on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPageGrupo').val();
                        ListarGrupos(pagina);
                    };
                }).find('.tile:first > .tile_true_content').trigger('click');
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                    $('#gvSecciones').html('');
                };
            };
            precargaExp('#gvGrupos', false);
        }
    });
}

function addValidFormaPago (tipo) {
    $('#txtImporteRecibido').rules('add', {
        required: true,
        maxlength: 11,
        min: 1
    });
}

function removeValidFormaPago (tipo) {
    $('#txtImporteRecibido').rules('remove');
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
}

function removeValidVenta () {
    $('#txtSerieComprobante').rules('remove');
    $('#txtNroComprobante').rules('remove');s
}

function GenerarNumVenta () {
    $.ajax({
        type: 'GET',
        url: 'services/numeracion/numventa-generate.php',
        cache: false,
        data: {
            idtipocomprobante: $('#ddlTipoComprobante').val(),
            idterminal: '1'
        },
        success: function(data){
            var datos = eval( "(" + data + ")" );
            var countdata = datos.length;
            var i = 0;
            var seriedoc = '';
            var nrodoc = '';

            if (countdata > 0){
                seriedoc = padZero(datos[0].td_seriedoc, 3);
                nrodoc = padZero(datos[0].td_nroactual, 10);
            }
            else {
                seriedoc = '001'
                nrodoc = '00001';
            };

            $('#txtSerieComprobante').val(seriedoc);
            $('#txtNroComprobante').val(nrodoc);
        }
    });
}

function ExtraerSimboloMoneda () {
    var valor = '';
    valor = $('#ddlMoneda option:selected').attr('data-simbolo');
    $('#lblMonedaCobro').text(valor);
}

function ExtraerTipoCambio () {
    var valor = '';
    valor = $('#ddlMonedaTarjeta option:selected').attr('data-tipocambio');
    $('#txtTipoCambioEfectivo').val(valor);
}

function ExtraerComisionTarjeta () {
    var valor = '';
    valor = $('#ddlNombreTarjeta option:selected').attr('data-comision');
    $('#txtComisionTarjeta').val(valor);
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

function LimpiarVenta () {
    $('#txtCodigoRecibo').val('');
    $('#txtValeDescuento').val('');
    $('#txtImporteTarjeta').val('0.00');
    $('#txtImporteRecibido').val('0.00');
    $('#txtImporteCambio').val('0.00');
    $('#txtFechaVenta').val(GetToday());
    $('#ddlTipoComprobante')[0].selectedIndex = 0;
    $('#ddlMoneda')[0].selectedIndex = 0;
    $('#ddlMonedaTarjeta')[0].selectedIndex = 0;
    $('#ddlNombreTarjeta')[0].selectedIndex = 0;
    LimpiarInfoCliente();
    ExtraerTipoCambio();
    ExtraerComisionTarjeta();
    ExtraerSimboloMoneda();
    GenerarNumVenta();
    $('#hdImpuesto').val('0');
    $('#hdTotalConImpuesto').val('0');
    $('#hdTotalSinImpuesto').val('0');
    $('#lblImporteCobro').text('0.00');
}

function ImprimirVenta () {
    var nombreProducto = '';
    var cantidad = 0;
    var subtotal = 0;
    var i = 0;
    var itemsDetalle = $('#sliderCuentas ul li.visible').find('.slider-content-scroll .item-section');
    var countdata = itemsDetalle.length;
    var strhtml = '';
    
    $('#lblFechaImp').text($('#txtFechaVenta').val());
    $('#lblNroReciboImp').text($('#txtSerieComprobante').val() + '-' + $('#txtNroComprobante').val());

    if (countdata > 0){
        while(i < countdata){
            nombreProducto = $(itemsDetalle[i]).find('.nombreProducto').text();
            cantidad = $(itemsDetalle[i]).find('.cantidad').text();
            subtotal = $(itemsDetalle[i]).find('.precio').text();

            strhtml += '<tr><td>' + cantidad + '</td><td>' + nombreProducto + '</td><td>' + subtotal + '</td></tr>';
            ++i;
        };
    };

    $('#pnlImpresion table tbody').html(strhtml);
    $('#lblTotalImp').text($('#lblMonedaCobro').text() + ' ' + $('#lblImporteCobro').text());

    window.print();
}

function setCliente (tipocliente, idcliente, codigo, nrodoc, descripcion, direccion) {
    $('#hdTipoCliente').val(tipocliente);
    $('#hdIdCliente').val(idcliente);
    $('#hdCodigoCliente').val(codigo);

    $('#pnlInfoCliente').attr('data-idcliente', idcliente);
    $('#pnlInfoCliente .info .descripcion').text(descripcion);
    $('#pnlInfoCliente .info .docidentidad').text(nrodoc);
    $('#pnlInfoCliente .info .direccion').text(direccion);

    setTipoDocIdentidad();

    $('#pnlClientes').fadeOut('400', function() {
        
    });
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
    };
}

function TodoUnaCuenta () {
    var strhtml = '';
    var itemsDetalle = $('.contentPedido table tbody tr');
    var countdata = itemsDetalle.length;
    var i = 0;

    if (countdata > 0){
        while(i < countdata){
            var item = $(itemsDetalle[i]);

            strhtml += '<div data-referer="' + item.attr('data-referer') + '" data-idproducto="' + item.attr('data-idproducto') + '" class="item-section">';
            strhtml += '<span class="nombreProducto">' + item.find('.nombreProducto').text() + '</span>';
            strhtml += '<span class="cantidad">' + item.attr('data-cantidad') + '</span>';
            strhtml += '<span class="precio">' + item.attr('data-precio') + '</span>';
            strhtml += '<span class="delete">&times;</span>';
            strhtml += '</div>';

            ++i;
        };
    };
    
    $('#sliderCuentas ul li.visible').find('.slider-content-scroll').html(strhtml);
    CalcularTotalPorCuenta();
}

function configValidate () {
    $("#form1").validate({
        lang: 'es',
        showErrors: showErrorsInValidate,
        submitHandler: CobrarPedido
    });
}

function CobrarPedido (form) {
    var detalleVenta = '';
    var Id = $('#hdIdPrimary').val();
    var CodigoCliente = $('#hdCodigoCliente').val();
    var IdVenta = $('#hdIdVenta').val();
    var TipoSave = '00';
    var TipoSeleccion = '04';
    var IdMesa = $('#hdIdMesa').val();
    var EstadoAtencion = '07';
    var TipoCobro = $('#ddlTipoCobro').val();
    
    var datosEnvio = '';

    var importeRecibido = 0;
    var importeTarjeta = 0;
    var importeIngresado = 0;
    var importeCuenta = 0;

    importeRecibido = Number($('#txtImporteRecibido').val());
    importeTarjeta = Number($('#txtImporteTarjeta').val());
    importeCuenta = Number($('#lblImporteCuenta').text());

    importeIngresado = importeRecibido + importeTarjeta;
    
    if ($('#form1').valid()){
        if (TipoCobro == '01'){
            if (CodigoCliente == '0') {
                $('#noticeCliente').fadeIn(300);
                return false;
            };
        }
        else {
            if (importeTarjeta > 0) {
                if (importeIngresado != importeCuenta){
                    MessageBox('Datos no v&aacute;lidos', 'El importe recibido m&aacute;s el importe de tarjeta debe ser igual al importe de cuenta.', '[Aceptar]', function () {
                        if ($('#tab009').is(':visible'))
                            $('#txtImporteRecibido').focus();
                        else
                            $('#txtImporteTarjeta').focus();
                    });
                    return false;
                };
            }
            else {
                if (importeRecibido < importeCuenta){
                    MessageBox('Datos no v&aacute;lidos', 'El importe recibido no debe ser menor al importe de cuenta', '[Aceptar]', function () {
                        if ($('#tab009').is(':visible')){
                            $('#pnlFormaPago .content .paneltab').hide();
                            $('#pnlFormaPago .content .paneltab[id="tab005"]').show('400', function() {
                                $('#txtImporteTarjeta').focus();
                            });
                        }
                        else
                            $('#txtImporteTarjeta').focus();
                    });
                    return false;
                };
            };
        };

        detalleVenta = ExtraerDetalleVenta();

        datosEnvio = 'fnPost=fnPost&hdIdPrimary=' + Id + '&hdTipoSave=' + TipoSave + '&hdIdVenta=' + IdVenta + '&hdTipoSeleccion=' + TipoSeleccion + '&hdIdMesa=' + IdMesa + '&hdEstadoAtencion=' + EstadoAtencion + '&strListMesas=0&';
        datosEnvio += $('#pnlVenta').find('input:text, input:hidden, select').serialize() + '&';
        datosEnvio += $('#frmClientes').find('input:text, input:hidden, select').serialize();
        datosEnvio += '&detalleVenta=' + detalleVenta;

        $.ajax({
            type: "POST",
            url: 'services/atencion/atencion-post.php',
            cache: false,
            dataType: 'json',
            data: datosEnvio
        })
        .done(function(data) {
            var rpta = data.rptaVenta;           
            MessageBox(data.titulomsjeVenta, data.contenidomensajeVenta, '[Aceptar]', function () {
                if (Number(rpta) > 0){
                    //UpdateStateMesa($('#pnlMesas .tile[data-idmesa="' + IdMesa + '"]'), data);
                    habilitarControl('#btnGenerarVenta', false);
                    $('#btnGenerarVenta').removeClass('success');
                };
            });
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }
}

function makeCuentaDroppable (IdCuenta) {
    var slider = $('#sliderCuentas ul');
    slider.on('mouseover', $('li.visible').find('.slider-content-scroll'), function() {
        if (!$(this).data("init")) {
            $(this).data("init", true).droppable({
                drop: function (event, ui) {
                    var cuentas;
                    var item;
                    var i = 0;
                    var j = 0;
                    var idproductoIng = 0;
                    var cantidadIng = 0;
                    var cantidadTotal = 0;
                    var countcuentas = 0;
                    var html_item_section = '';
                    
                    item = ui.draggable;
                    cuentas = $('#sliderCuentas ul li');
                    idproductoIng = item.attr('data-referer');
                    cantidadIng = Number(item.attr('data-cantidad'));
                    countcuentas = cuentas.length;
                    
                    if (countcuentas > 0){
                        for (i = 0; i < countcuentas; i++) {
                            var items = $(cuentas[i]).find('.item-section');
                            if (items.length > 0){
                                for (j = 0; j < items.length; j++) {
                                    if ($(items[j]).attr('data-referer') == idproductoIng)
                                        cantidadTotal = cantidadTotal + Number($(items[j]).find('.cantidad').text());
                                };
                            };
                        };

                        if (cantidadTotal < cantidadIng){
                            html_item_section = '<div data-referer="' + item.attr('data-referer') + '" data-idproducto="' + item.attr('data-idproducto') + '" class="item-section">';
                            html_item_section += '<span class="nombreProducto">' + item.find('.nombreProducto').text() + '</span>';
                            html_item_section += '<span class="cantidad">1</span>';
                            html_item_section += '<span class="precio">'+item.attr('data-precio')+'</span>';
                            html_item_section += '<span class="delete">&times;</span>';
                            html_item_section += '</div>';

                            $('#sliderCuentas ul li.visible').find('.slider-content-scroll').append(html_item_section);
                            CalcularTotalPorCuenta();
                            $('#btnTodoUnaCuenta').addClass('oculto');
                        }
                        else {
                            MessageBox('No se pudo agregar', 'Todas las cantidades de este articulo han sido cubiertas.', "[Aceptar]", function () {
                                
                            });
                        };
                    };
                }
            });
        };
    });
    CalcularTotalPorCuenta();
}

function MostrarMesas (idambiente) {
    var selector = '';
    
    selector = '#sliderAmbientes.slider ul li[data-idcontainer="' + idambiente + '"] .gridview';
    
    precargaExp('#sliderAmbientes.slider ul li[data-idcontainer="' + idambiente + '"]', true);
   
    $.ajax({
        type: "GET",
        url: "services/atencion/atencion-search.php",
        cache: false,
        dataType: 'json',
        data: "tipobusqueda=ATENCION-AMBIENTE&idambiente=" + idambiente,
        success: function(data){
            var countdata = 0; 
            var selectedState = '';
            var i = 0;
            var strhtml = '';
            var csssize = '';
            var tagheader = '';
            var stylehide = 'block';

            countdata = data.length;
            
            selectedState = $('#pnlEstadoMesa .dato.selected').attr('data-codigo');

            if (countdata > 0){
                while(i < countdata){
                    if (data[i].ta_tipoubicacion == '01'){
                        csssize = ' double';
                        tagheader = 'h3';
                    }
                    else {
                        csssize = '';
                        tagheader = 'h1';
                    };
                    
                    /*if (selectedState != '*'){
                        if (data[i].ta_estadoatencion != selectedState)
                            stylehide = 'none';
                        else
                            stylehide = 'block';
                    }
                    else
                        stylehide = 'block';*/

                    // strhtml += '<div class="tile dato ' + csssize + '" ';
                    // strhtml += 'data-idmesa="' + data[i].tm_idmesa + '" ';
                    // strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                    // strhtml += 'data-state="' + data[i].ta_estadoatencion + '" ';
                    // strhtml += 'data-tipoubicacion="' + data[i].ta_tipoubicacion + '" ';
                    // strhtml += 'style="background-color: ' + data[i].ta_colorleyenda + '; display: ' + stylehide + ';">';

                    // strhtml += '<div class="tile-content">';
                    // strhtml += '<div class="text-right padding10 ntp">';
                    // strhtml += '<' + tagheader + ' class="white-text">' + data[i].tm_codigo + '</' + tagheader + '>';
                    // strhtml += '</div></div>';
                    // strhtml += '<div class="brand"><span class="badge bg-dark">' + data[i].tm_nrocomensales + '</span></div>';
                    
                    // strhtml += '</div>';

                    strhtml += '<div class="dato mdl-cell mdl-cell--2-col mdl-cell--2-col-phone pos-rel card-panel" ';
                    strhtml += 'data-idmesa="' + data[i].tm_idmesa + '" ';
                    strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                    strhtml += 'data-state="' + data[i].ta_estadoatencion + '" ';
                    strhtml += 'data-tipoubicacion="' + data[i].ta_tipoubicacion + '" ';
                    strhtml += 'style="background-color: ' + data[i].ta_colorleyenda + '; display: ' + stylehide + ';">';

                    strhtml += '<i class="icon-select centered material-icons white-text circle">done</i><div class="layer-select"></div>';

                    strhtml += '<h1 class="padding10 align-center white-text">' + data[i].tm_codigo + '</h1>';

                    strhtml += '</div>';
                    ++i;
                };
            }
            else {
                strhtml = '<h2>No se encontraron resultados.</h2>';
            };
            
            $(selector).html(strhtml);
            precargaExp('#sliderAmbientes.slider ul li[data-idcontainer="' + idambiente + '"]', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function resetSelection () {
    var vista = $('#hdVista').val();
    $('#btnUnirMesas, #btnSepararMesas, #btnReserva, #btnBuscarArticulos').addClass('oculto');
    if (vista == 'MESAS' || vista == 'PRODUCTOS'){
        if (vista == 'MESAS'){
            $('#btnLeyendaMesas').removeClass('oculto');
            $('#btnViewOrder').addClass('oculto');
        }
        else if (vista == 'PRODUCTOS')
            $('#btnViewOrder').removeClass('oculto');
    }
    else if (vista == 'DETALLE'){
        $('#btnViewOrder').addClass('oculto');
        $('.contentPedido table tbody tr.selected').removeClass('selected');
    };
}

function selectOnClickMesa () {
    var EstadoMesa = '00';
    EstadoMesa = $('#hdEstadoMesa').val();
    
    if ((EstadoMesa == '00') || (EstadoMesa == '01') || (EstadoMesa == '02') || (EstadoMesa == '03'))
        AgregarArticulos();
    else
        VerPedido();
}

function selectMesas (obj) {
    var EstadoMesa = '00';
    var TipoUbicacion = '';
    var lonelyTile;

    EstadoMesa = $(obj).attr('data-state');

    $('#hdEstadoAtencion').val(EstadoMesa);
    
    if ($('#pnlEstadoMesa').is(':visible'))
        $( "#btnLeyendaMesas" ).trigger( "click" );

    if($(obj).hasClass("selected")){
        $(obj).removeClass("selected");
        
        if ($('#sliderAmbientes .tile.selected').length > 0){
            $('#btnClearSelection').removeClass('oculto');
            $('#btnLeyendaMesas').addClass('oculto');
            
            if ($('#sliderAmbientes .tile.selected').length == 1){
                lonelyTile = $('#sliderAmbientes .tile.selected:first');
                TipoUbicacion = lonelyTile.attr('data-tipoubicacion');

                $('#btnUnirMesas').addClass('oculto');
                $('#btnViewOrder').removeClass('oculto');

                if ((lonelyTile.attr('data-state') == '00') || (lonelyTile.attr('data-state') == '01') || (lonelyTile.attr('data-state') == '02')){
                    if (lonelyTile.attr('data-state') == '00')
                        $('#btnReserva').removeClass('oculto');
                    else
                        $('#btnReserva').addClass('oculto');
                    $('#btnBuscarArticulos').removeClass('oculto');
                }
                
                if (TipoUbicacion == '01')
                    $('#btnSepararMesas').removeClass('oculto');
                else
                    $('#btnSepararMesas').addClass('oculto');


                /*if ((EstadoMesa == '00') || (EstadoMesa == '01') || (EstadoMesa == '02'))
                    $('#btnReserva, #btnBuscarArticulos').removeClass('oculto');
                else if (EstadoMesa == '03'){
                    if ($('#sliderAmbientes .tile.selected:first').attr('data-tipoubicacion') == '01')
                        $('#btnSepararMesas').removeClass('oculto');
                }
                else if (EstadoMesa == '07')
                    $('#btnLiberarMesa').removeClass('oculto');
                */
            }
            else {
                $('#btnSepararMesas, #btnReserva').addClass('oculto');
                if ((EstadoMesa == '00') || (EstadoMesa == '01') || (EstadoMesa == '02')){
                    $('#btnBuscarArticulos').addClass('oculto');
                    $('#btnUnirMesas').removeClass('oculto');
                }
                else if (EstadoMesa == '07')
                    $('#btnLiberarMesa').addClass('oculto');
            }
        }
        else {
            $('#btnLeyendaMesas').removeClass('oculto');
            $('#btnClearSelection, #btnLiberarMesa, #btnBuscarArticulos, #btnUnirMesas, #btnViewOrder, #btnSepararMesas, #btnReserva').addClass('oculto');
        };
    }
    else {
        if ($('#hdIdPerfil').val() == '4')
            $('#sliderAmbientes .tile').removeClass("selected");            
        
        $(obj).addClass("selected");
        $('#btnClearSelection').removeClass('oculto');
        $('#btnLeyendaMesas').addClass('oculto');
        if ($('#sliderAmbientes .tile.selected').length == 1){
            $('#btnViewOrder').removeClass('oculto');
            if ($(obj).attr('data-tipoubicacion') == '01')
                $('#btnSepararMesas').removeClass('oculto');
            else
                $('#btnSepararMesas').addClass('oculto');
            if ((EstadoMesa == '00') || (EstadoMesa == '01') || (EstadoMesa == '02')){
                $('#btnBuscarArticulos').removeClass('oculto');
                if (EstadoMesa == '00')
                    $('#btnReserva').removeClass('oculto');
            }
            else if (EstadoMesa == '07')
                $('#btnLiberarMesa').removeClass('oculto');
            $('#btnUnirMesas').addClass('oculto');
        }
        else {
            $('#btnUnirMesas').removeClass('oculto');
            if (EstadoMesa == '07')
                $('#btnLiberarMesa').removeClass('oculto');
            $('#btnSepararMesas, #btnViewOrder, #btnBuscarArticulos, #btnReserva').addClass('oculto');
        };
    };
}

function LiberarMesas () {
    var tablesSelected = $('#sliderAmbientes .tile.selected');
    var countdata = tablesSelected.length;
    var i = 0;
    var strMesas = '';
    var strIdAtencion = '';
    
    $('#hdTipoSave').val('01');
    $('#hdTipoSeleccion').val('00');
    
    if (countdata > 0){
        while(i < countdata){
            if (strIdAtencion.length > 0)
                strIdAtencion += ',';
            strIdAtencion += tablesSelected[i].getAttribute('data-idatencion');
            ++i;
        };
    }
    else {
        strIdAtencion = $('#hdIdPrimary').val();
        tablesSelected = $('#sliderAmbientes .tile[data-idatencion="' + strIdAtencion + '"]');
    };
    
    $.ajax({
        type: "POST",
        url: 'services/atencion/atencion-post.php',
        cache: false,
        data: "fnPost=fnPost&strIdAtencion=" + strIdAtencion + "&hdIdPrimary=" + $('#hdIdPrimary').val() + "&hdTipoSave=01&hdEstadoAtencion=00",
        success: function(data){
            var datos = eval( "(" + data + ")" );
            var tile = $('<div class="tile"></div>');
            //UpdateStateMesa($(tablesSelected), datos);
            $('#btnLiberarMesa, #btnClearSelection, #btnViewOrder').addClass('oculto');
            $('#btnLeyendaMesas').removeClass('oculto');
            backToTables();
        }
    });
    
    resetSelection();
}

function UnirMesas () {
    var selector;
    var listaIdMesas = '';
    var listaNroMesas = '';
    var estadoAtencion = '01';
    var IdAtencion = '0';
    var maxEstado = 0;
    var arrayEstadoMesa = [];
    var idambiente = '0';

    idambiente = $('#sliderAmbientes.slider ul li.visible').attr('data-idcontainer');

    selector = '#sliderAmbientes .tile.selected';

    $('#btnUnirMesas, #btnClearSelection').addClass('oculto');
    $('#btnLeyendaMesas').removeClass('oculto');

    listaIdMesas = $.map($(selector), function(n, i){
        arrayEstadoMesa.push(n.getAttribute('data-state'));
        return n.getAttribute('data-idmesa');
    }).join(',');

    listaNroMesas = $.map($(selector), function(n, i){
        return $(n).find('h1').text();
    }).join(',');

    maxEstado = Math.max.apply(null, arrayEstadoMesa);
    estadoAtencion = (maxEstado > 0 ? addLeadingZero(maxEstado) : '01');

    IdAtencion = $(selector + '[data-state="' + estadoAtencion + '"]').first().attr('data-idatencion');

    $.ajax({
        type: 'POST',
        url: 'services/atencion/atencion-post.php',
        cache: false,
        dataType: 'json',
        data: {
            fnPost: 'fnPost',
            strListMesas: listaIdMesas,
            hdIdPrimary: IdAtencion,
            hdIdAmbiente: idambiente,
            hdTipoSave: '00',
            hdTipoSeleccion: '00',
            hdEstadoAtencion: estadoAtencion,
            hdTipoUbicacion: '01'
        },
        success: function(data){
            MostrarMesas(idambiente);
        }
    });
}

function TomarCuenta() {
    var Id = $('#hdIdPrimary').val();
    var TipoSave = '00';
    var TipoSeleccion = '03';
    var IdMesa = $('#hdIdMesa').val();
    var EstadoAtencion = '06';
    $.ajax({
        type: "POST",
        url: 'services/atencion/atencion-post.php',
        cache: false,
        data: {
            fnPost: 'fnPost',
            hdIdPrimary: Id,
            hdTipoSave: TipoSave,
            hdTipoSeleccion: TipoSeleccion,
            hdIdMesa: IdMesa,
            hdEstadoAtencion: EstadoAtencion
        },
        success: function(data){
            var datos = eval( "(" + data + ")" );
            var RptaAtencion = datos.rpta;
            if (Number(RptaAtencion) > 0){
                //UpdateStateMesa($('#pnlMesas .tile[data-idmesa="' + IdMesa + '"]'), datos);
                $('#btnLeyendaMesas').removeClass('oculto');
                $('#btnClearSelection, #btnBuscarArticulos, #btnUnirMesas, #btnViewOrder, #btnReserva').addClass('oculto');
            };
        }
    });
}

function ExtraerDetalle () {
    var detallePedido = '';
    var listaDetalle = [];
    var idDetalle = '0';
    var idProducto = '0';
    var idMoneda = '0';
    var nombreProducto = '';
    var precio = 0;
    var cantidad = 0;
    var subtotal = 0;
    var codTipoMenuDia = '';
    var i = 0;
    var itemsProducto = ';'
    
    var itemsDetalle = $('.contentPedido table tbody tr');
    var countdata = itemsDetalle.length;

    if (countdata > 0){
        while(i < countdata){
            idDetalle = itemsDetalle[i].getAttribute('data-iddetalle');
            idProducto = itemsDetalle[i].getAttribute('data-idproducto');
            idMoneda = itemsDetalle[i].getAttribute('data-idmoneda');
            codTipoMenuDia = itemsDetalle[i].getAttribute('data-tipoMenuDia');
            nombreProducto = $(itemsDetalle[i]).find('textarea[rel="txtObservaciones"]').val();
            precio = itemsDetalle[i].getAttribute('data-precio');
            cantidad = itemsDetalle[i].getAttribute('data-cantidad');
            subtotal = itemsDetalle[i].getAttribute('data-subtotal');

            if (codTipoMenuDia == '03'){
                var articulosDet = $(itemsDetalle[i]).find('.elemgroup');
                
                itemsProducto = $.map($(articulosDet), function(n, i){
                      return n.getAttribute('data-idelemgroup');
                }).join(',');
            };

            var detalle = new DetallePedido (idDetalle, idProducto, nombreProducto, idMoneda, cantidad, precio, subtotal, codTipoMenuDia, itemsProducto);
            
            listaDetalle.push(detalle);
            ++i;
        };
    };

    detallePedido = JSON.stringify(listaDetalle);
    return detallePedido;
}

function ExtraerDetalleVenta () {
    var detalleVenta = '';
    var listaDetalle = [];
    var idDetalle = '0';
    var idProducto = '0';
    var idMoneda = '0';
    var nombreProducto = '';
    var precio = 0;
    var cantidad = 0;
    var subtotal = 0;
    var codTipoMenuDia = '';
    var i = 0;

    var itemsDetalle = $('#sliderCuentas ul li.visible').find('.slider-content-scroll .item-section');
    var countdata = itemsDetalle.length;

    idMoneda = $('#ddlMoneda').val();

    if (countdata > 0){
        while(i < countdata){
            idDetalle = 0;
            idProducto = itemsDetalle[i].getAttribute('data-idproducto');
            precio = $(itemsDetalle[i]).find('.precio').text();
            nombreProducto = $(itemsDetalle[i]).find('.nombreProducto').text();
            cantidad = $(itemsDetalle[i]).find('.cantidad').text();
            subtotal = $(itemsDetalle[i]).find('.precio').text();
            var detalle = new DetalleVenta (idDetalle, idProducto, nombreProducto, idMoneda, cantidad, precio, subtotal);
            listaDetalle.push(detalle);
            ++i;
        };
    };

    detalleVenta = JSON.stringify(listaDetalle);
    return detalleVenta;
}

function GuardarCambios () {
    var detallePedido = '';
    var Id = $('#hdIdPrimary').val();
    var TipoSave = '00';
    var TipoSeleccion = '01';
    var IdMesa = $('#hdIdMesa').val();
    var TipoUbicacion = $('#hdTipoUbicacion').val();
    var EstadoAtencion = '03';
    var idambiente = '0';

    idambiente = $('#sliderAmbientes.slider ul li.visible').attr('data-idcontainer');

    detallePedido = ExtraerDetalle();
    
    $.ajax({
        type: "POST",
        url: 'services/atencion/atencion-post.php',
        cache: false,
        dataType: 'json',
        data: {
            fnPost: 'fnPost',
            hdIdPrimary: Id,
            hdIdAmbiente: idambiente,
            hdTipoSave: TipoSave,
            hdTipoSeleccion: TipoSeleccion,
            hdIdMesa: IdMesa,
            strListMesas: IdMesa,
            hdEstadoAtencion: EstadoAtencion,
            hdTipoUbicacion: TipoUbicacion,
            detallePedido: detallePedido
        },
        success: function(data){
            var RptaAtencion = data.rpta;
            if (Number(RptaAtencion) > 0){
                //UpdateStateMesa($('#pnlMesas .tile[data-idmesa="' + IdMesa + '"]'), data);
                MessageBox('Datos guardados', 'La operaci&oacute;n se complet&oacute; correctamente.', '[Aceptar]', function () {
                    backToTables();
                });
            };
        }
    });
}

function limpiarDetalle () {
    $('.contentPedido table tbody tr').remove();
    calcularTotal();
}

function limpiarDetalleCuenta () {
    $('#sliderCuentas ul li').find('.item-section').remove();
    $('#btnTodoUnaCuenta').removeClass('oculto');
    CalcularTotalPorCuenta();
}

function AgregarArticulos () {
    ListarGrupos('1');
    $('#btnBuscarArticulos, #btnReserva, #btnUnirMesas, #btnLeyendaMesas').addClass('oculto');
    $('#btnViewOrder').removeClass('oculto');
    $('#pnlMesas').fadeOut(400, function () {
        if ($('#pnlEstadoMesa').is(':visible'))
            $( "#btnLeyendaMesas" ).trigger( "click" );
        $('#pnlProductos').fadeIn(400, function () {
            $('#hdVista').val('PRODUCTOS');
            if ($("#pnlProductos .gridview .tile").length == 0){
                BuscarProductos('1');
            };
        });
    });
}

function Reservar () {
    $('#btnBuscarArticulos, #btnUnirMesas, #btnViewOrder, #btnLeyendaMesas').addClass('oculto');
    $('#pnlMesas').fadeOut(400, function () {
        ShowPanelClientes();
    });
}

function ShowPanelClientes () {
    $('#noticeCliente').fadeOut(300);
    $('#pnlClientes').fadeIn(400, function () {
        if ($("#gvClientes .gridview .tile").length == 0)
            LoadClienteWithForm($('#txtSearchCliente').val(), '', '1');
    });
}

function VerPedido () {
    var EstadoMesa = $('#hdEstadoMesa').val();
    
    $('#btnReserva, #btnLeyendaMesas, #btnAddOrder, #btnBuscarArticulos, #btnViewOrder, #btnClearSelection').addClass('oculto');
    $('#btnBackToTables').removeClass('oculto');
    
    if (EstadoMesa == '03'){
        $('#pnlOrden .moduloTwoPanel .colTwoPanel1').css('width', '60%');
        $('#pnlOrden .moduloTwoPanel .colTwoPanel2').css({
            'display': 'inline-block',
            'width': '40%'
        });

        ComprobarApertura();

        $('#btnGuardarCambios, #btnDividirCuenta').removeClass('oculto');
    }
    else {
        $('#pnlOrden .moduloTwoPanel .colTwoPanel1').css('width', '100%');
        $('#pnlOrden .moduloTwoPanel .colTwoPanel2').css({
            'display': 'none',
            'width': '0'
        });

        if (EstadoMesa == '07')
            $('#btnLiberarMesa').removeClass('oculto');
        else
            $('#btnGuardarCambios').removeClass('oculto');
    };
    
    if ($('#pnlMesas').is(':visible')){
        if ($('#pnlEstadoMesa').is(':visible')){
            toggleSlideButton($('#btnLeyendaMesas'), '#pnlEstadoMesa', {
                msje_active: 'Leyenda de etapas',
                icon_active: 'images/legend-info.png',
                msje_deactive: 'Ocultar leyenda',
                icon_deactive: 'images/legend-info-remove.png'
            });
        };
        
        $('#pnlMesas').fadeOut(400, function () {
            $('#pnlOrden').fadeIn(400, function () {
                $('#hdVista').val('DETALLE');
            });
        });

        $('#pnlMesas .tile.selected').removeClass('selected');
        $('#pnlMesas .tile input:checkbox').removeAttr('checked');
        $('#pnlMesas .tile .input_spinner').hide();
    }
    else {
        $('#pnlProductos').fadeOut(400, function () {
            $('#pnlOrden').fadeIn(400, function () {
                $('#hdVista').val('DETALLE');
            });
        });
    };

    clearSelectionProductos();
}

function clearSelectionProductos () {
    var tipomenudia = '';
    var selector = '';
    
    tipomenudia = $('#pnlProductos .sectionHeader button.success').attr('data-tipomenu');

    if (tipomenudia == '03')
        selector = '#gvSecciones';
    else
        selector = '#pnlIndividual';

    $(selector + ' .tile.selected').removeClass('selected');
    $(selector + ' .tile input:checkbox').removeAttr('checked');
    $(selector + ' .tile .input_spinner').hide();

    if (tipomenudia == '03'){
        $(selector + ' li').each(function() {
            $(this).find('.tile:first').addClass('selected').find('input:checkbox')[0].checked = true;
            $(this).find('.tile:first').find('.input_spinner').show();
        });
    };
}

function backToTables () {
    limpiarDetalle();
    
    $('#btnLeyendaMesas').removeClass('oculto');
    $('#btnBackToTables, #btnBuscarArticulos, #btnLiberarMesa, #btnUnirMesas, #btnGuardarCambios, #btnViewOrder, #btnAddOrder, #btnDividirCuenta').addClass('oculto');
    
    $('#hdIdPrimary').val('0');
    $('#hdIdMesa').val('0');
    $('#hdEstadoMesa').val('00');

    limpiarDetalleCuenta();

    if ($('#pnlProductos').is(':visible')){
        $('#pnlProductos').fadeOut(400, function () {
            $('#pnlMesas').fadeIn(0, function (argument) {
                $('#hdVista').val('MESAS');
            });
        });
    }
    else {
        $('#pnlOrden').fadeOut(400, function () {
            $('#pnlMesas').fadeIn(0, function (argument) {
                $('#hdVista').val('MESAS');
            });
        });
    };
}

function BuscarProductos (pagina) {
    var tipomenudia = '';
    var tipobusqueda = '';
    var criterio = '';
    var bdColorCarta = '';
    var iconTipoCarta  = '';
    
    var selector = '';
    var capaLoading = '';
    var esfavorito = '';
    var idcarta = '0';
    var idgrupo = '0';

    var htmlspinner = '';
    var htmlflag = '';

    tipomenudia = '00';

    if (tipomenudia == '03'){
        tipobusqueda = 'GRUPAL';
        capaLoading = '#pnlPacks .span9';
        htmlprecio = '';
        htmlspinner = '';
        htmlflag = '';
    }
    else {
        tipobusqueda = 'INDIVIDUAL';
        capaLoading = '#pnlIndividual';
        
        if (tipomenudia == '00'){
            selector = '#gvCartaProd .gridview';
            iconTipoCarta = '<i class="icon-book"></i>';
            bdColorCarta = ' bd_color-carta';
        }
        else if (tipomenudia == '01'){
            selector = '#gvMenuProd .gridview';
            iconTipoCarta = '<i class="icon-clipboard-2"></i>';
            bdColorCarta = ' bd_color-menu';
        };

        htmlflag += '<div class="flag_tipocarta' + bdColorCarta + '">';
        htmlflag += iconTipoCarta;
        htmlflag += '</div>';
        
        htmlspinner = '<div class="input_spinner">';
        htmlspinner += '<input type="text" name="txtCantidadInTile" class="inputCantidad" value="1" />';
        htmlspinner += '<div class="buttons">';
        htmlspinner += '<button type="button" class="up bg-green white-text">+</button>';
        htmlspinner += '<button type="button" class="down bg-red white-text">-</button>';
        htmlspinner += '</div>';
        htmlspinner += '</div>';
    };

    criterio = (tipomenudia == '03' ? '' : $('#txtSearch').val());

    idgrupo = $('#hdIdGrupo').val();
    
    precargaExp(capaLoading, true);
    
    $.ajax({
        type: "GET",
        url: 'services/productos/productos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '02',
            tipomenudia: tipomenudia,
            esfavorito: '',
            idcategoria: $('#hdIdCategoria').val(),
            idsubcategoria: $('#hdIdSubCategoria').val(),
            idcarta: '0',
            idgrupo: idgrupo,
            idorden: '0',
            criterio: criterio,
            estadoapertura: '01',
            pagina: (tipomenudia == '03' ? '0' : pagina)
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var csscontent = '';
            var idSubCategoria = '0';
            var idMoneda = '0';
            var simboloMoneda = '';
            var precio = 0;
            var stock = 0;
            var strhtml = '';
            var htmlprecio = '';

            if (countdata > 0){
                while (i < countdata){
                    idSubCategoria = data[i].tm_idsubcategoria;
                    idMoneda = data[i].tm_idmoneda;
                    simboloMoneda = data[i].simboloMoneda;
                    precio = Number(data[i].td_precio);
                    stock = Number(data[i].td_stockdia);

                    if (data[i].tm_foto == 'no-set'){
                        foto = 'images/food-48.png';
                        csscontent = 'icon';
                    }
                    else {
                        foto =  data[i].tm_foto;
                        csscontent = 'image';
                    };

                    strhtml += '<div class="tile dato double" ';
                    strhtml += 'rel="' + data[i].iddetalle + '" ';
                    strhtml += 'data-idProducto="' + data[i].tm_idproducto + '" ';
                    strhtml += 'data-idMoneda="' + idMoneda + '" ';
                    strhtml += 'data-idCategoria="' + data[i].tm_idcategoria + '" ';
                    strhtml += 'data-idSubCategoria="' + idSubCategoria + '" ';
                    strhtml += 'data-nomCategoria="' + data[i].Categoria + '" ';
                    strhtml += 'data-nomSubCategoria="' + data[i].SubCategoria + '" ';
                    strhtml += 'data-stock="' + stock + '" ';
                    strhtml += 'data-orden="' + data[i].td_orden + '" ';
                    strhtml += 'data-codTipoMenuDia="' + data[i].codTipoMenuDia + '" ';
                    strhtml += 'data-tipoMenuDia="' + data[i].tipoMenuDia + '">';

                    strhtml += htmlflag;
                    
                    if (tipomenudia == '03')
                        selector = '#gvSecciones li a[data-idseccion="' + data[i].td_orden + '"]';
                    else
                        htmlprecio = '<div class="badge bg-red"><span class="moneda">' + simboloMoneda + ' </span><span class="precio">' + precio.toFixed(2) + '</span></div>';

                    strhtml += '<input name="chkItemMenu[]" type="checkbox" class="oculto" value="' + data[i].iddetalle + '" />';
                    
                    strhtml += '<div class="tile_true_content">';
                    
                    strhtml += '<div class="tile-content ' + csscontent + '">';
                    strhtml += '<img src="' + foto + '" />';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="tile-status bg-dark opacity">';
                    strhtml += '<span class="label">' + data[i].nombreProducto + '</span>';
                    
                    strhtml += htmlprecio;
                    
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += htmlspinner;

                    strhtml += '</div>';

                    if (tipomenudia == '03'){
                        $(selector).parent().find('.gridview').html(strhtml).find('.tile[data-orden!="' + data[i].td_orden + '"]').remove();
                        if ($(selector).parent().find('.tile').length > 0){
                            $(selector).parent().find('.tile:first').addClass('selected');
                        };
                    };
                    ++i;
                };

                if (tipomenudia != '03'){

                    $('#hdPage').val(Number($('#hdPage').val()) + 1);
                    
                    if (pagina == '1'){
                        $(selector).html(strhtml);
                    }
                    else
                        $(selector).append(strhtml);
                }
                else {
                    if ($('#gvSecciones .tile').length > 0)
                        $('#btnAddOrder').removeClass('oculto');
                };
            }
            else {
                if (pagina == '1'){
                    $('#btnLimpiarSeleccion').addClass('oculto');
                    $(selector).html('<h2>No se encontraron resultados</h2>');
                };
            };

            alert(tipomenudia);

            precargaExp(capaLoading, false);
        }
    });
}

function removeArticulos () {
    var EstadoMesa = $('#hdEstadoMesa').val();
    $('.contentPedido table tbody tr.selected').fadeOut(300, function () {
        var objSubTotal = $(this).find('input[rel="hdSubTotal"]');
        var SubTotal = 0;
        var totalPedido = 0;
        totalPedido = Number($('#hdTotalPedido').val());
        SubTotal = Number(objSubTotal.val());
        totalPedido = totalPedido - SubTotal;
        $('#totalDetails').text(totalPedido.toFixed(2));
        $('#hdTotalPedido').val(totalPedido.toFixed(2));
        $(this).remove();
    });
    $('#pnlOrden .contentPedido table tbody tr.selected').removeClass('selected');
    $('#btnQuitarItem, #btnClearSelection').addClass('oculto');
    $('#btnGuardarCambios').removeClass('oculto');
    if (EstadoMesa == '03')
        $('#btnDividirCuenta').removeClass('oculto');
}

function DetallePedido (idDetalle, idProducto, nombreProducto, idMoneda, cantidad, precio, subTotal, codTipoMenuDia, itemsProducto) {
    this.idDetalle = idDetalle;
    this.idProducto = idProducto;
    this.nombreProducto = nombreProducto;
    this.idMoneda = idMoneda;
    this.cantidad = cantidad;
    this.precio = precio;
    this.subTotal = subTotal;
    this.codTipoMenuDia = codTipoMenuDia;
    this.itemsProducto = itemsProducto;
}

function DetalleVenta (idDetalle, idProducto, nombreProducto, idMoneda, cantidad, precio, subTotal) {
    this.idDetalle = idDetalle;
    this.idProducto = idProducto;
    this.nombreProducto = nombreProducto;
    this.idMoneda = idMoneda;
    this.cantidad = cantidad;
    this.precio = precio;
    this.subTotal = subTotal;
}

function listarDetallePedido (IdAtencion) {
    if (IdAtencion != '0'){
        $.ajax({
            type: "GET",
            url: "services/atencion/detallepedido-search.php",
            cache: false,
            dataType: 'json',
            data: "idatencion=" + IdAtencion,
            success: function(data){
                builDetallePedido('01', data);
            }
        });
    }
}

function addDetallePedido () {
    var tipomenudia = '';
    var selector = '';
    var seleccionados;

    $('#btnViewOrder').removeClass('oculto');
    $('#btnClearSelection').addClass('oculto');

    tipomenudia = $('#pnlProductos .sectionHeader button.success').attr('data-tipomenu');

    if (tipomenudia == '03')
        selector = '#gvGrupos .tile.selected';
    else {
        $('#btnAddOrder').addClass('oculto');
        if (tipomenudia == '00')
            selector = '#gvCartaProd .tile.selected';
        else if (tipomenudia == '01')
            selector = '#gvMenuProd .tile.selected';
    };
    
    seleccionados = $(selector);
    builDetallePedido('00', seleccionados);
}
function builDetallePedido (tipo, list) {
    var idambiente = '0';
    var idDetalle = '0';
    var idProducto = '0';
    var idMoneda = '0';
    var detallePedido = '';
    var EstadoMesa = '';
    var simboloMoneda = '';
    var nombreProducto = '';
    var nombreCategoria = '';
    var nombreSubCategoria = '';
    var precio = 0;
    var txtCantidadInTile = '';
    var cantidad = 0;
    var subtotal = 0;
    var codTipoMenuDia = '';
    var tipoMenuDia = '';
    var colorMenuDia = '';
    var colorEstado = '';
    var codEstado = '';
    var i = 0;
    var il = list.length;
    var liProductsAdded = $('.contentPedido table tbody tr');
    var idsProducto = liProductsAdded.find('input[rel="hdIdProducto"]');
    var countProductsAdded = idsProducto.length;
    var counterProducto = 0;
    var idproducto = 0;
    var arrayIdProducts = [];
    var strhtml = '';
    var referer = 0;
    var tileGroup;

    idambiente = $('#sliderAmbientes.slider ul li.visible').attr('data-idcontainer');

    if (tipo == '00'){
        codTipoMenuDia = $('#pnlProductos .sectionHeader button.success').attr('data-tipomenu');
        tileGroup = $('#gvSecciones .tile.selected');
    }
    else
        limpiarDetalle();

    if (il > 0){
        while (i < il){
            if (tipo == '00'){
                idProducto = list[i].getAttribute('data-idProducto');
                idMoneda = list[i].getAttribute('data-idMoneda');
                simboloMoneda = $(list[i]).find('.moneda').text();
                precio = Number($(list[i]).find('.precio').text());

                if (codTipoMenuDia == '03'){
                    nombreProducto = $(list[i]).find('.brand .label').text();
                    colorMenuDia = '#008287';
                    tipoMenuDia = 'GRUPO';
                }
                else {
                    nombreProducto = $(list[i]).find('.tile-status .label').text();
                    nombreCategoria = $(list[i]).attr('data-nomCategoria');
                    nombreSubCategoria = $(list[i]).attr('data-nomSubCategoria');
                    colorMenuDia = $(list[i]).find('.flag_tipocarta').css('border-top-color');
                    tipoMenuDia = $(list[i]).attr('data-tipoMenuDia');
                };
                
                txtCantidadInTile = $(list[i]).find('.input_spinner input.inputCantidad').val();
                cantidad = txtCantidadInTile.trim().length == 0 ? 1 : Number(txtCantidadInTile);
                subtotal = precio;
            }
            else {
                idDetalle = list[i].idDetalle;
                idProducto = list[i].idProducto;
                idMoneda = list[i].idMoneda;
                simboloMoneda = list[i].simboloMoneda;
                nombreProducto = list[i].nombreProducto;
                nombreCategoria = list[i].nombreCategoria;
                nombreSubCategoria = list[i].nombreSubCategoria;
                precio = Number(list[i].precio);
                cantidad = Number(list[i].cantidad);
                subtotal = Number(list[i].subTotal);
                codTipoMenuDia = list[i].codTipoMenuDia;
                tipoMenuDia = list[i].tipoMenuDia;
                colorMenuDia = list[i].colorMenuDia;
                codEstado = list[i].codEstado;
                colorEstado = list[i].colorEstado;
            };
            
            for (var j = 0; j < cantidad; j++) {
                strhtml += '<tr ';
                strhtml += 'data-iddetalle="' + idDetalle + '" ';
                strhtml += 'data-referer="' + (referer + 1) + '" ';
                strhtml += 'data-idproducto="' + idProducto + '" ';
                strhtml += 'data-idmoneda="' + idMoneda + '" ';
                strhtml += 'data-precio="' + precio.toFixed(2) + '" ';
                strhtml += 'data-cantidad="1" ';
                strhtml += 'data-subtotal="' + subtotal.toFixed(2) + '" ';
                strhtml += 'data-tipoMenuDia="' + codTipoMenuDia + '">';
                strhtml += '<td class="colProducto">';
                strhtml += '<div class="input-observacion">';
                strhtml += '<button class="button-observacion"><i class="icon-pencil"></i></button>';
                strhtml += '<div class="observacion">';
                strhtml += '<div class="input-control text oculto" data-role="input-control">';
                strhtml += '<textarea rel="txtObservaciones" name="txtObservaciones[]">' + nombreProducto + '</textarea>';
                strhtml += '<button class="btn-clear" type="button"></button>';
                strhtml += '</div>';
                strhtml += '<h4 class="nombreProducto">' + nombreProducto + '</h4>';
                strhtml += '</div>';
                strhtml += '</div>';

                strhtml += '<div class="categoria">';
                
                if (codTipoMenuDia == '03'){
                    if (tipo == '00'){
                        for (var j = 0; j < tileGroup.length; j++) {
                            strhtml += '<span data-idelemgroup="' + tileGroup[j].getAttribute('data-idProducto') + '" class="elemgroup">' + $(tileGroup[j]).find('.tile-status .label').text() + '</span>';
                        };
                    };
                }
                else {
                    strhtml += '<span class="cat">' + nombreCategoria + '</span>';
                    strhtml += '<span class="subcat">' + nombreSubCategoria + '</span>';
                };
                
                strhtml += '<span class="tipomenu" style="background-color: ' + colorMenuDia +'">' + tipoMenuDia + '</span>';
                strhtml += '</div>';

                strhtml += '</td>';
                strhtml += '<td class="colPrecio">';
                strhtml += '<h3 class="precio">' + precio.toFixed(2) + '</h3>';
                strhtml += '</td>';
                strhtml += '<td class="colCantidad">';
                strhtml += '<h3 class="cantidad">1</h3>';
                strhtml += '</td>';
                strhtml += '<td class="colSubTotal">';
                strhtml += '<input type="hidden" rel="hdSubTotal" name="hdSubTotal[]" value="' + subtotal.toFixed(2) + '" />';
                strhtml += '<h3>' + subtotal.toFixed(2) + '</h3>';
                strhtml += '</td>';
                strhtml += '</tr>';

                ++referer;
            };
            ++i;
        };

        if (strhtml.length > 0)
            $('.contentPedido table tbody').append(strhtml);

        if (tipo == '01')
            ListarDetallePorArticulo($('#hdIdPrimary').val());

        /*EstadoMesa = $('#hdEstadoMesa').val();
        EstadoMesa = (EstadoMesa == '03' ? EstadoMesa : '02');*/

        if (tipo == '00'){
            IdMesa = $('#hdIdMesa').val();
            detallePedido = ExtraerDetalle();
            $.ajax({
                type: "POST",
                url: 'services/atencion/atencion-post.php',
                cache: false,
                dataType: 'json',
                data: {
                    fnPost: 'fnPost',
                    hdIdPrimary: $('#hdIdPrimary').val(),
                    hdIdAmbiente: idambiente,
                    hdTipoSave: '00',
                    hdTipoSeleccion: '01',
                    hdIdMesa: IdMesa,
                    strListMesas: IdMesa,
                    hdEstadoAtencion: '03',
                    hdTipoUbicacion: $('#hdTipoUbicacion').val(),
                    hdTipoAgrupacion: $('#hdTipoAgrupacion').val(),
                    detallePedido: detallePedido
                },
                success: function(data){
                    var RptaAtencion = data.rpta;
                    if (Number(RptaAtencion) > 0){
                        $('#hdIdPrimary').val(RptaAtencion);
                        //UpdateStateMesa($('#sliderAmbientes .tile[idmesa="' + IdMesa + '"]'), data);
                        $.Notify({style: {background: 'green', color: 'white'},  position: 'left', content: "Items agregados correctamente."});
                    };
                }
            });
        };
    }
    clearSelectionProductos();
    calcularTotal();
}

function UpdateStateMesa (objTile, datos) {
    objTile.css({'background-color':datos.stateColor}).attr({'data-state': datos.estadoAtencion, 'data-idatencion': datos.rpta});
}

function selectArticulo (obj) {
    var liArticulo = $(obj);
    if (liArticulo.hasClass('selected')){
        liArticulo.removeClass('selected');
        if ($('.contentPedido table tbody tr.selected').length == 0)
            $('#btnQuitarItem, #btnClearSelection').addClass('oculto');
    }
    else {
        liArticulo.addClass('selected');
        $('#btnQuitarItem, #btnClearSelection').removeClass('oculto');
    };
}

function calcularTotal () {
    var i = 0;
    var list = $('#pnlOrden div.contentPedido input[rel="hdSubTotal"]');
    var il = list.length;
    var totalPedido = 0;
    var cambioPedido = 0;
    
    if (il > 0){
        while (i < il){
            totalPedido += Number(list[i].value);
            ++i;
        };
    };

    $('#hdTotalPedido').val(totalPedido.toFixed(2));
    $('#totalDetails').text(totalPedido.toFixed(2));
    $('#lblMonedaVenta').text($('.simbol-currency:visible h1').text());
    $('#lblImporteVenta').text(totalPedido.toFixed(2));
}

function calcularCambio (importeRecibido) {
    var totalPedido = Number($('#lblImporteCuenta').text());
    var cambioPedido = 0;

    if (importeRecibido > totalPedido)
        cambioPedido = importeRecibido - totalPedido;
    else {
        cambioPedido = 0;
        totalPedido = importeRecibido;
    };

    $('#pnlInfoImporte .grid .row[data-codigo="009"] .total').text(totalPedido.toFixed(2));
    return cambioPedido;
}

function CalcularTotalPorCuenta () {
    var totalPorCuenta = 0;
    var i = 0;
    var precio = 0;
    sliderCuentas = $('#sliderCuentas ul li.visible').find('.item-section');
    countItems = sliderCuentas.length;
    if (countItems > 0){
        while(i < countItems){
            precio = Number($(sliderCuentas[i]).find('.precio').text());
            totalPorCuenta = totalPorCuenta + precio;
            ++i;
        };
    };
    
    $('#lblImporteCuenta').text(totalPorCuenta.toFixed(2));
}

function CalcularTotalConImpuestoPorVenta (TipoCobro) {
    var itemspago;
    var itemsimpuesto;
    var countItemsImp = 0;
    var countItemsPago = 0;
    var i = 0;
    var idtipocomprobante = '0';
    var impuestoPorVenta = 0;
    var totalSinImpuesto = 0;
    var totalConImpuesto = 0;
    var totalImpuesto = 0;
    var subtotal = 0;

    idtipocomprobante = $('#ddlTipoComprobante option:selected').attr('data-codigosunat');

    itemsimpuesto = $('#pnlInfoImporte h3.total.impuesto');
    countItemsImp = itemsimpuesto.length;
    
    if (TipoCobro == '00') {
        itemspago = $('#pnlInfoImporte .total.formapago');
        
        countItemsPago = itemspago.length;
        
        if (countItemsPago > 0){
            while(i < countItemsPago){
                subtotal = Number(itemspago[i].textContent || itemspago[i].innerText);
                totalConImpuesto = totalConImpuesto + subtotal;
                ++i;
            };
        };
    }
    else
        totalConImpuesto = Number($('#lblImporteCuenta').text());

    if (countItemsImp > 0){
        for (i = 0; i < countItemsImp; i++){
            var impuesto = Number(itemsimpuesto[i].getAttribute("data-valorimpuesto"));
            var subtotalImpuesto = totalConImpuesto - (totalConImpuesto / (1 + impuesto));
            totalImpuesto = totalImpuesto + subtotalImpuesto;
            if (itemsimpuesto[i].innerText != null)
                itemsimpuesto[i].innerText  = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
            else
                itemsimpuesto[i].textContent = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
        };
        if (idtipocomprobante == "01")
            totalSinImpuesto = totalConImpuesto - totalImpuesto;
        else
            totalSinImpuesto = totalConImpuesto;
    };

    $('#hdImpuesto').val(totalImpuesto.toFixed(2));
    $('#hdTotalSinImpuesto').val(totalSinImpuesto.toFixed(2));
    $('#hdTotalConImpuesto').val(totalConImpuesto.toFixed(2));

    $('#pnlInfoImporte .grid .row[data-codigo="totalsinimp"] .total').text(totalSinImpuesto.toFixed(2));
    $('#pnlInfoImporte .grid .row[data-codigo="totalconimp"] .total').text(totalConImpuesto.toFixed(2));

    if (TipoCobro == '00'){
        if ($('#txtImporteTarjeta').val().trim().length > 0){
            if (Number($('#txtImporteTarjeta').val()) > 0){
                if ($('#txtComisionTarjeta').val().trim().length > 0){
                    if (Number($('#txtComisionTarjeta').val()) > 0)
                        totalConImpuesto = totalConImpuesto + Number($('#txtComisionTarjeta').val());
                };
            };
        };
    };

    $('#lblImporteCobro').text(totalConImpuesto.toFixed(2));
}

function buildSliderCuenta (numberPanels, callback) {
    var strhtml = '';
    var strnomcuenta = 'Cuenta';
    var i = 0;
    var cssvisible = '';

    while (i < numberPanels){
        if (i == 0)
            cssvisible = ' class="visible"';
        else
            cssvisible = '';
        
        strhtml += '<li' + cssvisible + ' data-idcontainer="' + (i + 1) + '"><h3 class="slider-header">' + strnomcuenta + ' ' + (i + 1) + '</h3><div class="slider-content"><div class="slider-content-scroll"></div></div></li>';
        ++i;
    };

    $('#sliderCuentas ul').html(strhtml);

    callback();
}

function dividirCuentas () {
    var nroCuentas = 0;
    var importeTotal = 0;
    var subTotal = 0;
    var strhtml = '';
    var itemsDetalle;
    var countdata = 0;
    var i = 0;

    itemsDetalle = $('.contentPedido table tbody tr');
    nroCuentas = Number($('#txtNroCuentas').val());
    countdata = itemsDetalle.length;
    
    if (countdata > 0){
        while(i < countdata){
            var item = $(itemsDetalle[i]);
            subTotal = Number(item.attr('data-subtotal'));

            strhtml += '<div data-referer="' + item.attr('data-referer') + '" data-idproducto="' + item.attr('data-idproducto') + '" class="item-section">';
            strhtml += '<span class="nombreProducto">' + item.find('.nombreProducto').text() + '</span>';
            strhtml += '<span class="cantidad">'+ item.attr('data-cantidad') +'</span>';
            strhtml += '<span class="precio">' + (subTotal / nroCuentas).toFixed(2) + '</span>';
            strhtml += '<span class="delete">&times;</span>';
            strhtml += '</div>';
            ++i;
        };
    };
    
    $('#sliderCuentas ul li').each(function(index, el) {
        $(el).find('.slider-content-scroll').html(strhtml);
    });
    
    CalcularTotalPorCuenta();
}