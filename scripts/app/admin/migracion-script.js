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
                            Eliminarmigracion();
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
                            EliminarItemmigracion(parent[0], 'single');
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
    $('#txtServicios').val(0);
    $('#txtSueldos').val(0);
    $('#txtOtros').val(0);
    $('#txtTotal').val(0);
    $('#txtIngresos').val(0);
    $('#txtMeta').val(0);
    $('#txtFaltante').val(0);
    $('#txtPorcentaje').val(0);
    $('#txtObservacion').val('');    

    Materialize.updateTextFields();
}

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';

    precargaExp(selectorModal, true);

    LimpiarForm();
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    openModalCallBack(selectorModal, function () {

        if (idItem == '0') {

            $('#ddlmes').focus();

            Listarmigracion_Combo('0');

            precargaExp(selectorModal, false);
            }
        else {
            $.ajax({
                type: "GET",
                url: 'services/migracion/migracion-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        // var foto_original = data[0].tm_foto;
                        // var foto_edicion = foto_original.replace("_o", "_s255");

                        $('#hdIdPrimary').val(data[0].tm_idmigracion);
                        $('#txtObservacion').val(data[0].tm_observacion);
                        
                        Listarmigracion_Combo(data[0].tm_idzonacorporal);

                        $('#ddlPeriodo').val(data[0].tm_idmigracion).focus();

                        Materialize.updateTextFields();
                    };
                    
                    precargaExp(selectorModal, false);
                },
                error: function (data) {
                    console.log(data);
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
        type: "GET",
        url: "services/migracion/migracion-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    
                    var idItem = data[i].tm_idmigracion;

                    // var foto = data[i].tm_foto.replace('_o', '_s42');

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + idItem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + idItem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    // if (foto == 'no-set')
                    //     strhtml += '<i class="material-icons circle">&#xE853;</i>';
                    // else
                    //     strhtml += '<img src="' + foto + '" alt="" class="circle">';

                    strhtml += '<span class="title Mes" > Mes: ' + data[i].periodo + ' Meta ' + data[i].tm_meta +' </span>';
                    
                    strhtml += '<p>Total Gastos: <span class="total">' + data[i].tm_total + '  servicios: <span class="servicios">'+ data[i].tm_servicios +'  Sueldos: <span class="sueldos">'+ data[i].tm_sueldos + '</span><br>';

                    strhtml += '<p>Otros gastos: <span class="otros">' + data[i].tm_otros + '  Utilidad: <span class="utilidad">'+ data[i].tm_porcentaje + '%</span><br>';

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
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function GuardarDatos () {
    // var hdFoto = document.getElementById('hdFoto');
    //var data = newFormData('#pnlForm');
    var data = new FormData();

    //if ($('#form1').valid()){
        precargaExp('#pnlForm', true);

        // if (hdFoto.value == 'images/user-nosetimg-233.jpg')
        //     hdFoto.value = 'no-set';

        data.append('btnGuardar', 'btnGuardar');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());
        // data.append('archivo', file);

        var input_data = $('#pnlForm :input').serializeArray();

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/migracion/migracion-post.php',
            contentType:false,
            processData:false,
            cache: false,
            data: data,
            dataType: 'json',
            success: function(data){
                precargaExp('#pnlForm', false);
                //showSnackbar({ message: data.titulomsje });
                createSnackbar(data.titulomsje);
                
                if (Number(data.rpta) > 0){
                    // removeValidFormRegister();
                    closeCustomModal('#pnlForm');
                    paginaGeneral = 1;
                    BuscarDatos('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    //};
}

function Eliminarmigracion () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemmigracion(elemsSelected[0], 'multiple');
}

function EliminarItemmigracion (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdmigracion', idmodel);

    $.ajax({
        url: 'services/migracion/migracion-post.php',
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
                        EliminarItemmigracion(elemsSelected[indexList], mode);
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
        error:function (data){
            console.log(data);
        }
    });
}


function Listarmigracion_Combo (idmigracion_default) {
    $.ajax({
        type: 'GET',
        url: 'services/migracion/migracion-search.php',
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
                    var _selected = idmigracion_default == data[i].tm_idmigracion ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idmigracion + '">' + data[i].periodo + '</option>';
                    ++i;
                };
            };

            $('#ddlPeriodo').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function Buscar () {
    BuscarDatos('1');
}