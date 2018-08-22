$(function () {
    $('#gvDatos').on('click', '.mdl-button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row = getParentsUntil(this, '#gvDatos', '.dato');
        
        if (accion == 'edit'){
            var idItem = _row[0].getAttribute('data-id');
            GetDataById(idItem);
        }
        else {
            MessageBox({
                content: '¿Desea eliminar el item de la rutina?',
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

    $('#txtDetalle').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER){
              // $('#chkGrupal').focus();
               $('#ddlRutina').focus();
            return false;
        };
    });

    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtDetalle').val('');
    $('#ddlZonacorporal').val('0');
    $('#ddlEquipo').val('0');
    $('#txtSerie').val('0');
    $('#txtRepeticiones').val('0');
    $('#txtPeso').val('0');
    $('#ddlRutina').val(0).focus();
    Materialize.updateTextFields();
}

function MostrarDatos () {
    $.ajax({
        url: 'services/rutinagymdetalle/rutinagymdetalle-search.php',
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


            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].td_idrutinagym + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].td_idrutinagym + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content"> Nombre rutina:' + data[i].nombre + ' - ' + data[i].zona+ ' Equipo:' + data[i].equipo+ ' Serie:' + data[i].tm_serie + ' Repeticiones:' + data[i].tm_repeticiones + '</span>';
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';
                    strhtml += '</li>';
                    ++i;
                }
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';

            $('#gvDatos').html(strhtml);
        },
        // error: function (error) {
        //     console.log(error);
        // }
    });
}

function GuardarDatos () {
    var data = new FormData();
    var input_data = $('#pnlForm :input').serializeArray();
    data.append('btnGuardar', 'btnGuardar');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/rutinagymdetalle/rutinagymdetalle-post.php',
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
        // error: function (error) {
        //     console.log(error);
        // }
    });
}

function GetDataById (idItem) {
    var selectorModal = '#pnlForm';

    precargaExp(selectorModal, true);
    LimpiarForm();
    openModalCallBack(selectorModal, function () {

        if (idItem == '0') {
            ListarRutinagym_Combo('0');
            ListarZonacorporal_Combo('0');
            ListarEquipo_Combo('0');
            $('#txtDetalle').focus();

            precargaExp(selectorModal, false);
            }
        else {
            $.ajax({
                type: "GET",
                url: 'services/rutinagymdetalle/rutinagymdetalle-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {

                    if (data.length > 0){

                        $('#hdIdPrimary').val(data[0].td_idrutinagym);

                        $('#txtSerie').val(data[0].tm_serie);
                        $('#txtRepeticiones').val(data[0].tm_repeticiones);
                        $('#txtPeso').val(data[0].tm_peso);
                        
                        ListarRutinagym_Combo(data[0].tm_idrutinagym);
                        ListarZonacorporal_Combo(data[0].tm_idzonacorporal);
                        ListarEquipo_Combo(data[0].tm_idequipo);
                        
                        $('#txtDetalle').val(data[0].td_detalle).focus();                        

                        Materialize.updateTextFields();
                    };
                    
                    precargaExp(selectorModal, false);
                },

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
        url: 'services/rutinagymdetalle/rutinagymdetalle-post.php',
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

     
function ListarRutinagym_Combo (idrutinagym_default) {
    $.ajax({
        type: 'GET',
        url: 'services/rutinagym/rutinagym-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '4',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idrutinagym_default == data[i].tm_idrutinagym ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idrutinagym + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlRutina').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarZonacorporal_Combo (idzonacorporal_default) {
    $.ajax({
        type: 'GET',
        url: 'services/zonacorporal/zonacorporal-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idzonacorporal_default == data[i].tm_idzonacorporal ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idzonacorporal + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlZonacorporal').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarEquipo_Combo (idequipo_default) {
    $.ajax({
        type: 'GET',
        url: 'services/equipo/equipo-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idequipo_default == data[i].tm_idequipo ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idequipo + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlEquipo').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}