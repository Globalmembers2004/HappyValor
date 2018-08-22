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
            $('#chkGrupal').focus();
            return false;
        };
    });

    MostrarDatos();
});

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#chkGrupal')[0].checked = false;
    $('#txtNombre').val('').focus();
}

function MostrarDatos () {
    $.ajax({
        url: 'services/instructorgrupal/instructorgrupal-search.php',
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
                    var iditem = data[i].tm_idinstructorgrupal;
                    var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion">' + data[i].tm_nombres + '</span>';

                    strhtml += '<span class="title descripcion">' + data[2].tm_apellidos + '</span>';

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
    var data = new FormData();
    var input_data = $('#modalRegistro :input').serializeArray();

    data.append('btnGuardar', 'btnGuardar');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/instructorgrupal/instructorgrupal-post.php',
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
                url: 'services/instructorgrupal/instructorgrupal-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idinstructorgrupal);
                        $('#txtNombre').val(data[0].tm_nombre);
                        $ if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';


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

// function addValidForm () {
//     $('#txtNombre').rules('add', {
//         required: true,
//         maxlength: 150
//     });
// }

// function GuardarDatos () {
//     $('#form1').submit();
// }
function EliminarItem (item, mode) {
    var data = new FormData();
    var id = item.getAttribute('data-id');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPrimary', id);

    $.ajax({
        type: "POST",
        url: 'services/instructorgrupal/instructorgrupal-post.php',
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

// function MostrarCargos () {
//     $.ajax({
//         url: 'services/cargos/cargos-search.php',
//         type: 'GET',
//         dataType: 'json',
//         data: {
//             tipobusqueda: '1',
//             criterio: ''
//         }
//     })
//     .done(function(data) {
//         var i = 0;
//         var countdata = 0;
//         var strhtml = '';

//         countdata = data.length;

//         if (countdata > 0){
//             while(i < countdata){
//                 strhtml += '<a href="#" class="list dato" data-id="' + data[i].tp_idcargo + '">';
//                 strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tp_idcargo + '" />';
//                 strhtml += '<div class="list-content">';
//                 strhtml += '<div class="data">';
//                 strhtml += '<h2>' + data[i].tp_nombre + '</h2>';
//                 strhtml += '</div></div></a>';
//                 ++i;
//             }
//         }
//         else
//             strhtml = '<h2>No se encontraron resultados.</h2>';

//         $('#gvCargo .listview').html(strhtml);
//     })
//     .fail(function() {
//         console.log("error");
//     })
//     .always(function() {
//         console.log("complete");
//     });
// }