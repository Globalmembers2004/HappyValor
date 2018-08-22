// // window.onbeforeunload = function() {
// //     return "¿Estás seguro de salir de la aplicaci&oacute;n?";
// // }

docReady(function () {
    //     /*document.oncontextmenu = function(){
//         return false;
//     }*/

    var subpag = getParameterByName('subpag');

    _body.on('click touchend', '.grouped-buttons [data-action="more"]', function(event) {
        event.preventDefault();
        event.stopPropagation();

        //var parent = this.parentNode;
        var parent = getParentsUntil(this, 'body', '.grouped-buttons');

        if (parent[0].hasClass('fixed')){
            parent[0].removeClass('fixed');
        }
        else {
            $('.grouped-buttons').removeClass('fixed');
            parent[0].addClass('fixed');
        };
    });

    _body.on('click touchend', function (event) {
        var options_add = $$('.options-add');
        var grouped_buttons = $$('.grouped-buttons');
        var dropdown = $$('.dropdown');
        var pnlShowCalendar = document.getElementById('pnlShowCalendar');
        var selectable = $$('.selectable');
        
        if (this != event.target && !closest(event.target, '#pnlShowCalendar')) {
            if(!selectable.hasClass('hide')) {
                selectable.addClass('hide');
            };
        };

        if (this != event.target && !closest(event.target, '.dropdown')) {
            if(options_add.hasClass('fixed')) {
                options_add.removeClass('fixed');
            };
            if(grouped_buttons.hasClass('fixed')) {
                grouped_buttons.removeClass('fixed');
            };
            if(dropdown.hasClass('is-visible')) {
                dropdown.removeClass('is-visible');
            };
        };

        if (this != event.target && !closest(event.target, '#pnlShowCalendar')) {
            if (pnlShowCalendar !== null) {
                if(pnlShowCalendar.hasClass('is-visible')) {
                    pnlShowCalendar.removeClass('is-visible');
                };
            };
        };
    });

    $$('.control-inner-app').on('click', function (event) {
        event.preventDefault();
        window.parent.showOrHideCharmOptions('#charmOptions', true);
    });

    if (typeof btnCloseModal !== 'undefined') {
        btnCloseModal.on('click', function (event) {
            event.preventDefault();
            closeCustomModal(this);
        });
    };
    
    if (mnuSites !== null) {
        mnuSites.on('click', 'a', function(event) {
            event.preventDefault();

            var referencia = this.getAttribute('href');
            var titulo = this.innerText;
            
            mnuSites.removeClass('is-visible');

            navigateSubSite(referencia, titulo);
        });
    };

    $('.overlay-charm').on('click', function(event) {
        event.preventDefault();
        showOrHideCharmOptions('.control-center.is-visible', false);
    });

    $('.buttonfab-overlay').on('click', function(event) {
        event.preventDefault();
        closeEffectFBA(this);
    });

    $$('#btnMoreSites').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!this.hasClass('disabled')) {
            mnuSites.addClass('is-visible');
        };
    });

    $$('.mnuOpciones').on('click', 'a', function(event) {
        event.preventDefault();

        var alink = this;
        var accion = alink.getAttribute('data-action');
        
        if (accion == 'close'){
            var confimar = confirm('¿Desea salir de esta pantalla?');

            if (confimar){
                var linkToClose = $('.list-activewin .activewin.active a.close', window.parent.document);
                window.parent.closeActiveWin(linkToClose);
            };
        };

        $$('.mnuOpciones').removeClass('is-visible');
    });

    $$('.btnOpciones').on('click', function(event) {
        event.stopPropagation();
        $$('.mnuOpciones').addClass('is-visible');
    });
});

var validator;
var btnCloseModal = $('*.close-modal-example,.close-dialog');
var mnuSites = document.getElementById('mnuSites');

function navigateSubSite (referencia, titulo) {
    var titleLayout = document.querySelector('#pnlListado .mdl-layout-title');
    titleLayout.find('.text').innerText = titulo;

    document.querySelectorAll('#pnlListado .mdl-layout__content section').addClass('hide');
    $(referencia).removeClass('hide');

    if (typeof getDataByReference !== 'undefined') {
        getDataByReference(referencia);
    };
}

function closeEffectFBA (fabOverlay) {
    fabOverlay = typeof fabOverlay !== 'undefined' ? fabOverlay : $('.buttonfab-overlay');
    
    var idFAB = fabOverlay.getAttribute('data-relfab');
    $('*#' + idFAB + ' .mfb-component__button--main').trigger('click');
}

function ListarOpcionesDropdown (idmenu) {
    $$.ajax({
        url: 'services/menu/menu-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 'HOME',
            idperfil: $('#spnIdPerfil').textContent,
            idreferencia: idmenu,
            tipomenu: '02'
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<li><a href="' + data[i].tm_uri + '" data-id="' + data[i].tm_idmenu + '">' + data[i].tm_titulo + '</a></li>';
                    ++i;
                };
                
                mnuSites.innerHTML = strhtml;
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}