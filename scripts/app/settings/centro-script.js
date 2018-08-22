$(function () {
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
                content: '¿Desea eliminar el centro?',
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

    $('#btnBuscarDireccion').on('click', function() {
        var address = document.getElementById('txtDireccion').value;
        var geocoder = new google.maps.Geocoder();
        
        geocoder.geocode({ 'address': address}, geocodeResult);
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
            $('#txtDireccion').focus();
            return false;
        };
    });

    $('#ddlDepartamento').on('change', function(event) {
        event.preventDefault();

        ListarUbicacion('#ddlProvincia', $(this).val(), '0', function () {
            ListarUbicacion('#ddlDistrito', $('#ddlProvincia').val(), '0', function () {
            });
        });
    });

    $('#ddlProvincia').on('change', function(event) {
        event.preventDefault();

        ListarUbicacion('#ddlDistrito', $(this).val(), '0', function () {
        });
    });

    ListarUbicacion('#ddlDepartamento', '1', '0', function () {
        ListarUbicacion('#ddlProvincia', $('#ddlDepartamento').val(), '0', function () {
            ListarUbicacion('#ddlDistrito', $('#ddlProvincia').val(), '0', function () {
            });
        });
    });
    
    addValidCentro();
    MostrarDatos();
});

var messagesValid = {
    txtNombre: {
        remote: "Este nombre de centro ya existe"  
    }
};

var geocodeResult = function(results, status) {
    console.log('test');
    if (status == 'OK') {
        var _direccion_format = results[0].formatted_address;
        var _lat = results[0].geometry.location.lat;
        var _lng = results[0].geometry.location.lng;

        $('#hdLatitudCentro').val(_lat);
        $('#hdLongitudCentro').val(_lng);

        $('#lblDireccionFormateada').text(_direccion_format);
        $('#hdDireccionFormateada').val(_direccion_format);
    }
    else
        console.log("Geocoding no tuvo éxito debido a: " + status);
};

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#txtDireccion').val('');
    $('#hdLatitudCentro').val('0');
    $('#hdLongitudCentro').val('0');
    $('#lblDireccionFormateada').text('');
    $('#hdDireccionFormateada').val('');
    $('#txtNombre').val('').focus();
}

function MostrarDatos () {
    $.ajax({
        url: 'services/centro/centro-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdEmpresa').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].tm_idcentro + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idcentro + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content">' + data[i].tm_nombre + '</span>';
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';
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
    if ($('#form1').valid()) {
        var data = new FormData();
        var input_data = $('#modalRegistro :input').serializeArray();

        data.append('btnGuardar', 'btnGuardar');

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/centro/centro-post.php',
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
    };
}

function GetDataById (idData) {
    LimpiarForm();
    openModalCallBack('#modalRegistro', function () {
        if (idData != '0') {
            $.ajax({
                url: 'services/centro/centro-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdPrimary').val(data[0].tm_idcentro);
                        $('#txtNombre').val(data[0].tm_nombre);
                        $('#txtDireccion').val(data[0].tm_direccion);
                        $('#hdLatitudCentro').val(data[0].tm_latitud);
                        $('#hdLongitudCentro').val(data[0].tm_longitud);
                        $('#lblDireccionFormateada').text(data[0].tm_direccion_gmpas);
                        $('#hdDireccionFormateada').val(data[0].tm_direccion_gmpas);

                        ListarUbicacion('#ddlDepartamento', '1', data[0].tm_iddepartamento, function () {
                            ListarUbicacion('#ddlProvincia', $('#ddlDepartamento').val(), data[0].tm_idprovincia, function () {
                                ListarUbicacion('#ddlDistrito', $('#ddlProvincia').val(), data[0].tm_iddistrito, function () {
                                });
                            });
                        });

                        Materialize.updateTextFields();

                        $('#txtNombre').focus();
                    };
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        else
            $('#txtNombre').focus();
    });
}

function EliminarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/centro/centro-post.php',
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

function addValidCentro () {
    $('#txtNombre').rules('add', {
        required: true,
        remote: {
            url:  'services/centro/check-nombre.php',
            type: 'POST',
            data: {
                idempresa: function() {
                    return $('#hdIdEmpresa').val();
                },
                idregistro: function() {
                    return $('#hdIdPrimary').val();
                }
            }
        }
    });
}