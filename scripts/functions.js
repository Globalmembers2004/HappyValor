// JavaScript Document
var isCtrl = false;


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

// var paginaGeneral = 1;
// var mnuOpciones = document.getElementsByClassName('.mnuOpciones')[0];
// if (mnuOpciones != null) {
//     var btnSelectAll = mnuOpciones.querySelector('a[data-action="select-all"]');
//     var btnUnSelectAll = mnuOpciones.querySelector('a[data-action="unselect-all"]');
// };

// (function ($) {
//    $.fn.liveDraggable = function (opts, sub) {
//       this.on("mouseover", sub, function() {
//          if (!$(this).data("init")) {
//             $(this).data("init", true).draggable(opts);
//          }
//       });
//       return this;
//    };
// }(jQuery));

// (function($){
//     $.fn.imgLoad = function(callback) {
//         return this.each(function() {
//             if (callback) {
//                 if (this.complete || /*for IE 10-*/ $(this).height() > 0) {
//                     callback.apply(this);
//                 }
//                 else {
//                     $(this).on('load', function(){
//                         callback.apply(this);
//                     });
//                 }
//             }
//         });
//     };
// })(jQuery);

// var oHtml = jQuery.fn.html;
// jQuery.fn.html = function() {
//     oHtml.apply(this, arguments).promise().done(function(){
//         $('img').imgLoad(function(){
//             $(this).css('opacity', '1');
//         });
//     });
//     return oHtml;
// };

function precargaExp(selector, bloqueo) {
    var capa = $(selector);

	if (bloqueo){
        //$(capa).append('<div class="modal-preload"><div class="modal-preload-content"><div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div></div></div>');
        var preloaderbar = capa.find('.preloaderbar');
        if (typeof preloaderbar !== 'undefined')
            preloaderbar.remove();
        capa.insertAdjacentHTML('beforeend', '<div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div>');
    }
    else {
        //$(capa + ' .modal-preload').remove();
        var preloaderbar = capa.find('.preloaderbar');
        if (typeof preloaderbar !== 'undefined')
            preloaderbar.remove();
    };
}

function setSelectOptions(objSelect, state){
    var select = document.querySelector(objSelect);
    var options = select.getElementsByTagName('option');
    
    Array.prototype.forEach.call(options, function(el, i){
        if (state == true)
            el.setAttribute('selected', 'selected');
        else
            el.removeAttribute('selected');
    });
}

function habilitarLink (selector, flag) {
    var alink = document.querySelector(selector);
    var isDisabled = alink.hasClass('disabled');
    
    if (flag){
        if (isDisabled){
            alink.removeClass('disabled');
            alink.setAttribute('href', alink.getAttribute('data-href'));
            alink.removeAttribute('disabled');
        };
    }
    else {
        if (!isDisabled){
            alink.addClass('disabled');
            alink.setAttribute('DATA-href', alink.getAttribute('href'));
            alink.setAttribute('href', 'javascript:void(0)');
            alink.setAttribute('disabled', 'disabled');
        };
    };
}

function habilitarControl(selectors, flag) {
    var controls = [];

    if (typeof selectors == 'string')
        controls = document.querySelectorAll(selectors);
    else {
        if (isArray(selectors))
            controls = selectors;
        else
            controls.push(selectors);
    };
    
    [].forEach.call(controls, function(el){
        if (flag == true)
            el.removeClass('disabled is-disabled').removeAttribute('disabled');
        else
            el.addClass('disabled is-disabled').setAttribute('disabled', '-1');
    });
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

// function ConvertMySQLDate (date) {
//     var dateOriginal = new String(date);
//     var dateConverted = '';
//     var year = '';
//     var month = '';
//     var day = '';
//     dateSlash = dateOriginal.split("-");
//     year = dateSlash[0];
//     month = dateSlash[1];
//     dayIncoming = dateSlash[2];
//     day = new String(dayIncoming).split(' ');
//     day = day[0];
//     dateConverted = day + '/' + month + '/' + year;
//     return dateConverted;
// }

// function ConvertMySQLTime (date) {
//     var dateOriginal = new String(date);
//     var dateConverted = '';
//     dateSpace = dateOriginal.split(" ");
//     strTime = dateSpace[1];
    
//     return strTime;
// }

// function buscarItem(lista, valor){
//     var ind, pos;
//     for(ind=0; ind<lista.length; ind++)
//     {
//         if (lista[ind] == valor)
//         break;
//     }
//     pos = (ind < lista.length)? ind : -1;
//     return (pos);
// }

// function convertDate(inputFormat) {
//   function pad(s) { return (s < 10) ? '0' + s.toString() : s.toString(); }
//   var d = new Date(inputFormat);
//   return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
// }

// function getOnlyYearMonth () {
//     function pad(s) { return (s < 10) ? '0' + s : s; }
//     var d = new Date();
//     return [d.getFullYear(), pad(d.getMonth()+1)].join('-');
// }

// function cargarDatePicker(ctrl, fnSelect) {
//     $(ctrl).datepicker(
//         {
//             dateFormat: 'dd/mm/yy',
//             changeMonth: true,
//             changeYear: true,
//             showMonthAfterYear: false,
//             onSelect: fnSelect
//         },
//         $.datepicker.regional['es']
//     );
// }

// function onlyNumbers (e) {
//     var charCode = (e.which) ? e.which : e.keyCode;
//     if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
//         return false;
//     return true;
// }

// function audioNotif (tipo) {
//     var i = document.createElement("audio");
//     var pathAudio = '';
//     if (tipo == 'BigBox')
//         pathAudio = "scripts/metro-alert/sound/bigbox.mp3";
//     i.setAttribute("src", pathAudio);
//     i.addEventListener("load", function () {
//         i.play()
//     }, true);
//     i.pause();
//     i.play();
// }

function prepareForm(form) {
    // Cache initial states
    // $('input:checkbox, input:radio', form).each(function() {
    //     $(this).prop('initial', $(this).is(':checked'));
    // });
    // $('select', form).each(function() {
    //     $(this).prop('initial', this.selectedIndex);
    // });
}

function resetForm (selector) {
    // var allInputs = $(selector + ' :input');
    // var allSelects = $(selector + ' .selecttwo');

    // allInputs.each(function(index, el) {
    //     var $element = $(el);

    //     $element.val(function() {
    //         return this.defaultValue;
    //     });

    //     if ($element.hasClass('tooltipped')){
    //         $element
    //         .data("tooltip", "")
    //         .removeClass("error state tooltipped")
    //         .tooltip("remove");
            
    //         $element.parent('div').removeClass('error-state');
    //     };
    // });

    // allSelects.each(function(index, el) {
    //     var $element = $(el);
    //     setDefaultSelection('#' + $element.attr('id'));
    // });

    // $('input:checkbox, input:radio', selector).each(function() {
    //     $(this).attr('checked', $(this).prop('initial'));
    // });
}

function GetToday () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    today = addLeadingZero(dd) + '/' + addLeadingZero(mm) + '/' + yyyy;
    return today;
}

function GetFormatDate (dd, mm, yyyy, format) {
    format = typeof format !== 'undefined' ? format : '/';
    dd = addLeadingZero(dd);
    mm = mm - 1;
    var monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    return (format == 'large') ? dd  +  ' de ' + monthNames[mm] + ' del año ' + yyyy : [dd, addLeadingZero(mm + 1), yyyy].join(format);
}

function zeroFill(number, width) {
    width -= number.toString().length;
    
    if ( width > 0 )
        return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;

    return number + ""; // always return a string
}

function GetCompleteDate_default () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    return GetFormatDate(dd, mm, yyyy, 'large');
}

function fadeIn (elem, ms, callback) {
    if (!elem)
        return;

    elem.style.opacity = 0;
    elem.style.filter = 'alpha(opacity=0)';
    elem.style.display = 'block';
    elem.style.visibility = 'visible';

    if (ms){
        var opacity = 0;
        var timer = setInterval( function() {
            opacity += 50 / ms;
            
            if (opacity >= 1){
                clearInterval(timer);
                opacity = 1;

                if (typeof callback !== 'undefined')
                    callback();
            };
            
            elem.style.opacity = opacity;
            elem.style.filter = 'alpha(opacity=' + opacity * 100 + ')';
        }, 50);
    }
    else {
        elem.style.opacity = 1;
        elem.style.filter = 'alpha(opacity=1)';
    };
}

function fadeOut (elem, ms, callback) {
    if (!elem)
        return;

    if (ms){
        var opacity = 1;
        var timer = setInterval( function() {
            opacity -= 50 / ms;
            
            if (opacity <= 0){
                clearInterval(timer);
                opacity = 0;
                elem.style.display = 'none';
                elem.style.visibility = 'hidden';

                if (typeof callback !== 'undefined')
                    callback();
            };

            elem.style.opacity = opacity;
            elem.style.filter = 'alpha(opacity=' + opacity * 100 + ')';
        }, 50);
    }
    else {
        elem.style.opacity = 0;
        elem.style.filter = 'alpha(opacity=0)';
        elem.style.display = 'none';
        elem.style.visibility = 'hidden';
    };
}

function openCustomModal (selector, callback) {
    var idmodal = selector.substring(1, selector.length);
    var modals = document.getElementsByClassName('modal-example-content');
    var modal = document.getElementById(idmodal);
    var lastZIndex = 0;
    var styleIndex = '';
    var i = 0;
    var countmodals = modals.length;

    if (countmodals > 0){
        while (i < countmodals){
            var elem_modal = modals[i];

            if (getStyle(elem_modal, 'display') !== 'none'){
                lastZIndex = getStyle(elem_modal, 'zIndex');
                break;
            };
            ++i;
        };
    };

    fadeIn(modal, 300);
    
    var overlayModal = document.createElement('div');
    
    overlayModal.setAttribute('id', 'over' + idmodal);
    overlayModal.addClass('modal-example-overlay');
    
    if (lastZIndex > 0){
        modal.style.zIndex = lastZIndex + 2;
        overlayModal.style.zIndex = lastZIndex + 1;
    };

    _body.appendChild(overlayModal);

    if (typeof callback !== 'undefined')
        callback();
}

function closeCustomModal (selector) {
    if (typeof selector != 'string'){
        var modals = document.getElementsByClassName('modal-example-content');
        var i = 0;
        var countmodals = modals.length;
        var elem_modal;

        if (countmodals > 0){
            while (i < countmodals){

                if (getStyle(modals[i], 'display') !== 'none'){
                    elem_modal = modals[i];
                    break;
                };
                ++i;
            };
            
            idmodal = elem_modal.getAttribute('id');
        };
    }
    else
        idmodal = selector.substring(1, selector.length);

    var modal = document.getElementById(idmodal);

    fadeOut(modal, 300);
    
    var overlayModal = document.getElementById('over' + idmodal);
    overlayModal.parentNode.removeChild(overlayModal);
}

var isArray = Array.isArray || function(arr) {
    return Object.prototype.toString.call(arr) == '[object Array]';
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
        var count_buttons = buttons.length;
        var _buttons = isArray(buttons) ? buttons : buttons.split('|');

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
        strhtml_header += '<div class="left"><a href="#" class="close-modal-example padding5 circle left"><i class="material-icons md-18">close</i></a>';
        strhtml_header += '<h4 class="no-margin fg-dark left">' + title + '</h4>';
        strhtml_header += '</div>';
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
    strhtml += '<div class="modal-example-wrapper padding30">' + options.content + '</div>';
    strhtml += '</main>';
    strhtml += '<footer class="modal-example-footer"></footer>';
    strhtml += '</div>';

    document.body.insertAdjacentHTML('beforeend', strhtml);

    var _cancelButton = typeof options.cancelButton === 'undefined' ? false : options.cancelButton;

    var messageBox = document.getElementById(_idmodal);
    var messageBox_footer = messageBox.getElementsByClassName('modal-example-footer')[0];
    
    if (typeof options.buttons !== 'undefined') {
        _buildCustomButtons(wrapper_buttons, options.buttons);
        
        if (_cancelButton)
            createDefaultButton(wrapper_buttons);
    };

    messageBox_footer.appendChild(wrapper_buttons);

    openCustomModal('#' + _idmodal);
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
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

function setSelect2 () {
    //$('select:not([multiple])').addClass('selecttwo').select2();

}

function setDefaultSelection (selector) {
    var selector_selected = '';
    if ($(selector + ' option:selected').length == 0)
        selector_selected = selector + ' option:eq(0)';
    else
        selector_selected = selector + ' option:selected';
    $(selector).val($(selector_selected).val());//.trigger("change");
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
    var overlay = $('.overlay-charm');
    var isVisible = charm_panel.hasClass('is-visible');

    if (state == false) {
        if (isVisible) {
            charm_panel.removeClass('is-visible');
            overlay.style.display = 'none';
        };
    }
    else {
        if (!isVisible) {
            charm_panel.addClass('is-visible');
            overlay.style.display = 'block';
        };
    };
}

function randomString (length) {
    var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

function inputNavigation (selector) {
    $(selector).on('keyup', '.mdl-textfield__input', function(event) {
        var _key = event.which || event.keyCode || 0;

        if (_key == 39 || _key == 37 || _key == 40 || _key == 38) {
            var _cell, _row, _containSibling, _containInput, _input;
            var caret_position = this.selectionStart;

            if (_key == 39 || _key == 37) {
                compareLength = _key == 39 ? this.value.length : 0;

                if (caret_position == compareLength) {
                    _cell = closest(this, 'td');
                    _containInput = _key == 39 ? _cell.nextSibling : _cell.previousSibling;
                };
            }
            else if (_key == 40 || _key == 38) {
                _row = closest(this, 'tr');
                _cell = closest(this, 'td');
                
                var arrCells = [].slice.call(_cell.parentNode.getElementsByTagName('td'));
                var _indexCell = arrCells.indexOf(_cell);

                _containSibling = _key == 40 ? _row.nextSibling : _row.previousSibling;

                if (_containSibling != null)
                    _containInput = _containSibling.getElementsByTagName('td')[_indexCell];
            };
            
            if (typeof _containInput !== 'undefined') {
                _input = _containInput.querySelector('input[type="text"]');

                if (_key == 39 || _key == 37) {
                    if (caret_position == compareLength) {
                        if (_input != null)
                            _input.focus();
                    };
                }
                else{
                    if (_input != null)
                        _input.focus();
                };
            };
        };

        // if (event.which == 39) { // right arrow
        //     _cell = closest(this, 'td');
            
        //     _cell.nextSibling.querySelector('input[type="text"]').focus();
        // }
        // else if (event.which == 37) { // left arrow
        //     _cell = closest(this, 'td');
            
        //     _cell.previousSibling.querySelector('input[type="text"]').focus();
        // }
        // else if (event.which == 40) { // down arrow
        //     _row = closest(this, 'tr');
        //     _cell = closest(this, 'td');
            
        //     arrCells = [].slice.call(_cell.parentNode.getElementsByTagName('td'));
        //     _indexCell = arrCells.indexOf(_cell);

        //     _row.nextSibling.getElementsByTagName('td')[_indexCell].querySelector('input[type="text"]').focus();
        // }
        // else if (event.which == 38) { // up arrow
        //     _row = closest(this, 'tr');
        //     _cell = closest(this, 'td');

        //     arrCells = [].slice.call(_cell.parentNode.getElementsByTagName('td'));
        //     _indexCell = arrCells.indexOf(_cell);

        //     _row.previousSibling.getElementsByTagName('td')[_indexCell].querySelector('input[type="text"]').focus();
        // };
    });
}

function selectable (element_text, options) {
    var strhtml = '';
    var gridview = document.createElement('div');

    gridview.addClass('gridview selectable no-padding mdl-shadow--4dp white hide');
    
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

    element_text.on('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
    });

    element_text.on('focus', function (event) {
        gridview.removeClass('hide');
    });

    var pagina = 1;
    var data = {
        criterio: element_text.value,
        pagina: pagina
    };

    if (typeof options.data !== 'undefined')
        data = $$.extend(data, options.data);

    element_text.on('keyup', function (event) {
        if (gridview.hasClass('hide'))
            gridview.removeClass('hide');

        data.criterio = this.value;

        $$.ajax({
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

function isNodeList(nodes) {
    var stringRepr = Object.prototype.toString.call(nodes);

    return typeof nodes === 'object' &&
        /^\[object (HTMLCollection|NodeList|Object)\]$/.test(stringRepr) &&
        (typeof nodes.length === 'number') &&
        (nodes.length === 0 || (typeof nodes[0] === "object" && nodes[0].nodeType > 0));
}

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
      var sending_data = $$.extend( {'timestamp' : self.timestamp}, _data );

      $$.ajax({
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