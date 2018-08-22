$(function () {
	$('#btnDescartar').on('click', function(event) {
		event.preventDefault();
		Preliminar(3);
	});

	// $('#btnLater').on('click', function(event) {
	// 	event.preventDefault();
	// 	Preliminar(2);
	// });

	$('#btnImportar').on('click', function(event) {
		event.preventDefault();
		Preliminar(1);
	});
});


function Preliminar (pregunta) {
	var data = new FormData();

    data.append('btnImportarDataPreliminar', 'btnImportarDataPreliminar');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdPregunta', pregunta);

    $.ajax({
        type: "POST",
        url: 'services/usuarios/usuarios-post.php',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        dataType: 'json',
        success: function(data){
            window.location = 'index.php';
        },
        error: function (error) {
            console.log(error);
        }
    });
}