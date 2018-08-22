$(function() {
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
    Reporte_Ventas();
    $(".date-register").datetimepicker({
        format: "DD/MM/YYYY"
    });
    $("#btnShowFilter").on("click", function(event) {
        event.preventDefault();
        toggleOptions_v2("#pnlFiltro", "left");
    });
    $("#btnCloseFilter").on("click", function(event) {
        event.preventDefault();
        toggleOptions_v2("#pnlFiltro", "left");
    });
    // $('#btnHideMenu').on('click', function(event) {
    // 	event.preventDefault();
    // 	toggleOptions('#pnlMenu', false);
    // });
    $("#gvControlStock").on("scroll", function(event) {
        event.preventDefault();
        gvControlStock.listenerScroll(this, event);
    });
    $("#btnConsultarReporte").on("click", function(event) {
        event.preventDefault();
        MostrarReporte();
    });
    $("#txtSearchCliente").easyAutocomplete({
        url: function(phrase) {
            var _url = "services/clientes/clientes-autocomplete.php";
            _url += "?idempresa=" + $("#hdIdEmpresa").val();
            _url += "&idcentro=" + $("#hdIdCentro").val();
            _url += "&tipobusqueda=3";
            _url += "&criterio=" + phrase;
            return _url;
        },
        getValue: function(element) {
            return element.tm_numerodoc.toLowerCase() + " - " + element.Descripcion;
        },
        list: {
            onSelectItemEvent: function() {
                var value = $("#txtSearchCliente").getSelectedItemData().tm_idtipocliente;
                $("#hdIdCliente").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function(value, item) {
                return item.tm_numerodoc.toLowerCase() + " - " + item.Descripcion;
            }
        },
        theme: "square"
    });
});

var gvControlStock = new DataList("#gvControlStock", {
    onSearch: function() {
        Reporte_ControlStock(gvControlStock.currentPage());
    }
});

function Reporte_Ventas() {
    precargaExp("#pnlReports", true);
    $.ajax({
        url: "services/ventas/ventas-report.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            fechaini: $("#txtFechaIni").val(),
            fechafin: $("#txtFechaFin").val(),
            idcliente: $("#hdIdCliente").val()
        },
        success: function(data) {
            var strhtml = "";
            var countdata = data.length;
            var i = 0;
            if (countdata > 0) {
                while (i < countdata) {
                    // var importe_sinimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_base_imponible).toFixed(2);
                    // var importe_impuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_impuesto).toFixed(2);
                    // var importe_conimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2);
                    strhtml += "<tr>";
                    strhtml += '<td class="text-center">' + data[i].CUO + "</td>";
                    strhtml += '<td class="text-center">' + data[i].FechaEmision + "</td>";
                    strhtml += '<td class="text-center"></td>';
                    strhtml += '<td class="text-center">' + data[i].Tipo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Serie + "</td>";
                    strhtml += '<td class="text-center">' + data[i].NroDoc + "</td>";
                    strhtml += '<td class="text-center">' + data[i].CodSunatDocCli + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Numero + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Nombres + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ValorFac + "</td>";
                    strhtml += '<td class="text-center">' + data[i].BaseImponible + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Exonerada + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Inafecta + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ISC + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Impuesto + "</td>";
                    strhtml += '<td class="text-center">' + data[i].OtrosTributos + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ImporteTotal + "</td>";
                    strhtml += '<td class="text-center">' + data[i].TipoCambio + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaFecha + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaTipo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaSerie + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaNroDoc + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $("#gvVenta tbody").html(strhtml);
            precargaExp("#pnlReports", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function Reporte_Compras() {
    precargaExp("#pnlReports", true);
    $.ajax({
        url: "services/compras/compras-report.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            fechaini: $("#txtFechaIni").val(),
            fechafin: $("#txtFechaFin").val()
        },
        success: function(data) {
            var strhtml = "";
            var countdata = data.length;
            var i = 0;
            if (countdata > 0) {
                while (i < countdata) {
                    // var importe_sinimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_base_imponible).toFixed(2);
                    // var importe_impuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_impuesto).toFixed(2);
                    // var importe_conimpuesto = data[i].SimboloMoneda + ' ' + Number(data[i].tm_total).toFixed(2);
                    strhtml += "<tr>";
                    strhtml += '<td class="text-center">' + data[i].CUO + "</td>";
                    strhtml += '<td class="text-center">' + data[i].FechaEmision + "</td>";
                    strhtml += '<td class="text-center">' + data[i].FechaVencimiento + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Tipo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].CodAduana + "</td>";
                    strhtml += '<td class="text-center">' + data[i].AnhoEmisionDUA + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Serie + "-" + data[i].NroDoc + "</td>";
                    strhtml += '<td class="text-center">' + data[i].CodSunatDocCli + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Numero + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Nombres + "</td>";
                    strhtml += '<td class="text-center">' + data[i].BaseImponible_EXPORT_GV + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Impuesto_EXPORT_GV + "</td>";
                    strhtml += '<td class="text-center">' + data[i].BaseImponible_EXPORT_NOGV + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Impuesto_EXPORT_NOGV + "</td>";
                    strhtml += '<td class="text-center">' + data[i].BaseImponible_NOGV + "</td>";
                    strhtml += '<td class="text-center">' + data[i].Impuesto_NOGV + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ValorAdqNoGravada + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ISC + "</td>";
                    strhtml += '<td class="text-center">' + data[i].OtrosTributos + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ImporteTotal + "</td>";
                    strhtml += '<td class="text-center">' + data[i].NroDocDetraccion + "</td>";
                    strhtml += '<td class="text-center">' + data[i].FechaDocDetraccion + "</td>";
                    strhtml += '<td class="text-center">' + data[i].TipoCambio + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaFecha + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaTipo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaSerie + "</td>";
                    strhtml += '<td class="text-center">' + data[i].ReferenciaNroDoc + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $("#gvCompra tbody").html(strhtml);
            precargaExp("#pnlReports", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function Reporte_Caja(tipo) {
    precargaExp("#pnlReports", true);
    $.ajax({
        url: "services/ventas/caja-report.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: tipo,
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            fecha: $("#txtFecha").val()
        },
        success: function(data) {
            var selector = "";
            var strhtml = "";
            var countdata = data.length;
            var i = 0;
            if (tipo == "CUADRE") selector = "#gvCaja_Cuadre"; else if (tipo == "EFECTIVO") selector = "#gvCaja_Efectivo"; else if (tipo == "IMPUESTOS") selector = "#gvCaja_Impuesto";
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += "<tr>";
                    if (tipo == "CUADRE") strhtml += "<td>" + data[i].CuadreCaja + "</td>"; else if (tipo == "EFECTIVO") strhtml += "<td>" + data[i].EfectivoCaja + "</td>"; else if (tipo == "IMPUESTOS") strhtml += "<td>" + data[i].TipoComprobante + "</td>";
                    strhtml += '<td class="text-right">' + Number(data[i].Importe).toFixed(2) + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $(selector + " tbody").html(strhtml);
            precargaExp("#pnlReports", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function Reporte_EstadisticaVentas() {
    precargaExp("#pnlReports", true);
    $.ajax({
        url: "services/ventas/ventas-report.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "3",
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            fechaini: $("#txtFechaIni").val(),
            fechafin: $("#txtFechaFin").val()
        },
        success: function(data) {
            var strhtml = "";
            var countdata = data.length;
            var i = 0;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += "<tr>";
                    strhtml += '<td class="text-center">' + data[i].nombreArticulo + "</td>";
                    strhtml += '<td class="text-center">' + Number(data[i].td_precio) + "</td>";
                    strhtml += '<td class="text-center">' + Number(data[i].td_cantidad) + "</td>";
                    strhtml += '<td class="text-center">' + Number(data[i].td_subtotal) + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $("#gvEstadisticaVentas tbody").html(strhtml);
            precargaExp("#pnlReports", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function Reporte_Rentabilidad(pagina) {
    precargaExp("#pnlReports", true);
    $.ajax({
        url: "services/insumos/rentabilidad-report.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            fechaini: $("#txtFechaIni").val(),
            fechafin: $("#txtFechaFin").val(),
            pagina: pagina
        },
        success: function(data) {
            var strhtml = "";
            var countdata = data.length;
            var i = 0;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<td class="text-center">' + data[i].tr_nombrearticulo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].tr_costo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].tr_precioventa + "</td>";
                    strhtml += '<td class="text-center">' + data[i].tr_rentabilidad + "</td>";
                    strhtml += '<td class="text-center">' + data[i].tr_porcjrentabilidad + "</td>";
                    ++i;
                }
            }
            $("#gvRentabilidad tbody").html(strhtml);
            precargaExp("#pnlReports", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function Reporte_ControlStock(pagina) {
    precargaExp("#pnlReports", true);
    $.ajax({
        url: "services/insumos/controlstock-report.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            fechaini: $("#txtFechaIni").val(),
            fechafin: $("#txtFechaFin").val(),
            pagina: pagina
        },
        success: function(data) {
            var selector = "#gvControlStock tbody";
            var strhtml = "";
            var countdata = data.length;
            var i = 0;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += "<tr" + (Number(data[i].stock_diferencia) < 0 ? ' class="red white-text"' : "") + ">";
                    strhtml += "<td>" + data[i].insumo + "</td>";
                    strhtml += '<td class="text-center">' + data[i].UM + "</td>";
                    strhtml += '<td class="text-right">' + data[i].stock_almacen + "</td>";
                    strhtml += '<td class="text-right">' + data[i].stock_programado + "</td>";
                    strhtml += '<td class="text-right">' + data[i].stock_diferencia + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
                gvControlStock.currentPage(gvControlStock.currentPage() + 1);
                if (pagina == "1") $(selector).html(strhtml); else $(selector).append(strhtml);
            }
            precargaExp("#pnlReports", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function getDataByReference(referencia) {
    var _elemTitulo = $("#pnlConsulta .mdl-layout-title");
    var _titulo = "";
    if (referencia == "#gvCaja") {
        _titulo = "Caja";
        Reporte_Caja("CUADRE");
        Reporte_Caja("EFECTIVO");
        Reporte_Caja("IMPUESTOS");
        $(".rowFilterCaja").removeClass("hide");
        $(".rowFilterVenta").addClass("hide");
    } else {
        $(".rowFilterCaja").addClass("hide");
        $(".rowFilterVenta").removeClass("hide");
        if (referencia == "#gvEstadisticaVentas") {
            _titulo = "Estadistica de Ventas";
            $("#rowCliente").removeClass("hide");
            $("#rowProveedor").addClass("hide");
            Reporte_EstadisticaVentas();
        } else if (referencia == "#gvVenta") {
            _titulo = "Ventas SUNAT";
            $("#rowCliente").removeClass("hide");
            $("#rowProveedor").addClass("hide");
            $("#rowTipoProducto, #rowCategoria, #rowOrden").removeClass("hide");
            Reporte_Ventas();
        } else if (referencia == "#gvCompra") {
            _titulo = "Compras SUNAT";
            $("#rowTipoProducto, #rowCliente").addClass("hide");
            $("#rowProveedor, #rowCategoria, #rowOrden").removeClass("hide");
            Reporte_Compras();
        } else if (referencia == "#gvRentabilidad") {
            _titulo = "Margen de ganancia";
            $("#rowCliente, #rowProveedor, #rowOrden").addClass("hide");
            $("#rowTipoProducto, #rowCategoria").removeClass("hide");
            Reporte_Rentabilidad("1");
        } else if (referencia == "#gvControlStock") {
            _titulo = "Control de stock";
            $("#rowCliente, #rowProveedor, #rowTipoProducto, #rowCategoria, #rowOrden").addClass("hide");
            Reporte_ControlStock("1");
        }
    }
    _elemTitulo.text(_titulo);
}

function MostrarReporte() {
    toggleOptions_v2("#pnlFiltro", "left");
    if ($("#gvCaja").is(":visible")) {
        Reporte_Caja("CUADRE");
        Reporte_Caja("EFECTIVO");
        Reporte_Caja("IMPUESTOS");
    } else if ($("#gvVenta").is(":visible")) {
        Reporte_Ventas();
    } else if ($("#gvCompra").is(":visible")) {
        Reporte_Compras();
    } else if ($("#gvEstadisticaVentas").is(":visible")) {
        Reporte_EstadisticaVentas();
    } else if ($("#gvControlStock").is(":visible")) {
        Reporte_ControlStock("1");
    }
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
function ListarCategorias_Combo() {
    $.ajax({
        type: "GET",
        url: "services/categorias/categoria-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val()
        },
        success: function(data) {
            var strhtml = "";
            var i = 0;
            var countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<option value="' + data[i].tm_idcategoria + '">' + data[i].tm_nombre + "</option>";
                    ++i;
                }
            } else strhtml = '<option value="0">No existen categor&iacute;as registradas.</option>';
            $("#ddlCategoria").html(strhtml);
        },
        error: function(error) {
            console.log(error);
        }
    });
}