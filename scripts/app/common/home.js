$(function () {
    $('#AppMain').on('click', '.opcion', function(event){
        event.preventDefault();
        navigateInFrame('00', this);
    });

    $('#gvCentros').on('click', '.mdl-card', function(event) {
        event.preventDefault();

        $(this).siblings('.mdl-card').removeClass('oneSelected');
        $(this).addClass('oneSelected');

        $('#hdIdCentro').val(this.getAttribute('data-id'));
    });

    $('#btnOpciones').on('click', function(event) {
        event.preventDefault();
        WebNotifications.askForPermission();
    });

    $('.list-activewin').on('click', '.activewin:not(.close)', function(event){
        event.preventDefault();
        navigateInFrame("01", this);
        $(this).addClass('active');
        $('.close-modal-example,.close-dialog').trigger('click');
    });

    $('body').on('click', '.modal-example-overlay', function(event) {
        event.preventDefault();
        $('.close-modal-example,.close-dialog').trigger('click');
    });
    
    $('.list-activewin').on('click', '.activewin > a.close', function(event){
        event.preventDefault();
        event.stopPropagation();
        closeActiveWin (this);
    });

    $('#lnkShowDesktop').on('click', function (event) {
        event.preventDefault();
        showDesktop();
        $('.close-modal-example,.close-dialog').trigger('click');
    });

    $('#menuModulo').on('click', 'a', function(event) {
        event.preventDefault();
        
        var referencia = this.getAttribute('href');
        
        navigateInPage(referencia);
        showOrHideCharmOptions('#charmOptions', false);
    });

    $('#control-app').on('click', function (event) {
        event.preventDefault();
        showOrHideCharmOptions('#charmOptions', true);
    });

    $('#menuBottomSettings').on('click', 'a', function(event) {
        event.preventDefault();
        
        var alink = this;
        var accion = alink.getAttribute('data-action');
        
        hideAllSlidePanels();
        
        if (accion == 'recents')
            openCustomModal('#modalRecents');
        else if (accion == 'settings')
            $('.mdl-card[data-id="' + config['configuracion'].id + '"]').trigger('click');
        else if (accion == 'home')
            showDesktop();
        else if (accion == 'center') {
            openModalCallBack('#modalCentros', function () {
                ListarCentros();
            });
        }
        else if (accion == 'logout'){
            MessageBox({
                content: '¿Realmente desea cerrar la sesi&oacute;n?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'Cerrar sesión',
                        onClickButton: function (event) {
                            askBeforeGetOut = false;
                            window.location = alink.getAttribute('href');
                        }
                    }
                ],
                cancelButton: true
            });
        };
    });
});

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
    var hexDigits = new Array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'); 

    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}

function precargaModulo (obj, flag) {
    var head = $('head');
    var metaColor = head.find('meta[name="theme-color"]');
    
    metaColor.remove();

    if (flag){
        var html_icon = obj.getElementsByClassName('material-icons')[0].outerHTML;
        var title_link = $(obj).find('.tile-label').text();
        var bg_color = getStyle(obj, 'background-color');

        head.append('<meta name="theme-color" content="' + rgb2hex(bg_color) + '">');
         $('.list-sites').append('<div class="preload" style="background-color: ' + bg_color + '"><div class="preload-wrapper">' + html_icon + '<h2 class="title-preload white-text place-bottom align-center padding20">' + title_link + '</h2></div>');
    }
    else {
        head.append('<meta name="theme-color" content="#3F51B5">');
        var preload =  $('.list-sites').find('.preload');
        preload.remove();
    };
}

function closeActiveWin (alink) {
    var activewin = alink.parentNode;
    closeWindow(activewin.getAttribute('data-url'));
}

function closeWindowFromInside (url) {
    $('.list-sites').find('.panelWin[data-url="' + url + '"]').remove();
    $('.activewin[data-url="' + url + '"]').remove();

    $('.list-sites').fadeOut(300);
    hideFrame();
}

function closeWindow (url) {
    var currentPanel =  $('.list-sites').find('.panelWin[data-url="' + url + '"]');
    
    currentPanel.remove();
    $(activewin).remove();
    
    var panelWin = $('.panelWin');
    if (panelWin.is(':visible')) {
        $('.list-sites').fadeOut(300);
        hideFrame();
    };
}

function showDesktop () {
    $('.list-sites').fadeOut(300);
    hideFrame();
    hideAllSlidePanels();
}

function hideAllSlidePanels () {
    showOrHideCharmOptions('#charmOptions', false);
}

function hideFrame() {
    var activeWin = $('.list-activewin').find('.activewin.active');
    var panelWin = $('.panelWin');
    
    activeWin.removeClass('active');

    if (panelWin.is(':visible')){
        panelWin.removeClass('active');
        panelWin.hide();
    };

    $('#menuModulo').html('');
}

function navigateInFrame(type, enlace, callback) {
    var idPanel = '';
    // var _frame;
    var page = enlace.getAttribute('data-url');
    var dataId = enlace.getAttribute('data-id');

    if (type == '00')
        idPanel = 'pnl' + dataId;
    else {
        var currentPanel =  $('.list-sites').find('.panelWin[data-url="' + page + '"]');
        idPanel = currentPanel.attr('id');
    };
    
    hideFrame();
    $('.list-sites').css({
        'display': 'block',
        'opacity': 1,
        'visibility': 'visible'
     });
    
    var windowActive = document.getElementById(idPanel);

    if (windowActive === null){
        var idFrame = 'ifr' + page;
        
        precargaModulo(enlace, true);

        var panel = document.createElement('div');
        panel.setAttribute('id', idPanel);
        panel.setAttribute('data-url', page);
        panel.setAttribute('data-id', dataId);

        var _frame = document.createElement('iframe');
        _frame.setAttribute('id', idFrame);
        _frame.setAttribute('scrolling', 'no');
        _frame.setAttribute('marginwidth', '0');
        _frame.setAttribute('marginheight', '0');
        _frame.setAttribute('width', '100%');
        _frame.setAttribute('height', '100%');
        _frame.setAttribute('frameborder', 'no');
        _frame.setAttribute('src', page);

        _frame.addEventListener('load', function(event){
            var fd = this.document || this.contentWindow;
            
            precargaModulo(enlace, false);
            createThumbWin(enlace, this);

            if (typeof fd.ListarOpcionesDropdown !== 'undefined')
                fd.ListarOpcionesDropdown(dataId);

            if (typeof callback !== 'undefined')
                callback(fd);
        });

        panel.appendChild(_frame);
         $('.list-sites').append(panel);
        
        panel.classList.add('panelWin', 'active');
    }
    else {
        windowActive.classList.add('active');
        windowActive.style.display = 'block';
        
        var _frame = windowActive.getElementsByTagName('iframe')[0];

        var fd = _frame.document || _frame.contentWindow;
        fd.ListarOpcionesDropdown(dataId);
        
        if (typeof callback !== 'undefined')
            callback(fd);
    };
    
    ListarOpcionesCharm(dataId);    
}

function createThumbWin(enlace, iframe) {
    var strhtml = '';
    var idactive = 'thumb' + enlace.getAttribute('id');
    var dataId = enlace.getAttribute('data-id');
    var activeWin = document.getElementById(idactive);

    if (activeWin == null){
        var titulo = $(enlace).find('.tile-label').text();
        var page = enlace.getAttribute('data-url');

        activeWin = document.createElement('div');
        activeWin.setAttribute('id', idactive);
        activeWin.setAttribute('data-id', dataId);
        activeWin.setAttribute('title', titulo);
        activeWin.setAttribute('data-url', page);

        activeWin.classList.add('activewin', 'demo-card-image', 'mdl-card', 'mdl-shadow--2dp', 'mdl-cell', 'mdl-cell--4-col', 'mdl-cell--4-col-tablet', 'mdl-cell--12-col-phone', 'active');

        strhtml = '<a href="#" class="close bg-opacity-8 circle place-top-right margin5 padding5"><i class="material-icons">close</i></a>';
        strhtml += '<div class="mdl-card__title mdl-card--expand"></div>';
        strhtml += '<div class="mdl-card__actions bg-opacity-8"><span class="demo-card-image__filename">' + titulo + '</span></div>';
        
        activeWin.innerHTML = strhtml;

        var view = $('.list-activewin').find('.view');
        view.append(activeWin);

        var body = iframe.contentDocument.body;

        html2canvas(body, {
            onrendered: function( canvas ) {
                activeWin.style.backgroundImage = 'url(' + canvas.toDataURL() + ')';
            },
            allowTaint: true,
            taintTest: false,
            logging: true,
            width: 600,
            height: 350
        });
    }
    else
        activeWin.classList.add('active');
}

function navigateInPage (referencia) {
    var windowActive =  $('.list-sites').find('.panelWin.active');
    var innerIframe = windowActive.find('iframe')[0];
    var contentIframe = innerIframe.contentDocument.body;

    $('.page', contentIframe).addClass('hide');
    $(referencia, contentIframe).removeClass('hide');
    
    var linkActive = $('#menuModulo').find('.active');
    linkActive.removeClass('active');

    var linkReferencia = $('#menuModulo').find('a[href="' + referencia + '"]');
    linkReferencia.addClass('active');

    var iframeDocument = innerIframe.document || innerIframe.contentWindow;
    if (typeof iframeDocument.getDataByReference !== 'undefined') {
        iframeDocument.getDataByReference(referencia);
    };
}

function ListarOcionesMenu () {
    $.ajax({
        type: 'GET',
        url: 'services/menu/menu-group-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 1,
            idperfil: $('#spnIdPerfil').text()
        },
        success: function(result){
            var i = 0;
            // var countdata = 0;
            var strhtml = '';
            var count_secciones = 0;

            var groups = _.groupBy(result, function(value){
                return value.tp_idgroupoption + '#' + value.tp_nombre;
            });

            var data = _.map(groups, function(group){
                return {
                    tp_idgroupoption: group[0].tp_idgroupoption,
                    tp_nombre: group[0].tp_nombre,
                    list_secciones: group
                }
            });

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var j = 0;
                    var secciones = data[i].list_secciones;

                    if (secciones.length == 1){
                        if (secciones[0].tm_titulo.trim().length == 0)
                            count_secciones = 0;
                        else
                            count_secciones = 1;
                    }
                    else
                        count_secciones = secciones.length;

                    if (count_secciones > 0){

                        strhtml += '<div class="mdl-cell mdl-cell--6-col">';
                        strhtml += '<div class="page-header no-margin"><h3>' + data[i].tp_nombre + '</h3></div>';
                        strhtml += '<div class="mdl-grid">';

                            
                        while (j < count_secciones){
                            if (typeof secciones[j] !== 'undefined') {
                                strhtml += '<div id="tile' + secciones[j].tm_idmenu + '" data-id="' + secciones[j].tm_idmenu + '" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone opcion ' + secciones[j].tm_iconbgcolor + ' white-text" data-url="' + secciones[j].tm_uri + '" data-role="tile">';
                                strhtml += '<i class="material-icons centered">' + secciones[j].tm_iconuri + '</i>';
                                strhtml += '<h5 class="tile-label place-bottom-left padding5 margin5">' + secciones[j].tm_titulo + '</h5>';
                                strhtml += '</div>';
                                
                            };
                            ++j;
                        };
                        

                        strhtml += '</div></div>';
                    };

                    ++i;
                };
            };

            $('#AppMain').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarOpcionesCharm (idmenu) {
    $.ajax({
        url: 'services/menu/menu-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 'HOME',
            idperfil: $('#spnIdPerfil').text(),
            idreferencia: idmenu,
            tipomenu: '03'
        },
        success: function (data) {
            var i = 0;
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    //strhtml += '<li data-id="' + data[i].tm_idmenu + '" data-url="' + data[i].tm_uri + '" class="mdl-menu__item">' + data[i].tm_titulo + '</li>';
                    strhtml += '<li><a class="' + data[i].tm_iconbgcolor + '" href="' + data[i].tm_uri + '" data-id="' + data[i].tm_idmenu + '"><i class="material-icons icon">' + data[i].tm_iconuri + '</i><span class="text">' + data[i].tm_titulo + '</span></a></li>';
                    ++i;
                };
            };
            
            $('#menuModulo').html(strhtml);
        },
        error: function (data) {
            console.error(data);
        }
    });
}

function ListarCentros () {
    $.ajax({
        type: 'GET',
        url: 'services/centro/centro-empresa.php',
        cache: false,
        dataType: 'json',
        success: function(data){
            var strhtml = '';
            var countdata = data.length;
            var i = 0;

            if (countdata > 0) {
                while (i < countdata){
                    strhtml += '<div id="tile' + data[i].tm_idcentro + '" data-id="' + data[i].tm_idcentro + '" class="mdl-card pos-rel mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--2-col-phone demo-card-order red" style="height: 180px;" data-role="tile">';
                    
                    strhtml += '<div style="display: table; height: 100%;" class="full-size">';

                    strhtml += '<div style="display: table-cell; vertical-align: middle;">';
                    
                    strhtml += '<h3 class="white-text align-center">' + data[i].tm_nombre + '</h3>';

                    strhtml += '</div>';

                    strhtml += '</div>';

                    strhtml += '<div class="mark-selected pos-abs indigo accent-4 white-text circle"><i class="material-icons centered">&#xE5CA;</i></div>';

                    strhtml += '</div>';
                    ++i;
                };
            };

            $('#gvCentros').html(strhtml);
        },
        error: function (data) {
            console.log(data);
        }
    });
}