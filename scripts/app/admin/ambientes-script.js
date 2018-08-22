$(function () {
    MostrarAmbientes();

    $('#nav').on('click', 'li > .collapsible-header', function(event) {
        event.preventDefault();
        ShowMesasByCurrentTab();
    });

    $('#nav').on('click', '.mdl-button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row;
        var iditem = '0'; 

        if ((accion == 'edit-ambiente') || (accion == 'delete-ambiente') || (accion == 'new-mesa')){
            _row = getParentsUntil(this, '#nav', 'li');
            iditem = _row[0].getAttribute('data-idambiente');

            if (accion == 'edit-ambiente')
                GoToEditAmbiente(iditem);
            else if (accion == 'delete-ambiente')
                EliminarAmbiente(_row[0]);
            else {
                $('#hdIdAmbiente').val(iditem);
                GoToEditMesa('0');
            };
        }
        else if ((accion == 'edit-mesa') || (accion == 'delete-mesa')){
            _row = getParentsUntil(this, '#nav', '.dato');

            if (accion == 'edit-mesa'){
                iditem = _row[0].getAttribute('data-idmesa');
                GoToEditMesa(iditem);
            }
            else {
                MessageBox({
                    content: '¿Desea eliminar el equipo?',
                    width: '320px',
                    height: '130px',
                    buttons: [
                        {
                            primary: true,
                            content: 'Eliminar',
                            onClickButton: function (event) {
                                EliminarItemMesa(_row[0], 'single');
                            }
                        }
                    ],
                    cancelButton: true
                });
            };
        };
    });

    $('#btnNuevoAmbiente').on('click', function(event) {
        event.preventDefault();
        GoToEditAmbiente('0');
    });

    $('#btnGuardarAmbiente').on('click', function(event) {
        event.preventDefault();
        GuardarAmbiente();
    });

    $('#btnGuardarMesa').on('click', function(event) {
        event.preventDefault();
        GuardarMesa();
    });
});

var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;

function ShowMesasByCurrentTab () {
    var currentTab = $('#nav li.active');
    
    if ($('#nav li.active').length > 0)
        MostrarMesas(currentTab.attr('data-idambiente'));
}

function crearItemAmbiente (data, flag_active) {
    var strhtml = '';
    var cssactive = flag_active == true ? ' class="active"' : '';

    strhtml += '<li data-idambiente="' + data.tm_idambiente + '">';
    strhtml += '<div class="collapsible-header"><i class="material-icons">&#xE42A;</i>' + data.tm_nombre + '</div>';
    
    strhtml += '<div class="collapsible-body">';
    strhtml += '<div class="panel panel-default no-margin">';
    strhtml += '<div class="panel-heading"><h3 class="panel-title">Lista de equipos</h3></div>';
    strhtml += '<div class="panel-body"><div class="gridview mdl-grid no-padding"></div></div>';
    strhtml += '<div class="panel-footer">';
    strhtml += '<button data-action="edit-ambiente" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary mdl-button--colored left">Editar ambiente</button>';
    strhtml += '<button data-action="delete-ambiente" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored left">Eliminar ambiente</button>';
    strhtml += '<button data-action="new-mesa" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--colored right">Nueva máquina</button>';
    strhtml += '<div class="clear"></div>';
    strhtml += '</div>';
    strhtml += '</div>';
    strhtml += '</div>';
    strhtml += '</li>';

    return strhtml;
}

function MostrarAmbientes () {
    $.ajax({
        url: 'services/ambientes/ambientes-search.php',
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
                    strhtml += crearItemAmbiente(data[i], (i == 0));
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

function GuardarAmbiente () {
    var data = new FormData();
    var input_data = $('#modalAmbiente :input').serializeArray();

    data.append('btnGuardarAmbiente', 'btnGuardarAmbiente');
    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/ambientes/mesas-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                var idambiente = $('#hdIdAmbiente').val();
                var strhtml = crearItemAmbiente(data.rpta[0], false);
                
                if (idambiente == '0')
                    $('#nav').append(strhtml);
                else
                    $('#nav li[data-idambiente="' + idambiente + '"]').replaceWith(strhtml);

                $('#nav').collapsible({
                    accordion : false
                });

                if (idambiente != '0')
                    $('#nav li[data-idambiente="' + idambiente + '"] > .collapsible-header').trigger('click');

                closeCustomModal('#modalAmbiente');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function LimpiarAmbiente () {
    $('#hdIdAmbiente').val('0');
    $('#txtCodigoAmbiente').val('');
    $('#txtNombreAmbiente').val('');
    Materialize.updateTextFields();
}

function GoToEditAmbiente (idambiente) {
    LimpiarAmbiente();
    openModalCallBack('#modalAmbiente', function () {
        if (idambiente != '0') {
            $.ajax({
                url: 'services/ambientes/amesas-getdetails.php',
                type: 'GET',
                dataType: 'json',
                cache: false,
                data: {
                    tipo: '00',
                    id: idambiente
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdAmbiente').val(data[0].tm_idambiente);
                        $('#txtCodigoAmbiente').val(data[0].tm_codigo);
                        $('#txtNombreAmbiente').val(data[0].tm_nombre);

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

function EliminarAmbiente (item) {
    var idambiente = item.getAttribute('data-idambiente');
    
    MessageBox({
        content: '¿Desea eliminar el ambiente?',
        width: '320px',
        height: '130px',
        buttons: [
            {
                primary: true,
                content: 'Eliminar',
                onClickButton: function (event) {
                    var data = new FormData();

                    data.append('btnEliminarAmbiente', 'btnEliminarAmbiente');
                    data.append('hdIdAmbiente', idambiente);

                    $.ajax({
                        type: "POST",
                        url: 'services/ambientes/mesas-post.php',
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

function LimpiarMesa () {
    $('#hdIdMesa').val('0');
    $('#txtCodigoMesa').val('');
    $('#txtNroComensales').val('1');
    Materialize.updateTextFields();
}

function GoToEditMesa (idmesa) {
    LimpiarMesa();
    openModalCallBack('#modalMesa', function () {
        if (idmesa != '0') {
            $.ajax({
                type: "GET",
                url: "services/ambientes/amesas-getdetails.php",
                cache: false,
                data: {
                    tipo: '01',
                    id: idmesa
                },
                dataType: 'json',
                success: function(data){
                    if (data.length > 0) {
                        $('#hdIdMesa').val(data[0].tm_idmesa);
                        $('#txtCodigoMesa').val(data[0].tm_codigo);
                        $('#txtNroComensales').val(data[0].tm_nrocomensales);

                        Materialize.updateTextFields();
                    };
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };
    });
}

function GuardarMesa () {
    var data = new FormData();
    var input_data = $('#modalMesa :input').serializeArray();

    data.append('btnGuardarMesa', 'btnGuardarMesa');
    data.append('hdIdAmbiente', $('#hdIdAmbiente').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/ambientes/mesas-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                closeCustomModal('#modalMesa');
                ShowMesasByCurrentTab();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function EliminarItemMesa (item, mode) {
    var data = new FormData();
    var idmesa = item.getAttribute('data-idmesa');

    data.append('btnEliminarMesa', 'btnEliminarMesa');
    data.append('hdIdMesa', idmesa);

    $.ajax({
        type: "POST",
        url: 'services/ambientes/mesas-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
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
                        EliminarItemMesa(elemsSelected[indexList], mode);
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
        error: function (error) {
            console.log(error);
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

function MostrarMesas (idambiente) {
    precargaExp('#pnlListado', true);

	$.ajax({
        type: "GET",
        url: "services/ambientes/mesas-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipo: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            id: idambiente
        },
        success: function(data){
        	var countdata = data.length;
        	var i = 0;
            var selector = '#nav li.active .gridview';
            var strhtml = '';

            if (countdata > 0){
            	while(i < countdata){
            		strhtml += '<div class="card-panel pos-rel dato mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--2-col-phone" data-idmesa="' + data[i].tm_idmesa + '">';
                    strhtml += '<input type="checkbox" name="chkItem[]" class="oculto" value="' + data[i].tm_idmesa + '" />';
		            strhtml += '<h1 class="padding10 align-center">' + data[i].tm_codigo + '</h1>';
                    strhtml += '<div class="dato-badge place-top-right margin5 padding5 align-center blue darken-1 white-text rounded">' + data[i].tm_nrocomensales + '</div>';

                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5">';
                                
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit-mesa" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a>';

                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete-mesa" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a>';

                    strhtml += '</div>';

                    strhtml += '</div>';
            		++i;
            	};
            }
            else
            	strhtml = '<h2>No se encontraron registros</h2>';
            
            $(selector).html(strhtml);
            precargaExp('#pnlListado', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}