$(function () {
	$('#AppMain').on('click', '.mdl-card', function(event) {
		event.preventDefault();

		$(this).siblings('.mdl-card').removeClass('selected');
		$(this).addClass('selected');
	});
});

function ListarCentros () {
	$.ajax({
        type: 'GET',
        url: 'services/centro/centro-empresa.php',
        cache: false,
        dataType: 'json',
        success: function(data){
        	var countdata = data.length;
        	var i = 0;

        	if (countdata > 0) {
        		while (i < countdata){
        			strhtml += '<div id="tile' + data[i].tm_idcentro + '" data-id="' + data[i].tm_idcentro + '" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion white-text" data-role="tile">';
                    strhtml += '<h5 class="tile-label place-bottom-left padding5 margin5">' + data[i].tm_nombre + '</h5>';
                    strhtml += '</div>';
        			++i;
        		};
        	};
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function SetCentro () {
	var data = new FormData();
	var idcentro = $('#AppMain .selected').attr('data-id');

    data.append('btnSetCentro', 'btnSetCentro');
    data.append('hdIdCentro', idcentro);

	$.ajax({
		url: 'services/centro/centro-post.php',
		type: 'POST',
		dataType: 'json',
		cache: false,
        contentType: false,
        processData: false,
		data: data,
		success: function (data) {
			
		},
        error: function (data) {
            console.log(data);
        }
	});
}