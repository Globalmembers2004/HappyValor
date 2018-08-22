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
                            EliminarEnlace();
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
                            EliminarItemEnlaces(parent[0], 'single');
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

    $('#form1').validate({
        lang: 'es',
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement)
                $(placement).append(error);
            else
                error.insertAfter(element);
        }
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
    $('#txtLocal').val('');focus();
    $('#txtCuenta_12').val('');
    $('#txtCuenta_40').val('');
    $('#txtCuenta_Facturas').val('');
    $('#txtCuentaBoletas').val('');
    $('#txtCentroCosto').val('');
    $('#txtNombreLocal').val('');
    $('#txtSerie').val('');
    $('#txtCodigo').val('');
}

function removeValidFormRegister () {
    $('#txtLocal').rules('remove');
    $('#txtCuenta_12').rules('remove');
    $('#txtCuenta_40').rules('remove');
    $('#txtCuenta_Facturas').rules('remove');
    $('#txtCuentaBoletas').rules('remove');
    $('#txtCentroCosto').rules('remove');
    $('#txtNombreLocal').rules('remove');
    $('#txtSerie').rules('remove');
    $('#txtCodigo').rules('remove');
}

function addValidFormRegister () {
    $('#txtLocal').rules('add', {
        required: true,
        minlength: 5,
        maxlength: 100,
        messages:{
            required: jQuery.validator.format("Por favor ingrese un nombre de Local"),
            minlength: jQuery.validator.format("Por favor ingrese un nombre de Local válido")
        }
    });

    $('#txtCuenta_12').rules('add', {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Por favor ingrese una cuenta de clientes"),
            minlength: jQuery.validator.format("Por favor ingrese una cuenta válida, de por lo menos 8 caracteres")
        }
    });

    $('#txtCuenta_40').rules('add', {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Por favor ingrese una cuenta de tributos"),
            minlength: jQuery.validator.format("Por favor ingrese una cuenta válida, de por lo menos 8 caracteres")
        }
    });

    $('#txtCuenta_Facturas').rules('add', {
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: "",
            minlength: jQuery.validator.format("Por favor ingrese una cuenta válida, de por lo menos 8 caracteres")
        }
    });

    $('#txtCuentaBoletas').rules('add', {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Por favor ingrese una cuenta de boletas"),
            minlength: jQuery.validator.format("Por favor ingrese una cuenta válida, de por lo menos 8 caracteres")
        }
    });

    $('#txtCentroCosto').rules('add', {
        required: true,
        number: true,
        minlength: 6,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Por favor ingrese un centro de costo"),
            minlength: jQuery.validator.format("Por favor ingrese un centro de costo válido, de por lo menos 6 caracteres")
        }
    });

    $('#txtNombreLocal').rules('add', {
        required: true,
        minlength: 7,
        maxlength: 100,
        messages:{
            required: jQuery.validator.format("Por favor ingrese nombre de Local"),
            minlength: jQuery.validator.format("Por favor ingrese una descripción válida")
        }
    });

    $('#txtSerie').rules('add', {
        required: true,
        minlength: 3,
        maxlength: 3,
        messages:{
            required: jQuery.validator.format("Por favor ingrese serie de local"),
            minlength: jQuery.validator.format("Por favor ingrese una serie válida de 3 caracteres")
        }
    });

    $('#txtCodigo').rules('add', {
        required: true,
        number: true,
        minlength: 11,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Por favor ingrese un código de local"),
            minlength: jQuery.validator.format("Por favor ingrese una centro de costo de 11 caracteres")
        }
    });


}

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = 0;

    precargaExp(selectorModal, true);

    LimpiarForm();

    removeValidFormRegister();
    addValidFormRegister();

    openModalCallBack(selectorModal, function () {

        if (idItem == '0')
            precargaExp(selectorModal, false);
        else {
            $.ajax({
                type: "GET",
                url: 'services/enlaces/enlaces-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        $('#hdIdPrimary').val(data[0].tm_idenlace);
                        $('#txtLocal').val(data[0].tm_local);
                        $('#txtCuenta_12').val(data[0].tm_cuenta_12);
                        $('#txtCuenta_40').val(data[0].tm_cuenta_40);
                        $('#txtCuenta_Facturas').val(data[0].tm_cuenta_facturas);
                        $('#txtCuentaBoletas').val(data[0].tm_cuenta_boletas);
                        $('#txtCentroCosto').val(data[0].tm_centro_costo);
                        $('#txtNombreLocal').val(data[0].tm_nombre_local);
                        $('#txtSerie').val(data[0].tm_serie);
                        $('#txtCodigo').val(data[0].tm_codigo);
                        
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
        url: "services/enlaces/enlaces-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idenlace;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion">' + data[i].tm_nombre_local + '</span>';
                    
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
    // var file = fileValue;
    //var data = newFormData('#pnlForm');
    var data = new FormData();

    if ($('#form1').valid()){
        precargaExp('#pnlForm', true);

        data.append('btnGuardar', 'btnGuardar');
        // data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        // data.append('archivo', file);

        var input_data = $('#pnlForm :input').serializeArray();

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });

        $.ajax({
            type: "POST",
            url: 'services/enlaces/enlaces-post.php',
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
    };
}

function EliminarEnlace () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemEnlaces(elemsSelected[0], 'multiple');
}

function EliminarItemEnlaces (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdEnlace', idmodel);

    $.ajax({
        url: 'services/enlaces/enlaces-post.php',
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
                        EliminarItemEnlaces(elemsSelected[indexList], mode);
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

function Buscar () {
    BuscarDatos('1');
}