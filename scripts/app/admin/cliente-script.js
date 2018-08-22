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
    $('#txtCodigo').val('');focus();
    $('#txtTipo').val('');
    $('#txtDocIdentidad').val('');
    $('#txtRuc').val('');
    $('#txtDescripcion').val('');
    $('#txtTipoPersona').val('');
    $('#txtDireccion').val('');
    $('#txtTelefono').val('');
}

function removeValidFormRegister () {
    $('#txtCodigo').rules('remove');
    $('#txtTipo').rules('remove');
    $('#txtDocIdentidad').rules('remove');
    $('#txtRuc').rules('remove');
    $('#txtDescripcion').rules('remove');
    $('#txtTipoPersona').rules('remove');
    $('#txtDireccion').rules('remove');
    $('#txtTelefono').rules('remove');
}



function addValidFormRegister () {
    $('#txtCodigo').rules('add', {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Se requiere que ingrese código"),
            minlength: jQuery.validator.format("Por favor ingrese por lo menos 8 dígitos")
        }
    });

    $('#txtTipo').rules('add', {
        required: true,
        number: true,
        minlength: 1,
        maxlength: 1,
        messages:{
            required: jQuery.validator.format("Se requiere que ingrese tipo"),
            minlength: jQuery.validator.format("Por favor ingrese un tipo válido")
        }
    });

    $('#txtDocIdentidad').rules('add', {
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: jQuery.validator.format("Se requiere que ingrese documento"),
            minlength: jQuery.validator.format("Por favor ingrese por lo menos 8 dígitos")
        }
    });

    $('#txtRuc').rules('add', {
        number: true,
        minlength: 8,
        maxlength: 11,
        messages:{
            required: "",
            minlength: jQuery.validator.format("Por favor ingrese una cuenta válida, de por lo menos 8 caracteres")
        }
    });

    $('#txtDescripcion').rules('add', {
        required: true,
        minlength: 8,
        maxlength: 100,
        messages:{
            required: jQuery.validator.format("Se requiere que ingrese nombre del cliente"),
            minlength: jQuery.validator.format("Por favor ingrese un nombre válido")
        }
    });

    $('#txtTipoPersona').rules('add', {
        required: true,
        number: true,
        minlength: 2,
        maxlength: 2,
        messages:{
            required: jQuery.validator.format("Se requiere que ingrese tipo de persona"),
            minlength: jQuery.validator.format("Por favor ingrese tipo válido")
        }
    });

    $('#txtDireccion').rules('add', {
        minlength: 7,
        maxlength: 100,
        messages:{
            required: "",
            minlength: jQuery.validator.format("Por favor ingrese una dirección válida")
        }
    });

    $('#txtTelefono').rules('add', {
        number: true,
        minlength: 7,
        maxlength: 10,
        messages:{
            required: "",
            minlength: jQuery.validator.format("Por favor ingrese un número válido")
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
                url: 'services/cliente/cliente-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        $('#hdIdPrimary').val(data[0].tm_idcliente);
                        $('#txtCodigo').val(data[0].tm_codigo);
                        $('#txtTipo').val(data[0].tm_tipo);
                        $('#txtDocIdentidad').val(data[0].tm_doc_identidad);
                        $('#txtRuc').val(data[0].tm_ruc);
                        $('#txtDescripcion').val(data[0].tm_descripcion);
                        $('#txtTipoPersona').val(data[0].tm_tipo_persona);
                        $('#txtDireccion').val(data[0].tm_direccion);
                        $('#txtTelefono').val(data[0].tm_telefono);
                        
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
        url: "services/cliente/cliente-search.php",
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
                    var iditem = data[i].tm_idcliente;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion">' + data[i].tm_descripcion + '</span>';
                    
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
            url: 'services/cliente/cliente-post.php',
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
        url: 'services/cliente/cliente-post.php',
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