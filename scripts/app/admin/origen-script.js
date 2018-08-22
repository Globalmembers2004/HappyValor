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
                            EliminarOrigen();
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
                            EliminarItemOrigen(parent[0], 'single');
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
    $('#txtTipoDoc').val('');focus();
    $('#txtFolio').val('');
    $('#txtRucreceptor').val('');
    $('#txtRazonSocial').val('');
    $('#txtFechaEmision').val('');
    $('#txtMoneda').val('');
    $('#txtLocal').val('');
    $('#txtIgv').val('');
    $('#txtGravadas').val('');
    $('#txtTotal').val('');
    $('#txtReferencia').val('');

}

function removeValidFormRegister () {
    $('#txtTipoDoc').rules('remove');
    $('#txtFolio').rules('remove');
    $('#txtRucreceptor').rules('remove');
    $('#txtRazonSocial').rules('remove');
    $('#txtFechaEmision').rules('remove');
    $('#txtMoneda').rules('remove');
    $('#txtLocal').rules('remove');
    $('#txtIgv').rules('remove');
    $('#txtGravadas').rules('remove');
    $('#txtTotal').rules('remove');
    $('#txtReferencia').rules('remove');
}



function addValidFormRegister () {
    $('#txtTipoDoc').rules('add', {
        required: true,
        minlength: 2,
        maxlength: 2,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese tipo de documento"),
            minlength: jQuery.validator.format("Por favor ingrese Tipo de documento válido")
        }
    });

    $('#txtFolio').rules('add', {
        required: true,
        minlength: 13,
        maxlength: 13,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese folio"),
            minlength: jQuery.validator.format("Por favor ingrese un folio válido")
        }
    });

    $('#txtRucreceptor').rules('add', {
        minlength: 8,
        maxlength: 11,
        messages:{
            required: "",
            minlength: jQuery.validator.format("Por favor ingrese un documento válido, por lo menos 8 números")
        }
    });

    $('#txtRazonSocial').rules('add', {
        required: true,
        minlength: 8,
        maxlength: 100,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese razón social"),
            minlength: jQuery.validator.format("Por favor ingrese una razón social válida")
        }
    });

    $('#txtFechaEmision').rules('add', {
        required: true,
        minlength: 10,
        maxlength: 10,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese fecha"),
            minlength: jQuery.validator.format("Por favor ingrese una fecha válida con el siguiente formato (YYYY-MM-DD)")
        }
    });

    $('#txtMoneda').rules('add', {
        required: true,
        minlength: 3,
        maxlength: 3,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese moneda"),
            minlength: jQuery.validator.format("Por favor ingrese una moneda válida")
        }
    });

    $('#txtLocal').rules('add', {
        required: true,
        minlength: 3,
        maxlength: 3,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese local"),
            minlength: jQuery.validator.format("Por favor ingrese una serie válida")
        }
    });

    $('#txtIgv').rules('add', {
        required: true,
        number: true,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese IGV"),
            minlength: jQuery.validator.format("Por favor ingrese un IGV válido")
        }        
    });

    $('#txtGravadas').rules('add', {
        required: true,
        number: true,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese Importe gravado"),
            minlength: jQuery.validator.format("Por favor ingrese un Importe gravado válido")
        }        
    });
    $('#txtTotal').rules('add', {
        required: true,
        number: true,
        messages:{
            required: jQuery.validator.format("Es necesario que ingrese Importe total"),
            minlength: jQuery.validator.format("Por favor ingrese un Importe total válido")
        }        
    });

    $('#txtReferencia').rules('add', {
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
                url: 'services/origen/origen-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                        $('#hdIdPrimary').val(data[0].tm_idorigen);
                        $('#txtTipoDoc').val(data[0].tipodoc);
                        $('#txtFolio').val(data[0].folio);
                        $('#txtRucreceptor').val(data[0].rucreceptor);
                        $('#txtRazonSocial').val(data[0].razonsocialreceptor);
                        $('#txtFechaEmision').val(data[0].fechaemision);
                        $('#txtMoneda').val(data[0].moneda);
                        $('#txtLocal').val(data[0].local);
                        $('#txtIgv').val(data[0].igv);
                        $('#txtGravadas').val(data[0].operacionesgravadas);
                        $('#txtTotal').val(data[0].montototal);
                        $('#txtReferencia').val(data[0].referencia);
                        
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
        url: "services/origen/origen-search.php",
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
                    var iditem = data[i].tm_idorigen;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title folio"> Folio: ' + data[i].folio + '  -  Nombre Cliente: ' + data[i].razonsocialreceptor+ '  -  Referencia: ' + data[i].referencia+ '</span>';
                    
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
            url: 'services/origen/origen-post.php',
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

function EliminarOrigen () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    EliminarItemOrigen(elemsSelected[0], 'multiple');
}

function EliminarItemOrigen (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdOrigen', idmodel);

    $.ajax({
        url: 'services/origen/origen-post.php',
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
                        EliminarItemOrigen(elemsSelected[indexList], mode);
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