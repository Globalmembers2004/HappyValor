<?php
header('Content-type: text/javascript');
require('../../../common/class.translation.php');
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);
?>
var TipoBusqueda = '03';

$(function () {    
    $('#nav').on('click', 'li > a', function() {
        var linkAmb = $(this);
        if (!linkAmb.parent().hasClass('active')) {
            $('#hdIdOrden').val(linkAmb.attr('data-idseccion'));
            
            $('#nav .is-open').removeClass('is-open').hide(300);
            linkAmb.next().toggleClass('is-open').toggle(300, function () {
                ListarPlatos('03', $('#hdFecha').val());
            });
          
            $('#nav').find('.active').removeClass('active');
            linkAmb.parent().addClass('active');
        }
        else {
            $('#nav .is-open').removeClass('is-open').hide(300);
            linkAmb.parent().removeClass('active');
            if ($('#nav li.active').length == 0){
                $('#hdIdOrden').val('0');
            }
        }
    });

    $('#gvProductos').on('click', '.tile > .tile_true_content', function(event) {
        var TipoCarta = '';
        var _inputSpinner = $(this).parent().find('.input_spinner');
        var _tile = $(this).parent();
        var _selectorButtons = '#btnLimpiarSeleccion, #btnAsignar';

        event.preventDefault();
        
        TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

        if (_tile.hasClass('selected')){
            _tile.find('input:checkbox')[0].checked = false;
            _tile.removeClass('selected');
            if (_tile.siblings('.selected').length > 0){
                $(_selectorButtons).removeClass('oculto');
            }
            else {
                $(_selectorButtons).addClass('oculto');
            }
            _inputSpinner.hide();
        }
        else {
            $('#btnBuscarArticulos').addClass('oculto');
            _tile.find('input:checkbox')[0].checked = true;
            _tile.addClass('selected');
            $(_selectorButtons).removeClass('oculto');
            _inputSpinner.show();
        }
        return false;
    });

    $('#gvGrupos').on('click', '.tile', function(event) {
        var nrosecciones = 0;
        var i = 0;
        var strhtml = '';

        event.preventDefault();
        
        $('#hdIdGrupo').val($(this).attr('data-idgrupo'));

        $('#hdIdOrden').val('1');

        nrosecciones = $(this).attr('data-nrosecciones');

        if (nrosecciones > 0){
            while(i < nrosecciones){
                strhtml += '<li>';
                strhtml += '<a href="#" data-idseccion="' + (i + 1) + '">Seccion ' + (i + 1) + '</a>';
                strhtml += '<section>';
                strhtml += '<div class="tile-area gridview">';
                strhtml += '</div>';
                strhtml += '</section>';
                strhtml += '</li>';
                ++i;
            }
        }
        
        $(this).siblings('.selected').removeClass('selected');
        $(this).addClass('selected');
        
        $('#nav').html(strhtml).children('li').first().addClass('active').children('a').next().addClass('is-open').show(300, function () {
            ListarPlatos('03', $('#hdFecha').val());
        });
    });

    $('#pnlConfigMenu .sectionHeader').on('click', 'button', function(event) {
        var targedId = $(this).attr('data-target');
        var TipoCarta = $(this).attr('data-tipomenu');
        var fechaMenu = $('#hdFecha').val();
        var CountData = 0;

        event.preventDefault();
        
        if (TipoCarta == '00'){
            if ($('#pnlCarta').css('display') == 'none'){
                $('#btnNuevaCarta').removeClass('oculto');
                $('#btnBuscarArticulos, #btnBackToPrevious, #btnSelectAll').addClass('oculto');
            }
            else {
                $('#btnNuevaCarta').addClass('oculto');
                $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
                if ($('#pnlCarta .tile-area .tile').length > 0)
                    $('#btnSelectAll').removeClass('oculto');
            }
            $('#btnSelectYearMonth').addClass('oculto');
        }
        else if (TipoCarta == '01') {
            $('#btnNuevaCarta').addClass('oculto');
            if ($('#pnlMenu').css('display') == 'none'){
                $('#btnSelectYearMonth').removeClass('oculto');
                $('#btnBuscarArticulos, #btnBackToPrevious, #btnSelectAll').addClass('oculto');
            }
            else {
                $('#btnSelectYearMonth').addClass('oculto');
                $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
                if ($('#pnlMenu .tile-area .tile').length > 0){
                    $('#btnSelectAll').removeClass('oculto');
                }
            }
        }
        else {
            $('#btnNuevaCarta, #btnSelectYearMonth').addClass('oculto');

            if ($('#pnlPacks').css('display') == 'none'){
                $('#btnSelectYearMonth').removeClass('oculto');
                $('#btnBuscarArticulos, #btnBackToPrevious, #btnSelectAll').addClass('oculto');
            }
            else {
                $('#btnSelectYearMonth').addClass('oculto');
                $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
                if ($('#pnlPacks .tile-area .tile').length > 0){
                    $('#btnSelectAll').removeClass('oculto');
                }
            }
        }

        if (TipoCarta == '03')
            CountData = $('#nav .tile').length;
        else if (TipoCarta == '01')
            CountData = $('#gvMenu .tile').length;

        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');

        $('#pnlConfigMenu .sectionContent > section').hide();
        $(targedId).show();
        $('#hdTipoCarta').val(TipoCarta);
        
        ShowHideAperturador (TipoCarta, CountData);
    });

    $("#pnlCalendarioPack > .responsive-calendar").responsiveCalendar({
        time: '<?php echo date('Y-m') ?>',
        onDayClick: function(events) {
            var fecha = '';
            var estado = '';

            var anho = $(this).data('year');
            var mes = $(this).data('month');
            var dia = $(this).data('day');
            
            fecha = anho + '-' + addLeadingZero(mes) + '-' + addLeadingZero(dia);

            var currentDay = $('#pnlCalendarioPack .day:not(.not-current) a[data-day="' + dia + '"][data-month="' + mes + '"][data-year="' + anho + '"]').parent();

            estado = currentDay.attr('data-estado');

            $('#hdEstadoApertura').val(estado);
            $('#hdFecha').val(fecha);

            $('#gvGrupos').attr({'data-fecha': fecha, 'data-estado': estado});
            
            GoToPacks();
        },
        onInit: function () {
            setTimeout(function () {
                var anho = $('#hdCurrentYear').val();
                var mes = Number($('#hdCurrentMonth').val());
                 ListarDiasAsignados(anho, mes, '03');
            }, 1000);
        },
        onMonthChange: function () {
            setTimeout(function () {
                var firstDay = $("#pnlCalendarioPack .responsive-calendar .days .day:not(.not-current)").first().children('a');
                var anho = firstDay.attr('data-year');
                var mes = firstDay.attr('data-month');
                ListarDiasAsignados(anho, mes, '03');
            }, 1000);
        }
    });

    $("#pnlCalendarioIndividual .responsive-calendar").responsiveCalendar({
        time: '<?php echo date('Y-m') ?>',
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

    $('#ddlCategoria').focus().on('change', function () {
        $('#hdPageProd').val('1');
        idreferencia = $(this).val();
        habilitarControl('#ddlSubCategoria', false);
        $('#ddlSubCategoria').find('option').remove();
        $('#ddlSubCategoria').append('<option value="0"><?php $translate->__('TODOS'); ?></option>');
        LoadSubCategorias(idreferencia, '#ddlSubCategoria');
        BuscarProductos('1');
    });

    $('#ddlSubCategoria').on('change', function () {
        $('#hdPageProd').val('1');
        BuscarProductos('1');
    });

    $('#btnBackList').on('click', function () {
        BackToList();
        $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
        LimpiarSelecciones();
        return false;
    });

    $('#txtSearch').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            BuscarProductos('1');
            return false;
        }
    }).on('keypress', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER)
            return false;
    });

    $('#btnSearch').on('click', function (e) {
        BuscarProductos('1');
        return false;
    });

    $('#pnlListaCartas .tile-area').on('contextmenu', '.tile', function(event) {
        event.preventDefault();
        var checkBox = $(this).find('input:checkbox');
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            checkBox.removeAttr('checked');
            if ($('#gvCarta .gridview .dato.selected').length == 0){
                $('#btnNuevaCarta').removeClass('oculto');
                $('#btnClearCarta, #btnEditarCarta, #btnEliminarCarta, #btnSetCarta').addClass('oculto');
            }
            else {
                if ($('#gvCarta .gridview .dato.selected').length == 1){
                    $('#btnClearCarta, #btnEditarCarta, #btnSetCarta').removeClass('oculto');
                }
            }
        }
        else {
            $(this).addClass('selected');
            checkBox.attr('checked', '');
            $('#btnNuevaCarta').addClass('oculto');
            $('#btnClearCarta, #btnEliminarCarta').removeClass('oculto');
            if ($('#gvCarta .gridview .dato.selected').length == 1)
                $('#btnEditarCarta, #btnSetCarta').removeClass('oculto');
            else
                $('#btnEditarCarta, #btnSetCarta').addClass('oculto');
        }
        $('#hdIdCarta').val($(this).attr('data-idcarta'));
    });

    var longpress = false;

    $('#pnlListaCartas .tile-area').on('click', '.tile', function (event) {
        event.preventDefault();
        $('#hdIdCarta').val($(this).attr('data-idcarta'));
        if (longpress){
            var checkBox = $(this).find('input:checkbox');
            if ($(this).hasClass('selected')){
                $(this).removeClass('selected');
                checkBox.removeAttr('checked');
                if ($('#gvCarta .gridview .dato.selected').length == 0){
                    $('#btnNuevaCarta').removeClass('oculto');
                    $('#btnClearCarta, #btnEditarCarta, #btnEliminarCarta').addClass('oculto');
                }
                else {
                    if ($('#gvCarta .gridview .dato.selected').length == 1)
                        $('#btnClearCarta, #btnEditarCarta').removeClass('oculto');
                    else
                        $('#btnEliminarCarta').removeClass('oculto');
                }
            }
            else {
                $(this).addClass('selected');
                checkBox.attr('checked', '');
                $('#btnNuevaCarta').addClass('oculto');
                $('#btnClearCarta, #btnEliminarCarta').removeClass('oculto');
                if ($('#gvCarta .gridview .dato.selected').length == 1)
                    $('#btnEditarCarta').removeClass('oculto');
                else
                    $('#btnEditarCarta').addClass('oculto');
                $('#btnEliminarCarta').removeClass('oculto');
            }
            return false;
        }
        else {
            $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
            $('#btnNuevaCarta, #btnEditarCarta, #btnEliminarCarta, #btnSetCarta, #btnClearCarta').addClass('oculto');
            
            clearView('00');
            $('#pnlListaCartas').fadeOut(500, function () {
                $('#pnlCarta').fadeIn(500, function () {
                    ListarPlatos('00', $('#hdFecha').val());
                });
            });
            $('#gvCarta .gridview .dato').removeClass('selected');
        }
    }).disableSelection();

    var startTime, endTime;
    $('#pnlListaCartas .tile-area').on('mousedown', '.tile', function () {
        startTime = new Date().getTime();
    });

    $('#pnlListaCartas .tile-area').on('mouseup', '.tile', function () {
        endTime = new Date().getTime();
        longpress = (endTime - startTime < 300) ? false : true;
    });

    if ($('#btnFilter').length > 0){
        $('#btnFilter').on('click', function(){
            if (!$(this).hasClass('active')){
                $(this).addClass('active');
                $('.filtro').slideDown();
                if ($('#ddlCategoria').length > 0)
                    $('#ddlCategoria').focus();
            }
            else {
                $(this).removeClass('active');
                $('.filtro').slideUp();
                $('#txtSearch').focus();                
            }
            return false;
        });
    }
    
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

    $('#btnEliminar').on('click', function (event) {
        var TipoCarta = '';
        
        event.preventDefault();

        TipoCarta =  $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

        $('#hdTipoCarta').val(TipoCarta);
        EliminarDatos();
    });

    $("#btnLimpiarSeleccion").on('click', function(event){
        event.preventDefault();
        LimpiarSelecciones();
    });

    $('#btnClearCarta').on('click', function(event) {
        event.preventDefault();
        ClearSelectCarta();
    });

    $('#btnSetCarta').on('click', function(event) {
        event.preventDefault();
        ActivarCarta();
    });

    $('#btnNuevaCarta').on('click', function(event) {
        event.preventDefault();
        LimpiarCarta();
        openCustomModal('#pnlRegistroCarta');
    });

    $('#btnEditarCarta').on('click', function(event) {
        event.preventDefault();
        GetCarta();
    });

    $('#btnEliminarCarta').on('click', function(event) {
        event.preventDefault();
        EliminarCarta();
    });

    $('#pnlRegistroCarta .close-modal-example').on('click', function(event) {
        event.preventDefault();
        removeValidCarta();
    });

    $('#btnGuardarCarta').on('click', function(event) {
        event.preventDefault();
        GuardarCarta();
    });

    $('#btnBackToPrevious').on('click', function(event) {
        event.preventDefault();
        BackToPrevious();
    });

    $('#btnSelectAll').on('click', function (event) {
        event.preventDefault();
        SelectAllItems();
    });

    $('#lnkShowFavs').on('click', function (event) {
        var TipoCarta = '';

        event.preventDefault();

        TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

        if ($(this).hasClass('active'))
            $(this).removeClass('active').attr('title', 'Mostrar favoritos');
        else
            $(this).addClass('active').attr('title', 'Mostrar todo');;

        clearView(TipoCarta);
        ListarPlatos(TipoCarta, $('#hdFecha').val());
    });

    $('#btnAperturarMenu').on('click', function(event) {
        event.preventDefault();
        AperturarMenu();
    });

    $('#pnlConfigMenu').on('click', '.tile > .tile_true_content', function(event) {
        var TipoCarta = '';
        var _inputSpinner = $(this).parent().find('.input_spinner');
        var _tile = $(this).parent();
        var _selectorButtons = '#btnLimpiarSeleccion, #btnGuardarCambios';

        event.preventDefault();
        
        TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

        if (_tile.hasClass('selected')){
            _tile.find('input:checkbox')[0].checked = false;
            _tile.removeClass('selected');
            $('#btnBuscarArticulos').removeClass('oculto');
            if (_tile.siblings('.selected').length > 0){
                $(_selectorButtons).removeClass('oculto');
                if (TipoCarta != 'None')
                    $('#btnEliminar').removeClass('oculto');
            }
            else {
                $(_selectorButtons).addClass('oculto');
                if (TipoCarta != 'None')
                    $('#btnEliminar').addClass('oculto');
            }
            if (TipoCarta != '00')
                _inputSpinner.hide();
        }
        else {
            $('#btnBuscarArticulos').addClass('oculto');
            _tile.find('input:checkbox')[0].checked = true;
            _tile.addClass('selected');
            $(_selectorButtons).removeClass('oculto');
            if (TipoCarta != 'None')
                $('#btnEliminar').removeClass('oculto');
            if (TipoCarta != '00')
                _inputSpinner.show();
        }
        return false;
    });
    
    eventTileSpinner('#pnlPacks');
    eventTileSpinner('#pnlCarta');
    eventTileSpinner('#pnlMenu');
    eventTileSpinner('#pnlArticulos');
    
    ListarRegistroCarta('1');
});

function EliminarDatos () {
    var serializedReturn = $("#form1 input:checkbox").serialize() + '&hdTipoCarta=' + $('#hdTipoCarta').val() + '&btnEliminar=btnEliminar';
    precargaExp('.page-region', true);
    
    $.ajax({
        type: 'POST',
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        dataType: 'json',
        data: serializedReturn,
        success: function(data){
            MessageBox(data.titulomsje, data.contenidmsje, "[<?php $translate->__('Aceptar'); ?>]", function () {
            });
        }
    });
}

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

function LimpiarSelecciones () {
    var TipoCarta = '';
    TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');
    
    $('#btnLimpiarSeleccion').addClass('oculto');

    if ($('#pnlArticulos').is(':visible'))
        selector = '#pnlArticulos';
    else {
        if (TipoCarta == '00')
            selector = '#pnlCarta';
        else if (TipoCarta == '01')
            selector = '#pnlMenu';
        else if (TipoCarta == '03')
            selector = '#pnlPacks #nav li.active section';

        if ($(selector + ':visible .tile').length > 0)
            $('#btnBuscarArticulos').removeClass('oculto');
    }

    if ($(selector + ':visible .tile').length > 0)
        $('#btnSelectAll').removeClass('oculto');

    $(selector + ':visible .tile.selected').removeClass('selected');
    $(selector + ':visible .tile input:checkbox').removeAttr('checked');
    $(selector + ':visible .tile .input_spinner').hide();

    if ($('#pnlMenuToday').is(':visible'))
        $('#btnAsignar').addClass('oculto');
    else
        $('#btnGuardarCambios, #btnEliminar').addClass('oculto');
}

function GoToPacks () {
    $('#btnSelectYearMonth').addClass('oculto');
    $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    clearView('03');
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
                    strhtml += '<h2 class="fg-white">' + data[i].tm_simbolo + ' ' + Number(data[i].td_precio).toFixed(2) + '</h2>';
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
    
    MessageBox('<?php $translate->__('¿Desea apeturar este men&uacute;?'); ?>', '<?php $translate->__('Recuerde que no se podr&aacute;n hacer cambios una vez aperturado el men&uacute;.'); ?>', "[No], [Si]", function(action){
        if(action == "Si"){
            $.ajax({
                type: 'POST',
                url: 'services/cartadia/cartadia-post.php',
                cache: false,
                data: 'fnPost=fnPost&btnAperturarMenu=btnAperturarMenu&hdTipoCarta=' + TipoCarta + '&hdIdGrupo=' + $('#hdIdGrupo').val() + '&hdFecha=' + $('#hdFecha').val(),
                success: function(data){
                    datos = eval( "(" + data + ")" );
                    if (Number(datos.rpta) > 0){
                        /*MessageBox('<?php $translate->__('Apertura realizada'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
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

function ClearSelectCarta () {
    $('#gvCarta .tile').removeClass('selected');
    $('#gvCarta .tile input:checkbox').removeAttr('checked');
    $('#btnNuevaCarta').removeClass('oculto');
    $('#btnEditarCarta, #btnEliminarCarta, #btnClearCarta, #btnSetCarta').addClass('oculto');
}

function EliminarCarta() {
    var serializedReturn = $("#form1 input[type!=text]").serialize() + '&btnEliminarCarta=btnEliminar';
    $.ajax({
        type: "POST",
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        data: serializedReturn,
        success: function(data){
            var titleMensaje = '';
            var contentMensaje = '';
            var datos = eval( "(" + data + ")" );

            if (Number(datos.rpta) > 0){
                titleMensaje = '<?php $translate->__('Items eliminados correctamente'); ?>';
                contentMensaje = '<?php $translate->__('La operaci&oacute;n ha sido completada'); ?>';    
            }

            MessageBox(titleMensaje, contentMensaje, "[<?php $translate->__('Aceptar'); ?>]", function () {
                var dataSelected = $('.tile-area .tile.selected');
                if (datos.rpta > 0){
                   dataSelected.fadeOut(400, function () {
                        $(this).remove();
                    }); 
                }
                ClearSelectCarta();
                if ($('#gvCarta .tile-area .tile').length == 0){
                    ListarRegistroCarta('1');
                }
            });
        }
    });
}

function ListarRegistroCarta (pagina) {
    var selector = '#gvCarta .tile-area';

    precargaExp('#gvCarta', true);
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartas-search.php',
        cache: false,
        dataType: 'json',
        data: "pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countDatos = data.length;
            var emptyMessage = '';
            var strhtml = '';
            var colorState = '';

            if (countDatos > 0){
                while(i < countDatos){
                    colorState = (data[i].Actual == 1 ? ' active' : '');
                    
                    strhtml += '<div data-idcarta="' + data[i].tm_idcarta + '" class="tile dato half' + colorState + '">';
                    strhtml += '<div class="tile-content icon">';
                    strhtml += '<input type="checkbox" name="chkItemCarta[]" value="' + data[i].tm_idcarta + '">';
                    strhtml += '<h2>' + data[i].tm_nombre + '</h2>';
                    strhtml += '</div>';
                    strhtml += '</div>';
                    ++i;
                }
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPageCarta').val(Number($('#hdPageCarta').val()) + 1);

                $(selector).on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPageCarta').val();
                        ListarRegistroCarta(pagina);
                    }
                });
            }
            else {
                if (pagina == '1')
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
            }
            
            precargaExp('#gvCarta', false);
        }
    });
}

function LimpiarCarta () {
    $('#hdIdCarta').val('0');
    $('#txtNombreCarta').val('');
}

function GuardarCarta () {
    $.ajax({
        type: 'POST',
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        data: 'fnPost=fnPost&btnGuardarCarta=btnGuardarCarta&hdIdCarta=' + $('#hdIdCarta').val() + '&txtNombreCarta=' + $('#txtNombreCarta').val(),
        success: function(data){
            datos = eval( "(" + data + ")" );
            if (Number(datos.rpta) > 0){
                MessageBox('<?php $translate->__('Datos guardados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                    LimpiarCarta();
                    ClearSelectCarta();
                    removeValidCarta();
                    closeCustomModal('#pnlRegistroCarta');
                    ListarRegistroCarta('1');
                });
            }
        }
    });
}

function ActivarCarta () {
    $.ajax({
        type: 'POST',
        url: 'services/cartadia/cartadia-post.php',
        cache: false,
        data: 'fnPost=fnPost&btnSetCarta=btnSetCarta&hdIdCarta=' + $('#hdIdCarta').val(),
        success: function(data){
            datos = eval( "(" + data + ")" );
            if (Number(datos.rpta) > 0){
                MessageBox('<?php $translate->__('Datos guardados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                    ClearSelectCarta();
                    $('#gvCarta .tile').removeClass('bg-lightGreen');
                    $('#gvCarta .tile[data-idcarta="' + datos.rpta + '"]').addClass('active');
                });
            }
        }
    });
}

function addValidCarta () {
    
}

function removeValidCarta () {
    
}

function GetCarta () {
    var idItem = $('#hdIdCarta').val();
    
    addValidCarta();
    openCustomModal('#pnlRegistroCarta');
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartas-getdetails.php',
        cache: false,
        data: 'id=' + idItem,
        success: function (data) {
            var datos = eval( "(" + data + ")" );
            $('#txtNombreCarta').val(datos[0].tm_nombre);
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

function clearView (TipoCarta) {
    var selector = '';
    if (TipoCarta == '00')
        selector = '.section-subcat .tile-area';
    else if (TipoCarta == '01')
        selector = '#pnlMenu .tile-area';
    else if (TipoCarta == '03')
        selector = '#pnlPacks #nav li.active .tile-area';
    $(selector).html('');
}

function SelectAllItems () {
    var TipoCarta = '';
    var selector = '';

    $('#btnSelectAll').addClass('oculto');
    $('#btnLimpiarSeleccion').removeClass('oculto');
    
    if ($('#pnlArticulos').is(':visible')) {
        selector = '#pnlArticulos';
        $('#btnAsignar').removeClass('oculto');
        $('#btnEliminar').addClass('oculto');
    }
    else {
        TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');
        if (TipoCarta == '00')
            selector = '#pnlCarta';
        else if (TipoCarta == '01')
            selector = '#pnlMenu';
        else if (TipoCarta == '03')
            selector = '#nav li.active section';
        
        $('#btnBuscarArticulos').addClass('oculto');
        $('#btnEliminar, #btnGuardarCambios').removeClass('oculto');
    }

    $(selector + ':visible .tile').addClass('selected');
    $(selector + ':visible .tile input:checkbox').attr('checked', '');
    $(selector + ':visible .tile .input_spinner').show();

}

function GoToMenu () {
    $('#btnSelectYearMonth').addClass('oculto');
    $('#btnBuscarArticulos, #btnBackToPrevious').removeClass('oculto');
    clearView('01');
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

function AsignarSeleccion (TipoEdit) {
    var listaDetalle = [];

    var selector = '';
    var articulos;

    var i = 0;
    var count = 0;

    var idCartaMenu = '0';
    var idProducto = '0';
    var idMoneda = '0';
    var idCategoria = '0';
    var idSubCategoria = '0';
    var precio = 0;
    var stock = 0;
    var detalleMenu = '';

    var IdCarta = $('#hdIdCarta').val();
    var IdGrupo = $('#hdIdGrupo').val();
    var IdOrden = $('#hdIdOrden').val();
    var TipoCarta = '';
    var fechaMenu = $('#hdFecha').val();

    TipoCarta = $('#pnlConfigMenu .sectionHeader button.success').attr('data-tipomenu');

    if (TipoEdit == 'N')
        selector = '#pnlArticulos';
    else {
        if (TipoCarta == '00')
            selector = '#pnlCarta';
        else if (TipoCarta == '01')
            selector = '#pnlMenu';
        else
            selector = '#nav';
    }
        
    articulos = $(selector + ' .tile.selected');
    count = articulos.length;

    if (count > 0){
        if (TipoCarta == '03'){
            while (i < count){
                if (TipoEdit == 'N'){
                    idCartaMenu = '0';
                    idProducto = articulos[i].getAttribute('rel');
                    idMoneda = articulos[i].getAttribute('data-idMoneda');
                    //precio = Number($(articulos[i]).find('span.precio').text());
                    stock = Number($(articulos[i]).find('input.inputCantidad').val());
                }
                else {
                    idCartaMenu = articulos[i].getAttribute('rel');
                    idProducto = articulos[i].getAttribute('data-idProducto');
                    idMoneda = articulos[i].getAttribute('data-idMoneda');
                    //precio = Number($(articulos[i]).find('input:text').val());
                    //stock = Number(articulos[i].getAttribute('data-stock'));
                    stock = Number($(articulos[i]).find('input.inputCantidad').val());
                }
                var detalle = new DetalleMenuDia(idCartaMenu, IdGrupo, idProducto, idMoneda, fechaMenu, TipoCarta, 0, stock, IdOrden);
                listaDetalle.push(detalle);
                ++i;
            }
            detalleMenu = JSON.stringify(listaDetalle);
        }
        else {
            while (i < count){
                if (TipoEdit == 'N'){
                    idCartaMenu = '0';
                    idProducto = articulos[i].getAttribute('rel');
                    idMoneda = articulos[i].getAttribute('data-idMoneda');
                    precio = Number($(articulos[i]).find('span.precio').text());
                    stock = Number($(articulos[i]).find('input.inputCantidad').val());
                }
                else {
                    idCartaMenu = articulos[i].getAttribute('rel');
                    idProducto = articulos[i].getAttribute('data-idProducto');
                    idMoneda = articulos[i].getAttribute('data-idMoneda');
                    //precio = Number($(articulos[i]).find('input:text').val());
                    //stock = Number(articulos[i].getAttribute('data-stock'));
                    stock = Number($(articulos[i]).find('input.inputCantidad').val());
                }

                var detalle = new DetalleMenuDia (idCartaMenu, 0, idProducto, idMoneda, fechaMenu, TipoCarta, precio.toFixed(2), stock, 0);
                listaDetalle.push(detalle);
                ++i;
            }
            detalleMenu = JSON.stringify(listaDetalle);
        }

        $.ajax({
            type: "POST",
            url: 'services/cartadia/cartadia-post.php',
            cache: false,
            data: {
                fnPost: 'fnPost',
                hdTipoCarta: TipoCarta,
                hdIdCarta: IdCarta,
                hdIdGrupo: IdGrupo,
                hdIdOrden: IdOrden,
                hdFecha: fechaMenu,
                btnAsignar: 'btnAsignar',
                detalleMenu: detalleMenu
            },
            success: function(data){
                datos = eval( "(" + data + ")" );
                if (Number(datos.rpta) > 0){
                    MessageBox('<?php $translate->__('Datos guardados'); ?>', '<?php $translate->__('La operaci&oacute;n se complet&oacute; correctamente.'); ?>', "[<?php $translate->__('Aceptar'); ?>]", function () {
                        $('#hdPage').val('1');
                        $('#hdPageActual').val('1');

                        clearView(TipoCarta);
                        ListarPlatos(TipoCarta, fechaMenu);
                        LimpiarSelecciones();
                        //$('#btnSelectAll').removeClass('oculto');
                    });
                }
            }
        });
    }
}

function ListarPlatos (TipoCarta, fechaMenu) {
    var selector = '';
    var capaLoading = '';
    var esfavorito = '';
    var idcarta = '0';
    var idgrupo = '0';
    var idorden = '0';
    var tipobusqueda = 'INDIVIDUAL';
        
    idcarta = $('#hdIdCarta').val();
    idgrupo = $('#hdIdGrupo').val();
    idorden = $('#hdIdOrden').val();

    if (TipoCarta == '00')
        capaLoading = '#pnlCarta';
    else if (TipoCarta == '01' || TipoCarta == '03'){
        if (TipoCarta == '01'){
            capaLoading = '#pnlMenu';
            selector = '#pnlMenu .tile-area';
        }
        else if (TipoCarta == '03'){
            capaLoading = '#pnlPacks #nav li.active section';
            selector = '#pnlPacks #nav li.active .tile-area';
            tipobusqueda = 'GRUPAL';
        }
    }

    $('#btnSelectAll, #btnLimpiarSeleccion, #btnGuardarCambios, #btnEliminar').addClass('oculto');

    esfavorito = ($('#lnkShowFavs').hasClass('active') ? '1' : '');
    
    precargaExp(capaLoading, true);
    
    $.ajax({
        type: "GET",
        url: 'services/cartadia/cartadia-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: tipobusqueda,
            tipomenu: TipoCarta,
            fecha: fechaMenu,
            esfavorito: esfavorito,
            idcarta: idcarta,
            idgrupo: idgrupo,
            idorden: idorden
        },
        success: function(data){
            var count = data.length;
            var i = 0;
            var csscontent = '';
            var idSubCategoria = '0';
            var simboloMoneda = '';
            var precio = 0;
            var stock = 0;
            var capaLoading = '';
            var strhtml = '';

            if (count > 0){                    
                while (i < count){
                    idSubCategoria = data[i].tm_idsubcategoria;
                    simboloMoneda = data[i].simboloMoneda;
                    precio = Number(data[i].td_precio);
                    stock = Number(data[i].td_stockdia);

                    if (TipoCarta == '00')
                        selector = '#pnlCarta .section-subcat[rel="' + idSubCategoria + '"] .tile-area';

                    if (data[i].tm_foto == 'no-set'){
                        foto = 'images/food-48.png';
                        csscontent = 'icon';
                    }
                    else {
                        foto =  data[i].tm_foto;
                        csscontent = 'image';
                    }

                    strhtml += '<div class="tile dato double" ';
                    strhtml += 'rel="' + data[i].iddetalle + '" ';
                    strhtml += 'data-idProducto="' + data[i].tm_idproducto + '" ';
                    strhtml += 'data-idMoneda="' + data[i].tm_idmoneda + '" ';
                    strhtml += 'data-idCategoria="' + data[i].tm_idcategoria + '" ';
                    strhtml += 'data-idSubCategoria="' + idSubCategoria + '" ';
                    strhtml += 'data-stock="' + stock + '">';
                    
                    if (data[i].td_esfavorito == '1'){
                        strhtml += '<div class="flag_tipocarta">';
                        strhtml += '<i class="icon-star-3 bd_color-favorito"></i>';
                        strhtml += '</div>';
                    }

                    strhtml += '<input name="chkItemMenu[]" type="checkbox" class="oculto" value="' + data[i].iddetalle + '" />';
                    
                    strhtml += '<div class="tile_true_content">';
                    
                    strhtml += '<div class="tile-content ' + csscontent + '">';
                    strhtml += '<img src="' + foto + '" />';
                    strhtml += '</div>';
                    
                    strhtml += '<div class="tile-status bg-dark opacity">';
                    strhtml += '<span class="label">' + data[i].nombreProducto + '</span>';

                    if (TipoCarta != '03')
                        strhtml += '<div class="badge bg-red">' + simboloMoneda + ' ' + precio.toFixed(2) + '</div>';

                    strhtml += '</div>';

                    strhtml += '</div>';

                    strhtml += '<div class="input_spinner">';
                    strhtml += '<input type="text" name="txtCantidad" class="inputCantidad" value="' + stock + '" />';
                    strhtml += '<div class="buttons">';
                    strhtml += '<button type="button" class="up bg-green fg-white">+</button>';
                    strhtml += '<button type="button" class="down bg-red fg-white">-</button>';
                    strhtml += '</div>';
                    strhtml += '</div>';

                    strhtml += '</div>';

                    if (TipoCarta == '00')
                        $(selector).html(strhtml).find('.tile[data-idSubCategoria!="' + idSubCategoria + '"]').remove();
                    ++i;
                }

                if ($('#hdEstadoApertura').val() == '00'){
                    if (!$('#pnlCalendarioPack').is(':visible') && !$('#pnlCalendarioIndividual').is(':visible')){
                        $('#btnSelectAll').removeClass('oculto');

                        ShowHideAperturador(TipoCarta, count);
                    }
                }
                else
                    $('#btnAperturarMenu').addClass('oculto');
            }
            else {
                strhtml = '<h2>No se encontraron resultados</h2>';
                $('#btnLimpiarSeleccion').addClass('oculto');
            }

            if (TipoCarta == '00')
                capaLoading = '#pnlCarta';
            else {
                if (TipoCarta == '03')
                    capaLoading = '#pnlPacks #nav li.active section';
                else
                    capaLoading = '#pnlMenu';
                
                $(selector).html(strhtml);
            }
            
            precargaExp(capaLoading, false);
        }
    });
}

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
                    strhtml += '<button type="button" class="up bg-green fg-white">+</button>';
                    strhtml += '<button type="button" class="down bg-red fg-white">-</button>';
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
                    $('#gvProductos .tile-area').html('<h2><?php $translate->__('No se encontraron resultados.'); ?></h2>');
            }
            precargaExp('#gvProductos', false);
        }
    });
}