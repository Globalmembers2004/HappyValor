$(function () {
    $('[data-toogle="tooltip"]').tooltip();

    $('#gvDatos').on('click', '.mdl-button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row = getParentsUntil(this, '#gvDatos', '.dato');
        
        if (accion == 'edit'){
            var iditem = _row[0].getAttribute('data-id');
            GetDataById(iditem);
        }
        else {
            MessageBox({
                content: '¿Desea eliminar el tipo de comprobante?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            EliminarItem(_row[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
         };
    });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        GetDataById('0');
    });

    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#btnLimpiar').on('click', function(event) {
        event.preventDefault();
        LimpiarForm();
    });

    // $('#btnEliminar').on('click', function () {
    //     Eliminar();
    //     return false;
    // });

    $('#txtNombre').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            $('#txtDescripcion').focus();
            return false;
        };
    });

    // $("#form1").validate({
    //     lang: 'es',
    //     showErrors: showErrorsInValidate,
    //     submitHandler: EnviarDatos
    // });

    // addValidForm();

    $('#chkSelectAllMenu').on('change', function(event) {
        $('#gvOpcionesMenu tbody input:checkbox').prop('checked', this.checked);
    });

    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtDescripcion').val('');
    $('#txtAbreviatura').val('');
    $('#chkSelectAllMenu').prop('checked', false);
    $('#txtNombre').val('').focus();
}

// function addValidForm () {
//     $('#txtNombre').rules('add', {
//         required: true,
//         maxlength: 150
//     });
// }

// function GuardarDatos () {
//     $('#form1').submit();
// }

// function limpiarSeleccionados () {
//     $('.listview .selected').removeClass('selected');
//     $('.listview .list input:checkbox').removeAttr('checked');
// }

function MostrarDatos () {
    $.ajax({
        url: 'services/perfil/perfil-search.php',
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
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].tm_idperfil + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idperfil + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content">' + data[i].tm_nombre + '</span>';
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" title= "Editar" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" title= "Eliminar" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';
                    strhtml += '</li>';
                    ++i;
                };
            }
            else
                strhtml = '<h2>No se encontraron registros</h2>';

            $('#gvDatos .gridview').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GuardarDatos () {
    var data = new FormData();
    var input_data = $('#modalRegistro :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/perfil/perfil-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                closeCustomModal('#modalRegistro');
                MostrarDatos();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function GetDataById (idData) {
    LimpiarForm();
    openModalCallBack('#modalRegistro', function () {
        if (idData == '0')
            ListarOpcionesMenu('0');
        else {
            $.ajax({
                url: 'services/perfil/perfil-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    idperfil: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdPrimary').val(data[0].tm_idperfil);
                        $('#txtNombre').val(data[0].tm_nombre);
                        $('#txtDescripcion').val(data[0].tm_descripcion);
                        $('#txtAbreviatura').val(data[0].tm_abreviatura);

                        Materialize.updateTextFields();

                        ListarOpcionesMenu(data[0].tm_idperfil);
                    };
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    });
}

function EliminarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/perfil/perfil-post.php',
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

                    if ($('#gvDatos .dato').length == 0)
                        $('#gvDatos .gridview').html('<h2>No se encontraron registros</h2>');
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItem(elemsSelected[indexList], mode);
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

function ListarOpcionesMenu (idperfil) {
    // $('#chkAllMenu')[0].checked = false;
    
    precargaExp('#modalRegistro .ibody', true);

    $.ajax({
        type: 'GET',
        url: 'services/menu/menu-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 'CONFIG',
            idperfil: idperfil
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var selector = '#gvOpcionesMenu tbody';

            if (countdata > 0){
                strhtml = treeMenu(data, 0, 0);
                $(selector).html(strhtml);
            }
            else
                $(selector).html('<tr><td colspan="2">No se encontraron resultados.</td></tr>');                
            
            precargaExp('#modalRegistro .ibody', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function treeMenu(data, mom, level){
    var strhtml = '';

    for (var k in data) {
        if (data[k].tm_idmenuref == mom) {
            var checking = data[k].idperfilmenu == 0 ? '' : ' checked=""';

            strhtml += '<tr>';
            strhtml += '<td>';

            strhtml += '<input id="chkMenu' + k + '" name="chkMenu[]"  class="filled-in" type="checkbox" value="' + data[k].tm_idmenu + '"' + checking + ' /><label for="chkMenu' + k + '"></label>';
            
            strhtml += '<input type="hidden" value="' + data[k].idperfilmenu + '" />';


            strhtml += '</td><td>' + data[k].tipomenu + '</td><td>' + data[k].tm_titulo + '</td></tr>';
            strhtml += treeMenu(data, data[k].tm_idmenu, level);
        };
     };

     return strhtml;
}