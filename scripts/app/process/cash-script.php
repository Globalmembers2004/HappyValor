<?php
header('Content-type: text/javascript');
require('../../../common/class.translation.php');
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'es';
$translate = new Translator($lang);
?>
$(function () {
    AperturaByDefault();

    $('#pnlCaja .sectionHeader').on('click', 'button', function(event) {
        var tipomov = '';

        event.preventDefault();

        tipomov = $(this).attr('data-tipomov');

        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');

        AperturaByDefault();
    });

    $('#btnRegistrarApertura').on('click', function(event) {
        event.preventDefault();
        RegistrarAperturaCaja();
    });

    $('#btnAperturaCaja').on('click', function(event) {
        event.preventDefault();
        ListarPersonalPorTurno();
        openCustomModal('#pnlAperturaCaja');
    });

    $('#btnVerAperturas').on('click', function(event) {
        event.preventDefault();
        $('#lblFechaHoy').text(GetToday());
        openCustomModal('#pnlAperturasDia');
        ListarAperturas();
    });

    $('#btnRegistrarMovimiento').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#pnlRegMovimientoCaja');
    });

    $('#ddlMonedaApertura').on('keydown', function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
            $('#txtImporteApertura').focus();
            return false;
        };
    });

    $('#pnlInfoPersonal').on('click', function(event) {
        event.preventDefault();
        ShowPanelPersona();
    });

    $('#btnExitPersona').on('click', function(event) {
        event.preventDefault();
        $('#pnlSearchPersona').fadeOut(400);
    });

    $('#pnlPersona > .sectionHeader').on('click', 'button', function(event) {
        var tipodata = '';

        tipodata = $(this).attr('data-target');

        $(this).siblings('.success').removeClass('success');
        $(this).addClass('success');

        BuscarPersona('1');
    });

    $('#gvPersona .items-area').on('click', '.list', function(event) {
        var idpersona = '0',
            nrodoc = '',
            descripcion = '',
            direccion = '';

        event.preventDefault();
        
        idpersona = $(this).attr('data-idpersona');
        nrodoc = $(this).find('main p .docidentidad').text();
        descripcion = $(this).find('main p .descripcion').text();
        direccion = $(this).find('main p .direccion').text();

        setPersona(idpersona, nrodoc, descripcion, direccion);
    });

    $('#txtImporteApertura').on({
        focus: function () {
            if (Number(this.value) == 0)
                this.value = '';
        },
        blur: function () {
            if ($(this).val().trim().length == 0)
                this.value = '0.00';
        },
        keydown: function (event) {
            if (event.keyCode == $.ui.keyCode.ENTER) {
                $('#ddlTurnoApertura').focus();
                return false;
            };
        }
    });

    $('#ddlTurnoApertura').on('change', function(event) {
        event.preventDefault();
        ListarPersonalPorTurno();
    });

    $('#txtImporteMovimiento').on({
        focus: function () {
            if (Number(this.value) == 0)
                this.value = '';
        },
        blur: function () {
            if ($(this).val().trim().length == 0)
                this.value = '0.00';
        },
        keydown: function (event) {
            if (event.keyCode == $.ui.keyCode.ENTER) {
                $('#txtObservacionMovCaja').focus();
                return false;
            };
        }
    });

    $('#btnRegistrarMovCaja').on('click', function(event) {
        event.preventDefault();
        RegistrarMovCaja();
    });

    $('#btnCierreCaja').on('click', function(event) {
        event.preventDefault();
        openCustomModal('#pnlCierreCaja');
    });

    $('#btnCerrarCaja').on('click', function(event) {
        event.preventDefault();
        CerrarCaja();
    });
});

function setPersona (idpersona, nrodoc, descripcion, direccion) {
    var tipodata = '';

    tipodata = $('#pnlPersona .sectionHeader button.success').attr('data-tipodata');

    $('#hdTipoDataPersona').val(tipodata);
    $('#hdIdPersona').val(idpersona);
    $('#pnlInfoPersonal').attr('data-idpersona', idpersona);
    $('#pnlInfoPersonal .descripcion').text(descripcion);
    $('#pnlInfoPersonal .docidentidad').text(nrodoc);
    $('#pnlInfoPersonal .direccion').text(direccion);

    $('#pnlSearchPersona').fadeOut('400', function() {
        
    });
}

function BuscarPersona (pagina) {
    var selector = '#gvPersona .items-area';
    var tipodata = '';
    var url = '';
    var elem;

    elem = $('#pnlPersona .sectionHeader button.success');
    tipodata = elem.attr('data-tipodata');

    if (tipodata == '00')
        url = 'services/clientes/clientes-search.php';
    else if (tipodata == '01')
        url = 'services/proveedores/proveedores-search.php';
    else if (tipodata == '02')
        url = 'services/organigrama/organigrama-search.php';

    precargaExp('#gvPersona', true);
    
    $.ajax({
        type: "GET",
        url: url,
        cache: false,
        dataType: 'json',
        data: "criterio=" + $('#txtSearchPersona').val() + "&pagina=" + pagina,
        success: function(data){
            var i = 0;
            var countDatos = data.length;
            var emptyMessage = '';
            var strhtml = '';

            if (countDatos > 0){
                if (tipodata == '00'){
                    while(i < countDatos){
                        iditem = data[i].tm_idtipocliente;
                        foto = data[i].tm_foto;
                        strhtml += '<a href="#" class="list dato bg-gray-glass" rel="' + iditem + '" data-tipocliente="' + data[i].tm_iditc + '">';

                        strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<div class="list-content">';
                        strhtml += '<div class="data">';
                        strhtml += '<aside>';

                        if (foto == 'no-set')
                            strhtml += '<i class="fa fa-user"></i>';
                        else
                            strhtml += '<img src="' + foto + '" />';
                        strhtml += '</aside>';
                        strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].Descripcion + '</strong>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">' + data[i].TipoDoc + ': ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                        strhtml += '</main></div></div>';
                        strhtml += '</a>';
                        ++i;
                    };
                }
                else if (tipodata == '01'){
                    while(i < countDatos){
                        iditem = data[i].tm_idproveedor;
                        foto = data[i].tm_foto;
                        strhtml += '<a href="#" class="list dato bg-gray-glass" rel="' + iditem + '">';

                        strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<div class="list-content">';
                        strhtml += '<div class="data">';
                        strhtml += '<aside>';

                        if (foto == 'no-set')
                            strhtml += '<i class="fa fa-user"></i>';
                        else
                            strhtml += '<img src="' + foto + '" />';
                        strhtml += '</aside>';
                        strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].tm_nombreproveedor + '</strong>Tel&eacute;fono: ' + data[i].tm_telefono + ' - Direcci&oacute;n: <span class="direccion">' + data[i].tm_direccion + '</span><br /><span class="docidentidad">RUC: ' + data[i].tm_numerodoc + '</span> - Email: ' + data[i].tm_email + '</p>';
                        strhtml += '</main></div></div>';
                        strhtml += '</a>';
                        ++i;
                    };
                }
                else if (tipodata == '02'){
                    while(i < countDatos){
                        iditem = data[i].tm_idpersonal;
                        foto = data[i].tm_foto;
                        strhtml += '<a href="#" class="list dato bg-gray-glass"rel="' + iditem + '">';

                        strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                        strhtml += '<div class="list-content">';
                        strhtml += '<div class="data">';
                        strhtml += '<aside>';

                        if (foto == 'no-set')
                            strhtml += '<i class="fa fa-user"></i>';
                        else
                            strhtml += '<img src="' + foto + '" />';
                        strhtml += '</aside>';
                        strhtml += '<main><p class="fg-darker"><strong class="descripcion">' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</strong>Cargo: <span class="direccion">' +data[i].Cargo + '</span><br /><span class="docidentidad">RUC: ' + data[i].tm_nrodni + '</span> - Email: ' + data[i].tm_email + '</p>';
                        strhtml += '</main></div></div>';
                        strhtml += '</a>';
                        ++i;
                    };
                }
                
                if (pagina == '1')
                    $(selector).html(strhtml);
                else
                    $(selector).append(strhtml);

                $('#hdPagePersona').val(Number($('#hdPagePersona').val()) + 1);

                $(selector).on('scroll', function(){
                    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
                        var pagina = $('#hdPagePersona').val();
                        BuscarPersona(pagina);
                    };
                });
            }
            else {
                if (pagina == '1'){
                    $(selector).html('<h2>No se encontraron resultados.</h2>');
                };
            };
            
            precargaExp('#gvPersona', false);
        }
    });
}

function ShowPanelPersona () {
    $('#pnlSearchPersona').fadeIn(400, function () {
        BuscarPersona('1');
    });
}

function ListarMovimientoCaja (idregistrocaja) {
    var tipomov = '';
    
    tipomov = $('#pnlCaja .sectionHeader button.success').attr('data-tipomov');

    precargaExp('#tableRegistroCaja .ibody', true);

    $.ajax({
        type: 'GET',
        url: 'services/ventas/detalleapertura-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            idregistrocaja: idregistrocaja,
            tipomov: tipomov
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var emptyMessage = '';
            var strhtml = '';
            var totalcaja = 0;

            if (countdata > 0){
                while(i < countdata){
                    strhtml += '<tr>';
                    strhtml += '<td>' + (i + 1)+ '</td>';
                    strhtml += '<td>' + data[i].Concepto + '</td>';
                    strhtml += '<td>' + data[i].FechaReg.split(' ')[1] + '</td>';
                    strhtml += '<td>' + data[i].Moneda + '</td>';
                    strhtml += '<td>' + data[i].tm_monto_mn + '</td>';
                    strhtml += '<td>' + data[i].tm_observacion + '</td>';
                    strhtml += '</tr>';

                    totalcaja = totalcaja + Number(data[i].tm_monto_mn);
                    ++i;
                };
            };
            $('#tableRegistroCaja .ibody tbody').html(strhtml);
            $('#lblImporteTotalCaja').text(totalcaja.toFixed(2));

            precargaExp('#tableRegistroCaja .ibody', false);
        }
    });
}

function ListarAperturas () {
    $.ajax({
        type: 'GET',
        url: 'services/ventas/aperturacaja-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            fecha: GetToday()
        }
    }).done(function(data) {
        var i = 0;
        var countdata = data.length;
        var strhtml = '';

        if (countdata > 0){
            while(i < countdata){
                strhtml += '<tr>';
                strhtml += '<td>' + (i + 1) + '</td>';
                strhtml += '<td>' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</td>';
                strhtml += '<td>' + data[i].NombreMoneda + '</td>';
                strhtml += '<td>' + data[i].tm_monto_inicial + '</td>';
                strhtml += '<td>' + data[i].tm_monto_final + '</td>';
                strhtml += '<td>' + data[i].Turno + '</td>';
                strhtml += '<td>' + data[i].Estado + '</td>';
                strhtml += '</tr>';
                ++i;
            }
        };
        $('#tableAperturaDia tbody').html(strhtml);
    }).fail(function() {
        console.log("error");
    }).always(function() {
        console.log("complete");
    });
}

function LimpiarCaja () {
    $('#hdIdAperturaCaja').val('0');
    $('#hdIdMoneda').val('0');
    $('#lblFechaRegistroCaja').text('');
    $('#lblTurnoCaja').text('');
    $('#lblMonedaInicial').text('');
    $('#lblImporteInicial').text('0.00');
    $('#lblMonedaActual').text('');
    $('#lblImporteActual').text('0.00');
    $('#lblMonedaTotalCaja').text('');
    $('#lblImporteTotalCaja').text('0.00');
    $('#tableRegistroCaja .ibody tbody').html('');
}

function AperturaByDefault () {
    $.ajax({
        type: 'GET',
        url: 'services/ventas/aperturacaja-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '1',
            fecha: GetToday()
        }
    }).done(function(data) {
        var i = 0;
        var countdata = data.length;
        
        LimpiarCaja();
        if (countdata > 0){
            $('#hdIdAperturaCaja').val(data[0].tm_idregistro_caja);
            $('#hdIdMoneda').val(data[0].tm_idmoneda);
            $('#lblFechaRegistroCaja').text(ConvertMySQLDate(data[0].tm_fecharegistro));
            $('#lblTurnoCaja').text(data[0].Turno);
            $('#lblMonedaInicial').text(data[0].SimboloMoneda);
            $('#lblImporteInicial').text(Number(data[0].tm_monto_inicial).toFixed(2));
            $('#lblMonedaActual').text(data[0].SimboloMoneda);
            $('#lblImporteActual').text(Number(data[0].tm_monto_actual).toFixed(2));
            $('#lblMonedaTotalCaja').text(data[0].SimboloMoneda);

            $('#btnAperturaCaja').addClass('oculto');
            $('#btnRegistrarMovimiento, #btnCierreCaja').removeClass('oculto');

            ListarMovimientoCaja(data[0].tm_idregistro_caja);
        }
        else {
            $('#btnAperturaCaja').removeClass('oculto');
            $('#btnRegistrarMovimiento, #btnCierreCaja').addClass('oculto');
        };
    }).fail(function() {
        console.log("error");
    }).always(function() {
        console.log("complete");
    });
}

function RegistrarAperturaCaja () {
    $.ajax({
        type: 'POST',
        url: 'services/ventas/caja-post.php',
        cache: false,
        dataType: 'json',
        data: {
            lang: '<?php echo $lang; ?>',
            btnRegistrarApertura: 'btnRegistrarApertura',
            hdIdAperturaCaja: $('#hdIdAperturaCaja').val(),
            ddlMonedaApertura: $('#ddlMonedaApertura').val(),
            txtImporteApertura: $('#txtImporteApertura').val(),
            ddlTurnoApertura: $('#ddlTurnoApertura').val()
        },
        success: function(data){
            if (Number(data.rpta) > 0){
                MessageBox(data.titulomsje, data.contenidomsje, '[<?php $translate->__('Aceptar'); ?>]', function () {
                    closeCustomModal('#pnlAperturaCaja');
                    AperturaByDefault();
                });
            };
        }
    });
}

function RegistrarMovCaja () {
    $.ajax({
        type: 'POST',
        url: 'services/ventas/caja-post.php',
        cache: false,
        dataType: 'json',
        data: {
            lang: '<?php echo $lang; ?>',
            btnRegistrarMovCaja: 'btnRegistrarMovCaja',
            hdIdAperturaCaja: $('#hdIdAperturaCaja').val(),
            hdIdMoneda: $('#hdIdMoneda').val(),
            hdTipoDataPersona: $('#hdTipoDataPersona').val(),
            hdIdPersona: $('#hdIdPersona').val(),
            ddlTipoMovimiento: $('#ddlTipoMovimiento').val(),
            ddlConcepto: $('#ddlConcepto').val(),
            txtImporteMovimiento: $('#txtImporteMovimiento').val(),
            txtObservacionMovCaja: $('#txtObservacionMovCaja').val()
        },
        success: function(data){
            if (Number(data.rpta) > 0){
                MessageBox(data.titulomsje, data.contenidomsje, '[<?php $translate->__('Aceptar'); ?>]', function () {
                    $('#pnlCaja .sectionHeader button.success').removeClass('success');
                    $('#pnlCaja .sectionHeader button[data-tipomov="' + $('#ddlTipoMovimiento').val() + '"]').addClass('success');

                    closeCustomModal('#pnlRegMovimientoCaja');
                    AperturaByDefault();
                });
            };
        }
    });
}

function CerrarCaja () {
    $.ajax({
        url: 'services/ventas/caja-post.php',
        type: 'POST',
        dataType: 'json',
        data: {
            lang: '<?php echo $lang; ?>',
            btnCerrarCaja: 'btnCerrarCaja',
            hdIdAperturaCaja: $('#hdIdAperturaCaja').val(),
            hdIdMoneda: $('#hdIdMoneda').val(),
            txtObservacionCierreCaja: $('#txtObservacionCierreCaja').val()
        }
    })
    .done(function(data) {
        if (Number(data.rpta) > 0){
            MessageBox(data.titulomsje, data.contenidomsje, '[<?php $translate->__('Aceptar'); ?>]', function () {
                $('#pnlCaja .sectionHeader button').removeClass('success').first().trigger('click');
                closeCustomModal('#pnlCierreCaja');
                AperturaByDefault();
            });
        };
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function ListarPersonalPorTurno () {
    var selector = '#gvPersonalTurno';

    $.ajax({
        type: 'GET',
        url: 'services/organigrama/organigrama-search.php',
        cache: false,
        dataType: 'json',
        data: {
            tipobusqueda: '3',
            turno: $('#ddlTurnoApertura').val()
        },
        success: function(data){
            var i = 0;
            var countdata = data.length;
            var emptyMessage = '';
            var strhtml = '';

            if (countdata > 0){
                while(i < countdata){
                    iditem = data[i].tm_idpersonal;
                    foto = data[i].tm_foto;
                    strhtml += '<a href="#" class="list dato" rel="' + iditem + '">';

                    strhtml += '<input name="chkItem[]" type="checkbox" class="oculto" value="' + iditem + '" />';
                    strhtml += '<div class="list-content">';
                    strhtml += '<div class="data">';
                    strhtml += '<aside>';

                    if (foto == 'no-set')
                        strhtml += '<i class="fa fa-user"></i>';
                    else
                        strhtml += '<img src="' + foto + '" />';
                    strhtml += '</aside>';
                    strhtml += '<main><p class="fg-dark"><strong>' + data[i].tm_apellidopaterno + ' ' + data[i].tm_apellidomaterno + ' ' + data[i].tm_nombres + '</strong>Cargo: ' + data[i].Cargo + '<br />DNI: ' + data[i].tm_nrodni + ' - Email: ' + data[i].tm_email + '</p>';
                    strhtml += '</main></div></div>';
                    strhtml += '</a>';
                    ++i;
                };

                $(selector).html(strhtml);
            }
            else
                $(selector).html('<h2>No se encontraron resultados.</h2>');
        }
    });
}