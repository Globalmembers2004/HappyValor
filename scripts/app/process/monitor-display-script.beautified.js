var videoArray = [ "at3FPJaAwoY", "IxxstCcJlsc", "dGghkjpNCQ8", "RVmG_d3HKBA", "NF-kLy44Hls", "Qc9c12q3mrc", "RcZn2-bGXqQ", "CevxZvSJLk8", "5dbEhBKGOtY" ];

var index = 0;

var player;

$(function() {});

function ListarMesas(estadoatencion) {
    var parentSelector = "#pnlMonitor";
    var selector = "";
    if (estadoatencion == "03") selector = "#pnlCocina"; else selector = "#pnlEspera";
    precargaExp(parentSelector, true);
    $$.ajax({
        url: "services/ambientes/mesas-search.php",
        type: "GET",
        dataType: "json",
        data: {
            tipobusqueda: "GROUP-MESAS",
            tipo: "1",
            estadoatencion: estadoatencion
        },
        success: function(result) {
            var strhtml = "";
            var i = 0;
            var groups = _.groupBy(result, function(value) {
                return value.idgrupomesa + "#" + value.ta_tipomesa + "#" + value.codigo_group + "#" + value.comensales_group + "#" + value.estadomesa_group + "#" + value.color_leyenda_group;
            });
            var data = _.map(groups, function(group) {
                return {
                    idgrupomesa: group[0].idgrupomesa,
                    ta_tipomesa: group[0].ta_tipomesa,
                    codigo_group: group[0].codigo_group,
                    comensales_group: group[0].comensales_group,
                    estadomesa_group: group[0].estadomesa_group,
                    color_leyenda_group: group[0].color_leyenda_group,
                    list_mesas: group
                };
            });
            var countdata = data.length;
            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<div class="dato mdl-cell mdl-cell--2-col mdl-cell--2-col-phone pos-rel mdl-card" ';
                    strhtml += 'data-idmesa="' + data[i].idgrupomesa + '" ';
                    strhtml += 'data-tipomesa="' + data[i].ta_tipomesa + '" ';
                    strhtml += 'data-state="' + data[i].estadomesa_group + '" ';
                    strhtml += 'style="background-color: ' + data[i].color_leyenda_group + ';">';
                    strhtml += '<input type="checkbox" name="chkMesa[]" value="' + data[i].idgrupomesa + '" />';
                    strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';
                    strhtml += '<div style="width: 64px; height:48px;" class="centered"><h1 class="text-center white-text">' + data[i].codigo_group + "</h1></div>";
                    strhtml += "</div>";
                    ++i;
                }
            } else strhtml = "<h2>No se encontraron resultados.</h2>";
            $(selector).html(strhtml);
            precargaExp(parentSelector, false);
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function atencion_Notif(estadoatencion) {
    var comet = new Comet("services/atencion/despacho-update.php", {
        idempresa: $("#hdIdEmpresa").val(),
        idcentro: $("#hdIdCentro").val(),
        estadoatencion: estadoatencion
    }, function(data) {
        agregar_Notificiacion(estadoatencion, data);
    });
    comet.connect();
}

function agregar_Notificiacion(estadoatencion, data) {
    if (typeof _data.idatencion != "undefined") {
        if (_data.idatencion != "0") {
            var idatencion = _data.idatencion;
            var nroatencion = _data.nroatencion;
            ListarMesas(estadoatencion);
        }
    }
}

window.onYouTubeIframeAPIReady = function() {
    setVideo(0);
};

// function resizeDisplay () {
//     var heightTables = $('.displayTables').height();
//     var windowHeight = document.documentElement.offsetHeight;
//     var heightMonitor = windowHeight - heightTables;
//     $('.displayMonitor').height(heightMonitor);
// }
function setVideo(index) {
    if (index == videoArray.length) index = 0;
    player = new YT.Player("player", {
        width: 720,
        height: 480,
        videoId: videoArray[index],
        playerVars: {
            controls: 0,
            showinfo: 0,
            modestbranding: 1,
            wmode: "transparent",
            iv_load_policy: 3
        },
        events: {
            onReady: onPlayerReady,
            onStateChange: onPlayerStateChange
        }
    });
}

window.onPlayerReady = function(e) {
    e.target.seekTo(0);
    e.target.playVideo();
};

window.onPlayerStateChange = function(state) {
    if (state.data === 0) {
        index += 1;
        window.player.destroy();
        window.player == null;
        setVideo(index);
    }
};