$(function () {
	ListarClasesSeparadas();
});

function ListarClasesSeparadas () {
	$.ajax({
		url: 'services/separacionrutina/separacionrutina-search.php',
		type: 'GET',
		dataType: 'json',
		data: {
            'tipobusqueda': '1',
            'idempresa': $('#hdIdEmpresa').val(),
            'idcentro': $('#hdIdCentro').val()
        },
        success: function (data) {
       		var i = 0;
            var strhtml = '';
            var countdata = data.length;
            var selectorgrid = "";

            if (countdata > 0){
                while(i < countdata){                	
                    strhtml += '<li class="collection-item avatar no-border dato">';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion">Clase: ' + data[i].rutina + ' (' + data[i].tm_hora_inicio + ' - ' + data[i].tm_hora_final + '</span>';

                        strhtml += '<span class="title descripcion">Cliente: ' + data[i].nombreCliente + '</span>';

                    strhtml += '</li>';
                	++i;
                };
            };

            $('#gvDatos').html(strhtml);
        },
        error: function (error) {
        	console.log(error);
        }
	});
}