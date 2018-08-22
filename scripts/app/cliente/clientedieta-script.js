$(function () {
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
});

var filaItem = 0;

function GoToEdit (idItem) {
    var selectorModal = '#pnlForm';

    document.getElementById('hdIdPrimary').value = '0';

    // precargaExp(selectorModal, true);

    // resetFoto('new');
    // LimpiarForm();
    // resetForm(selectorModal);

    // removeValidFormRegister();
    // addValidFormRegister();

    openModalCallBack(selectorModal, function () {

    });
}

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