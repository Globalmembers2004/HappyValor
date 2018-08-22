$(function () {
	ListarServicioCliente();

	$('#btnNuevo').on('click', function(event) {
		event.preventDefault();
		
	});

	$('#btnRegistrarAsistencia').on('click', function(event) {
		event.preventDefault();
		Guardar();
	});

	$('#btnViewList').on('click', function(event) {
		event.preventDefault();
		$('#pnlForm').fadeOut(400, function() {
			$('#pnlListado').fadeIn(400, function() {
			});
		});
	});

	$('#btnBack').on('click', function(event) {
		event.preventDefault();
		$('#pnlListado').fadeOut(400, function() {
			$('#pnlForm').fadeIn(400, function() {
			});
		});
	});
});

function ListarServicioCliente () {
	$.ajax({
		url: 'services/serviciocliente/serviciocliente-search.php',
		type: 'GET',
		dataType: 'json',
		data: {
			'tipo': '3',
			'idempresa': $('#hdIdEmpresa').val(),
			'idcentro': $('#hdIdCentro').val(),
			'idcliente': getParameterByName('idcliente')
		},
		success: function (data) {
			var i = 0;
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<option value="' + data[i].tm_idservicio + '">' + data[i].NombreServicio + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0">No hay servicios relacionados</option>';

            $('#ddlServicio').html(strhtml);
		},
        error: function (error) {
            console.log(error);
        }
	});
}

function Limpiar () {
	$('#ddlServicio')[0].selectedIndex = 0;
}

function Guardar () {
	var data = new FormData();

    data.append('btnGuardar', 'btnGuardar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdCliente', getParameterByName('idcliente'));
    data.append('ddlServicio', $('#ddlServicio').val());

    $.ajax({
        type: "POST",
        url: 'services/asistenciacliente/asistenciacliente-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                Limpiar();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}