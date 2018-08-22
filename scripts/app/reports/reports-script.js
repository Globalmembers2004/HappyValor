$(function(){


    ListarCentros();
    ListarCategorias_Combo();
	// $('.links-config ul').on('click', 'a', function () {
	// 	$('.links-config a').removeClass('active');
	// 	$(this).addClass('active');
	// 	navigateInFrame(this);
	// 	return false;
	// });

	// $('#btnShowMenu').on('click', function(event) {
	// 	event.preventDefault();
	// 	toggleOptions('#pnlMenu', true);
	// });

    cargarDatePicker('#txtFecha', function (dateText, inst) {
    });

    cargarDatePicker_Restrict('#txtFechaIni', function (dateText, inst) {
    });

    cargarDatePicker('#txtFechaIni_Caja', function (dateText, inst) {
    });

    cargarDatePicker('#txtFechaFin', function (dateText, inst) {
    });

    Reporte_Ventas(0);

	// $('.date-register').datetimepicker({
 //        format: 'DD/MM/YYYY'
 //    });

	$('#btnShowFilter').on('click', function(event) {
		event.preventDefault();
		toggleOptions_v2('#pnlFiltro', 'left');
	});

	$('#btnCloseFilter').on('click', function(event) {
		event.preventDefault();
		toggleOptions_v2('#pnlFiltro', 'left');
	});

	// $('#btnHideMenu').on('click', function(event) {
	// 	event.preventDefault();
	// 	toggleOptions('#pnlMenu', false);
	// });

    $('#gvControlStock').on('scroll', function(event) {
        event.preventDefault();
        gvControlStock.listenerScroll(this, event);
    });

    $('#gvControlStockMinimo').on('scroll', function(event) {
        event.preventDefault();
        gvControlStockMinimo.listenerScroll(this, event);
    });

    $('#btnConsultarReporte').on('click', function(event) {
        event.preventDefault();
        MostrarReporte(0);
    });

    $('#btnExportarReporte').on('click', function(event) {
        event.preventDefault();
        MostrarReporte(1);
    });

    $("#txtSearchCliente").easyAutocomplete({
        url: function (phrase) {
            var _url = 'services/clientes/clientes-autocomplete.php';
            
            _url += '?idempresa=' + $('#hdIdEmpresa').val();
            _url += '&idcentro=' + $('#ddlCentro').val();
            _url += '&tipobusqueda=3';
            _url += '&criterio=' + phrase;

            return _url;
        },
        getValue: function (element) {
            return element.tm_numerodoc.toLowerCase() +  ' - ' + element.Descripcion;
        },
        list: {
            onSelectItemEvent: function () {
                var value = $("#txtSearchCliente").getSelectedItemData().tm_idtipocliente;

                $("#hdIdCliente").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_numerodoc.toLowerCase() +  ' - ' + item.Descripcion;
            }
        },
        theme: "square"
    });
});

var gvControlStock = new DataList('#gvControlStock', {
    onSearch: function () {
        Reporte_ControlStock(gvControlStock.currentPage(), 0);
    }
});

var gvControlStockMinimo = new DataList('#gvControlStockMinimo', {
    onSearch: function () {
        Reporte_ControlStockMinimo(gvControlStockMinimo.currentPage(), 0);
    }
});

function Reporte_Ventas (_export) {
	precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/ventas/ventas-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            anhoini: $('#ddlAnhoIni').val(),
            mesini: $('#ddlMesIni').val(),
            anhofin: $('#ddlAnhoFin').val(),
            mesfin: $('#ddlMesFin').val(),
            isexport: _export
        },
        success: function (data) {
        	var strhtml = '';
        	var countdata = data.length;
        	var i = 0;

        	if (countdata > 0) {
                while(i < countdata){
                    // var importe_sinimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_base_imponible).toFixed(2);
                    // var importe_impuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_impuesto).toFixed(2);
                    // var importe_conimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2);
                    strhtml += '<tr>';
                    strhtml += '<td class="text-center">' + data[i].CUO + '</td>';
                    strhtml += '<td class="text-center">' + data[i].FechaEmision + '</td>';
                    strhtml += '<td class="text-center"></td>';
                    strhtml += '<td class="text-center">' + data[i].Tipo + '</td>';
                    strhtml += '<td class="text-center">' + data[i].Serie + '</td>';
                    strhtml += '<td class="text-center">' + data[i].NroDoc + '</td>';
                    strhtml += '<td class="text-center">' + data[i].CodSunatDocCli + '</td>';
                    strhtml += '<td class="text-center">' + data[i].Numero + '</td>';
                    strhtml += '<td class="text-center">' + data[i].Nombres + '</td>';
                    strhtml += '<td class="text-center">' + data[i].ValorFac + '</td>';
                    strhtml += '<td class="text-center">' + data[i].BaseImponible + '</td>';
                    strhtml += '<td class="text-center">' + data[i].Exonerada + '</td>';
                    strhtml += '<td class="text-center">' + data[i].Inafecta + '</td>';
                    strhtml += '<td class="text-center">' + data[i].ISC + '</td>';
                    strhtml += '<td class="text-center">' + data[i].Impuesto + '</td>';
                    strhtml += '<td class="text-center">' + data[i].OtrosTributos + '</td>';
                    strhtml += '<td class="text-center">' + data[i].ImporteTotal + '</td>';
					strhtml += '<td class="text-center">' + data[i].TipoCambio + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaFecha + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaTipo + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaSerie + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaNroDoc + '</td>';
					strhtml += '</tr>';

                    ++i;
                };

                // datagrid.currentPage(datagrid.currentPage() + 1);

            };

            $('#gvVenta tbody').html(strhtml);
            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_Compras (_export) {
	precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/compras/compras-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            anhoini: $('#ddlAnhoIni').val(),
            mesini: $('#ddlMesIni').val(),
            anhofin: $('#ddlAnhoFin').val(),
            mesfin: $('#ddlMesFin').val(),
            isexport: _export
        },
        success: function (data) {
        	var strhtml = '';
        	var countdata = data.length;
        	var i = 0;

        	if (countdata > 0) {
                while(i < countdata){
                    // var importe_sinimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_base_imponible).toFixed(2);
                    // var importe_impuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_impuesto).toFixed(2);
                    // var importe_conimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2);

                    strhtml += '<tr>';
					strhtml += '<td class="text-center">' + data[i].CUO + '</td>';
					strhtml += '<td class="text-center">' + data[i].FechaEmision + '</td>';
					strhtml += '<td class="text-center">' + data[i].FechaVencimiento + '</td>';
					strhtml += '<td class="text-center">' + data[i].Tipo + '</td>';
					strhtml += '<td class="text-center">' + data[i].CodAduana + '</td>';
					strhtml += '<td class="text-center">' + data[i].AnhoEmisionDUA + '</td>';
					strhtml += '<td class="text-center">' + data[i].Serie + '-' + data[i].NroDoc + '</td>';
					strhtml += '<td class="text-center">' + data[i].CodSunatDocCli + '</td>';
					strhtml += '<td class="text-center">' + data[i].Numero + '</td>';
					strhtml += '<td class="text-center">' + data[i].Nombres + '</td>';
					strhtml += '<td class="text-center">' + data[i].BaseImponible_EXPORT_GV + '</td>';
					strhtml += '<td class="text-center">' + data[i].Impuesto_EXPORT_GV + '</td>';
					strhtml += '<td class="text-center">' + data[i].BaseImponible_EXPORT_NOGV + '</td>';
					strhtml += '<td class="text-center">' + data[i].Impuesto_EXPORT_NOGV + '</td>';
					strhtml += '<td class="text-center">' + data[i].BaseImponible_NOGV + '</td>';
					strhtml += '<td class="text-center">' + data[i].Impuesto_NOGV + '</td>';
					strhtml += '<td class="text-center">' + data[i].ValorAdqNoGravada + '</td>';
					strhtml += '<td class="text-center">' + data[i].ISC + '</td>';
					strhtml += '<td class="text-center">' + data[i].OtrosTributos + '</td>';
					strhtml += '<td class="text-center">' + data[i].ImporteTotal + '</td>';
					strhtml += '<td class="text-center">' + data[i].NroDocDetraccion + '</td>';
					strhtml += '<td class="text-center">' + data[i].FechaDocDetraccion + '</td>';
					strhtml += '<td class="text-center">' + data[i].TipoCambio + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaFecha + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaTipo + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaSerie + '</td>';
					strhtml += '<td class="text-center">' + data[i].ReferenciaNroDoc + '</td>';
					strhtml += '</tr>';

                    ++i;
                };

                // datagrid.currentPage(datagrid.currentPage() + 1);
            };

            $('#gvCompra tbody').html(strhtml);

            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_Caja (tipo) {
    precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/ventas/caja-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: tipo,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            fechaini: $('#txtFechaIni_Caja').val(),
            fechafin: $('#txtFechaFin').val()
        },
        success: function (data) {
            var selector = '';
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (tipo == 'CUADRE')
                selector = '#gvCaja_Cuadre';
            else if (tipo == 'EFECTIVO')
                selector = '#gvCaja_Efectivo';
            else if (tipo == 'IMPUESTOS')
                selector = '#gvCaja_Impuesto';


            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<tr>';
                    
                    if (tipo == 'CUADRE')
                        strhtml += '<td>' + data[i].CuadreCaja  + '</td>';
                    else if (tipo == 'EFECTIVO')
                        strhtml += '<td>' + data[i].EfectivoCaja  + '</td>';
                    else if (tipo == 'IMPUESTOS')
                        strhtml += '<td>' + data[i].TipoComprobante  + '</td>';
                    
                    strhtml += '<td class="text-right">' + Number(data[i].Importe).toFixed(2) + '</td>';
                    strhtml += '</tr>';

                    ++i;
                };
            };

            $(selector + ' tbody').html(strhtml);

            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_EstadisticaVentas () {
    precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/ventas/ventas-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            anhoini: $('#ddlAnhoIni').val(),
            mesini: $('#ddlMesIni').val(),
            anhofin: $('#ddlAnhoFin').val(),
            mesfin: $('#ddlMesFin').val(),
            idcliente: $('#hdIdCliente').val()
        },
        success: function (data) {
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td class="text-center">' + data[i].nombreArticulo + '</td>';
                    strhtml += '<td class="text-center">' + Number(data[i].td_cantidad) + '</td>';
                    strhtml += '<td class="text-center">' + Number(data[i].td_precio) + '</td>';
                    strhtml += '<td class="text-center">' + Number(data[i].td_subtotal) + '</td>';
                    strhtml += '</tr>';
                    ++i;
                };
            };

            $('#gvEstadisticaVentas tbody').html(strhtml);

            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_Rentabilidad (pagina, _export) {
    precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/insumos/rentabilidad-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            anhoini: $('#ddlAnhoIni').val(),
            mesini: $('#ddlMesIni').val(),
            anhofin: $('#ddlAnhoFin').val(),
            mesfin: $('#ddlMesFin').val(),
            isexport: _export,
            pagina: pagina
        },
        success: function (data) {
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<tr><td class="text-center">' + data[i].tr_nombrearticulo + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tr_costo + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tr_precioventa + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tr_rentabilidad + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tr_porcjrentabilidad + '</td></tr>';
                    ++i;
                };
            };

            $('#gvRentabilidad tbody').html(strhtml);

            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_ControlStock (pagina, _export) {
    precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/insumos/controlstock-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            fechaini: $('#txtFechaIni').val(),
            fechafin: $('#txtFechaFin').val(),
            isexport: _export,
            pagina: pagina
        },
        success: function (data) {
            if (_export == 1) {
                window.location = data.archivo;
            }
            else {
                var selector = '#gvControlStock tbody';
                var strhtml = '';
                var countdata = data.length;
                var i = 0;

                if (countdata > 0) {
                    while(i < countdata){

                        strhtml += '<tr' + (Number(data[i].stock_diferencia) < 0 ? ' class="red white-text"' : '') + '>';

                        strhtml += '<td>' + data[i].insumo + '</td>';
                        strhtml += '<td class="text-center">' + data[i].UM + '</td>';
                        strhtml += '<td class="text-right">' + data[i].stock_almacen + '</td>';
                        strhtml += '<td class="text-right">' + data[i].stock_programado + '</td>';
                        strhtml += '<td class="text-right">' + data[i].stock_diferencia + '</td>';

                        strhtml += '</tr>';
                        ++i;
                    };

                    gvControlStock.currentPage(gvControlStock.currentPage() + 1);

                    if (pagina == '1')
                        $(selector).html(strhtml);
                    else
                        $(selector).append(strhtml);
                };
            };

            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_ControlStockMinimo (pagina, _export) {
    precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/insumos/controlstock-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'2',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            fechaini: $('#txtFechaIni').val(),
            fechafin: $('#txtFechaFin').val(),
            isexport: _export,
            pagina: pagina
        },
        success: function (data) {
            if (_export == 1) {
                window.location = data.archivo;
            }
            else {
                var selector = '#gvControlStockMinimo tbody';
                var strhtml = '';
                var countdata = data.length;
                var i = 0;

                if (countdata > 0) {
                    while(i < countdata){

                        strhtml += '<tr' + (Number(data[i].stock_diferencia) < 0 ? ' class="red white-text"' : '') + '>';

                        strhtml += '<td>' + data[i].insumo + '</td>';
                        strhtml += '<td class="text-center">' + data[i].UM + '</td>';
                        strhtml += '<td class="text-right">' + Number(data[i].stock_almacen).toFixed(3) + '</td>';
                        strhtml += '<td class="text-right">' + Number(data[i].stock_minimo).toFixed(3) + '</td>';
                        strhtml += '<td class="text-right">' + Number(data[i].stock_diferencia).toFixed(3) + '</td>';

                        var stock_porcentaje = typeof data[i].stock_porcentaje !== 'undefined' ? data[i].stock_porcentaje : 0;
                        
                        strhtml += '<td class="text-right">' + Number(stock_porcentaje).toFixed(2) + '</td>';

                        strhtml += '</tr>';
                        ++i;
                    };

                    gvControlStockMinimo.currentPage(gvControlStock.currentPage() + 1);

                    if (pagina == '1')
                        $(selector).html(strhtml);
                    else
                        $(selector).append(strhtml);
                };
            };

            precargaExp('#pnlReports', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Reporte_DetalleVenta (_export) {
    precargaExp('#pnlReports', true);

    $.ajax({
        url: 'services/ventas/detalleventas-report.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val(),
            fechaini: $('#txtFechaIni_Caja').val(),
            fechafin: $('#txtFechaFin').val(),
            isexport: _export
        },
        success: function (data) {
            var selector = '#gvCaja_DetalleVenta tbody';
            var strhtml = '';
            var countdata = data.length;
            var i = 0;
            var total = 0;

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<td class="text-center">' + data[i].TipoComprobante + ' ' + data[i].tm_vserie_documento + '-' + data[i].tm_vnumero_documento + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tm_base_imponible + '</td>';
                    strhtml += '<td class="text-center">0.00</td>';
                    strhtml += '<td class="text-center">' + data[i].tm_base_imponible + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tm_impuesto + '</td>';
                    strhtml += '<td class="text-center">' + data[i].tm_total + '</td>';

                    total += Number(data[i].tm_total);
                    ++i;
                };                
            };

            $(selector).html(strhtml);
            $('#lblTotalDetalleVenta').text('TOTAL: S/. ' + total.toFixed(2));
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function getDataByReference (referencia) {
    var _elemTitulo = $('#pnlConsulta .mdl-layout-title');
	var _titulo = '';

    if (referencia == '#gvCaja'){
        _titulo = 'Caja';
        Reporte_Caja('CUADRE');
        Reporte_Caja('EFECTIVO');
        Reporte_Caja('IMPUESTOS');

        Reporte_DetalleVenta();

        $('#fechaIni_Control').addClass('hide');
        $('#fechaIni_Caja').removeClass('hide');

        $('#rowFechas').removeClass('hide');
        $('.rowFilterCaja, .rowFilterPeriod, .rowFilterPeriod_Ini, .rowFilterPeriod_Fin').addClass('hide');
    }
    else {
        $('#fechaIni_Control').removeClass('hide');
        $('#fechaIni_Caja').addClass('hide');

        $('#rowFechas, .rowFilterCaja').addClass('hide');
        // $('.rowFilterVenta').removeClass('hide');

        if (referencia == '#gvEstadisticaVentas'){
            _titulo = 'Estadistica de Ventas';

            $('.rowFilterPeriod_Ini, .rowFilterPeriod_Fin, #rowCliente, #rowOrden').removeClass('hide');
            $('#rowProveedor, #rowOrden').addClass('hide');

            Reporte_EstadisticaVentas();
        }
        else if (referencia == '#gvVenta'){
            _titulo = 'Ventas SUNAT';
            
            $('.rowFilterPeriod_Ini, .rowFilterPeriod_Fin').removeClass('hide');
            $('.rowFilterPeriod, #rowFechas, #rowCliente, #rowProveedor, #rowTipoProducto, #rowCategoria, #rowOrden, #rowOrdenValor').addClass('hide');

            Reporte_Ventas(0);
        }
        else if (referencia == '#gvCompra'){
            _titulo = 'Compras SUNAT';
            
            $('.rowFilterPeriod_Ini, .rowFilterPeriod_Fin').removeClass('hide');
            $('.rowFilterPeriod, #rowFechas, #rowTipoProducto, #rowCliente, #rowProveedor, #rowCategoria, #rowOrden, #rowOrdenValor').addClass('hide');
            
            Reporte_Compras(0);
        }
        else if (referencia == '#gvRentabilidad'){
            _titulo = 'Margen de ganancia';

            $('#rowFechas, #rowCliente, #rowProveedor, #rowCategoria, #rowOrden').addClass('hide');
            $('#rowTipoProducto, #rowOrden, #rowOrdenValor').removeClass('hide');

            Reporte_Rentabilidad('1');
        }
        else if (referencia == '#gvControlStock'){
            _titulo = 'Control de stock';
            
            $('#rowFechas').removeClass('hide');
            $('.rowFilterCaja, .rowFilterPeriod, .rowFilterPeriod_Ini, .rowFilterPeriod_Fin, #rowCliente, #rowProveedor, #rowTipoProducto, #rowCategoria, #rowOrden, #rowOrdenValor').addClass('hide');
            
            Reporte_ControlStock('1', 0);
        }
        else if (referencia == '#gvControlStockMinimo'){
            _titulo = 'Control de stock mínimo';

            $('#rowFechas').removeClass('hide');
            $('.rowFilterCaja, .rowFilterPeriod, .rowFilterPeriod_Ini, .rowFilterPeriod_Fin, #rowCliente, #rowProveedor, #rowTipoProducto, #rowCategoria, #rowOrden, #rowOrdenValor').addClass('hide');

            Reporte_ControlStockMinimo('1', 0);
        };
    };
    
    _elemTitulo.text(_titulo);
}

function MostrarReporte (_export) {
    toggleOptions_v2('#pnlFiltro', 'left');

    if ($('#gvCaja').is(':visible')){
        if (_export) {
            console.log('sssss');
        }
        else {
            Reporte_Caja('CUADRE');
            Reporte_Caja('EFECTIVO');
            Reporte_Caja('IMPUESTOS');
            Reporte_DetalleVenta();
        };
    }
    else if ($('#gvVenta').is(':visible')){
        Reporte_Ventas(_export);
    }
    else if ($('#gvCompra').is(':visible')){
        Reporte_Compras(_export);
    }
    else if ($('#gvEstadisticaVentas').is(':visible')){
        Reporte_EstadisticaVentas(_export);
    }
    else if ($('#gvRentabilidad').is(':visible')){
        Reporte_Rentabilidad('1', _export);
    }
    else if ($('#gvControlStock').is(':visible')){
        Reporte_ControlStock('1', _export);
    }
    else if ($('#gvControlStockMinimo').is(':visible')){
        Reporte_ControlStockMinimo('1', _export);
    };
}

// function navigateInFrame (alink) {
// 	var url = alink.getAttribute('href');
// 	var tab = alink.getAttribute('data-tab');
// 	var iframe = '<iframe data-tab="' + tab + '" src="' + url + '" scrolling="no" frameborder="0" marginwidth="0" marginheight="0" width="100%" height="100%"></iframe>';
// 	$('.panels iframe').hide();
// 	if ($('.panels > iframe[data-tab="' + tab + '"]').length == 0){
// 		$(iframe).appendTo('.panels').load(function () {
// 			blockLoadWin(false);
//             $(this).contents().find("body, body *").on('click', function(event) {
//                 window.top.hideAllSlidePanels();
//             });
// 		});
// 	}
// 	else
// 		$('.panels > iframe[data-tab="' + tab + '"]').show();

// 	$('.titulo-reporte').text($(alink).find('h2').text());
// 	toggleOptions('#pnlMenu', false);
// }

function ListarCategorias_Combo (){    
    $.ajax({
        type: "GET",
        url: 'services/categorias/categoria-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#ddlCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    strhtml += '<option value="' + data[i].tm_idcategoria + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No existen categor&iacute;as registradas.</option>';

            $('#ddlCategoria').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarCentros () {
    $.ajax({
        type: 'GET',
        url: 'services/centro/centro-empresa.php',
        cache: false,
        dataType: 'json',
        success: function(data){
            var strhtml = '<option value="0">TODOS</option>';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    strhtml += '<option value="' + data[i].tm_idcentro + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlCentro').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}