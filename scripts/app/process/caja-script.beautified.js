$(function() {
    var operators = [ "+", "-", "x", "÷" ];
    var operations = [ "clientes", "atencion", "ventas", "compras", "menu", "ver-caja", "operar-caja", "imprimir", "cobrar" ];
    var decimalAdded = false;
    ComprobarApertura();
    $("#chkClienteDefault").on("change", function(event) {
        event.preventDefault();
        var flag = this.checked;
        habilitarOptionCliente(!flag);
        if (flag == false) {
            if ($("#rbObtenerCliente")[0].checked) {
                habilitarControl("#txtSearchCliente", true);
                habilitarClienteNatural(false);
                habilitarClienteJuridico(false);
                habilitarControl("#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente", false);
            } else {
                habilitarControl("#txtSearchCliente", false);
                if ($("#hdTipoCliente").val() == "NA") {
                    habilitarClienteNatural(true);
                    habilitarClienteJuridico(false);
                } else {
                    habilitarClienteNatural(false);
                    habilitarClienteJuridico(true);
                }
                habilitarControl("#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente", true);
            }
        } else {
            habilitarControl("#txtSearchCliente", false);
            habilitarClienteNatural(false);
            habilitarClienteJuridico(false);
            habilitarControl("#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente", false);
        }
    });
    $("#pnlCobranza").on("change", 'input:radio[name="rbRegCliente"]', function(event) {
        habilitarModuloCliente(this.value);
    });
    $("#txtSearchCliente").easyAutocomplete({
        url: function(phrase) {
            return "services/clientes/clientes-autocomplete.php?criterio=" + phrase + "&tipobusqueda=3";
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
    $("#ddlTurnoApertura").on("change", function(event) {
        event.preventDefault();
        ListarPersonalPorTurno($(this).val());
    });
    $(".calc").on("click", "button", function(event) {
        event.preventDefault();
        var input = document.getElementsByClassName("screen")[0];
        var inputVal = input.value;
        var btnVal = this.getAttribute("data-value");
        var btnAction = this.getAttribute("data-action");
        if (operations.indexOf(btnVal) > -1) {
            if (btnVal == "ver-caja") {
                $(".lblFechaHoy").text(GetToday());
                openModalCallBack("#pnlCajaActual", function() {});
            } else if (btnVal == "operar-caja") {
                if (btnAction == "abrir") {
                    $("#hdFechaHoraApertura").val(moment().format("YYYY-MM-D hh:mm:ss"));
                    openModalCallBack("#pnlAperturaCaja", function() {
                        ListarPersonalPorTurno($("#ddlTurnoApertura").val());
                    });
                } else openCustomModal("#pnlCierreCaja");
            } else if (btnVal == "cobrar") GestionarCobranza(); else {
                var module_id = config[btnVal].id;
                window.top.document.querySelector('.mdl-card[data-id="' + module_id + '"]').trigger("click");
            }
        } else {
            if (btnVal == "C") {
                input.value = "";
                decimalAdded = false;
            } else if (btnVal == "=") {
                var equation = inputVal;
                var lastChar = equation[equation.length - 1];
                equation = equation.replace(/x/g, "*").replace(/÷/g, "/");
                if (operators.indexOf(lastChar) > -1 || lastChar == ".") equation = equation.replace(/.$/, "");
                if (equation) input.value = eval(equation);
                decimalAdded = false;
            } else if (operators.indexOf(btnVal) > -1) {
                var lastChar = inputVal[inputVal.length - 1];
                if (inputVal != "" && operators.indexOf(lastChar) == -1) input.value += btnVal; else if (inputVal == "" && btnVal == "-") input.value += btnVal;
                if (operators.indexOf(lastChar) > -1 && inputVal.length > 1) input.value = inputVal.replace(/.$/, btnVal);
                decimalAdded = false;
            } else if (btnVal == ".") {
                if (!decimalAdded) {
                    input.value += btnVal;
                    decimalAdded = true;
                }
            } else {
                var moneda = this.getAttribute("data-idmoneda");
                if (moneda != null) input.value = btnVal; else input.value += btnVal;
            }
            calcularCambio(input.value);
        }
    });
    $("#btnInfoOrden").on("click", function(event) {
        event.preventDefault();
        if ($(this).hasClass("active")) {
            $(this).removeClass("active").attr("data-tooltip", "M&aacute;s informaci&oacute;n").html('<i class="left material-icons">&#xE88E;</i> M&aacute;s informaci&oacute;n');
            $("#pnlInfoOrden").fadeOut(300, function() {
                $("#pnlDetalleOrden").fadeIn(300, function() {});
            });
        } else {
            $(this).addClass("active").attr("data-tooltip", "Volver al detalle de orden").html('<i class="left material-icons">&#xE5C4;</i> Volver al detalle de orden');
            $("#pnlDetalleOrden").fadeOut(300, function() {
                $("#pnlInfoOrden").fadeIn(300, function() {});
            });
        }
    });
    $("#btnCobrar").on("click", function(event) {
        event.preventDefault();
        GuardarCobranza();
    });
    $("#btnImprimir").on("click", function(event) {
        event.preventDefault();
        window.print();
    });
    $("#chkPagoTarjeta").on("change", function(event) {
        var monto_tarjeta = 0;
        if (this.checked) {
            var monto_pago = Number($("#lblTotalPago .monto").text());
            var monto_cobro = Number($("#lblTotalCobro .monto").text());
            monto_tarjeta = monto_pago > 0 ? monto_cobro - monto_pago : monto_cobro;
        }
        $("#txtImporteTarjeta").val(monto_tarjeta.toFixed(2));
    });
    $("#datetimepickerFHA").datetimepicker({
        inline: true,
        locale: "es",
        format: "D/MM/YYYY hh:mm A"
    });
    $("#btnCloseFechaHoraApertura").on("click", function(event) {
        event.preventDefault();
        toggleOptions_v2("#pnlFechaHora", "left");
    });
    $("#btnMostrarFechaHoraApertura").on("click", function(event) {
        event.preventDefault();
        toggleOptions_v2("#pnlFechaHora", "left");
    });
    // $('#btnEstablecerFechaHoraApertura').on('click', function(event) {
    //     event.preventDefault();
    //     var _fechahoraApertura = $('#datetimepickerFHA').data('date');
    //     $('#lblFechaHoraApertura').text(_fechahoraApertura);
    //     $('#hdFechaHoraApertura').val(_fechahoraApertura);
    //     toggleOptions_v2('#pnlFechaHora', 'left');
    // });
    $("#btnRegistrarApertura").on("click", function(event) {
        event.preventDefault();
        RegistrarAperturaCaja();
    });
    $("#btnRegistrarMovCaja").on("click", function(event) {
        event.preventDefault();
        RegistrarMovCaja();
    });
    $("#btnCerrarCaja").on("click", function(event) {
        event.preventDefault();
        CerrarCaja();
    });
    $("#pnlCajaActual .btn-group").on("click", "button", function(event) {
        event.preventDefault();
        var tipomov = this.getAttribute("data-tipomov");
        $(this).siblings(".btn-primary").removeClass("btn-primary");
        $(this).addClass("btn-primary");
        AperturaByDefault();
    });
    $("#btnAddMovimiento").on("click", function(event) {
        event.preventDefault();
        openCustomModal("#pnlRegMovimientoCaja");
    });
    $("#txtSearchPersonal").easyAutocomplete({
        url: function(phrase) {
            return "services/organigrama/organigrama-search.php?criterio=" + phrase + "&tipobusqueda=1&idempresa=" + $("#hdIdEmpresa").val() + "&idcentro=" + $("#hdIdCentro").val();
        },
        getValue: function(element) {
            return element.tm_nrodni.toLowerCase() + " - " + element.tm_apellidopaterno + " " + element.tm_apellidomaterno;
        },
        list: {
            onSelectItemEvent: function() {
                var value = $("#txtSearchPersonal").getSelectedItemData().tm_idpersonal;
                $("#hdIdPersona").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function(value, item) {
                return item.tm_nrodni.toLowerCase() + " - " + item.tm_apellidopaterno + " " + item.tm_apellidomaterno;
            }
        },
        theme: "square"
    });
});

function habilitarModuloCliente(manejador) {
    if (manejador == "GET") {
        habilitarControl("#txtSearchCliente", true);
        habilitarClienteNatural(false);
        habilitarClienteJuridico(false);
        habilitarControl("#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente", false);
    } else {
        habilitarControl("#txtSearchCliente", false);
        if ($("#hdTipoCliente").val() == "NA") {
            habilitarClienteNatural(true);
            habilitarClienteJuridico(false);
        } else {
            habilitarClienteNatural(false);
            habilitarClienteJuridico(true);
        }
        habilitarControl("#ddlTipoDocCliente,#txtNroDocCliente,#txtDireccionCliente,#txtTelefonoCliente,#txtEmailCliente", true);
    }
}

function ListarAperturas() {
    $.ajax({
        type: "GET",
        url: "services/ventas/aperturacaja-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "3",
            fecha: GetToday()
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += "<tr>";
                    strhtml += "<td>" + (i + 1) + "</td>";
                    strhtml += "<td>" + data[i].tm_apellidopaterno + " " + data[i].tm_apellidomaterno + " " + data[i].tm_nombres + "</td>";
                    strhtml += "<td>" + data[i].NombreMoneda + "</td>";
                    strhtml += "<td>" + data[i].tm_monto_inicial + "</td>";
                    strhtml += "<td>" + data[i].tm_monto_final + "</td>";
                    strhtml += "<td>" + data[i].Turno + "</td>";
                    strhtml += "<td>" + data[i].Estado + "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
            }
            $("#tableAperturaDia tbody").html(strhtml);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function RegistrarAperturaCaja() {
    var data = new FormData();
    var input_data = $("#pnlAperturaCaja :input").serializeArray();
    data.append("btnRegistrarApertura", "btnRegistrarApertura");
    Array.prototype.forEach.call(input_data, function(fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        type: "POST",
        url: "services/ventas/caja-post.php",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        data: data,
        success: function(data) {
            createSnackbar(data.titulomsje);
            if (data.rpta != "0") {
                closeCustomModal("#pnlAperturaCaja");
                AperturaByDefault();
                habilitarCaja(true);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function RegistrarMovCaja() {
    var data = new FormData();
    var input_data = $("#pnlRegMovimientoCaja :input").serializeArray();
    data.append("btnRegistrarMovCaja", "btnRegistrarMovCaja");
    data.append("hdIdAperturaCaja", $("#hdIdAperturaCaja").val());
    data.append("hdIdPersona", $("#hdIdPersona").val());
    data.append("hdIdMoneda", $("#hdIdMoneda").val());
    data.append("hdTipoDataPersona", $("#hdTipoDataPersona").val());
    Array.prototype.forEach.call(input_data, function(fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        type: "POST",
        url: "services/ventas/caja-post.php",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        data: data,
        success: function(data) {
            createSnackbar(data.titulomsje);
            if (data.rpta != "0") {
                $("#pnlCajaActual .btn-group button.btn-primary").removeClass("btn-primary");
                $('#pnlCajaActual .btn-group button[data-tipomov="' + $("#ddlTipoMovimiento").val() + '"]').addClass("btn-primary");
                closeCustomModal("#pnlRegMovimientoCaja");
                AperturaByDefault();
            }
        }
    });
}

function CerrarCaja() {
    var data = new FormData();
    var input_data = $("#pnlCierreCaja :input").serializeArray();
    data.append("btnCerrarCaja", "btnCerrarCaja");
    data.append("hdIdAperturaCaja", $("#hdIdAperturaCaja").val());
    Array.prototype.forEach.call(input_data, function(fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        url: "services/ventas/caja-post.php",
        type: "POST",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        data: data,
        success: function(data) {
            createSnackbar(data.titulomsje);
            if (data.rpta != "0") {
                closeCustomModal("#pnlCierreCaja");
                $("#pnlCajaActual .btn-group button").removeClass("btn-primary").first().trigger("click");
                AperturaByDefault();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function habilitarOptionCliente(flag) {
    habilitarControl('input:radio[name="rbRegCliente"]', flag);
}

function habilitarClienteNatural(flag) {
    habilitarControl(".rowClienteNatural input:text", flag);
}

function habilitarClienteJuridico(flag) {
    habilitarControl(".rowClienteJuridico input:text", flag);
}

function LimpiarCobranza() {
    $("#ddlNombreTarjeta")[0].selectedIndex = 0;
    $("#txtNumeroTarjeta").val("");
    $("#txtImporteTarjeta").val("");
    $("#hdIdCliente").val("");
    $("#ddlTipoDocCliente")[0].selectedIndex = 0;
    $("#txtNroDocCliente").val("");
    $("#txtApePaternoCliente").val("");
    $("#txtApeMaternoCliente").val("");
    $("#txtNombresCliente").val("");
    $("#txtRazonSocialCliente").val("");
    $("#txtDireccionCliente").val("");
    $("#txtTelefonoCliente").val("");
    $("#txtEmailCliente").val("");
}

function MostrarPanelCobranza() {
    LimpiarCobranza();
    if (Number($("#lblTotalPago .monto").text()) == 0) {
        var total_cobro = $("#lblTotalCobro .monto").text();
        $("#lblTotalPago .monto").text(total_cobro);
        $("#lblEfectivoPago").text(total_cobro);
    }
    openModalCallBack("#pnlCobranza", function() {
        habilitarOptionCliente(!$("#chkClienteDefault")[0].checked);
    });
}

function MostrarTipoDocCliente(codigotributable) {
    $.ajax({
        url: "services/documentos/documentos-tributables.php",
        type: "GET",
        dataType: "json",
        data: {
            codigotributable: codigotributable
        },
        success: function(data) {
            var strhtml = "";
            var i = 0;
            var countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<option value="' + data[i].tm_iddocident + '">' + data[i].tm_descripcion + "</option>";
                    ++i;
                }
            } else strhtml = '<option value="0">No hay tipos de documento para este tipo de cliente.</option>';
            $("#ddlTipoDocCliente").html(strhtml);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function GestionarCobranza() {
    $.ajax({
        url: "services/tipocomprobante/tipocomprobante-search.php",
        type: "GET",
        dataType: "json",
        data: {
            param1: "value1"
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            if (countdata > 0) {
                while (i < countdata) {
                    var _checked = i == 0 ? " checked" : "";
                    strhtml += '<p><input class="with-gap" name="rbTipoComprobante" type="radio" id="rbTipoComprobante' + data[i].tm_idtipocomprobante + '" value="' + data[i].tm_idtipocomprobante + '"' + _checked + ' /><label for="rbTipoComprobante' + data[i].tm_idtipocomprobante + '">' + data[i].tm_nombre + "</label></p>";
                    ++i;
                }
                strhtml = '<div class="scrollbarra">' + strhtml + "</div>";
                MessageBox({
                    title: "Seleccione tipo de comprobante",
                    content: strhtml,
                    width: "320px",
                    height: "230px",
                    buttons: [ {
                        primary: true,
                        content: "Continuar",
                        onClickButton: function(event) {
                            var _rbTipoComprobante = $('input[name="rbTipoComprobante"]:checked').val();
                            $("#hdTipoComprobante").val(_rbTipoComprobante);
                            if (_rbTipoComprobante == "2") {
                                $("#hdTipoCliente").val("JU");
                                $(".rowClienteNatural").addClass("hide");
                                $(".rowClienteJuridico").removeClass("hide");
                                calcultarTotalFinal(_rbTipoComprobante);
                                MostrarTipoDocCliente("6");
                            } else {
                                $("#hdTipoCliente").val("NA");
                                $(".rowClienteNatural").removeClass("hide");
                                $(".rowClienteJuridico").addClass("hide");
                                calcultarTotalFinal(_rbTipoComprobante);
                                MostrarTipoDocCliente("1");
                            }
                            MostrarPanelCobranza();
                        }
                    } ],
                    cancelButton: true
                });
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
    $("#lblEfectivoPago .monto").text($("#lblTotalPago .monto").text());
    $("#lblEfectivoCambio .monto").text($("#lblTotalCambio .monto").text());
}

function GuardarCobranza() {
    var data = new FormData();
    var input_caja = $("#pnlCaja :input").serializeArray();
    var input_cobranza = $("#pnlCobranza :input").serializeArray();
    data.append("btnCobrar", "btnCobrar");
    Array.prototype.forEach.call(input_caja, function(fields) {
        data.append(fields.name, fields.value);
    });
    Array.prototype.forEach.call(input_cobranza, function(fields) {
        data.append(fields.name, fields.value);
    });
    data.append("hdIdAperturaCaja", $("#hdIdAperturaCaja").val());
    data.append("hdTotalSinImpuesto", $("#lblTotalSinImpuesto .monto").text());
    data.append("hdImpuesto", $("#lblImpuesto .monto").text());
    data.append("hdTotalConImpuesto", $("#lblTotalConImpuesto .monto").text());
    $.ajax({
        url: "services/ventas/caja-post.php",
        type: "POST",
        dataType: "json",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            createSnackbar(respuesta.titulomsje);
            if (respuesta.rpta != "0") {
                $("#titleOrden").text("Orden #:");
                $("#gvArticuloMenu tbody").html("");
                $("#lblTotalCobro .monto").text("0.00");
                $("#lblTotalCambio .monto").text("0.00");
                $("#lblTotalPago .monto").text("0.00");
                var datosVenta = respuesta.datosVenta;
                habilitarControl("#btnCobrar", false);
                habilitarControl("#btnImprimir", true);
                // closeCustomModal('#pnlCobranza');
                // openModalCallBack('#modalImpresion', function () {
                // });
                var groups = _.groupBy(datosVenta, function(value) {
                    return value.CodigoVenta + "#" + value.Cliente + "#" + value.SimboloMoneda + "#" + value.TipoComprobante;
                });
                var data = _.map(groups, function(group) {
                    return {
                        CodigoVenta: group[0].CodigoVenta,
                        Cliente: group[0].Cliente,
                        SimboloMoneda: group[0].SimboloMoneda,
                        TipoComprobante: group[0].TipoComprobante,
                        tm_base_imponible: group[0].tm_base_imponible,
                        tm_impuesto: group[0].tm_impuesto,
                        tm_total: group[0].tm_total,
                        list_articulos: group
                    };
                });
                var countdata = data.length;
                var strhtml = "";
                if (countdata > 0) {
                    var simbolo_moneda = data[0].SimboloMoneda;
                    $("#lblTipoComprobante_print").text(data[0].TipoComprobante);
                    $("#lblCodigoVenta_print").text(data[0].CodigoVenta);
                    $("#lblFechaHora_print").text(moment().format("DD/MM/YYYY hh:mm:ss"));
                    $("#lblNombreCliente_print").text(data[0].Cliente);
                    $("#lblTotal_print").text(simbolo_moneda + Number(data[0].tm_base_imponible).toFixed(2));
                    $("#lblImpuestos_print").text(simbolo_moneda + Number(data[0].tm_impuesto).toFixed(2));
                    $("#lblTotalImp_print").text(simbolo_moneda + Number(data[0].tm_total).toFixed(2));
                    var articulos = data[0].list_articulos;
                    var count_articulos = 0;
                    if (articulos.length == 1) {
                        if (articulos[0].nombreArticulo.trim().length == 0) count_articulos = 0; else count_articulos = 1;
                    } else count_articulos = articulos.length;
                    var j = 0;
                    if (count_articulos > 0) {
                        while (j < count_articulos) {
                            strhtml += "<tr>";
                            strhtml += "<td>" + articulos[j].nombreArticulo + "</td>";
                            strhtml += "<td>" + articulos[j].td_cantidad + "</td>";
                            strhtml += "<td>" + simbolo_moneda + Number(articulos[j].td_precio).toFixed(2) + "</td>";
                            strhtml += "<td>" + simbolo_moneda + Number(articulos[j].td_subtotal).toFixed(2) + "</td>";
                            strhtml += "</tr>";
                            ++j;
                        }
                    }
                }
                $(".performance-facts__table tbody").html(strhtml);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function calcularCambio(total_pago) {
    var _pago = 0;
    var total_cambio = 0;
    var total_orden = Number($("#lblTotalCobro .monto").text());
    console.log(isNaN(total_pago));
    if (!isNaN(total_pago)) {
        if (total_pago.length > 0) _pago = Number(total_pago);
        if (_pago > 0) total_cambio = _pago - total_orden;
    }
    $("#lblTotalPago .monto").text(_pago.toFixed(2));
    $("#lblTotalCambio .monto").text(total_cambio.toFixed(2));
}

function ListarPersonalPorTurno(turno) {
    var selector = "#gvPersonalTurno .gridview-content";
    $.ajax({
        type: "GET",
        url: "services/organigrama/organigrama-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "3",
            turno: turno
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            if (countdata > 0) {
                while (i < countdata) {
                    var iditem = data[i].tm_idpersonal;
                    var foto = data[i].tm_foto;
                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';
                    if (foto == "no-set") strhtml += '<i class="material-icons circle">&#xE853;</i>'; else strhtml += '<img src="' + foto + '" alt="" class="circle">';
                    strhtml += '<span class="title descripcion">' + data[i].tm_apellidopaterno + " " + data[i].tm_apellidomaterno + " " + data[i].tm_nombres + "</span>";
                    strhtml += '<p><span class="docidentidad">RUC: ' + data[i].tm_nrodni + "</span> -  " + data[i].tm_email + "</p>";
                    strhtml += '<div class="divider"></div>';
                    strhtml += "</li>";
                    ++i;
                }
                $(selector).html(strhtml);
            } else $(selector).html("<h2>No se encontraron resultados.</h2>");
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function buildMenu(data) {
    var countdata = data.length;
    var total_orden = 0;
    var strhtml = "";
    if (countdata > 0) {
        if (data[0].nombreProducto.length > 0) {
            var i = 0;
            while (i < countdata) {
                var cantidad = data[i].td_cantidad;
                var precio = Number(data[i].td_precio).toFixed(2);
                var subtotal = Number(data[i].td_subtotal);
                strhtml += '<tr data-idmodel="' + data[i].tm_idproducto + '" class="dato">';
                strhtml += '<td class="hide">';
                // strhtml += '<label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkDetalle' + i + '"><input name="mc_articulo[' + i + '][chkDetalle]" type="checkbox" id="chkDetalle' + i + '" class="mdl-checkbox__input check-articulo" value="0"><span class="mdl-checkbox__label"></span></label>';
                strhtml += '<input name="mc_articulo[' + i + '][iddetalle]" type="hidden" id="iddetalle' + i + '" value="' + data[i].td_idatencion_articulo + '" /><input name="mc_articulo[' + i + '][tipomenudia]" type="hidden" id="tipomenudia' + i + '" value="' + data[i].ta_tipomenudia + '" /><input name="mc_articulo[' + i + '][idproducto]" type="hidden" id="idproducto' + i + '" value="' + data[i].tm_idproducto + '" /></td>';
                strhtml += '<td data-title="Articulo" class="v-align-middle nombre-articulo">' + data[i].nombreProducto;
                // strhtml += '<input type="hidden" class="subtotal" name="mc_articulo[' + i + '][subtotal]" id="subtotal' + i + '" value="' + precio.toFixed(2) + '" />';
                // strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size"><input class="mdl-textfield__input observacion hide" type="text" name="mc_articulo[' + i + '][observacion]" id="observacion' + i + '" placeholder="Ingresa aqu&iacute; m&aacute;s detalles sobre el art&iacute;culo" value=""><label class="mdl-textfield__label" for="observacion' + i + '"></label></div>';
                strhtml += "</td>";
                strhtml += '<td data-title="Cantidad" class="text-right">';
                // strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size"><input disabled class="mdl-textfield__input align-right cantidad" type="text" name="mc_articulo[' + i + '][cantidad]" id="cantidad' + i + '" value="1"><label class="mdl-textfield__label" for="cantidad' + i + '"></label></div>';
                strhtml += '<input type="hidden" name="mc_articulo[' + i + '][cantidad]" id="cantidad' + i + '" value="' + cantidad + '">' + cantidad;
                strhtml += "</td>";
                strhtml += '<td data-title="Precio" class="text-right">';
                // strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size"><input disabled class="mdl-textfield__input align-right precio" type="text" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + precio.toFixed(2) + '"><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
                strhtml += '<input type="hidden" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + precio + '">' + precio;
                strhtml += "</td>";
                strhtml += '<td data-title="Subtotal" class="text-right">';
                strhtml += '<input type="hidden" name="mc_articulo[' + i + '][subtotal]" id="subtotal' + i + '" value="' + subtotal.toFixed(2) + '">' + subtotal.toFixed(2);
                strhtml += "</td>";
                strhtml += '<td><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></td>';
                strhtml += "</tr>";
                total_orden += subtotal;
                ++i;
            }
        }
    }
    $("#gvArticuloMenu tbody").html(strhtml);
    $("#lblTotalCobro .monto").text(total_orden.toFixed(2));
}

function calcultarTotalFinal(tipocomprobante) {
    var valor_impuesto = .18;
    var total_orden = Number($("#lblTotalCobro .monto").text());
    var impuestos = 0;
    var total_sin_impuesto = total_orden;
    if (tipocomprobante == "2") {
        impuestos = total_orden * valor_impuesto;
        total_sin_impuesto = total_orden - impuestos;
    }
    $("#lblTotalSinImpuesto .monto").text(total_sin_impuesto.toFixed(2));
    $("#lblImpuesto .monto").text(impuestos.toFixed(2));
    $("#lblTotalConImpuesto .monto").text(total_orden.toFixed(2));
}

function getOrden(idorden) {
    $.ajax({
        url: "services/atencion/atencion-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "ONE-ATENCION",
            idatencion: idorden
        },
        success: function(result) {
            var groups = _.groupBy(result, function(value) {
                return value.tm_idatencion + "#" + value.tm_nroatencion + "#" + value.tm_fechahora;
            });
            var data = _.map(groups, function(group) {
                return {
                    tm_idatencion: group[0].tm_idatencion,
                    tm_nroatencion: group[0].tm_nroatencion,
                    tm_fechahora: group[0].tm_fechahora,
                    list_articulos: group
                };
            });
            var countdata = data.length;
            if (countdata > 0) {
                $("#hdIdOrden").val(data[0].tm_nroatencion);
                $("#titleOrden").text("Orden #: " + data[0].tm_nroatencion);
                buildMenu(data[0].list_articulos);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function LimpiarCaja() {
    $("#hdIdAperturaCaja").val("0");
    $("#hdIdMoneda").val("0");
    $("#lblFechaRegistroCaja").text("");
    $("#lblTurnoCaja").text("");
    $("#lblMonedaInicial").text("");
    $("#lblImporteInicial").text("0.00");
    $("#lblMonedaActual").text("");
    $("#lblImporteActual").text("0.00");
    $("#lblMonedaTotalCaja").text("");
    $("#lblImporteTotalCaja").text("0.00");
    $("#tableRegistroCaja .ibody tbody").html("");
}

function ListarMovimientoCaja(idregistrocaja) {
    var tipomov = $("#pnlCajaActual .btn-group button.btn-primary").attr("data-tipomov");
    precargaExp("#tableRegistroCaja", true);
    $.ajax({
        type: "GET",
        url: "services/ventas/detalleapertura-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            idregistrocaja: idregistrocaja,
            tipomov: tipomov
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            // var totalcaja = 0;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += "<tr>";
                    strhtml += "<td>" + (i + 1) + "</td>";
                    strhtml += "<td>" + data[i].Concepto + "</td>";
                    strhtml += "<td>" + data[i].FechaReg.split(" ")[1] + "</td>";
                    strhtml += "<td>" + data[i].Moneda + "</td>";
                    strhtml += "<td>" + data[i].tm_monto_mn + "</td>";
                    strhtml += "<td>" + data[i].tm_observacion + "</td>";
                    strhtml += "</tr>";
                    // totalcaja = totalcaja + Number(data[i].tm_monto_mn);
                    ++i;
                }
            }
            $("#tableRegistroCaja tbody").html(strhtml);
            // $('#lblImporteTotalCaja').text(totalcaja.toFixed(2));
            precargaExp("#tableRegistroCaja", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function habilitarCaja(flag) {
    var content_btncaja = "";
    var action_btncaja = "";
    var tooltip_btncaja = "";
    if (flag) {
        content_btncaja = '<span class="fa fa-lock md-36"></span>';
        action_btncaja = "cerrar";
        tooltip_btncaja = "Cerrar caja";
    } else {
        content_btncaja = '<span class="fa fa-unlock md-36"></span>';
        action_btncaja = "abrir";
        tooltip_btncaja = "Abrir caja";
    }
    $('.calc button[data-value="operar-caja"]').html(content_btncaja).attr({
        "data-action": action_btncaja,
        title: tooltip_btncaja,
        "data-original-title": tooltip_btncaja
    });
    habilitarControl('.calc button[data-value!="operar-caja"]', flag);
}

function ComprobarApertura() {
    $.ajax({
        url: "services/ventas/aperturacaja-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "2",
            fecha: GetToday()
        },
        success: function(data) {
            var countdata = data.length;
            var flag = countdata > 0 ? true : false;
            habilitarCaja(flag);
            AperturaByDefault();
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function AperturaByDefault() {
    $.ajax({
        type: "GET",
        url: "services/ventas/aperturacaja-search.php",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            fecha: GetToday()
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            LimpiarCaja();
            if (countdata > 0) {
                $("#hdIdAperturaCaja").val(data[0].tm_idregistro_caja);
                $("#hdIdMoneda").val(data[0].tm_idmoneda);
                $("#lblFechaRegistroCaja").text(ConvertMySQLDate(data[0].tm_fecharegistro));
                $("#lblTurnoCaja").text(data[0].Turno);
                $("#lblMonedaIngreso").text(data[0].SimboloMoneda);
                $("#lblImporteIngreso").text(Number(data[0].tm_monto_ingreso).toFixed(2));
                $("#lblMonedaSalida").text(data[0].SimboloMoneda);
                $("#lblImporteSalida").text(Number(data[0].tm_monto_salida).toFixed(2));
                $("#lblMonedaInicial").text(data[0].SimboloMoneda);
                $("#lblImporteInicial").text(Number(data[0].tm_monto_inicial).toFixed(2));
                $("#lblMonedaActual").text(data[0].SimboloMoneda);
                $("#lblImporteActual").text(Number(data[0].tm_monto_actual).toFixed(2));
                // $('#lblMonedaTotalCaja').text(data[0].SimboloMoneda);
                // $('#btnAperturaCaja').addClass('oculto');
                // $('#btnRegistrarMovimiento, #btnCierreCaja').removeClass('oculto');
                ListarMovimientoCaja(data[0].tm_idregistro_caja);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}