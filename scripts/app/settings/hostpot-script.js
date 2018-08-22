 $(function () {
    MostrarDatos();

    $('#nav').on('click', 'li > .collapsible-header', function(event) {
        event.preventDefault();
        ShowSeriesByCurrentTab();
    });

    $('#nav').on('click', 'button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row;
        var iditem = '0';

        if ((accion == 'edit-terminal') || (accion == 'delete-terminal') || (accion == 'new-serie')){
            _row = getParentsUntil(this, '#nav', 'li');
            iditem = _row[0].getAttribute('data-idterminal');

            if (accion == 'edit-terminal')
                GetTerminalById(iditem);
            else if (accion == 'delete-terminal')
                EliminarTerminal(_row[0]);
            else {
                $('#hdIdTerminal').val(iditem);
                GetSerieById('0');
            };
        }
        else if ((accion == 'edit-serie') || (accion == 'delete-serie')){
            _row = getParentsUntil(this, '#nav', '.dato');

            if (accion == 'edit-serie'){
                iditem = _row[0].getAttribute('data-idserie');
                GetSerieById(iditem);
            }
            else {
                MessageBox({
                    content: '¿Desea eliminar este item?',
                    width: '320px',
                    height: '130px',
                    buttons: [
                        {
                            primary: true,
                            content: 'Eliminar',
                            onClickButton: function (event) {
                                EliminarItemSerie(_row[0], 'single');
                            }
                        }
                    ],
                    cancelButton: true
                });
            };
        };
    });

    $('#btnGuardarTerminal').on('click', function(event) {
        event.preventDefault();
        GuardarTerminal();
    });

    $('#btnGuardarSerie').on('click', function(event) {
        event.preventDefault();
        GuardarSerie();
    });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        GetTerminalById('0');
    });

    ListarTipoComprobante();

    $('#btnUpdateTipoComprobante').on('click', function(event) {
        event.preventDefault();
        ListarTipoComprobante();
    });
});

function crearItem_Serie (data) {
    var iditem = data.td_idnumeraciondoc;
    var idtipocomprobante = data.tm_idtipocomprobante
    var TipoComprobante = data.TipoComprobante;
    var serie = data.td_serie;
    var correlativo = data.td_correlativo;

    var strhtml = '';

    strhtml += '<div class="mdl-card dato demo-card-order mdl-shadow--2dp mdl-cell mdl-cell--3-col" data-idserie="' + iditem + '">';

    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

    strhtml += '<div class="generic-panel">'
    
    strhtml += '<div class="gp-header">';
    strhtml += '<h4 class="padding20 no-margin">' + TipoComprobante + '</h4>';
    strhtml += '</div>';

    
    strhtml += '<div class="gp-body">';

    strhtml += '<div class="panel-view row padding20">';
    strhtml += '<h4>Serie: ' + serie + '</h4>';
    strhtml += '<h4>Correlativo: ' + correlativo + '</h4>';
    strhtml += '</div>';

    strhtml += '</div>';

    strhtml += '<div class="gp-footer">';
    
    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5">';
    strhtml += '<button class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit-serie" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></button>';

    strhtml += '<button class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete-serie" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></button>';
    strhtml += '</div>';

    strhtml += '</div>';

    strhtml += '</div>';
    strhtml += '</div>';

    return strhtml;
 }

function MostrarSeries (idterminal) {
    $.ajax({
        url: 'services/numeracion/numventa-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            id: idterminal
        },
        success: function(data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while (i < countdata) {
                    strhtml += crearItem_Serie(data[i]);
                    ++i;
                };
            }
            else
                strhtml = '<h2>No se encontraron registros</h2>';

            $('#nav li.active .gridview').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ShowSeriesByCurrentTab () {
    var currentTab = $('#nav li.active');
    
    if ($('#nav li.active').length > 0)
        MostrarSeries(currentTab.attr('data-idterminal'));
}

function LimpiarTerminal () {
    $('#hdIdTerminal').val('0');
    $('#txtNombre').val('').focus();
}

function addValidForm () {
    $('#txtNombre').rules('add', {
        required: true,
        maxlength: 150
    });
}

function limpiarSeleccionados () {
    $('.listview .selected').removeClass('selected');
    $('.listview .list input:checkbox').removeAttr('checked');
}

function crearItem_Terminal (data, flag_active) {
    var strhtml = '';
    var cssactive = flag_active == true ? ' class="active"' : '';

    strhtml += '<li data-idterminal="' + data.tm_idterminal + '">';
    strhtml += '<div class="collapsible-header"><i class="material-icons">&#xE42A;</i>' + data.tm_nombre + '</div>';
    
    strhtml += '<div class="collapsible-body">';
    strhtml += '<div class="panel panel-default no-margin">';
    strhtml += '<div class="panel-heading"><h3 class="panel-title">Series configuradas</h3></div>';
    strhtml += '<div class="panel-body"><div class="gridview mdl-grid no-padding"></div></div>';
    strhtml += '<div class="panel-footer">';
    strhtml += '<button data-action="edit-terminal" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-button--colored left">Editar terminal</button>';
    strhtml += '<button data-action="delete-terminal" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored left">Eliminar terminal</button>';
    strhtml += '<button data-action="new-serie" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored right">Nueva serie de venta</button>';
    strhtml += '<div class="clear"></div>';
    strhtml += '</div>';
    strhtml += '</div>';
    strhtml += '</div>';
    strhtml += '</li>';

    return strhtml;
}

function MostrarDatos () {
    $.ajax({
        url: 'services/terminal/terminal-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += crearItem_Terminal(data[i], (i == 0));
                    ++i;
                };
            };

            $('#nav').html(strhtml).collapsible({
                accordion : false
            }).find('li:first > .collapsible-header').trigger('click');
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GuardarSerie () {
    var data = new FormData();
    var input_data = $('#modalSerie :input').serializeArray();

    data.append('btnGuardarSerie', 'btnGuardarSerie');
    data.append('hdIdTerminal', $('#hdIdTerminal').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/terminal/terminal-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (typeof data.rpta != '0'){
                closeCustomModal('#modalSerie');
                ShowSeriesByCurrentTab();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GuardarTerminal () {
    var data = new FormData();
    var input_data = $('#modalTerminal :input').serializeArray();

    data.append('btnGuardarTerminal', 'btnGuardarTerminal');
    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/terminal/terminal-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0'){
                var idterminal = $('#hdIdTerminal').val();
                var strhtml = crearItem_Terminal(data.rpta[0], false);
                
                if (idterminal == '0')
                    $('#nav').append(strhtml);
                else
                    $('#nav li[data-idterminal="' + idterminal + '"]').replaceWith(strhtml);

                $('#nav').collapsible({
                    accordion : false
                });

                if (idterminal != '0')
                    $('#nav li[data-idterminal="' + idterminal + '"] > .collapsible-header').trigger('click');

                closeCustomModal('#modalTerminal');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GetTerminalById (idterminal) {
    LimpiarTerminal();
    openModalCallBack('#modalTerminal', function () {
        if (idterminal != '0') {
            $.ajax({
                url: 'services/terminal/terminal-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idterminal
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdTerminal').val(data[0].tm_idterminal);
                        $('#txtNombre').val(data[0].tm_nombre);
                        $('#txtDireccionIP').val(data[0].tm_direccionip);

                        Materialize.updateTextFields();
                    };
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    });
}

function LimpiarSerie () {
    $('#hdIdSerie').val('0');
    $('#ddlTipoComprobante').attr('data-idtipocomprobante', '0')
    $('#ddlTipoComprobante')[0].selectedIndex = 0;
    $('#txtSerie').val('');
    $('#txtCorrelativo').val('');
}

function GetSerieById (idserie) {
    LimpiarSerie();
    openModalCallBack('#modalSerie', function () {
        if (idserie != '0') {
            $.ajax({
                url: 'services/numeracion/numventa-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idserie
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdSerie').val(data[0].td_idnumeraciondoc);
                        $('#ddlTipoComprobante').val(data[0].tm_idtipocomprobante).attr('data-idtipocomprobante', data[0].tm_idtipocomprobante);
                        $('#txtSerie').val(data[0].td_serie);
                        $('#txtCorrelativo').val(data[0].td_correlativo);

                        Materialize.updateTextFields();
                    };
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    });
}

function ListarTipoComprobante () {
    $.ajax({
        url: 'services/tipocomprobante/tipocomprobante-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var default_id = $('#ddlTipoComprobante').attr('data-idtipocomprobante');

            if (countdata > 0){
                while (i < countdata) {
                    var selected = default_id == data[i].tm_idtipocomprobante ? ' selected="selected"' : '';
                    strhtml += '<option' + selected + ' value="' + data[i].tm_idtipocomprobante + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">NO EXISTEN TIPOS DE COMPROBANTE REGISTRADOS</option>';

            $('#ddlTipoComprobante').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

var indexList = 0;
var elemsSelected;

function EliminarTerminal (item) {
    var idterminal = item.getAttribute('data-idterminal');
    
    MessageBox({
        content: '¿Desea eliminar la terminal?',
        width: '320px',
        height: '130px',
        buttons: [
            {
                primary: true,
                content: 'Eliminar',
                onClickButton: function (event) {
                    var data = new FormData();

                    data.append('btnEliminarTerminal', 'btnEliminarTerminal');
                    data.append('hdIdTerminal', idterminal);

                    $.ajax({
                        type: "POST",
                        url: 'services/terminal/terminal-post.php',
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: data,
                        success: function(data){
                            createSnackbar(data.titulomsje);
                            
                            if (data.rpta != '0'){
                                $(item).fadeOut(400, function() {
                                    $(this).remove();
                                });
                            };
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            },
        ],
        cancelButton: true
    });
}

function EliminarSerie () {
    indexList = 0;
    elemsSelected = $('#gvDatos').find('.selected');
    EliminarItemSerie(elemsSelected[0], 'multiple');
}

function EliminarItemSerie (item, mode) {
    var data = new FormData();
    var idserie = item.getAttribute('data-idserie');

    data.append('btnEliminarSerie', 'btnEliminarSerie');
    data.append('hdIdSerie', idserie);

    $.ajax({
        url: 'services/terminal/terminal-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var endqueue = false;

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                $(item).fadeOut(400, function() {
                    $(this).remove();

                    if ($('#nav li.active .dato').length == 0)
                        $('#nav li.active .gridview').html('<h2>No se encontraron registros</h2>');
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemSerie(elemsSelected[indexList], mode);
                    else {
                        endqueue = true;
                        titulomsje = data.titulomsje;
                    };
                }
                else if (mode == 'single') {
                    endqueue = true;
                    titulomsje = data.titulomsje;
                };
            };
            
            if (endqueue) {
                createSnackbar(titulomsje);                

                if ($('.actionbar').hasClass('is-visible'))
                    $('.back-button').trigger('click');
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}