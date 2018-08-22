$(function () {
    $('[data-toogle="tooltip"]').tooltip();

    // $('#pnlConfigMenu > .sectionHeader').on('click', 'button', function(event) {
    //     var countSelected = 0;
    //     var targetId = '';

    //     targetId = $(this).attr('data-target');

    //     $(this).siblings('.success').removeClass('success');
    //     $(this).addClass('success');

    //     $('#pnlConfigMenu > .sectionContent > section').hide();

    //     if (targetId == '#tab1'){
    //         countSelected = $('#pnlUsuario .dato.selected').length;

    //         $('#btnAplicarPerfil').addClass('oculto');
    //         $('#btnNuevoPerfil, #btnEditarPerfil, #btnEliminarPerfil').addClass('oculto');

    //         if (countSelected > 0){
    //             if (countSelected == 1)
    //                 $('#btnEditar, #btnEliminar, #btnLimpiarSeleccion').removeClass('oculto');
    //             else
    //                 $('#btnEliminar, #btnLimpiarSeleccion').removeClass('oculto');
    //         }
    //         else
    //             $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
    //     }
    //     else if (targetId == '#tab2'){
    //         $('#btnAplicarPerfil').removeClass('oculto');
    //         if ($('#gvPerfil .tile').length > 0)
    //             $('#btnNuevoPerfil, #btnEditarPerfil, #btnEliminarPerfil').removeClass('oculto');
            
    //         $('#btnNuevo, #btnLimpiarSeleccion, #btnEditar, #btnEliminar, #btnUploadExcel').addClass('oculto');
    //     }
    //     $(targetId).show();
    // });

    // $('#pnlConfigUser > .sectionHeader').on('click', 'button', function(event) {
    //     var countSelected = 0;
    //     var targetId = '';

    //     targetId = $(this).attr('data-target');

    //     $(this).siblings('.success').removeClass('success');
    //     $(this).addClass('success');

    //     if (targetId == '#tabUser2'){
    //         if ($('#tablePerfil tbody tr').length == 0)
    //             ListarPerfiles('FIELD');
    //     }

    //     $('#pnlConfigUser > .sectionContent > section').hide();

    //     targetId = $(this).attr('data-target');
    //     $(targetId).show();
    // });

    // ListarPerfiles_Combo();

    $('#gvDatos').on('click', 'a', function(event) {
        event.preventDefault();
        
        var accion = this.getAttribute('data-action');
        var _row = getParentsUntil(this, '#gvDatos', '.dato');
        var iditem = _row[0].getAttribute('data-id');
        
        if (accion == 'edit')
            GetDataById(iditem);
        else if (accion == 'change-password'){
            $('#hdIdUsuarioClave').val(iditem);
            openCustomModal('#modalChangePassword');
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
                            EliminarItemUsuario(_row[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#btnCambiarClave').on('click', function(event) {
        event.preventDefault();
        CambiarClave();
    });

    $("#txtSearchPersonal").easyAutocomplete({
        url: function (phrase) {
            var url = "";
            var tipopersona = $('#ddlTipoPersona').val();

            if (tipopersona == '00') {
                url = "services/cliente/cliente-search.php?criterio=" + phrase + "&tipobusqueda=1&idempresa=" + $('#hdIdEmpresa').val() + "&idcentro=" + $('#hdIdCentro').val();
            }
            else if (tipopersona == '01'){
                url = "services/proveedores/proveedores-search.php?criterio=" + phrase + "&tipobusqueda=1&idempresa=" + $('#hdIdEmpresa').val() + "&idcentro=" + $('#hdIdCentro').val();
            }
            else if (tipopersona == '02'){
                url = "services/organigrama/organigrama-search.php?criterio=" + phrase + "&tipobusqueda=1&idempresa=" + $('#hdIdEmpresa').val() + "&idcentro=" + $('#hdIdCentro').val();
            };

            return url;
        },
        getValue: function (element) {
            return element.tm_nrodni +  ' - ' + element.tm_apellidopaterno + ' ' + element.tm_apellidomaterno + ' ' + element.tm_nombres;
        },
        list: {
            onSelectItemEvent: function () {
                var _element = $("#txtSearchPersonal").getSelectedItemData();
                var idpersonal = _element.tm_idpersonal;
                var nrodoc = _element.tm_nrodni;
                var apellidos = _element.tm_apellidopaterno + ' ' + _element.tm_apellidomaterno;
                var nombres = _element.tm_nombres;
                var email = _element.tm_email;
                var telefono = _element.tm_telefono;

                $("#hdIdPersona").val(idpersonal);
                $('#txtNumeroDoc').val(nrodoc);
                $('#txtApellidos').val(apellidos);
                $('#txtNombres').val(nombres);
                $('#txtEmail').val(email);
                $('#txtTelefono').val(telefono);

                Materialize.updateTextFields();
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return item.tm_nrodni +  ' - ' + item.tm_apellidopaterno + ' ' + item.tm_apellidomaterno + ' ' + item.tm_nombres;
            }
        },
        theme: 'square'
    });

    // $('#pnlPersona > .sectionHeader').on('click', 'button', function(event) {
    //     var tipodata = '';

    //     tipodata = $(this).attr('data-target');

    //     $('#hdTipoDataPersona').val(tipodata);
    //     $(this).siblings('.success').removeClass('success');
    //     $(this).addClass('success');

    //     BuscarPersona('1');
    // });

    // $('#gvPersona .items-area').on('click', '.list', function(event) {
    //     var idpersona = '0',
    //         nrodoc = '',
    //         descripcion = '',
    //         direccion = '';

    //     event.preventDefault();
        
    //     idpersona = $(this).attr('data-idpersona');
    //     nrodoc = $(this).find('main p .docidentidad').text();
    //     descripcion = $(this).find('main p .descripcion').text();
    //     direccion = $(this).find('main p .direccion').text();

    //     setPersona(idpersona, nrodoc, descripcion, direccion);
    // });

    // $('#pnlInfoPersonal').on('click', function(event) {
    //     event.preventDefault();
    //     ShowPanelPersona();
    // });

    // $('#btnExitPersona').on('click', function(event) {
    //     event.preventDefault();
    //     $('#pnlSearchPersona').fadeOut(400);
    // });

    $('#ddlCargo').focus().on('change', function () {
        idreferencia = $(this).val();
        LoadPersonal(TipoBusqueda, $(this).val(), '0', '1');
    });

    // $('#btnCancelar, #btnBackList').on('click', function () {    
    //     resetForm('form1');
    //     clearOnlyListSelection();
    //     clearImagenForm();
    //     BackToList();
    //     BuscarDatos('1');
    //     return false;
    // });

    // $('#btnEditar').on('click', function(event) {
    //     var id = $('#gvDatos .dato.selected').attr('data-id');
    //     event.preventDefault();
    //     LimpiarFormUsuario();
    //     openCustomModal('#modalRegistro');
    //     GetDataById(id);
    // });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();
        GetDataById('0');
    });
    
    // $('#gvDatos').on('click', function () {
    //     if ($('.filtro').length > 0){
    //         $('#btnFilter').removeClass('active');
    //         $('.filtro').slideUp();
    //     }
    // });

    BuscarDatos('1');

    // $('#txtSearch').on('keydown', function(event) {
    //     if (event.keyCode == $.ui.keyCode.ENTER) {
    //         BuscarDatos('1');
    //         return false;
    //     }
    // }).on('keypress', function(event) {
    //     if (event.keyCode == $.ui.keyCode.ENTER)
    //         return false;
    // });

    // $('#btnSearch').on('click', function () {
    //     BuscarDatos('1');
    //     return false;
    // });

    // if ($('#btnFilter').length > 0){
    //     $('#btnFilter').on('click', function(){
    //         if (!$(this).hasClass('active')){
    //             $(this).addClass('active');
    //             $('.filtro').slideDown();
    //             if ($('#ddlCategoria').length > 0)
    //                 $('#ddlCategoria').focus();
    //         }
    //         else {
    //             $(this).removeClass('active');
    //             $('.filtro').slideUp();
    //             $('#txtSearch').focus();                
    //         }
    //         return false;
    //     });
    // }

    // $('#btnEliminar').on('click', function (event) {
    //     event.preventDefault();
    //     EliminarDatos();
    // });

    // $("#btnLimpiarSeleccion").on('click', function(){
    //     clearSelection();
    //     return false;
    // });

    // $('#btnEliminarPerfil').on('click', function(event) {
    //     event.preventDefault();
    //     EliminarPerfil();
    // });

    $('#btnEditarPerfil').on('click', function(event) {
        var id = '0';
        event.preventDefault();
        
        id = $('#gvPerfil .tile.selected').attr('data-idperfil');

        LimpiarFormPerfil();
        openCustomModal('#modalPerfil');
        GetPerfil(id);
        
        $('#txtNombrePerfil').focus();
    });

    $('#btnNuevoPerfil').on('click', function(event) {
        event.preventDefault();
        
        LimpiarFormPerfil();
        openCustomModal('#modalPerfil');
        
        $('#txtNombrePerfil').focus();
    });

    // $('#gvPerfil').on('click', '.tile', function(event) {
    //     var idperfil = '0';
    //     event.preventDefault();

    //     idperfil = $(this).attr('data-idperfil');
        
    //     $(this).siblings('.selected').removeClass('selected');
    //     $(this).addClass('selected');

    //     ListarOpcionesMenu(idperfil);
    // });
    
    $('#btnGuardar').on('click', function(event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#btnGuardarPerfil').on('click', function(event) {
        event.preventDefault();
        GuardarPerfil();
    });

    $('#btnAplicarPerfil').on('click', function(event) {
        event.preventDefault();
        AplicarPerfil();
    });

    // $("#form1").validate({
    //     lang: 'es',
    //     showErrors: showErrorsInValidate,
    //     submitHandler: EnvioAdminDatos
    // });

    // $('.droparea').droparea({
    //     'instructions': 'Arrastre una imagen o haga click aqu&iacute;',
    //     'init' : function(result){
    //         clearImagenForm();
    //     },
    //     'start' : function(area){
    //         area.find('.error').remove(); 
    //     },
    //     'error' : function(result, input, area){
    //         $('<div class="error">').html(result.error).prependTo(area); 
    //         return 0;
    //     },
    //     'complete' : function(result, file, input, area){
    //         if((/image/i).test(file.type)){
    //             area.find('img').remove();
    //             area.append($('<img>',{'src': result.filename + '?' + Math.random() }));
    //             $('#hdFoto').val(result.filename);
    //         }
    //     }
    // });
    
    $('#chkAllMenu').on('click', function(event) {            
        var checking = $(this)[0].checked;
        var checkboxes = $('#tableMenu tbody input:checkbox');
        var countcheck = checkboxes.length;

        if (countcheck > 0) {
            for (var i = 0; i < countcheck; i++) {
                checkboxes[i].checked = checking;
            };
        };
    });

    // addValidFormRegister();
    
    ListarPerfiles('DATA');
});

// function ShowPanelPersona () {
//     $('#pnlSearchPersona').fadeIn(400, function () {
//         BuscarPersona('1');
//     });
// }

// function clearImagenForm () {
//     $("#area").find('img').remove();
//     $('#area .instructions').html('Arrastre una imagen o haga click aqu&iacute;');
//     $("#area > .spot").append($('<img>',{'src': 'images/product-nosetimg.png'}));
// }

// function addValidFormRegister () {
//     $('#txtEmail').rules('add', {
//         email: true,
//         maxlength: 100
//     });
// }

// function removeValidFormRegister () {
//     $('#txtEmail').rules('remove');
// }

function GetDataById (idData) {
    
    LimpiarFormUsuario();

    openModalCallBack('#modalRegistro', function () {
        if (idData == '0') {
            ListarPerfiles_Combo('0');
            ListarCentros_Combo('0');
            ListarCenCosto_Combo('0');

            habilitarControl('#txtClave,#txtConfirmClave', true);
            $('#ddlTipoPersona').focus();
        }
        else {
            $.ajax({
                url: 'services/usuarios/usuarios-search.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    tipobusqueda: '4',
                    idusuario: idData
                },
                success: function (data) {
                    if (data.length > 0) {
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        habilitarControl('#txtClave,#txtConfirmClave', false);

                        $('#hdIdUsuario').val(data[0].tm_idusuario);
                        $('#txtNombre').val(data[0].tm_login);
                        $('#txtNombres').val(data[0].tm_nombres);
                        $('#txtApellidos').val(data[0].tm_apellidos);
                        $('#txtEmail').val(data[0].tm_email);
                        $('#txtTelefono').val(data[0].tm_telefono);

                        $("#ddlTipoPersona").val(data[0].ta_tipopersona);
                        $("#hdIdPersona").val(data[0].tm_idpersona);

                        $('#txtSearchPersonal').val(data[0].tm_nrodni + ' - ' + data[0].tm_apellidos + ' ' + data[0].tm_nombres);

                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        hdFoto.value = foto_original;

                        ListarPerfiles_Combo(data[0].tm_idperfil);
                        ListarCentros_Combo(data[0].tm_idcentro);
                        ListarCenCosto_Combo(data[0].tm_idcencosto);

                        Materialize.updateTextFields();
                    };
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    });

    // $.ajax({
    //     type: "GET",
    //     url: "services/usuarios/usuarios-search.php",
    //     cache: false,
    //     dataType: 'json',
    //     data: "tipobusqueda=2&criterio=&idusuario=" + id,
    //     success: function(data){
    //         var count = 0;
    //         count = data.length;
            
    //         if (count > 0){
    //             $('#hdIdUsuario').val(data[0].tm_idusuario);
    //             $('#txtNombre').val(data[0].tm_login);
    //             $('#txtEmail').val(data[0].tm_email);
    //             $('#hdIdPerfilUsuario').val(data[0].tm_idperfil);
    //         }
    //     }
    // });
}

function setPersona (idpersona, nrodoc, descripcion, direccion) {
    $('#hdIdPersona').val(idpersona);

    $('#pnlInfoPersonal').attr('data-idpersona', idpersona);
    $('#pnlInfoPersonal .descripcion').text(descripcion);
    $('#pnlInfoPersonal .docidentidad').text(nrodoc);
    $('#pnlInfoPersonal .direccion').text(direccion);

    $('#pnlSearchPersona').fadeOut('400', function() {
        
    });
}

function BuscarDatos (pagina) {
    var selector = '#gvDatos .gridview';

    precargaExp('#gvDatos', true);
    
    $.ajax({
        type: "GET",
        url: "services/usuarios/usuarios-search.php",
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idusuario;
                    var foto = data[i].tm_foto;

                    strhtml += '<li class="mdl-list__item dato pos-rel" data-id="' + iditem + '">';
                
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<span class="mdl-list__item-primary-content">';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons mdl-list__item-avatar">person</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="mdl-list__item-avatar" />';

                    strhtml += data[i].tm_login;

                    if ((data[i].tm_nombres != null) && (data[i].tm_apellidos != null)){
                        if ((data[i].tm_nombres.trim().length > 0) && (data[i].tm_apellidos.trim().length > 0))
                            strhtml += ' (' + data[i].tm_nombres + ' ' + data[i].tm_apellidos + ')';
                    };

                    strhtml += '</span>';

                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5"><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="change-password" data-delay="50" data-position="bottom" title="Cambiar clave" data-tooltip="Cambiar password"><i class="material-icons">&#xE897;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" title="Editar" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" title="Eliminar" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';

                    strhtml += '</li>';

                    ++i;
                    // strhtml += '<a href="#" class="list dato bg-gray-glass" data-id="' + iditem + '">';

                    // strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    // strhtml += '<div class="list-content">';
                    // strhtml += '<div class="data">';
                    // strhtml += '<aside>';

                    // if (foto == 'no-set')
                    //     strhtml += '<i class="fa fa-user"></i>';
                    // else
                    //     strhtml += '<img src="' + foto + '" />';
                    // strhtml += '</aside>';
                    // strhtml += '<main><p class="fg-darker"><strong>' + data[i].tm_login + '</strong>Email: ' + data[i].tm_email + '</p>';
                    // strhtml += '</main></div></div>';
                    // strhtml += '</a>';
                };
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                // $('#hdPage').val(Number($('#hdPage').val()) + 1);

                // $(selector).on('scroll', function(){
                //     if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                //         var pagina = $('#hdPage').val();
                //         BuscarDatos(pagina);
                //     }
                // });
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#gvDatos', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

// function BackToList () {
//     removeValidFormRegister();
//     $('#btnNuevo, #btnUploadExcel').removeClass('oculto');
//     $('#btnGuardar, #btnCancelar').addClass('oculto');
//     $('#pnlForm').fadeOut(500, function () {
//         $('#pnlConfigMenu').fadeIn(500, function () {
//             $('#txtSearch').focus();
//         });
//     });
// }

function GuardarDatos () {
    var data = new FormData();
    var input_data = $('#modalRegistro :input').serializeArray();
    var file = fileValue;

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdFoto', $('#hdFoto').val());
    data.append('archivo', file);

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/usuarios/usuarios-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                closeCustomModal('#modalRegistro');
                BuscarDatos('1');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

// function EnvioAdminDatos (form) {
//     $.ajax({
//         type: "POST",
//         url: 'services/usuarios/usuario-post.php',
//         cache: false,
//         dataType: 'json',
//         data: $(form).serialize() + "&btnGuardar=btnGuardar",
//         success: function(data){
//             if (Number(data.rpta) > 0){
//                 MessageBox('Datos guardados', 'La operaci&oacute;n se complet&oacute; correctamente.', "[Aceptar]", function () {
//                     $('#hdPage').val('1');
//                     $('#hdPageActual').val('1');
//                     clearOnlyListSelection();
//                     BuscarDatos('1');
//                     clearImagenForm();
//                     resetForm('form1');
//                     BackToList();
//                 });
//             }
//         }
//     });
// }

function ListarPerfiles (tipomuestra) {
    var tipobusqueda = '';
    var idperfil = '0';
    var selectorLoading = '';
    var checking = '';
    
    if (tipomuestra == 'DATA'){
        tipobusqueda = '1';
        selectorLoading = '#pnlPermisos .gp-header';
    }
    else if (tipomuestra == 'FIELD'){
        tipobusqueda = 'PERFILUSER';
        idperfil = $('#hdIdPerfilUsuario').val();
        selectorLoading = '#tablePerfil .ibody';
    }

    precargaExp(selectorLoading, true);
    
    $.ajax({
        type: 'GET',
        url: 'services/perfil/perfil-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            idperfil: idperfil,
            idusuario: $('#hdIdUsuario').val()
        },
        success: function(data){
            var i = 0;
            var count = 0;
            var strhtml = '';
            var selector = '';

            count = data.length;

            if (tipomuestra == 'DATA')
                selector = '#gvPerfil';
            else if (tipomuestra == 'FIELD')
                selector = '#tablePerfil tbody';
            
            if (count > 0){
                while(i < count){
                    if (tipomuestra == 'DATA'){
                        strhtml += '<div data-idperfil="' + data[i].tm_idperfil + '" class="tile dato double" data-click="transform">';
                        strhtml += '<div class="tile-content">';
                        strhtml += '<div class="text-right padding10 ntp">';
                        strhtml += '<h3 class="fg-gray">' + data[i].tm_nombre + '</h3>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                        strhtml += '<div class="brand">';
                        strhtml += '<div class="label fg-darker">C&oacute;digo: ' + data[i].tm_codigo + '</div>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                        strhtml += '</div>';
                    }
                    else if (tipomuestra == 'FIELD'){
                        if (data[i].idperfilusuario == 0)
                            checking = '';
                        else
                            checking = ' checked=""';

                        strhtml += '<tr><td>';
                        strhtml += '<div class="input-control checkbox" data-role="input-control">';
                        strhtml += '<label>';
                        strhtml += '<input name="hdIdPefilMenu[]" type="checkbox" value="' + data[i].tm_idperfil + '"' + checking + ' />';
                        strhtml += '<span class="check"></span>';
                        strhtml += '</label></div>';
                        strhtml += '</td><td>' + data[i].tm_nombre + '</td></tr>';
                    }
                    ++i;
                }
                if (tipomuestra == 'DATA')
                    $(selector).html(strhtml).find('.tile:first').trigger('click');
                else if (tipomuestra == 'FIELD')
                    $(selector).html(strhtml);
            }
            else {
                if (tipomuestra == 'DATA')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                else if (tipomuestra == 'FIELD')
                    $(selector).html('');
            }
            
            precargaExp(selectorLoading, false);
        }
    });
}

function ListarCenCosto_Combo (idcentro_default) {
    $.ajax({
        type: 'GET',
        url: 'services/centrocosto/centrocosto-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdEmpresa').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idcentro_default == data[i].tm_idcencosto ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcencosto + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlCenCosto').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function ListarCentros_Combo (idcentro_default) {
    $.ajax({
        type: 'GET',
        url: 'services/centro/centro-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdEmpresa').val()
        },
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    var _selected = idcentro_default == data[i].tm_idcentro ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcentro + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlCentro').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarPerfiles_Combo (idperfil_default) {
    $.ajax({
        type: 'GET',
        url: 'services/perfil/perfil-search.php',
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
                    var _selected = idperfil_default == data[i].tm_idperfil ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idperfil + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            };

            $('#ddlPerfil').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function LimpiarFormUsuario () {
    // resetForm('#modalRegistro');
}

function LimpiarFormChangePassword () {
    $('#hdIdUsuarioClave').val('0');
    $('#txtNewPassword').val('');
    $('#txtConfirmNewPassword').val('');
}

// function LimpiarFormPerfil () {
//     $('#hdIdPerfil').val('0');
//     $('#txtNombrePerfil').val('');
//     $('#txtDescripcionPerfil').val('');
//     $('#txtAbreviaturaPerfil').val('');
// }

// function GetPerfil (idperfil) {
//     $.ajax({
//         type: 'GET',
//         url: 'services/perfil/perfil-search.php',
//         cache: false,
//         dataType: 'json',
//         data: {
//             tipobusqueda: '2',
//             idperfil: idperfil
//         },
//         success: function(data){
//             var count = 0;
//             count = data.length;
            
//             if (count > 0){
//                 $('#hdIdPerfil').val(data[0].tm_idperfil);
//                 $('#txtNombrePerfil').val(data[0].tm_nombre);
//                 $('#txtDescripcionPerfil').val(data[0].tm_descripcion);
//                 $('#txtAbreviaturaPerfil').val(data[0].tm_abreviatura);
//             }
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }

// function ListarOpcionesMenu (idperfil) {
//     $('#chkAllMenu')[0].checked = false;
//     precargaExp('#tableMenu .ibody', true);

//     $.ajax({
//         type: 'GET',
//         url: 'services/menu/menu-search.php',
//         cache: false,
//         dataType: 'json',
//         data: {
//             tipobusqueda: 'CONFIG',
//             idperfil: idperfil
//         },
//         success: function(data){
//             var i = 0;
//             var count = 0;
//             var strhtml = '';
//             var selector = '';

//             count = data.length;
//             selector = '#tableMenu tbody';

//             if (count > 0){
//                 /*while(i < count){
//                     ++i;
//                 }*/
//                 strhtml = treeMenu(data, 0, 0);
//                 $(selector).html(strhtml);
//             }
//             else
//                 $(selector).html('<h2>No se encontraron resultados.</h2>');                
            
//             precargaExp('#tableMenu .ibody', false);
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }

// function treeMenu(data, mom, level){
//     var checking = '';
//     var strhtml = '';

//     for (var k in data) {
//         if (data[k].tm_idmenuref == mom) {
//             if (data[k].idperfilmenu == 0)
//                 checking = '';
//             else
//                 checking = ' checked=""';

//             strhtml += '<tr>';
//             strhtml += '<td style="width:20px;">';
//             strhtml += '<div class="input-control checkbox" data-role="input-control">';
//             strhtml += '<label>';
//             strhtml += '<input name="hdIdMenu[]" type="checkbox" value="' + data[k].tm_idmenu + '"' + checking + ' />';
//             strhtml += '<span class="check"></span>';
//             strhtml += '</label></div>';
//             strhtml += '<input type="hidden"  value="' + data[k].idperfilmenu + '" />';
//             strhtml += '</td><td>' + data[k].tm_titulo + '</td></tr>';
//             strhtml += treeMenu(data, data[k].tm_idmenu, level);
//         }
//      }
//      return strhtml;
// }

function BuscarPersona (pagina) {
    var selector = '#gvPersona .items-area';
    var tipodata = '';
    var url = '';
    var elem;

    elem = $('#pnlPersona .sectionHeader button.success');
    tipodata = elem.attr('data-tipodata');

    if (tipodata == '00')
        url = 'services/clientes/clientes-search.php';
    else if (tipodata == '01')
        url = 'services/proveedores/proveedores-search.php';
    else if (tipodata == '02')
        url = 'services/organigrama/organigrama-search.php';

    precargaExp('#gvPersona', true);
    
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchPersona').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countDatos = data.length;
            var emptyMessage = '';
            var strhtml = '';

            if (countDatos > 0){
                if (tipodata == '00'){
                    while(i < countDatos){
                        iditem = data[i].tm_idtipocliente;
                        foto = data[i].tm_foto;
                        strhtml += '<a href="#" class="list dato bg-gray-glass" rel="' + iditem + '" data-tipocliente="' + data[i].tm_iditc + '">';

                        strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<div class="list-content">';
                        strhtml += '<div class="data">';
                        strhtml += '<aside>';

                        if (foto == 'no-set')
                            strhtml += '<i class="fa fa-user"></i>';
                        else
                            strhtml += '<img src="' + foto + '" />';
                        strhtml += '</aside>';
                        strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].Descripcion + '</strong>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].TipoDoc + ': ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                        strhtml += '</main></div></div>';
                        strhtml += '</a>';
                        ++i;
                    }
                }
                else if (tipodata == '01'){
                    while(i < countDatos){
                        iditem = data[i].tm_idproveedor;
                        foto = data[i].tm_foto;
                        strhtml += '<a href="#" class="list dato bg-gray-glass" rel="' + iditem + '">';

                        strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<div class="list-content">';
                        strhtml += '<div class="data">';
                        strhtml += '<aside>';

                        if (foto == 'no-set')
                            strhtml += '<i class="fa fa-user"></i>';
                        else
                            strhtml += '<img src="' + foto + '" />';
                        strhtml += '</aside>';
                        strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].tm_nombreproveedor + '</strong>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">RUC: ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                        strhtml += '</main></div></div>';
                        strhtml += '</a>';
                        ++i;
                    }
                }
                else if (tipodata == '02'){
                    while(i < countDatos){
                        iditem = data[i].tm_idpersonal;
                        foto = data[i].tm_foto;
                        strhtml += '<a href="#" class="list dato bg-gray-glass"rel="' + iditem + '">';

                        strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<div class="list-content">';
                        strhtml += '<div class="data">';
                        strhtml += '<aside>';

                        if (foto == 'no-set')
                            strhtml += '<i class="fa fa-user"></i>';
                        else
                            strhtml += '<img src="' + foto + '" />';
                        strhtml += '</aside>';
                        strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</strong>Cargo: <span class="direccion">' +data[i].Cargo + '</span><br /><span class="docidentidad">RUC: ' + data[i].tm_nrodni + '</span> - Email: ' + data[i].tm_email + '</p>';
                        strhtml += '</main></div></div>';
                        strhtml += '</a>';
                        ++i;
                    }
                }
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPagePersona').val(Number($('#hdPagePersona').val()) + 1);
                //alert($('#hdPagePersona').val());

                $(selector).on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPagePersona').val();
                        BuscarPersona(pagina);
                    }
                });
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                }
            }
            
            precargaExp('#gvPersona', false);
        }
    });
}

function EliminarUsuario () {
    indexList = 0;
    elemsSelected = $('#gvDatos').find('.selected');
    EliminarItemUsuario(elemsSelected[0], 'multiple');
}

function EliminarItemUsuario (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-id');

    data.append('btnEliminarUsuario', 'btnEliminarUsuario');
    data.append('hdIdUsuario', idmodel);

    $.ajax({
        url: 'services/usuarios/usuarios-post.php',
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
                });
                
                if (mode == 'multiple'){
                    ++indexList;
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemUsuario(elemsSelected[indexList], mode);
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
            
            if (endqueue)
                createSnackbar(titulomsje);
        },
        error:function (data){
            console.log(data);
        }
    });
}

function CambiarClave () {
    var data = new FormData();
    var input_data = $('#modalChangePassword :input').serializeArray();

    data.append('btnCambiarClave', 'btnCambiarClave');

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

     $.ajax({
        url: 'services/usuarios/usuarios-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0') {
                LimpiarFormChangePassword();
                closeCustomModal('#modalChangePassword');
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}