$(function () {
    // inputNavigation('*#gvArticuloMenu tbody');
    var screenmode = getParameterByName('screenmode');

    // $('#tabs-swipe-demo').tabs({ 'swipeable': true });

    $('#btnActualizarViewArticles__Portada').on('click', function(event) {
        event.preventDefault();
        ListarArticulos__Portada('1');
    });

    $('#pnlLocal > .modal-example-body > .scrollbarra').scroll(function(e){ 
        var _containerTabs = $('.hide-tab-scrollbar');
        var isPositionFixed =  (_containerTabs.css('position') == 'absolute');
        
        var _targetTop = 400;

        if (document.documentElement.clientWidth < 480)
            _targetTop = 260;

        if ($(this).scrollTop() > _targetTop && !isPositionFixed)
            $('.hide-tab-scrollbar').addClass('fixedElement'); // $('.hide-tab-scrollbar').css({'position': 'fixed', 'top': '56px'}); 
        
        if ($(this).scrollTop() < _targetTop && isPositionFixed)
            $('.hide-tab-scrollbar').removeClass('fixedElement'); // $('.hide-tab-scrollbar').css({'position': 'static', 'top': '0px'}); 
    });

    ListarArticulos__Portada('1');

    $('#btnActualizarUbicacion').on('click', function(event) {
        event.preventDefault();
        registrarPosicion();
    });

    $('#btnVerUbicacion, #next').on('click', function(event) {
        event.preventDefault();
       
       context__map = true;
       showModalUbicacion(); 
    });

    $('#btnConfirmarUbicacion').on('click', function(event) {
        event.preventDefault();
        Ambientes();
    });

    $('#gvCentro').on('click', 'button[data-action="choose"]', function(event) {
        event.stopPropagation();
        event.preventDefault();
        
        var _row = getParentsUntil(this, '#gvCentro', '.dato');
        _row = _row[0];
        showLocal(_row);
    });

    $('#gvCentro').on('click', '.resultItem', function(event) {
        event.preventDefault();
        
        var _row = this;
        showLocal(_row);
    });

    $('#txtArticulo').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            // $('#barSearchArticulos .easy-autocomplete-container ul').hide();
            $(this).blur();
            precargaExp('#pnlArticulo > .gp-body > .container-body', true);
            ListarArticulos__Portada('1');
            return false;
        };
    });

    $("#txtArticulo").easyAutocomplete({
        url: function (phrase) {
            var _url = 'services/cartadia/cartadia-search.php';
            
            _url += '?tipoconsulta=COMENSAL';
            _url += '&tipobusqueda=2';
            _url += '&tipomenu=01';
            _url += '&criterio=' + phrase;

            return _url;
        },
        getValue: function (element) {
            return element.nombreProducto;
        },
        list: {
            onChooseEvent: function () {
                precargaExp('#pnlArticulo > .gp-body > .container-body', true);
                ListarArticulos__Portada('1');
            }
        },
        template: {
            type: "custom",
            method: function (value, item) {
                return '<i class="material-icons">&#xE56C;</i><span class="text grey-text text-darken-4">' + item.nombreProducto + '</span>';
            }
        },
        theme: "bootstrap"
    });

    $('#gvArticulo').on('click', 'a[data-action="add"]', function(event) {
        event.preventDefault();
        
        var _row = getParentsUntil(this, '#gvArticulo', '.dato');
        var iditem = _row[0].getAttribute('data-iditem');
        var nombreProducto = _row[0].getAttribute('data-nombreProducto');

        $('#hdNombreArticulo').val(nombreProducto);
        VerSedes();
    });

    $('#btnBackToArticles__FromOrdenes').on('click', function(event) {
        event.preventDefault();
        $('#pnlOrden').fadeOut('400', function() {
            $('#pnlArticulo').fadeIn('400', function() {
            
            });
        });
    });

    $('#btnBackToSede__FromArticles').on('click', function(event) {
        event.preventDefault();
        $('#pnlCentros').fadeOut('400', function() {
            $('#pnlArticulo').fadeIn('400', function() {
            
            });
        });
    });

    $('#btnBackToSede__FromOrdenes').on('click', function(event) {
        event.preventDefault();
        $('#pnlOrden').fadeOut('400', function() {
            $('#pnlCentros').fadeIn('400', function() {
                
            });
        });
    });

    $('#btnVerPedido').on('click', function(event) {
        event.preventDefault();
        VerOrden__FromArticulo();
    });

    $('#btnSeleccionarMesa').on('click', function(event) {
        event.preventDefault();
        seleccionarMesa();
    });

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

    $('#btnHideSearchBarArticles').on('click', function(event) {
        event.preventDefault();
        // $('.control-inner-app').removeClass('hide');
        // $(this).addClass('hide');
        $('#barSearchArticulos').addClass('hide');
        // $('#pnlArticulo > .gp-header > .mdl-layout__header').removeClass('white text-black');
        // $('#pnlArticulo > .gp-header > .mdl-layout__header > .mdl-layout-title').removeClass('hide');
        // $('#pnlArticulo > .gp-header > .mdl-layout__header > .mdl-layout__header-row').removeClass('no-padding-right');
    });

    $('#btnBuscarArticulo').on('click', function(event) {
        event.preventDefault();
        // $('.control-inner-app').addClass('hide');
        $('#barSearchArticulos').removeClass('hide');
        // $('#pnlArticulo > .gp-header > .mdl-layout__header').addClass('white text-black');
        // $('#pnlArticulo > .gp-header > .mdl-layout__header > .mdl-layout-title').addClass('hide');
        // $('#pnlArticulo > .gp-header > .mdl-layout__header > .mdl-layout__header-row').addClass('no-padding-right');
    });

    $('#btnHideSearchBarSedes').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('hide');
        $('#barSearchSedes').addClass('hide');
    });

    $('#btnBuscarSede').on('click', function(event) {
        event.preventDefault();
        $('#btnHideSearchBarSedes').removeClass('hide');
        $('#barSearchSedes').removeClass('hide');
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

    $('#pnlMesas .mdl-layout__header').on('click', '.view-button', function(event) {
        event.preventDefault();

        var view = this.getAttribute('data-view');

        $(this).parent().find('.btn-success').removeClass('btn-success');
        $(this).addClass('btn-success');

        $('#carousel-example-generic .pane-carousel').addClass('hide');
        $('#carousel-example-generic .pane-carousel.' + view).removeClass('hide');
    });

    $('#btnAddArticles').on('click', function(event) {
        event.preventDefault();
        nuevaOrden();
    });

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

var idempresa__old = 0;
var idcentro__old = 0;
var arrAgregado = [];

var is__setted__question_location = false, is__built__map = false, context__map = false, registrandoPosicion = false, lugar__destino = false, flg_show__message__distance = true, idRegistroPosicion, ultimaPosicionUsuario, marcadorUsuario, mapa;

var gvMesas;
var gvMesasGroup;

var _ACTIVITY = '';

var gvArticulo = new DataList('#gvArticulo', {
    onSearch: function () {
        ListarArticulos__Portada(gvArticulo.currentPage());
    }
});

var gvArticulo__Individual = new DataList('#gvArticulo__Individual', {
    onSearch: function () {
        ListarArticulos__Individual(gvArticulo__Individual.currentPage());
    }
});

function MostrarMesas__onupdate () {
    MostrarMesas (true);
}

function MostrarAmbientes () {

    $.ajax({
        url: 'services/ambientes/ambientes-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: ''
        },
        success: function (data) {
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var view = $('#pnlMesas .mdl-layout__header .view-button.btn-success').attr('data-view');
            var view__mesas = '';
            var view__grupos = '';

            if (countdata > 0) {
                while (i < countdata) {
                    if (view == 'mesas') {
                        view__mesas = '';
                        view__grupos = ' hide';
                    }
                    else {
                        view__mesas = ' hide';
                        view__grupos = '';
                    };

                    strhtml += '<div data-idambiente="' + data[i].tm_idambiente + '" class="item' + ((i == 0) ? ' active' : '') + ' all-height"><div class="generic-panel gp-no-footer"><div class="gp-header"><h3 class="text-center">' + data[i].tm_nombre + '</h3></div>';
                    
                    strhtml += '<div class="gp-body">'; // start body slide

                    strhtml += '<div class="pane-carousel mesas scrollbarra' + view__mesas + '" class="gridview all-height" data-selected="none" data-multiselect="false" data-actionbar="mesas-actionbar"><div class="gridview-container mdl-grid"></div></div>';

                    strhtml += '<div class="pane-carousel grupos scrollbarra' + view__grupos + '" class="gridview all-height" data-selected="none" data-multiselect="false" data-actionbar="grupos-actionbar"><div class="gridview-container mdl-grid"></div></div>';

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

function Ambientes () {
    openModalCallBack('#pnlMesas', function () {
        MostrarAmbientes();
    });
}

function Ordenes (idatencion, nombremesa) {
	$('#pnlMesas').fadeOut(300, function () {
		$('#pnlOrden').removeClass('hide');
		
        $('#pnlOrden').fadeIn(300, function () {
            $('#pnlOrden > .gp-header .mdl-layout-title').text('Mesa: ' + nombremesa);

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
                    strhtml += '<div class="dato mdl-cell mdl-cell--2-col mdl-cell--2-col-phone pos-rel mdl-card card-mesa" ';
                    strhtml += 'data-idatencion="' + data[i].tm_idatencion + '" ';
                    strhtml += 'data-nroatencion="' + data[i].tm_nroatencion + '" ';
                    strhtml += 'data-idmesa="' + data[i].idgrupomesa + '" ';
                    strhtml += 'data-tipomesa="' + data[i].ta_tipomesa + '" ';
                    strhtml += 'data-state="' + data[i].estadomesa_group + '" ';
                    strhtml += 'style="background-color: ' + data[i].color_leyenda_group + ';">';

                    strhtml += '<input type="checkbox" name="chkMesa[]" value="' + data[i].idgrupomesa + '" />'

                    strhtml += '<div class="mark-selected pos-abs indigo accent-4 white-text circle"><i class="material-icons centered">&#xE5CA;</i></div>';
                    
                    strhtml += '<i class="icon-select place-top-right margin10 material-icons white-text circle">done</i><div class="layer-select"></div>';
                    strhtml += '<div style="width: 64px; height:48px;" class="centered"><h1 class="text-center white-text nombremesa">' + data[i].codigo_group + '</h1></div>';
                    strhtml += '</div>';

                    ++i;
                };
            }
            else
                strhtml = '<h2>No se encontraron resultados.</h2>';
            
            $(selector).html(strhtml).find('.dato:first-child').trigger('click');
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

                    strhtml += '<div class="dato mdl-cell mdl-cell--4-col mdl-cell--4-col-phone pos-rel mdl-card card-mesa" ';
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
            
            $(selector).html(strhtml).find('.dato:first-child').trigger('click');
            precargaExp(parentSelector, false);

            if (typeof preload_overlayer !== 'undefined')
                precarga_OverLayer('.page-region', false);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function crearItemArticulo (iddetalleorden, idarticulo, nombreProducto, cantidad, precio, subtotal, observacion) {
    var strhtml = '';
    var _subtotal = Number(subtotal).toFixed(2);

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
            var get_articles = crearItems_Articulos(data);

            var count_articulos = get_articles.count_articulos;
            var strhtml = get_articles.strhtml_articulos;
            var importe = get_articles.total_orden;

            $('#gvOrdenes tbody').html(strhtml);
            $('#lblTotalFromOrder .monto').text(Number(importe).toFixed(2));

            if (count_articulos > 0) {

                if ($('#hdEstadoMesa').val() == '02')
                    $('#btnConfirmOrder').removeClass('hide');
                else
                    $('#btnConfirmOrder').addClass('hide');
                
                if ($('#hdEstadoMesa').val() != '05')
                    $('#btnPayOrder').removeClass('hide');
                
                $('#emptyStateOrders').addClass('hide');
                $('#pnlOrdenesDetalle').removeClass('hide');
            }
            else {
                $('#emptyStateOrders').removeClass('hide');
                $('#pnlOrdenesDetalle').addClass('hide');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function agregarArticulos (idorden) {
    var data = new FormData();

    data.append('btnAddArticles', 'btnAddArticles');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    // data.append('hdIdAmbiente', $('#hdIdAmbiente').val());
    data.append('hdIdAtencion', idorden);


    // data.append('hdTipoMenuDia', $('#hdTipoMenuDia').val());
    // data.append('txtCantidad', $('#txtCantidad').val());

    data.append('hdIdArticulo', $('#hdIdArticulo').val());
    data.append('hdPrecio', $('#hdPrecio').val());
    data.append('hdCantidad', $('#hdCantidad').val());
    data.append('hdSubTotal', $('#hdSubTotal').val());

    // data.append('txtObservacion', $('#txtObservacion').val());

    // var selector_detalle = '#gvArticulo';

    // var input_data = $(selector_detalle + ' :input').serializeArray();

    // Array.prototype.forEach.call(input_data, function(fields){
    //     data.append(fields.name, fields.value);
    // });

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
                // $('#btnConfirmOrder').removeClass('hide');
                VerOrden__FromSede();
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
    // data.append('hdIdAmbiente', $('#hdIdAmbiente').val());
    data.append('hdIdAtencion', $('#hdIdAtencion').val());
    data.append('hdIdCliente', $('#hdIdCliente').val());
    // data.append('hdIdMesa', $('#hdIdMesa').val());
    // data.append('hdTipoMesa', $('#hdTipoMesa').val());

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

                $('#hdIdAtencion').val(id_orden);

                agregarArticulos(id_orden);
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
        onSearch: function () {
        },
        oneItemClick: function (event) {
            var elem = event.target;
            var item = getParentsUntil(elem, '#carousel-example-generic .mesas', '.dato');
            item = item[0];

            $('#carousel-example-generic .mesas .oneSelected').removeClass('oneSelected');
            $(item).addClass('oneSelected');
        }
    });
}

function initGvMesasGroup () {
    gvMesasGroup = new DataList('#carousel-example-generic .grupos', {
        onSearch: function () {
        },
        oneItemClick: function (event) {
            var elem = event.target;
            var item = getParentsUntil(elem, '#carousel-example-generic .grupos', '.dato');
            item = item[0];

            $('#carousel-example-generic .grupos .oneSelected').removeClass('oneSelected');
            $(item).addClass('oneSelected');
        }
    });
}

function BackToRooms () {
    $('#hdIdAtencion').val('0');
    $('#hdIdMesa').val('0');
    $('#hdTipoMesa').val('0');
    $('#hdEstadoMesa').val('00');

    $('#pnlOrden').fadeOut(300, function () {
        $('#pnlOrden').addClass('hide');
        $('#pnlMesas').fadeIn(300, function () {
            $('#btnPayOrder, #btnRemoveOrder, #btnAddArticles, #btnConfirmOrder').addClass('hide');
        });
    });
}

function VerOrden__FromArticulo () {
    $('#pnlArticulo').fadeOut(400, function() {
        $('#pnlOrden').fadeIn(400, function() {
            
        });
    });
}

function VerOrden__FromSede () {
    $('#pnlCentros').fadeOut(400, function() {
        $('#pnlOrden').fadeIn(400, function() {
            
        });
    });
}

function VerSedes () {
    $('#pnlArticulo').fadeOut(400, function() {
        $('#pnlCentros').fadeIn(400, function() {
            ListarCentros();
        });
    });
}

function VerLocal () {
    openModalCallBack('#pnlLocal', function () {
         $("#pnlLocal > .modal-example-body > .scrollbarra").animate({
            scrollTop: 0
        }, 1000, function () {
            ListarArticulos__Individual('1');
        });
    });
}

function seleccionarMesa () {
    var view = $('#pnlMesas .mdl-layout__header .view-button.btn-success').attr('data-view');
    var item = $('#carousel-example-generic .' + view + ' .dato.oneSelected');

    var idatencion = item.attr('data-idatencion');
    var listmesa = item.attr('data-idmesa');
    var tipomesa = item.attr('data-tipomesa');
    var estadoatencion = item.attr('data-state');
    var nombremesa = item.find('.nombremesa').text();

    $('#hdIdAtencion').val(idatencion);
    $('#hdIdMesa').val(listmesa);
    $('#hdTipoMesa').val(tipomesa);
    $('#hdEstadoMesa').val(estadoatencion);

    closeCustomModal('#pnlMesas');
    nuevaOrden();
    VerOrden__FromArticulo();
}

function ListarArticulos__Portada (pagina) {
    var typelist = "portada";
    var criterio = $('#txtArticulo').val();

    var _data = {
        tipoconsulta: 'COMENSAL',
        tipobusqueda: '1',
        tipomenu: '01',
        criterio: criterio,
        pagina: pagina
    };

    precargaExp('#pnlArticulo > .gp-body > .container-body', true);
    ListarArticulos(typelist, _data, pagina, function () {
        $('.info-card-list li').each(function(index, li){
            var swipeListItem = new SwipeListItem(li, 'option');
        });
        precargaExp('#pnlArticulo > .gp-body > .container-body', false);
    });
}

function createItem__Menu (i, imagen, nombreProducto, idarticulo, importe) {
    var strhtml = '';

    var _idarticulo = typeof idarticulo === 'undefined' ? '0' : idarticulo;
    var _importe = typeof importe === 'undefined' ? 0 : importe;

    strhtml += '<li class="resultItem dato mdl-shadow--2dp"';

    strhtml += 'data-iditem="' + idarticulo + '" ';
    strhtml += 'data-nombreProducto="' + nombreProducto + '" ';
    strhtml += 'data-importe="' + _importe + '" ';

    strhtml += '>';

    strhtml += '<input type="hidden" name="carrito[' + i + '][importe]" class="importe" value="' + importe + '" />';
        
    strhtml += '<div class="resultItem-avatar blue-grey darken-2">';
    strhtml += '<img data-src="' + imagen.replace('_o', '_s640') + '" class="image__centro centered" alt="' + nombreProducto + '" src="' + imagen.replace('_o', '_s140') + '">';
    
    strhtml += '</div>';
    strhtml += '<div class="resultItem-information">';
    strhtml += '<h3 class="resultItem-name">';
    strhtml += nombreProducto;
    strhtml += '</h3>';
    strhtml += '<div class="resultItem-address hide"></div>';
    
    if (_importe > 0) {
        strhtml += '<div class="resultItem-averagePrice">';
        strhtml += 'S/.' + _importe;
        strhtml += '</div>';
    };

    strhtml += '</div>';
    
    strhtml += '<div class="resultItem-rating resultItem-rating--noTimeSlot">';
    strhtml += '<div class="rating pos-rel no-margin">';
    strhtml += '<div class="spin"><input type="number" min="1" max="100" value="1" /></div>';
    strhtml += '<div class="clear"></div>';
    strhtml += '</div>';
    strhtml += '</div>';

    strhtml += '<div class="resultItem-action">';
    strhtml += '<a href="#" data-action="add" class="mdl-button mdl-button--icon tooltipped" data-delay="50" data-position="bottom" data-tooltip="Agregar a la orden"><i class="material-icons">&#xE146;</i></a>';
    strhtml += '</div>';


    strhtml += '</li>';

    return strhtml;
}

function ListarArticulos__Menu (pagina) {

}

function ListarArticulos__Carta (pagina) {
    var criterio = ""; //$('#txtSearchArticulo').val();

    var _data = {
        tipobusqueda: '2',
        idempresa: $('#hdIdEmpresa').val(),
        idcentro: $('#hdIdCentro').val(),
        tipomenu: '00',
        idcarta: 0,
        criterio: criterio,
        pagina: pagina
    };

    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: data,
        success: function (result) {
            var i = 0;
            var strhtml = '';

            var count_result = result.length;

            if (count_result > 0) {
                 while (i < count_result){
                    strhtml += createItem__Menu(i, data[i].tm_foto, data[i].nombreProducto, data[i].tm_idproducto, data[i].td_precio);

                    ++i;
                };

                $('#gvArticulo__Carta ul').html(strhtml);

                $('#gvArticulo__Carta').removeClass('hide');
                $('#emptyStateCentros').addClass('hide');

                precargaExp('#pnlCentros >.gp-body > .container-body', false);
            }
            else {
                $('#gvArticulo__Carta').addClass('hide');
                $('#emptyStateCentros').removeClass('hide');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function ListarArticulos__Individual (pagina) {
    var typelist = "individual";
    var criterio = ""; //$('#txtSearchArticulo').val();

    var _data = {
        tipobusqueda: '1',
        idempresa: $('#hdIdEmpresa').val(),
        idcentro: $('#hdIdCentro').val(),
        tipomenu: '01',
        idgrupo: 0,
        criterio: criterio,
        pagina: pagina
    };

    // precargaExp('#pnlArticulo > .gp-body > .container-body', true);
    ListarArticulos(typelist, _data, pagina);
}

function ListarArticulos (typelist, data, pagina, callback) {
    var selector__visible = "", selector__data = "", selector__empty = "";

    if (typelist == "portada") {
        selector__visible = "#gvArticulo";
        selector__data = "#gvArticulo > .scrollbarra > ul";
        selector__empty = "#emptyStateArticles";
    }
    else if (typelist == "individual") {
        selector__visible = "#gvArticulo__Individual";
        selector__data = "#gvArticulo__Individual > ul";
        selector__empty = "#emptyStateArticles__Individual";
    };

    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: data,
        success: function(data){
            var strhtml = '';
            var countdata = data.length;

            if (countdata > 0) {
                var i = 0;
                // var width__card = "";

                while(i < countdata){
                    // if (typelist == "portada")
                    //     width__card = "mdl-cell--2-col";
                    // else
                    //     width__card = "mdl-cell--3-col";

                    // strhtml += '<div class="demo-card-square mdl-card dato articulo mdl-shadow--2dp mdl-cell ' + width__card + ' mdl-cell--2-col-tablet mdl-cell--12-col-phone" data-iditem="' + data[i].tm_idproducto + '">';
                    // strhtml += '<input name="chkItem[]" type="checkbox" class="hide" value="' + data[i].tm_idproducto + '" />';

                    // strhtml += '<div class="mdl-card__media pos-rel">';
                    // strhtml += '<i class="icon-select centered material-icons white-text circle">done</i>';
                    
                    // if (data[i].tm_foto != 'no-set')
                    //     strhtml += '<img src="' + data[i].tm_foto.replace('_o', '_s225') + '" width="100%" height="140px" border="0" alt="">';

                    // strhtml += '</div>';

                    // strhtml += '<div class="layer-select"></div>';

                    // strhtml += '<div class="mdl-card__title">';
                    // strhtml += '<div class="grouped-buttons mdl-grid mdl-grid--no-spacing full-size no-margin pos-rel">';
                    // strhtml += '<div class="mdl-cell mdl-cell--9-col mdl-cell--3-col-phone">';

                    // strhtml += '<h5 class="text-ellipsis" title="' + data[i].nombreProducto + '">' + data[i].nombreProducto + '</h5>';

                    // strhtml += '</div>';

                    // strhtml += '<div data-action="add" class="mdl-cell mdl-cell--3-col mdl-cell--1-col-phone"><a href="#" class="mdl-button mdl-button--icon right tooltipped" data-delay="50" data-position="bottom" data-tooltip="Agregar a la orden"><i class="material-icons">&#xE146;</i></a></div>';

                    // strhtml += '</div>';

                    // strhtml += '</div>';

                    // strhtml += '</div>';

                    var foto = data[i].tm_foto;
                    var nombreProducto = data[i].nombreProducto;

                    strhtml += createItem__Menu(i, foto, nombreProducto);

                    ++i;
                };

                gvArticulo.currentPage(gvArticulo.currentPage() + 1);

                if (pagina == '1')
                    $(selector__data).html(strhtml);
                else
                    $(selector__data).append(strhtml);

                $(selector__empty).addClass('hide');
                $(selector__visible).removeClass('hide');
            }
            else {
                if (pagina == '1') {
                    $(selector__data, selector__empty).html("");

                    $(selector__empty).removeClass('hide');
                    $(selector__visible).addClass('hide');
                };
            };

            if (typeof callback !== 'undefined')
                callback();

            $('input[type=number]').spinner();
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarCentros () {
    precargaExp('#pnlCentros >.gp-body > .container-body', true);

    $.ajax({
        url: 'services/centro/centro-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipoconsulta: 'COMENSAL',
            tipobusqueda: '1',
            idregion: $('#hdIdRegion').val(),
            nombrearticulo: $('#hdNombreArticulo').val()
        },
        success: function (result) {
            var i = 0;
            var strhtml = '';

            var count_result = result.length;

            if (count_result > 0) {
                 while (i < count_result){
                    var lat = result[i].tm_latitud;
                    var lng = result[i].tm_longitud;
                    // var destino = new google.maps.LatLng(lat, lng);
                    // var distancia = google.maps.geometry.spherical.computeDistanceBetween(ultimaPosicionUsuario, destino);
                    
                    // result[i]['distancia'] = distancia;

                    var importe = Number(result[i].td_precio).toFixed(2);


                    // strhtml += ' - (a ' + Number(result[i].distancia).toFixed(2) + ' metros de distancia)';


                    strhtml += '<li class="resultItem resultItem__local dato mdl-shadow--2dp"';

                    strhtml += 'data-idempresa="' + result[i].tm_idempresa + '" ';
                    strhtml += 'data-idcentro="' + result[i].tm_idcentro + '" ';
                    strhtml += 'data-lat="' + result[i].tm_latitud + '" ';
                    strhtml += 'data-lng="' + result[i].tm_longitud + '" ';
                    strhtml += 'data-importe="' + importe + '" ';

                    strhtml += '>';

                    strhtml += '<input type="hidden" name="carrito[' + i + '][importe]" class="importe" value="' + importe + '" />';
                        
                    strhtml += '<div class="resultItem-avatar blue-grey darken-2">';
                    strhtml += '<img data-src="' + result[i].tm_logo.replace('_o', '_s640') + '" class="image__centro centered" alt="' + result[i].NombreEmpresa + '" src="' + result[i].tm_logo.replace('_o', '_s140') + '">';
                    
                    strhtml += '</div>';
                    strhtml += '<div class="resultItem-information">';
                    strhtml += '<h3 class="resultItem-name">';
                    strhtml += result[i].NombreEmpresa;
                    strhtml += '</h3>';
                    strhtml += '<div class="resultItem-address">';
                    strhtml += result[i].tm_direccion;
                    strhtml += '</div>';
                    strhtml += '<div class="resultItem-averagePrice">';
                    strhtml += 'S/.' + importe;
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="resultItem-rating resultItem-rating--noTimeSlot">';
                    strhtml += '<div class="rating">';
                    strhtml += '<a href="#" class="js_rating" target="_blank"><span class="rating-ratingValue">8,5</span> /10</a>';
                    strhtml += '<br />Valoraci&oacute;n';
                    strhtml += '</div>';
                    strhtml += '<button id="btnAgregarArticulos" type="button" data-action="choose" class="hidden-xs mdl-button mdl-js-button waves-effect mdl-button--raised mdl-button--colored mdl-button--primary center-block">SELECCIONAR</button>';
                    strhtml += '</div>';

                    strhtml += '<div class="clear"></div>';

                    strhtml += '<div class="resultItem-footer place-bottom-left-right">';
                    strhtml += '<h3 class="resultItem-name">';
                    strhtml += result[i].NombreEmpresa;
                    strhtml += '</h3>';
                    strhtml += '<div class="resultItem-address">';
                    strhtml += result[i].tm_direccion;
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</li>';

                    ++i;
                };

                $('#gvCentro').html(strhtml);

                $('#pnlViewCentro').removeClass('hide');
                $('#emptyStateCentros').addClass('hide');

                precargaExp('#pnlCentros >.gp-body > .container-body', false);
            }
            else {
                $('#pnlViewCentro').addClass('hide');
                $('#emptyStateCentros').removeClass('hide');
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function registrarPosicion() {
    if (navigator.geolocation) {
        if (is__setted__question_location == false) {
            MessageBox({
                content: '¿Quiere saber qu&eacute; local est&aacute; cerca de usted?',
                width: '320px',
                height: '130px',
                buttons: [
                    {
                        primary: true,
                        content: 'OK',
                        onClickButton: function (event) {
                            is__setted__question_location = true;
                            iniciarRegistroPosicion();
                        }
                    }
                ],
                cancelButton: true
            });
        }
        else
            iniciarRegistroPosicion();
    }
    else {
         MessageBox({
            title: 'TAMBOAPP dice',
            content: 'Geolocalización no soportada para este navegador',
            width: '320px',
            height: '150px',
            cancelButton: true
        });
    };
}

function exitoRegistroPosicion(position) {
    if (!registrandoPosicion) {
        registrandoPosicion = true;
        ultimaPosicionUsuario = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

        if (is__built__map == false && context__map == true)
            ConstruirMapa();
    }
    else {
        var posicionActual = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        ultimaPosicionUsuario = posicionActual;
        
        if (is__built__map == true && context__map == true)
            marcadorUsuario.setPosition(posicionActual);
    };

    // createSnackbar('Ubicaciones actualizadas');
    if (is__built__map == true && context__map == true){
        mapa.panTo(ultimaPosicionUsuario);
        
        if (lugar__destino != false) {
            var distancia = google.maps.geometry.spherical.computeDistanceBetween( ultimaPosicionUsuario, lugar__destino );

            console.log(distancia);
            
            if ( distancia < 1000 )
                habilitarControl('#btnConfirmarUbicacion', true);
            else {
                if (flg_show__message__distance == true) {
                    MessageBox({
                        title: 'TAMBOAPP dice',
                        content: 'Aún no estás en el lugar, acércate a donde quieres ir para confirmar tu ubicación y procesar tu pedido',
                        width: '320px',
                        height: '230px',
                        cancelButton: true
                    });

                    flg_show__message__distance = false;
                };

                habilitarControl('#btnConfirmarUbicacion', false);
            };
        };
    };
}

function falloRegistroPosicion(error) {
    console.log('No se pudo determinar la ubicación');

    MessageBox({
        title: 'TAMBOAPP dice',
        content: 'No se pudo determinar la ubicación: ERROR(' + err.code + '): ' + err.message,
        width: '320px',
        height: '200px',
        cancelButton: true
    });

    limpiarUbicacion();
}

function limpiarUbicacion() {
    ultimaPosicionUsuario = new google.maps.LatLng(0, 0);
    if (marcadorUsuario) {
        marcadorUsuario.setMap(null);
        marcadorUsuario = null;
    };
}

function iniciarRegistroPosicion () {
    if (registrandoPosicion) {
        registrandoPosicion = false;
        navigator.geolocation.clearWatch(idRegistroPosicion);
        limpiarUbicacion();
    }
    else {
        // createSnackbar('Buscando...');
        idRegistroPosicion = navigator.geolocation.watchPosition(exitoRegistroPosicion, falloRegistroPosicion, {
            enableHighAccuracy: true,
            maximumAge: 30000,
            timeout: 27000
        });
    };
}

function ConstruirMapa () {
    console.log(lugar__destino);
    
    var mapOptions = {
        zoom: 14,
        scrollwheel: true,
        center: lugar__destino,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    mapa = new google.maps.Map(document.getElementById('google-map'), mapOptions);

    marcadorUsuario = new google.maps.Marker({
        position: ultimaPosicionUsuario,
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            strokeColor: "#336699",
            scale: 10
        },
        draggable: false,
        map: mapa
    });
    
    var marker__destino = new google.maps.Marker({
        position: lugar__destino,
        draggable: false,
        map: mapa
    });

    var line = new google.maps.Polyline({
        path: [
            ultimaPosicionUsuario,
            lugar__destino
        ],
        strokeColor: "#0DA6DA",
        strokeOpacity: 1.0,
        strokeWeight: 10,
        map: mapa
    });
    
    marcadorUsuario.setPosition(ultimaPosicionUsuario);
    is__built__map = true;
}

function showModalUbicacion(){
    flg_show__message__distance = true;

    openModalCallBack('#modalConfirmUbicacion',  function () {
        registrarPosicion();
    });
}

function showLocal (_row) {
    var _idempresa = _row.getAttribute('data-idempresa');
    var _idcentro = _row.getAttribute('data-idcentro');
    var _destino_lat = _row.getAttribute('data-lat');
    var _destino_lng = _row.getAttribute('data-lng');

    var _cantidad = 1;
    var _precio = Number(_row.getAttribute('data-importe'));

    $('#hdIdEmpresa').val(_idempresa);
    $('#hdIdCentro').val(_idcentro);
    $('#hdCantidad').val(_cantidad);
    $('#hdPrecio').val(_precio);

    var _logo = _row.getElementsByClassName('image__centro')[0].getAttribute('data-src');

    if (_logo == 'no-set')
        _logo = 'images/if_business-work_9_2377637.png';
    
    $('#imgLogo__Local').attr('src', _logo);

    var name = _row.getElementsByClassName('resultItem-name')[0].textContent;
    var address = _row.getElementsByClassName('resultItem-address')[0].textContent;
    var ratingValue = _row.getElementsByClassName('rating-ratingValue')[0].textContent;


    document.getElementById('lblTitle__Local').textContent = name;
    document.getElementById('lblAddress__Local').textContent = address;
    document.getElementById('lblCounter__Local').textContent = ratingValue;

    var destino = new google.maps.LatLng(_destino_lat, _destino_lng);
    lugar__destino = destino;

    var _subtotal = _precio * _cantidad;

    $('#hdSubTotal').val(_subtotal.toFixed(2));
    console.log(destino);
    
    VerLocal();
}