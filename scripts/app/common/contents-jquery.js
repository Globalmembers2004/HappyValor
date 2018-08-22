var askBeforeGetOut = true;

window.addEventListener("load", function load(event){
    /*document.oncontextmenu = function(){
        return false;
    }*/
},false);

window.onbeforeunload = function (e) {
  var message = "Sus cambios pueden no guardarse ¿Desea realmente salir de la aplicaciòn?",
  e = e || window.event;
  // For IE and Firefox
  alert(askBeforeGetOut);
  if (askBeforeGetOut) {
      if (e) {
        e.returnValue = message;
      }

      // For Safari
      return message;
  };
};


$(function () {
    var pag = getParameterByName('pag');
    var mode = getParameterByName('mode');
    
    $('.tooltipped').tooltip({delay: 50});

    $('.back-activity').on('click', function(event) {
        event.preventDefault();
        
        /*var url = $(window.top.document).find('.panelWin.active').attr('data-url');
        window.top.closeWindowFromInside(url);*/

        window.top.showDesktop();
    });
    
    if (mode == 'direct')
        $('.control-inner-app').addClass('hide');

    $('#txtSearch').on('keyup', function(event) {
        if (typeof Buscar !== 'undefined')
            Buscar();
    });

    $(document).on('click touchend', '.grouped-buttons > [data-action="more"]', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var parent = $(this).parent();

        if (parent.hasClass('fixed'))
            parent.removeClass('fixed');
        else {
            $('.grouped-buttons.fixed').removeClass('fixed');
            parent.addClass('fixed');
        };
    });

    $('#btnGenericBack').on('click', function(event) {
        event.preventDefault();
        datagrid.removeSelection();
    });

    // defaultBackEvent();

    $(document).on('click touchend', '.hide-expandable', function(event) {
        event.preventDefault();
        var selectorFade = '.page:visible .mdl-layout__header-row';
        
        $('.dato.expandable.is-expanded').removeClass('is-expanded').removeClass('expand-phone');
        $(selectorFade).fadeIn(300);
    });

    $('.control-inner-app').on('click', function (event) {
        event.preventDefault();
        window.parent.showOrHideCharmOptions('#charmOptions', true);
    });
    
    $('.close-modal-example').add('.close-dialog').on('click', function(event) {
        event.preventDefault();
        closeCustomModal(this);
    });

    $('.buttonfab-overlay').on('click', function(event) {
        event.preventDefault();
        closeEffectFBA();
    });

    $('.overlay-charm').on('click', function(event) {
        event.preventDefault();
        showOrHideCharmOptions('.control-center.is-visible', false);
    });

    $(document).on('click touchend', function (event) {
        if (!$(this).is(event.target) && !$(event.target).closest('.dropdown').length) {
            if($('.grouped-buttons.fixed').hasClass('fixed'))
                $('.grouped-buttons.fixed').removeClass('fixed');

            if($('.dropdown.is-visible').hasClass('is-visible'))
                $('.dropdown.is-visible').removeClass('is-visible');
        };

        if (!$(this).is(event.target) && !$(event.target).closest('#pnlShowCalendar').length) {
            if ($('#pnlShowCalendar').hasClass('is-visible'))
                $('#pnlShowCalendar').removeClass('is-visible');
        };
    });

    // $(document).bind('click.'+ activates.attr('id') + ' touchstart.' + activates.attr('id'), function (e) {
    //   if (!activates.is(e.target) && !origin.is(e.target) && (!origin.find(e.target).length) ) {
        
    //     $('.grouped-buttons.fixed').removeClass('fixed');
    //     $('.dropdown').removeClass('is-visible');
        
    //     $(document).unbind('click.'+ activates.attr('id') + ' touchstart.' + activates.attr('id'));
    //   }
    // });

    $('.m-search').on('click', '.helper-button', function(event) {
        event.preventDefault();
        $(this).parent().find('input:text[data-input="search"]').val('').focus();
        if (typeof showAll !== 'undefined')
            showAll();
    });

    $('#btnShowAll').on('click', function(event) {
        event.preventDefault();
        if (typeof showAll !== 'undefined')
            showAll();
    });

    $('.btnOpciones').on('click', function(event) {
        event.stopPropagation();
        $('.mnuOpciones').addClass('is-visible');
    });

    // if ($("form.validado").length > 0){
    //     validator = $("form.validado").validate({
    //         lang: 'es',
    //         showErrors: showErrorsInValidate
    //     });
    // };

    $('#btnMoreSites').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (!$(this).hasClass('disabled'))
            $('#mnuSites').addClass('is-visible');
    });

    $('#mnuSites').on('click', 'a', function(event) {
        event.preventDefault();

        var referencia = this.getAttribute('href');
        var titulo = this.innerText;
        
        $('#mnuSites').removeClass('is-visible');

        navigateSubSite(referencia, titulo);
    });

    $('.mnuOpciones').on('click', 'a', function(event) {
        event.preventDefault();

        var alink = this;
        var accion = alink.getAttribute('data-action');
        var action_to_hide = '';

        if (accion == 'select-all' || accion == 'unselect-all'){
            if (typeof selectorSelection !== 'undefined'){
                action_to_hide = accion == 'unselect-all' ? 'select-all' : 'unselect-all';
            
                $(this).addClass('oculto');
                $('.mnuOpciones a[data-action="' + action_to_hide + '"]').removeClass('oculto');

                if (accion == 'select-all'){
                    // showAppBar(selectorSelection, true, 'edit');
                    // setSelecting(selectorSelection, 'true', 'all');

                    $(selectorSelection + ' .dato').addClass('selected');
                    $(selectorSelection + ' input:checkbox').attr('checked', '');

                    if (typeof callBack__selectAll !== 'undefined')
                        callBack__selectAll();
                }
                else {
                    // if (!$(selectorSelection).hasClass('custom')){
                        // showAppBar(selectorSelection, false, 'edit');
                    // };
                    // setSelecting(selectorSelection, 'false', 'none');
                    
                    $(selectorSelection + ' .dato.selected').removeClass('selected');
                    $(selectorSelection + ' input:checkbox:checked').removeAttr('checked');
                };
            };
        }
        else if (accion == 'close'){
            confimar = confirm('¿Desea salir de esta pantalla?');

            if (confimar){
                alink = $('.list-activewin .activewin.active a.close', window.parent.document);
                window.parent.closeActiveWin(alink);
            };
        };

        $('.mnuOpciones').removeClass('is-visible');
    });
    
    ApplyValidNumbers();

    if (typeof messagesValid !== 'undefined') {
        $('#form1').validate({
            lang: 'es',
            messages: messagesValid,
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement)
                    $(placement).append(error);
                else
                    error.insertAfter(element);
            }
        });
    };
    
    // prepareForm('#form1');
});

var validator;

function navigateSubSite (referencia, titulo) {
    $('#pnlListado .mdl-layout-title span.text').text(titulo);

    $('#pnlListado .section-main section').hide();
    $(referencia).show();

    if (typeof getDataByReference !== 'undefined')
        getDataByReference(referencia);
}

function closeEffectFBA () {
    var idFAB = $('.buttonfab-overlay').attr('data-relfab');
    $('#' + idFAB).trigger('click');
}

function ListarOpcionesDropdown (idmenu) {
    $.ajax({
        url: 'services/menu/menu-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: 'HOME',
            idperfil: $('#spnIdPerfil').text(),
            idreferencia: idmenu,
            tipomenu: '02'
        },
        success: function (data) {
            var countdata = 0;
            var i = 0;
            var strhtml = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    //strhtml += '<li data-id="' + data[i].tm_idmenu + '" data-url="' + data[i].tm_uri + '" class="mdl-menu__item">' + data[i].tm_titulo + '</li>';
                    strhtml += '<li><a class="waves-effect" href="' + data[i].tm_uri + '" data-id="' + data[i].tm_idmenu + '">' + data[i].tm_titulo + '</a></li>';
                    ++i;
                };
                
                document.getElementById('mnuSites').innerHTML = strhtml;
            };
        },
        error: function (data) {
            console.log(data);
        }
    });
}