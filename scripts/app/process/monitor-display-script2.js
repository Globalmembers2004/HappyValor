var videoArray = ['at3FPJaAwoY', 'IxxstCcJlsc', 'dGghkjpNCQ8', 'RVmG_d3HKBA', 'NF-kLy44Hls', 'Qc9c12q3mrc', 'RcZn2-bGXqQ', 'CevxZvSJLk8', '5dbEhBKGOtY'];
var index = 0;
var player;

$(function() {
    // ListarMesas ('03');
    // ListarMesas ('04');

    ListarAmbientes();

    $('#btnAmbientes').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#modalAmbientes');
    });

    $('#gvAmbientes').on('click', '.dato', function(event) {
        event.preventDefault();

        $('.close-modal-example').trigger('click');

        var idambiente = this.getAttribute('data-idambiente');
        
        $(this).siblings('.dato').removeClass('oneSelected');
        $(this).addClass('oneSelected');

        ListarOrdenes(idambiente, '#pnlCocina', '03');
        ListarOrdenes(idambiente, '#pnlEspera', '04');
    });

    // atencion_Notif('03');
    // atencion_Notif('04');

});

// function ListarMesas (estadoatencion) {
//     var parentSelector = '#pnlMonitor';
//     var selector = (estadoatencion == '03' ? '#pnlCocina' : '#pnlEspera');

//     precargaExp(parentSelector, true);

//     $.ajax({
//         url: 'services/ambientes/mesas-search.php',
//         type: 'GET',
//         dataType: 'json',
//         data: {
//             tipobusqueda: 'GROUP-MESAS',
//             tipo: '2',
//             estadoatencion: estadoatencion
//         },
//         success: function (result) {
//             var strhtml = '';
//             var i = 0;

//             var groups = _.groupBy(result, function(value){
//                 return value.idgrupomesa + '#' + value.ta_tipomesa + '#' + value.codigo_group + '#' + value.comensales_group + '#' + value.estadoatencion_group + '#' + value.color_leyenda_group;
//             });
            
//             var data = _.map(groups, function(group){
//                 return {
//                     idgrupomesa: group[0].idgrupomesa,
//                     ta_tipomesa: group[0].ta_tipomesa,
//                     codigo_group: group[0].codigo_group,
//                     comensales_group: group[0].comensales_group,
//                     estadoatencion_group: group[0].estadoatencion_group,
//                     color_leyenda_group: group[0].color_leyenda_group,
//                     list_mesas: group
//                 };
//             });

//             var countdata = data.length;

//             if (countdata > 0){
//                 while(i < countdata){
//                     strhtml += '<div class="demo-card-monitor dato mdl-cell mdl-cell--12-col mdl-cell--12-col-phone pos-rel mdl-card" ';
//                     strhtml += 'data-idmesa="' + data[i].idgrupomesa + '" ';
//                     strhtml += 'data-tipomesa="' + data[i].ta_tipomesa + '" ';
//                     strhtml += 'data-state="' + data[i].estadoatencion_group + '" ';
//                     strhtml += 'style="background-color: ' + data[i].color_leyenda_group + ';">';

//                     strhtml += '<input type="checkbox" name="chkMesa[]" value="' + data[i].idgrupomesa + '" />'
//                     strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';
//                     strhtml += '<div style="width: 64px; height:48px;" class="centered"><h1 class="text-center white-text">' + data[i].codigo_group + '</h1></div>';
//                     strhtml += '</div>';

//                     ++i;
//                 };
//             };
//             // else
//             //     strhtml = '<h2>No se encontraron resultados.</h2>';
            
//             $(selector).html(strhtml);
//             precargaExp(parentSelector, false);            
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }

function atencion_Notif (estadoatencion) {
    var comet = new Comet(
        'services/atencion/despacho-update.php', {'idempresa': $('#hdIdEmpresa').val(), 'idcentro': $('#hdIdCentro').val(), 'estadoatencion': estadoatencion}, function (data) {
        agregar_Notificiacion(estadoatencion, data);
    });
    comet.connect();
}

function crearItemArticulo (iddetalleorden, idarticulo, nombreProducto, cantidad, precio, subtotal, observacion) {
    var strhtml = '';
    var _subtotal = Number(subtotal).toFixed(2);

    strhtml += '<li>';
    strhtml += '<div class="mdl-grid">';
    strhtml += '<div class="mdl-cell mdl-cell--7-col">' + nombreProducto + ' (' + cantidad + ')';
    strhtml += '</div>';
    strhtml += '<div class="mdl-cell mdl-cell--5-col align-right">S/. ' + _subtotal + '</div>';
    strhtml += '</div>';
    strhtml += '</li>';

    return strhtml;
}

function crearItems_Articulos (articulos) {
    var j = 0;
    var count_articulos = 0;
    var strhtml = '';
    var total_orden = 0;

    if (articulos.length == 1){
        if (articulos[0].nombreProducto.trim().length == 0)
            count_articulos = 0;
        else
            count_articulos = 1;
    }
    else
        count_articulos = articulos.length;

    if (count_articulos > 0){
        while (j < count_articulos){
            if (typeof articulos[j] !== 'undefined') {
                var subtotal = Number(articulos[j].td_subtotal);

                strhtml += crearItemArticulo (articulos[j].td_idatencion_articulo, articulos[j].tm_idproducto, articulos[j].nombreProducto, Number(articulos[j].td_cantidad).toFixed(0), Number(articulos[j].td_precio).toFixed(2), articulos[j].td_subtotal, articulos[j].td_observacion);
                total_orden += subtotal;
            };
            ++j;
        };
    };

    return {
        strhtml_articulos: strhtml,
        total_orden: total_orden
    };
}

function crearItemOrden (id_orden, nro_orden, nombre_personal, articulos) {
    var strhtml = '';
    strhtml = '<div data-idorden="' + id_orden + '" class="demo-card-order dato mdl-card mdl-cell mdl-cell--12-col mdl-shadow--2dp">';

    strhtml += '<input name="chkItem[]" type="checkbox" class="hide" value="' + id_orden + '" />';

    strhtml += '<div class="mdl-card__title mdl-card--expand mdl-card--border">';
    strhtml += '<h5>';
    strhtml += '<span class="padding-right10 padding-left10 place-left"><strong>ORDEN</strong>: ' + nro_orden + '</span>';
    strhtml += '<span class="padding-right10 padding-left10 place-right"><strong>MOZO</strong>: ' + nombre_personal + '</span>';
    strhtml += '</h5>';
    strhtml += '</div>';
    strhtml += '<div class="mdl-card__supporting-text full-size scrollbarra">';
    strhtml += '<ul class="details-in-card no-margin">';

    var total_orden = 0;

    if (typeof articulos !== 'undefined'){
        var get_articles = crearItems_Articulos(articulos);
        
        strhtml += get_articles.strhtml_articulos;
        total_orden = get_articles.total_orden;
    };

    strhtml += '</ul>';
    strhtml += '</div>';
    strhtml += '<div class="mdl-card__actions mdl-card--border">';
    strhtml += '<h4 class="align-right"><strong>S/.</strong>&nbsp;<span class="total">' + total_orden.toFixed(2) + '</span></h4>';
    strhtml += '</div>';
    strhtml += '<div class="mark-selected pos-abs indigo accent-4 white-text circle"><i class="material-icons centered">&#xE5CA;</i></div>';

    strhtml += '<i class="icon-select centered material-icons white-text circle">&#xE5CA;</i>';
    strhtml += '<div class="layer-select"></div>';

    strhtml += '</div>';

    return strhtml;
}

function ListarOrdenes (idambiente, selector, estadoatencion) {
    $.ajax({
        url: 'services/atencion/atencion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'ATENCION-TICKETS',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idambiente: idambiente,
            idmesas: '0',
            estado: estadoatencion
        },
        success: function (result) {
            var strhtml = '';
            var i = 0;
            
            var groups = _.groupBy(result, function(value){
                return value.tm_idatencion + '#' + value.tm_idambiente + '#' + value.tm_nroatencion + '#' + value.ta_estadoatencion + '#' + value.ta_tipoubicacion + '#' + value.tm_fechahora + '#' + value.tm_idempresa + '#' + value.tm_idcentro;
            });
            
            var data = _.map(groups, function(group){
                return {
                    tm_idatencion: group[0].tm_idatencion,
                    tm_idambiente: group[0].tm_idambiente,
                    tm_nroatencion: group[0].tm_nroatencion,
                    ta_estadoatencion: group[0].ta_estadoatencion,
                    ta_tipoubicacion: group[0].ta_tipoubicacion,
                    tm_fechahora: group[0].tm_fechahora,
                    tm_idempresa: group[0].tm_idempresa,
                    tm_idcentro: group[0].tm_idcentro,
                    list_articulos: group
                }
            });

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += crearItemOrden(data[i].tm_idatencion, data[i].tm_nroatencion, 'Admin', data[i].list_articulos);
                    ++i;
                };
            };
            
            $(selector).html(strhtml);
            atencion_Notif(estadoatencion);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function listarDetalle_Orden (estadoatencion, id_orden, nro_orden, nombre_personal) {
    $.ajax({
        url: 'services/atencion/detallearticulo-search.php',
        type: 'GET',
        data: {
            tipo: '2',
            idatencion: id_orden
        },
        dataType: 'json',
        cache: false,
        success: function (data) {
            var strhtml_orden = crearItemOrden(id_orden, nro_orden, nombre_personal, data);
            var selector = estadoatencion == '03' ? '#pnlCocina' : '#pnlEspera';
            
            $(selector).append(strhtml_orden);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function agregar_Notificiacion (estadoatencion, _data) {
    if (typeof _data.idatencion != 'undefined') {
        if (_data.idatencion != '0') {
            var idatencion  = _data.idatencion;          
            var nroatencion  = _data.nroatencion;

            var selector = estadoatencion == '03' ? '#pnlCocina' : '#pnlEspera';

            if ($(selector + ' .dato[data-idorden="' + idatencion + '"]').length == 0)
                listarDetalle_Orden(estadoatencion, idatencion, nroatencion, 'Admin');
        };
    };
}

// window.onYouTubeIframeAPIReady = function() {
//     setVideo(0);
// }

function setVideo () {

    // if (index == videoArray.length)
    //     index = 0;
    // player = new YT.Player('player', {
    //     width: 720,
    //     height: 480,
    //     videoId: videoArray[index],
    //     playerVars: {
    //         html5: 1,
    //         controls: 0,
    //         showinfo: 0,
    //         modestbranding: 1,
    //         wmode: 'transparent',
    //         iv_load_policy: 3
    //     },
    //     events: {
    //         'onReady': onPlayerReady,
    //         'onStateChange': onPlayerStateChange
    //     }
    // });
}

window.onPlayerReady = function(e) {
    e.target.seekTo(0);
    e.target.playVideo();
}

window.onPlayerStateChange = function(state) {
    if (state.data === 0) {
        index += 1;
        window.player.destroy();
        window.player == null;
        setVideo(index);
    }
}

function ListarAmbientes () {
    $.ajax({
        url: 'services/ambientes/ambientes-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<div data-idambiente="' + data[i].tm_idambiente + '" class="demo-card-monitor dato mdl-cell mdl-cell--3-col pos-rel mdl-card teal">';
                    strhtml += '<div class="mark-selected pos-abs indigo accent-4 white-text circle"><i class="material-icons centered">&#xE5CA;</i></div>';
                    strhtml += '<div style="width: 100%; height: 25%;" class="centered"><h3 class="text-center white-text">' + data[i].tm_nombre + '</h3></div>';
                    strhtml += '</div>';

                    ++i;
                };
            };

            $('#gvAmbientes').html(strhtml).find('.dato:first-child').trigger('click');
        },
        error: function (error) {
            console.log(error);
        }
    });
}