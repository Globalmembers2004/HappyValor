// JavaScript Document
var isCtrl = false;

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
    if (bloqueo) {
        //$(capa).append('<div class="modal-preload"><div class="modal-preload-content"><div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div></div></div>');
        var preloaderbar = capa.find(".preloaderbar");
        if (typeof preloaderbar !== "undefined") preloaderbar.remove();
        capa.insertAdjacentHTML("beforeend", '<div class="preloaderbar" aria-busy="true" aria-label="Loading, please wait." role="progressbar"></div>');
    } else {
        //$(capa + ' .modal-preload').remove();
        var preloaderbar = capa.find(".preloaderbar");
        if (typeof preloaderbar !== "undefined") preloaderbar.remove();
    }
}

function setSelectOptions(objSelect, state) {
    var select = document.querySelector(objSelect);
    var options = select.getElementsByTagName("option");
    Array.prototype.forEach.call(options, function(el, i) {
        if (state == true) el.setAttribute("selected", "selected"); else el.removeAttribute("selected");
    });
}

function habilitarLink(selector, flag) {
    var alink = document.querySelector(selector);
    var isDisabled = alink.hasClass("disabled");
    if (flag) {
        if (isDisabled) {
            alink.removeClass("disabled");
            alink.setAttribute("href", alink.getAttribute("data-href"));
            alink.removeAttribute("disabled");
        }
    } else {
        if (!isDisabled) {
            alink.addClass("disabled");
            alink.setAttribute("DATA-href", alink.getAttribute("href"));
            alink.setAttribute("href", "javascript:void(0)");
            alink.setAttribute("disabled", "disabled");
        }
    }
}

function habilitarControl(selectors, flag) {
    var controls = [];
    if (typeof selectors == "string") controls = document.querySelectorAll(selectors); else {
        if (isArray(selectors)) controls = selectors; else controls.push(selectors);
    }
    [].forEach.call(controls, function(el) {
        if (flag == true) el.removeClass("disabled is-disabled").removeAttribute("disabled"); else el.addClass("disabled is-disabled").setAttribute("disabled", "-1");
    });
}

function enterTextArea(idtextarea, destino) {
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
function prepareForm(form) {}

function resetForm(selector) {}

// function showErrorsInValidate (errorMap, errorList) {
//     $.each(this.validElements(), function (index, element) {
//         var $element = $(element);
//         $element.data("tooltip", "")
//         .removeClass("error state tooltipped")
//         .tooltip("remove");
//         $element.parent('div').removeClass('error-state');
//     });
//     $.each(errorList, function (index, error) {
//         var $element = $(error.element);
//         $element.tooltip("remove");
//         $element
//         .attr({
//             'data-delay': '50',
//             'data-position': 'bottom',
//             'data-tooltip': error.message
//         })
//         .addClass("error state tooltipped")
//         .tooltip();
//         $element.parent('div').addClass('error-state');
//     });
// }
// function LoadSubCategorias (idreferencia, idControl, defaultValue) {
//     $.ajax({
//         type: "GET",
//         url: "services/categorias/categorias-search.php",
//         cache: false,
//         dataType: 'json',
//         data: "idref=" + (idreferencia == '0' ? '1' : idreferencia),
//         success: function(data){
//             var i = 0;
//             var countdata = data.length;
//             var strhtml = '';
//             if (countdata > 0){
//                 while(i < countdata){
//                     strhtml += '<option value="' + data[i].id + '">' + data[i].value + '</option>';
//                     ++i;
//                 };
//                 habilitarControl(idControl, true);
//                 if (defaultValue != null)
//                     $(idControl).val(defaultValue).trigger('change');
//             }
//             else {
//                 strhtml = '<option value="0">No hay sub-categor&iacute;as disponibles</option>';
//             };
//             $(idControl).html(strhtml).trigger('change');
//         },
//         error:  function (data) {
//             console.log(data);
//         }
//     });
// }
// function LoadClienteWithForm (criterio, tipocliente, pagina) {
//     var selector = '#gvClientes .items-area';
//     precargaExp('#gvClientes', true);
//     $.ajax({
//         type: "GET",
//         url: "services/clientes/clientes-search.php",
//         cache: false,
//         dataType: 'json',
//         data: "criterio=" + criterio + "&tipocliente=" + tipocliente + "&pagina=" + pagina,
//         success: function(data){
//             var i = 0;
//             var countDatos = data.length;
//             var emptyMessage = '';
//             var strhtml = '';
//             if (countDatos > 0){
//                 $('#gvClientes').show();
//                 $('#frmClientes').hide();
//                 while(i < countDatos){
//                     iditem = data[i].tm_idtipocliente;
//                     foto = data[i].tm_foto;
//                     strhtml += '<a href="#" class="list dato bg-gray-glass" data-idcliente="' + iditem + '" data-tipocliente="' + data[i].tm_iditc + '">';
//                     strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
//                     strhtml += '<div class="list-content">';
//                     strhtml += '<div class="data">';
//                     strhtml += '<aside>';
//                     if (foto == 'no-set')
//                         strhtml += '<i class="fa fa-user"></i>';
//                     else
//                         strhtml += '<img src="' + foto + '" />';
//                     strhtml += '</aside>';
//                     strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].Descripcion + '</strong>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].TipoDoc + ': ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
//                     strhtml += '</main></div></div>';
//                     strhtml += '</a>';
//                     ++i;
//                 }
//                 if (pagina == '1')
//                     $(selector).html(strhtml);
//                 else
//                     $(selector).append(strhtml);
//                 $('#btnNewCliente').removeClass('oculto');
//                 $('#btnSaveCliente, #btnCancelCliente, #btnDelCliente, #btnEditCliente, #btnCleanSelectCliente').addClass('oculto');
//                 $('#hdPageCli').val(Number($('#hdPageCli').val()) + 1);
//                 $(selector).on('scroll', function(){
//                     if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
//                         var pagina = $('#hdPageCli').val();
//                         LoadClienteWithForm(criterio, tipocliente, pagina);
//                     }
//                 });
//             }
//             else {
//                 if (pagina == '1'){
//                     $('#gvClientes').hide();
//                     $('#frmClientes').show();
//                     $('#btnNewCliente, #btnDelCliente, #btnEditCliente, #btnCleanSelectCliente').addClass('oculto');
//                     $('#btnSaveCliente, #btnCancelCliente').removeClass('oculto');
//                 }
//             }
//             precargaExp('#gvClientes', false);
//         }
//     });
// }
// function LoadProveedorWithForm (criterio, pagina) {
//     var selector = '#gvProveedor .items-area';
//     precargaExp('#gvProveedor', true);
//     $.ajax({
//         type: "GET",
//         url: "services/proveedores/proveedores-search.php",
//         cache: false,
//         dataType: 'json',
//         data: "criterio=" + criterio + "&pagina=" + pagina,
//         success: function(data){
//             var i = 0;
//             var countDatos = data.length;
//             var emptyMessage = '';
//             var strhtml = '';
//             if (countDatos > 0){
//                 $('#gvProveedor').show();
//                 $('#frmProveedor').hide();
//                 while(i < countDatos){
//                     iditem = data[i].tm_idproveedor;
//                     foto = data[i].tm_foto;
//                     strhtml += '<a href="#" class="list dato bg-gray-glass" data-idproveedor="' + iditem + '">';
//                     strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
//                     strhtml += '<div class="list-content">';
//                     strhtml += '<div class="data">';
//                     strhtml += '<aside>';
//                     if (foto == 'no-set')
//                         strhtml += '<i class="fa fa-user"></i>';
//                     else
//                         strhtml += '<img src="' + foto + '" />';
//                     strhtml += '</aside>';
//                     strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].tm_nombreproveedor + '</strong>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">RUC: ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
//                     strhtml += '</main></div></div>';
//                     strhtml += '</a>';
//                     ++i;
//                 }
//                 if (pagina == '1')
//                     $(selector).html(strhtml);
//                 else
//                     $(selector).append(strhtml);
//                 $('#btnNewProveedor').removeClass('oculto');
//                 $('#btnSaveProveedor, #btnCancelProveedor, #btnDelProveedor, #btnEditProveedor, #btnCleanSelectProveedor').addClass('oculto');
//                 $('#hdPageProv').val(Number($('#hdPageProv').val()) + 1);
//                 $(selector).on('scroll', function(){
//                     if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
//                         var pagina = $('#hdPageProv').val();
//                         BuscarProveedor(criterio, pagina);
//                     }
//                 });
//             }
//             else {
//                 if (pagina == '1'){
//                     $('#gvProveedor').hide();
//                     $('#frmProveedor').show();
//                     $('#btnNewProveedor, #btnDelProveedor, #btnEditProveedor, #btnCleanSelectProveedor').addClass('oculto');
//                     $('#btnSaveProveedor, #btnCancelProveedor').removeClass('oculto');
//                 }
//             }
//             precargaExp('#gvProveedor', false);
//         }
//     });
// }
// function NotificarAtencion (TipoNotificacion) {
//     $.ajax({
//         type: "GET",
//         url: "services/ambientes/mesas-search.php",
//         cache: false,
//         data: 'tipobusqueda=' + TipoNotificacion + '&idambiente=0',
//         success: function(data){
//             var datos = eval( "(" + data + ")" );
//             var countDatos = datos.length;
//             var selector = '#pnlMesas .tile-area';
//             var strContent = '';
//             var IdAtencion = '0';
//             var IdMesa = '0';
//             var CodEstado = '';
//             var ColorEstado = '';
//             var NroComentales = '';
//             if (countDatos > 0){
//                 IdAtencion = datos[0].tm_idatencion;
//                 IdMesa = datos[0].tm_idmesa;
//                 Codigo = datos[0].tm_codigo;
//                 CodEstado = datos[0].ta_estadoatencion;
//                 ColorEstado = datos[0].ta_colorleyenda;
//                 NroComentales = datos[0].tm_nrocomensales;
//                 if ($(selector + ' .tile[rel="' + IdMesa + '"]').length == 0){
//                     $('#pnlMesas .tile-area h2').remove();
//                     tile = $('<div class="tile"></div>');
//                     tile.attr({
//                          'data-idatencion': IdAtencion,
//                          'data-state': CodEstado,
//                          'rel': IdMesa
//                     }).css('background-color', ColorEstado).addClass('blink').hide();
//                     strContent = '<div class="tile-content">';
//                     strContent += '<div class="text-right padding10 ntp">';
//                     strContent += '<h1 class="fg-white">' + Codigo + '</h1>';
//                     strContent += '</div></div>';
//                     strContent += '<div class="brand"><span class="badge bg-dark">' + NroComentales + '</span></div>';
//                     tile.html(strContent).prependTo('#pnlMesas .tile-area').fadeIn(300);
//                     audioNotif('BigBox');
//                 }
//                 else {
//                     tile = $('#pnlMesas .tile[rel="' + IdMesa + '"]');
//                     if (tile.attr('data-state') != CodEstado){
//                         tile.attr('data-state', CodEstado).css('background-color', ColorEstado);
//                         audioNotif('BigBox');
//                     }
//                 }
//             }                    
//         }
//     });
// }
function GetToday() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    //January is 0!
    var yyyy = today.getFullYear();
    today = addLeadingZero(dd) + "/" + addLeadingZero(mm) + "/" + yyyy;
    return today;
}

function GetFormatDate(dd, mm, yyyy, format) {
    format = typeof format !== "undefined" ? format : "/";
    dd = addLeadingZero(dd);
    mm = mm - 1;
    var monthNames = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];
    return format == "large" ? dd + " de " + monthNames[mm] + " del año " + yyyy : [ dd, addLeadingZero(mm + 1), yyyy ].join(format);
}

function zeroFill(number, width) {
    width -= number.toString().length;
    if (width > 0) return new Array(width + (/\./.test(number) ? 2 : 1)).join("0") + number;
    return number + "";
}

function GetCompleteDate_default() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1;
    //January is 0!
    var yyyy = today.getFullYear();
    return GetFormatDate(dd, mm, yyyy, "large");
}

function fadeIn(elem, ms, callback) {
    if (!elem) return;
    elem.style.opacity = 0;
    elem.style.filter = "alpha(opacity=0)";
    elem.style.display = "block";
    elem.style.visibility = "visible";
    if (ms) {
        var opacity = 0;
        var timer = setInterval(function() {
            opacity += 50 / ms;
            if (opacity >= 1) {
                clearInterval(timer);
                opacity = 1;
                if (typeof callback !== "undefined") callback();
            }
            elem.style.opacity = opacity;
            elem.style.filter = "alpha(opacity=" + opacity * 100 + ")";
        }, 50);
    } else {
        elem.style.opacity = 1;
        elem.style.filter = "alpha(opacity=1)";
    }
}

function fadeOut(elem, ms, callback) {
    if (!elem) return;
    if (ms) {
        var opacity = 1;
        var timer = setInterval(function() {
            opacity -= 50 / ms;
            if (opacity <= 0) {
                clearInterval(timer);
                opacity = 0;
                elem.style.display = "none";
                elem.style.visibility = "hidden";
                if (typeof callback !== "undefined") callback();
            }
            elem.style.opacity = opacity;
            elem.style.filter = "alpha(opacity=" + opacity * 100 + ")";
        }, 50);
    } else {
        elem.style.opacity = 0;
        elem.style.filter = "alpha(opacity=0)";
        elem.style.display = "none";
        elem.style.visibility = "hidden";
    }
}

function openCustomModal(selector, callback) {
    var idmodal = selector.substring(1, selector.length);
    var modals = document.getElementsByClassName("modal-example-content");
    var modal = document.getElementById(idmodal);
    var lastZIndex = 0;
    var styleIndex = "";
    var i = 0;
    var countmodals = modals.length;
    if (countmodals > 0) {
        while (i < countmodals) {
            var elem_modal = modals[i];
            if (getStyle(elem_modal, "display") !== "none") {
                lastZIndex = getStyle(elem_modal, "zIndex");
                break;
            }
            ++i;
        }
    }
    fadeIn(modal, 300);
    var overlayModal = document.createElement("div");
    overlayModal.setAttribute("id", "over" + idmodal);
    overlayModal.addClass("modal-example-overlay");
    if (lastZIndex > 0) {
        modal.style.zIndex = lastZIndex + 2;
        overlayModal.style.zIndex = lastZIndex + 1;
    }
    _body.appendChild(overlayModal);
    if (typeof callback !== "undefined") callback();
}

function closeCustomModal(selector) {
    if (typeof selector != "string") {
        var modals = document.getElementsByClassName("modal-example-content");
        var i = 0;
        var countmodals = modals.length;
        var elem_modal;
        if (countmodals > 0) {
            while (i < countmodals) {
                if (getStyle(modals[i], "display") !== "none") {
                    elem_modal = modals[i];
                    break;
                }
                ++i;
            }
            idmodal = elem_modal.getAttribute("id");
        }
    } else idmodal = selector.substring(1, selector.length);
    var modal = document.getElementById(idmodal);
    fadeOut(modal, 300);
    var overlayModal = document.getElementById("over" + idmodal);
    overlayModal.parentNode.removeChild(overlayModal);
}

// function showSnackbar (options) {
//     var exist_snackbar = document.getElementsByClassName('mdl-js-snackbar');
//     if (exist_snackbar.length > 0) {
//         exist_snackbar[0].parentNode.removeChild(exist_snackbar[0]);
//     };
//     var snackbar = document.createElement('div');
//     snackbar.addClass('mdl-js-snackbar');
//     if (typeof options.id !== 'undefined') {
//         snackbar.setAttribute('id', options.id);
//     };
//     componentHandler.upgradeElement(snackbar);
//     var data = { message: options.message };
//     snackbar.MaterialSnackbar.showSnackbar(data);
//     _body.appendChild(snackbar);
// }
function MessageBox(options) {
    // $.MetroMessageBox({
    //     title: title,
    //     content: message,
    //     NormalButton: "#232323",
    //     ActiveButton: "#a20025",
    //     buttons: buttons
    // }, callback);
    var strhtml = "";
    var strhtml_header = "";
    var no_header = "";
    var build_title = false;
    var build_buttons = false;
    var _idmodal = typeof options.idmodal === "undefined" ? "modalMessageBox" : options.idmodal;
    var wrapper_buttons = document.createElement("div");
    wrapper_buttons.addClass("wrapper-buttons");
    var _createButton = function(content, css_classes, id, handler) {
        var button = document.createElement("button");
        if (typeof id !== "undefined") button.setAttribute("id", id);
        button.setAttribute("type", "button");
        button.addClass("mdl-button mdl-js-button mdl-js-ripple-effect right " + css_classes);
        button.innerHTML = content;
        button.on("click", function(event) {
            event.preventDefault();
            closeCustomModal("#" + _idmodal);
            if (typeof handler !== "undefined") handler(event);
        });
        return button;
    };
    var _buildCustomButtons = function(wrapper, buttons) {
        var i = 0;
        var count_buttons = buttons.length;
        var _buttons = isArray(buttons) ? buttons : buttons.split("|");
        while (i < count_buttons) {
            var _button = buttons[i];
            var primary = _button.primary === "undefined" ? false : _button.primary;
            var css_primary = primary ? "mdl-button--primary" : "";
            var content = _button.content === "undefined" ? "Aceptar" : _button.content;
            var button = _createButton(content, css_primary, _button.id, _button.onClickButton);
            componentHandler.upgradeElement(button);
            wrapper.appendChild(button);
            ++i;
        }
    };
    var createDefaultButton = function(wrapper) {
        var cancel_button = _createButton("Cancelar", "mdl-button--primary", "cancel_button", function(event) {
            closeCustomModal("#" + _idmodal);
        });
        wrapper.appendChild(cancel_button);
    };
    if (typeof options.title === "undefined") no_header = " without-header"; else {
        strhtml_header = '<header class="modal-example-header">';
        strhtml_header += '<div class="left"><a href="#" class="close-modal-example padding5 circle left"><i class="material-icons md-18">close</i></a>';
        strhtml_header += '<h4 class="no-margin fg-dark left">' + title + "</h4>";
        strhtml_header += "</div>";
        strhtml_header += "</header>";
    }
    var _width = typeof options.width === "undefined" ? "default" : options.width;
    var _height = typeof options.height === "undefined" ? "default" : options.height;
    var style_WH = "";
    if (_width != "auto" && _height != "auto") style_WH = ' style="width: ' + _width + "; height: " + _height + ';"';
    strhtml = '<div id="' + _idmodal + '" class="modal-example-content modal-dialog' + no_header + '"' + style_WH + ">";
    strhtml += strhtml_header;
    strhtml += '<main class="modal-example-body">';
    strhtml += '<div class="modal-example-wrapper padding30">' + options.content + "</div>";
    strhtml += "</main>";
    strhtml += '<footer class="modal-example-footer"></footer>';
    strhtml += "</div>";
    _body.insertAdjacentHTML("beforeend", strhtml);
    var _cancelButton = typeof options.cancelButton === "undefined" ? false : options.cancelButton;
    var messageBox = document.getElementById(_idmodal);
    var messageBox_footer = messageBox.getElementsByClassName("modal-example-footer")[0];
    if (typeof options.buttons !== "undefined") {
        _buildCustomButtons(wrapper_buttons, options.buttons);
        if (_cancelButton) createDefaultButton(wrapper_buttons);
    }
    messageBox_footer.appendChild(wrapper_buttons);
    openCustomModal("#" + _idmodal);
}

// function habilitarDiv (idlayer, flag) {
//     if (flag){
//         $(idlayer + ' .panel-bloqueo').fadeOut(300);
//         //$(idlayer + ' *:not(.panel-bloqueo)').removeClass('opaco-disabled');
//     }
//     else {
//         $(idlayer + ' .panel-bloqueo').fadeIn(300);
//         //$(idlayer + ' *:not(.panel-bloqueo)').addClass('opaco-disabled');
//     }
// }
// function BackToPrevPanel () {
//     $('.inner-page:visible').fadeOut(400, function() {
//         $(this).prev().fadeIn(400, function() {
//         });
//     });
// }
// function ajustarColumnas (iditables) {
//     if ($(iditables + ' tbody tr').length > 0){
//         $(iditables + ' tbody tr:last td').each(function(index, el) {
//             var columnas;
//             var countdata = 0;
//             columnas = $(iditables + ' thead th');
//             countdata = columnas.length;
//             if (countdata > 0){
//                 $(columnas[index]).width($(el).width());
//             };
//         });
//         // $(iditables + ' .ihead').height('auto');
//         // $(iditables + ' .ibody').css('padding-top', $(iditables + ' .ihead').height());
//     };
// }
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function getDomainServer() {
    /*var http = location.protocol;
    var slashes = http.concat("//");
    var host = slashes.concat(window.location.hostname);
    var host = host + ':' + window.location.port;*/
    var urlorigen = window.location.origin;
    var ruta = window.location.pathname;
    var arrRuta = ruta.split("/");
    var rootfolder = "";
    rootfolder = arrRuta.length > 1 ? "/" + arrRuta[1] : "";
    urlorigen = urlorigen + rootfolder;
    return urlorigen;
}

// function doRippleEffect (elem) {
//     var parent;
//     var ink;
//     parent = $(elem);
//     //create .ink element if it doesn't exist
//     if (parent.find(".ink").length == 0)
//         parent.append("<span class='ink'></span>");
//     ink = parent.find(".ink");
//     //incase of quick double clicks stop the previous animation
//     ink.removeClass("animate");
//     //set size of .ink
//     if(!ink.height() && !ink.width()) {
//         //use parent's width or height whichever is larger for the diameter to make a circle which can cover the entire element.
//         d = Math.max(parent.outerWidth(), parent.outerHeight());
//         ink.css({height: d, width: d});
//     };
//     //get click coordinates
//     //logic = click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center;
//     x = event.pageX - parent.offset().left - ink.width()/2;
//     y = event.pageY - parent.offset().top - ink.height()/2;
//     //set the position and add class .animate
//     ink.css({top: y+'px', left: x+'px'}).addClass("animate");
// }
function registerScriptMDL(selector) {
    var elements = document.querySelectorAll(selector);
    var i = 0;
    var countdata = elements.length;
    if (countdata > 0) {
        while (i < countdata) {
            var element = elements[i];
            componentHandler.upgradeElement(element);
            ++i;
        }
    }
}

// function setSelecting (selector, valueMultiselect, valueSelected) {
//     var obj = document.querySelector(selector);
//     obj.setAttribute('data-multiselect', valueMultiselect);
//     obj.setAttribute('data-selected', valueSelected);
// }
// function selectElement (baseElement, element, selectClass) {
//     var baselement = document.querySelector(baseElement);
//     var checkBox = element.querySelector('input[type="checkbox"]');
//     var selecteds;
//     if (element.hasClass(selectClass)){
//         element.removeClass(selectClass);
//         checkBox.checked = false;
//         selecteds = baselement.getElementsByClassName(selectClass);
//         if (selecteds.length == 0){
//             if (!baselement.hasClass('custom')){
//                 showAppBar(baseElement, false, 'edit');
//                 setSelecting(baseElement, 'false', 'none');
//             };
//             if (mnuOpciones != null) {
//                 btnUnSelectAll.addClass('hide');
//             };
//         }
//         else {
//             selecteds = baselement.getElementsByClassName(selectClass);
//             if (selecteds.length == 1){
//                 if (mnuOpciones != null) {
//                     btnUnSelectAll.removeClass('hide');
//                 };
//             };
//         };
//     }
//     else {
//         element.addClass(selectClass);
//         checkBox.checked = true;
//         if (mnuOpciones != null) {
//             btnSelectAll.removeClass('hide');
//             btnUnSelectAll.removeClass('hide');
//         };
//     };
// }
// function removeSelection () {
//     var idactionbar = document.querySelector('.actionbar.is-visible').getAttribute('id');
//     var selector = '.gridview[data-actionbar="' + idactionbar + '"]';
//     removeSelectionBySelector (selector);
// }
// function removeSelectionBySelector (selector) {
//     var selecteds = document.querySelectorAll(selector + ' .dato.selected');
//     selecteds.removeClass('hover');
//     var checkboxes = document.querySelectorAll(selector + ' input[type="checkbox"]');
//     [].forEach.call(checkboxes, function(el) {
//         el.checked = false;
//     });
//     showAppBar(selector, false, 'visible');
//     setSelecting(selector, 'false', 'none');
//     btnSelectAll.removeClass('hide');
//     btnUnSelectAll.addClass('hide');
// }
// function showAppBar (baselement, flag, mode) {
//     var baseElement;
//     var actionbar;
//     var idactionbar = '';
//     baseElement = $(baselement);
//     idactionbar = baseElement.getAttribute('data-actionbar');
//     actionbar = document.getElementById(idactionbar);
//     if (flag){
//         actionbar.removeClass('edit search');
//         actionbar.addClass('is-visible ' + mode);
//         baseElement.addClass(mode);
//         if (mode == 'search') {
//             actionbar.querySelector('input[data-input="search"]').focus();
//         }
//         else {
//             baseElement.addClass('prepare-multiselect');
//         };
//     }
//     else {
//         baseElement.removeClass('prepare-multiselect ' + mode);
//         actionbar.removeClass('is-visible ' + mode);
//     };
// }
// function gridEvents (selectorMain, selectorItem, oneClickCallback) {
//     if (!$(selectorMain).hasClass('custom')){
//         if ($(selectorMain).hasClass('list-checkbox')) {
//             $(selectorMain).on('click touchend', selectorItem + ' input[type="checkbox"]', function(event) {
//                 var elem = this;
//                 var parent = elem.parentNode();
//                 var selectClass = 'selected';
//                 var flagCheck = elem.checked;
//                 var itemsChecked;
//                 if (flagCheck){
//                     parent.addClass(selectClass);
//                 }
//                 else {
//                     parent.removeClass(selectClass);
//                 };
//                 itemsChecked = $(selectorMain + ' .' + selectClass);
//                 if (itemsChecked.length > 0){
//                     if (itemsChecked.length == 1){
//                         showAppBar(selectorMain, true, 'edit');
//                     };
//                 }
//                 else {
//                     showAppBar(selectorMain, false, 'edit');
//                 };
//             });
//         }
//         else {
//             $(selectorMain).on('click touchend', selectorItem, function(event) {
//                 event.preventDefault();
//                 var parent;
//                 var element_dataid = '0';
//                 parent = this;
//                 if (event.type == 'touchend'){
//                     endTime = new Date().getTime();
//                     longpress = (endTime - startTime < 300) ? false : true;
//                 };
//                 if (isScroll === false){
//                     if (longpress){
//                         showAppBar(selectorMain, true, 'edit');
//                         setSelecting(selectorMain, 'true', 'some');
//                         selectElement(selectorMain, parent, 'selected');
//                     }
//                     else {
//                         if ($(selectorMain).getAttribute('data-multiselect') == 'true') {
//                             selectElement(selectorMain, parent, 'selected');
//                         }
//                         else {
//                             if (typeof oneClickCallback !== 'undefined') {
//                                 oneClickCallback(this);
//                             };
//                         };
//                     };
//                 };
//             });
//             $(selectorMain).on('mousedown touchstart', selectorItem, function (event) {
//                 startTime = new Date().getTime();
//             });
//             $(selectorMain).on('mouseup', selectorItem, function (event) {
//                 endTime = new Date().getTime();
//                 longpress = (endTime - startTime < 300) ? false : true;
//             });
//         };
//     };
// }
// function listdataEvents_default () {
// var subpag = getParameterByName('subpag');
// var selectorScroll = '';
// if (subpag == 'menu-hoy'){
//     if ($('#pnlListaCartas').is(':visible')){
//         selectorScroll = '#pnlListaCartas';
//     };
// }
// else {
//     selectorScroll = '#pnlListado .mdl-layout__content';
// };
// $(selectorScroll).on('scroll', function(){
//     var paginaActual = 0;
//     isScroll = true;
//     clearTimeout(timeoutScroll);
//     timeoutScroll = setTimeout(function(){
//         isScroll = false;
//     }, delayScroll);
//     if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
//         if (subpag == 'insumos' || subpag == 'productos'){
//             if ($('#tabCategoria').is(':visible')){
//                 paginaActual = Number($('#hdPageCategoria').val());
//                 ListarCategorias(paginaActual);
//             }
//             else {
//                 if (subpag == 'insumos'){
//                     paginaActual = Number($('#hdPageInsumo').val());
//                     ListarInsumos(paginaActual);
//                 }
//                 else if (subpag == 'productos'){
//                     paginaActual = Number($('#hdPageArticulo').val());
//                     ListarArticulos(paginaActual);
//                 };
//             };
//         }
//         else {
//             paginaActual = Number($('#hdPageGeneral').val());
//             BuscarDatos(paginaActual);
//         };
//     };
// });
// $('input[data-input="search"]').on('keydown', function(event) {
//     if (event.keyCode == $.ui.keyCode.ENTER) {
//         if (subpag == 'insumos' || subpag == 'productos'){
//             if ($('#tabCategoria').is(':visible')){
//                 paginaCategoria = 1;
//                 ListarCategorias('1');
//             }
//             else {
//                 if (subpag == 'insumos'){
//                     paginaInsumo = 1;
//                     ListarInsumos('1');
//                 }
//                 else if (subpag == 'productos'){
//                     if ($('#tabPack').is(':visible')) {
//                         paginaGrupo = 1;
//                         ListarPacks('1');
//                     }
//                     else {
//                         paginaArticulo = 1;
//                         ListarArticulos('1');
//                     };
//                 };
//             };
//         }
//         else if (subpag == 'menu-hoy'){
//             if ($('#pnlListaCartas').is(':visible')){
//                 paginaCarta = 1;
//                 ListarCartas('1');
//             };
//         }
//         else {
//             paginaGeneral = 1;
//             BuscarDatos('1');
//         };
//         return false;
//     };
// }).on('keypress', function(event) {
//     if (event.keyCode == $.ui.keyCode.ENTER)
//         return false;
// });
// $('.m-search').on('click', '.helper-button', function(event) {
//     event.preventDefault();
//     $(this).parent().find('input:text[data-input="search"]').val('').focus();
// });
// $('button[data-type="search"]').on('click', function(event) {
//     event.preventDefault();
//     var selector = '';
//     if (subpag == 'insumos' || subpag == 'productos'){
//         if (subpag == 'insumos'){
//             selector = $('#tabCategoria').is(':visible') ? '#gvCategoria' : '#gvDatos';
//         }
//         else {
//             if ($('#tabCategoria').is(':visible')) {
//                 selector = '#gvCategoria';
//             }
//             else if ($('#tabPack').is(':visible')) {
//                 selector = '#gvPacks';
//             }
//             else {
//                 selector = '#gvDatos';
//             };
//         };
//     }
//     else if (subpag == 'menu-hoy'){
//         if ($('#pnlListaCartas').is(':visible')){
//             selector = '#gvCarta';
//         };
//     }
//     else {
//         selector = '#gvDatos';
//     };
//     showAppBar(selector, true, 'search');
// });
// }
function setSelect2() {}

function setDefaultSelection(selector) {
    var selector_selected = "";
    if ($(selector + " option:selected").length == 0) selector_selected = selector + " option:eq(0)"; else selector_selected = selector + " option:selected";
    $(selector).val($(selector_selected).val());
}

// function viewInExpandItem (item) {
//     var selectorFade = '.page:visible .mdl-layout__header-row';
//     $('.dato.expandable.is-expanded').removeClass('is-expanded');
//     $('.grouped-buttons').removeClass('fixed');
//     item.classList.add('is-expanded', 'expand-phone');
//     $(selectorFade).fadeOut(300);
// }
// function defaultBackEvent (handler_backbutton) {
//     _body.on('click touchend', '.back-button', handler_backbutton);
// }
// function initDragDrop (selectorMain) {
//     var selectorDroparea = '';
//     var selectedClass = 'selected';
//     var clickDelay = 600;
//     var lastClick;
//     var diffClick;
//     selectorDroparea = '#' + $(selectorMain).attr('data-droparea');
//     $(selectorMain + " .dato").bind('mousedown mouseup', function(e) {
//         if (e.type == "mousedown") {
//             lastClick = e.timeStamp;
//         }
//         else {
//             diffClick = e.timeStamp - lastClick;
//             if (diffClick < clickDelay) {
//                 $(this).toggleClass(selectedClass);
//             };
//         };
//     })
//     .draggable({
//         revertDuration: 10,
//         containment: '.page-region',
//         start: function(e, ui) {
//             ui.helper.addClass(selectedClass);
//             $(selectorDroparea).addClass('show');
//         },
//         stop: function(e, ui) {
//             $('.' + selectedClass).css({
//                 top: 0,
//                 left: 0
//             });
//             $(selectorDroparea).removeClass('show');
//         },
//         drag: function(e, ui) {
//             $('.' + selectedClass).css({
//                 top: ui.position.top,
//                 left: ui.position.left
//             });
//         }
//     });
//     $(selectorDroparea).droppable({
//         drop: function(e, ui) {
//             // $('.' + selectedClass).appendTo($(this)).add(ui.draggable) // ui.draggable is appended by the script, so add it after
//             // .removeClass(selectedClass).css({
//             //     top: 0,
//             //     left: 0
//             // });
//         }
//     });
// }
function initMasonry(selector, selectorWidth, selectorItem) {
    var elem = document.querySelector(selector);
    var msnry = new Masonry(elem, {
        columnWidth: selectorWidth,
        itemSelector: selectorItem,
        percentPosition: true
    });
}

function showOrHideCharmOptions(selector, state) {
    var charm_panel = document.querySelector(selector);
    var overlay = $(".overlay-charm");
    var isVisible = charm_panel.hasClass("is-visible");
    if (state == false) {
        if (isVisible) {
            charm_panel.removeClass("is-visible");
            overlay.style.display = "none";
        }
    } else {
        if (!isVisible) {
            charm_panel.addClass("is-visible");
            overlay.style.display = "block";
        }
    }
}

function randomString(length) {
    var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var result = "";
    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
    return result;
}

function inputNavigation(selector) {
    $(selector).on("keyup", ".mdl-textfield__input", function(event) {
        var _key = event.which || event.keyCode || 0;
        if (_key == 39 || _key == 37 || _key == 40 || _key == 38) {
            var _cell, _row, _containSibling, _containInput, _input;
            if (_key == 39 || _key == 37) {
                _cell = closest(this, "td");
                _containInput = _key == 39 ? _cell.nextSibling : _cell.previousSibling;
            } else if (_key == 40 || _key == 38) {
                _row = closest(this, "tr");
                _cell = closest(this, "td");
                var arrCells = [].slice.call(_cell.parentNode.getElementsByTagName("td"));
                var _indexCell = arrCells.indexOf(_cell);
                _containSibling = _key == 40 ? _row.nextSibling : _row.previousSibling;
                _containInput = _containSibling.getElementsByTagName("td")[_indexCell];
            }
            _input = _containInput.querySelector('input[type="text"]');
            if (_input != null) _input.focus();
        }
    });
}

function selectable(element_text, options) {
    var strhtml = "";
    var gridview = document.createElement("div");
    gridview.addClass("gridview selectable no-padding mdl-shadow--4dp white hide");
    strhtml += '<ul class="collection gridview-content no-margin no-border hide">';
    strhtml += "</ul>";
    strhtml += '<div class="empty-temp">';
    strhtml += '<h4 class="padding20 grey-text text-darken-4">No se encontraron resultados</h4>';
    strhtml += "</div>";
    gridview.innerHTML = strhtml;
    if (typeof options.container === "undefined") element_text.parentNode.appendChild(gridview); else {
        var container = document.getElementById(options.container);
        container.appendChild(gridview);
    }
    element_text.on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
    });
    element_text.on("focus", function(event) {
        gridview.removeClass("hide");
    });
    var pagina = 1;
    var data = {
        criterio: element_text.value,
        pagina: pagina
    };
    if (typeof options.data !== "undefined") data = $$.extend(data, options.data);
    element_text.on("keyup", function(event) {
        if (gridview.hasClass("hide")) gridview.removeClass("hide");
        data.criterio = this.value;
        $$.ajax({
            url: options.url,
            type: "GET",
            dataType: "json",
            data: data,
            success: options.successCallback,
            error: function(data) {
                console.log(data);
            }
        });
    });
}