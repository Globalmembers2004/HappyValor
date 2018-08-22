docReady(function () {
	var firstAmbiente = slidesAmbientes[0];
	firstAmbiente.removeClass('inactive');
	MostrarMesas(firstAmbiente.getAttribute('data-idambiente'));

	var prevArrow = document.getElementsByClassName('slideshow-left-control')[0];
	var nextArrow = document.getElementsByClassName('slideshow-right-control')[0];

	prevArrow.addEventListener('click', CHESLIDESHOW.prevSlide);
	nextArrow.addEventListener('click', CHESLIDESHOW.nextSlide);
});

var slidesAmbientes = $('#sliderAmbientes').find('.che-slideshow-slide');

function MostrarMesas (idambiente) {
	var parentSelector = '*#sliderAmbientes .che-slideshow-slide[data-idambiente="' + idambiente + '"]';
    var selector = parentSelector + ' .gridview-container';
    
    precargaExp(parentSelector, true);
   
    $$.ajax({
        type: "GET",
        url: "services/atencion/atencion-search.php",
        cache: false,
        dataType: 'json',
        data: "tipobusqueda=ATENCION-AMBIENTE&idambiente=" + idambiente,
        success: function(data){
            // var selectedState = '';
            var i = 0;
            var strhtml = '';
            var countdata = data.length;
            // var csssize = '';
            // var tagheader = '';
            // var stylehide = 'block';

            
            //selectedState = $('#pnlEstadoMesa .dato.selected').attr('data-codigo');

            if (countdata > 0){
                while(i < countdata){
                    // if (data[i].ta_tipoubicacion == '01'){
                    //     csssize = ' double';
                    //     tagheader = 'h3';
                    // }
                    // else {
                    //     csssize = '';
                    //     tagheader = 'h1';
                    // };

                    strhtml = '<div class="dato mdl-cell mdl-cell--2-col mdl-cell--2-col-phone pos-rel mdl-card" ';
                    strhtml += 'data-idmesa="' + data[i].tm_idmesa + '" ';
                    strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                    strhtml += 'data-state="' + data[i].ta_estadoatencion + '" ';
                    strhtml += 'data-tipoubicacion="' + data[i].ta_tipoubicacion + '" ';
                    strhtml += 'style="background-color: ' + data[i].ta_colorleyenda + '; display: ' + stylehide + ';">';

                    strhtml += '<i class="icon-select centered material-icons white-text circle">done</i><div class="layer-select"></div>';

                    strhtml += '<h1 class="padding10 align-center white-text">' + data[i].tm_codigo + '</h1>';

                    strhtml += '</div>';
                    ++i;
                };
            }
            else {
                strhtml = '<h2>No se encontraron resultados.</h2>';
            };
            
            $(selector).innerHTML = strhtml;
            precargaExp(parentSelector, false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}