$(function () {
	settingCalendar();
	gridEvents('#gvPacks', '.dato');
	gridEvents('#gvDatos', '.dato');
	listdataEvents_default();

	$('#pnlAsignacion .mdl-layout__content').on('scroll', function(){
        var paginaActual = 0;
        isScroll = true;

        clearTimeout(timeoutScroll);
        timeoutScroll = setTimeout(function(){
            isScroll = false;
        }, delayScroll);

        if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
			if ($('#tabPack').is(':visible')){
                paginaActual = Number($('#hdPageGrupo').val());
                ListarPacks('55', paginaActual);
            }
            else {
                paginaActual = Number($('#hdPageArticulo').val());
                ListarArticulos(paginaActual);
            };
        };
    });

	$('#btnActionMenu').on('click', 'li a', function(event) {
		event.preventDefault();
		
		var accion = this.getAttribute('data-action');

		if (accion == 'search-articles') {
			$('#pnlMenu').fadeOut(400, function () {
				$('#pnlAsignacion').fadeIn(400, function() {
					$('#btnGoToPacks').addClass('show-in-select').removeClass('oculto');
			        $('#btnAsignarProductos, #btnSearchPacks').addClass('oculto');
			        if ($('#gvDatos .dato').length == 0){
			            paginaArticulo = 1;
			            ListarArticulos('1');
			        };
				});
			});
		};
	});

	$('#articulos-actionbar').on('click', 'button', function(event) {
        event.preventDefault();
        
        var selector = '';
        var accion = this.getAttribute('data-action');

        if (accion == 'add-list') {
            $('#articulos-actionbar .show-in-select').addClass('oculto');
            $('#btnAsignarProductos, #btnSearchPacks').removeClass('oculto');
            $('#gvPacks').addClass('custom');
            gridEvents('#gvPacks', '.dato');
            customEventsBar_Packs();

            $('#tabArticulo').fadeOut(400, function() {
                $('#tabPack').fadeIn(400, function() {
                    paginaGrupo = 1;
                    ListarPacks('55', '1');
                });
            });
        };
    });

    $('#btnAsignarProductos').on('click', function(event) {
    	event.preventDefault();
    	AsignarMenu();
    });
});

var paginaCarta = 1;
var paginaGrupo = 1;
var paginaArticulo = 1;
var fechaTexto = '';

function settingCalendar () {
	var selector = '#pnlCalendarioIndividual';
	
	$(selector).responsiveCalendar({
        time: getOnlyYearMonth(),
        onDayClick: function(events) {
            var fecha = '';
            var estado = '';

            var anho = $(this).data('year');
            var mes = $(this).data('month');
            var dia = $(this).data('day');
            var monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            
            fecha = anho + '-' + addLeadingZero(mes) + '-' + addLeadingZero(dia);
            fechaTexto = addLeadingZero(dia) +  ' de ' + monthNames[mes] + ' del año ' + anho;

            var currentDay = $(selector + ' .day:not(.not-current) a[data-day="' + dia + '"][data-month="' + mes + '"][data-year="' + anho + '"]').parent();

            estado = $(currentDay).attr('data-estado');


            $('#hdEstadoApertura').val(estado);
            $('#hdFecha').val(fecha);

            $('#gvMenu').attr({'data-fecha': fecha, 'data-estado': estado});

            paginaGrupo = 1;
            ListarPacks('56', '1');
        },
        onInit: function () {
            setTimeout(function () {
                var anho = $('#hdCurrentYear').val();
                var mes = $('#hdCurrentMonth').val();
            	
            	$(selector + ' .day.today a').trigger('click');
                
                ListarDiasAsignados(anho, mes, '01');
            }, 1000);
        },
        onMonthChange: function () {
            setTimeout(function () {
                var firstDay = $(selector + ' .responsive-calendar .days .day:not(.not-current)').first().children('a');
                var anho = firstDay.attr('data-year');
                var mes = firstDay.attr('data-month');

                firstDay.trigger('click');

                ListarDiasAsignados(anho, mes, '01');
            }, 1000);
        }
    });
}

function ListarDiasAsignados (anho, mes, tipomenudia) {
    var tipobusqueda = '';
    
    if (tipomenudia == '03')
        tipobusqueda = 'DIAS-GRUPAL';
    else
        tipobusqueda = 'DIAS-INDIVIDUAL';
    
    $.ajax({
        url: 'services/cartadia/cartadia-dias.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            anho: anho,
            mes: mes,
            tipomenudia: tipomenudia
        },
        success: function  (data) {
            var open = '';
            var count = data.length;
            var i = 0;
            var idcalendar = '#pnlCalendarioIndividual';

            if (count > 0) {
                while (i < count){
                    open = (data[i].estado == '01' ? ' open' : '');
                    
                    $(idcalendar + ' .day:not(.not-current) a[data-day="' + data[i].dia + '"][data-month="' + data[i].mes + '"][data-year="' + data[i].anho + '"]').parent().addClass('active' + open).attr('data-estado', data[i].estado);
                    
                    ++i;
                };
            };
        }
    });
}

function ListarPacks (tipobusqueda, pagina) {
    var selectorgrid = '';
    var selector = '';
    var criterio = $('#txtSearch').val();

    selectorgrid = tipobusqueda == '56' ? '#gvPacksMenu' : '#gvPacks';
    selector = selectorgrid + ' .gridview';

    precargaExp('#pnlMenu', true);

    $.ajax({
        type: 'GET',
        url: 'services/grupos/grupos-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: criterio,
            fechaini: $('#hdFecha').val(),
            pagina: pagina
        },
        success: function(result){
            var i = 0;
            var j = 0;
            var countdata = 0;
            var strhtml = '';
            var preselect_class = '';
            var iditem = '0';
            var secciones;
            var count_secciones = 0;
            var empty_data = '';

            var groups = _.groupBy(result, function(value){
                return value.tm_idgrupoarticulo + '#' + value.tm_nombre;
            });
            var data = _.map(groups, function(group){
                return {
                    tm_idgrupoarticulo: group[0].tm_idgrupoarticulo,
                    tm_nombre: group[0].tm_nombre,
                    tm_idmoneda: group[0].tm_idmoneda,
                    tm_simbolo: group[0].tm_simbolo,
                    td_precio: group[0].td_precio,
                    list_secciones: group
                }
            });

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    j = 0;
                    iditem = data[i].tm_idgrupoarticulo;
                    secciones = data[i].list_secciones;

                    if (secciones.length == 1){
                        if (secciones[0].td_nombreseccion.trim().length == 0){
                            count_secciones = 0;
                        };
                    }
                    else {
                        count_secciones = secciones.length;
                    };

                    preselect_class = count_secciones > 0 ? 'select-in-details' : 'select-in-item';

                    strhtml += '<div data-idmodel="' + iditem + '" data-idMoneda="' + data[i].tm_idmoneda + '" class="dato card mdl-cell mdl-cell--2-col mdl-shadow--2dp left ' + preselect_class + '" data-baselement="' + selectorgrid + '">';
                    strhtml += '<input type="checkbox" style="display:none;" name="chkItem[]" value="' + iditem + '">';
                    strhtml += '<i class="icon-select place-top-right margin10 material-icons circle white-text">done</i><div class="layer-select"></div>';
                    strhtml += '<div class="card-content">';
                    strhtml += '<span class="card-title descripcion">' + data[i].tm_nombre + '</span>';
                    
                    if (count_secciones > 0){
                        strhtml += '<ul>';
                        while (j < count_secciones){
                            strhtml +=  '<li>' + secciones[j].td_nombreseccion + '</li>';
                            ++j;
                        };
                        strhtml += '</ul>';
                    };

                    strhtml += '</div>';
                    strhtml += '<div class="card-action">';
                    strhtml += '<h4 class="black-text no-margin"><span class="moneda">' + data[i].tm_simbolo + ' </span><span class="precio">' + Number(data[i].td_precio).toFixed(2) + '</span></h4>';
                    strhtml += '</div>';

                    
                    strhtml += '<div class="grouped-buttons place-bottom-right padding5 margin5">';
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';
                    strhtml += '<ul class="dropdown">';
                    strhtml += '<li><a href="#" data-action="edit" class="waves-effect">Editar</a></li>';
                    strhtml += '<li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li>';
                    strhtml += '<li><a href="#" data-action="stats" class="waves-effect">Ir a estad&iacute;sticas</a></li>';
                    strhtml += '</ul>';
                    strhtml += '</div>';

                    strhtml += '</div>';
                    ++i;
                };
                
                paginaGrupo = paginaGrupo + 1;

                $('#hdPageGrupo').val(paginaGrupo);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#emptyInProgram').addClass('hide');
                $(selector + ' .grouped-buttons a.tooltipped').tooltip();

                initMasonry(selector, '.mdl-cell--2-col', '.dato');
            }
            else {
                if (pagina == '1'){
                    $('#emptyInProgram').removeClass('hide');
                };
            };
            
            precargaExp('#pnlMenu', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function customEventsBar_Packs () {
    $('#gvPacks').on('click', '.dato.select-in-item', function(event) {
        event.preventDefault();
        $(this).toggleClass('selected');
    });

    $('#gvPacks').on('click', '.dato.select-in-details li', function(event) {
        event.preventDefault();
        var parent = $(this).parent().parent().parent();
        $(this).siblings().removeClass('subitem-selected');
        $(this).toggleClass('subitem-selected');
        if ($(this).hasClass('subitem-selected')){
            parent.addClass('selected');
        }
        else {
            parent.removeClass('selected');
        };
    });
}

function ListarArticulos (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview';
    var criterio = $('#txtSearch').val();

    precargaExp('#pnlAsignacion', true);

    $.ajax({
        url: 'services/productos/productos-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda:'00',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcategoria: 0,
            criterio: criterio,
            pagina: pagina
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var imagen = '';
            var cssbgtile = '';
            var cssdisplay = '';
            
            countdata = data.length;

            if (countdata > 0) {
                while(i < countdata){
                    imagen = data[i].tm_foto == 'no-set' ? imageDefault : data[i].tm_foto;

                    strhtml += '<div class="mdl-card dato articulo mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--4-col-tablet mdl-cell--12-col-phone" data-idmodel="' + data[i].tm_idproducto + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idproducto + '" />';

                    strhtml += '<div class="mdl-card__media pos-rel">';
                    strhtml += '<i class="icon-select centered material-icons white-text circle">done</i>';
                    strhtml += '<img src="' + imagen + '" width="100%" height="160px" border="0" alt="">';
                    strhtml += '</div>';

                    strhtml += '<div class="layer-select"></div>';

                    strhtml += '<div class="mdl-card__title full-size"><h5 class="fg-dark no-margin">' + data[i].tm_nombre + '</h5></div>';
                    
                    strhtml += '</div>';

                    ++i;
                };

                paginaArticulo = paginaArticulo + 1;

                $('#hdPageArticulo').val(paginaArticulo);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $(selector + ' .grouped-buttons a.tooltipped').tooltip();
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                };
            };

            precargaExp('#pnlAsignacion', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}