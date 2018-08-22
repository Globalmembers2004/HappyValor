$(function () {

     $('.timepicker').pickatime({
        default: 'now', // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
        aftershow: function(){} //Function for after opening timepicker
    });

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
                content: '¿Desea eliminar el tipo de ambiente?',
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

    MostrarDatos();
});

function LimpiarForm () {

    $('#hdIdPrimary').val('0');
    $('#ddlInstructor').val('0');
    $('#ddlDia').val('02');
    $('#txtHoraInicio').val('07:00');
    $('#txtHoraFinal').val('08:00');
    $('#txtAforo').val('0');
    $('#txtminutos').val('30');
    $('#ddlRutinaGrupal').val('0').focus();

}

function MostrarDatos () {
    $.ajax({
        url: 'services/horariogrupal/horariogrupal-search.php',
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
                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + data[i].td_idhorariogrupal  + '">';
                    
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].td_idhorariogrupal + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content"> DÍA:' + data[i].dia + '  RUTINA:' + data[i].rutina + '  INICIO:' + data[i].tm_hora_inicio + ' FINAL:' + data[i].tm_hora_final + ' INSTRUCTOR:' + data[i].instructor +'</span>';
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';
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
    if (validHoraClase()) {
        var data = new FormData();
        var input_data = $('#modalRegistro :input').serializeArray();

        data.append('btnGuardar', 'btnGuardar');

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/horariogrupal/horariogrupal-post.php',
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
        if (idData == '0')
            {
            ListarRutinagrupal_Combo('0');
            ListarInstructor_Combo('0');

            $('#ddlRutinaGrupal').focus();

            precargaExp(selectorModal, false);
            }
         else {
            $.ajax({
                url: 'services/horariogrupal/horariogrupal-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '5',
                    id: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#hdIdPrimary').val(data[0].td_idhorariogrupal);
                        $('#ddlDia').val(data[0].ta_diasemana);
                        $('#txtHoraInicio').val(data[0].tm_hora_inicio);
                        $('#txtHoraFinal').val(data[0].tm_hora_final);
                        $('#txtAforo').val(data[0].tm_aforo);
                        $('#txtminutos').val(data[0].tm_minutos_sep);

                        ListarRutinagrupal_Combo(data[0].tm_idrutinagrupal);
                        ListarInstructor_Combo(data[0].tm_idinstructorgrupal);


                        $('#ddlRutinaGrupal').val(data[0].tm_idrutinagrupal).focus();
                        
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
        url: 'services/horariogrupal/horariogrupal-post.php',
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

function ListarInstructor_Combo (idinstructor_default) {
    $.ajax({
        type: 'GET',
        url: 'services/instructorgrupal/instructorgrupal-search.php',
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
                    var _selected = idinstructor_default == data[i].tm_idinstructorgrupal ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idinstructorgrupal + '">' + data[i].instructor + '</option>';
                    ++i;
                };
            };

            $('#ddlInstructor').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarRutinagrupal_Combo (idrutinagrupal_default) {
    $.ajax({
        type: 'GET',
        url: 'services/rutinagrupal/rutinagrupal-search.php',
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
                    var _selected = idrutinagrupal_default == data[i].tm_idrutinagrupal ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idrutinagrupal + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlRutinaGrupal').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function validHoraClase () {
    var horainicio = $('#txtHoraInicio').val();
    var horafinal = $('#txtHoraFinal').val();
    var ms = moment(horafinal,"HH:mm:ss").diff(moment(horainicio,"HH:mm:ss"));
    var d = moment.duration(ms);
    var nMinutos = d.asMinutes();

    if (nMinutos > 0) {
        if (nMinutos < 45) {
            alert('La clase tiene que durar al menos 45 minutos.');
            return false;
        }
        else {
            if (nMinutos > 60) {
                alert('La clase no puede durar más de una hora.');
                return false;
            }
            else {
                return true;
            };
        };
    }
    else {
        if (nMinutos == 0) {
            alert('La hora de inicio y la hora final no pueden ser iguales.');
            return false;
        }
        else {
            alert('La hora de inicio no puede ser mayor a la hora final.');
            return false;
        };
    };
}