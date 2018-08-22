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
                content: '¿Desea eliminar La Familia?',
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

    $('#txtNombre').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            return false;
        };
    });

    $('#txtCodigoStar').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
            return false;
        };
    });

    MostrarDatos();
});

function LimpiarForm () {

    $('#hdIdPrimary').val('0');
    $('#ddlTipoFamilia').val('0').focus();
    $('#txtNombre').val('');
    $('#txtCodigoStar').val('');

}

function MostrarDatos () {
    $.ajax({
        url: 'services/familia/familia-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '4',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].tm_idfamilia  + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idfamilia + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content"> Código StartSoft:' + data[i].tm_codfam_star + ' - ' +data[i].tm_descripcion + ' Tipo de familia:' + data[i].tipofamilia + '</span>'; 
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" title="Editar" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" title="Eliminar" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';
                    strhtml += '</li>';
                    ++i;
                }
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';

            $('#gvDatos').html(strhtml);
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
        url: 'services/familia/familia-post.php',
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
            {
            ListarTipoFamilia_Combo('0');

            $('#ddlTipoFamilia').focus();

            precargaExp(selectorModal, false);
            }
         else {
            $.ajax({
                url: 'services/familia/familia-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdPrimary').val(data[0].tm_idfamilia);
                        $('#txtNombre').val(data[0].tm_descripcion);
                        $('#txtCodigoStar').val(data[0].tm_codfam_star);
                        $('#chkEditable')[0].checked = data[0].tm_flagedicion == '1' ? true : false;

                        ListarTipoFamilia_Combo(data[0].tm_idtipofamilia);

                        $('#ddlTipoFamilia').val(data[0].tm_idtipofamilia).focus();
                        
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


function EliminarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/familia/familia-post.php',
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


function ListarTipoFamilia_Combo (idtipofamilia_default) {
    $.ajax({
        type: 'GET',
        url: 'services/tipofamilia/tipofamilia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idtipofamilia_default == data[i].tm_idtipofamilia ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idtipofamilia + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlTipoFamilia').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
