$(function () {
    BuscarDatos('1');

	$('.datepicker').pickadate({
		format: 'dd/mm/yyyy',
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15, // Creates a dropdown of 15 years to control year,
	    today: 'Today',
	    clear: 'Clear',
	    close: 'Ok',
	    closeOnSelect: false // Close upon selecting a date,
	});

	$('#btnNuevo').on('click', function(event) {
		event.preventDefault();
		GoToEdit('0');
	});

	$('#btnGuardar').on('click', function(event) {
		event.preventDefault();
		Guardar();
	});

    $('#gvDatos').on('click touchend', '.dropdown a', function(event) {

        event.preventDefault();

        var accion = this.getAttribute('data-action');
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
                             eliminarDieta(parent[0], 'single');
                        }
                    }
                ],
                cancelButton: true
            });
        }
    });
});

var filaItem = 0;

function Guardar () {
	var data = new FormData();
    var input_data = $('#pnlForm :input').serializeArray();
    
    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdCliente', getParameterByName('idcliente'));

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: 'POST',
        url: 'services/dietacliente/dietacliente-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data,
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
            	closeCustomModal('#pnlForm');
                BuscarDatos('1');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function BuscarDatos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/dietacliente/dietacliente-search.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcliente: getParameterByName('idcliente'),
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_iddietasocio;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion"> CALORIAS : ' + data[i].tm_calorias + '</span> <br />';

                    strhtml += '<span class="correo">DURACI&Oacute;N: Desde ' + ConvertMySQLDate(data[i].tm_fechaInicial) + '</span> al ' + ConvertMySQLDate(data[i].tm_fechaFinal) + '</p>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';

                    ++i;
                };

                // datagrid.currentPage(datagrid.currentPage() + 1);

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

function EliminarDieta () {
    indexList = 0;
    elemsSelected = $('#gvDatos .selected');
    eliminarDieta(elemsSelected[0], 'multiple');
}

function eliminarDieta (item, mode) {
    var data = new FormData();
    var idmodel = item.getAttribute('data-idmodel');

    data.append('btnEliminar', 'btnEliminar');
    data.append('hdIdDietacliente', idmodel);

    $.ajax({
        url: 'services/dietacliente/dietacliente-post.php',
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
                        eliminarDieta(elemsSelected[indexList], mode);
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

function GoToEdit (idItem) {

    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';

    precargaExp(selectorModal, true);

    LimpiarForm();
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    openModalCallBack(selectorModal, function () {

        if (idItem == '0')
            precargaExp(selectorModal, false);
        else {
            $.ajax({
                type: "GET",
                url: 'services/dietacliente/dietacliente-getdetails.php',
                cache: false,
                dataType: 'json',
                data: 'id=' + idItem,
                success: function (data) {
                    if (data.length > 0){

                        $('#hdIdPrimary').val(data[0].tm_iddietasocio);
                        $('#txtGrasaCorporal').val(data[0].tm_calorias);
                        $('#ddlDieta').val(data[0].tm_iddieta);
                        $('#txtFechaInicio').val(ConvertMySQLDate(data[0].tm_fechaInicial));
                        $('#txtFechaFinal').val(ConvertMySQLDate(data[0].tm_fechaFinal));
                        $('#txtObservaciones').val(data[0].tm_documento);

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

function LimpiarForm(){
    $('#txtGrasaCorporal').val('0');
    $('#ddlDieta')[0].selectedIndex = 0;
    $('#txtFechaInicio').val(moment().format('DD/MM/YYYY'));
    $('#txtFechaFinal').val(moment().format('DD/MM/YYYY'));
    $('#txtObservaciones').val('');
}