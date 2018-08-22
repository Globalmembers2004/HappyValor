$(function () {
    ListarCartas('1');
    gridEvents('#gvCarta', '.dato', MostrarCarta);
    listdataEvents_default();

    $('#gvCarta').on('click touchend', '.dropdown a', function(event) {
        event.preventDefault();

        var idmodel = '0';
        var accion = this.getAttribute('data-action');
        var parent = this.parentNode.parentNode.parentNode.parentNode;

        if (accion == 'view-content') {
            MostrarCarta(parent);
        }
        else if (accion == 'activate') {
            confirmar = confirm('¿Desea activar esta carta?');
            
            if (confirmar){
                ActivarCarta(parent);
            };
        }
        else if (accion == 'edit') {
            idmodel = parent.getAttribute('data-idmodel');
            GoToEditCarta(idmodel);
        }
        else if (accion == 'delete'){
            confirmar = confirm('¿Desea eliminar este elemento?');
            
            if (confirmar){
                EliminarItemCarta(parent, 'single');
            };
        };
    });

    // $('#nav').on('click', 'li > a', function() {
    //     var linkAmb = $(this);
    //     if (!linkAmb.parent().hasClass('active')) {
    //         $('#hdIdOrden').val(linkAmb.attr('data-idseccion'));
            
    //         $('#nav .is-open').removeClass('is-open').hide(300);
    //         linkAmb.next().toggleClass('is-open').toggle(300, function () {
    //             ListarPlatos('03', $('#hdFecha').val());
    //         });
          
    //         $('#nav').find('.active').removeClass('active');
    //         linkAmb.parent().addClass('active');
    //     }
    //     else {
    //         $('#nav .is-open').removeClass('is-open').hide(300);
    //         linkAmb.parent().removeClass('active');
    //         if ($('#nav li.active').length == 0){
    //             $('#hdIdOrden').val('0');
    //         }
    //     }
    // });

    // $('#gvProductos').on('click', '.tile > .tile_true_content', function(event) {
    //     var TipoCarta = '';
    //     var _inputSpinner = $(this).parent().find('.input_spinner');
    //     var _tile = $(this).parent();
    //     var _selectorButtons = '#btnLimpiarSeleccion, #btnAsignar';

    //     event.preventDefault();
        
    //     TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

    //     if (_tile.hasClass('selected')){
    //         _tile.find('input:checkbox')[0].checked = false;
    //         _tile.removeClass('selected');
    //         if (_tile.siblings('.selected').length > 0){
    //             $(_selectorButtons).removeClass('oculto');
    //         }
    //         else {
    //             $(_selectorButtons).addClass('oculto');
    //         }
    //         _inputSpinner.hide();
    //     }
    //     else {
    //         $('#btnBuscarArticulos').addClass('oculto');
    //         _tile.find('input:checkbox')[0].checked = true;
    //         _tile.addClass('selected');
    //         $(_selectorButtons).removeClass('oculto');
    //         _inputSpinner.show();
    //     }
    //     return false;
    // });

    // $('#gvGrupos').on('click', '.tile', function(event) {
    //     var nrosecciones = 0;
    //     var i = 0;
    //     var strhtml = '';

    //     event.preventDefault();
        
    //     $('#hdIdGrupo').val($(this).attr('data-idgrupo'));

    //     $('#hdIdOrden').val('1');

    //     nrosecciones = $(this).attr('data-nrosecciones');

    //     if (nrosecciones > 0){
    //         while(i < nrosecciones){
    //             strhtml += '<li>';
    //             strhtml += '<a href="#" data-idseccion="' + (i + 1) + '">Seccion ' + (i + 1) + '</a>';
    //             strhtml += '<section>';
    //             strhtml += '<div class="tile-area gridview">';
    //             strhtml += '</div>';
    //             strhtml += '</section>';
    //             strhtml += '</li>';
    //             ++i;
    //         }
    //     }
        
    //     $(this).siblings('.selected').removeClass('selected');
    //     $(this).addClass('selected');
        
    //     $('#nav').html(strhtml).children('li').first().addClass('active').children('a').next().addClass('is-open').show(300, function () {
    //         ListarPlatos('03', $('#hdFecha').val());
    //     });
    // });

    // $('#pnlConfigMenu .sectionHeader').on('click', 'button', function(event) {
    //     var targedId = $(this).attr('data-target');
    //     var TipoCarta = $(this).attr('data-tipomenu');
    //     var fechaMenu = $('#hdFecha').val();
    //     var CountData = 0;

    //     event.preventDefault();
        
    //     if (TipoCarta == '00'){
    //         if ($('#pnlCarta').css('display') == 'none'){
    //             $('#btnNuevaCarta').removeClass('oculto');
    //             $('#btnBuscarArticulos, #btnBackToPrevious, #btnSelectAll').addClass('oculto');
    //         }
    //         else {
    //             $('#btnNuevaCarta').addClass('oculto');
    //             $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    //             if ($('#pnlCarta .tile-area .tile').length > 0)
    //                 $('#btnSelectAll').removeClass('oculto');
    //         }
    //         $('#btnSelectYearMonth').addClass('oculto');
    //     }
    //     else if (TipoCarta == '01') {
    //         $('#btnNuevaCarta').addClass('oculto');
    //         if ($('#pnlMenu').css('display') == 'none'){
    //             $('#btnSelectYearMonth').removeClass('oculto');
    //             $('#btnBuscarArticulos, #btnBackToPrevious, #btnSelectAll').addClass('oculto');
    //         }
    //         else {
    //             $('#btnSelectYearMonth').addClass('oculto');
    //             $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    //             if ($('#pnlMenu .tile-area .tile').length > 0){
    //                 $('#btnSelectAll').removeClass('oculto');
    //             }
    //         }
    //     }
    //     else {
    //         $('#btnNuevaCarta, #btnSelectYearMonth').addClass('oculto');

    //         if ($('#pnlPacks').css('display') == 'none'){
    //             $('#btnSelectYearMonth').removeClass('oculto');
    //             $('#btnBuscarArticulos, #btnBackToPrevious, #btnSelectAll').addClass('oculto');
    //         }
    //         else {
    //             $('#btnSelectYearMonth').addClass('oculto');
    //             $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    //             if ($('#pnlPacks .tile-area .tile').length > 0){
    //                 $('#btnSelectAll').removeClass('oculto');
    //             }
    //         }
    //     }

    //     if (TipoCarta == '03')
    //         CountData = $('#nav .tile').length;
    //     else if (TipoCarta == '01')
    //         CountData = $('#gvMenu .tile').length;

    //     $(this).siblings('.success').removeClass('success');
    //     $(this).addClass('success');

    //     $('#pnlConfigMenu .sectionContent > section').hide();
    //     $(targedId).show();
    //     $('#hdTipoCarta').val(TipoCarta);
        
    //     ShowHideAperturador (TipoCarta, CountData);
    // });

    // $("#pnlCalendarioPack.responsive-calendar").responsiveCalendar({
    //     time: getOnlyYearMonth(),
    //     onDayClick: function(events) {
    //         var fecha = '';
    //         var estado = '';

    //         var anho = $(this).data('year');
    //         var mes = $(this).data('month');
    //         var dia = $(this).data('day');
            
    //         fecha = anho + '-' + addLeadingZero(mes) + '-' + addLeadingZero(dia);

    //         var currentDay = $('#pnlCalendarioPack .day:not(.not-current) a[data-day="' + dia + '"][data-month="' + mes + '"][data-year="' + anho + '"]').parent();

    //         estado = currentDay.attr('data-estado');

    //         $('#hdEstadoApertura').val(estado);
    //         $('#hdFecha').val(fecha);

    //         $('#gvGrupos').attr({'data-fecha': fecha, 'data-estado': estado});
            
    //         GoToPacks();
    //     },
    //     onInit: function () {
    //         setTimeout(function () {
    //             var anho = $('#hdCurrentYear').val();
    //             var mes = Number($('#hdCurrentMonth').val());
    //              ListarDiasAsignados(anho, mes, '03');
    //         }, 1000);
    //     },
    //     onMonthChange: function () {
    //         setTimeout(function () {
    //             var firstDay = $("#pnlCalendarioPack .responsive-calendar .days .day:not(.not-current)").first().children('a');
    //             var anho = firstDay.attr('data-year');
    //             var mes = firstDay.attr('data-month');
    //             ListarDiasAsignados(anho, mes, '03');
    //         }, 1000);
    //     }
    // });

    $('#btnOpcionesMenu').on('click', function(event) {
        event.stopPropagation();
        $('#mnuOpcionesMenu').addClass('is-visible');
    });

    $('#btnOpcionesCarta').on('click', function(event) {
        event.stopPropagation();
        $('#mnuOpcionesCarta').addClass('is-visible');
    });

    $("#pnlCalendarioIndividual").responsiveCalendar({
        time: getOnlyYearMonth(),
        onDayClick: function(events) {
            var fecha = '';
            var estado = '';

            var anho = $(this).data('year');
            var mes = $(this).data('month');
            var dia = $(this).data('day');
            
            fecha = anho + '-' + addLeadingZero(mes) + '-' + addLeadingZero(dia);

            var currentDay = $('#pnlCalendarioIndividual .day:not(.not-current) a[data-day="' + dia + '"][data-month="' + mes + '"][data-year="' + anho + '"]').parent();

            estado = $(currentDay).attr('data-estado');

            $('#hdEstadoApertura').val(estado);
            $('#hdFecha').val(fecha);

            $('#gvMenu').attr({'data-fecha': fecha, 'data-estado': estado});

            GoToMenu();
        },
        onInit: function () {
            setTimeout(function () {
                var anho = $('#hdCurrentYear').val();
                var mes = Number($('#hdCurrentMonth').val());
                 ListarDiasAsignados(anho, mes, '01');
            }, 1000);
        },
        onMonthChange: function () {
            setTimeout(function () {
                var firstDay = $("#pnlCalendarioIndividual .responsive-calendar .days .day:not(.not-current)").first().children('a');
                var anho = firstDay.attr('data-year');
                var mes = firstDay.attr('data-month');
                ListarDiasAsignados(anho, mes, '01');
            }, 1000);
        }
    });

    // $('#ddlCategoria').focus().on('change', function () {
    //     $('#hdPageProd').val('1');
    //     idreferencia = $(this).val();
    //     habilitarControl('#ddlSubCategoria', false);
    //     $('#ddlSubCategoria').find('option').remove();
    //     $('#ddlSubCategoria').append('<option value="0">TODOS</option>');
    //     LoadSubCategorias(idreferencia, '#ddlSubCategoria');
    //     BuscarProductos('1');
    // });

    // $('#ddlSubCategoria').on('change', function () {
    //     $('#hdPageProd').val('1');
    //     BuscarProductos('1');
    // });

    // $('#btnBackList').on('click', function () {
    //     BackToList();
    //     $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    //     LimpiarSelecciones();
    //     return false;
    // });

    // $('#txtSearch').on('keydown', function(event) {
    //     if (event.keyCode == $.ui.keyCode.ENTER) {
    //         BuscarProductos('1');
    //         return false;
    //     }
    // }).on('keypress', function(event) {
    //     if (event.keyCode == $.ui.keyCode.ENTER)
    //         return false;
    // });

    // $('#btnSearch').on('click', function (e) {
    //     BuscarProductos('1');
    //     return false;
    // });

    // $('#pnlListaCartas .tile-area').on('contextmenu', '.tile', function(event) {
    //     event.preventDefault();
    //     var checkBox = $(this).find('input:checkbox');
    //     if ($(this).hasClass('selected')){
    //         $(this).removeClass('selected');
    //         checkBox.removeAttr('checked');
    //         if ($('#gvCarta .gridview .dato.selected').length == 0){
    //             $('#btnNuevaCarta').removeClass('oculto');
    //             $('#btnClearCarta, #btnEditarCarta, #btnEliminarCarta, #btnSetCarta').addClass('oculto');
    //         }
    //         else {
    //             if ($('#gvCarta .gridview .dato.selected').length == 1){
    //                 $('#btnClearCarta, #btnEditarCarta, #btnSetCarta').removeClass('oculto');
    //             }
    //         }
    //     }
    //     else {
    //         $(this).addClass('selected');
    //         checkBox.attr('checked', '');
    //         $('#btnNuevaCarta').addClass('oculto');
    //         $('#btnClearCarta, #btnEliminarCarta').removeClass('oculto');
    //         if ($('#gvCarta .gridview .dato.selected').length == 1)
    //             $('#btnEditarCarta, #btnSetCarta').removeClass('oculto');
    //         else
    //             $('#btnEditarCarta, #btnSetCarta').addClass('oculto');
    //     }
    //     $('#hdIdCarta').val($(this).attr('data-idcarta'));
    // });

    // var longpress = false;

    // $('#gvCarta').on('click', '.dato', function (event) {
    //     event.preventDefault();
    //     $('#hdIdCarta').val($(this).attr('data-idcarta'));
    //     if (longpress){
    //         var checkBox = $(this).find('input:checkbox');
    //         if ($(this).hasClass('selected')){
    //             $(this).removeClass('selected');
    //             checkBox.removeAttr('checked');
    //             if ($('#gvCarta .gridview .dato.selected').length == 0){
    //                 $('#btnNuevaCarta').removeClass('oculto');
    //                 $('#btnClearCarta, #btnEditarCarta, #btnEliminarCarta').addClass('oculto');
    //             }
    //             else {
    //                 if ($('#gvCarta .gridview .dato.selected').length == 1)
    //                     $('#btnClearCarta, #btnEditarCarta').removeClass('oculto');
    //                 else
    //                     $('#btnEliminarCarta').removeClass('oculto');
    //             }
    //         }
    //         else {
    //             $(this).addClass('selected');
    //             checkBox.attr('checked', '');
    //             $('#btnNuevaCarta').addClass('oculto');
    //             $('#btnClearCarta, #btnEliminarCarta').removeClass('oculto');
    //             if ($('#gvCarta .gridview .dato.selected').length == 1)
    //                 $('#btnEditarCarta').removeClass('oculto');
    //             else
    //                 $('#btnEditarCarta').addClass('oculto');
    //             $('#btnEliminarCarta').removeClass('oculto');
    //         }
    //         return false;
    //     }
    //     else {
    //         $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    //         $('#btnNuevaCarta, #btnEditarCarta, #btnEliminarCarta, #btnSetCarta, #btnClearCarta').addClass('oculto');
            
    //         clearView('00');
    //         $('#pnlListaCartas').fadeOut(500, function () {
    //             $('#pnlCarta').fadeIn(500, function () {
    //                 ListarPlatos('00', $('#hdFecha').val());
    //             });
    //         });
    //         $('#gvCarta .gridview .dato').removeClass('selected');
    //     }
    // }).disableSelection();

    // var startTime, endTime;
    // $('#pnlListaCartas .tile-area').on('mousedown', '.tile', function () {
    //     startTime = new Date().getTime();
    // });

    // $('#pnlListaCartas .tile-area').on('mouseup', '.tile', function () {
    //     endTime = new Date().getTime();
    //     longpress = (endTime - startTime < 300) ? false : true;
    // });

    // if ($('#btnFilter').length > 0){
    //     $('#btnFilter').on('click', function(){
    //         if (!$(this).hasClass('active')){
    //             $(this).addClass('active');
    //             $('.filtro').slideDown();
    //             if ($('#ddlCategoria').length > 0)
    //                 $('#ddlCategoria').focus();
    //         }
    //         else {
    //             $(this).removeClass('active');
    //             $('.filtro').slideUp();
    //             $('#txtSearch').focus();                
    //         }
    //         return false;
    //     });
    // }
    
    $('#btnAsignar').on('click', function (event) {
        event.preventDefault();
        AsignarSeleccion('N');
    });

    $('#btnBuscarArticulos').on('click', function(event) {
        event.preventDefault();
        $('#btnBuscarArticulos, #btnAperturarMenu, #btnBackToPrevious, #btnGuardarCambios, #btnLimpiarSeleccion, #btnEliminar').addClass('oculto');

        if ($('#gvProductos .tile').length > 0)
            $('#btnSelectAll').removeClass('oculto');
        GoToArticles();
    });

    $('#btnGuardarCambios').on('click', function (event) {
        event.preventDefault();
        AsignarSeleccion('M');
    });

    // $('#btnEliminar').on('click', function (event) {
    //     var TipoCarta = '';
        
    //     event.preventDefault();

    //     TipoCarta =  $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

    //     $('#hdTipoCarta').val(TipoCarta);
    //     EliminarDatos();
    // });

    // $("#btnLimpiarSeleccion").on('click', function(event){
    //     event.preventDefault();
    //     LimpiarSelecciones();
    // });

    // $('#btnClearCarta').on('click', function(event) {
    //     event.preventDefault();
    //     ClearSelectCarta();
    // });

    // $('#btnSetCarta').on('click', function(event) {
    //     event.preventDefault();
    //     ActivarCarta();
    // });

    $('#btnNuevo').on('click', function(event) {
        event.preventDefault();

        if ($('#pnlListaCartas').is(':visible')){
            GoToEditCarta('0');
        };
    });

    $('#btnGuardarCarta').on('click', function(event) {
        event.preventDefault();
        GuardarCarta();
    });

    $('#btnBackToPrevious').on('click', function(event) {
        event.preventDefault();
        BackToPrevious();
    });

    $('#lnkShowFavs').on('click', function (event) {
        var TipoCarta = '';

        event.preventDefault();

        TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

        if ($(this).hasClass('active'))
            $(this).removeClass('active').attr('title', 'Mostrar favoritos');
        else
            $(this).addClass('active').attr('title', 'Mostrar todo');;

        ListarPlatos(TipoCarta, $('#hdFecha').val());
    });

    $('#btnAperturarMenu').on('click', function(event) {
        event.preventDefault();
        AperturarMenu();
    });

    // $('#pnlConfigMenu').on('click', '.tile > .tile_true_content', function(event) {
    //     var TipoCarta = '';
    //     var _inputSpinner = $(this).parent().find('.input_spinner');
    //     var _tile = $(this).parent();
    //     var _selectorButtons = '#btnLimpiarSeleccion, #btnGuardarCambios';

    //     event.preventDefault();
        
    //     TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

    //     if (_tile.hasClass('selected')){
    //         _tile.find('input:checkbox')[0].checked = false;
    //         _tile.removeClass('selected');
    //         $('#btnBuscarArticulos').removeClass('oculto');
    //         if (_tile.siblings('.selected').length > 0){
    //             $(_selectorButtons).removeClass('oculto');
    //             if (TipoCarta != 'None')
    //                 $('#btnEliminar').removeClass('oculto');
    //         }
    //         else {
    //             $(_selectorButtons).addClass('oculto');
    //             if (TipoCarta != 'None')
    //                 $('#btnEliminar').addClass('oculto');
    //         }
    //         if (TipoCarta != '00')
    //             _inputSpinner.hide();
    //     }
    //     else {
    //         $('#btnBuscarArticulos').addClass('oculto');
    //         _tile.find('input:checkbox')[0].checked = true;
    //         _tile.addClass('selected');
    //         $(_selectorButtons).removeClass('oculto');
    //         if (TipoCarta != 'None')
    //             $('#btnEliminar').removeClass('oculto');
    //         if (TipoCarta != '00')
    //             _inputSpinner.show();
    //     }
    //     return false;
    // });
    
    // eventTileSpinner('#pnlPacks');
    // eventTileSpinner('#pnlCarta');
    // eventTileSpinner('#pnlMenu');
    // eventTileSpinner('#pnlArticulos');
});

var paginaCarta = 1;

function eventTileSpinner (selector) {
    $(selector).on('blur', '.inputCantidad', function(event) {
        event.preventDefault();
        if ($(this).val().trim().length == 0)
            $(this).val('0');
        else
            $(this).val(Number($(this).val()));
    }).numeric(".");

    $(selector).on('click', 'button.up', function(event) {
        event.preventDefault();
        var inputSpinText = $(this).parent().parent().find('input');
        var idProducto = $(this).parent().parent().parent().attr('data-idProducto');
        var stock = Number(inputSpinText.val());
        
        if (stock < 999){
            stock = stock + 1;
            inputSpinText.val(stock);
        }
        return false;
    });

    $(selector).on('click', 'button.down', function(event) {
        var inputSpinText = $(this).parent().parent().find('input');
        var idProducto = $(this).parent().parent().parent().attr('data-idProducto');
        var stock = Number(inputSpinText.val());

        if (stock > 0.01){
            stock = stock - 1;
            inputSpinText.val(stock);
        }
        return false;
    });
}

function GoToPacks () {
    $('#btnSelectYearMonth').addClass('oculto');
    $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    
    $('#pnlCalendarioPack').fadeOut(500, function () {
        $('#pnlPacks').fadeIn(500, function () {
            ListarGrupos('1');
        });
    });
}

function ListarGrupos (pagina) {
    var selector = '#gvGrupos .tile-area';

    precargaExp('#gvGrupos', true);

    $.ajax({
        type: 'GET',
        url: 'services/grupos/grupos-search.php',
        cache: false,
        dataType: 'json',
        data: "tipobusqueda=2&criterio=&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countDatos = data.length;
            var emptyMessage = '';
            var strhtml = '';

            if (countDatos > 0){
                while(i < countDatos){
                    strhtml += '<div data-idgrupo="' + data[i].tm_idgrupoarticulo + '" class="tile dato double bg-olive" data-nrosecciones="' + data[i].tm_nrosecciondefault + '" data-precio="' + Number(data[i].td_precio).toFixed(2) + '" data-click="transform">';
                    strhtml += '<div class="tile-content">';
                    strhtml += '<div class="text-right padding10 ntp">';
                    strhtml += '<h2 class="white-text">' + data[i].tm_simbolo + ' ' + Number(data[i].td_precio).toFixed(2) + '</h2>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    strhtml += '<div class="brand">';
                    strhtml += '<div class="label">' + data[i].tm_nombre + '</div>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    ++i;
                }
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPageGrupo').val(Number($('#hdPageGrupo').val()) + 1);

                $(selector).on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPageGrupo').val();
                        ListarGrupos(pagina);
                    }
                }).find('.tile:first').trigger('click');
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            }
            
            precargaExp('#gvGrupos', false);
        }
    });
}

function BackToPrevious () {
    var TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');    
    
    $('#hdEstadoApertura').val('00');
    $('#btnBackToPrevious, #btnAperturarMenu, #btnSelectAll, #btnBuscarArticulos, #btnGuardarCambios, #btnLimpiarSeleccion, #btnAsignar, #btnEliminar').addClass('oculto');
    
    if (TipoCarta == '00'){
        $('#btnNuevaCarta').removeClass('oculto');
        $('#pnlCarta').fadeOut(500, function () {
            $('#pnlListaCartas').fadeIn(500, function () {
                
            });
        });
    }
    else if (TipoCarta == '01'){
        $('#btnSelectYearMonth').removeClass('oculto');
        $('#pnlMenu').fadeOut(500, function () {
            $('#pnlCalendarioIndividual').fadeIn(500, function () {
                ListarPlatos('01', $('#hdFecha').val());
            });
        });
    }
    else if (TipoCarta == '03'){
        $('#btnSelectYearMonth').removeClass('oculto');
        $('#pnlPacks').fadeOut(500, function () {
            $('#pnlCalendarioPack').fadeIn(500, function () {
                ListarGrupos('1');
            });
        });
    }
}

function AperturarMenu () {
    var TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');    
    
    MessageBox('¿Desea apeturar este men&uacute;?', 'Recuerde que no se podr&aacute;n hacer cambios una vez aperturado el men&uacute;.', "[No], [Si]", function(action){
        if(action == "Si"){
            $.ajax({
                type: 'POST',
                url: 'services/cartadia/cartadia-post.php',
                cache: false,
                data: 'fnPost=fnPost&btnAperturarMenu=btnAperturarMenu&hdTipoCarta=' + TipoCarta + '&hdIdGrupo=' + $('#hdIdGrupo').val() + '&hdFecha=' + $('#hdFecha').val(),
                success: function(data){
                    datos = eval( "(" + data + ")" );
                    if (Number(datos.rpta) > 0){
                        /*MessageBox('Apertura realizada', 'La operaci&oacute;n se complet&oacute; correctamente.', "[Aceptar]", function () {
                            var tipomenudia = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');   
                            
                            
                        });*/
                        BackToPrevious();
                        SetUpInfoCalendar(TipoCarta);
                    }
                }
            });
        }
    });        
}

function ListarCartas (pagina) {
    var selectorgrid = '#gvCarta';
    var selector = selectorgrid + ' .gridview';
    var criterio = $('#txtSearch').val();

    precargaExp('#pnlListaCartas', true);
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartas-search.php',
        cache: false,
        dataType: 'json',
        data: {
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            criterio: criterio,
            pagina: pagina
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var strhtml = '';
            var colorState = '';

            if (countdata > 0){
                while(i < countdata){
                    colorState = (data[i].Actual == 1 ? ' is-active' : '');
                    
                    strhtml += '<li data-idmodel="' + data[i].tm_idcarta + '" class="collection-item dato' + colorState + ' pos-rel expandable" data-baselement="' + selectorgrid + '">';
                    strhtml += '<input type="checkbox" name="chkItemCarta[]" value="' + data[i].tm_idcarta + '" />';

                    strhtml += '<div class="expandable-wrapper generic-panel gp-no-footer">';
                    
                    strhtml += '<h4 class="gp-header">' + data[i].tm_nombre;
                    strhtml += '<button class="hide-expandable place-top-left waves-effect mdl-button mdl-button mdl-button--icon"><i class="material-icons">&#xE5C4;</i></button></h4>';

                    strhtml += '<div class="gp-body"><div class="scrollbarra"></div></div>';

                    strhtml += '</div>';

                    strhtml += '<i class="icon-select height-centered material-icons white-text circle place-top-right">done</i><div class="layer-select"></div>';

                    strhtml += '<div class="grouped-buttons place-bottom-right padding5">';
                    
                    strhtml += '<a class="padding5 mdl-button mdl-button--icon tooltipped" href="#" data-action="more" data-delay="50" data-position="bottom" data-tooltip="M&aacute;s"><i class="material-icons">&#xE5D4;</i></a>';

                    strhtml += '<ul class="dropdown">';

                    strhtml += '<li><a href="#" data-action="view-content" class="waves-effect">Ver contenido</a></li>';
                    strhtml += '<li><a href="#" data-action="activate" class="waves-effect">Activar carta</a></li>';
                    strhtml += '<li><a href="#" data-action="edit" class="waves-effect">Editar</a></li>';
                    strhtml += '<li><a href="#" data-action="delete" class="waves-effect">Eliminar</a></li>';
                    strhtml += '<li><a href="#" data-action="stats" class="waves-effect">Ir a estad&iacute;sticas</a></li>';

                    strhtml += '</ul>';

                    strhtml += '</div>';

                    strhtml += '</li>';
                    ++i;
                };
                
                paginaCarta = paginaCarta + 1;

                $('#hdPageCarta').val(paginaCarta);

                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $(selector + ' .grouped-buttons a.tooltipped').tooltip();
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            };
            
            precargaExp('#pnlListaCartas', false);
        }
    });
}

function  ListarPlatos_Carta(item, pagina) {
    var idcarta = item.getAttribute('data-idmodel');

    precargaExp('.dato.expandable.is-expanded', true);
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idempresa: $('#hdIdEmpresa').val(),
            idcentro: $('#hdIdCentro').val(),
            idcarta: idcarta,
            criterio: '',
            pagina: pagina
        },
        success: function(result){
            var groups = _.groupBy(result, function(value){
                return value.tm_idcategoria + '#' + value.Categoria;
            });
            var data = _.map(groups, function(group){
                return {
                    tm_idcategoria: group[0].tm_idcategoria,
                    Categoria: group[0].Categoria,
                    list_productos: group
                }
            });

            var i = 0;
            var j = 0;
            var productos;
            var count_categorias = data.length;
            var count_productos = 0;
            var strhtml = '';
            var selectorItem = item.querySelector('.expandable-wrapper > .gp-body > .scrollbarra');

            if (count_categorias > 0){
               while(i < count_categorias){
                    strhtml += '<li data-idcategoria="' + data[i].tm_idcategoria + '" class="section-categoria">';
                    strhtml +=  '<header><h4 class="title grey-text text-darken-2">' + data[i].Categoria + '</h4></header>';
                    strhtml +=  '<main>';
                    
                    strhtml +=  '<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">';
                    strhtml +=  '<thead><tr><th class="mdl-data-table__cell--non-numeric">Art&iacute;culo</th><th>Stock</th><th>Precio</th></tr></thead><tbody>';

                    j = 0;
                    productos = data[i].list_productos;
                    count_productos = productos.length;

                    if (count_productos > 0){
                        while (j < count_productos){
                            strhtml +=  '<tr>';
                            strhtml +=  '<td class="mdl-data-table__cell--non-numeric">' + productos[j].nombreProducto + '</td>';
                            strhtml +=  '<td>' + productos[j].td_stockdia + '</td>';
                            strhtml +=  '<td>' + productos[j].simboloMoneda + ' ' + productos[j].td_precio + '</td>';
                            strhtml +=  '</tr>';
                            ++j;
                        };
                    };
                      
                    strhtml +=  '</tbody></table>';

                    strhtml += '</main>';
                    strhtml += '</li>';
                    ++i;
               };
                
                selectorItem.innerHTML = '<ul>' + strhtml + '</ul>';
            };

            precargaExp('.dato.expandable.is-expanded', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
    
}

function MostrarCarta (item) {   
    if (!item.classList.contains('is-expanded')) {
        viewInExpandItem(item);
        ListarPlatos_Carta(item, 1);
    };
}

// function MostrarCarta (item) {
//     viewInExpandItem(item);
//     precargaExp(item, true);

//     $.ajax({
//         type: "GET",
//         url: 'services/categorias/categoria-search.php',
//         cache: false,
//         dataType: 'json',
//         data: {
//             tipobusqueda: '3',
//             idempresa: $('#hdIdEmpresa').val(),
//             idcentro: $('#hdIdCentro').val(),
//             criterio: '',
//             pagina: 0
//         },
//         success: function(data){
//             var icat = 0;
//             var countdata = data.length;
//             var idcategoria = '0';
//             var strhtml = '';
//             var selectorItem = item.querySelector('.expandable-wrapper > .gp-body > .scrollbarra');
//             var itemsCategoria;

//             if (countdata > 0){
//                 while(icat < countdata){
//                     strhtml += '<li data-idcategoria="' + data[icat].tm_idcategoria + '" class="section-categoria">';
//                     strhtml +=  '<header><h4 class="title grey-text text-darken-2">' + data[icat].tm_nombre + '</h4></header>';
//                     strhtml +=  '<main></main>';
//                     strhtml += '</li>';
//                     ++icat;
//                 };
                
//                 selectorItem.innerHTML = '<ul>' + strhtml + '</ul>';

//                 itemsCategoria = selectorItem.querySelector('ul').getElementsByTagName('li');
//             };
            
            
//             precargaExp('.dato.expandable.is-expanded', false);
//         },
//         error: function (data) {
//             console.log(data);
//         }
//     });
// }

function addValidCarta () {
    $('#txtNombreCarta').rules('add', {
        required: true,
        maxlength: 150
    });
}

function removeValidCarta () {
     $('#txtNombreCarta').rules('remove');
}

function GoToEditCarta (idItem) {
    var selectorModal = '#pnlRegistroCarta';

    precargaExp(selectorModal, true);
    
    resetForm(selectorModal);
    removeValidCarta();
    addValidCarta();

    openModalCallBack(selectorModal, function () {
        if (idItem == '0'){
            precargaExp(selectorModal, false);
            $('#txtNombreCarta').focus();
        }
        else {
            $.ajax({
                type: "GET",
                url: 'services/cartadia/cartas-search.php',
                cache: false,
                dataType: 'json',
                data: {
                    tipobusqueda: '2',
                    id: idItem
                },
                success: function (data) {
                    $('#hdIdCarta').val(data[0].tm_idcarta);
                    $('#txtNombreCarta').val(data[0].tm_nombre).focus();
                    precargaExp(selectorModal, false);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        };
    });
}

function GuardarCarta () {
    var data = new FormData();
    var input_data;

    if ($('#form1').valid()){
        input_data = $('#pnlRegistroCarta :input').serializeArray();

        data.append('btnGuardarCarta', 'btnGuardarCarta');
        data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
        data.append('hdIdCentro', $('#hdIdCentro').val());

        $.each(input_data, function(key, fields){
            data.append(fields.name, fields.value);
        });
        
        $.ajax({
            type: 'POST',
            url: 'services/cartadia/cartadia-post.php',
            cache: false,
            dataType: 'json',
            data: data,
            contentType:false,
            processData: false,
            success: function(data){
                MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                    if (Number(data.rpta) > 0){
                        closeCustomModal('#pnlRegistroCarta');
                        ListarCartas('1');
                    };
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    };
}

function ActivarCarta (item) {
    var data = new FormData();
    var idItem = '0';

    idItem = item.getAttribute('data-idmodel');

    data.append('btnSetCarta', 'btnSetCarta');
    data.append('hdIdEmpresa', $('#hdIdEmpresa').val());
    data.append('hdIdCentro', $('#hdIdCentro').val());
    data.append('hdIdCarta', idItem);

    $.ajax({
        type: 'POST',
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        data: data,
        dataType: 'json',
        contentType:false,
        processData: false,
        success: function(data){
            MessageBox(data.titulomsje, data.contenidomsje, "[Aceptar]", function () {
                if (Number(data.rpta) > 0){
                    $('#gvCarta .dato').removeClass('is-active');
                    item.classList.add('is-active');
                };
            });
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function ListarDiasAsignados (anho, mes, tipomenudia) {
    var tipobusqueda = '';
    
    if (tipomenudia == '03')
        tipobusqueda = 'DIAS-GRUPAL';
    else
        tipobusqueda = 'DIAS-INDIVIDUAL';
    
    $.ajax({
        url: 'services/cartadia/cartadia-dias.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            anho: anho,
            mes: mes,
            tipomenudia: tipomenudia
        },
        success: function  (data) {
            var open = '';
            var count = data.length;
            var i = 0;
            var idcalendar = '';

            if (tipomenudia == '03')
                idcalendar = '#pnlCalendarioPack';
            else
                idcalendar = '#pnlCalendarioIndividual';

            if (count > 0) {
                while (i < count){
                    open = (data[i].estado == '01' ? ' open' : '');
                    
                    $(idcalendar + ' .day:not(.not-current) a[data-day="' + data[i].dia + '"][data-month="' + data[i].mes + '"][data-year="' + data[i].anho + '"]').parent().addClass('active' + open).attr('data-estado', data[i].estado);
                    
                    ++i;
                }
            };
        }
    });
}

// function clearView (TipoCarta) {
//     var selector = '';
//     if (TipoCarta == '00')
//         selector = '.section-subcat .tile-area';
//     else if (TipoCarta == '01')
//         selector = '#pnlMenu .tile-area';
//     else if (TipoCarta == '03')
//         selector = '#pnlPacks #nav li.active .tile-area';
//     $(selector).html('');
// }

// function SelectAllItems () {
//     var TipoCarta = '';
//     var selector = '';

//     $('#btnSelectAll').addClass('oculto');
//     $('#btnLimpiarSeleccion').removeClass('oculto');
    
//     if ($('#pnlArticulos').is(':visible')) {
//         selector = '#pnlArticulos';
//         $('#btnAsignar').removeClass('oculto');
//         $('#btnEliminar').addClass('oculto');
//     }
//     else {
//         TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');
//         if (TipoCarta == '00')
//             selector = '#pnlCarta';
//         else if (TipoCarta == '01')
//             selector = '#pnlMenu';
//         else if (TipoCarta == '03')
//             selector = '#nav li.active section';
        
//         $('#btnBuscarArticulos').addClass('oculto');
//         $('#btnEliminar, #btnGuardarCambios').removeClass('oculto');
//     }

//     $(selector + ':visible .tile').addClass('selected');
//     $(selector + ':visible .tile input:checkbox').attr('checked', '');
//     $(selector + ':visible .tile .input_spinner').show();
// }

function GoToMenu () {
    $('#btnSelectYearMonth').addClass('oculto');
    $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    $('#pnlCalendarioIndividual').fadeOut(500, function () {
        $('#pnlMenu').fadeIn(500, function () {
            ListarPlatos('01', $('#hdFecha').val());
        });
    });
}

function GoToArticles () {
    $('#hdTipoCarta').val('None');
    $('#btnSelectYearMonth').addClass('oculto');
    //$('#btnSelectAll').removeClass('oculto');
    $('#pnlListado').fadeOut(500, function () {
        $('#pnlMenuToday').fadeIn(500, function () {
            if ($("#gvProductos .gridview .tile").length == 0)
                BuscarProductos('1');
        });
    });
}

function SetUpInfoCalendar (tipomenu) {
    setTimeout(function () {
        var idcalendar = '';
        var anho = '0';
        var mes = '0';
        
        if (tipomenu == '03')
            idcalendar = '#pnlCalendarioPack';
        else
            idcalendar = '#pnlCalendarioIndividual';

        firstDay = $(idcalendar + " .responsive-calendar .days .day:not(.not-current)").first().children('a');
        anho = firstDay.attr('data-year');
        mes = firstDay.attr('data-month');

        ListarDiasAsignados(anho, mes, tipomenu);
    }, 1000);
}

function BackToList () {
    $('#pnlMenuToday').fadeOut(500, function () {
        //$('#btnSelectYearMonth').removeClass('oculto');
        $('#pnlListado').fadeIn(500, function () {
            var TipoCarta = 0;
            var CountData = 0;

            TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

            if (TipoCarta == '03')
                CountData = $('#nav .tile').length;
            else if (TipoCarta == '01')
                CountData = $('#gvMenu .tile').length;

            ShowHideAperturador(TipoCarta, CountData);

            SetUpInfoCalendar('03');
            SetUpInfoCalendar('01');
            
            $('#txtSearch').focus();
        });
    });
}

function DetalleMenuDia (idCartaMenu, idGrupo, idProducto, idMoneda, fechaMenu, tipoMenuDia, precio, stock, orden) {
    this.idCartaMenu = idCartaMenu;
    this.idGrupo = idGrupo;
    this.idProducto = idProducto;
    this.idMoneda = idMoneda;
    this.fechaMenu = fechaMenu;
    this.tipoMenuDia = tipoMenuDia;
    this.precio = precio;
    this.stock = stock;
    this.orden = orden;
}

// function AsignarSeleccion (TipoEdit) {
//     var listaDetalle = [];

//     var selector = '';
//     var articulos;

//     var i = 0;
//     var count = 0;

//     var idCartaMenu = '0';
//     var idProducto = '0';
//     var idMoneda = '0';
//     var idCategoria = '0';
//     var idSubCategoria = '0';
//     var precio = 0;
//     var stock = 0;
//     var detalleMenu = '';

//     var IdCarta = $('#hdIdCarta').val();
//     var IdGrupo = $('#hdIdGrupo').val();
//     var IdOrden = $('#hdIdOrden').val();
//     var TipoCarta = '';
//     var fechaMenu = $('#hdFecha').val();

//     TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

//     if (TipoEdit == 'N')
//         selector = '#pnlArticulos';
//     else {
//         if (TipoCarta == '00')
//             selector = '#pnlCarta';
//         else if (TipoCarta == '01')
//             selector = '#pnlMenu';
//         else
//             selector = '#nav';
//     }
        
//     articulos = $(selector + ' .tile.selected');
//     count = articulos.length;

//     if (count > 0){
//         if (TipoCarta == '03'){
//             while (i < count){
//                 if (TipoEdit == 'N'){
//                     idCartaMenu = '0';
//                     idProducto = articulos[i].getAttribute('rel');
//                     idMoneda = articulos[i].getAttribute('data-idMoneda');
//                     //precio = Number($(articulos[i]).find('span.precio').text());
//                     stock = Number($(articulos[i]).find('input.inputCantidad').val());
//                 }
//                 else {
//                     idCartaMenu = articulos[i].getAttribute('rel');
//                     idProducto = articulos[i].getAttribute('data-idProducto');
//                     idMoneda = articulos[i].getAttribute('data-idMoneda');
//                     //precio = Number($(articulos[i]).find('input:text').val());
//                     //stock = Number(articulos[i].getAttribute('data-stock'));
//                     stock = Number($(articulos[i]).find('input.inputCantidad').val());
//                 }
//                 var detalle = new DetalleMenuDia(idCartaMenu, IdGrupo, idProducto, idMoneda, fechaMenu, TipoCarta, 0, stock, IdOrden);
//                 listaDetalle.push(detalle);
//                 ++i;
//             }
//             detalleMenu = JSON.stringify(listaDetalle);
//         }
//         else {
//             while (i < count){
//                 if (TipoEdit == 'N'){
//                     idCartaMenu = '0';
//                     idProducto = articulos[i].getAttribute('rel');
//                     idMoneda = articulos[i].getAttribute('data-idMoneda');
//                     precio = Number($(articulos[i]).find('span.precio').text());
//                     stock = Number($(articulos[i]).find('input.inputCantidad').val());
//                 }
//                 else {
//                     idCartaMenu = articulos[i].getAttribute('rel');
//                     idProducto = articulos[i].getAttribute('data-idProducto');
//                     idMoneda = articulos[i].getAttribute('data-idMoneda');
//                     //precio = Number($(articulos[i]).find('input:text').val());
//                     //stock = Number(articulos[i].getAttribute('data-stock'));
//                     stock = Number($(articulos[i]).find('input.inputCantidad').val());
//                 }

//                 var detalle = new DetalleMenuDia (idCartaMenu, 0, idProducto, idMoneda, fechaMenu, TipoCarta, precio.toFixed(2), stock, 0);
//                 listaDetalle.push(detalle);
//                 ++i;
//             }
//             detalleMenu = JSON.stringify(listaDetalle);
//         }

//         $.ajax({
//             type: "POST",
//             url: 'services/cartadia/cartadia-post.php',
//             cache: false,
//             data: {
//                 fnPost: 'fnPost',
//                 hdTipoCarta: TipoCarta,
//                 hdIdCarta: IdCarta,
//                 hdIdGrupo: IdGrupo,
//                 hdIdOrden: IdOrden,
//                 hdFecha: fechaMenu,
//                 btnAsignar: 'btnAsignar',
//                 detalleMenu: detalleMenu
//             },
//             success: function(data){
//                 datos = eval( "(" + data + ")" );
//                 if (Number(datos.rpta) > 0){
//                     MessageBox('Datos guardados', 'La operaci&oacute;n se complet&oacute; correctamente.', "[Aceptar]", function () {
//                         $('#hdPage').val('1');
//                         $('#hdPageActual').val('1');

//                         clearView(TipoCarta);
//                         ListarPlatos(TipoCarta, fechaMenu);
//                         LimpiarSelecciones();
//                         //$('#btnSelectAll').removeClass('oculto');
//                     });
//                 }
//             }
//         });
//     }
// }

function ShowHideAperturador (TipoCarta, CountData) {
    var EstadoApertura = '';
    var fechaMenu = '';
    var flag = false;

    if (!$('#pnlMenuToday').is(':visible')){
        if (TipoCarta != '00'){
            fechaMenu = (TipoCarta == '01' ? $('#gvMenu').attr('data-fecha') : $('#gvGrupos').attr('data-fecha'));

            EstadoApertura = (TipoCarta == '01' ? $('#gvMenu').attr('data-estado') : $('#gvGrupos').attr('data-estado'));
            
            if (EstadoApertura == '00'){
                if (ConvertMySQLDate(fechaMenu) == GetToday()){
                    if (CountData > 0){
                        if (TipoCarta == '01')
                            flag = !$('#pnlCalendarioIndividual').is(':visible');
                        else
                            flag = !$('#pnlCalendarioPack').is(':visible');
                    }
                }
            }
        }
    }
    if (flag)
        $('#btnAperturarMenu').removeClass('oculto');
    else
        $('#btnAperturarMenu').addClass('oculto');
}

function BuscarProductos (pagina) {        
    precargaExp('#gvProductos', true);

    $.ajax({
        url: 'services/productos/productos-search.php',
        type: 'GET',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda:'03',
            idcategoria: $('#ddlCategoria').val(),
            idsubcategoria:  $('#ddlSubCategoria').val(),
            criterio: $('#txtSearch').val(),
            pagina: pagina
        },
        success: function (data) {
            var count = data.length;
            var i = 0;
            var strhtml = '';
            var imagen = '';
            var cssbgtile = '';
            var cssdisplay = '';

            if (count > 0) {
                while(i < count){
                    if (data[i].tm_foto == 'no-set'){
                        imagen = 'images/food-48.png';
                        cssbgtile = ' bg-olive';
                        cssdisplay = 'icon';
                    }
                    else {
                        imagen = data[i].tm_foto;
                        cssdisplay = 'image';
                    }

                    strhtml += '<div class="tile dato double' + cssbgtile + '" rel="' + data[i].tm_idproducto + '" data-nomCategoria="' + data[i].Categoria + '" data-nomSubCategoria="' + data[i].SubCategoria + '" data-idCategoria="' + data[i].tm_idcategoria + '" data-idSubCategoria="' + data[i].tm_idsubcategoria + '" data-idMoneda="' + data[i].tm_idmoneda + '">';
                    
                     strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + data[i].tm_idproducto + '" />';

                    strhtml += '<div class="tile_true_content">';
                    strhtml += '<div class="tile-content ' + cssdisplay + '">';
                    strhtml += '<img src="' + imagen + '" alt="" />';;
                    strhtml += '</div>';
                    strhtml += '<div class="tile-status bg-dark opacity">';
                    strhtml += '<span class="label">' + data[i].nombreProducto + '</span>';
                    strhtml += '<div class="badge bg-red"><span class="moneda">' + data[i].simboloMoneda + ' </span><span class="precio">' + Number(data[i].td_precio).toFixed(2) + '</span></div>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '<div class="input_spinner">';
                    strhtml += '<input type="text" name="txtCantidad" class="inputCantidad" value="5" />';
                    strhtml += '<div class="buttons">';
                    strhtml += '<button type="button" class="up bg-green white-text">+</button>';
                    strhtml += '<button type="button" class="down bg-red white-text">-</button>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';

                    ++i;
                }

                $('#btnSelectAll').removeClass('oculto');

                $('#gvProductos .tile-area').on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPageProd').val();
                        BuscarProductos(pagina);
                    }
                });
                
                $('#hdPageProd').val(Number($('#hdPageProd').val()) + 1);
                
                if (pagina == '1')
                    $('#gvProductos .tile-area').html(strhtml);
                else
                    $('#gvProductos .tile-area').append(strhtml);
            }
            else {
                if (pagina == '1')
                    $('#gvProductos .tile-area').html('<h2>No se encontraron resultados.</h2>');
            }
            precargaExp('#gvProductos', false);
        }
    });
}