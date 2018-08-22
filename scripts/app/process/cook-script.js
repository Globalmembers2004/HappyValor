$(function(){
    atencion_Notif();
    ListarMesas();

    // $('.divContent').scroll(function(){
    //     if ($(this).scrollTop() > 100)
    //         $('#btnBackTables').removeClass('oculto');
    //     else
    //         $('#btnBackTables').addClass('oculto');
    // });

    $('#gvArticuloMenu_SinAtender').on('click', 'input:checkbox', function(event) {
        if (this.checked)
            $('#btnAtenderSeleccion').removeClass('hide');
        else {
            if ($('#gvArticuloMenu_SinAtender input:checkbox:checked').length == 0)
                $('#btnAtenderSeleccion').addClass('hide');
        };
    });

    $('#gvArticuloMenu_Atendidos').on('click', 'input:checkbox', function(event) {
        if (this.checked)
            $('#btnCompletarSeleccion').removeClass('hide');
        else {
            if ($('#gvArticuloMenu_Atendidos input:checkbox:checked').length == 0)
                $('#btnCompletarSeleccion').addClass('hide');
        };
    });

    $('#btnAtenderSeleccion').on('click', function (event) {
        event.preventDefault();
        $(this).addClass('hide');
        $('#hdTipoAccion').val('SELECTION');
        GuardarCambios('01');
    });

    $('#btnCompletarSeleccion').on('click', function (event) {
        event.preventDefault();
        $(this).addClass('hide');
        $('#btnAtenderSeleccion').addClass('hide');
        $('#hdTipoAccion').val('SELECTION');
        GuardarCambios('02');
    });

    $('#btnAtenderOrden').on('click', function (event) {
        event.preventDefault();
        $(this).addClass('hide');
        $('#hdTipoAccion').val('ALL');
        GuardarCambios('01');
    });

    $('#btnCompletarOrden').on('click', function (event) {
        event.preventDefault();
        $(this).addClass('hide');
        $('#btnAtenderOrden').addClass('hide');
        $('#hdTipoAccion').val('ALL');
        GuardarCambios('02');
    });

    // $('#btnClearSelection').on('click', function (event) {
    //     event.preventDefault();
    //     $('.contentPedido table tbody tr.selected').removeClass('selected');
    //     $('#btnAtenderItem, #btnCompletarItem').addClass('oculto');
    //     $('.contentPedido table tbody input:checkbox').removeAttr('checked');
    //     $('#btnAtenderPedido, #btnCompletarPedido').removeClass('oculto');
    //     $(this).addClass('oculto');
    // });
});

var gvOrdenes = new DataList('#gvOrdenes', {
    onSearch: function () {
    },
    onInitSelecting: function (event) {
        clearOneSelectedOrder();
    },
    onSelectClear: function () {
        $('#gvOrdenes .dato:first').addClass('oneSelected');
        $('#btnConfirmOrder').addClass('hide');
    },
    oneItemClick: function (event) {
        event.preventDefault();
        event.stopPropagation();

        clearOneSelectedOrder();
        
        var elem = event.target;
        var item = getParentsUntil(elem, '#gvOrdenes', '.dato');

        // console.log(item);
        
        // item = item[0];
        $(item).addClass('oneSelected');

        var id_orden = item[0].getAttribute('data-idorden');
        
        $('#hdIdAtencion').val(id_orden);

        $('#btnAtenderSeleccion, #btnCompletarSeleccion').addClass('hide');
        $('#btnCompletarOrden').addClass('hide');

        listarDetalle('00', id_orden);
        listarDetalle('01', id_orden);
    }
});

var progressError = false;

function GuardarCambios (EstadoNuevo) {
    var data = new FormData();
    var id_orden = $('#hdIdAtencion').val();
    var selector = EstadoNuevo == '01' ? '#gvArticuloMenu_SinAtender' : '#gvArticuloMenu_Atendidos';

    data.append('hdEstadoNuevo', EstadoNuevo);
    data.append('hdTipoAccion', $('#hdTipoAccion').val())
    data.append('hdIdAtencion', id_orden);

    var input_data = $(selector + ' :input').serializeArray();

    Array.prototype.forEach.call(input_data, function(fields){
        data.append(fields.name, fields.value);
    });

    $.ajax({
        type: "POST",
        url: 'services/atencion/despacho-post.php',
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        data: data
,        success: function(data){
            createSnackbar(data.titulomsje);

            if (data.rpta != '0') {
                var orden = $('#gvOrdenes .dato[data-idorden="' + id_orden + '"]');
                var mesa = getParentsUntil(orden[0], '#gvOrdenes', '.panel');

                console.log(orden);
                console.log(mesa);

                orden.find('.mdl-card__media').css('background-color', data.ColorEstado);

                listarDetalle('00', id_orden);
                listarDetalle('01', id_orden);
                
                if (data.EstadoAtencion == '05'){
                    orden.remove();

                    if ($('#gvOrdenes .dato').length == 0)
                        $(mesa).remove();
                };
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function clearOneSelectedOrder () {
    $('#gvOrdenes .dato').removeClass('oneSelected');
}

function crearItems_Orden (ordenes) {
    var strhtml = '';
    var j = 0;
    var count_ordenes = 0;

    if (ordenes.length == 1){
        if (typeof ordenes[0].tm_nroatencion !== 'undefined')
            count_ordenes = ordenes[0].tm_nroatencion.trim().length == 0 ? 0 : 1;
        else
            count_ordenes = 1;
    }
    else
        count_ordenes = ordenes.length;

    if (count_ordenes > 0){
        while (j < count_ordenes){
            if (typeof ordenes[j] !== 'undefined') {
                strhtml = '<div data-idorden="' + ordenes[j].tm_idatencion + '" class="demo-card-order dato mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp">';

                strhtml += '<input type="checkbox" class="hide" value="' + ordenes[j].tm_idatencion + '" />';

                strhtml += '<div class="mdl-card__media pos-rel" style="min-height: 140px;">';
                strhtml += '<h4 class="no-margin text-center block centered white-text" style="height: 30px; width: 100%;">';
                strhtml += '<strong>ORDEN</strong>: ' + ordenes[j].tm_nroatencion;
                strhtml += '</h4>';
                strhtml += '</div>';

                 strhtml += '<div class="mdl-card__title">';
                
                strhtml += '<h5 class="align-right">';
                strhtml += '<span class="padding-right10 padding-left10 place-right"><strong>MOZO</strong>: Admin</span>';
                strhtml += '</h5>';
                
                strhtml += '</div>';

                strhtml += '<div class="mark-selected pos-abs indigo accent-4 white-text circle"><i class="material-icons centered">&#xE5CA;</i></div>';

                strhtml += '<i class="icon-select centered material-icons white-text circle">&#xE5CA;</i>';
                strhtml += '<div class="layer-select"></div>';

                strhtml += '</div>';
            };
            ++j;
        };
    };

    return strhtml;
}

function crearItems_Mesa (idmesa, infomesa, ordenes) {
    var strhtml = '';
    strhtml += '<div class="panel panel-default mdl-cell mdl-cell--12-col" data-idmesa="' + idmesa + '">';
    strhtml += '<div class="panel-heading">';
    strhtml += '<h3 class="panel-title">Mesa: ' + infomesa + '</h3>';
    strhtml += '</div>';
    strhtml += '<div class="panel-body flexibox-row">';

    strhtml += crearItems_Orden(ordenes);

    strhtml += '</div>';
    strhtml += '</div>';
    return strhtml;
}

function atencion_Notif () {
    var comet = new Comet(
        'services/atencion/despacho-update.php', {'idempresa': $('#hdIdEmpresa').val(), 'idcentro': $('#hdIdCentro').val(), 'estadoatencion': '03'}, function (data) {
        agregarDataNotificacion(data);
    });
    comet.connect();
}

var agregarDataNotificacion = function (_data) {
    if (typeof _data.idatencion != 'undefined') {
        if (_data.idatencion != '0') {
            var idatencion  = _data.idatencion;            
            var nroatencion  = _data.nroatencion;

            ListarMesas(idatencion);
            playNotifSound();

            showNotification('Orden N# ' + nroatencion, 'Esta orden requiere de su atención!', {
                click: function (event) {
                    var id_despacho = config['despacho'].id;

                    window.top.document.querySelector('.mdl-card[data-id="' + id_despacho + '"]').trigger('click');
                    event.target.close();
                }
            });
        };
    };
};

function ListarMesas (idatencion) {
    var _idatencion = typeof idatencion === 'undefined' ? '0' : idatencion;

    $.ajax({
        url: 'services/atencion/atencion-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: 'ATENCION-COOK',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idambiente: '0',
            idmesas: '0',
            idatencion: _idatencion,
            estado: '03,04'
        },
        cache: false,
        success: function (result) {
            var strhtml = '';
            var i = 0;
            
            var groups = _.groupBy(result, function(value){
                return value.tm_idmesa + '#' + value.infomesa;
            });
            
            var data = _.map(groups, function(group){
                return {
                    tm_idmesa: group[0].tm_idmesa,
                    infomesa: group[0].infomesa,
                    list_atencion: group
                };
            });

            var countdata = data.length;

            if (countdata > 0){
                if (_idatencion == '0'){
                    while(i < countdata){
                        strhtml += crearItems_Mesa(data[i].tm_idmesa, data[i].infomesa, data[i].list_atencion);
                        ++i;
                    };

                    $('#gvOrdenes .gridview-content').html(strhtml);
                }
                else {
                    var mesa = $('#gvOrdenes .panel[data-idmesa="' + data[i].tm_idmesa + '"]');

                    if (mesa.length == 0){
                        strhtml = crearItems_Mesa(data[i].tm_idmesa, data[i].infomesa, data[i].list_atencion);
                        $('#gvOrdenes .gridview-content').after(strhtml);
                    }
                    else {
                        var orden = $('#gvOrdenes .dato[data-idorden="' + data[i].list_atencion[0].tm_idatencion + '"]');
                        if (orden.length == 0) {
                            strhtml = crearItems_Orden(data[i].list_atencion);

                            mesa.find('.panel-body').prepend(strhtml);
                        };
                    };
                };
            };
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function listarDetalle (estado, idatencion) {
    $.ajax({
        url: 'services/atencion/detallearticulo-search.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipo: '3',
            idatencion: idatencion,
            estado: estado
        },
        success: function (result) {
            var total_orden = 0;
            var selector = estado == '00' ? '#gvArticuloMenu_SinAtender' : '#gvArticuloMenu_Atendidos';
            var strhtml = '';
            var i = 0;
            
            var groups = _.groupBy(result, function(value){
                return value.td_idatencion_articulo + '#' + value.idArticulo + '#' + value.nombreArticulo + '#' + value.td_precio + '#' + value.td_cantidad + '#' + value.td_subtotal + '#' + value.td_observacion + '#' + value.tm_foto;
            });
            
            var data = _.map(groups, function(group){
                return {
                    td_idatencion_articulo: group[0].td_idatencion_articulo,
                    idArticulo: group[0].idArticulo,
                    nombreArticulo: group[0].nombreArticulo,
                    td_precio: group[0].td_precio,
                    td_cantidad: group[0].td_cantidad,
                    td_subtotal: group[0].td_subtotal,
                    td_observacion: group[0].td_observacion,
                    tm_foto: group[0].tm_foto,
                    list_articulo: group
                };
            });

            var countdata = data.length;

            if (countdata > 0) {
                while (i < countdata){
                    var cantidad = Number(data[i].td_cantidad).toFixed(0);
                    var precio = Number(data[i].td_precio).toFixed(2);
                    var subtotal = Number(data[i].td_subtotal);

                    strhtml += '<div class="demo-card-article margin10 mdl-card mdl-shadow--2dp">';

                    strhtml += '<div class="mdl-card__title mdl-card--expand no-padding pos-rel">';
                    strhtml += '<div class="mdl-grid mdl-grid--no-spacing full-size" style="height: 143px;">';
                    
                    var j = 0;
                    var detalle = data[i].list_articulo;
                    
                    if (detalle.length == 1){
                        if (detalle[0].nombreProducto.trim().length == 0)
                            count_detalle = 0;
                        else
                            count_detalle = detalle.length;
                    }
                    else
                        count_detalle = detalle.length;

                    if (count_detalle > 0){
                        strhtml += '<div class="mdl-cell mdl-cell--8-col all-height"><div class="scrollbarra padding10">';
                        while (j < count_detalle){
                            if (typeof detalle[j] !== 'undefined')
                                strhtml += '<div class="chip margin5">' + detalle[j].nombreProducto + '</div>';
                            ++j;
                        };
                        strhtml += '</div>';
                    }
                    else
                        strhtml += '<div class="mdl-cell mdl-cell--8-col all-height demo-card-article__photo" style="background-image: url(' + data[i].tm_foto.replace('_o', '_s225') + ');">';

                    strhtml += '</div>';
                    strhtml += '<div class="mdl-cell mdl-cell--4-col all-height">';
                    strhtml += '<div class="padding10 place-top-right indigo-text"><strong>' + data[i].nombreArticulo + '</strong></div>';
                    strhtml += '<div class="padding10 place-bottom-right">';

                    strhtml += '<p class="text-right"><input type="hidden" name="mc_articulo[' + i + '][cantidad]" id="cantidad' + i + '" value="' + cantidad + '"><strong>Cantidad: ' + cantidad + '</strong></p>';

                    strhtml += '<p class="text-right"><input type="hidden" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + precio + '"><strong>Precio: ' + precio + '</strong></p>';

                    strhtml += '</div>';
                    strhtml += '</div></div>';

                    strhtml += '</div>';
                    
                    strhtml += '<div class="mdl-card__actions mdl-card--border">';
                    
                    strhtml += '<input type="checkbox" class="filled-in" name="chkItem[]" id="chkItem' + i + data[i].td_idatencion_articulo + '"  value="' + data[i].td_idatencion_articulo + '" /><label for="chkItem' + i + data[i].td_idatencion_articulo + '">SELECCIONAR</label>';

                    strhtml += '<div class="mdl-layout-spacer"></div>';
                    strhtml += '<p><strong class="text-right"><input type="hidden" name="mc_articulo[' + i + '][subtotal]" id="subtotal' + i + '" value="' + subtotal.toFixed(2) + '">Importe: S/. ' + subtotal.toFixed(2) + '</strong></p>';
                    strhtml += '</div>';

                    strhtml += '</div>';

                    ++i;
                };

                if (estado == '00')
                    $('#btnAtenderOrden').removeClass('hide');
                else
                    $('#btnCompletarOrden').removeClass('hide');
            };
            
            $(selector).html(strhtml);
        },
        error: function (error) {
            console.log(error);
        }
    });   
}

// function listarDetalle_Articulo (estado, idatencion) {
//     $.ajax({
//         url: 'services/atencion/detallearticulo-search.php',
//         type: 'GET',
//         data: {
//             tipo: '3',
//             idatencion: idatencion,
//             estado: estado
//         },
//         dataType: 'json',
//         cache: false,
//         success: function (data) {
//             var countdata = data.length;
//             var total_orden = 0;
//             var strhtml = '';
//             var selector = estado == '00' ? '#gvArticuloMenu_SinAtender' : '#gvArticuloMenu_Atendidos';

//             if (countdata > 0){
//                 var i = 0;

//                 while(i < countdata){
//                     var cantidad = data[i].td_cantidad;
//                     var precio = Number(data[i].td_precio).toFixed(2);
//                     var subtotal = Number(data[i].td_subtotal);
                    
//                     strhtml += '<tr data-idmodel="' +  data[i].tm_idproducto + '" class="dato">';

//                     strhtml += '<td>';

//                     // strhtml += '<label class="mdl-input-js mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check-filled" for="chkDetalle' + i + '"><input name="mc_articulo[' + i + '][chkDetalle]" type="checkbox" id="chkDetalle' + i + '" class="mdl-checkbox__input check-articulo" value="0"><span class="mdl-checkbox__label"></span></label>';

//                     strhtml += '<p><input name="chkItem[]" type="checkbox" class="filled-in" id="iddetalle' + i + '" value="' + data[i].td_idatencion_articulo + '" /><label for="iddetalle' + i + '"></p>';

//                     strhtml += '<input name="mc_articulo[' + i + '][idproducto]" type="hidden" id="idproducto' + i + '" value="' + data[i].tm_idproducto + '" /></td>';

//                     strhtml += '<td data-title="Articulo" class="v-align-middle nombre-articulo">' + data[i].nombreProducto;

//                     // strhtml += '<input type="hidden" class="subtotal" name="mc_articulo[' + i + '][subtotal]" id="subtotal' + i + '" value="' + precio.toFixed(2) + '" />';

//                     // strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size"><input class="mdl-textfield__input observacion hide" type="text" name="mc_articulo[' + i + '][observacion]" id="observacion' + i + '" placeholder="Ingresa aqu&iacute; m&aacute;s detalles sobre el art&iacute;culo" value=""><label class="mdl-textfield__label" for="observacion' + i + '"></label></div>';

//                     strhtml += '</td>';
                    
//                     strhtml += '<td data-title="Cantidad" class="text-right">';
                    
//                     // strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size"><input disabled class="mdl-textfield__input align-right cantidad" type="text" name="mc_articulo[' + i + '][cantidad]" id="cantidad' + i + '" value="1"><label class="mdl-textfield__label" for="cantidad' + i + '"></label></div>';

//                     // strhtml += '<input type="hidden" name="mc_articulo[' + i + '][cantidad]" id="cantidad' + i + '" value="' + cantidad + '">';

//                     strhtml += cantidad;

//                     strhtml += '</td>';
//                     strhtml += '<td data-title="Precio" class="text-right">';

//                     // strhtml += '<div class="mdl-input-js mdl-textfield mdl-js-textfield full-size"><input disabled class="mdl-textfield__input align-right precio" type="text" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + precio.toFixed(2) + '"><label class="mdl-textfield__label" for="precio' + i + '"></label></div>';

//                     // strhtml += '<input type="hidden" name="mc_articulo[' + i + '][precio]" id="precio' + i + '" value="' + precio + '">';

//                     strhtml += precio;
                    
//                     strhtml += '</td>';

//                     strhtml += '<td data-title="Subtotal" class="text-right">';


//                     // strhtml += '<input type="hidden" name="mc_articulo[' + i + '][subtotal]" id="subtotal' + i + '" value="' + subtotal.toFixed(2) + '">'; 
//                     strhtml += subtotal.toFixed(2);

//                     strhtml += '</td>';
                    
//                     // strhtml += '<td><a class="padding5 mdl-button mdl-button--icon tooltipped center-block" href="#" data-action="send" data-delay="50" data-position="bottom" data-tooltip="Preparar"><i class="material-icons">&#xE163;</i></a></td>';
                    
//                     strhtml += '</tr>';

//                     total_orden += subtotal;

//                     ++i;
//                 };

//                 if (estado == '00') {
//                     $('#btnAtenderOrden').removeClass('hide');
//                     $('#btnCompletarOrden').addClass('hide');
//                 }
//                 else {
//                     $('#btnAtenderOrden').addClass('hide');
//                     $('#btnCompletarOrden').removeClass('hide');
//                 };
//             };
            
//             $(selector + ' tbody').html(strhtml);
//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
// }