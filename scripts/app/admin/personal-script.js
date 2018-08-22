$(function () {
    BuscarDatos('1');

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
                            EliminarPersonal();
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
        
        if (accion == 'edit')
            GoToEdit(idmodel);
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
                            EliminarItemPersonal(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#btnNuevo').on('click', function (event) {
        event.preventDefault();
        GoToEdit('0');
    });
    
    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();

        ///if ($('#chkCrearUsuario')[0].checked) {
            
        //}            
        GuardarDatos();
    });
});

var indexList = 0;
var elemsSelected;
var progress = 0;
var progressError = false;
var datagrid = new DataList('#gvDatos', {
    onSearch: function () {
        BuscarDatos(datagrid.currentPage());
    }
});


function LimpiarForm () {
    $('#txtCodigo').val('');
    $('#txtApePaterno').val('');
    $('#txtApeMaterno').val('');
    $('#txtNombres').val('');
    $('#txtEmail').val('');
    $('#txtTelefono').val('');
    $('#ddlTurnoReg')[0].selectedIndex = 0;
    $('#txtNroDNI').val('').focus();

    Materialize.updateTextFields();
}

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';
    document.getElementById('hdFoto').value = 'no-set';

    precargaExp(selectorModal, true);

    resetFoto('new');
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    LimpiarForm();

    openModalCallBack(selectorModal, function () {
        if (idItem == '0'){


            ListarCargos('0');
            ListarAreasTrabajo('0');

            precargaExp(selectorModal, false);

            $('#txtCodigo').focus();
        }
        else {
            $.ajax({
                type: 'GET',
                url: 'services/personal/personal-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        //var foto = data[0].tm_foto;
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idpersonal);
                        $('#txtNroDNI').val(data[0].tm_nrodni);
                        $('#txtFacebook').val(data[0].tm_facebook);
                        $('#txtTelefono').val(data[0].tm_telefono);
                        $('#txtSueldo').val(data[0].tm_sueldo);                        
                        $('#txtApePaterno').val(data[0].tm_apellidopaterno);
                        $('#txtApeMaterno').val(data[0].tm_apellidomaterno);
                        $('#txtNombres').val(data[0].tm_nombres);
                        $('#txtEmail').val(data[0].tm_email);

                        
                        // $('#ddlCargoReg').changeMaterialSelect(data[0].tp_idcargo);
                        // $('#ddlAreaReg').changeMaterialSelect(data[0].tp_idarea);

                        ListarCargos(data[0].tm_idcargo);
                        ListarAreasTrabajo(data[0].tm_idarea);

                        $('#ddlTurnoReg').changeMaterialSelect(data[0].ta_turno);
                        
                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        hdFoto.value = foto_original;
                        $('#txtCodigo').val(data[0].tm_codigo).focus();

                        Materialize.updateTextFields();
                    };

                    precargaExp(selectorModal, false);
                }
            });
        };
    });
}

function BuscarDatos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: 'GET',
        url: 'services/personal/personal-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idpersonal;
                    var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion">' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</span>';
                    
                    strhtml += '<p><span class="docidentidad">DNI: ' + data[i].tm_nrodni + '</span> - Email: ' + data[i].tm_email + '</p>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';
                    ++i;
                };
                
                datagrid.currentPage(datagrid.currentPage() + 1);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                //$(selector + ' .grouped-buttons a.tooltipped').tooltip();
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#pnlListado', false);
        }
    });
}

function GuardarDatos () {
    var hdFoto = document.getElementById('hdFoto');
    var file = fileValue;
    var data = new FormData();

    precargaExp('#pnlForm', true);

    if (hdFoto.value == 'images/user-nosetimg-233.jpg'){
        hdFoto.value = 'no-set';
    };

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
        url: 'services/personal/personal-post.php',
        contentType:false,
        processData:false,
        cache: false,
        data: data,
        dataType: 'json',
        success: function(data){
            precargaExp('#pnlForm', false);

            createSnackbar(data.titulomsje);
                
            if (data.rpta != '0'){
                // removeValidFormRegister();
                closeCustomModal('#pnlForm');
                BuscarDatos('1');
            };
        }
    });
}

function EliminarPersonal () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemPersonal(elemsSelected[0], 'multiple');
}

function EliminarItemPersonal (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdPersonal', idmodel);

    $.ajax({
        url: 'services/personal/personal-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType:false,
        processData: false,
        success: function(data){
            var titulomsje = '';
            var itemSelected = $(item);
            var endqueue = false;

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
                    
                    if (indexList <= elemsSelected.length - 1)
                        EliminarItemPersonal(elemsSelected[indexList], mode);
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

                if (typeof endCallback !== 'undefined')
                    endCallback();
            };
        },
        error:function (data){
            console.log(data);
        }
    });
}

function Buscar () {
    BuscarDatos('1');
}

function showAll () {
    Buscar();
}

function ListarCargos (idcargo_default) {
    $.ajax({
        type: "GET",
        url: 'services/cargos/cargos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    var _selected = idcargo_default == data[i].tm_idcargo ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idcargo + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay cargos administrativos registrados.</option>';

            $('#ddlCargoReg').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarAreasTrabajo (idarea_default) {
    $.ajax({
        type: "GET",
        url: 'services/areas/areas-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val()
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    var _selected = idarea_default == data[i].tm_idarea ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idarea + '">' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay &aacute;reas de trabajo registradas.</option>';

            $('#ddlAreaReg').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
