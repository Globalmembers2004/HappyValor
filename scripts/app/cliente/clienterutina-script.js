$(function () {
	PorZonas('1');

    $('#gvDatos').on('click', '.demo-card-square', function(event) {
        event.preventDefault();
        
        var iditem = this.getAttribute('data-idmodel');

        openModalCallBack ('#pnlDetalle', function () {
            DetalleZonas(iditem, '1');
        });
    });
});

function PorZonas (pagina) {
    var selectorgrid = '#gvDatos';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/rutinacliente/rutinacliente-zonas.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcliente: getParameterByName('idcliente'),
            tipobusqueda: 3,
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    //var imagen = data[i].tm_foto;
                    strhtml += '<div class="demo-card-square mdl-card dato articulo mdl-shadow--2dp mdl-cell mdl-cell--2-col mdl-cell--2-col-tablet mdl-cell--2-col-phone" data-idmodel="' + data[i].tm_idrutinasocio + '">';
                    strhtml += '<input name="chkItem[]" type="checkbox" class="hide" value="' + data[i].tm_idrutinasocio + '" />';

                    strhtml += '<div class="mdl-card__media pos-rel">';
                    strhtml += '<i class="icon-select centered material-icons white-text circle">done</i>';
                    
                    if (data[i].fotozona != 'no-set')
                        strhtml += '<img src="' + data[i].fotozona + '" width="100%" height="140px" border="0" alt="">';

                    strhtml += '</div>';

                    strhtml += '<div class="mdl-card__title">';

                    strhtml += '<h5 class="text-ellipsis" title="' + data[i].zonacorporal + '">' + data[i].zonacorporal + '</h5>';

                    strhtml += '</div>';
                    
                    strhtml += '</div>';

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

function DetalleZonas (idZona, pagina) {
    var selectorgrid = '#gvDetalle';
    var selector = selectorgrid + ' .gridview-content';

    precargaExp('#pnlListado', true);
    
    $.ajax({
        type: "GET",
        url: "services/rutinacliente/rutinacliente-detalle-zonas.php",
        cache: false,
        dataType: 'json',
        data: {
            criterio: $('#txtSearch').val(),
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcliente: getParameterByName('idcliente'),
            id: idZona, 
            tipobusqueda: 4,
            pagina: pagina
        },
        success: function(data){
            var countdata = data.length;
            var i = 0;
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    var iditem = data[i].tm_idrutinasocio;

                    strhtml += '<li class="collection-item avatar no-border dato" data-idmodel="' + iditem + '"  data-baselement="' + selectorgrid + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';

                    strhtml += '<i class="icon-select material-icons circle white-text">done</i><div class="layer-select"></div>';

                    strhtml += '<span class="title descripcion"> EQUIPO : ' + data[i].equipo + '</span>';
                    
                    strhtml += '<p> Series ' + data[i].td_serie + ' - Repeticiones: <span class=" repeticiom">' + data[i].td_repeticion + ' - Peso: <span class=" peso">' + data[i].td_peso + '</span><br>';

                    strhtml += '<div class="grouped-buttons place-top-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons md-18">&#xE5D4;</i></a>';

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