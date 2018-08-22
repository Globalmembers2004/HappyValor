$(function () {
    $('[data-toogle="tooltip"]').tooltip();

    $('.datepicker').pickadate({
        format: 'dd/mm/yyyy',
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false // Close upon selecting a date,
    });

    $('#gvDatos').on('click', '.mdl-button', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row = getParentsUntil(this, '#gvDatos', '.dato');
        
        if (accion == 'edit'){
            var iditem = _row[0].getAttribute('data-id');
            GetDataById(iditem);
        }
        else if (accion == 'delete') {
            MessageBox({
                content: '¿Desea eliminar el periodo?',
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
         }   
        else if (accion == 'close') {
            MessageBox({
                content: '¿Desea Cerrar el periodo?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Cerrar',
                        onClickButton: function (event) {
                            CerrarItem(_row[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        }
        else  {
            MessageBox({
                content: '¿Desea Fijar este periodo de trabajo?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'fijar',
                        onClickButton: function (event) {
                            FijarItem(_row[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        }

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

    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtFechaInicio').val(moment().format('DD/MM/YYYY'));
    $('#txtFechaFinal').val(moment().format('DD/MM/YYYY'));    
    $('#txtNombre').val('').focus();
}

function MostrarDatos () {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';
    $.ajax({
        url: 'services/periodo/periodo-search.php',
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
                    if (data[i].ta_estado_periodo =='01') {
                        icon_status = '<i class="material-icons">&#xE8DB;</i>';
                        color_fila = '#07a7f2';
                    }
                    else {
                            icon_status = '<i class="material-icons">&#xE5CD;</i>';
                            color_fila = '#f9fffd'; 
                    };
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].tm_idperiodo + '"  data-baselement="' + selectorgrid + '" style="background-color: ' + color_fila + ';">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idperiodo + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content"> Descripción:' + data[i].tm_descripcion + '</span>';
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" title="Editar" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" title="Eliminar" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="fixed" data-delay="50" data-position="bottom" title="Fijar" data-tooltip="Fijar periodo trabajo"><i class="material-icons">check_circle</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="close" data-delay="50" data-position="bottom" title="Cerrar" data-tooltip="Cerrar"><i class="material-icons">https</i></a></div>';
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
        url: 'services/periodo/periodo-post.php',
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
        if (idData != '0') {
            $.ajax({
                url: 'services/periodo/periodo-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdPrimary').val(data[0].tm_idperiodo);
                        $('#txtNombre').val(data[0].tm_descripcion);
                        $('#txtFechaInicio').val(ConvertMySQLDate(data[0].tm_fechainicial));
                        $('#txtFechaFinal').val(ConvertMySQLDate(data[0].tm_fechafinal));
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
        url: 'services/periodo/periodo-post.php',
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


function CerrarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnCerrar', 'btnCerrar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/periodo/periodo-post.php',
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
                titulomsje = 'No se puede cerrar';
            }
            else {
                $(item).fadeOut(400, function() {
                    // $(this).remove();

                    if ($('#gvDatos .dato').length == 0)
                        $('#gvDatos .gridview').html('<h2>No se encontraron registros</h2>');
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        CerrarItem(elemsSelected[indexList], mode);
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

function FijarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnFijar', 'btnFijar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/periodo/periodo-post.php',
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
                titulomsje = 'No se puede fijar';
            }
            else {
                $(item).fadeOut(400, function() {
                    // $(this).remove();

                    if ($('#gvDatos .dato').length == 0)
                        $('#gvDatos .gridview').html('<h2>No se encontraron registros</h2>');
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        FijarItem(elemsSelected[indexList], mode);
                    else {
                        endqueue = false;
                        titulomsje = data.titulomsje;
                    };
                }
                else if (mode == 'single') {
                    endqueue = false;
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
