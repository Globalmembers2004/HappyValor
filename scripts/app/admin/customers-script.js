$(function () {
    // var screenmode = getParameterByName('screenmode');

    BuscarDatos('1');

    $('#ddlTipoOperacion').on('change', function(event) {
        event.preventDefault();
        
        if ($(this).val() == '01')
            $('.rowOperacion').addClass('hide');
        else
            $('.rowOperacion').removeClass('hide');
    });

    $('#txtImporteLinea').on('focus', function(event) {
        event.preventDefault();
        this.select();
    });

    $('#tableLineaCredito').on('click', 'button[data-action="deudas"]', function(event) {
        event.preventDefault();
        
        var elem = getParentsUntil(this, '#tableLineaCredito', 'tr');
        elem = elem[0];

        openModalCallBack('#pnlDetalleLineaCredito', function () {
            idlineacredito = elem.getAttribute('data-idlineacredito');
            ListarDeudaCobrar(idlineacredito);
        });
    });

    $('#tableLineaDetalleCredito').on('click', 'button[data-action="pay"]', function(event) {
        event.preventDefault();
        
        var elem = getParentsUntil(this, '#tableLineaDetalleCredito', 'tr');
        elem = elem[0];

        var iddeuddacobrar = elem.getAttribute('data-iddeuddacobrar');
        $('#hdIdDeudaCobrar').val(iddeuddacobrar);
        
        LimpiarForm_CobroDeuda();

        openModalCallBack('#pnlCobroDeuda', function () {
        });
    });

    $('#ddlPaisNatural').on('change', function(event) {
        event.preventDefault();
        ListarUbicacion('#ddlRegionNatural', this.value, '0');
    });

    $('#ddlPaisEmpresa').on('change', function(event) {
        event.preventDefault();
        ListarUbicacion('#ddlRegionEmpresa', this.value, '0');
    });

    $('.date-register').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('#btnCobroDeuda').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#pnlCobroDeuda', function () {
            
        });
    });

    $('#btnCobrarDeuda').on('click', function(event) {
        event.preventDefault();
        CobrarDeuda();
    });

    $('#btnGenerarLineaCredito').on('click', function(event) {
        event.preventDefault();
        openModalCallBack('#pnlFormLineaCredito', function () {
        });
    });

    $('#btnAplicarLineaCredito').on('click', function(event) {
        event.preventDefault();
        GuardarLineaCredito();
    });
    
    $('#btnSearch').on('click', function(event) {
        event.preventDefault();

        datagrid.showAppBar(true, 'search');
        $('#txtSearch').focus();
    });

    $('.back-button').on('click', function () {
        $('#btnUnSelectAll').trigger('click');
    });

    $('#generic-actionbar').on('click touchend', 'button', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        
        if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar todo lo seleccionado?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            EliminarCliente();
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#gvDatos').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var accion = this.getAttribute('data-action');
        // var parent = this.parentNode.parentNode.parentNode.parentNode;
        var parent = getParentsUntil(this, '#gvDatos', '.dato');
        var idmodel = parent[0].getAttribute('data-idmodel');
        var _nombrecliente = parent[0].getElementsByClassName('descripcion')[0].innerHTML + ' con ' + parent[0].getElementsByClassName('docidentidad')[0].innerHTML;

        console.log(_nombrecliente);
        
        if (accion == 'edit')
            GoToEdit(idmodel);
        else if (accion == 'lineacredito'){
            $('#hdIdCliente').val(idmodel);
            $('#lblCliente').text(_nombrecliente);

            openModalCallBack('#pnlLineaCredito', function () {
                ListarLineaCredito('1');
            });
        }
        else if (accion == 'delete'){
            MessageBox({
                content: '¿Desea eliminar este elemento?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Eliminar',
                        onClickButton: function (event) {
                            EliminarItemCliente(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    // if (screenmode == 'search'){
    //     $('#btnSelectAll').addClass('oculto');

    //     $('#btnSelectOne').on('click', function(event) {
    //         event.preventDefault();
    //         SeleccionarCliente();
    //     });
    // }
    // else {
    //     $('#btnSelectOne').addClass('oculto');
    // };
    
    // $('#btnCustomBack').on('click', function(event) {
    //     event.preventDefault();
        
    //     if (screenmode == 'search') {
    //         window.parent.closePanelCliente();
    //     }
    //     else {
    //         window.top.showDesktop();
    //     };
    // });

    $('#btnNuevo').on('click', function (event) {
        event.preventDefault();
        GoToEdit('0');
    });

    $('#btnTipoCliente').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$('#btnTipoCliente').hasClass('disabled')){
            $('#mnuTipoCliente').addClass('is-visible');
        };
    });

    // $('#mnuTipoCliente').on('click', 'a', function(event) {
    //     event.preventDefault();
        
    //     var tipocliente = this.getAttribute('data-tipocliente');
    //     var referencia = this.getAttribute('href');
    //     var titulo = this.innerText;

    //     console.log(this);

    //     showTabTipoCliente(tipocliente, referencia, titulo);

    //     $('#mnuTipoCliente').removeClass('is-visible');
    // });

    $('#btnGuardar').on('click', function (evt) {
        GuardarDatos();
    });

    // $('.droping-air .file-import').on({
    //     'dragenter': function (event) {
    //         event.stopPropagation();
    //         event.preventDefault();
    //     },
    //     'dragover': function (event) {
    //         event.stopPropagation();
    //         event.preventDefault();
    //     },
    //     'change': function(event) {
    //         event.preventDefault();

    //         prepareImport(this.files);
    //     },
    //     'drop': function (event) {
    //         event.preventDefault();
    //         var files = event.originalEvent.dataTransfer.files;

    //         prepareImport(files);
    //     }
    // });

    // $('#btnCancelarSubida').on('click', function(event) {
    //     event.preventDefault();
    //     cancelImport();
    // });

    // $('#btnSubirDatos').on('click', function(event) {
    //     event.preventDefault();
    //     executeImport();
    // });
});

var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var progressSuccess = false;
var datagrid = new DataList('#gvDatos', {
    onSearch: function () {
        BuscarDatos(datagrid.currentPage());
    }
});

function LimpiarForm_CobroDeuda () {
    $('#ddlTipoOperacion')[0].selectedIndex = 0;
    $('#ddlTipoOperacion').trigger('change');
    $('#ddlBanco')[0].selectedIndex = 0;
    $('#txtNroCuentaBancaria').val('');
    $('#txtNroOperacion').val('');
    
    $('#txtFechaPago').val(moment().format('DD/MM/YYYY'));

    $('#txtImportePago').val('0.00');
    $('#txtImporteMora').val('0.00');
}

function showTabTipoCliente (tipocliente, referencia, titulo) {
    $('#pnlForm .mdl-layout-title .text').text(titulo);

    $('#hdTipoCliente').val(tipocliente);
    $('#pnlForm section').addClass('hide');
    $(referencia).removeClass('hide');
    setDefaultFocus();
}

function BuscarDatos (pagina) {
    var selectorgrid = '*#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/clientes/clientes-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var strhtml = '';
            var bgtiporelacion = '';

            var screenmode = getParameterByName('screenmode');
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idtipocliente;
                    var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion">' + data[i].Descripcion + '</span>';
                    
                    strhtml += '<p>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br>';

                    strhtml += '<span class="docidentidad">' + data[i].TipoDoc + ': ' + data[i].tm_numerodoc + '</span> - ' + data[i].tm_email + '</p>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="lineacredito" class="waves-effect">L&iacute;nea de cr&eacute;dito</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';

                    ++i;
                };

                datagrid.currentPage(datagrid.currentPage() + 1);
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append('beforeend', strhtml);
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No hay datos.</h2>');
            };
            
            precargaExp('#pnlListado', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function SeleccinoarCliente () {
    var cliente = $('#gvDatos .dato.selected');
    var idcliente = cliente[0].getAttribute('data-idcliente');
    var descripcion = cliente.find('.descripcion').text();
    
    window.parent.setCliente(idcliente, descripcion);
}

// function prepareImport (files) {
//     var allowedTypes = ['xls','xlsx'];
//     var extension = '';
//     var filename = '';

//     fileValue = files[0]; 
//     filename = fileValue.name;
//     extension = filename.split('.').pop().toLowerCase();

//     if($.inArray(extension, allowedTypes) == -1) {
//         MessageBox('Extensi&oacute;n no v&aacute;lida', 'El tipo de archivo no es compatible para la importaci&oacute;n', "[Aceptar]", function () {

//         });
//         return false;
//     };

//     $('.droping-air .help').text(filename);
//     $('.droping-air').addClass('dropped');

//     habilitarControl('#btnSubirDatos', true);
//     $('#btnSubirDatos').addClass('success');
// }

// function cancelImport () {
//     var pbMetro;

//     pbMetro = $('.progress-bar').progressbar();
    
//     $('.droping-air .help').text('Seleccione o arrastre un archivo de Excel');
//     $('.droping-air').removeClass('dropped');

//     habilitarControl('#btnSubirDatos', false);
//     $('#btnSubirDatos').removeClass('success');

//     $('.droping-air .file-import').val('');

//     pbMetro.progressbar('value', 0);
//     pbMetro.progressbar('color', 'bg-cyan');

//     fileValue = false;
// }

// function executeImport () {
//     var pbMetro;
//     var file = fileValue;
//     var data = new FormData();
//     var intervalProgress;

//     pbMetro = $('.progress-bar').progressbar();

//     intervalProgress = new Interval(function(){
//         pbMetro.progressbar('value', (++progress));
//         if (progress == 100){
//             intervalProgress.stop();
//             if (progressSuccess)
//                 intervalProgress.start();
//         };
//     }, 100);

//     pbMetro.progressbar('value', '0');
//     pbMetro.progressbar('color', 'bg-cyan');

//     data.append('btnSubirDatos', 'btnSubirDatos');
//     data.append('archivo', file);

//     $.ajax({
//         type: "POST",
//         url: "services/cliente/cliente-post.php",
//         contentType:false,
//         processData:false,
//         cache: false,
//         dataType: 'json',
//         data: data,
//         success: function(data){
//             progressError = false;
//             if (data.rpta != '0')
//                 progressSuccess = true;
            
//             pbMetro.progressbar('value', 100);
//             pbMetro.progressbar('color', 'bg-green');

//             if (intervalProgress.isRunning())
//                 intervalProgress.stop();
            
//             MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
//                 if (data.rpta != '0'){
//                     closeCustomModal('#modalUploadExcel');
//                     cancelImport();
//                     paginaGeneral = 1;
//                     BuscarDatos('1');
//                 };
//             });
//         },
//         beforeSend: function () {
//             intervalProgress.start();
//         },
//         complete: function () {
//             progress = 0;
            
//             if (progressError){
//                 setTimeout(function () {
//                     if (intervalProgress.isRunning())
//                         intervalProgress.stop();
//                     pbMetro.progresskbar('value', 100);
//                     executeImport();
//                 }, 10000);
//             };
//         },
//         error:function (data){
//             progress = 0;
//             pbMetro.progressbar('color', 'bg-red');
//             progressError = true;
//             console.log(data);
//         }
//     });
// }

// function SetTabByDefault(tipocliente){
//     var buttoncli = '';
//     var targedId = '';

//     if (tipocliente == 'NA')
//         targedId = '#tab1';
//     else
//         targedId = '#tab2';
    
//     buttoncli = '[data-tipocliente="' + tipocliente + '"]';

//     $('#pnlForm > .title-window button').removeClass('success');
//     $('#pnlForm > .title-window button' + buttoncli).addClass('success');

//     $('#pnlForm > .divContent section.tab-principal').hide();
//     $(targedId).show();
// }

// function setUbigeo (idubigeo, descripcion) {
//     var selector = '';
//     var selectorHidden = '';
//     var TipoCliente = $('#pnlForm > .title-window button.success').attr('data-tipocliente');

//     if (TipoCliente == 'NA'){
//         selector = '#pnlInfoUbigeoNatural';
//         selectorHidden = '#hdIdUbigeoNatural';
//     }
//     else {
//         selector = '#pnlInfoUbigeoEmpresa';
//         selectorHidden = '#hdIdUbigeoJuridico';
//     };

//     $(selector).attr('data-idubigeo', idubigeo);
//     $(selector + ' .info .descripcion').text(descripcion);

//     $(selectorHidden).val(idubigeo);
//     closeCustomModal('#modalUbigeo');
// }

// function ListarUbigeo () {
//     $.ajax({
//         url: 'services/ubigeo/ubigeo-autocomplete.php',
//         type: 'GET',
//         dataType: 'json',
//         data: {
//             tipobusqueda: '1',
//             criterio: $('#txtSearchUbigeo').val()
//         }
//     })
//     .done(function(data) {
//         var countdata = 0;
//         var i = 0;
//         var strhtml = '';

//         countdata = data.length;

//         if (countdata > 0){
//             while(i < countdata){
//                 strhtml += '<div data-idubigeo="' + data[i].tm_idubigeo + '" title="' + data[i].ubigeo + '" class="panel-info without-foto">';
//                 strhtml += '<div class="info">';
//                 strhtml += '<h3 class="descripcion">' + data[i].ubigeo + '</h3>';
//                 strhtml += '</div>';
//                 strhtml += '</div>';
//                 ++i;
//             };
//         }
//         else {
//             strhtml = '<h2>No hay datos.</h2>';
//         };

//         $('#gvUbigeo').html(strhtml);
//     })
//     .fail(function() {
//         console.log("error");
//     })
//     .always(function() {
//         console.log("complete");
//     });
// }

// function clearImagenForm () {
//     $('#fileUploadImage').val('');
//     $('#imgFoto').attr({
//         'src': 'images/user-nosetimg-233.jpg',
//         'data-src': 'images/user-nosetimg-233.jpg'
//     });
//     $('#btnResetImage').addClass('oculto');
// }

// function addValidPersonaNatural () {
//     $('#txtNroDocNatural').rules('add', {
//         minlength: 8,
//         digits: true,
//         required : true
//     });

//     $('#txtApePaterno').rules('add', {
//         required : true
//     });

//     $('#txtApeMaterno').rules('add', {
//         required : true
//     });

//     $('#txtNombres').rules('add', {
//         required : true
//     });
// }

// function removeValidPersonaNatural () {
//     $('#txtNroDocNatural').rules('remove');
//     $('#txtApePaterno').rules('remove');
//     $('#txtApeMaterno').rules('remove');
//     $('#txtNombres').rules('remove');
// }

// function addValidPersonaJuridica () {
//     $('#txtRucEmpresa').rules('add', {
//         minlength: 11,
//         digits: true,
//         required : true
//     });

//     $('#txtRazonSocial').rules('add', {
//         required : true
//     });
// }

// function removeValidPersonaJuridica () {
//     $('#txtRucEmpresa').rules('remove');
//     $('#txtRazonSocial').rules('remove');
// }

function LimpiarForm () {
    $('#hdIdPrimary').val('0');
    $('#hdCodigoOri').val('0');
    $('#ddlTipoDocJuridica')[0].selectedIndex = 0;
    $('#txtRucEmpresa').val('');
    $('#txtRazonSocial').val('');
    $('#txtDireccionEmpresa').val('');
    $('#txtTelefonoEmpresa').val('');
    $('#txtEmailEmpresa').val('');
    $('#txtWebEmpresa').val('');
    $('#ddlTipoDocNatural')[0].selectedIndex = 0;
    $('#txtNroDocNatural').val('');
    $('#txtApePaterno').val('');
    $('#txtApeMaterno').val('');
    $('#txtNombres').val('');
    $('#txtDireccionNatural').val('');
    $('#txtTelefonoNatural').val('');
    $('#txtEmailNatural').val('');
}

function GuardarDatos () {
    var hdFoto = document.getElementById('hdFoto');
    var file = fileValue;
    var data = new FormData();

    // if ($('#form1').valid()){
        precargaExp('#pnlForm', true);

        if (hdFoto.value == 'images/user-nosetimg-233.jpg')
            hdFoto.value = 'no-set';

        data.append('btnGuardar', 'btnGuardar');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());
        data.append('archivo', file);

        var input_data = $('#pnlForm :input').serializeArray();

         Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: "POST",
            url: "services/clientes/clientes-post.php",
            contentType:false,
            processData:false,
            cache: false,
            dataType: 'json',
            data: data,
            success: function(data){
                precargaExp('#pnlForm', false);

                createSnackbar(data.titulomsje);
                
                if (data.rpta != '0'){
                    // removeValidFormRegister();

                    closeCustomModal('#pnlForm');
                    paginaGeneral = 1;
                    BuscarDatos('1');
                };
                // MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                //     if (data.rpta != '0'){
                //         if ( $('#hdTipoCliente').val() == 'NA') {
                //             removeValidPersonaNatural();
                //         }
                //         else {
                //             removeValidPersonaJuridica();
                //         };
                //         closeCustomModal('#pnlForm');
                //         paginaGeneral = 1;
                //         BuscarDatos('1');
                //     };
                // });
            },
            error:function (data){
                console.log(data);
            }
        });
    // };
}

function setDefaultFocus () {
    //$('*#pnlForm section:not(.hide) .first-focus').focus();
}

function GoToEdit (idItem) {
    var screenmode = '';
    var tipocliente = 'NA';
    var referencia = '#tabNatural';
    var titulo = 'Cliente tabNatural';
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';
    document.getElementById('hdFoto').value = 'no-set';

    precargaExp(selectorModal, true);

    resetFoto('new');
    LimpiarForm();
    // resetForm(selectorModal);

    // if ($('#hdTipoCliente').val() == 'NA') {
    //     removeValidPersonaJuridica();
    //     addValidPersonaNatural();
    // }
    // else {
    //     removeValidPersonaNatural();
    //     addValidPersonaJuridica();
    // };

    openModalCallBack(selectorModal, function () {
        if (idItem == '0'){
            precargaExp(selectorModal, false);
            showTabTipoCliente (tipocliente, referencia, titulo);
            habilitarLink('#btnTipoCliente', true);
        }
        else {
            $.ajax({
                url: 'services/clientes/clientes-search.php',
                type: 'GET',
                dataType: 'json',
                cache: false,
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idItem
                },
                success: function (data) {
                    if (data.length > 0){

                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");
                        
                        tipocliente = data[0].tm_iditc;
                        referencia = tipocliente == 'NA' ? '#tabNatural' : '#tabJuridico';
                        titulo = tipocliente == 'NA' ? 'Cliente natural' : 'Cliente jurídico';

                        $('#hdIdPrimary').val(data[0].tm_idtipocliente);
                        $('#hdCodigoOri').val(data[0].tm_codigo_ori);
                        $('#hdTipoCliente').val(data[0].tm_iditc);

                        showTabTipoCliente (tipocliente, referencia, titulo);

                        if (tipocliente == 'NA'){
                            $('#ddlTipoDocNatural').val(data[0].tm_iddocident).trigger('change');
                            $('#txtNroDocNatural').val(data[0].tm_numerodoc);
                            $('#txtDireccionNatural').val(data[0].tm_direccion);
                            $('#txtTelefonoNatural').val(data[0].tm_telefono);
                            $('#txtApePaterno').val(data[0].tm_apepaterno);
                            $('#txtApeMaterno').val(data[0].tm_apematerno);
                            $('#txtNombres').val(data[0].tm_nombres);
                            $('#txtEmailNatural').val(data[0].tm_email);
                            $('#ddlPaisNatural').changeMaterialSelect(data[0].tp_idpais);
                            
                            ListarUbicacion('#ddlRegionNatural', data[0].tp_idpais, data[0].tm_idciudad);
                        }
                        else {
                            $('#ddlTipoDocJuridica').val(data[0].tm_iddocident).trigger('change');
                            $('#txtRucEmpresa').val(data[0].tm_numerodoc);
                            $('#txtRazonSocial').val(data[0].tm_razsocial);
                            $('#txtEmailEmpresa').val(data[0].tm_email);
                            $('#txtRepresentante').val(data[0].tm_representante);
                            $('#txtDireccionEmpresa').val(data[0].tm_direccion);
                            $('#txtTelefonoEmpresa').val(data[0].tm_telefono);
                            $('#txtWebEmpresa').val(data[0].tm_urlweb);
                            $('#ddlPaisEmpresa').changeMaterialSelect(data[0].tp_idpais);

                            ListarUbicacion('#ddlRegionEmpresa', data[0].tp_idpais, data[0].tm_idciudad);
                        };

                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        hdFoto.value = foto_original;

                        Materialize.updateTextFields();
                    };

                    habilitarLink('#btnTipoCliente', false);
                    precargaExp(selectorModal, false);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };
    });
}

function EliminarCliente () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemCliente(elemsSelected[0], 'multiple');
}

function EliminarItemCliente (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdCliente', idmodel);

    $.ajax({
        url: 'services/clientes/clientes-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var scrollProyectos;
            var iScroll = 0;
            var titulomsje = '';
            var itemSelected;
            var heightItem = 0;
            
            itemSelected = $(item);
            heightItem = itemSelected.height();

            if (data.rpta == '0'){
                endqueue = true;
                titulomsje = 'No se puede eliminar';
            }
            else {
                itemSelected.fadeOut(400, function() {
                    $(this).remove();
                });

                if (mode == 'multiple'){
                    ++indexList;
                    
                    scrollProyectos = $('#gvDatos .gridview');
                    iScroll = scrollProyectos.scrollTop();

                    if (indexList <= elemsSelected.length - 1){
                        iScroll = iScroll + (heightItem + 18);
                        
                        scrollProyectos.animate({ scrollTop: iScroll  }, 400, function () {
                            EliminarItemCliente(elemsSelected[indexList], mode);
                        });
                    }
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

                if ($('.actionbar').hasClass('is-visible')){
                    $('.back-button').trigger('click');
                };
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function ListarLineaCredito (pagina) {
   
    $.ajax({
        type: 'GET',
        url: 'services/lineacredito/lineacredito-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: $('#hdIdCliente').val()
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-idlineacredito="' + data[i].td_idlineacredito + '">';
                    strhtml += '<td class="align-center">' + (i + 1) + '</td>';
                    strhtml += '<td class="align-center">' + ConvertMySQLDate(data[i].FechaReg) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].importelinea).toFixed(2) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].consumo).toFixed(2) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].cancelado).toFixed(2) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].saldo).toFixed(2) + '</td>';
                    strhtml += '<td class="align-center no-padding"><button class="mdl-button mdl-button--colored tooltipped margin5" type="button" data-action="deudas" data-delay="50" data-position="bottom" data-tooltip="DEUDAS">DEUDAS</button></td>';
                    strhtml += '<td class="align-center no-padding"><button class="mdl-button mdl-button--colored tooltipped margin5" type="button" data-action="cobros" data-delay="50" data-position="bottom" data-tooltip="COBROS">COBROS</button></td>';
                    strhtml += '</tr>';
                    ++i;
                };
                
                $('#tableLineaCredito .empty_state').addClass('hide');
                $('#tableLineaCredito .table-responsive-vertical').removeClass('hide');


                // $('#btnCobroDeuda').removeClass('hide');
            }
            else {
                $('#tableLineaCredito .empty_state').removeClass('hide');
                $('#tableLineaCredito .table-responsive-vertical, #btnCobroDeuda').addClass('hide');
            };
            
            $('#tableLineaCredito tbody').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function CobrarDeuda() {
    var data = new FormData();
    var input_cobranza = $('#pnlCobroDeuda :input').serializeArray();

    data.append('btnCobrarDeuda', 'btnCobrarDeuda');

    Array.prototype.forEach.call(input_cobranza, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/lineacredito/lineacredito-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);

            if (data.rpta != '0') {
                closeCustomModal('#pnlCobroDeuda');
                ListarDeudaCobrar(idlineacredito);
                ListarLineaCredito('1');
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function GuardarLineaCredito () {
    var data = new FormData();
    var input_data = $('#pnlFormLineaCredito :input').serializeArray();

    data.append('btnAplicarLineaCredito', 'btnAplicarLineaCredito');
    data.append('hdIdCliente', $('#hdIdCliente').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/lineacredito/lineacredito-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);

            if (data.rpta != '0') {
                closeCustomModal('#pnlFormLineaCredito');
                ListarLineaCredito('1');
            };
        },
        error: function (data){
            console.log(data);
        }
    });
}

var idlineacredito = 0;

function ListarDeudaCobrar (idlineacredito) {
    $.ajax({
        type: 'GET',
        url: 'services/lineacredito/deudacobrar-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            id: idlineacredito
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr data-iddeuddacobrar="' + data[i].td_iddeudacobrar + '">';
                    strhtml += '<td class="align-center">' + (i + 1) + '</td>';
                    strhtml += '<td class="align-center">' + ConvertMySQLDate(data[i].td_fechagen) + '</td>';
                    strhtml += '<td class="align-center">' + ConvertMySQLDate(data[i].td_fechainipago) + '</td>';
                    strhtml += '<td class="align-center">' + ConvertMySQLDate(data[i].td_fechafinpago) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].td_valormora).toFixed(2) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].td_importe).toFixed(2) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].td_importecancelado).toFixed(2) + '</td>';
                    strhtml += '<td class="align-right">' + Number(data[i].saldo).toFixed(2) + '</td>';
                    strhtml += '<td class="align-center">' + data[i].EstadoDeuda + '</td>';
                    strhtml += '<td class="align-center no-padding"><button class="mdl-button mdl-button--colored tooltipped margin5" type="button" data-action="pay" data-delay="50" data-position="bottom" data-tooltip="Cobrar deuda">Cobrar deuda</button></td>';
                    strhtml += '</tr>';
                    ++i;
                };
                
                $('#tableLineaDetalleCredito .empty_state').addClass('hide');
                $('#tableLineaDetalleCredito .table-responsive-vertical').removeClass('hide');

                // $('#btnCobroDeuda').removeClass('hide');
            }
            else {
                $('#tableLineaDetalleCredito .empty_state').removeClass('hide');
                $('#tableLineaDetalleCredito .table-responsive-vertical').addClass('hide');
            };

            $('#tableLineaDetalleCredito tbody').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Buscar () {
    BuscarDatos('1');
}

function showAll () {
    $('#txtSearch').val('');
    Buscar();
}