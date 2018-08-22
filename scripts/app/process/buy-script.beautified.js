$(function() {
    GetIdAperturaCaja();
    BuscarDatos("1");
    $("#btnBackCaja").on("click", function(event) {
        event.preventDefault();
    });
    $("#ddlTipoComprobante").on("change", function(event) {
        event.preventDefault();
        CalcularTotal();
    });
    $("#chkImpuesto").on("change", function(event) {
        event.preventDefault();
        CalcularTotal();
    });
    $("#starks-panel .scrollbarra").on("scroll", function(event) {
        gvInsumo.listenerScroll(this, event);
    });
    $("#cantidad_custom0").on("keyup", function(event) {
        var cantidad = Number(this.value);
        var precio = Number(document.getElementById("precio_custom0").value);
        var subtotal = cantidad * precio;
        $("#subtotal_custom0").val(subtotal.toFixed(2)).parent().find("h4").text(subtotal.toFixed(2));
    });
    $("#precio_custom0").on("keyup", function(event) {
        var cantidad = Number(document.getElementById("cantidad_custom0").value);
        var precio = Number(this.value);
        var subtotal = cantidad * precio;
        $("#subtotal_custom0").val(subtotal.toFixed(2)).parent().find("h4").text(subtotal.toFixed(2));
    });
    // $('#lannisters-panel .scrollbarra').on('scroll', function(event){
    //     gvArticulo.listenerScroll(this, event);
    // });
    $("#ddlNombreTarjeta").on("change", function(event) {
        event.preventDefault();
        ExtraerComisionTarjeta();
    });
    $("#btnBackToList").on("click", function(event) {
        event.preventDefault();
        BackToList();
    });
    $("#pnlProveedor").on("change", 'input:radio[name="rbRegProveedor"]', function(event) {
        habilitarModuloProveedor(this.value);
    });
    $("#txtSearchProveedor").easyAutocomplete({
        url: function(phrase) {
            var _url = "services/proveedores/proveedores-search.php";
            _url += "?idempresa=" + $("#hdIdEmpresa").val();
            _url += "&idcentro=" + $("#hdIdCentro").val();
            _url += "&tipobusqueda=3";
            _url += "&criterio=" + phrase;
            return _url;
        },
        getValue: function(element) {
            return element.tm_numerodoc.toLowerCase() + " - " + element.tm_nombreproveedor;
        },
        list: {
            onSelectItemEvent: function() {
                var value = $("#txtSearchProveedor").getSelectedItemData().tm_idproveedor;
                $("#hdIdProveedor").val(value).trigger("change");
            }
        },
        template: {
            type: "custom",
            method: function(value, item) {
                return item.tm_numerodoc.toLowerCase() + " - " + item.tm_nombreproveedor;
            }
        },
        theme: "square"
    });
    $("#btnAddProveedor").on("click", function(event) {
        event.preventDefault();
        seleccionarProveedor();
    });
    // $('#btnCancelar, #btnBackList').on('click', function (event) {
    //     event.preventDefault();
    //     removeValidCompra();
    //     resetForm('form1');
    //     Limpiar();
    //     BackToList();
    //     $('#btnGuardar, #btnBuscarItems, #btnCancelar').addClass('oculto');
    //     $('#btnNuevo, #btnPlanificacionCompra').removeClass('oculto');
    //     return false;
    // });
    // $('#btnBackForm').on('click', function (event) {
    //     event.preventDefault();
    //     $('#btnGuardar, #btnBuscarItems, #btnCancelar').removeClass('oculto');
    //     $('#btnMoreFilter, #btnPlanificacionCompra').addClass('oculto');
    //     BackToForm();
    //     return false;
    // });
    $("#ddlMoneda").on("change", function(event) {
        event.preventDefault();
        ExtraerTipoCambio();
        ExtraerSimboloMoneda();
    });
    $("#btnEditTarjeta").on("click", function(event) {
        event.preventDefault();
        openModalCallBack("#pnlInfoTarjeta", function() {
            LimpiarTarjeta();
        });
    });
    $("#ddlFormaPago").on("change", function(event) {
        event.preventDefault();
        var codigosunat = $("#ddlFormaPago option:selected").attr("data-codigosunat");
        if (codigosunat == "005") {
            $("#btnEditTarjeta").removeClass("hide");
            openModalCallBack("#pnlInfoTarjeta", function() {
                LimpiarTarjeta();
            });
        } else $("#btnEditTarjeta").addClass("hide");
    });
    $("#btnCloseInfoTarjeta").on("click", function(event) {
        event.preventDefault();
        // if (!$('#form1').valid()) {
        LimpiarTarjeta();
        // };
        closeCustomModal("#pnlInfoTarjeta");
        // removeValidTarjeta();
        $("#ddlFormaPago")[0].selectedIndex = $('#ddlFormaPago option[data-codigosunat="009"]').index();
    });
    $("#btnLimpiarTarjeta").on("click", function(event) {
        event.preventDefault();
        LimpiarTarjeta();
    });
    $("#btnAplicarTarjeta").on("click", function(event) {
        event.preventDefault();
        AplicarTarjeta();
    });
    $("#btnNuevo").on("click", function(event) {
        event.preventDefault();
        // resetForm('form1');
        mostrarAlmacen($("#chkIngresoAutomatico")[0].checked);
        Limpiar();
        //addValidCompra();
        // ExtraerTipoCambio();
        GoToEdit("0");
    });
    $("#btnBuscarItems").on("click", function(event) {
        event.preventDefault();
        MostrarPanelItems();
    });
    $("#btnBackToList_FromGuia").on("click", function(event) {
        event.preventDefault();
        $("#pnlGuia").fadeOut(400, function() {
            $("#pnlForm").fadeIn(400, function() {});
        });
    });
    $("#pnlForm .title-window button").on("click", function(event) {
        $(this).siblings(".success").removeClass("success");
        $(this).addClass("success");
        if ($(this).attr("data-tipocompra") == "01") {
            $("#dateMenu").calendar({
                multiSelect: true,
                getDates: function(data) {},
                click: function(d) {}
            });
            openCustomModal("#pnlRequerimiento");
        }
    });
    $("#tableDetalle tbody").on("click", 'a[data-action="delete"]', function(event) {
        event.preventDefault();
        var _row = getParentsUntil(this, "#tableDetalle", "tr");
        $(_row[0]).remove();
        CalcularTotal();
    });
    $("#tableDetalle tbody").on("keyup", 'input[type="number"]', function(event) {
        var _input = event.target;
        var precio = 0;
        var cantidad = 0;
        var _row = getParentsUntil(_input, "#tableDetalle", "tr");
        _row = _row[0];
        if (_input.classList.contains("cantidad")) {
            cantidad = _input.value;
            precio = _row.getElementsByClassName("precio")[0].value;
        } else {
            cantidad = _row.getElementsByClassName("cantidad")[0].value;
            precio = _input.value;
        }
        var subtotal = cantidad * precio;
        var field_subtotal = _row.getElementsByClassName("subtotal")[0];
        field_subtotal.getElementsByTagName("input")[0].value = subtotal.toFixed(2);
        field_subtotal.getElementsByTagName("h4")[0].innerHTML = subtotal.toFixed(2);
        CalcularTotal();
    });
    // $('#pnlProductos .title-window button').on('click', function (event) {        
    //     event.preventDefault();
    //     var codtipoproducto = $(this).attr('data-item');
    //     $(this).siblings('.success').removeClass('success');
    //     $(this).addClass('success');
    //     if (codtipoproducto == '00'){
    //         $('#precargaInsu').fadeIn(function () {
    //             if ($('#gvInsumo .gridview .tile').length == 0)
    //                 ListarInsumos();
    //         });
    //         $('#precargaProd').hide();
    //     }
    //     else {
    //         $('#precargaProd').fadeIn(function () {
    //             if ($('#gvProductos .gridview .tile').length == 0)
    //                 listarProductos('1');
    //         });
    //         $('#precargaInsu').hide();
    //     };
    //     $('#hdTipoProducto').val(codtipoproducto);
    // });
    $("#pnlInfoProveedor").on("click", function(event) {
        event.preventDefault();
        openCustomModal("#pnlProveedor");
    });
    // $('#btnInfoImporte').on('click', function(event) {
    //     event.preventDefault();
    //     if (!$(this).hasClass('active')){
    //         $(this).addClass('active');
    //         $('#pnlInfoImporte').stop(true, true)
    //         .show( "clip",{direction: "vertical"}, 400 )
    //         .animate({ opacity : 1 }, { duration: 400, queue: false });
    //     }
    //     else {
    //         $(this).removeClass('active');
    //         $('#pnlInfoImporte').stop(true, true)
    //         .hide( "clip",{direction: "vertical"}, 400 )
    //         .animate({ opacity : 0 }, { duration: 400, queue: false });
    //     };
    // });
    $("#txtSearchProd").keyup(function(event) {
        // if (event.keyCode == $.ui.keyCode.ENTER){
        AlternarBusquedaItems();
    }).keypress(function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) return false;
    });
    // $('#btnSearchProducts').on('click', function(event) {
    //     event.preventDefault();
    //     if ($('#btnArticulo').hasClass('success'))
    //         listarProductos('1');
    //     else
    //         ListarInsumos('1');
    // });
    // $('#btnSaveProveedor').on('click', function(event) {
    //     var nrodoc = '';
    //     var descripcion = '';
    //     var direccion = '';
    //     event.preventDefault();
    //     nrodoc = $('#txtRucEmpresa').val();
    //     direccion = $('#txtDireccionJur').val();    
    //     descripcion = $('#txtRazonSocial').val();
    //     setProveedor('0', '000', nrodoc, descripcion, direccion);
    // });
    // $('#gvInsumo .gridview').on('click', '.tile', function(event) {
    //     var idinsumo = '0';
    //     event.preventDefault();
    //     idinsumo = $(this).attr('data-idproducto');
    //     LimpiarInputProducto();
    //     $('#hdIdProducto').val(idinsumo);
    //     $('#lblDescripProducto').text($(this).find('p strong').text());
    //     listarPresentaciones(idinsumo);
    //     openCustomModal('#pnlInfoProducto');
    // });
    // $('#gvProductos .gridview').on('click', '.tile', function(event) {
    //     event.preventDefault();
    //     LimpiarInputProducto();
    //     $('#hdIdProducto').val($(this).attr('data-idproducto'));
    //     $('#lblDescripProducto').text($(this).find('span.label').text());
    //     openCustomModal('#pnlInfoProducto');
    // });
    // $('#btnProductoAdd').on('click', function(event) {
    //     event.preventDefault();
    //     AddDetalle();
    // });
    // $('#btnHidePnlInfoProducto').on('click', function (event) {
    //     event.preventDefault();
    //     closeCustomModal('#pnlInfoProducto');
    //     // removeValidInfoProd();
    // });
    // $('#btnLimpiarSeleccion').on('click', function(event) {
    //     event.preventDefault();
    //     $(this).addClass('oculto');
    //     if ($('#pnlListado').is(':visible')){
    //         $('#gvDatos .gridview .tile.selected').removeClass('selected');
    //     }
    //     else {
    //         $('#tableDetalle tbody tr.selected').removeClass('selected');
    //         $('#btnQuitarItem').addClass('oculto');
    //         $('#btnBuscarItems').removeClass('oculto');
    //     };
    // });
    // $('#tableDetalle tbody').on('click', 'tr', function(event) {
    //     event.preventDefault();
    //     if ($(this).hasClass('selected')){
    //         $(this).removeClass('selected');
    //         if ($('#tableDetalle tbody tr.selected').length == 0){
    //             $('#btnQuitarItem, #btnLimpiarSeleccion').addClass('oculto');
    //             $('#btnBuscarItems').removeClass('oculto');
    //         }
    //     }
    //     else {
    //         $(this).addClass('selected');
    //         $('#btnQuitarItem, #btnLimpiarSeleccion').removeClass('oculto');
    //         $('#btnBuscarItems').addClass('oculto');
    //     };
    // });
    // $('#btnQuitarItem').on('click', function(event) {
    //     event.preventDefault();
    //     removeArticulos();
    // });
    $("#btnGuardar").on("click", function(event) {
        event.preventDefault();
        Guardar();
    });
    // cargarDatePicker('#txtFecha', function (dateText, inst) {
    //     $('#txtSerieComprobante').focus();
    // });
    // $('#txtFecha').pickadate({
    //     selectMonths: true,
    //     selectYears: 15,
    //     format: 'dd/mm/yyyy'
    // });
    $(".date-register").datetimepicker({
        format: "DD/MM/YYYY"
    });
    // $('#chkIngresoAutomatico').on('change', function(event) {
    //     mostrarAlmacen(this.checked);
    // });
    $("#btnSelectDetalleCompra").on("click", function(event) {
        event.preventDefault();
        openModalCallBack("#pnlProductos", function() {
            ListarInsumos("1");
        });
    });
    $("#gvInsumo tbody").on("click", "input:checkbox", function(event) {
        var _row = getParentsUntil(this, "#gvInsumo", "tr");
        var _selectPresentacion = _row[0].getElementsByClassName("select-presentacion")[0];
        var _inputCantidad = _row[0].getElementsByClassName("cantidad")[0];
        var _inputPrecio = _row[0].getElementsByClassName("precio")[0];
        var _inputSubtotal = _row[0].getElementsByClassName("subtotal")[0].getElementsByTagName("input")[0];
        var _labelSubtotal = _row[0].getElementsByTagName("h4")[0];
        if (this.checked) {
            _selectPresentacion.removeAttribute("disabled");
            _inputCantidad.removeAttribute("disabled");
            _inputPrecio.removeAttribute("disabled");
            _labelSubtotal.classList.remove("grey-text");
            _inputCantidad.focus();
            habilitarControl("#btnAddItemsCompra", true);
        } else {
            _selectPresentacion.setAttribute("disabled", "");
            _inputCantidad.setAttribute("disabled", "");
            _inputCantidad.value = "";
            _inputPrecio.value = "";
            _inputSubtotal.value = "";
            _inputPrecio.setAttribute("disabled", "");
            _labelSubtotal.classList.add("grey-text");
            _labelSubtotal.innerHTML = "0.00";
            if ($("#gvInsumo input:checked").length == 0) habilitarControl("#btnAddItemsCompra", false);
        }
    });
    // $('#gvArticulo tbody').on('click', 'input:checkbox', function(event) {
    //     var _row = getParentsUntil(this, '#gvArticulo', 'tr');
    //     var selectUnidadMedida = _row[0].getElementsByClassName('select-unidadmedida')[0];
    //     var _inputCantidad = _row[0].getElementsByClassName('cantidad')[0];
    //     var _inputPrecio = _row[0].getElementsByClassName('precio')[0];
    //     var _inputSubtotal = _row[0].getElementsByClassName('subtotal')[0].getElementsByTagName('input')[0];
    //     var _labelSubtotal = _row[0].getElementsByTagName('h4')[0];
    //     if (this.checked) {
    //         selectUnidadMedida.removeAttribute('disabled');
    //         _inputCantidad.removeAttribute('disabled');
    //         _inputPrecio.removeAttribute('disabled');
    //         _labelSubtotal.classList.remove('grey-text');
    //         _inputCantidad.focus();
    //         habilitarControl('#btnAddItemsCompra', true);
    //     }
    //     else {
    //         selectUnidadMedida.setAttribute('disabled', '');
    //         _inputCantidad.setAttribute('disabled', '');
    //         _inputCantidad.value = '';
    //         _inputPrecio.value = '';
    //         _inputSubtotal.value = '';
    //         _inputPrecio.setAttribute('disabled', '');
    //         _labelSubtotal.classList.add('grey-text');
    //         _labelSubtotal.innerHTML = '0.00';
    //         if ($('#gvArticulo input:checked').length == 0)
    //             habilitarControl('#btnAddItemsCompra', false);
    //     };
    // });
    $("#gvInsumo tbody").on("keyup", 'input[type="number"]', function(event) {
        var _input = event.target;
        var precio = 0;
        var cantidad = 0;
        var _row = getParentsUntil(_input, "#gvInsumo", "tr");
        _row = _row[0];
        if (_input.classList.contains("cantidad")) {
            cantidad = _input.value;
            precio = _row.getElementsByClassName("precio")[0].value;
        } else {
            cantidad = _row.getElementsByClassName("cantidad")[0].value;
            precio = _input.value;
        }
        var subtotal = cantidad * precio;
        var field_subtotal = _row.getElementsByClassName("subtotal")[0];
        field_subtotal.getElementsByTagName("input")[0].value = subtotal.toFixed(2);
        field_subtotal.getElementsByTagName("h4")[0].innerHTML = subtotal.toFixed(2);
    });
    // $('#gvArticulo tbody').on('keyup', 'input[type="number"]', function(event) {
    //     var _input = event.target;
    //     var precio = 0;
    //     var cantidad = 0;
    //     var _row = getParentsUntil(_input, '#gvArticulo', 'tr');
    //     _row = _row[0];
    //     if (_input.classList.contains('cantidad')) {
    //         cantidad = _input.value;
    //         precio = _row.getElementsByClassName('precio')[0].value;
    //     }
    //     else {
    //         cantidad = _row.getElementsByClassName('cantidad')[0].value;
    //         precio = _input.value;
    //     };
    //     var subtotal = cantidad * precio;
    //     var field_subtotal = _row.getElementsByClassName('subtotal')[0];
    //     field_subtotal.getElementsByTagName('input')[0].value = subtotal.toFixed(2);
    //     field_subtotal.getElementsByTagName('h4')[0].innerHTML = subtotal.toFixed(2);
    // });
    $("#tabAddItemsCompra").on("click", ".mdl-tabs__tab", function(event) {
        var _tab = this;
        var accion = _tab.hash.substring(1);
        var flag = false;
        if (accion == "rogers-panel") {
            flag = true;
            $(".mdl-textfield--expandable").addClass("hide");
        } else {
            $(".mdl-textfield--expandable").removeClass("hide");
            flag = false;
            // else if (accion == 'lannisters-panel'){
            //     flag = ($('#gvArticulo input:checkbox:checked').length > 0);
            //     if ($('#gvArticulo tbody tr').length == 0)
            //         ListarArticulos('1');
            // };
            ListarInsumos("1");
        }
        habilitarControl("#btnAddItemsCompra", flag);
    });
    $("#btnAddItemsCompra").on("click", function(event) {
        event.preventDefault();
        AgregarItemsCompra();
    });
});

var gvDatos = new DataList("#gvDatos", {
    onSearch: function() {
        BuscarDatos(gvDatos.currentPage());
    }
});

var gvInsumo = new DataList("#gvInsumo", {
    onSearch: function() {
        ListarInsumos(gvInsumo.currentPage());
    }
});

// var gvArticulo = new DataList('#gvArticulo', {
//     onSearch: function () {
//         ListarArticulos(gvArticulo.currentPage());
//     }
// });
function mostrarAlmacen(flag) {
    if (flag) $("#gpAlmacen").removeClass("oculto"); else $("#gpAlmacen").addClass("oculto");
}

function LimpiarTarjeta() {
    $("#ddlNombreTarjeta")[0].selectedIndex = 0;
    ExtraerComisionTarjeta();
    $("#txtCodigoRecibo").val("");
    Materialize.updateTextFields();
}

// function addValidTarjeta () {
//     $('#txtComisionTarjeta').rules('add', {
//         required: true,
//         maxlength: 11,
//         min: 0
//     });
//     $('#txtCodigoRecibo').rules('add', {
//         required: true
//     });
// }
// function removeValidTarjeta () {
//     $('#txtComisionTarjeta').rules('remove');
//     $('#txtCodigoRecibo').rules('remove');
// }
// function removeArticulos () {
//     $('#tableDetalle tbody tr.selected').fadeOut(300, function() {
//         var objSubTotal = $(this).find('.subtotal');
//         var SubTotal = 0;
//         var totalPedido = 0;
//         totalPedido = Number($('#hdTotalConImpuesto').val());
//         SubTotal = Number(objSubTotal.text());
//         totalPedido = totalPedido - SubTotal;
//         $('#lblImporteCobro').text(totalPedido.toFixed(2));
//         $('#hdTotalConImpuesto').val(totalPedido.toFixed(2));
//         $(this).remove();
//     });
//     $('#btnQuitarItem, #btnLimpiarSeleccion').addClass('oculto');
//     $('#btnBuscarItems').removeClass('oculto');
// }
function AlternarBusquedaItems() {
    if (!$("#rogers-panel").hasClass("is-active")) ListarInsumos("1");
}

function LimpiarInfoProveedor() {
    $(".pnlInfoProveedor .descripcion").text("Elegir proveedor...");
    $(".pnlInfoProveedor .docidentidad").text("");
    $(".pnlInfoProveedor .direccion").text("");
}

function LimpiarFormProveedor() {
    $("#txtRazonSocial").val("");
    $("#txtRucEmpresa").val("");
    $("#txtDireccionJur").val("");
}

function Limpiar() {
    $("#txtFecha").val(GetToday());
    $("#ddlTipoComprobante")[0].selectedIndex = 0;
    $("#ddlMoneda")[0].selectedIndex = 0;
    $("#ddlFormaPago")[0].selectedIndex = 0;
    $("#txtSerieComprobante").val("");
    $("#txtNroComprobante").val("");
    ExtraerSimboloMoneda();
    ExtraerTipoCambio();
    LimpiarTarjeta();
    LimpiarInfoProveedor();
    $("#tableDetalle tbody tr").remove();
    cuentafila = 0;
    CalcularTotal();
}

function LimpiarInputProducto() {
    $("#ddlUnidadMedida")[0].selectedIndex = 0;
    $("#txtCantidad").val("");
    $("#txtPrecioRef").val("");
}

function CalcularTotal() {
    var rows = $("#tableDetalle tbody tr");
    var idtipocomprobante = $("#ddlTipoComprobante option:selected").attr("data-codigosunat");
    var countdata = rows.length;
    var i = 0;
    // var total_baseimponible = 0;
    // var total_impuesto = 0;
    var total_conimpuesto = 0;
    var impuesto = .18;
    if (countdata > 0) {
        while (i < countdata) {
            total_conimpuesto += Number(rows[i].getElementsByClassName("subtotal")[0].getElementsByTagName("input")[0].value);
            ++i;
        }
    }
    var total_baseimponible = 0;
    var total_impuesto = 0;
    if ($("#chkImpuesto")[0].checked) {
        total_baseimponible = idtipocomprobante == "01" ? total_conimpuesto / (1 + impuesto) : total_conimpuesto;
        total_impuesto = idtipocomprobante == "01" ? total_conimpuesto * impuesto : 0;
    }
    // var impuestoPorCompra = 0;
    // var totalSinImpuesto = 0;
    // var totalConImpuesto = 0;
    // var totalImpuesto = 0;
    // var list = $('#pnlInfoImporte h3.total.impuesto');
    // var idtipocomprobante = $('#ddlTipoComprobante option:selected').attr('data-codigosunat');
    // var countItemsImp = list.length;
    // for (i = 0; i < count; i++) {
    //     totalConImpuesto = totalConImpuesto + Number($(rows[i]).find('td.subtotal').text());
    // };
    // if (countItemsImp > 0){
    //     for (i = 0; i < countItemsImp; i++){
    //         var impuesto = Number(list[i].getAttribute("data-valorimpuesto"));
    //         var subtotalImpuesto = totalConImpuesto - (totalConImpuesto / (1 + impuesto));
    //         totalImpuesto = totalImpuesto + subtotalImpuesto;
    //         if (list[i].innerText != null)
    //             list[i].innerText  = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
    //         else
    //             list[i].textContent = (idtipocomprobante == "01" ? subtotalImpuesto.toFixed(2) : '0.00');
    //     }
    //     if (idtipocomprobante == "01")
    //         totalSinImpuesto = totalConImpuesto - totalImpuesto;
    //     else
    //         totalSinImpuesto = totalConImpuesto;
    // }
    $("#lblTotalSinImpuesto .monto").text(total_baseimponible.toFixed(2));
    $("#lblTotalImpuesto .monto").text(total_impuesto.toFixed(2));
    $("#lblTotalConImpuesto .monto").text(total_conimpuesto.toFixed(2));
    $("#hdTotalSinImpuesto").val(total_baseimponible.toFixed(2));
    $("#hdTotalImpuesto").val(total_impuesto.toFixed(2));
    $("#hdTotalConImpuesto").val(total_conimpuesto.toFixed(2));
}

function Guardar() {
    var data = new FormData();
    var input_data = $("#pnlForm :input").serializeArray();
    var input_proveedor = $("#pnlProveedor :input").serializeArray();
    data.append("btnGuardar", "btnGuardar");
    data.append("hdIdAperturaCaja", $("#hdIdAperturaCaja").val());
    Array.prototype.forEach.call(input_data, function(fields) {
        data.append(fields.name, fields.value);
    });
    Array.prototype.forEach.call(input_proveedor, function(fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        type: "POST",
        url: "services/compras/compras-post.php",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        data: data,
        success: function(data) {
            createSnackbar(data.titulomsje);
            if (data.rpta != "0") {
                if ($("#chkIngresoAutomatico")[0].checked) BackToList(); else {
                    $("#pnlForm").fadeOut(400, function() {
                        $("#pnlGuia").fadeIn(400, function() {});
                    });
                }
                // removeValidCompra();
                BuscarDatos("1");
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

// function addValidInfoProd () {
//     $('#txtCantidad').rules('add', {
//         required: true,
//         number: true
//     });
//     $('#txtPrecioRef').rules('add', {
//         required: true,
//         number: true
//     });
// }
// function removeValidInfoProd () {
//     $('#txtCantidad').rules('remove');
//     $('#txtPrecioRef').rules('remove');
// }
// function addValidCompra() {
//     $('#txtSerieComprobante').rules('add', {
//         required: true,
//         maxlength: 30
//     });
//     $('#txtNroComprobante').rules('add', {
//         required: true,
//         maxlength: 30
//     });
// }
// function removeValidCompra () {
//     $('#txtSerieComprobante').rules('remove');
//     $('#txtNroComprobante').rules('remove');
// }
var cuentafila = 0;

function createItem_DetalleCompra(iddetalle, idproducto, descripcion, idpresentacion, idunidadmedida, presentacion_unidadmedida, medidapre, cantidad, precio, subtotal, codtipoproducto) {
    var strhtml = "";
    strhtml += "<tr>";
    strhtml += "<td>" + (cuentafila + 1) + "</td>";
    strhtml += '<td data-title="Descripci&oacute;n" class="v-align-middle">';
    strhtml += '<input name="mc_itemcompra[' + cuentafila + '][iddetalle]" type="hidden" id="iddetalle' + cuentafila + '" value="' + iddetalle + '" /><input name="mc_itemcompra[' + cuentafila + '][idproducto]" type="hidden" id="idproducto' + cuentafila + '" value="' + idproducto + '" /><input name="mc_itemcompra[' + cuentafila + '][descripcion]" type="hidden" id="descripcion' + cuentafila + '" value="' + descripcion + '" /><input name="mc_itemcompra[' + cuentafila + '][codtipoproducto]" type="hidden" id="codtipoproducto' + cuentafila + '" value="' + codtipoproducto + '" /><input name="mc_itemcompra[' + cuentafila + '][medidapre]" type="hidden" id="medidapre' + cuentafila + '" value="' + medidapre + '" />';
    strhtml += descripcion;
    strhtml += "</td>";
    strhtml += '<td data-title="Presentaci&oacute;n - UM" class="v-align-middle">' + presentacion_unidadmedida + '<input name="mc_itemcompra[' + cuentafila + '][idpresentacion]" type="hidden" id="idpresentacion' + cuentafila + '" value="' + idpresentacion + '" /><input name="mc_itemcompra[' + cuentafila + '][idunidadmedida]" type="hidden" id="idunidadmedida' + cuentafila + '" value="' + idunidadmedida + '" /></td>';
    strhtml += '<td data-title="Cantidad">';
    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input no-margin align-right cantidad" type="number" step="any" name="mc_itemcompra[' + cuentafila + '][cantidad]" id="cantidad_compra' + cuentafila + '" value="' + cantidad + '"><label class="mdl-textfield__label" for="cantidad_compra' + cuentafila + '"></label></div>';
    strhtml += "</td>";
    strhtml += '<td data-title="Precio">';
    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input no-margin align-right precio" type="number" step="any" name="mc_itemcompra[' + cuentafila + '][precio]" id="precio_compra' + cuentafila + '" value="' + precio + '"><label class="mdl-textfield__label" for="precio_compra' + cuentafila + '"></label></div>';
    strhtml += "</td>";
    strhtml += '<td data-title="SubTotal" class="subtotal"><input type="hidden" name="mc_itemcompra[' + cuentafila + '][subtotal]" id="subtotal_compra' + cuentafila + '" value="' + subtotal + '"><h4 class="grey-text text-right">' + subtotal + "</h4></td>";
    strhtml += '<td><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></td>';
    strhtml += "</tr>";
    return strhtml;
}

function LimpiarPreSeleccion_compra() {
    if ($("#starks-panel").hasClass("is-active")) {
        $("#gvInsumo input:checkbox").prop("checked", false);
        $("#gvInsumo .precio").val("");
        $("#gvInsumo .cantidad").val("");
        $("#gvInsumo .subtotal input:hidden").val("");
        $("#gvInsumo .subtotal h4").text("0.00").addClass("grey-text");
    } else {
        $("#descripcion_custom0").val("");
        $("#cantidad_custom0").val("");
        $("#precio_custom0").val("");
        $("#subtotal_custom0").val("");
    }
    habilitarControl("#btnAddItemsCompra", false);
}

function AgregarItemsCompra() {
    var strhtml = "";
    var _checkeds;
    var countdata = 0;
    var i = 0;
    var idproducto = 0;
    var descripcion = "";
    var idpresentacion = 0;
    var idunidadmedida = 0;
    var medidapre = 0;
    var cantidad = 0;
    var precio = 0;
    var subtotal = 0;
    if ($("#rogers-panel").hasClass("is-active")) {
        descripcion = $("#descripcion_custom0").val();
        precio = Number($("#cantidad_custom0").val());
        cantidad = Number($("#precio_custom0").val());
        subtotal = Number($("#subtotal_custom0").val());
        var strhtml = createItem_DetalleCompra("0", idproducto, descripcion, idpresentacion, idunidadmedida, "", medidapre, cantidad, precio, subtotal, "02");
        ++cuentafila;
    } else {
        _checkeds = $("#gvInsumo input:checkbox:checked");
        countdata = _checkeds.length;
        var tipoinsumo = $("#tabAddItemsCompra .mdl-tabs__tab:first-child").hasClass("is-active") ? "00" : "01";
        if (countdata > 0) {
            while (i < countdata) {
                _row = getParentsUntil(_checkeds[i], "#gvInsumo", "tr");
                _selectPresentacion = _row[0].getElementsByClassName("select-presentacion")[0];
                idpresentacion = _selectPresentacion.value;
                idunidadmedida = _selectPresentacion.options[_selectPresentacion.selectedIndex].getAttribute("data-idunidadmedida");
                medidapre = _selectPresentacion.options[_selectPresentacion.selectedIndex].getAttribute("data-medidapre");
                presentacion_unidadmedida = _selectPresentacion.options[_selectPresentacion.selectedIndex].text;
                idproducto = _checkeds[i].value;
                descripcion = _row[0].getElementsByClassName("descripcion")[0].innerHTML;
                cantidad = _row[0].getElementsByClassName("cantidad")[0].value;
                precio = _row[0].getElementsByClassName("precio")[0].value;
                subtotal = _row[0].getElementsByClassName("subtotal")[0].getElementsByTagName("input")[0].value;
                strhtml += createItem_DetalleCompra("0", idproducto, descripcion, idpresentacion, idunidadmedida, presentacion_unidadmedida, medidapre, cantidad, precio, subtotal, tipoinsumo);
                ++cuentafila;
                ++i;
            }
        }
    }
    $("#tableDetalle tbody").append(strhtml);
    CalcularTotal();
    LimpiarPreSeleccion_compra();
}

function setProveedor(idproveedor, nrodoc, descripcion) {
    $("#hdIdProveedor").val(idproveedor);
    $(".pnlInfoProveedor").attr("data-idproveedor", idproveedor);
    $(".pnlInfoProveedor .docidentidad").text(nrodoc);
    $(".pnlInfoProveedor .descripcion").text(descripcion);
}

function seleccionarProveedor() {
    var idproveedor = "0";
    var nrodoc = "";
    var descripcion = "";
    if ($("#rbObtenerProveedor")[0].checked) {
        var _nombreseleccionado = $("#txtSearchProveedor").val();
        idproveedor = $("#hdIdProveedor").val();
        nrodoc = _nombreseleccionado.split("-")[0];
        descripcion = _nombreseleccionado.split("-")[1];
    } else {
        nrodoc = $("#txtNroDocProveedor").val();
        descripcion = $("#txtRazonSocialProveedor").val();
    }
    setProveedor(idproveedor, nrodoc, descripcion);
    closeCustomModal("#pnlProveedor");
}

function BackToList() {
    // $('#btnBuscarItems, #btnGuardar, #btnCancelar').addClass('oculto');
    // $('#btnPlanificacionCompra, #btnNuevo').removeClass('oculto');
    $("#pnlForm").fadeOut(500, function() {
        $("#pnlListado").fadeIn(500, function() {});
    });
}

function BackToForm() {
    $("#pnlProductos").fadeOut(500, function() {
        $("#pnlForm").fadeIn(500, function() {});
    });
}

// function MostrarPanelItems () {
//     //clearSelection();
//     $('#btnBuscarItems, #btnPlanificacionCompra, #btnGuardar, #btnCancelar').addClass('oculto');
//     $('#btnMoreFilter').removeClass('oculto');
//     $('#pnlForm').fadeOut(400, function () {
//         $('#pnlProductos').fadeIn(400, function () {
//             if ($("#gvProductos .gridview .tile").length == 0){
//                 ListarInsumos('1');
//             }
//         });
//     });
// }
function ExtraerTipoCambio() {
    var valor = $("#ddlMoneda option:selected").attr("data-tipocambio");
    $("#txtTipoCambio").val(valor);
}

function ExtraerSimboloMoneda() {
    var valor = $("#ddlMoneda option:selected").attr("data-simbolo");
    $("#lblMonedaCobro").text(valor);
}

function ExtraerComisionTarjeta() {
    var valor = $("#ddlNombreTarjeta option:selected").attr("data-comision");
    $("#txtComisionTarjeta").val(valor);
}

function GoToEdit(idItem) {
    $("#pnlListado").fadeOut(500, function() {
        $("#pnlForm").fadeIn(500, function() {
            if (idItem != "0") {
                $.ajax({
                    type: "GET",
                    url: "services/compras/compras-search.php",
                    cache: false,
                    data: {
                        tipobusqueda: "3",
                        id: idItem
                    },
                    dataType: "json",
                    success: function(data) {},
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });
    });
}

function ListarInsumos(pagina) {
    var tipo = "";
    if ($("#tabAddItemsCompra .mdl-tabs__tab:first-child").hasClass("is-active")) tipo = "1"; else tipo = "2";
    $.ajax({
        url: "services/insumos/insumos-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "INSUMO-PRESENTACION",
            tipo: tipo,
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            idcategoria: $("#hdIdCategoria").val(),
            idsubcategoria: "0",
            criterio: $("#txtSearchProd").val(),
            pagina: pagina
        },
        success: function(result) {
            var i = 0;
            var strhtml = "";
            var selector = "#gvInsumo tbody";
            var groups = _.groupBy(result, function(value) {
                return value.idarticulo + "#" + value.nombre + "#" + value.tipoinsumo;
            });
            var data = _.map(groups, function(group) {
                return {
                    idarticulo: group[0].idarticulo,
                    nombre: group[0].nombre,
                    tipoinsumo: group[0].tipoinsumo,
                    list_presentacion: group
                };
            });
            var countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    var j = 0;
                    var presentacion = data[i].list_presentacion;
                    var count_presentacion = 0;
                    if (presentacion.length > 0) {
                        if (presentacion[0].Presentacion.length == 0) count_presentacion = 0; else count_presentacion = presentacion.length;
                    }
                    // var count_presentacion = presentacion.length;
                    strhtml += "<tr>";
                    strhtml += "<td>";
                    if (count_presentacion > 0) {
                        strhtml += '<input type="checkbox" class="filled-in" id="chkInsumo' + i + '" value="' + data[i].idarticulo + '" /><label for="chkInsumo' + i + '"></label>';
                    }
                    strhtml += "</td>";
                    strhtml += '<td data-title="Insumo/Articulo" class="descripcion">' + data[i].nombre + "</td>";
                    strhtml += '<td data-title="Presentacion"><select disabled class="select-presentacion browser-default">';
                    if (count_presentacion > 0) {
                        while (j < count_presentacion) {
                            if (typeof presentacion[j] !== "undefined") strhtml += '<option value="' + presentacion[j].idpresentacion + '" data-idunidadmedida="' + presentacion[j].idunidadmedida + '" data-medidapre="' + presentacion[j].medida_presentacion + '">' + presentacion[j].Presentacion + (presentacion[j].Presentacion.length == 0 ? "" : " - ") + presentacion[j].UM + "</option>";
                            ++j;
                        }
                    } else strhtml += '<option value="0" data-idunidadmedida="0">No hay presentaciones</option>';
                    strhtml += "</select></td>";
                    strhtml += '<td data-title="Cantidad">';
                    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right cantidad" type="number" step="any" id="cantidad' + i + '" value=""><label class="mdl-textfield__label" for="cantidad' + i + '"></label></div>';
                    strhtml += "</td>";
                    strhtml += '<td data-title="Precio">';
                    strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right precio" type="number" step="any" id="precio' + i + '" value=""><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
                    strhtml += "</td>";
                    strhtml += '<td data-title="SubTotal" class="subtotal">';
                    strhtml += '<input type="hidden" id="subtotal' + i + '" value="0"><h4 class="grey-text text-right">0.00</h4>';
                    strhtml += "</td>";
                    strhtml += "</tr>";
                    ++i;
                }
                gvInsumo.currentPage(gvInsumo.currentPage() + 1);
                if (pagina == "1") $(selector).html(strhtml); else $(selector).append(strhtml);
            } else {
                if (pagina == "1") $(selector).html("");
                habilitarControl("#btnAddItemsCompra", false);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

// function ListarArticulos (pagina) {
//     // precargaExp('#gvProductos', true);
//     $.ajax({
//         url: 'services/productos/productos-search.php',
//         type: 'GET',
//         cache: false,
//         dataType: 'json',
//         data: {
//             tipobusqueda:'04',
//             idcategoria: $('#hdIdCategoria').val(),
//             idsubcategoria: $('#hdIdSubCategoria').val(),
//             criterio: $('#txtSearchProd').val(),
//             pagina: pagina
//         },
//         success: function (data) {
//             var countdata = data.length;
//             var i = 0;
//             var strhtml = '';
//             var selector = '#gvArticulo tbody';
//             // var strhtml_unidadmedida = $('#ddlUnidadMedida').html();
//             if (countdata > 0) {
//                 while(i < countdata){
//                     strhtml += '<tr>';
//                     strhtml += '<td>';
//                     strhtml += '<input type="checkbox" class="filled-in" id="chkArticulo' + i + '" value="' + data[i].tm_idproducto + '" /><label for="chkArticulo' + i + '"></label>';                        
//                     strhtml += '</td>';
//                     strhtml += '<td data-title="Insumo" class="descripcion">' + data[i].tm_nombre + '</td>';
//                     strhtml += '<td data-title="Presentacion"><select disabled class="select-unidadmedida browser-default">';
//                     strhtml += strhtml_unidadmedida;
//                     strhtml += '</select></td>';
//                     strhtml += '<td data-title="Cantidad">';
//                     strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right cantidad" type="number" step="any" id="cantidad' + i + '" value=""><label class="mdl-textfield__label" for="cantidad' + i + '"></label></div>';
//                     strhtml += '</td>';
//                     strhtml += '<td data-title="Precio">';
//                     strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input disabled class="mdl-textfield__input align-right precio" type="number" step="any" id="precio' + i + '" value=""><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
//                     strhtml += '</td>';
//                     strhtml += '<td data-title="SubTotal" class="subtotal">';
//                     strhtml += '<input type="hidden" id="subtotal' + i + '" value="0"><h4 class="grey-text text-right">0.00</h4>';
//                     strhtml += '</td>';
//                     strhtml += '</tr>';
//                     ++i;
//                 };
//                 gvArticulo.currentPage(gvArticulo.currentPage() + 1);
//                 if (pagina == '1')
//                     $(selector).html(strhtml);
//                 else
//                     $(selector).append(strhtml);
//             }
//             else {
//                 if (pagina == '1')
//                     $(selector).html('');
//                 habilitarControl('#btnAddItemsCompra', false);
//             };
//             // precargaExp('#gvProductos', false);
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }
function BuscarDatos(pagina) {
    var selectorgrid = "#gvDatos";
    precargaExp("#pnlListado", true);
    $.ajax({
        url: "services/compras/compras-search.php",
        type: "GET",
        cache: false,
        dataType: "json",
        data: {
            tipobusqueda: "1",
            criterio: $("#txtSearch").val(),
            idempresa: $("#hdIdEmpresa").val(),
            idcentro: $("#hdIdCentro").val(),
            pagina: pagina
        },
        success: function(data) {
            var countdata = data.length;
            var i = 0;
            var strhtml = "";
            if (countdata > 0) {
                while (i < countdata) {
                    var iditem = data[i].tm_idregistrocompra;
                    var importe_sinimpuesto = data[i].SimboloMoneda + " " + Number(data[i].tm_subtotal).toFixed(2);
                    var importe_impuesto = data[i].SimboloMoneda + " " + Number(data[i].tm_impuesto).toFixed(2);
                    var importe_conimpuesto = data[i].SimboloMoneda + " " + Number(data[i].tm_totalcompra).toFixed(2);
                    strhtml += "<div ";
                    strhtml += 'data-id="' + iditem + '" ';
                    strhtml += 'class="result item pos-rel animate mdl-shadow--2dp margin10">';
                    strhtml += '<div class="col-md-4">';
                    strhtml += "<h4>ID Compra #" + iditem + "</h4>";
                    strhtml += '<p class="lugar"><strong>Cod. compra: </strong>' + data[i].tm_serie_documento + "-" + data[i].tm_numero_documento + "</p>";
                    strhtml += '<p class="lugar"><strong>Tipo de comprobante: </strong>' + data[i].TipoComprobante + "</p>";
                    strhtml += '<p class="lugar"><strong>Fecha: </strong>' + ConvertMySQLDate(data[i].tm_fecha_recibo) + "</p>";
                    strhtml += "</div>";
                    strhtml += '<div class="col-md-4">';
                    strhtml += "<h4>Proveedor:</h4>";
                    // strhtml += '<p><span class="horario">El d&iacute;a: ' + fecha +  ', desde las: ' + horainicio + ' hasta las ' + horafinal + ' </span><br />';
                    strhtml += '<span class="duracion">' + data[i].Proveedor + "</span>";
                    // strhtml += '</p>';
                    // strhtml += '<h4><span class="label label-' + data[i].color_estado_requerimiento + '">' + data[i].text_estado_requerimiento + '</span></h4>';
                    strhtml += "</div>";
                    strhtml += '<div class="col-md-4">';
                    strhtml += '<h4 class="text-center">Monto de venta</h4>';
                    strhtml += '<h5 class="row"><strong class="col-md-4">Base imponible: </strong><span class="col-md-8 blue-text text-right">' + importe_sinimpuesto + "</span></h5>";
                    strhtml += '<h5 class="row"><strong class="col-md-4">Impuestos deducidos: </strong><span class="col-md-8 blue-text text-right">' + importe_impuesto + "</span></h5>";
                    strhtml += '<h5 class="row"><strong class="col-md-4">Total de importe: </strong><span class="col-md-8 blue-text text-right">' + importe_conimpuesto + "</span></h5>";
                    // strhtml += '<h4 class="text-center">Vacantes</h4>';
                    // strhtml += '<h4 class="text-center blue-text">' + cantidad + '</h4>';
                    // strhtml += '</div>';
                    // strhtml += '</div>';
                    // strhtml += '<small class="text-muted margin10 place-bottom-right"><i class="fa fa-clock-o"></i> Publicado el: ' + fecha_reg + '</small>';
                    strhtml += '<div class="clear"></div>';
                    strhtml += "</div>";
                    strhtml += "</div>";
                    ++i;
                }
                gvDatos.currentPage(gvDatos.currentPage() + 1);
                if (pagina == "1") $(selectorgrid).html(strhtml); else $(selectorgrid).append(strhtml);
                $(selectorgrid + " .grouped-buttons a.tooltipped").tooltip();
            } else {
                if (pagina == "1") $(selectorgrid).html("<h2>No se encontraron resultados.</h2>");
            }
            precargaExp("#pnlListado", false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function habilitarModuloProveedor(manejador) {
    if (manejador == "GET") {
        habilitarControl("#txtSearchProveedor", true);
        habilitarControl("#txtNroDocProveedor,#txtRazonSocialProveedor,#txtDireccionProveedor,#txtTelefonoProveedor,#txtEmailProveedor", false);
    } else {
        habilitarControl("#txtSearchProveedor", false);
        habilitarControl("#txtNroDocProveedor,#txtRazonSocialProveedor,#txtDireccionProveedor,#txtTelefonoProveedor,#txtEmailProveedor", true);
    }
}

function AplicarTarjeta() {
    $("#lblTotalComision .monto").text(Number($("#txtComisionTarjeta").val()).toFixed(2));
    // if ($('#form1').valid()) {
    closeCustomModal("#pnlInfoTarjeta");
}

function GetIdAperturaCaja() {
    var module_id = config["compras"].id;
    var _btnOpcionMenu = window.top.document.querySelector('.mdl-card[data-id="' + module_id + '"]');
    var idaperturacaja = _btnOpcionMenu.getAttribute("data-idcajareferer");
    $("#hdIdAperturaCaja").val(idaperturacaja);
}