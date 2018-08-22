// JavaScript Document
var isCtrl = false;
var startTime, endTime;
var longpress = false;
var isScroll = false;
var timeoutScroll = null;
var delayScroll = 200;
var paginaGeneral = 1;

var isArray = Array.isArray || function(arr) {
    return Object.prototype.toString.call(arr) == '[object Array]';
};

var inArray = function(elem, array, i){
    return [].indexOf.call(array, elem, i)
};

function getInternetExplorerVersion() {
  var f = -1;
  if (navigator.appName == "Microsoft Internet Explorer") {
    var e = navigator.userAgent;
    var d = new RegExp("MSIE ([0-9]{1,}[.0-9]{0,})");
    if (d.exec(e) != null) {
      f = parseFloat(RegExp.$1)
    }
  }
  return f
}

// function checkVersion() {
//   var c = "You're not using Windows Internet Explorer.";
//   var d = getInternetExplorerVersion();
//   if (d > -1) {
//     if (d >= 8) {
//       c = "You're using a recent copy of Windows Internet Explorer."
//     } else {
//       c = "You should upgrade your copy of Windows Internet Explorer."
//     }
//   }
//   alert(c)
// }

function isIE8orlower() {
  var c = "0";
  var d = getInternetExplorerVersion();
  if (d > -1) {
    if (d >= 9) {
      c = 0
    } else {
      c = 1
    }
  }
  return c
}

(function ($) {
   $.fn.liveDraggable = function (opts, sub) {
      this.on("mouseover", sub, function() {
         if (!$(this).data("init")) {
            $(this).data("init", true).draggable(opts);
         }
      });
      return this;
   };
}(jQuery));

(function ($) {
    $.fn.changeMaterialSelect = function (_value) {
        var listBox = this.parent().find('.mdl-selectfield__list-option-box');
        var optionText = listBox.find('li[data-option-value="' + _value + '"]').text();

        this.parent().find('.mdl-selectfield__box-value').text(optionText);
        this.val(_value);

        return this;
    };
}(jQuery));

(function($){
    $.fn.imgLoad = function(callback) {
        return this.each(function() {
            if (callback) {
                if (this.complete || /*for IE 10-*/ $(this).height() > 0) {
                    callback.apply(this);
                }
                else {
                    $(this).on('load', function(){
                        callback.apply(this);
                    });
                }
            }
        });
    };
})(jQuery);


// var oHtml = jQuery.fn.html;
// jQuery.fn.html = function() {
//     oHtml.apply(this, arguments).promise().done(function(){
//         $('img').imgLoad(function(){
//             $(this).css('opacity', '1');
//         });
//     });
//     return oHtml;
// };

function precargaExp(capa, bloqueo) {
	if (bloqueo){
        //$(capa).append('<div class="modal-preload"><div class="modal-preload-content"><div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div></div></div>');
        $(capa).append('<div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div>');
    }
    else {
        //$(capa + ' .modal-preload').remove();
        $(capa + ' .preloaderbar').remove();
    };
}

function precarga_OverLayer (selector, flag, options) {
    if (flag){
        var bg_color = 'rgba(225,225,225,0.5)';
        var mensaje = 'Cargando...';
        var icono = '<div class="bg-preloader-wrapper pos-rel full-size all-height"><div class="centered mdl-spinner mdl-js-spinner"></div></div>';

        if (typeof options !== 'undefined') {
            if (typeof options.bg_color !== 'undefined')
                bg_color = options.bg_color;

            if (typeof options.mensaje !== 'undefined')
                mensaje = options.mensaje;

            if (typeof options.icono !== 'undefined')
                icono = options.icono;
        };

        $(selector).append('<div class="preload" style="background-color: ' + bg_color + '"><div class="preload-wrapper">' + icono + '<h2 class="title-preload white-text place-bottom align-center padding20">' + mensaje + '</h2></div>');
    }
    else
        $(capa + ' .preload').remove();
}

function setSelectOptions(objSelect, state){
    $(objSelect).find('option').each(function(){
        if (state==true)
            $(this).attr('selected', 'selected');
        else
            $(this).removeAttr('selected');
    });
}

function habilitarLink (selector, flag) {
    if (flag){
        if ($(selector).hasClass('disabled')){
            $(selector).removeClass('disabled').attr("href", $(selector).data("href")).removeAttr("disabled");
        };
    }
    else {
        if (!$(selector).hasClass('disabled')){
            $(selector).addClass('disabled').data("href", $(selector).attr("href")).attr("href", "javascript:void(0)").attr("disabled", "disabled");
        };
    };
}

function habilitarControl(idcontrol, flag) {
    if (flag == true)
        $(idcontrol).removeAttr("disabled");
    else
        $(idcontrol).attr("disabled","-1");
}

function enterTextArea(idtextarea, destino){
    $(idtextarea).keyup(function(e) {
        if (e.which == 17) isCtrl = false;
    }).keydown(function(e) {
        if (e.which == 17) isCtrl = true;
        if (e.which == 13 && isCtrl == true) {
            $(destino).focus();
            isCtrl = false;
            return false;
        }
    });
}

function ConvertMySQLDate (date) {
    var dateOriginal = new String(date);
    var dateConverted = '';
    var year = '';
    var month = '';
    var day = '';
    dateSlash = dateOriginal.split("-");
    year = dateSlash[0];
    month = dateSlash[1];
    dayIncoming = dateSlash[2];
    day = new String(dayIncoming).split(' ');
    day = day[0];
    dateConverted = day + '/' + month + '/' + year;
    return dateConverted;
}

function ConvertMySQLTime (date) {
    var dateOriginal = new String(date);
    var dateConverted = '';
    dateSpace = dateOriginal.split(" ");
    strTime = dateSpace[1];
    
    return strTime;
}

function buscarItem(lista, valor){
    var ind, pos;
    for(ind=0; ind<lista.length; ind++)
    {
        if (lista[ind] == valor)
        break;
    }
    pos = (ind < lista.length)? ind : -1;
    return (pos);
}

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s.toString() : s.toString(); }
  var d = new Date(inputFormat);
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
}

function getOnlyYearMonth () {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date();
    return [d.getFullYear(), pad(d.getMonth()+1)].join('-');
}

function cargarDatePicker(ctrl, fnSelect) {
    $(ctrl).datepicker(
        {
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            showMonthAfterYear: false,
            onSelect: fnSelect
        },
        $.datepicker.regional['es']
    );
}

function cargarDatePicker_Restrict(ctrl, fnSelect) {
    $(ctrl).datepicker(
        {
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            minDate: 0,
            maxDate: "+1",
            changeYear: true,
            showMonthAfterYear: false,
            onSelect: fnSelect
        },
        $.datepicker.regional['es']
    );
}

function onlyNumbers (e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function MessageBox (options) {
    var strhtml = '';
    var strhtml_header = '';
    var no_header = '';
    var build_title = false;
    var build_buttons = false;
    var _idmodal = typeof options.idmodal === 'undefined' ? 'modalMessageBox' : options.idmodal;
    
    var wrapper_buttons = document.createElement('div');
    wrapper_buttons.className = 'wrapper-buttons';

    var _createButton = function (content, css_classes, id, handler) {
        var button = document.createElement('button');
        
        if (typeof id !== 'undefined')
            button.setAttribute('id', id);

        button.setAttribute('type', 'button');
        button.className = 'mdl-button mdl-js-button mdl-js-ripple-effect right ' + css_classes;

        button.innerHTML = content;

        button.addEventListener('click', function(event) {
            event.preventDefault();

            closeCustomModal('#' + _idmodal);

            if (typeof handler !== 'undefined')
                handler(event);
        });

        return button;
    };
    
    var _buildCustomButtons = function (wrapper, buttons) {
        var i = 0;
        var _buttons = isArray(buttons) ? buttons : buttons.split('|');
        var count_buttons = _buttons.length;

        wrapper.innerHTML = '';

        if (count_buttons > 0) {
            while(i < count_buttons){
                var _button = buttons[i];

                var primary = _button.primary === 'undefined' ? false : _button.primary;
                var css_primary = primary ? 'mdl-button--primary' : '';
                var content = _button.content === 'undefined' ? 'Aceptar' : _button.content;

                var button = _createButton(content, css_primary, _button.id, _button.onClickButton);

                componentHandler.upgradeElement(button);
                wrapper.appendChild(button);

                ++i;
            };
        };
    };

    var createDefaultButton = function (wrapper) {
        var cancel_button = _createButton('Cancelar', 'mdl-button--primary', 'cancel_button', function (event) {
            closeCustomModal('#' + _idmodal);
        });

        wrapper.appendChild(cancel_button);
    };

    if (typeof options.title === 'undefined')
        no_header = ' without-header';
    else {
        strhtml_header = '<header class="modal-example-header">';
        strhtml_header += '<h4 class="no-margin padding5"><strong>' + options.title + '</strong></h4>';
        strhtml_header += '</header>';
    };

    var _width = typeof options.width === 'undefined' ? 'default' : options.width;
    var _height = typeof options.height === 'undefined' ? 'default' : options.height;
    var style_WH = '';
    
    if ((_width != 'auto') && (_height != 'auto'))
        style_WH = ' style="width: ' + _width + '; height: ' + _height + ';"';

    strhtml = '<div id="' + _idmodal + '" class="modal-example-content modal-dialog' + no_header + '"' + style_WH + '>';
    strhtml += strhtml_header;
    strhtml += '<main class="modal-example-body">';
    strhtml += '<div class="modal-example-wrapper padding20">' + options.content + '</div>';
    strhtml += '</main>';
    strhtml += '<footer class="modal-example-footer"></footer>';
    strhtml += '</div>';

    var _checkModal = document.getElementById(_idmodal);
    if (_checkModal != null)
        _checkModal.parentNode.removeChild(_checkModal);
    
    document.body.insertAdjacentHTML('beforeend', strhtml);

    var _cancelButton = typeof options.cancelButton === 'undefined' ? false : options.cancelButton;

    var messageBox = document.getElementById(_idmodal);
    var messageBox_footer = messageBox.getElementsByClassName('modal-example-footer')[0];

    messageBox_footer.innerHTML = '';
    
    if (typeof options.buttons !== 'undefined') {
        _buildCustomButtons(wrapper_buttons, options.buttons);
    };
    
    if (_cancelButton)
        createDefaultButton(wrapper_buttons);

    messageBox_footer.appendChild(wrapper_buttons);

    openCustomModal('#' + _idmodal);
}

function prepareForm(form) {
    // Cache initial states
    $('input:checkbox, input:radio', form).each(function() {
        $(this).prop('initial', $(this).is(':checked'));
    });
    // $('select', form).each(function() {
    //     $(this).prop('initial', this.selectedIndex);
    // });
}

// function resetForm (selector) {
//     var allInputs = $(selector + ' :input');
//     // var allSelects = $(selector + ' .selecttwo');

//     allInputs.each(function(index, el) {
//         var $element = $(el);

//         if (el.tagName.toLowerCase() == 'select')
//             el.selectedIndex = 0;
//         else {
//             $element.val(function() {
//                 return this.defaultValue;
//             });
//         };

//         // if ($element.hasClass('tooltipped')){
//         //     $element
//         //     .data("tooltip", "")
//         //     .removeClass("error state tooltipped")
//         //     .tooltip("remove");
            
//         //     $element.parent('div').removeClass('error-state');
//         // };
//     });

//     // allSelects.each(function(index, el) {
//     //     var $element = $(el);
//     //     setDefaultSelection('#' + $element.attr('id'));
//     // });

//     $('input:checkbox, input:radio', selector).each(function() {
//         $(this).attr('checked', $(this).prop('initial'));
//     });
// }

function showErrorsInValidate (errorMap, errorList) {
    $.each(this.validElements(), function (index, element) {
        var $element = $(element);

        $element.data("tooltip", "")
        .removeClass("error state tooltipped")
        .tooltip("remove");

        $element.parent('div').removeClass('error-state');
    });

    $.each(errorList, function (index, error) {
        var $element = $(error.element);
        
        $element.tooltip("remove");

        $element
        .attr({
            'data-delay': '50',
            'data-position': 'bottom',
            'data-tooltip': error.message
        })
        .addClass("error state tooltipped")
        .tooltip();

        $element.parent('div').addClass('error-state');
    });
}

function LoadSubCategorias (idreferencia, idControl, defaultValue) {
    $.ajax({
        type: "GET",
        url: "services/categorias/categorias-search.php",
        cache: false,
        dataType: 'json',
        data: "idref=" + (idreferencia == '0' ? '1' : idreferencia),
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            
            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
                    ++i;
                };

                habilitarControl(idControl, true);
                if (defaultValue != null)
                    $(idControl).val(defaultValue).trigger('change');
            }
            else {
                strhtml = '<option value="0">No hay sub-categor&iacute;as disponibles</option>';
            };

            $(idControl).html(strhtml).trigger('change');
        },
        error:  function (data) {
            console.log(data);
        }
    });
}

function ApplyValidNumbers () {
    $('.only-numbers').numeric(".");
}

function addLeadingZero(num) {
    return ((num < 10) ? "0" + num : "" + num);
}

function GetToday () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd < 10) {
        dd = '0' + dd;
    } 

    if(mm < 10) {
        mm = '0' + mm;
    }

    today = dd + '/' + mm + '/' + yyyy;
    return today;
}

function GetCompleteDate (dd, mm, yyyy) {
    mm = mm - 1;
    var monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    return addLeadingZero(dd) +  ' de ' + monthNames[mm] + ' del año ' + yyyy;
}

function GetCompleteDate_default () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    return GetCompleteDate(dd, mm, yyyy);
}

function padZero(num, size) {
    var s = num + '';
    while (s.length < size) s = '0' + s;
    return s;
}

function customReady(fn) {
  if (document.readyState != 'loading'){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

function toggleSlideButton (obj, slideSelector, params) {
    var pathIcon = '';
    var labelButton = '';
    if (!$(obj).hasClass('active')){
        pathIcon = params.icon_deactive;
        labelButton = params.msje_deactive;
        $(obj).addClass('active');
        $(slideSelector).slideDown();
    }
    else {
        pathIcon = params.icon_active;
        labelButton = params.msje_active;
        $(obj).removeClass('active');
        $(slideSelector).slideUp();
    }
    $(obj).find('.content img').attr('src', pathIcon);
    $(obj).find('.content .text').html(labelButton);
}

function toggleSlidePanel(layout, state) {
    if (state == false) {
        if ($(layout).is(':visible')){
            $('.control-app', parent.document).removeClass('oculto');
            $(layout).hide('slide', {'direction':'right'}, 400);
        }
    }
    else {
        if (!$(layout).is(':visible')) {
            $('.control-app', parent.document).addClass('oculto');
            $(layout).show('slide', {'direction':'right'}, 400);
        }
    }
}

function ListarDetallePorArticulo (idatencion) {
    $.ajax({
        type: 'GET',
        url: 'services/atencion/detallearticulo-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipo: '1',
            idatencion: idatencion
        },
        success: function(data){
            var count = 0;

            count = data.length;

            if (count > 0){
                $('.contentPedido table tr').map(function(index, elem) {
                    var selector_row;
                    var selector_details;
                    var i = 0;
                    var strhtml = '';

                    selector_row = $(elem);
                    selector_details = selector_row.find('.categoria');
                    
                    while(i < count){
                        if (selector_row.attr('data-iddetalle') == data[i].td_idatencion_articulo){
                            strhtml += '<span data-idelemgroup="' + data[i].tm_idproducto + '" class="elemgroup">' + data[i].tm_nombre + '</span>';
                        }
                        ++i;
                    }
                    selector_details.prepend(strhtml);
                });
            }
        }
    });
}

function toggleOptions_v2(selector, direction) {
  if ($(selector).is(':visible')){
    $(selector).hide('slide', {'direction':direction}, 400);
    $('.slider-overlay[data-referer="' + selector + '"]').addClass('hide');
  }
  else {
    $(selector).show('slide', {'direction':direction}, 400);
    $('.slider-overlay[data-referer="' + selector + '"]').removeClass('hide');
  };
}

function toggleOptions(layout, state) {
    if (state == false) {
        if ($(layout).is(':visible')){
            $(layout).hide('slide', {'direction':'left'}, 400);
        }
    }
    else {
        if (!$(layout).is(':visible')) {
            $(layout).show('slide', {'direction':'left'}, 400);
        }
    }
}

function openModal (idmodal) {
    $(idmodal + '.custombox-modal').css({
        'transition': '600ms',
        '-webkit-transition': '600ms'
    }).addClass('custombox-slit').addClass('custombox-show').after('<div class="modal-example-overlay"></div>');
}

function closeModal (idmodal) {
    $(idmodal + '.custombox-modal').removeClass('custombox-slit').removeClass('custombox-show').removeAttr('style').nextAll('.modal-example-overlay').remove();

    var validator = $('#form1').validate();
    if (typeof validator !== 'undefined')
        validator.resetForm();
    
    if (typeof clearValidationsRules !== 'undefined')
        clearValidationsRules(idmodal);
}

function openCustomModal (idmodal) {
    /*$(idmodal + ', .modal-example-overlay').fadeIn(300, function() {
        
    });*/

    var lastZIndex = 0;
    var styleIndex = '';
    
    lastZIndex = $('.modal-example-content:visible').zIndex();

    $(idmodal).fadeIn(250, function() {
    });
    
    if (lastZIndex > 0)
        $(idmodal).zIndex(lastZIndex + 2);
    
    idmodal = idmodal.substring(1, idmodal.length);
    
    if (lastZIndex > 0)
        styleIndex = ' style="z-index: ' + (lastZIndex + 1) + ';"';
    
    $('body').append('<div id="over' + idmodal + '" class="modal-example-overlay"' + styleIndex + '></div>');
}

function closeCustomModal (selector) {
    var idmodal = '';

    if (typeof selector != 'string') {
        var elemDialog = getParentsUntil(selector, false, '.modal-example-content');
        idmodal = '#' + elemDialog[0].getAttribute('id');
    }
    else
        idmodal = selector;

    $(idmodal).fadeOut(250, function() {
    });

    idmodal = idmodal.substring(1, idmodal.length);
    // console.log('#over' + idmodal);
    $('#over' + idmodal).remove();

    var validator = $('#form1').validate();
    if (typeof validator !== 'undefined')
        validator.resetForm();
    
    if (typeof clearValidationsRules !== 'undefined')
        clearValidationsRules(idmodal);
}

function openModalCallBack (idmodal, callback) {
    var lastZIndex = 0;
    var styleIndex = '';
    
    lastZIndex = $('.modal-example-content:visible').zIndex();

    $(idmodal).fadeIn(250, function () {        
    
    });

    if (lastZIndex > 0)
        $(idmodal).zIndex(lastZIndex + 2);
    
    idmodal = idmodal.substring(1, idmodal.length);
    
    if (lastZIndex > 0)
        styleIndex = ' style="z-index: ' + (lastZIndex + 1) + ';"';
    
    $('body').append('<div id="over' + idmodal + '" class="modal-example-overlay"' + styleIndex + '></div>');

    callback();
}

function hideTopCharmOptions() {
    var charmOptions = $("#charmOptions", top.document);
    if (charmOptions.is(':visible'))
        charmOptions.hide('slide', {'direction':'right'}, 300);
}

function mostrarPanel (idpanel, url) {
    var panel = $(idpanel);
    panel.fadeIn(1, function() {
        precargaExp(idpanel, true);
    });
    frame = $('<iframe></iframe>')
                    .attr({
                        "scrolling": "no",
                        "marginwidth" : "0",
                        "marginheight" : "0",
                        "width" : "100%",
                        "height" : "100%",
                        "frameborder" : "no",
                        "src" : url
                    }).load(function(){
                        precargaExp(idpanel, false);
                        $(this).contents().find("body, body *").on('click', function(event) {
                            hideTopCharmOptions();
                        });
                    });
    panel.html('').append(frame);
}

function setSpecialTab (idtab, callback) {
    $(idtab + '.special-tab > .menu').on('click', 'li > a', function(event) {
        var aLink = '';
        event.preventDefault();
        aLink = $(this).attr('href');

        $(idtab + '.special-tab > .menu li a.active').removeClass('active');
        $(this).addClass('active');
        $(idtab + ' > .content > .paneltab').hide();
        $(aLink).fadeIn('400', function() {
            callback();
        });
    }).find('li:first-child a').addClass('active');
}

function habilitarDiv (idlayer, flag) {
    if (flag){
        $(idlayer + ' .panel-bloqueo').fadeOut(300);
        //$(idlayer + ' *:not(.panel-bloqueo)').removeClass('opaco-disabled');
    }
    else {
        $(idlayer + ' .panel-bloqueo').fadeIn(300);
        //$(idlayer + ' *:not(.panel-bloqueo)').addClass('opaco-disabled');
    }
}

function startTime(){
    var today;
    var mesPlus = 0;
    var mes = '';
    
    today = new Date();
    mesPlus = today.getMonth() + 1;

    mes = addLeadingZero(mesPlus);

    h = today.getHours();
    m = today.getMinutes();
    s = today.getSeconds();
    
    m = addLeadingZero(m);
    s = addLeadingZero(s);
    
    document.getElementById('reloj').innerHTML = today.getDate() + '/' + mes + '/' + today.getFullYear() + ' ' + h + ':' + m + ':' + s;
    
    t = setTimeout(startTime, 500);
}

function BackToPrevPanel () {
    $('.inner-page:visible').fadeOut(400, function() {
        $(this).prev().fadeIn(400, function() {
            
        });
    });
}

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
    var hexDigits = new Array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'); 

    return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}
 
function getStyle(oElm, css3Prop){
    var strValue = "";
    
    if (window.getComputedStyle){
        strValue = getComputedStyle(oElm).getPropertyValue(css3Prop);
    }
    else if (oElm.currentStyle){
        try {
            strValue = oElm.currentStyle[css3Prop];
        }
        catch (e) {
            console.log(e);
        }
    };

    return strValue;
}

function ajustarColumnas (iditables) {
    if ($(iditables + ' tbody tr').length > 0){
        $(iditables + ' tbody tr:last td').each(function(index, el) {
            var columnas;
            var countdata = 0;

            columnas = $(iditables + ' thead th');
            countdata = columnas.length;

            if (countdata > 0){
                $(columnas[index]).width($(el).width());
            };
        });

        // $(iditables + ' .ihead').height('auto');
        // $(iditables + ' .ibody').css('padding-top', $(iditables + ' .ihead').height());
    };
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
   
String.prototype.repeat = function( num )
{
    return new Array( num + 1 ).join( this );
}

function Interval(fn, time) {
    var timer = false;
    this.start = function () {
        if (!this.isRunning())
            timer = setInterval(fn, time);
    };
    this.stop = function () {
        clearInterval(timer);
        timer = false;
    };
    this.isRunning = function () {
        return timer !== false;
    };
}

function getDomainServer () {
    /*var http = location.protocol;
    var slashes = http.concat("//");
    var host = slashes.concat(window.location.hostname);
    var host = host + ':' + window.location.port;*/
    var urlorigen = window.location.origin;
    var ruta = window.location.pathname;
    var arrRuta = ruta.split('/');
    var rootfolder = '';

    rootfolder = (arrRuta.length > 1) ? '/' + arrRuta[1] : '';
    urlorigen = urlorigen + rootfolder;

    return urlorigen;
}

function registerScriptMDL (selector) {
    var elements = document.querySelectorAll(selector); 
    var i = 0;
    var countdata = elements.length;

    if (countdata > 0){
        while (i < countdata){
            var element = elements[i];
            componentHandler.upgradeElement(element);
            ++i;
        };
    };
}

function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {

    var result = { width: 0, height: 0, fScaleToTargetWidth: true };

    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
        return result;
    }

    // scale to the target width
    var scaleX1 = targetwidth;
    var scaleY1 = (srcheight * targetwidth) / srcwidth;

    // scale to the target height
    var scaleX2 = (srcwidth * targetheight) / srcheight;
    var scaleY2 = targetheight;

    // now figure out which one we should use
    var fScaleOnWidth = (scaleX2 > targetwidth);
    if (fScaleOnWidth) {
        fScaleOnWidth = fLetterBox;
    }
    else {
       fScaleOnWidth = !fLetterBox;
    }

    if (fScaleOnWidth) {
        result.width = Math.floor(scaleX1);
        result.height = Math.floor(scaleY1);
        result.fScaleToTargetWidth = true;
    }
    else {
        result.width = Math.floor(scaleX2);
        result.height = Math.floor(scaleY2);
        result.fScaleToTargetWidth = false;
    }
    result.targetleft = Math.floor((targetwidth - result.width) / 2);
    result.targettop = Math.floor((targetheight - result.height) / 2);

    return result;
}

function setSelect2 () {
    $('select').addClass('selecttwo').select2();
}

function setDefaultSelection (selector) {
    var selector_selected = '';
    if ($(selector + ' option:selected').length == 0){
        selector_selected = selector + ' option:eq(0)';
    }
    else {
        selector_selected = selector + ' option:selected';
    };
    $(selector).val($(selector_selected).val()).trigger("change");
}

function viewInExpandItem (item) {
    var selectorFade = '.page:visible .mdl-layout__header-row';
    
    $('.dato.expandable.is-expanded').removeClass('is-expanded');
    $('.grouped-buttons').removeClass('fixed');
    item.classList.add('is-expanded', 'expand-phone');
    $(selectorFade).fadeOut(300);
}

// function defaultBackEvent () {
//     $('.back-button').on('click touchend', function(event) {
//         event.preventDefault();
//         // removeSelection();
//     });
// }

function initDragDrop (selectorMain) {
    var selectorDroparea = '';
    var selectedClass = 'selected';
    var clickDelay = 600;
    var lastClick;
    var diffClick;

    selectorDroparea = '#' + $(selectorMain).attr('data-droparea');
    
    $(selectorMain + " .dato").bind('mousedown mouseup', function(e) {
        if (e.type == "mousedown") {
            lastClick = e.timeStamp;
        }
        else {
            diffClick = e.timeStamp - lastClick;
            
            if (diffClick < clickDelay) {
                $(this).toggleClass(selectedClass);
            };
        };
    })
    .draggable({
        revertDuration: 10,
        containment: '.page-region',
        start: function(e, ui) {
            ui.helper.addClass(selectedClass);
            $(selectorDroparea).addClass('show');
        },
        stop: function(e, ui) {
            $('.' + selectedClass).css({
                top: 0,
                left: 0
            });
            $(selectorDroparea).removeClass('show');
        },
        drag: function(e, ui) {
            $('.' + selectedClass).css({
                top: ui.position.top,
                left: ui.position.left
            });
        }
    });

    $(selectorDroparea).droppable({
        drop: function(e, ui) {
            // $('.' + selectedClass).appendTo($(this)).add(ui.draggable) // ui.draggable is appended by the script, so add it after
            // .removeClass(selectedClass).css({
            //     top: 0,
            //     left: 0
            // });
        }
    });
}

function initMasonry (selector, selectorWidth, selectorItem) {
    var elem = document.querySelector(selector);
    var msnry = new Masonry( elem, {
        columnWidth: selectorWidth,
        itemSelector: selectorItem,
        percentPosition: true
    });
}

function showOrHideCharmOptions(selector, state) {
    var charm_panel = document.querySelector(selector);
    var overlay = document.querySelector('.overlay-charm');

    if (state == false) {
        if (charm_panel.classList.contains('is-visible')) {
            charm_panel.classList.remove('is-visible');
            overlay.style.display = 'none';
        };
    }
    else {
        if (!charm_panel.classList.contains(':visible')){
            charm_panel.classList.add('is-visible');
            overlay.style.display = 'block';
        };
    };
}

var getParentsUntil = function (elem, parent, selector) {
    var parents = [];
    if ( parent ) {
        var parentType = parent.charAt(0);
    }
    if ( selector ) {
        var selectorType = selector.charAt(0);
    }

    // Get matches
    for ( ; elem && elem !== document; elem = elem.parentNode ) {

        // Check if parent has been reached
        if ( parent ) {
            // If parent is a class
            if ( parentType === '.' ) {

                if ( elem.classList.contains( parent.substr(1) ) ) {
                    break;
                }
            }

            // If parent is an ID
            if ( parentType === '#' ) {
                if ( elem.id === parent.substr(1) ) {
                    break;
                }
            }

            // If parent is a data attribute
            if ( parentType === '[' ) {
                if ( elem.hasAttribute( parent.substr(1, parent.length - 1) ) ) {
                    break;
                }
            }

            // If parent is a tag
            if ( elem.tagName.toLowerCase() === parent ) {
                break;
            }

        }

        if ( selector ) {

            // If selector is a class
            if ( selectorType === '.' ) {
                if ( elem.classList.contains( selector.substr(1) ) ) {
                    parents.push( elem );
                }
            }

            // If selector is an ID
            if ( selectorType === '#' ) {
                if ( elem.id === selector.substr(1) ) {
                    parents.push( elem );
                }
            }

            // If selector is a data attribute
            if ( selectorType === '[' ) {
                if ( elem.hasAttribute( selector.substr(1, selector.length - 1) ) ) {
                    parents.push( elem );
                }
            }

            // If selector is a tag
            if ( elem.tagName.toLowerCase() === selector ) {
                parents.push( elem );
            }

        } else {
            parents.push( elem );
        }

    }

    // Return parents if any exist
    if ( parents.length === 0 ) {

        return null;
    } else {
        return parents;
    }
};

function showNotification (title, content, callbacks) {
  if (WebNotifications.areSupported()){
    if (WebNotifications.currentPermission() === WebNotifications.permissions.granted) {
      var notif = WebNotifications.new(title, content, 'images/dish-icon.png', null, 7000);
      
      if (typeof callbacks.click !== 'undefined')
        notif.addEventListener("click", callbacks.click);
      else if (typeof callbacks.show !== 'undefined')
        notif.addEventListener("show", callbacks.show);
      else if (typeof callbacks.close !== 'undefined')
        notif.addEventListener("close", callbacks.close);
    };
  };
}

var Comet = function (_url, _data, _callback) {
  this.timestamp = 0;
  this.url = _url;  
  this.noerror = true;
  this.connect = function() {
      var self = this;
      var sending_data = $.extend( {'timestamp' : self.timestamp}, _data );

      $.ajax({
          type : 'get',
          url : this.url,
          dataType : 'json',
          data : sending_data,
          success : function(response) {
            self.timestamp = response.timestamp;
            self.handleResponse(response);
            self.noerror = true;
          },
          complete : function(response) {
            if (!self.noerror) {
              setTimeout(function(){ comet.connect(); }, 5000);           
            }
            else {
              self.connect();
            }
            self.noerror = false;
          }
      });
  }
  this.disconnect = function() {}
  this.handleResponse = function(response) {
      console.log(response);
      _callback(response);
  }
};

function playNotifSound () {
  if (isIE8orlower() == 0) {
    var i = document.createElement("audio");
    i.setAttribute("src", "sound/messagebox.mp3");
    i.addEventListener("load", function () {
      i.play()
    }, true);
    i.pause();
    i.play()
  }
}

function selectable (element_text, options) {
    var strhtml = '';
    var gridview = document.createElement('div');

    gridview.classList.add('gridview', 'selectable', 'no-padding', 'mdl-shadow--4dp', 'white', 'hide');
    
    strhtml += '<ul class="collection gridview-content no-margin no-border hide">';
    strhtml += '</ul>';
    strhtml += '<div class="empty-temp">';
    strhtml += '<h4 class="padding20 grey-text text-darken-4">No se encontraron resultados</h4>';
    strhtml += '</div>';

    gridview.innerHTML = strhtml;

    if (typeof options.container === 'undefined')
        element_text.parentNode.appendChild(gridview);
    else {
        var container = document.getElementById(options.container);
        container.appendChild(gridview);
    };

    element_text.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
    });

    element_text.addEventListener('focus', function (event) {
        gridview.classList.remove('hide');
    });

    var pagina = 1;
    var data = {
        criterio: element_text.value,
        pagina: pagina
    };

    if (typeof options.data !== 'undefined')
        data = $.extend(data, options.data);

    element_text.addEventListener('keyup', function (event) {
        if (gridview.classList.contains('hide'))
            gridview.classList.remove('hide');

        data.criterio = this.value;

        $.ajax({
            url: options.url,
            type: 'GET',
            dataType: 'json',
            data: data,
            success: options.successCallback,
            error: function (data) {
                console.log(data);
            }
        });
    });
}

function ListarUbicacion (selector, idubigeopadre, defaultvalue, callback) {
    $.ajax({
        url: 'services/ubigeo/ubigeo-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda : '4',
            id: idubigeopadre
        },
        success: function (data) {
            var i = 0;
            var countdata = 0;
            var strhtml = '';
            var selected = '';

            countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    if (defaultvalue != '0')
                        selected = defaultvalue == data[i].tm_idubigeo ? ' selected="selected"' : '';

                    strhtml += '<option value="' + data[i].tm_idubigeo + '" data-referencia="' + data[i].tm_idubigeoref + '" ' + selected + '>' + data[i].tm_nombre + '</option>';
                    ++i;
                };
            }
            else
                strhtml = '<option value="0" data-referencia="0">No hay regiones relacionadas</option>';

            $(selector).html(strhtml);

            if (typeof callback !== 'undefined')
                callback();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

// function startTime(selector){
//     var today = new Date();
//     var mesPlus = today.getMonth() + 1;

//     var mes = addLeadingZero(mesPlus);
//     var h = today.getHours();
    
//     var hours = (h + 24 - 2) % 24; 
//     var mid = 'AM';
    
//     if (hours == 0)
//         hours = 12;
//     else if (hours > 12) {
//         hours = hours % 12;
//         mid = 'PM';
//     };

//     h = addLeadingZero(h);

//     var m = today.getMinutes();
//     // var s = today.getSeconds();
    
//     m = addLeadingZero(m);
//     // s = addLeadingZero(s);
    
//     document.getElementById(selector).innerHTML = today.getDate() + '/' + mes + '/' + today.getFullYear() + ' ' + h + ':' + m + ' ' + mid;
    
//     t = setTimeout(startTime, 500, selector);
// }

// function startTime(selector) {
//   $(selector).html(moment().format('D/MM/YYYY hh:mm A'));

//   t = setInterval(startTime, 1000, selector);
// }

function emptyState_List (message) {
    return '<div class="empty_state centered text-center"><img src="images/logo_empty.png" class="margin20" style="width: 120px; height: 120px;" alt="" /><p class="text-center white-text">' + message + '</p><a href="#" id="btnActualizar" class="mdl-button white mdl-button--colored mdl-js-button waves-effect">Actualizar</a></div>';
}