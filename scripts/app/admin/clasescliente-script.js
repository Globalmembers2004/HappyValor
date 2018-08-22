$(function () {
	ListarClasesDisponibles();
    ListarClasesSeparadas();

    $('#ddlClaseDisponible').on('change', function(event) {
        event.preventDefault();
        $('#hdIdRutina').val($(this).find('option[value="' + $(this).val() + '"]').attr('data-idrutina'));
    });
	
	$('#btnSepararClase').on('click', function(event) {
		event.preventDefault();
		SepararClase();
	});
});

function Limpiar () {
    $('#ddlClaseDisponible')[0].selectedIndex = 0;
    $('#hdIdRutina').val('0');
}

function ListarClasesSeparadas () {
    $.ajax({
        url: 'services/separacionrutina/separacionrutina-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            'tipobusqueda': '1',
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
                    var iditem = data[i].tm_idrutinagrupal;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion">' + data[i].rutina + ' (' + data[i].tm_hora_inicio + ' - ' + data[i].tm_hora_final + '</span>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown"><li><a href="#" data-action="edit" class="waves-effect">Editar</a></li><li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li></ul>';

                    strhtml += '</div>';

                    strhtml += '<div class="divider"></div>';
                    
                    strhtml += '</li>';

                    ++i;
                };
            }
            else
                strhtml = 'A&uacute;n no se ha separado ninguna clase';

            $('#gvClasesSeparadas').html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarClasesDisponibles () {
	$.ajax({
		url: 'services/horariogrupal/horariogrupal-search.php',
		type: 'GET',
		dataType: 'json',
		data: {
			'tipobusqueda': '6',
			'idempresa': $('#hdIdEmpresa').val(),
			'idcentro': $('#hdIdCentro').val()
		},
		success: function (data) {
			var i = 0;
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<option value="' + data[i].td_idhorariogrupal + '" data-idrutina="' + data[i].tm_idrutinagrupal + '">' + data[i].rutina + ' (' + data[i].tm_hora_inicio + ' - ' + data[i].tm_hora_final + ')</option>';
                    ++i;
                };

                $('#hdIdRutina').val(data[0].tm_idrutinagrupal);
            }
            else
                strhtml = '<option value="0">No hay clases disponibles</option>';

            $('#ddlClaseDisponible').html(strhtml);
		},
        error: function (error) {
            console.log(error);
        }
	});
}

function SepararClase () {
	var data = new FormData();

    data.append('btnSepararClase', 'btnSepararClase');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdCliente', getParameterByName('idcliente'));
    data.append('hdIdRutina', $('#hdIdRutina').val());
    data.append('ddlClaseDisponible', $('#ddlClaseDisponible').val());

    $.ajax({
        type: "POST",
        url: 'services/separacionrutina/separacionrutina-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                Limpiar();
                ListarClasesSeparadas();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}