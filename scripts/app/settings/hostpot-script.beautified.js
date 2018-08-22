$(function() {
    MostrarDatos();
    $("#nav").on("click", "li > .collapsible-header", function(event) {
        event.preventDefault();
        ShowSeriesByCurrentTab();
    });
    $("#nav").on("click", "button", function(event) {
        event.preventDefault();
        var accion = this.getAttribute("data-action");
        var item = getParentsUntil(this, "#nav", ".demo-card-order");
        var iditem = item[0].getAttribute("data-idserie");
        if (accion == "edit") {
            openModalCallBack("#modalSerie", function() {
                GetSerieById(iditem);
            });
        } else if (accion == "delete") {
            MessageBox({
                content: "¿Desea eliminar este item?",
                width: "320px",
                height: "130px",
                buttons: [ {
                    primary: true,
                    content: "Eliminar",
                    onClickButton: function(event) {
                        EliminarItemSerie(item[0]);
                    }
                } ],
                cancelButton: true
            });
        }
    });
    $("#btnGuardarTerminal").on("click", function(event) {
        event.preventDefault();
        GuardarTerminal();
    });
    $("#btnGuardarSerie").on("click", function(event) {
        event.preventDefault();
        GuardarSerie();
    });
    // $('#btnLimpiar').on('click', function(event) {
    //     event.preventDefault();
    //     LimpiarForm();
    // });
    // $('#btnEliminar').on('click', function () {
    //     Eliminar();
    //     return false;
    // });
    // $('#txtNombre').on('keydown', function(event) {
    //     if (event.keyCode == $.ui.keyCode.ENTER){
    //         $('#btnGuardar').focus();
    //         return false;
    //     }
    // });
    // $('#btnLimpiarSeleccion').on('click', function(event) {
    //     event.preventDefault();
    //     limpiarSeleccionados();
    //     $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').addClass('oculto');
    //     $('#btnNuevo').removeClass('oculto');
    // });
    // $('#btnEditar').on('click', function(event) {
    //     var id = $('.listview a.list.selected').attr('data-id');
    //     event.preventDefault();
    //     openCustomModal('#modalRegistro');
    //     GetTerminalById(id);
    // });
    // $('#btnEliminar').on('click', function(event) {
    //     event.preventDefault();
    //     var elem = $('.listview a.selected');
    // });
    $("#btnNuevo").on("click", function(event) {
        event.preventDefault();
        LimpiarForm();
        openCustomModal("#modalTerminal");
    });
    // $("#form1").validate({
    //     lang: 'es',
    //     showErrors: showErrorsInValidate,
    //     submitHandler: EnviarDatos
    // });
    // addValidForm();
    ListarTipoComprobante();
    $("#btnUpdateTipoComprobante").on("click", function(event) {
        event.preventDefault();
        ListarTipoComprobante();
    });
});

function crearItem_Serie(data) {
    var iditem = data.td_idnumeraciondoc;
    var idtipocomprobante = data.tm_idtipocomprobante;
    var TipoComprobante = data.TipoComprobante;
    var serie = data.td_serie;
    var correlativo = data.td_correlativo;
    var strhtml = "";
    strhtml += '<div class="mdl-card demo-card-order mdl-shadow--2dp mdl-cell mdl-cell--3-col" data-idserie="' + iditem + '">';
    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
    strhtml += '<div class="generic-panel">';
    strhtml += '<div class="gp-header">';
    strhtml += '<h4 class="padding20 no-margin">' + TipoComprobante + "</h4>";
    strhtml += "</div>";
    strhtml += '<div class="gp-body">';
    strhtml += '<div class="panel-view row padding20">';
    strhtml += "<h4>Serie: " + serie + "</h4>";
    strhtml += "<h4>Correlativo: " + correlativo + "</h4>";
    strhtml += "</div>";
    strhtml += "</div>";
    strhtml += '<div class="gp-footer mdl-grid">';
    strhtml += '<div class="mdl-cell mdl-cell--6-col">';
    strhtml += '<button type="button" data-action="edit" class="btn btn-sm full-size waves-effect padding-left5 padding-right5"><i class="material-icons left">&#xE3C9;</i>Editar</button>';
    strhtml += '<button type="button" data-action="cancel" class="btn btrn-primary btn-sm full-size waves-effect padding-left5 padding-right5 hide"><i class="material-icons left">&#xE5C9;</i>Cancelar</button>';
    strhtml += "</div>";
    strhtml += '<div class="mdl-cell mdl-cell--6-col">';
    strhtml += '<button type="button" data-action="delete" class="btn btn-sm full-size waves-effect padding-left5 padding-right5"><i class="material-icons left">&#xE872;</i>Eliminar</button>';
    strhtml += '<button type="button" data-action="save" class="btn btrn-primary btn-sm full-size waves-effect padding-left5 padding-right5 hide"><i class="material-icons left">&#xE161;</i>Guardar</button>';
    strhtml += "</div>";
    strhtml += "</div>";
    strhtml += "</div>";
    strhtml += "</div>";
    return strhtml;
}

function MostrarSeries(idterminal) {
    $.ajax({
        url: "services/numeracion/numventa-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "1",
            id: idterminal
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            if (countdata > 0) {
                for (i = 0; i < countdata; i++) {
                    strhtml += crearItem_Serie(data[i]);
                }
            }
            $("#nav li.active .gridview").html(strhtml);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function ShowSeriesByCurrentTab() {
    var currentTab = $("#nav li.active");
    if ($("#nav li.active").length > 0) MostrarSeries(currentTab.attr("data-idterminal"));
}

function LimpiarForm() {
    $("#hdIdTerminal").val("0");
    $("#txtNombre").val("").focus();
}

function addValidForm() {
    $("#txtNombre").rules("add", {
        required: true,
        maxlength: 150
    });
}

function limpiarSeleccionados() {
    $(".listview .selected").removeClass("selected");
    $(".listview .list input:checkbox").removeAttr("checked");
}

function MostrarDatos() {
    $.ajax({
        url: "services/terminal/terminal-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "1",
            criterio: ""
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            if (countdata > 0) {
                while (i < countdata) {
                    var cssactive = i == 0 ? " active" : "";
                    strhtml += '<li data-idterminal="' + data[i].tm_idterminal + '" class="' + cssactive + '">';
                    strhtml += '<div class="collapsible-header"><i class="material-icons">&#xE42A;</i>' + data[i].tm_nombre + "</div>";
                    strhtml += '<div class="collapsible-body white">';
                    strhtml += '<div class="gridview mdl-grid">' + "</div>";
                    strhtml += "</div>";
                    strhtml += "</li>";
                    ++i;
                }
            }
            $("#nav").html(strhtml).collapsible({
                accordion: false
            }).find("li:first > .collapsible-header").trigger("click");
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function GuardarSerie() {
    var data = new FormData();
    var input_data = $("#modalSerie").serializeArray();
    data.append("btnGuardarSerie", "btnGuardarSerie");
    Array.prototype.forEach.call(input_data, function(fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        type: "POST",
        url: "services/terminal/terminal-post.php",
        cache: false,
        dataType: "json",
        data: data,
        success: function(data) {
            createSnackbar(data.titulomsje);
            if (typeof data.rpta[0].td_idnumeraciondoc !== "undefined") {
                var strhtml = crearItem_Serie(data.rpta[0]);
                closeCustomModal("#modalSerie");
            }
        }
    });
}

function GuardarTerminal() {
    var data = new FormData();
    var input_data = $("#modalTerminal").serializeArray();
    data.append("btnGuardarTerminal", "btnGuardarTerminal");
    Array.prototype.forEach.call(input_data, function(fields) {
        data.append(fields.name, fields.value);
    });
    $.ajax({
        type: "POST",
        url: "services/terminal/terminal-post.php",
        cache: false,
        dataType: "json",
        data: data,
        success: function(data) {
            var titulomsje = "No se guardaron los datos :(";
            if (datos.rpta != "0") {
                titulomsje = "La operaci&oacute;n se complet&oacute; correctamente.";
                closeCustomModal("#modalTerminal");
                MostrarDatos();
            }
            createSnackbar(titulomsje);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function GetTerminalById(idterminal) {
    $.ajax({
        url: "services/terminal/terminal-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "2",
            id: idterminal
        }
    }).done(function(data) {
        $("#hdIdTerminal").val(data[0].tm_idterminal);
        $("#txtNombre").val(data[0].tm_nombre);
        $("#txtDireccionIP").val(data[0].tm_direccionip);
    }).fail(function() {
        console.log("error");
    }).always(function() {
        console.log("complete");
    });
}

function GetSerieById(idserie) {
    $.ajax({
        url: "services/numeracion/numventa-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "2",
            id: idserie
        },
        success: function(data) {
            if (data.length > 0) {
                $("#hdIdSerie").val(data[0].td_idnumeraciondoc);
                $("#ddlTipoComprobante").val(data[0].tm_idtipocomprobante).attr("data-idtipocomprobante", data[0].tm_idtipocomprobante);
                $("#txtSerie").val(data[0].td_serie);
                $("#txtCorrelativo").val(data[0].td_correlativo);
                Materialize.updateTextFields();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function ListarTipoComprobante() {
    $.ajax({
        url: "services/tipocomprobante/tipocomprobante-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "1",
            criterio: ""
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = "";
            var default_id = $("#ddlTipoComprobante").attr("data-idtipocomprobante");
            if (countdata > 0) {
                while (i < countdata) {
                    var selected = default_id == data[i].tm_idtipocomprobante ? ' selected="selected"' : "";
                    strhtml += "<option" + selected + ' value="' + data[i].tm_idtipocomprobante + '">' + data[i].tm_nombre + "</option>";
                    ++i;
                }
            } else strhtml = '<option value="0">NO EXISTEN TIPOS DE COMPROBANTE REGISTRADOS</option>';
            $("#ddlTipoComprobante").html(strhtml);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

var indexList = 0;

var elemsSelected;

function EliminarSerie() {
    indexList = 0;
    elemsSelected = $("#gvDatos").find(".selected");
    EliminarItemSerie(elemsSelected[0], "multiple");
}

function EliminarItemSerie(item, mode) {
    var data = new FormData();
    var idserie = item.getAttribute("data-idserie");
    data.append("btnEliminarSerie", "btnEliminarSerie");
    data.append("hdIdSerie", idserie);
    $.ajax({
        url: "services/numeracion/numeracion-post.php",
        type: "POST",
        dataType: "json",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            var titulomsje = "";
            var endqueue = false;
            var itemSelected = $(item);
            if (data.rpta == "0") {
                endqueue = true;
                titulomsje = "No se puede eliminar";
            } else {
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });
                if (mode == "multiple") {
                    ++indexList;
                    if (indexList <= elemsSelected.length - 1) EliminarItemProveedor(elemsSelected[indexList], mode); else {
                        endqueue = true;
                        titulomsje = data.titulomsje;
                    }
                } else if (mode == "single") {
                    endqueue = true;
                    titulomsje = data.titulomsje;
                }
            }
            if (endqueue) {
                createSnackbar(titulomsje);
                if ($(".actionbar").hasClass("is-visible")) $(".back-button").trigger("click");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}