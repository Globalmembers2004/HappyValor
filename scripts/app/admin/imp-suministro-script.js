$(function () {

    $('#btnNuevo').on('click', function (event) {
        event.preventDefault();
        GoToEdit('0');
    });

    $('#btnGuardar').on('click', function (event) {
        event.preventDefault();
        GuardarDatos();
    });

    $('#ddlTabla').on('change', function (event) {
        event.preventDefault();
        var val = $(this).val();
        if(val == "tmp_productos")
        	$(".cmb_periodo").addClass('hide');
        if(val == "tmp_familia")
        	$(".cmb_periodo").addClass('hide');
        if(val == "0")
        	$(".cmb_periodo").addClass('hide');
        if(val == "tmp_centrocosto")
        	$(".cmb_periodo").addClass('hide');

        if(val == "tmp_costo_producto")
        	$(".cmb_periodo").removeClass('hide');
        if(val == "tmp_inventario")
        	$(".cmb_periodo").removeClass('hide');
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
            ListarPeriodo_Combo('0');

            $('#ddlPeriodo').focus();

            precargaExp(selectorModal, false);
            }

        }
        else {
            $.ajax({
                type: "GET",
                url: 'services/suministro/suministro-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){
                    	/*
                        $('#hdIdPrimary').val(data[0].tm_idinventario);
                                             
                        
                        $('#ddlCenCos').val(data[0].tm_idcencosto);
                        $('#ddlProducto').val(data[0].tm_idproducto);

                        $('#txtCantidadAnt').val(data[0].tm_cant_ante);
                        $('#txtCantidadEnvi').val(data[0].tm_cant_envi);
                        $('#txtCantidadDevu').val(data[0].tm_cant_devu);
                        $('#txtCantidadInv').val(data[0].tm_cant_inve);
                        $('#txtCantidadCons').val(data[0].tm_cant_cons);
                      */

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

            // {
            // ListarTipoFamilia_Combo('0');

            // $('#ddlTipoFamilia').focus();

            // precargaExp(selectorModal, false);
            // }

        ;
        // data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        // data.append('archivo', file);

        /*
        var input_data = $('#pnlForm :input').serializeArray();

        Array.prototype.forEach.call(input_data, function(fields){
            data.append(fields.name, fields.value);
        });
        */

        $.ajax({
            type: "POST",
            url: 'services/suministro/suministro-post.php',
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


function ListarPeriodo_Combo (idperiodo_default) {
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

            $('#ddlPeriodo').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}
