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

        closeCustomModal('#modalAmbientes');

        var idambiente = this.getAttribute('data-idambiente');
        
        $(this).siblings('.dato').removeClass('oneSelected');
        $(this).addClass('oneSelected');

        ListarMesas(idambiente);
    });
});


function crearItemMesa (data) {
    var strhtml = '';

    strhtml += '<div class="demo-card-square dato mdl-cell mdl-cell--2-col mdl-cell--6-col-phone pos-rel mdl-card" ';
    strhtml += 'data-idmesa="' + data.idgrupomesa + '" ';
    strhtml += 'data-tipomesa="' + data.ta_tipomesa + '" ';
    strhtml += 'data-state="' + data.estadoatencion_group + '" ';
    strhtml += 'style="background-color: ' + data.color_leyenda_group + ';">';

    strhtml += '<input type="checkbox" name="chkMesa[]" value="' + data.idgrupomesa + '" />';
    strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';
    strhtml += '<div style="width: 64px; height:48px;" class="centered"><h1 class="text-center white-text">' + data.codigo_group + '</h1></div>';
    strhtml += '</div>';

    return strhtml;
}

function initAutoScroll () {
    $list   = $('#pnlEspera');
    $listSH = $list[0].scrollHeight - $list.outerHeight();

    var loop = function (){ 
        setTimeout(function () {
            var t = $list.scrollTop();
            $list.stop().animate({scrollTop : !t ? $listSH : 0 }, 2000, loop);
        }, 15000);
    };

    loop();
}

function ListarMesas (idambiente) {
    var parentSelector = '#pnlMonitor';
    // var selector = (estadoatencion == '03' ? '#pnlCocina' : '#pnlEspera');

    precargaExp(parentSelector, true);

    $.ajax({
        url: 'services/ambientes/mesas-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'GROUP-MESAS',
            tipo: '2',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idambiente: idambiente,
            estadoatencion: '02,03,04'
        },
        success: function (result) {
            var strhtml = '';
            var i = 0;

            var groups = _.groupBy(result, function(value){
                return value.idgrupomesa + '#' + value.ta_tipomesa + '#' + value.codigo_group + '#' + value.comensales_group + '#' + value.estadoatencion_group + '#' + value.color_leyenda_group;
            });
            
            var data = _.map(groups, function(group){
                return {
                    idgrupomesa: group[0].idgrupomesa,
                    ta_tipomesa: group[0].ta_tipomesa,
                    codigo_group: group[0].codigo_group,
                    comensales_group: group[0].comensales_group,
                    estadoatencion_group: group[0].estadoatencion_group,
                    color_leyenda_group: group[0].color_leyenda_group,
                    list_mesas: group
                };
            });

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += crearItemMesa(data[i]);
                    ++i;
                };
            };
            // else
            //     strhtml = '<h2>No se encontraron resultados.</h2>';
            
            $('#pnlEspera').html(strhtml);

            atencion_Notif(idambiente);

            precargaExp(parentSelector, false);

            initAutoScroll();

            // $list.on('mouseenter mouseleave', function( e ){
            //     return e.type=="mouseenter"? $list.stop() : loop();
            // });      
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function atencion_Notif (idambiente) {
    var comet = new Comet(
        'services/atencion/mesa-update.php', {'idempresa': $('#hdIdEmpresa').val(), 'idcentro': $('#hdIdCentro').val(), 'idambiente': idambiente}, function (data) {
        agregar_Notificiacion(data);
    });
    comet.connect();
}

// function listarDetalle_Orden (estadoatencion, id_orden, nro_orden, nombre_personal) {
//     $.ajax({
//         url: 'services/atencion/detallearticulo-search.php',
//         type: 'GET',
//         data: {
//             tipo: '2',
//             idatencion: id_orden
//         },
//         dataType: 'json',
//         cache: false,
//         success: function (data) {
//             var strhtml_orden = crearItemOrden(id_orden, nro_orden, nombre_personal, data);
//             var selector = estadoatencion == '03' ? '#pnlCocina' : '#pnlEspera';
            
//             $(selector).append(strhtml_orden);
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }

function agregar_Notificiacion (_data) {
    if (typeof _data.idgrupomesa != 'undefined') {
        if (_data.idgrupomesa != '0') {
            var idgrupomesa  = _data.idgrupomesa;
            var strhtml = '';

            var selector = '#pnlEspera';

            if ($(selector + ' .dato[data-idmesa="' + idgrupomesa + '"]').length == 0){
                strhtml = crearItemMesa(_data);
                $('#pnlEspera').prepend(strhtml);

                initAutoScroll();
            };
        };
    };
}

// window.onYouTubeIframeAPIReady = function() {
//     setVideo(0);
// }

// function setVideo () {

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
// }

// window.onPlayerReady = function(e) {
//     e.target.seekTo(0);
//     e.target.playVideo();
// }

// window.onPlayerStateChange = function(state) {
//     if (state.data === 0) {
//         index += 1;
//         window.player.destroy();
//         window.player == null;
//         setVideo(index);
//     }
// }

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