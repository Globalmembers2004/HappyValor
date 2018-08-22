$(function() {
    $("#nav").on("click", "li > .collapsible-header", function(event) {
        event.preventDefault();
        ShowMesasByCurrentTab();
    });
    $("#nav li:first-child > .collapsible-header").trigger("click");
    // $('#btnGuardarMesa, #btnGuardarAmbiente').on('click', function (evt) {
    //     GuardarDatos();
    // });
    // $('#btnCancelRooms').on('click', function () {
    //     BackToList();
    //     return false;
    // });
    // $('#pnlForm').on('click', '#btnBackList', function () {
    //     BackToList();
    //     return false;
    // });
    // $('#btnNuevoAmbiente').on('click', function () {
    //     var tipoEdit = 'N';
    //     var TipoData = '00';
    //     resetForm('form1');
    //     GoToEditRoom(TipoData, tipoEdit);
    //     return false;
    // });
    // $('#btnNuevaMesa').on('click', function () {
    //     var tipoEdit = 'N';
    //     var TipoData = '01';
    //     resetForm('form1');
    //     GoToEditRoom(TipoData, tipoEdit);
    //     return false;
    // });
    // $('#btnEditAmbiente').on('click', function () {
    //     var tipoEdit = 'E';
    //     var TipoData = '00';
    //     GoToEditRoom(TipoData, tipoEdit);
    //     return false;
    // });
    // $('#btnEditRooms').on('click', function () {
    //     var tipoEdit = 'E';
    //     var TipoData = '01';
    //     GoToEditRoom(TipoData, tipoEdit);
    //     return false;
    // });
    // $('#btnDelAmbiente').on('click', function () {
    //     EliminarAmbiente();
    //     return false;
    // });
    // $('#chkCorrelativoMesa').on('click', function () {
    //     var check = this.checked;
    //     habilitarControl('#txtCodigoMesa', !check);
    //     if (!check)
    //         $('#txtCodigoMesa').focus();
    // });
    $("#nav").on("click", ".mdl-button", function(event) {
        event.preventDefault();
        var accion = this.getAttribute("data-action");
        var _row;
        var iditem = "0";
        if (accion == "edit-ambiente" || accion == "new-mesa") {
            _row = getParentsUntil(this, "#nav", "li");
            iditem = _row[0].getAttribute("data-idambiente");
            if (accion == "edit-ambiente") GoToEditAmbiente(iditem); else {
                $("#hdIdAmbiente").val(iditem);
                GoToEditMesa("0");
            }
        } else if (accion == "edit-mesa") {
            _row = getParentsUntil(this, "#nav", ".dato");
            iditem = _row[0].getAttribute("data-idmesa");
            GoToEditMesa(iditem);
        }
    });
    $("#btnNuevoAmbiente").on("click", function(event) {
        event.preventDefault();
        GoToEditAmbiente("0");
    });
});

function ShowMesasByCurrentTab() {
    var currentTab = $("#nav li.active");
    if ($("#nav li.active").length > 0) MostrarMesas(currentTab.attr("data-idambiente"));
}

function GuardarDatos() {
    $.ajax({
        type: "POST",
        url: "services/ambientes/mesas-post.php",
        cache: false,
        data: $(form).serialize() + "&btnSaveRooms=btnSaveRooms&codMesa=" + $("#txtCodigoMesa").val(),
        success: function(data) {
            console.log(data);
            datos = eval("(" + data + ")");
            if (Number(datos.rpta) > 0) {
                MessageBox("Datos guardados", "La operaci&oacute;n se complet&oacute; correctamente.", "[Aceptar]", function() {
                    var TipoData = $("#hdTipoData").val();
                    var Id = $("#hdIdPrimary").val();
                    var NombreAmbiente = $("#txtNombreAmbiente").val();
                    var strContent = "";
                    $("#hdPage").val("1");
                    $("#hdPageActual").val("1");
                    BackToListRooms();
                    if (TipoData == "00") {
                        if (Id == "0") {
                            aLink = $('<a href="#"></a>');
                            li = $("<li></li>");
                            section = $("<section></section>");
                            tileArea = $('<div class="gridview gridview"></div>');
                            aLink.attr("rel", datos.rpta).text(NombreAmbiente);
                            section.append(tileArea);
                            li.append(aLink);
                            li.append(section);
                            $("#nav").append(li);
                        } else $('#nav li.active a[rel="' + datos.rpta + '"]').text(NombreAmbiente);
                    } else if (TipoData == "01") {
                        if (Id == "0") {
                            $("#nav li.active section .gridview h2").remove();
                            tile = $('<div class="tile dato bg-olive" rel="' + datos.rpta + '"></div>');
                            strContent = '<div class="tile-content">';
                            strContent += '<input type="checkbox" name="chkItem[]" class="oculto" value="' + datos.rpta + '"  />';
                            strContent += '<div class="text-center">';
                            strContent += '<h1 class="fg-white" style="margin:30px 0px;">' + datos.codigo + "</h1>";
                            strContent += "</div></div>";
                            strContent += '<div class="brand"><span class="badge bg-dark">' + datos.nrocomensales + "</span></div>";
                            tile.html(strContent).appendTo("#nav li.active section .gridview").on("click", function() {
                                $("#hdTipoData").val("01");
                                selectInTile(this);
                                return false;
                            });
                        } else $('#nav li.active .tile[rel="' + datos.rpta + '"] .text-center h1').text(datos.codigo);
                    }
                    resetForm("form1");
                    if (TipoData == "00") {
                        closeCustomModal("#pnlEditAmbiente");
                    } else {
                        closeCustomModal("#pnlEditMesa");
                    }
                });
            }
        }
    });
}

// function BackToListRooms () {
//     $('#btnNuevoAmbiente').removeClass('oculto');
//     if ($('#nav li.active').length > 0)
//         $('#btnEditAmbiente, #btnDelAmbiente, #btnNuevaMesa').removeClass('oculto');
//     $('#btnSaveRooms, #btnCancelRooms').addClass('oculto')
//     $('#pnlForm').fadeOut(500, function () {;
//         $('#pnlListado').fadeIn(500, function () {
//             $('#txtSearch').focus();
//         });
//     });
// }
function LimpiarAmbiente() {
    $("#hdIdAmbiente").val("0");
    $("#txtCodigoAmbiente").val("");
    $("#txtNombreAmbiente").val("");
    Materialize.updateTextFields();
}

function GoToEditAmbiente(idambiente) {
    LimpiarAmbiente();
    openModalCallBack("#pnlEditAmbiente", function() {
        if (idambiente != "0") {
            $.ajax({
                url: "services/ambientes/amesas-getdetails.php",
                type: "GET",
                dataType: "json",
                cache: false,
                data: {
                    tipo: "00",
                    id: idambiente
                },
                success: function(data) {
                    if (data.length > 0) {
                        $("#hdIdAmbiente").val(data[0].tm_idambiente);
                        $("#txtCodigoAmbiente").val(data[0].tm_codigo);
                        $("#txtNombreAmbiente").val(data[0].tm_nombre);
                        Materialize.updateTextFields();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });
}

function LimpiarMesa() {
    $("#hdIdMesa").val("0");
    $("#txtCodigoMesa").val("");
    $("#txtNroComensales").val("1");
    Materialize.updateTextFields();
}

function GoToEditMesa(idmesa) {
    LimpiarMesa();
    openModalCallBack("#pnlEditMesa", function() {
        if (idmesa != "0") {
            $.ajax({
                type: "GET",
                url: "services/ambientes/amesas-getdetails.php",
                cache: false,
                data: {
                    tipo: "01",
                    id: idmesa
                },
                dataType: "json",
                success: function(data) {
                    if (data.length > 0) {
                        $("#hdIdMesa").val(data[0].tm_idmesa);
                        $("#txtCodigoMesa").val(data[0].tm_codigo);
                        $("#txtNroComensales").val(data[0].tm_nrocomensales);
                        Materialize.updateTextFields();
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });
}

// function addValidFormRegister (TipoData) {
//     if (TipoData == '00'){
//         $('#txtCodigoAmbiente').rules('add', {
//             required: true,
//             maxlength: 4
//         });
//         $('#txtNombreAmbiente').rules('add', {
//             required: true,
//             maxlength: 100
//         });
//     }
//     else if (TipoData == '01') {
//         $('#txtCodigoMesa').rules('add', {
//             required: true,
//             maxlength: 5
//         });
//         $('#txtNroComensales').rules('add', {
//             required: true
//         });
//     }
// }
// function removeValidFormRegister (TipoData) {
//     if (TipoData == '00'){
//         $('#txtCodigoAmbiente').rules('remove');
//         $('#txtNombreAmbiente').rules('remove');
//     }
//     else if (TipoData == '01') {
//         $('#txtCodigoMesa').rules('remove');
//         $('#txtNroComensales').rules('remove');
//     }
// }
function MostrarMesas(idambiente) {
    precargaExp("#pnlListado", true);
    $.ajax({
        type: "GET",
        url: "services/ambientes/mesas-search.php",
        cache: false,
        dataType: "json",
        data: "idambiente=" + idambiente,
        success: function(data) {
            var countdata = data.length;
            var i = 0;
            var selector = "#nav li.active .gridview";
            var strhtml = "";
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<div class="card-panel pos-rel dato mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--2-col-phone" data-idmesa="' + data[i].tm_idmesa + '">';
                    strhtml += '<input type="checkbox" name="chkItem[]" class="oculto" value="' + data[i].tm_idmesa + '" />';
                    strhtml += '<h1 class="padding10 align-center">' + data[i].tm_codigo + "</h1>";
                    strhtml += '<div class="dato-badge place-top-right margin5 padding5 align-center blue darken-1 white-text rounded">' + data[i].tm_nrocomensales + "</div>";
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5">';
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit-mesa" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a>';
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete-mesa" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a>';
                    strhtml += "</div>";
                    strhtml += "</div>";
                    ++i;
                }
            } else strhtml = "<h2>No se encontraron registros</h2>";
            $(selector).html(strhtml);
            precargaExp("#pnlListado", false);
        }
    });
}