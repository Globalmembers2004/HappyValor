$(function () {

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


function LimpiarForm () {
    $('#txtPeriodo').val("");
    $('#txtInicio').val("");
}


function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = 0;

    precargaExp(selectorModal, true);

    LimpiarForm();


    openModalCallBack(selectorModal, function () {

        if (idItem == '0'){
            {
            ListarPeriodo_Combo1('0');

            $('#ddlPeriodo1').focus();

            ListarPeriodo_Combo2('0');

            $('#ddlPeriodo2').focus();


            precargaExp(selectorModal, false);
            }

        }
        else {
            $.ajax({
                type: "GET",
                url: 'services/informes/informes-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
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

function GuardarDatos () {
    // var file = fileValue;
    var data = new FormData($('#form1')[0]);
    //var data = new FormData();

    if ($('#form1').valid()){
        precargaExp('#pnlForm', true);

        data.append('btnGuardar', 'btnGuardar')

        $.ajax({
            type: "POST",
            url: 'services/informes/informes-post.php',
            contentType:false,
            processData:false,
            cache: false,
            data: data,
            dataType: 'json',
            success: function(data){
            	console.log(data);
                precargaExp('#pnlForm', false);
                //showSnackbar({ message: data.titulomsje });
                createSnackbar(data.contenidomsje);
                
                if (Number(data.rpta) > 0){
                    // removeValidFormRegister();
                    closeCustomModal('#pnlForm');
                    paginaGeneral = 1;
                    //BuscarDatos('1');
                };
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}


function ListarPeriodo_Combo1 (idperiodo_default) {
    $.ajax({
        type: 'GET',
        url: 'services/periodo/periodo-search.php',
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
                    var _selected = idperiodo_default == data[i].tm_idperiodo ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idperiodo + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlPeriodo1').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarPeriodo_Combo2 (idperiodo_default) {
    $.ajax({
        type: 'GET',
        url: 'services/periodo/periodo-search.php',
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
                    var _selected = idperiodo_default == data[i].tm_idperiodo ? ' selected' : '';
                    strhtml += '<option' + _selected + ' value="' + data[i].tm_idperiodo + '">' + data[i].tm_descripcion + '</option>';
                    ++i;
                };
            };

            $('#ddlPeriodo2').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
