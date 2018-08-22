$(function () {
    // inputNavigation('*#gvArticuloMenu tbody');
    // iniciarDbOrden();
    var screenmode = getParameterByName('screenmode');

    if (screenmode == 'cliente'){
        InitBuscarUbicacion();

        $('#btnActualizarCentro__OnEmpty, #btnActualizarCentro').on('click', function(event) {
            event.preventDefault();
            ListarCentros();
        });

        // $('#gvCentros').on('click', 'button[data-action="take-table"]', function(event) {
        //     event.preventDefault();
            
        //     var elem = getParentsUntil(this, '#gvCentros', '.dato');
        //     elem = elem[0];
            
        //     var _idempresa = elem.getAttribute('data-idempresa');
        //     var _idcentro = elem.getAttribute('data-idcentro');

        //     $('#hdIdEmpresa').val(_idempresa);
        //     $('#hdIdCentro').val(_idcentro);

        //     var data = new FormData();
        //     data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        //     data.append('hdIdCentro', $('#hdIdCentro').val());

        //     $.ajax({
        //         url: 'services/home/home-ajax-post.php',
        //         type: 'POST',
        //         dataType: 'json',
        //         data: data,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         success: function (data) {
        //             createSnackbar(data.titulomsje);

        //             if (data.rpta != '0') {
        //                 Ambientes(_idempresa, _idcentro);
        //             };
        //         },
        //         error: function (error) {
        //             console.log(error);
        //         }
        //     });            
        // });
    }
    else
        MostrarAmbientes();

    $('#btnChangeViewOrder').on('click', function(event) {
        event.preventDefault();

        var _button = this;

        if (_button.getAttribute('data-currentview') == 'articles') {
            _button.setAttribute('data-currentview', 'orders');
            _button.setAttribute('title', 'Ver articulos');
            _button.setAttribute('data-original-title', 'Ver articulos');
            
            $('#btnAddArticles').addClass('hide');
            
            $('#pnlOrdenArticulos .articulos').fadeOut(400, function() {
                $('#pnlOrdenArticulos .ordenes').fadeIn(400);
            });

            $(this).find('.i__orders').animate({
                opacity: 0
            }, 400, function() {
                $(_button).find('.i__articles').animate({
                    opacity: 1
                }, 400, $.noop());
            });
        }
        else {
            _button.setAttribute('data-currentview', 'articles');
            _button.setAttribute('title', 'Ver ordenes');
            _button.setAttribute('data-original-title', 'Ver ordenes');

            $('#pnlOrdenArticulos .ordenes').fadeOut(400, function() {
                $('#pnlOrdenArticulos .articulos').fadeIn(400, function () {
                    showMenuRestaurante();
                });
            });

            $(this).find('.i__articles').animate({
                opacity: 0
            }, 400, function() {
                $(_button).find('.i__orders').animate({
                    opacity: 1
                }, 400, $.noop());               
            });
        };

        $(_button).tooltip();
    });

    $('#txtBuscarArticulos').on('keyup', function(event) {
        showMenuRestaurante();
    });

    $('#btnHideSearchBarArticles').on('click', function(event) {
        event.preventDefault();
        $('#btnBuscarArticulo').removeClass('hide');
        $(this).addClass('hide');
        $('#barSearchArticulos').addClass('hide');
        $('#pnlViewAllArticles .view-button').removeClass('hide');
        $('#pnlViewAllArticles > .mdl-layout__header > .mdl-layout__header-row').removeClass('no-padding-right');
    });

    $('#btnBuscarArticulo').on('click', function(event) {
        event.preventDefault();
        $('#btnHideSearchBarArticles').removeClass('hide');
        $(this).addClass('hide');
        $('#barSearchArticulos').removeClass('hide');
        $('#pnlViewAllArticles .view-button').addClass('hide');
        $('#pnlViewAllArticles > .mdl-layout__header > .mdl-layout__header-row').addClass('no-padding-right');
    });

    $('#btnAgruparMesas').on('click', function(event) {
        event.preventDefault();
        AgruparMesas();
    });

    $('#btnSepararMesas').on('click', function(event) {
        event.preventDefault();
        MessageBox({
            content: '¿Desea separar las mesas?',
            width: '320px',
            height: '130px',
            buttons: [
                {
                    primary: true,
                    content: 'SEPARAR MESAS',
                    onClickButton: function (event) {
                        SepararMesas();
                    }
                }
            ],
            cancelButton: true
        });
    });

    $('#carousel-example-generic').on('slid.bs.carousel', function (event) {
        var _ambiente = event.relatedTarget;
        var _idambiente = _ambiente.getAttribute('data-idambiente');

        $('#hdIdAmbiente').val(_idambiente);
        
        ListarMesas(_idambiente);
        ListarMesasGroup(_idambiente);
    });

    $('#btnConfirmOrder').on('click', function(event) {
        event.preventDefault();
        ConfirmarOrden();
    });

    $('#btnRemoveOrder').on('click', function(event) {
        event.preventDefault();
        MessageBox({
            content: '¿Desea eliminar la orden seleccionada?',
            width: '320px',
            height: '130px',
            buttons: [
                {
                    primary: true,
                    content: 'Eliminar',
                    onClickButton: function (event) {
                        EliminarOrden();
                    }
                }
            ],
            cancelButton: true
        });
    });

    $('#btnLiberarMesas').on('click', function(event) {
        event.preventDefault();
        CambiarEstado('00');
    });

    $('#btnReservarMesas').on('click', function(event) {
        event.preventDefault();
        CambiarEstado('01');
    });

    $('#btnMesasBack').on('click', function(event) {
        event.preventDefault();
        gvMesas.removeSelection();
    });

    $('#btnMesasGroupBack').on('click', function(event) {
        event.preventDefault();
        gvMesasGroup.removeSelection();
    });

    $('#gvArticuloPack').on('click', 'ul.tabs a', function(event) {
        event.preventDefault();

        $('ul.tabs input:checkbox').prop('checked', false);
        $('#gvArticuloPack').find('.item-pack .list-group-item').removeClass('active');

        var elem = this;

        $(elem).find('input:checkbox').prop('checked', true);
        $(elem.getAttribute('href', 2)).find('.item-pack .list-group-item:first-child').addClass('active');
        
        // if ($('#gvOrdenes .mdl-grid .dato').length > 0)
        //     
        // else
        //     $('#btnAddArticles').addClass('hide');

        $('#btnAddArticles').removeClass('hide');

        var input_subarticulos = elem.getElementsByClassName('lista_subarticulos')[0];
        input_subarticulos.value = extraerSubArticulos(elem);

        habilitarControl('#txtCantidad', true);
        // $('#txtCantidad').focus();
    });

    $('#gvArticuloPack').on('click', '.list-group-item', function(event) {
        event.preventDefault();

        var _row = getParentsUntil(this, '#gvArticuloPack', '.panel-tab-menu');
        var _currentTab =  $('ul.tabs a[href="#' + _row[0].getAttribute('id') + '"]');

        if (_currentTab.find('input:checkbox')[0].checked) {
            var parent = getParentsUntil(this, '#gvArticuloPack', '.item-pack');
            
            $(parent).find('.list-group-item').removeClass('active');
            $(this).addClass('active');

            $('#btnAddArticles').removeClass('hide');

            var input_subarticulos = _currentTab.find('.lista_subarticulos');
            input_subarticulos.val(extraerSubArticulos(_currentTab[0]));

            // $('#txtCantidad').focus();
        };
    });

    // $('#gvArticuloPack').on('click', 'input:checkbox', function(event) {
    //     var elem = this;
    //     var _row = getParentsUntil(elem, '#gvArticuloPack', '.dato');
        
    //     // var _cantidad = Number(_row[0].getElementsByClassName('cantidad')[0].value);
    //     // var _precio = Number(_row[0].getElementsByClassName('precio')[0].value);
    //     // var _subtotal = _cantidad * _precio;

    //     var input_cantidad = _row[0].getElementsByClassName('cantidad')[0];
    //     // var inputPrecio = _row[0].getElementsByClassName('precio')[0];
    //     var input_subarticulos = _row[0].getElementsByClassName('lista_subarticulos')[0];

    //     habilitarControl(input_cantidad, this.checked);
        
    //     if (this.checked) {
    //         input_cantidad.focus();

    //         $('p, label, input:text', $(_row[0]).children('.panel-heading')).addClass('white-text');
    //         $(_row[0]).removeClass('panel-info').addClass('panel-primary').find('.item-pack .list-group-item:first-child').addClass('active');

    //         $('#btnAddArticles').removeClass('hide');

    //         input_subarticulos.value = extraerSubArticulos(_row[0]);
    //     }
    //     else {
    //         $('p, label, input:text', $(_row[0]).children('.panel-heading')).removeClass('white-text');
    //         $(_row[0]).addClass('panel-info').removeClass('panel-primary').find('.item-pack .list-group-item').removeClass('active');

    //         if ($('#gvArticuloPack input:checkbox:checked').length == 0)
    //             $('#btnAddArticles').addClass('hide');

    //         input_cantidad.value = '1';
    //         input_subarticulos.value = '';
    //     };
    // });

    // $('#gvArticuloPack').on('keyup', '.cantidad', function(event) {
    //     event.preventDefault();

    //     var _row = getParentsUntil(this, '#gvArticuloPack', '.dato');

    //     var input_precio = _row[0].getElementsByClassName('precio')[0];
    //     var input_subtotal = _row[0].getElementsByClassName('subtotal')[0];

    //     var cantidad = Number(this.value);
    //     var precio = Number(input_precio.value);
    //     var subtotal = precio * cantidad;
        
    //     input_subtotal.value = subtotal.toFixed(2);
    // });

	// carousel-example-generic.on('click', '.dato', function(event) {
	// 	event.preventDefault();        

 //        var item = this;

 //        if (event.type == 'touchend'){
 //            _endTime = new Date().getTime();
 //            _longpress = (_endTime - _startTime < 300) ? false : true;
 //        };

 //        if (_longpress){
 //            __selectElement(item, _selectedClass);
 //            _settings.onInitSelecting(event);
 //        }
 //        else {
 //            if (_container.getAttribute('data-multiselect') == 'true')
 //                __selectElement(item, _selectedClass);
 //            else {
 //                var listmesa = item.getAttribute('data-idmesa');
 //                var estadoatencion = item.getAttribute('data-state');

 //                $('#hdIdMesa').val(listmesa);

 //                if (typeof $('*#gvOrdenes .dato') != 'undefined')
 //                    $('* #gvOrdenes .dato').remove();

 //                addAtencion(listmesa, estadoatencion);
 //                Ordenes(item);
 //            };
 //        };
	// });

    $('#btnBackToRooms').on('click', function(event) {
        event.preventDefault();
        BackToRooms();
    });

    $('#pnlViewAllArticles').on('click', '.view-button', function(event) {
        event.preventDefault();

        var action = this.getAttribute('data-action');

        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');

        $('#btnAddArticles').addClass('hide');

        ListarAgregadosArticulo(action);
    });

    $('#gvArticuloMenu').on('click touchend', '.options-add > a[data-action="nothing"]', function(event) {
        event.stopPropagation();
    });

    $('#gvArticuloMenu').on('click touchend', '.options-add > a[data-action="addins"]', function(event) {
        event.preventDefault();
        event.stopPropagation();

        var parentItem = getParentsUntil(this, '#gvArticuloMenu', '.dato');
        var parent = this.parentNode;
        // var container = parent.getElementsByClassName('dropdown')[0];
        var tipomenudia = $('#pnlViewAllArticles .view-button.active').attr('data-tipomenudia');
        var idreferencia = tipomenudia + '_' + parentItem[0].getAttribute('data-idmodel');

        if (parent.classList.contains('fixed')){
            parent.classList.remove('fixed');
        }
        else {
            $('.options-add').removeClass('fixed');
            parent.classList.add('fixed');
            //ListarAgregadosArticulo(container, idreferencia);
        };
    });

    $('#gvArticuloMenu').on('click', '.check-addins', function(event) {
        //var idatencion = getCurrentIdAtencion();
        event.stopPropagation();
        //var tipomenudia = $('*#pnlViewAllArticles .view-button.active').getAttribute('data-tipomenudia');

        // if (this.checked)
        //     addAgregado(idatencion , tipomenudia, this.value);
        // else
        //     removeAgregado(idatencion , tipomenudia, this.value);
    });

    $('#gvArticuloMenu').on('keyup', '.precio', function(event) {
        var elem = this;
        var _row = getParentsUntil(elem, '#gvArticuloMenu', '.dato');
        
        var input_cantidad = _row[0].getElementsByClassName('cantidad')[0];
        var input_subtotal = _row[0].getElementsByClassName('subtotal')[0];

        var precio = Number(elem.value);
        var cantidad = Number(input_cantidad.value);
        var subtotal = precio * cantidad;
        
        input_subtotal.value = subtotal.toFixed(2);
    });

    $('#gvArticuloMenu').on('keyup', '.cantidad', function(event) {
        var elem = this;
        var _row = getParentsUntil(elem, '#gvArticuloMenu', '.dato');
        
        var input_precio = _row[0].getElementsByClassName('precio')[0];
        var input_subtotal = _row[0].getElementsByClassName('subtotal')[0];

        var precio = Number(input_precio.value);
        var cantidad = Number(elem.value);
        var subtotal = precio * cantidad;
        
        input_subtotal.value = subtotal.toFixed(2);
    });

    $('*#gvArticuloMenu tbody').on('click', '.check-articulo', function (event) {
        event.stopPropagation();
        handlerRowCheck(this, '#gvArticuloMenu', event);
    });
    
    $('*#gvArticuloMenu tbody').on('click', 'tr', function (event) {
        handlerRowCheck(this, '#gvArticuloMenu', event);
    });

    $('*#gvArticuloMenu tbody').on('click focus', 'tr .mdl-textfield__input', function (event) {
        if (event.type == 'click')
            event.stopPropagation();
        else
            this.select();
    });

    $('#btnAddArticles').on('click', function(event) {
        event.preventDefault();
        nuevaOrden();
    });

    // $('#btnNuevaOrden').on('click', function(event) {
    //     event.preventDefault();
    //     nuevaOrden();
    // });

    $('#gvOrdenes').on('click', 'button', function(event) {
        event.preventDefault();
        if (this.getAttribute('data-action') == 'delete')
            eliminarArticulo(this);
    });

    $('#btnPayOrder').on('click', function(event) {
        event.preventDefault();

        var caja_id = config['caja'].id;
        var enlace = window.top.document.querySelector('.mdl-card[data-id="' + caja_id + '"]');

        window.top.navigateInFrame('00', enlace, function (_fd) {
            var id_orden = $('#hdIdAtencion').val();

            _fd.getOrden(id_orden);
        });
    });
});

// var _startTime;
// var _endTime;
// var _longpress = false;

var hdIdEmpresa = $('#hdIdEmpresa');
var hdIdCentro = $('#hdIdCentro');
var pnlOrden = $('#pnlOrden');
var pnlMesas = $('#pnlMesas');

var arrAgregado = [];

var gvMesas;
var gvMesasGroup;

// var gvOrdenes = new DataList('#gvOrdenes', {
//     onSearch: function () {
//     },
//     onInitSelecting: function (event) {
//         clearOneSelectedOrder();
//     },
//     oneItemClick: function (event) {
//         event.preventDefault();
//         event.stopPropagation();

//         var elem = event.target;
//         var item = getParentsUntil(elem, '#gvOrdenes', '.dato');
        
//         item = item[0];
//         clearOneSelectedOrder();
        
//         item.classList.add('oneSelected');

//         var id_orden = item.getAttribute('data-idorden');
//         $('#hdIdAtencion').val(id_orden);

//         $('#btnAddArticles, #btnRemoveOrder').removeClass('hide');

//         if (item.getElementsByClassName('item-list').length > 0)
//             $('#btnPayOrder, #btnConfirmOrder').removeClass('hide');
//         else
//             $('#btnPayOrder, #btnConfirmOrder').addClass('hide');
//     }
// });

var extraerSubArticulos = function (_row) {
    var _idSubArticulos = $(_row.getAttribute('href', 2)).find('.list-group-item.active').map(function(){
        return this.getAttribute('data-idproducto');
    }).get().join(',');

    return _idSubArticulos;
};

var handlerRowCheck = function  (_this, selectorgrid, event) {
    if ((event.target || {}).type !== 'textbox') {
        var _checkbox = _this;
        var _showAppbar = true;
        var _parent;
        var selector_checkbox = '';

        if (selectorgrid == '#gvArticuloMenu')
            selector_checkbox = '.check-articulo';
        
        if ((_this || {}).type !== 'checkbox') {
            event.preventDefault();
            
            _parent = _this;
            _checkbox = _this.querySelector(selector_checkbox);
            
            if (_checkbox != null) {
                _checkbox.checked = !_checkbox.checked;
                _checkbox.parentNode.MaterialCheckbox.checkToggleState();
            };
        }
        else {
            if (selectorgrid == '#gvArticuloMenu') {
                if (_checkbox.classList.contains(check-articulo.substring(1))) {
                    _parent = getParentsUntil(_checkbox, selectorgrid, 'tr');
                };
            }
            else {
                _parent = getParentsUntil(_checkbox, selectorgrid, 'tr');
            };

            _parent = _parent[0];
        };

        if (_parent != null) {
            if (selectorgrid == '#gvArticuloMenu') {
                var inputStock = _parent.getElementsByClassName('cantidad')[0];
                var inputPrecio = _parent.getElementsByClassName('precio')[0];
                var inputObservacion = _parent.getElementsByClassName('observacion')[0];
                // var showAddings = _parent.getElementsByClassName('show-addins')[0];
            
                habilitarControl([inputStock], _checkbox.checked);

                if (_checkbox.checked) {
                    _parent.classList.add('selected');
                    //_showAppbar = true;
                    
                    // inputPrecio.parentNode.classList.remove('is-disabled');
                    inputStock.parentNode.classList.remove('is-disabled');
                    // showAddings.setAttribute('data-action', 'addins');

                    inputObservacion.classList.remove('hide');
                    $('#btnAddArticles').removeClass('hide');

                    inputStock.focus();
                }
                else {
                    _parent.classList.remove('selected');
                    
                    inputStock.parentNode.classList.add('is-disabled');
                    // inputPrecio.parentNode.classList.add('is-disabled');

                    inputObservacion.classList.add('hide');
                    
                    // showAddings.setAttribute('data-action', 'nothing');

                    if ($(selectorgrid).find('.selected').length == 0)
                        $('#btnAddArticles').addClass('hide');
                };
                //gvArticuloMenu.showAppBar(_showAppbar, 'edit');
            };
        };
    };
};

//*** DATABASE_LOCAL ***//

// var indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || window.msIndexedDB;
// var dataBase;

// function tmpAtencion_crear (active) {
//     object = active.createObjectStore("atencion", { keyPath : 'idatencion', autoIncrement : true });
//     object.createIndex('by_idatencion', 'idatencion', { unique : true });
//     object.createIndex('by_nroatencion', 'nroatencion', { unique : false });
//     object.createIndex('by_listmesa', 'listmesa', { unique : false });
//     object.createIndex('by_estadoatencion', 'estadoatencion', { unique : false });
//     object.createIndex('by_iscurrent', 'iscurrent', { unique : false });
// }

// function tmpAgregadoArticulo_crear (active) {
//     object = active.createObjectStore("agregados_articulos", { keyPath : 'idagregado', autoIncrement : true });
//     object.createIndex('by_idagregado', 'idagregado', { unique : true });
//     object.createIndex('by_idatencion', 'idatencion', { unique : false });
//     object.createIndex('by_tipomenudia', 'tipomenudia', { unique : false });
//     object.createIndex('by_idproducto', 'idproducto', { unique : false });
// }

// function iniciarDbOrden () {
//     indexedDB.deleteDatabase('dbOrden');

//     dataBase = indexedDB.open('dbOrden', 1);

//     dataBase.onupgradeneeded = function (e) {
//         var active = dataBase.result;

//         tmpAtencion_crear(active);
//         tmpAgregadoArticulo_crear(active);
//     };

//     dataBase.onsuccess = function (e) {
//         console.log('Base de datos cargada correctamente');
//     };

//     dataBase.onerror = function (e)  {
//         console.log('Error cargando la base de datos');
//     };
// }
// function getCurrentIdAtencion () {
//     var active = dataBase.result;
//     var data = active.transaction(["atencion"], "readwrite");
//     var object = data.objectStore("atencion");
    
//     var nroatencion = '';

//     return nroatencion;
// }

// function addAtencion (listmesa, estadoatencion) {
//     var active = dataBase.result;
//     var data = active.transaction(["atencion"], "readwrite");
//     var object = data.objectStore("atencion");
    
//     var countRequest = object.count();
//     var nroatencion = '';
      
//     countRequest.onsuccess = function() {
//         nroatencion = 'TMP' + zeroFill(countRequest.result + 1, 6);
        
//         var request = object.put({
//             nroatencion: nroatencion,
//             listmesa: listmesa,
//             estadoatencion: estadoatencion,
//             iscurrent: true
//         });
        
//         request.onerror = function (e) {
//             console.log(request.error.name + '\n\n' + request.error.message);
//         };

//         data.oncomplete = function (e) {
//             console.log('Objeto agregado correctamente');
//         };
//     };
// }

// function validarAgregado (idatencion, tipomenudia, idproducto) {
//     var active = dataBase.result;
//     var data = active.transaction(["agregados_articulos"], "readonly");
//     var object = data.objectStore("agregados_articulos");

//     var elements = [];
//     var valid = false;

//     object.openCursor().onsuccess = function (e) {
//         var result = e.target.result;

//         if (result === null)
//             return;

//         elements.push(result.value);
//         result.continue();
//     };

//     data.oncomplete = function () {
//         for (var key in elements) {
//             if (idatencion == elements[key].idatencion && tipomenudia == elements[key].tipomenudia && idproducto == elements[key].idproducto) {
//                 valid = true;
//                 break;
//             };
//         };

//         elements = [];
//     };

//     return valid;
// }

// function addAgregado (idatencion, tipomenudia, idproducto) {
//     var active = dataBase.result;
//     var data = active.transaction(["agregados_articulos"], "readwrite");
//     var object = data.objectStore("agregados_articulos");
//     // var countRequest = object.count();
    
//     // countRequest.onsuccess = function() {
//         // var contarItems = countRequest.result;
        
//     if (!validarAgregado(idatencion, tipomenudia, idproducto)) {
//         //contarItems++;
//         var request = object.put({
//             idatencion: idatencion,
//             tipomenudia: tipomenudia,
//             idproducto: idproducto
//         });

//         request.onerror = function (e) {
//             console.log(request.error.name + '\n\n' + request.error.message);
//         };

//         data.oncomplete = function (e) {
//             console.log('Objeto agregado correctamente');
//         };
//     };
//     // };
// }

// function removeAgregado (idatencion, tipomenudia, idproducto) {
//     var active = dataBase.result;
//     var data = active.transaction(["agregados_articulos"], "readonly");
//     var object = data.objectStore("agregados_articulos");
//     var elements = [];
//     var idagregado = '0';

//     object.openCursor().onsuccess = function (e) {
//         var result = e.target.result;

//         if (result === null)
//             return;

//         elements.push(result.value);
//         result.continue();
//     };

//     data.oncomplete = function () {
//         for (var key in elements) {
//             if (idatencion == elements[key].idatencion && tipomenudia == elements[key].tipomenudia && idproducto == elements[key].idproducto) {
//                 idagregado = elements[key].idagregado;
//                 break;
//             };
//         };

//         elements = [];
//     };

//     if (idagregado != '0') {
//         var t = db.transaction(["agregados_articulos"], "readwrite");
//         var request = t.objectStore("agregados_articulos").delete(idagregado);
        
//         t.oncomplete = function(event) {
            
//         };
//     };
// }

//*** END DATABASE_LOCAL ***//

function MostrarMesas__onupdate () {

    MostrarMesas (true);
}

function MostrarAmbientes (idempresa, idcentro) {

    var _idempresa = typeof idempresa !== 'undefined' ? idempresa : $('#hdIdEmpresa').val();
    var _idcentro = typeof idcentro !== 'undefined' ? idcentro : $('#hdIdCentro').val();

    $.ajax({
        url: 'services/ambientes/ambientes-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: _idempresa,
            idcentro: _idcentro,
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';

            if (countdata > 0) {
                while (i < countdata) {
                    strhtml += '<div data-idambiente="' + data[i].tm_idambiente + '" class="item' + ((i == 0) ? ' active' : '') + ' all-height"><div class="generic-panel gp-no-footer"><div class="gp-header"><h3 class="text-center">' + data[i].tm_nombre + '</h3></div>';
                    
                    strhtml += '<div class="gp-body">'; // start body slide

                    strhtml += '<div class="mdl-grid mdl-grid--no-spacing all-height">'; // start grid content slide

                    strhtml += '<div class="mdl-cell mdl-cell--6-col all-height">'; // start 1st column slide

                    strhtml += '<div class="mesas scrollbarra" class="gridview all-height" data-selected="none" data-multiselect="false" data-actionbar="mesas-actionbar"><div class="gridview-container mdl-grid"></div></div>';

                    strhtml += '</div>'; // end 1st column slide

                    strhtml += '<div class="mdl-cell mdl-cell--6-col">'; // start 2st column slide

                    strhtml += '<div class="grupos scrollbarra" class="gridview all-height" data-selected="none" data-multiselect="false" data-actionbar="grupos-actionbar"><div class="gridview-container mdl-grid"></div></div>';

                    strhtml += '</div>'; // end 2st column slide

                    strhtml += '</div>'; // end grid content slide

                    strhtml += '</div>'; // end body slide

                    strhtml += '</div>';

                    strhtml += '</div>';
                    
                    ++i;
                };
            };

            $('.carousel-inner').html(strhtml);

            $('.carousel').carousel({
                interval: false,
                wrap: true,
                keyboard: true
            });

            initGvMesas();
            initGvMesasGroup();

            MostrarMesas();
        },
        error: function (error) {
            console.log(error);
        }
    });
}

// function clearOneSelectedOrder () {
//     $('*#gvOrdenes .dato').removeClass('oneSelected');
// }

function buildMenu (data, pagina) {
    var strhtml = '';
    var i = 0;
    var countdata = data.length;
    var selector = '*#gvArticuloMenu tbody';
    var counter_agregado = 0;

    if (countdata > 0){
        while(i < countdata){
            var precio = Number(data[i].td_precio);
            
            strhtml += '<tr data-idmodel="' +  data[i].tm_idproducto + '" class="dato">';

            strhtml += '<td><label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkDetalle' + i + '"><input name="mc_articulo[' + i + '][idproducto]" type="checkbox" id="chkDetalle' + i + '" class="mdl-checkbox__input check-articulo" value="' +  data[i].tm_idproducto + '"><span class="mdl-checkbox__label"></span></label><input name="mc_articulo[' + i + '][iddetalle]" type="hidden" id="iddetalle' + i + '" value="0" /></td>';

            strhtml += '<td data-title="Articulo" class="v-align-middle nombre-articulo">' + data[i].nombreProducto;

            strhtml += '<input type="hidden" class="subtotal" name="mc_articulo[' + i + '][subtotal]" id="subtotal' + i + '" value="' + precio.toFixed(2) + '" />';

            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield no-padding full-size"><input class="mdl-textfield__input observacion hide" type="text" name="mc_articulo[' + i + '][observacion]" id="observacion' + i + '" placeholder="Ingresa aqu&iacute; m&aacute;s detalles sobre el art&iacute;culo" value=""><label class="mdl-textfield__label" for="observacion' + i + '"></label></div>';

            strhtml += '</td>';
            
            strhtml += '<td data-title="Cantidad">';
            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield no-padding full-size"><input disabled class="mdl-textfield__input align-right cantidad" type="number" step="any" name="mc_articulo[' + i + '][cantidad]" id="cantidad' + i + '" value="1"><label class="mdl-textfield__label" for="cantidad' + i + '"></label></div>';

            strhtml += '</td>';
            strhtml += '<td data-title="Precio">';

            strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield no-padding full-size"><input readonly class="mdl-textfield__input align-right precio" type="text" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + precio.toFixed(2) + '"><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';
            
            strhtml += '</td>';

            // strhtml += '<td class="options-add pos-rel"><a class="padding5 mdl-button mdl-button--icon tooltipped show-addins" href="#" data-action="nothing" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';

            // strhtml += '<ul class="dropdown">';

            // var cadd = 0;
            
            // if (arrAgregado.length > 0) {
            //     while(cadd < arrAgregado.length){
            //         counter_agregado += i;
                    
            //         strhtml += '<li class="padding10"><label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkAgregado' + counter_agregado + '"><input type="checkbox" id="chkAgregado' + counter_agregado + '" class="mdl-checkbox__input check-addins" value="' + arrAgregado[cadd].tm_idproducto + '"><span class="mdl-checkbox__label">' + arrAgregado[cadd].tm_nombre + '</span></label></li>';

            //         ++cadd;
            //     };
            // };

            // strhtml += '</ul>';
            // strhtml += '</td>';
            strhtml += '</tr>';
            ++i;
        };

        // paginaDetalle = paginaDetalle + 1;

        // $('#hdPageDetalle').val(paginaDetalle);

        if (pagina == '1'){
            $(selector).html(strhtml);
            // $('#pnlViewAllArticles').removeClass('hide');
        }
        else
            $(selector).append(strhtml);

        //$(selector).enableCellNavigation();
        registerScriptMDL(selector + ' .mdl-input-js');
    }
    else {
        if (pagina == '1') {
            $(selector).html('');
        };
    };
}

function ListarArticulos_Individual (pagina) {
    var criterio = $('#txtBuscarArticulos').val();

    precargaExp('#pnlOrden', true);

    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            tipomenu: '01',
            idgrupo: 0,
            criterio: criterio,
            pagina: pagina
        },
        success: function(data){
            buildMenu(data, pagina);

            precargaExp('#pnlOrden', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarArticulos_Carta (pagina) {
    var criterio = $('#txtBuscarArticulos').val();

    precargaExp('#pnlOrden', true);
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '2',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            tipomenu: '00',
            idcarta: 0,
            criterio: criterio,
            pagina: pagina
        },
        success: function(data){
            buildMenu(data, pagina);

            precargaExp('#pnlOrden', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

var extract_secciones = function (group) {
    var groups_seccion = _.groupBy(group, function(value){
        return value.tp_idseccionpack + '#' + value.td_nombreseccion;
    });

    var second_data = _.map(groups_seccion, function(group_seccion){
        return {
            tp_idseccionpack: group_seccion[0].tp_idseccionpack,
            td_nombreseccion: group_seccion[0].td_nombreseccion,
            list_articulos: group_seccion
        };
    });

    return second_data;
};

function ListarArticulos_Menu (pagina) {
    var criterio = $('#txtBuscarArticulos').val();

    precargaExp('#pnlOrden', true);

    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            tipomenu: '03',
            idgrupo: 0,
            criterio: criterio,
            pagina: pagina
        },
        success: function(result){
            var i = 0;
            var strhtml = '';
            var count_articulos = 0;
            var selector = '#gvArticuloPack';
            var counter_agregado = 0;

            var strhtml_tabs_packs = '';
            var strhtml_panels_packs = '';            
            
            var groups = _.groupBy(result, function(value){
                return value.tm_idgrupoarticulo + '#' + value.nombrepack + '#' + value.tm_idmoneda + '#' + value.simboloMoneda + '#' + value.td_precio;
            });
            
            var data = _.map(groups, function(group){
                return {
                    tm_idgrupoarticulo: group[0].tm_idgrupoarticulo,
                    nombrepack: group[0].nombrepack,
                    tm_idmoneda: group[0].tm_idmoneda,
                    simboloMoneda: group[0].simboloMoneda,
                    td_precio: group[0].td_precio,
                    list_secciones: extract_secciones(group)
                };
            });

            var countdata = data.length;

            console.log(countdata);

            if (countdata > 0){
                while (i < countdata){
                    var j = 0;
                    var secciones = data[i].list_secciones;
                    var count_secciones = 0;

                    if (secciones.length == 1){
                        if (secciones[0].td_nombreseccion.trim().length == 0)
                            count_secciones = 0;
                        else
                            count_secciones = 1;
                    }
                    else
                        count_secciones = secciones.length;

                    if (count_secciones > 0){
                        strhtml_tabs_packs += '<li class="tab col s3">';
                        strhtml_tabs_packs += '<a href="#tab_menu' + data[i].tm_idgrupoarticulo + '" class="dato">' + data[i].nombrepack + ' (' + data[i].simboloMoneda + ' ' + data[i].td_precio + ')';
                        
                        strhtml_tabs_packs += '<input type="checkbox" class="hide" name="mc_menuarticulo[' + i + '][idproducto]" id="chkDetalleMenu' + i + '" value="' + data[i].tm_idgrupoarticulo + '" />';
                        strhtml_tabs_packs += '<input type="hidden" id="lista_subarticulos' + i + '" name="mc_menuarticulo[' + i + '][lista_subarticulos]" class="lista_subarticulos" value="">';

                        strhtml_tabs_packs += '<input type="hidden" id="precio_menu' + i + '" name="mc_menuarticulo[' + i + '][precio]" class="precio" value="' + data[i].td_precio + '">';
                        strhtml_tabs_packs += '<input type="hidden" id="subtotal_menu' + i + '" name="mc_menuarticulo[' + i + '][subtotal]" class="subtotal" value="' + data[i].td_precio + '">';

                        strhtml_tabs_packs += '</a>';
                        strhtml_tabs_packs += '</li>';

                        strhtml_panels_packs += '<div id="tab_menu' + data[i].tm_idgrupoarticulo + '" class="panel-tab-menu col s12">';

                        while (j < count_secciones){
                            if (typeof secciones[j] !== 'undefined'){
                                strhtml_panels_packs += '<div class="panel panel-info item-pack">';
                                strhtml_panels_packs += '<div class="panel-heading"><h3 class="panel-title">' + secciones[j].td_nombreseccion + '</h3></div>';

                                var k = 0;
                                var articulos = secciones[j].list_articulos;
                                var count_articulos = 0;

                                if (articulos.length == 1){
                                    if (articulos[0].nombreProducto.trim().length == 0)
                                        count_articulos = 0;
                                    else
                                        count_articulos = 1;
                                }
                                else
                                    count_articulos = articulos.length;

                                strhtml_panels_packs += '<div class="panel-body no-padding"><ul class="list-group no-margin no-padding">';
                                
                                if (count_articulos > 0){
                                    while (k < count_articulos){
                                        strhtml_panels_packs += '<a data-idproducto="' + articulos[k].tm_idproducto  + '" href="#" class="list-group-item">' + articulos[k].nombreProducto + '</a>';
                                        ++k;
                                    };

                                };
                                
                                strhtml_panels_packs += '</ul></div></div>';
                            };
                            ++j;
                        };

                        strhtml_panels_packs += '</div>';
                    };

                    ++i;
                };

                strhtml += '<div class="gp-header">';
                strhtml += '<ul class="tabs">';
                strhtml += strhtml_tabs_packs;
                strhtml += '</ul>';
                strhtml += '</div>';
                strhtml += '<div class="gp-body"><div class="scrollbarra padding10">';
                strhtml += strhtml_panels_packs;
                strhtml += '</div></div>';
                strhtml += '<div class="gp-footer">';
                
                strhtml += '<div class="col-md-12">';
                strhtml += '<div class="input-field right">';
                strhtml += '<label for="txtCantidad">Cantidad</label>';
                strhtml += '<input type="number" id="txtCantidad" name="txtCantidad" disabled class="validate text-right" value="1">';
                strhtml += '</div>';
                strhtml += '</div>';

                strhtml += '<div class="col-md-9 hide">';
                strhtml += '<div class="input-field">';
                strhtml += '<label for="txtObservacion">Observaciones</label>';
                strhtml += '<input type="text" id="txtObservacion" class="validate text-right">';
                strhtml += '</div>';
                strhtml += '</div>';
                strhtml += '</div>';
                // while(i < countdata){
                //     strhtml += '<div class="dato panel panel-info">';
                //     strhtml += '<div class="panel-heading no-padding">';
                //     strhtml += '<div class="mdl-grid">';
                    
                //     strhtml += '<div class="mdl-cell--6-col">';
                //      strhtml += '<p class="padding10"><input type="checkbox" class="filled-in" name="mc_menuarticulo[' + i + '][idproducto]" id="chkDetalleMenu' + i + '" value="' + data[i].tm_idgrupoarticulo + '" />';
                //     strhtml += '<label for="chkDetalleMenu' + i + '">' + data[i].nombrepack + '</label></p>';
                //     strhtml += '</div>';

                //     strhtml += '<div class="mdl-cell mdl-cell--3-col">';
                //     strhtml += '<div class="form-group no-margin">';
                //     strhtml += '<label for="cantidad_menu' + i + '" class="text-right full-size">Cantidad</label>';
                //     strhtml += '<input type="number" step="any" id="cantidad_menu' + i + '" name="mc_menuarticulo[' + i + '][cantidad]" disabled class="align-right no-margin cantidad"  value="1" style="height: 34px;">';
                //     strhtml += '</div>';

                //     strhtml += '</div><div class="mdl-cell mdl-cell--3-col">';
                //     strhtml += '<div class="form-group no-margin">';
                //     strhtml += '<label for="precio_menu' + i + '" class="text-right full-size">Precio</label>';
                //     strhtml += '<h4 class="text-right">' + data[i].td_precio + '</h4><input type="hidden" id="precio_menu' + i + '" name="mc_menuarticulo[' + i + '][precio]" class="precio" value="' + data[i].td_precio + '"><input type="hidden" id="subtotal_menu' + i + '" name="mc_menuarticulo[' + i + '][subtotal]" class="subtotal" value="' + data[i].td_precio + '">';
                //     strhtml += '</div>';
                //     strhtml += '</div>';

                //     strhtml += '</div>';
                //     strhtml += '</div>';

                //     strhtml += '<div class="panel-body" style="height: 265px;"><div class="scrollbarra-x padding10">';
                //     strhtml += '<input type="hidden" id="lista_subarticulos' + i + '" name="mc_menuarticulo[' + i + '][lista_subarticulos]" class="lista_subarticulos" value="">';

                //     var j = 0;
                //     var secciones = data[i].list_secciones;
                //     var count_secciones = 0;

                //     if (secciones.length == 1){
                //         if (secciones[0].td_nombreseccion.trim().length == 0)
                //             count_secciones = 0;
                //         else
                //             count_secciones = 1;
                //     }
                //     else
                //         count_secciones = secciones.length;

                //     if (count_secciones > 0){
                //         while (j < count_secciones){
                //             if (typeof secciones[j] !== 'undefined'){
                //                 strhtml += '<div class="panel panel-default item-pack" data-idseccion="' + secciones[j].tp_idseccionpack + '">';
                //                 strhtml += '<div class="panel-heading"><h3 class="panel-title">' + secciones[j].td_nombreseccion + '</h3></div>';
                //                 strhtml += '<div class="panel-body no-padding" style="height: 170px;"><div class="scrollbarra padding10">';
                //                 strhtml += '<ul class="list-group no-margin no-padding">';

                //                 var k = 0;
                //                 var articulos = secciones[j].list_articulos;
                //                 var count_articulos = 0;

                //                 if (articulos.length == 1){
                //                     if (articulos[0].nombreProducto.trim().length == 0)
                //                         count_articulos = 0;
                //                     else
                //                         count_articulos = 1;
                //                 }
                //                 else
                //                     count_articulos = articulos.length;

                //                 if (count_articulos > 0){
                //                     while (k < count_articulos){
                //                         strhtml += '<a data-idproducto="' + articulos[k].tm_idproducto  + '" href="#" class="list-group-item">' + articulos[k].nombreProducto + '</a>';
                //                         ++k;
                //                     };
                //                 };

                //                 strhtml += '</ul></div></div></div>';
                //             };

                //             ++j;
                //         };
                //     };

                //     // strhtml += '<td class="options-add pos-rel"><a class="padding5 mdl-button mdl-button--icon tooltipped show-addins" href="#" data-action="nothing" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';

                //     // strhtml += '<ul class="dropdown">';

                //     // var cadd = 0;
                    
                //     // if (arrAgregado.length > 0) {
                //     //     while(cadd < arrAgregado.length){
                //     //         counter_agregado += i;
                            
                //     //         strhtml += '<li class="padding10"><label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkAgregado' + counter_agregado + '"><input type="checkbox" id="chkAgregado' + counter_agregado + '" class="mdl-checkbox__input check-addins" value="' + arrAgregado[cadd].tm_idproducto + '"><span class="mdl-checkbox__label">' + arrAgregado[cadd].tm_nombre + '</span></label></li>';

                //     //         ++cadd;
                //     //     };
                //     // };

                //     // strhtml += '</ul>';

                //     strhtml += '</div></div>';

                //     strhtml += '<div class="panel-footer">';
                //     strhtml += '<div class="input-group">';
                //     strhtml += '<span class="input-group-addon" id="observacion_addon_menu' + i + '">Observaciones</span>';
                //     strhtml += '<input type="text" class="form-control" id="observacion_menu' + i + '" name="mc_menuarticulo[' + i + '][observacion]" aria-describedby="observacion_addon_menu">';

                //     strhtml += '</div></div>';

                //     strhtml += '</div>';

                //     ++i;
                // };

                
                $(selector).html(strhtml);

                $('ul.tabs').tabs().find('a:first').trigger('click');


                //$(selector).enableCellNavigation();
            }
            else {
                if (pagina == '1')
                    $(selector).html('');
            };

            precargaExp('#pnlOrden', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function showMenuRestaurante () {
    var tipomenudia = $('#pnlViewAllArticles .view-button.active').attr('data-action');
            
    if (tipomenudia == 'view-menu')
        ListarArticulos_Menu('1');
    else if (tipomenudia == 'view-card')
        ListarArticulos_Carta('1');
    else
        ListarArticulos_Individual('1');
}

function Ambientes (idempresa, idcentro) {
    $('#pnlLocal').fadeOut(300, function () {        
        $('#pnlMesas').fadeIn(300, function () {
            // $('#pnlOrden > .gp-header .mdl-layout-title').text('Mesa: ' + nombremesa);
            MostrarAmbientes(idempresa, idcentro);
        });
    });
}

function Ordenes (idatencion, nombremesa) {
	pnlMesas.fadeOut(300, function () {
		pnlOrden.removeClass('hide');
		
        pnlOrden.fadeIn(300, function () {
            $('#pnlOrden > .gp-header .mdl-layout-title').text('Mesa: ' + nombremesa);

            showMenuRestaurante();
            // ListarOrdenes();
            listarDetalle(idatencion);
		});
	});
}

function MostrarMesas (preload_overlayer) {
	var currentAmbiente = $('#carousel-example-generic').find('.item.active');
    var idambiente = currentAmbiente.attr('data-idambiente');
    $('#hdIdAmbiente').val(idambiente);

    if (typeof preload_overlayer !== 'undefined'){
        precarga_OverLayer('.page-region', true, {
            mensaje: 'Las mesas se están actualizando, espere unos minutos...'
        });
    };

    ListarMesas(idambiente, preload_overlayer);
	ListarMesasGroup(idambiente, preload_overlayer);
}

function ListarMesas (idambiente, preload_overlayer) {
    var parentSelector = '#carousel-example-generic .item[data-idambiente="' + idambiente + '"]';
    var selector = parentSelector + ' .mesas .gridview-container';
    
    precargaExp(parentSelector, true);
    
    $.ajax({
        url: 'services/ambientes/mesas-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'GROUP-MESAS',
            tipo: '1U',
            idambiente: idambiente
        },
        success: function (data) {
            var strhtml = '';
            var i = 0;
            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<div class="dato mdl-cell mdl-cell--3-col mdl-cell--2-col-phone pos-rel mdl-card" ';
                    strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                    strhtml += 'data-nroatencion="' + data[i].tm_nroatencion + '" ';
                    strhtml += 'data-idmesa="' + data[i].idgrupomesa + '" ';
                    strhtml += 'data-tipomesa="' + data[i].ta_tipomesa + '" ';
                    strhtml += 'data-state="' + data[i].estadomesa_group + '" ';
                    strhtml += 'style="background-color: ' + data[i].color_leyenda_group + ';">';

                    strhtml += '<input type="checkbox" name="chkMesa[]" value="' + data[i].idgrupomesa + '" />'
                    strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';
                    strhtml += '<div style="width: 64px; height:48px;" class="centered"><h1 class="text-center white-text nombremesa">' + data[i].codigo_group + '</h1></div>';
                    strhtml += '</div>';

                    ++i;
                };
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';
            
            $(selector).html(strhtml);
            precargaExp(parentSelector, false);

            if (typeof preload_overlayer !== 'undefined')
                precarga_OverLayer('.page-region', false);
        },
        error: function (error) {
            console.log(error);
        }
    });

}

function ListarMesasGroup (idambiente, preload_overlayer) {
	var parentSelector = '#carousel-example-generic .item[data-idambiente="' + idambiente + '"]';
    var selector = parentSelector + ' .grupos .gridview-container';
    
    precargaExp(parentSelector, true);

    $.ajax({
        url: 'services/ambientes/mesas-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'GROUP-MESAS',
            tipo: '1G',
            idambiente: idambiente
        },
        success: function (result) {
            var strhtml = '';
            var i = 0;

            var groups = _.groupBy(result, function(value){
                return value.idgrupomesa + '#' + value.ta_tipomesa + '#' + value.codigo_group + '#' + value.comensales_group + '#' + value.estadomesa_group + '#' + value.color_leyenda_group;
            });
            
            var data = _.map(groups, function(group){
                return {
                    tm_idatencion: group[0].tm_idatencion,
                    tm_nroatencion: group[0].tm_nroatencion,
                    idgrupomesa: group[0].idgrupomesa,
                    ta_tipomesa: group[0].ta_tipomesa,
                    codigo_group: group[0].codigo_group,
                    comensales_group: group[0].comensales_group,
                    estadomesa_group: group[0].estadomesa_group,
                    color_leyenda_group: group[0].color_leyenda_group,
                    list_mesas: group
                }
            });

            var countdata = data.length;

            if (countdata > 0){
                while(i < countdata){
                    var list_mesas = '';
                    var count_mesas = 0;
                    var j = 0;

                    if (data[i].codigo_group.trim().length > 0)
                        list_mesas = data[i].codigo_group;
                    else {
                        if (mesas.length == 1){
                            if (mesas[0].tm_codigo.trim().length == 0)
                                count_mesas = 0;
                            else
                                count_mesas = mesas.length;
                        }
                        else
                            count_mesas = mesas.length;
                        
                        if (count_mesas > 0){
                            while (j < count_mesas){
                                list_mesas += mesas[j].tm_codigo;
                                ++j;
                            };
                        };
                    };

                    strhtml += '<div class="dato mdl-cell mdl-cell--6-col mdl-cell--6-col-phone pos-rel mdl-card" ';
                    strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                    strhtml += 'data-nroatencion="' + data[i].tm_nroatencion + '" ';
                    strhtml += 'data-idmesa="' + data[i].idgrupomesa + '" ';
                    strhtml += 'data-tipomesa="' + data[i].ta_tipomesa + '" ';
                    strhtml += 'data-state="' + data[i].estadomesa_group + '" ';
                    strhtml += 'style="background-color: ' + data[i].color_leyenda_group + ';">';

                    strhtml += '<input type="checkbox" name="chkGrupos[]" value="' + data[i].idgrupomesa + '" />'
                    strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';
                    strhtml += '<div style="width: 84px; height:84px;" class="centered"><h1 class="text-center white-text nombremesa">' + list_mesas + '</h1></div>';
                    strhtml += '</div>';

                    ++i;
                };
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';
            
            $(selector).html(strhtml);
            precargaExp(parentSelector, false);

            if (typeof preload_overlayer !== 'undefined')
                precarga_OverLayer('.page-region', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarAgregadosArticulo (action) {
    var tipomenudia = $('#pnlViewAllArticles .view-button.active').attr('data-tipomenudia');
    $('#hdTipoMenuDia').val(tipomenudia);

    $.ajax({
        type: "GET",
        url: 'services/productos/productos-agregados-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            tipomenudia: tipomenudia
        },
        success: function(data){
            arrAgregado = data;

            if (action == 'view-menu') {
                $('#gvArticuloPack').removeClass('hide');
                $('#gvArticuloMenu').addClass('hide');

                ListarArticulos_Menu('1');
            }
            else {
                $('#gvArticuloPack').addClass('hide');
                $('#gvArticuloMenu').removeClass('hide');

                if (action == 'view-card')
                    ListarArticulos_Carta('1');
                else
                    ListarArticulos_Individual('1');
            };
        },
        error: function (data) {
            console.log(error);
        }
    });
}

function crearItemArticulo (iddetalleorden, idarticulo, nombreProducto, cantidad, precio, subtotal, observacion) {
    var strhtml = '';
    // var subtotal = precio * cantidad;
    var _subtotal = Number(subtotal).toFixed(2);

    // strhtml += '<li data-iditem="' + iddetalleorden + '" class="item-list">';
    // strhtml += '<div class="mdl-grid">';
    // strhtml += '<div class="mdl-cell mdl-cell--6-col">' + nombreProducto + ' (' + cantidad + ')';
    // strhtml += '<small> (*) ' + observacion + '</small>';
    // strhtml += '</div>';
    // strhtml += '<div class="mdl-cell mdl-cell--5-col align-right">S/. ' + _subtotal + '</div>';
    // strhtml += '<div class="mdl-cell mdl-cell--1-col align-right"><button class="mdl-button mdl-button--icon" data-action="delete"><i class="material-icons">&#xE872;</i></div>';
    // strhtml += '</div>';
    // strhtml += '</li>';

    strhtml += '<tr data-iditem="' + iddetalleorden + '">';

    strhtml += '<td data-title="Articulo" class="v-align-middle nombre-articulo">' + nombreProducto + '</td>';
    
    strhtml += '<td data-title="Cantidad">' + cantidad + '</td>';
    strhtml += '<td data-title="Precio">' + _subtotal + '</td>';

    strhtml += '<td class="pos-rel"><button class="mdl-button mdl-button--icon" data-action="delete"><i class="material-icons">&#xE872;</i></td>';

    strhtml += '</tr>';

    return strhtml;
}

function listarDetalle (idatencion) {
    $.ajax({
        url: 'services/atencion/detallearticulo-search.php',
        type: 'GET',
        data: {
            tipo: '2',
            idatencion: idatencion
        },
        dataType: 'json',
        cache: false,
        success: function (data) {
            // var selectorContainer = $('#gvOrdenes .demo-card-order.oneSelected');
            // var totalFromOrder = selectorContainer.find('.total');

            var get_articles = crearItems_Articulos(data);

            var count_articulos = get_articles.count_articulos;
            var strhtml = get_articles.strhtml_articulos;
            var importe = get_articles.total_orden;

            // selectorContainer.find('.details-in-card').html(strhtml);
            // totalFromOrder.text(Number(importe).toFixed(2));

            $('#gvOrdenes tbody').html(strhtml);
            $('#lblTotalFromOrder .monto').text(Number(importe).toFixed(2));

            if (count_articulos > 0) {

                if ($('#hdEstadoMesa').val() == '02')
                    $('#btnConfirmOrder').removeClass('hide');
                else
                    $('#btnConfirmOrder').addClass('hide');
                
                if ($('#hdEstadoMesa').val() != '05')
                    $('#btnPayOrder').removeClass('hide');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function agregarArticulos (idorden) {
    var data = new FormData();

    // var idatencion = $('#gvOrdenes .oneSelected').attr('data-idorden');

    data.append('btnAddArticles', 'btnAddArticles');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdAmbiente', $('#hdIdAmbiente').val());
    data.append('hdIdAtencion', idorden);
    data.append('hdTipoMenuDia', $('#hdTipoMenuDia').val());
    data.append('txtCantidad', $('#txtCantidad').val());
    data.append('txtObservacion', $('#txtObservacion').val());

    var selector_detalle = $('#hdTipoMenuDia').val() == '03' ? '#gvArticuloPack' : '#gvArticuloMenu';

    var input_data = $(selector_detalle + ' :input').serializeArray();

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.rpta != '0') {
                // var strhtml = '';
                // var selectorContainer = $('*#gvOrdenes .demo-card-order.oneSelected');
                // var totalFromOrder = selectorContainer.find('.total');
                // var importe = 0;
                // var importe = Number(totalFromOrder.text());
                
                // var i = 0;
                // var itemsSelected = $('*#gvArticuloMenu .dato.selected');

                // if (!isNodeList(itemsSelected))
                //     itemsSelected = [itemsSelected];


                // console.log(importe);

                // Array.prototype.forEach.call(itemsSelected, function(el, i){
                //     console.log(el);

                //     var idarticulo = el.getAttribute('data-idmodel');
                //     var nombreProducto = el.find('.nombre-articulo').text();
                //     var cantidad = Number(el.find('.cantidad').value);
                //     var precio = Number(el.find('.precio').value).toFixed(2);
                //     var subtotal = el.find('.subtotal').value;
                //     var observacion = el.find('.observacion').value;

                //     strhtml += crearItemArticulo(0, idarticulo, nombreProducto, cantidad, precio, subtotal, observacion);
                //     importe += Number(subtotal);
                // });

                // selectorContainer.find('.details-in-card').insertAdjacentHTML('beforeend', strhtml);
                // totalFromOrder.text(importe.toFixed(2));

                $('#btnConfirmOrder').removeClass('hide');
                listarDetalle(idorden);

            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

var x = 0;

function eliminarArticulo (_this) {
    var _row = getParentsUntil(_this, '#gvOrdenes', 'tr');
    var idarticulo_orden = _row[0].getAttribute('data-iditem');

    MessageBox({
        content: '¿Desea quitar este item?',
        width: '320px',
        height: '130px',
        buttons: [
            {
                primary: true,
                content: 'Quitar item',
                onClickButton: function (event) {
                    var data = new FormData();

                    data.append('btnRemoveArticles', 'btnRemoveArticles');
                    data.append('hdIdArticuloOrden', idarticulo_orden);

                    $.ajax({
                        url: 'services/atencion/atencion-post.php',
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function  (data) {
                            createSnackbar(data.titulomsje);
                            
                            if (data.rpta != '0')
                                $(_row[0]).remove();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        ],
        cancelButton: true
    });
}

function nuevaOrden () {
    var data = new FormData();

    var nombre_personal =  $('#hdNombrePersonal').val();

    data.append('btnNuevaOrden', 'btnNuevaOrden');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdAmbiente', $('#hdIdAmbiente').val());
    data.append('hdIdAtencion', $('#hdIdAtencion').val());
    data.append('hdIdMesa', $('#hdIdMesa').val());
    data.append('hdTipoMesa', $('#hdTipoMesa').val());

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            var id_orden = data.rpta;
            var nro_orden = data.contenidomsje;

            createSnackbar(data.titulomsje);

            if (id_orden != '0') {
               // $('#gvOrdenes .demo-card-order').removeClass('oneSelected');

                // var strhtml_orden = crearItemOrden(id_orden, nro_orden, nombre_personal);
                
                // $('#gvOrdenes .gridview-content').prepend(strhtml_orden);
                // $('#gvOrdenes .dato').first().trigger('click');

                $('#hdIdAtencion').val(id_orden);

                agregarArticulos(id_orden);
                MostrarMesas ();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
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
        count_articulos: count_articulos,
        strhtml_articulos: strhtml,
        total_orden: total_orden
    };
}

// function crearItemOrden (id_orden, nro_orden, nombre_personal, articulos) {
//     var strhtml = '';
//     strhtml = '<div data-idorden="' + id_orden + '" class="demo-card-order dato mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp">';

//     strhtml += '<input name="chkItem[]" type="checkbox" class="hide" value="' + id_orden + '" />';

//     strhtml += '<div class="mdl-card__title mdl-card--expand mdl-card--border">';
//     strhtml += '<h5>';
//     strhtml += '<span class="padding-right10 padding-left10 place-left"><strong>ORDEN</strong>: ' + nro_orden + '</span>';
//     strhtml += '<span class="padding-right10 padding-left10 place-right"><strong>MOZO</strong>: ' + nombre_personal + '</span>';
//     strhtml += '</h5>';
//     strhtml += '</div>';
//     strhtml += '<div class="mdl-card__supporting-text full-size scrollbarra">';
//     strhtml += '<ul class="details-in-card no-margin">';

//     var total_orden = 0;

//     if (typeof articulos !== 'undefined'){
//         var get_articles = crearItems_Articulos(articulos);
        
//         strhtml += get_articles.strhtml_articulos;
//         total_orden = get_articles.total_orden;
//     };

//     strhtml += '</ul>';
//     strhtml += '</div>';
//     strhtml += '<div class="mdl-card__actions mdl-card--border">';
//     strhtml += '<h4 class="align-right"><strong>S/.</strong>&nbsp;<span class="total">' + total_orden.toFixed(2) + '</span></h4>';
//     strhtml += '</div>';
//     strhtml += '<div class="mark-selected pos-abs indigo accent-4 white-text circle"><i class="material-icons centered">&#xE5CA;</i></div>';

//     strhtml += '<i class="icon-select centered material-icons white-text circle">&#xE5CA;</i>';
//     strhtml += '<div class="layer-select"></div>';

//     strhtml += '</div>';

//     return strhtml;
// }

// function ListarOrdenes () {
//     // $('#gvOrdenes .demo-card-order').removeClass('oneSelected');
//     $('#btnPayOrder, #btnConfirmOrder, #btnAddArticles, #btnRemoveOrder').addClass('hide');

//     $.ajax({
//         url: 'services/atencion/atencion-search.php',
//         type: 'GET',
//         dataType: 'json',
//         data: {
//             tipobusqueda: 'ATENCION-TICKETS',
//             idempresa: $('#hdIdEmpresa').val(),
//             idcentro: $('#hdIdCentro').val(),
//             idambiente: $('#hdIdAmbiente').val(),
//             tipomesa: $('#hdTipoMesa').val(),
//             idmesas: $('#hdIdMesa').val()
//         },
//         cache: false,
//         success: function (result) {
//             var strhtml = '';
//             var i = 0;
            
//             var groups = _.groupBy(result, function(value){
//                 return value.tm_idatencion + '#' + value.tm_idambiente + '#' + value.tm_nroatencion + '#' + value.ta_estadoatencion + '#' + value.ta_tipoubicacion + '#' + value.tm_fechahora + '#' + value.tm_idempresa + '#' + value.tm_idcentro;
//             });
            
//             var data = _.map(groups, function(group){
//                 return {
//                     tm_idatencion: group[0].tm_idatencion,
//                     tm_idambiente: group[0].tm_idambiente,
//                     tm_nroatencion: group[0].tm_nroatencion,
//                     ta_estadoatencion: group[0].ta_estadoatencion,
//                     ta_tipoubicacion: group[0].ta_tipoubicacion,
//                     tm_fechahora: group[0].tm_fechahora,
//                     tm_idempresa: group[0].tm_idempresa,
//                     tm_idcentro: group[0].tm_idcentro,
//                     list_articulos: group
//                 }
//             });

//             var countdata = data.length;

//             if (countdata > 0){
//                 while(i < countdata){
//                     strhtml += crearItemOrden(data[i].tm_idatencion, data[i].tm_nroatencion, 'Admin', data[i].list_articulos);
//                     ++i;
//                 };
                
//                 $('#gvOrdenes .gridview-content').html(strhtml);
//                 $('#gvOrdenes .dato').first().trigger('click');
//             };
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }

function CambiarEstado (estado) {
    var data = new FormData();

    var currentAmbiente = $('#carousel-example-generic').find('.item.active');
    var idambiente = currentAmbiente.attr('data-idambiente');
    var parentSelector = '#carousel-example-generic .item[data-idambiente="' + idambiente + '"]';
    var selector = parentSelector + ' .gridview-container';

    var input_data = $(selector + ' :input').serializeArray();

    data.append('btnCambiarEstado', 'btnCambiarEstado');
    data.append('hdEstadoMesa', estado);
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);

            if (data.rpta != '0') {
                gvMesas.removeSelection();
                gvMesasGroup.removeSelection();
                
                MostrarMesas();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ConfirmarOrden () {
    var data = new FormData();

    data.append('btnConfirmOrder', 'btnConfirmOrder');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdAtencion', $('#hdIdAtencion').val());

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                $('#btnBackToRooms').trigger('click');                
                MostrarMesas();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function EliminarOrden () {
    var data = new FormData();

    data.append('btnRemoveOrder', 'btnRemoveOrder');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdAtencion', $('#hdIdAtencion').val());

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                $('#btnBackToRooms').trigger('click');                
                MostrarMesas();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function AgruparMesas () {
    var data = new FormData();

    data.append('btnAgruparMesas', 'btnAgruparMesas');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdAmbiente', $('#hdIdAmbiente').val());

    var input_data = $('.mesas :input').serializeArray();

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                gvMesas.removeSelection();
                MostrarMesas ();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function SepararMesas () {
    var data = new FormData();

    data.append('btnSepararMesas', 'btnSepararMesas');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());

    var input_data = $('.grupos :input').serializeArray();

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        url: 'services/atencion/atencion-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);
            
            if (data.rpta != '0'){
                gvMesasGroup.removeSelection();
                MostrarMesas ();
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function initGvMesas () {
    gvMesas = new DataList('#carousel-example-generic .mesas', {
        actionbar: '#mesas-actionbar',
        onSearch: function () {
        },
        oneItemClick: function (event) {
            var elem = event.target;
            var item = getParentsUntil(elem, '#carousel-example-generic .mesas', '.dato');
            item = item[0];

            var idatencion = item.getAttribute('data-idatencion');
            var listmesa = item.getAttribute('data-idmesa');
            var tipomesa = item.getAttribute('data-tipomesa');
            var estadoatencion = item.getAttribute('data-state');
            var nombremesa = $(item).find('.nombremesa').text();

            $('#hdIdAtencion').val(idatencion);
            $('#hdIdMesa').val(listmesa);
            $('#hdTipoMesa').val(tipomesa);
            $('#hdEstadoMesa').val(estadoatencion);

            Ordenes (idatencion, nombremesa);
        }
    });
}

function initGvMesasGroup () {
    gvMesasGroup = new DataList('#carousel-example-generic .grupos', {
        actionbar: '#grupos-actionbar',
        onSearch: function () {
        },
        oneItemClick: function (event) {
            var elem = event.target;
            var item = getParentsUntil(elem, '#carousel-example-generic .grupos', '.dato');
            item = item[0];

            var idatencion = item.getAttribute('data-idatencion');
            var listmesa = item.getAttribute('data-idmesa');
            var tipomesa = item.getAttribute('data-tipomesa');
            var estadoatencion = item.getAttribute('data-state');
            var nombremesa = $(item).find('.nombremesa').text();

            $('#hdIdAtencion').val(idatencion);
            $('#hdIdMesa').val(listmesa);
            $('#hdTipoMesa').val(tipomesa);
            $('#hdEstadoMesa').val(estadoatencion);

            Ordenes (idatencion, nombremesa);
        }
    });
}

function BackToRooms () {
    $('#hdIdAtencion').val('0');
    $('#hdIdMesa').val('0');
    $('#hdTipoMesa').val('0');
    $('#hdEstadoMesa').val('00');

    pnlOrden.fadeOut(300, function () {
        pnlOrden.addClass('hide');
        pnlMesas.fadeIn(300, function () {
            $('#btnPayOrder, #btnRemoveOrder, #btnAddArticles, #btnConfirmOrder').addClass('hide');
        });
    });
}

function InitBuscarUbicacion () {
    var registrandoPosicion = false, idRegistroPosicion, ultimaPosicionUsuario; //, marcadorUsuario, mapa, div = document.getElementById('mapa');
    // mapa = new google.maps.Map(div, {
    //     zoom: 13,
    //     center: new google.maps.LatLng(0, 0),
    //     mapTypeId: google.maps.MapTypeId.ROADMAP
    // });

    // var intervalBusqueda = new Interval(function(){
    //     registrarPosicion();
    // }, 100);

    function registrarPosicion() {
        if (registrandoPosicion) {
            registrandoPosicion = false;
            navigator.geolocation.clearWatch(idRegistroPosicion);
            limpiarUbicacion();
        } else {
            idRegistroPosicion = navigator.geolocation.watchPosition(exitoRegistroPosicion, falloRegistroPosicion, {
                enableHighAccuracy: true,
                maximumAge: 30000,
                timeout: 27000
            });
        }
    }

    function exitoRegistroPosicion(position) {
        if (!registrandoPosicion) {
            // Es la primera vez 
            registrandoPosicion = true;
            ultimaPosicionUsuario = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            // marcadorUsuario = new google.maps.Marker({
            //     position: ultimaPosicionUsuario,
            //     map: mapa
            // });
        } else {
            var posicionActual = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            ultimaPosicionUsuario = posicionActual;
            // marcadorUsuario.setPosition(posicionActual);
        }

        ListarCentros();
        // mapa.panTo(ultimaPosicionUsuario);
    }

    function falloRegistroPosicion() {
        console.log('No se pudo determinar la ubicación');
        limpiarUbicacion();
    }

    function limpiarUbicacion() {
        ultimaPosicionUsuario = new google.maps.LatLng(0, 0);
        // if (marcadorUsuario) {
        //     marcadorUsuario.setMap(null);
        //     marcadorUsuario = null;
        // }
    }

    // if (navigator.geolocation) {
    //     var options = {
    //         enableHighAccuracy: true,
    //         timeout: 5000,
    //         maximumAge: 0
    //     };

    //     function success(pos) {
    //         var crd = pos.coords;
    //         var _lat = crd.latitude;
    //         var _lng = crd.longitude;
          
    //         console.log('Your current position is:');
    //         console.log('Latitude : ' + crd.latitude);
    //         console.log('Longitude: ' + crd.longitude);
    //         console.log('More or less ' + crd.accuracy + ' meters.');

            
    //     };

    //     function error(err) {
    //         console.warn('ERROR(' + err.code + '): ' + err.message);
    //     };

    //     navigator.geolocation.getCurrentPosition(success, error, options);
    // }
    // else {
    //     MessageBox({
    //         content: 'TAMBOAPP dice',
    //         content: 'Geolocalización no soportada para este navegador',
    //         width: '320px',
    //         height: '130px',
    //         cancelButton: true
    //     });
    // };

    function ListarCentros () {
        $.ajax({
            url: 'services/centro/centro-search.php',
            type: 'GET',
            dataType: 'json',
            data: {
                tipobusqueda: '3',
                id: $('#hdIdRegion').val()
            },
            success: function (result) {
                var i = 0;
                var strhtml = '';

                var count_result = result.length;

                if (count_result > 0) {
                     while (i < count_result){
                        var lat = result[i].tm_latitud;
                        var lng = result[i].tm_longitud;
                        var destino = new google.maps.LatLng(lat, lng);
                        var distancia = google.maps.geometry.spherical.computeDistanceBetween(ultimaPosicionUsuario, destino);
                        
                        result[i]['distancia'] = distancia;
                        ++i;
                    };

                    var data = result.sort( function ( a, b ) { return a.distancia - b.distancia; } );

                    $("#txtDireccion").easyAutocomplete({
                        data: data,
                        getValue: function (element) {
                            return element.NombreEmpresa +  ' - ' + element.tm_direccion + ' - (a ' + Number(element.distancia).toFixed(2) + ' metros de distancia)';
                        },
                        list: {
                            onSelectItemEvent: function () {
                                var _idempresa = $("#txtDireccion").getSelectedItemData().tm_idempresa;
                                var _idcentro = $("#txtDireccion").getSelectedItemData().tm_idcentro;

                                $('#hdIdEmpresa').val(_idempresa);
                                $('#hdIdCentro').val(_idcentro);
                            }
                        },
                        template: {
                            type: "custom",
                            method: function (value, item) {
                                return item.NombreEmpresa +  ' - ' + item.tm_direccion + ' - (a ' + Number(item.distancia).toFixed(2) + ' metros de distancia)';
                            }
                        },
                        theme: "square"
                    });
                    // var countdata = data.length;

                    // i = 0;
                    // while (i < countdata){
                        // strhtml += '<div data-idempresa="' + data[i].tm_idempresa + '" data-idcentro="' + data[i].tm_idcentro + '" class="list-group-item dato">';

                        // // strhtml += '<h4 class="list-group-item-heading">' + data[i].tm_nombre + '</h4>';
                        // strhtml += '<h4 class="list-group-item-heading">' + data[i].NombreEmpresa + '</h4>';
                        // strhtml += '<p class="list-group-item-text">' + data[i].tm_direccion + ' - (a ' + Number(data[i].distancia).toFixed(2) + ' metros de distancia)</p>';

                        // if (i == 0)
                        //     strhtml += '<button class="btn btn-primary waves-effect place-top-right tooltipped margin5" type="button" data-action="take-table" data-delay="50" data-position="bottom" data-tooltip="Ocupar mesa">Ocupar mesa</button>';

                        // strhtml += '</div>';
                    //     ++i;
                    // };
                    
                    // $('#gvCentros .gridview-content').html(strhtml).removeClass('hide');
                    // $('#gvCentros .empty_state').addClass('hide');
                };
            },
            error: function (error) {
                console.log(error);
            }
        });
    }


    $('#btnActualizar').on('click', function(event) {
        event.preventDefault();
        // if (intervalBusqueda.isRunning())
        //     intervalBusqueda.stop();
        // intervalBusqueda.start();
        createSnackbar('Buscando...');
        registrarPosicion();
    });
}

function setEmpresaCentro () {
    var data = new FormData();
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());

    $.ajax({
        url: 'services/home/home-ajax-post.php',
        type: 'POST',
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            createSnackbar(data.titulomsje);

            if (data.rpta != '0')
                Ambientes(_idempresa, _idcentro);
        },
        error: function (error) {
            console.log(error);
        }
    });
}