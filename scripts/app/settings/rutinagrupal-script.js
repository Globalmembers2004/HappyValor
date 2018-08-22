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
                            Eliminarrutinagrupal();
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });

    $('#gvDatos').on('click touchend', 'a', function(event) {
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
                            EliminarItemrutinagrupal(parent[0], 'single');
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
    fileValue = "";

    $('#hdIdPrimary').val('0');
    $('#hdFoto').val('no-set');
    $('#txtMinutos').val(0);
    $('#txtNombreRutina').val('').focus();
    Materialize.updateTextFields();
}

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    precargaExp(selectorModal, true);

    resetFoto('new');
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    LimpiarForm();

    openModalCallBack(selectorModal, function () {
        if (idItem == '0'){

           precargaExp(selectorModal, false);

            $('#txtNombreRutina').focus();
        }
        else {
            $.ajax({
                type: 'GET',
                url: 'services/rutinagrupal/rutinagrupal-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        //var foto = data[0].tm_foto;
                        var foto_original = data[0].tm_foto;
                        var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idrutinagrupal);
                        $('#txtMinutos').val(data[0].tm_minutos_sep);

                        
                        // $('#ddlCargoReg').changeMaterialSelect(data[0].tp_idcargo);
                        // $('#ddlAreaReg').changeMaterialSelect(data[0].tp_idarea);

                        if (foto_original != 'no-set')
                            setFoto(foto_edicion);
                        else
                            foto_edicion = 'images/user-nosetimg-233.jpg';

                        imgFoto.setAttribute('data-src', foto_edicion);
                        $('#hdFoto').val(foto_original);

                        $('#txtNombreRutina').val(data[0].tm_nombre).focus();

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
        url: 'services/rutinagrupal/rutinagrupal-search.php',
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
                    var iditem = data[i].tm_idrutinagrupal;
                    var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    if (foto == 'no-set')
                        strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    else
                        strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title descripcion"> Nombre de Rutina: ' + data[i].tm_nombre + ' Minutos para separación: '+ data[i].tm_minutos_sep + '</span>';

                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5">';

                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="edit" data-delay="50" data-position="bottom" data-tooltip="Editar"><i class="material-icons">&#xE254;</i></a><a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="delete" data-delay="50" data-position="bottom" data-tooltip="Eliminar"><i class="material-icons">&#xE872;</i></a></div>';

                    
                    // strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    // strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    // strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    // strhtml += '</div>';

                    // strhtml += '<div class="divider"></div>';
                    
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
    var file = fileValue;
    var data = new FormData();

    precargaExp('#pnlForm', true);

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdFoto', $('#hdFoto').val());
    data.append('archivo', file);

    var input_data = $('#pnlForm :input').serializeArray();

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/rutinagrupal/rutinagrupal-post.php',
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

function Eliminarrutinagrupal () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemrutinagrupal(elemsSelected[0], 'multiple');
}

function EliminarItemrutinagrupal (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdrutinagrupal', idmodel);

    $.ajax({
        url: 'services/rutinagrupal/rutinagrupal-post.php',
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
                        EliminarItemrutinagrupal(elemsSelected[indexList], mode);
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
