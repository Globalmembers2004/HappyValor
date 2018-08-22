<?php
require 'bussiness/empresa.php';
require 'bussiness/tabla.php';
require 'bussiness/monedas.php';
require 'bussiness/ventas.php';

$objEmpresa = new clsEmpresa();
$objTabla = new clsTabla();
$objMoneda = new clsMoneda();
$objVenta = new clsVenta();

$rsTurno = $objTabla->Listar('BY-FIELD', 'ta_turno');
$countTurno = count($rsTurno);

$rsTipoMovimiento = $objTabla->Listar('BY-FIELD', 'ta_tipomovimiento');
$countTipoMovimiento = count($rsTipoMovimiento);

// $rowMoneda = $objMoneda->ListarVigMoneda();
$rowMoneda = $objMoneda->Listar(1, 0, '', 1);
$countRowMoneda = count($rowMoneda);

$rsTipoMovCaja = $objVenta->ListarTipoMovCaja('1', 0, '');
$countTipoMovCaja = count($rsTipoMovCaja);
?>
<form id="form1" name="form1" method="post">
    <div class="page-region">
        <div id="pnlCaja" class="page generic-panel mdl-layout mdl-layout--fixed-header">
            <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>">
            <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>">
            <input type="hidden" name="hdIdOrden" id="hdIdOrden" value="0">
            <input type="hidden" name="hdTipoComprobante" id="hdTipoComprobante" value="0">
            <input type="hidden" name="hdMedioPago" id="hdMedioPago" value="1">
            <input type="hidden" name="hdTipoCliente" id="hdTipoCliente" value="NA">    
            <header class="gp-header mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span id="titleOrden" class="mdl-layout-title row no-margin">Caja - Orden #: </span>
                    <!-- <span class="mdl-layout-title">Caja</span> -->
                    <div class="mdl-layout-spacer"></div>
                    <div class="all-height" style="width: 80px;">
                        <div class="pos-rel full-size all-height text-center">
                            <span class="fa-stack margin10">
                                <i class="fa fa-calendar-o fa-stack-2x"></i>
                                <small class="calendar-text fa-stack-1x"><?php echo date('d'); ?></small>
                            </span>
                            <div class="calendar-title place-bottom-left-right padding5 text-center uppercase"><?php echo getMes(date('m')); ?></div>
                        </div>
                    </div>
                    <button id="btnAgregar" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Agregar item de venta">
                        <i class="material-icons">&#xE145;</i>
                    </button>
                    <button id="btnGestionarCobranza" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Registrar venta">
                        <i class="material-icons">&#xE870;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <ul id="mnuOpcionesMenu" class="mnuOpciones dropdown">
                <li><a href="#" data-action="ventas-view">Ver ventas</a></li>
                <li><a href="#" data-action="caja-open">Aperturar caja</a></li>
                <li><a href="#" data-action="caja-close" class="hide">Cerrar caja</a></li>
                <li><a href="#" data-action="movcaja-view">Movimientos de caja</a></li>
            </ul>
            <div class="mdl-layout__drawer-button">
                <!-- <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a> -->
                <a class="back-activity mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <main class="gp-body no-overflow">
                <div id="pnlDetalleOrden" class="all-height">
                    <div id="gvArticuloMenu" class="pos-rel all-height" data-selected="none" data-multiselect="false">
                        <div class="table-responsive-vertical shadow-z-1 all-height">
                            <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                <thead>
                                    <tr>
                                        <th class="hide"></th>
                                        <th><?php $translate->__('Articulo/Servicio'); ?></th>
                                        <th><?php $translate->__('Cantidad'); ?></th>
                                        <th><?php $translate->__('Precio'); ?></th>
                                        <th><?php $translate->__('Subtotal'); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="gp-footer">
                <div class="card-panel mdl-shadow--2dp padding20">
                    <h3 id="lblTotalCobro" class="text-right no-margin">
                        Importe <span class="simbolo-moneda">S/. </span><span class="monto">0.00</span>
                    </h3>
                </div>
            </footer>
        </div>
    </div>
    <div id="pnlCajaActual" class="modal-example-content modal-nomodal without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Caja de hoy <span class="lblFechaHoy"></span></span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnAddMovimiento">
                        <i class="material-icons">&#xE145;</i>
                    </button>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
            <input type="hidden" name="hdIdAperturaCaja" id="hdIdAperturaCaja" value="0">
            <input type="hidden" name="hdIdMoneda" id="hdIdMoneda" value="0">
            <input type="hidden" name="hdTipoDataPersona" id="hdTipoDataPersona" value="0">
            <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="0" />
            <input type="hidden" id="hdIdPerfil" name="hdIdPerfil" value="<?php echo $idperfil; ?>" />
            <div class="generic-panel">
                <div class="gp-header">
                    <div class="row no-margin">
                        <div class="col-xs-8">
                            <h3>Turno: <span id="lblTurnoCaja"></span></h3>
                        </div>
                        <div class="col-xs-4">
                            <div class="btn-group margin10 right" role="group" aria-label="...">
                                <button type="button" class="btn btn-default btn-primary" data-tipomov="00">Ingresos</button>
                                <button type="button" class="btn btn-default" data-tipomov="01">Salidas</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div class="scrollbarra">
                        <div id="tableRegistroCaja" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false">
                            <div class="table-responsive-vertical shadow-z-1">
                                <table class="table table-bordered table-hover mdl-shadow--2dp">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php $translate->__('Concepto'); ?></th>
                                            <th><?php $translate->__('Hora'); ?></th>
                                            <th><?php $translate->__('Moneda'); ?></th>
                                            <th><?php $translate->__('Importe'); ?></th>
                                            <th><?php $translate->__('Observaci&oacute;n'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-footer">
                    <div class="card-panel mdl-shadow--2dp margin20 no-padding">
                        <div class="mdl-grid no-padding">
                            <div class="mdl-cell mdl-cell--3-col">
                                <h4 class="align-center no-margin">Importe Ingreso</h4>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col">
                                <h4 class="align-center no-margin">Importe Salida</h4>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col">
                                <h4 class="align-center no-margin">Importe Inicial</h4>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col">
                                <h4 class="align-center no-margin">Importe Actual</h4>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="mdl-grid no-padding">
                            <div class="mdl-cell mdl-cell--3-col">
                                <h3 id="lblImporteIngreso" class="align-center no-margin">
                                    <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                </h3>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col">
                                <h3 id="lblImporteSalida" class="align-center no-margin">
                                    <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                </h3>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col">
                                <h3 id="lblImporteInicial" class="align-center no-margin">
                                    <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                </h3>
                            </div>
                            <div class="mdl-cell mdl-cell--3-col">
                                <h3 id="lblImporteActual" class="align-center no-margin">
                                    <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlAperturasDia" class="modal-example-content modal-nomodal without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Aperturas al <span class="lblFechaHoy"></span></span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra">
                <div id="tableAperturaDia" class="gridview pos-rel" data-selected="none" data-multiselect="false">
                    <div class="table-responsive-vertical shadow-z-1">
                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php $translate->__('Usuario'); ?></th>
                                    <th><?php $translate->__('Moneda'); ?></th>
                                    <th><?php $translate->__('Importe Inicial'); ?></th>
                                    <th><?php $translate->__('Importe Final'); ?></th>
                                    <th><?php $translate->__('Turno'); ?></th>
                                    <th><?php $translate->__('Estado'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlAperturaCaja" class="modal-example-content modaldos expand-phone without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Apertura de caja</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnRegistrarApertura">
                        <i class="material-icons">&#xE5CA;</i>
                    </button>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div  id="pnlFormApertura" class="generic-panel gp-no-footer">
                <div class="gp-header padding10">
                    <div class="row no-margin">
                        <div class="col-xs-5">
                            <label>Fecha y hora</label>
                            <div class="mdl-grid mdl-grid--no-spacing">
                                <div class="mdl-cell mdl-cell--8-col">
                                    <h4 id="lblFechaHoraApertura"><?php echo date('d/m/Y h:i A'); ?></h4>
                                </div>
                                <div class="mdl-cell mdl-cell--4-col">
                                   <button id="btnMostrarFechaHoraApertura" class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="input-field">
                                <select id="ddlMonedaApertura" name="ddlMonedaApertura" class="browser-default">
                                <?php
                                if ($countRowMoneda > 0):
                                    for ($i=0; $i < $countRowMoneda; ++$i):
                                        ?>
                                    <option data-tipocambio="<?php echo $rowMoneda[$i]['td_importe']; ?>" value="<?php echo $rowMoneda[$i]['tm_idmoneda']; ?>">
                                        <?php echo $rowMoneda[$i]['tm_nombre'].' ('.$rowMoneda[$i]['tm_simbolo'].')'; ?>
                                    </option>
                                    <?php
                                    endfor;
                                endif;
                                ?>
                                </select>
                                <label for="ddlMonedaApertura" class="active"><?php $translate->__('Moneda'); ?></label>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="input-field full-size">
                                <input id="txtImporteApertura" name="txtImporteApertura" type="text" class="validate text-right no-margin" value="0.00">
                                <label for="txtImporteApertura"><?php $translate->__('Importe inicial'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div class="all-height padding20">
                        <div class="generic-panel gp-no-footer">
                            <div class="gp-header">
                                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label full-size">
                                    <select id="ddlTurnoApertura" name="ddlTurnoApertura" class="mdl-selectfield__select full-size">
                                    <?php
                                    if ($countTurno > 0):
                                        for ($i=0; $i < $countTurno; ++$i):
                                            ?>
                                        <option value="<?php echo $rsTurno[$i]['ta_codigo']; ?>">
                                            <?php echo $rsTurno[$i]['ta_denominacion']; ?>
                                        </option>
                                        <?php
                                        endfor;
                                    endif;
                                    ?>
                                    </select>
                                    <label for="ddlTurnoApertura" class="mdl-selectfield__label"><?php $translate->__('Turno'); ?></label>
                                    <span class="mdl-selectfield__error">Input is not a empty!</span>
                                </div>
                            </div>
                            <div class="gp-body">
                                <div class="scrollbarra">
                                    <div id="gvPersonalTurno">
                                        <ul class="collection">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section id="pnlFechaHora" class="slide-panel white mdl-shadow--4dp place-top-bottom-left col-md-5 no-padding" style="display: none;">
                            <div class="generic-panel">
                                <div class="gp-header">
                                    <h4 class="margin30">Seleccionar fecha/hora</h4>
                                    <div class="place-top-right padding20">
                                      <button type="button" id="btnCloseFechaHoraApertura" data-toggle="tooltip" data-placement="left" title="Cerrar" class="btn indigo white-text no-border"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="gp-body">
                                    <input type="hidden" name="hdFechaHoraApertura" id="hdFechaHoraApertura" value="<?php echo date('Y-m-d h:i:s') ?>">
                                    <div class="scrollbarra" style="border-top: 1px #ddd solid; border-bottom: 1px #ddd solid;">
                                        <div id="datetimepickerFHA" class="full-size"></div>
                                    </div>
                                </div>
                                <div class="gp-footer padding20">
                                    <button id="btnEstablecerFechaHoraApertura" type="button" class="btn btn-primary center-block"><i class="fa fa-calendar" aria-hidden="true"></i> Establecer fecha/hora</button>
                                </div>
                            </div>
                        </section>
                        <div class="slider-overlay hide" data-referer="#pnlFechaHora"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlRegMovimientoCaja" class="modal-dialog modal-example-content">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Movimiento de caja</span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra">
                <div class="padding20">
                    <div class="row">
                        <div class="input-field">
                            <select name="ddlTipoMovimiento" id="ddlTipoMovimiento" class="browser-default">
                                <?php
                                if ($countTipoMovimiento > 0):
                                    for ($i=0; $i < $countTipoMovimiento; ++$i):
                                ?>
                                <option value="<?php echo $rsTipoMovimiento[$i]['ta_codigo']; ?>">
                                    <?php echo $rsTipoMovimiento[$i]['ta_denominacion']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                            <label class="active" for="ddlTipoMovimiento"><?php $translate->__('Tipo Movimiento'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <select name="ddlConcepto" id="ddlConcepto" class="browser-default">
                                <?php
                                if ($countTipoMovCaja > 0):
                                    for ($i=0; $i < $countTipoMovCaja; ++$i):
                                ?>
                                <option value="<?php echo $rsTipoMovCaja[$i]['tm_idtipomovimiento_caja']; ?>">
                                    <?php echo $rsTipoMovCaja[$i]['tm_nombre']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                            <label class="active" for="ddlConcepto"><?php $translate->__('Concepto'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtSearchPersonal"><?php $translate->__('Personal'); ?></label>
                        <input type="text" name="txtSearchPersonal" id="txtSearchPersonal" class="full-size" style="width: 100%;" />
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <input id="txtImporteMovimiento" name="txtImporteMovimiento" type="text" class="text-right only-numbers" placeholder="0.00" value="0.00" />
                            <label for="txtImporteMovimiento"><?php $translate->__('Importe movimiento'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field">
                            <textarea id="txtObservacionMovCaja" name="txtObservacionMovCaja" class="materialize-textarea"></textarea>
                            <label for="txtObservacionMovCaja"><?php $translate->__('Observaci&oacute;n'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnRegistrarMovCaja" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Registrar movimiento
            </button>
            <button id="btnLimpiarMovCaja" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Limpiar
            </button>
        </div>
    </div>
    <div id="pnlCierreCaja" class="modal-dialog modal-example-content">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Cierre de caja</span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="padding20">
                <div class="row">
                    <div class="input-field">
                        <textarea id="txtObservacionCierreCaja" name="txtObservacionCierreCaja" class="materialize-textarea"></textarea>
                        <label for="txtObservacionCierreCaja"><?php $translate->__('Observaci&oacute;n'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <p class="left">
                <input type="checkbox" class="filled-in" checked id="chkLimpiarMesas" name="chkLimpiarMesas" value="1" />
                <label for="chkLimpiarMesas">Borrar &oacute;rdenes y mesas</label>
            </p>
            <button id="btnCerrarCaja" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Cerrar caja
            </button>
            <button id="btnLimpiarCierreCaja" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Limpiar
            </button>
        </div>
    </div>
    <div id="pnlCobranza" class="modal-example-content modaldos expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__heade red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Cobro de orden</span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div id="tabCobranza" class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect all-height">
                <div class="mdl-tabs__tab-bar">
                    <a id="tabcob_1" href="#starks-panel" class="mdl-tabs__tab is-active">Informaci&oacute;n de pago</a>
                    <a id="tabcob_2" href="#lannisters-panel" class="mdl-tabs__tab">Informaci&oacute;n de cliente</a>
                </div>
                <div class="mdl-tabs__panel is-active" id="starks-panel">
                    <div class="mdl-tabs__panel-content scrollbarra padding20">
                        <div id="pnlPagoTarjeta">
                            <div class="row">
                                <p>
                                    <input type="checkbox" class="filled-in" id="chkPagoTarjeta" name="chkPagoTarjeta" />
                                    <label for="chkPagoTarjeta">Pago con tarjeta</label>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label class="control-label" for="ddlNombreTarjeta">Tarjeta</label>
                                        <select name="ddlNombreTarjeta" id="ddlNombreTarjeta" class="form-control">
                                            <option value="0">Seleccione un tipo de tarjeta</option>
                                            <option value="1">VISA</option>
                                            <option value="1">MASTERCARD</option>
                                            <option value="1">AMERICAN EXPRESS</option>
                                            <option value="1">DINERS CLUB</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label class="control-label" for="txtNumeroTarjeta">N&uacute;mero de tarjeta:</label>
                                        <input type="text" name="txtNumeroTarjeta" placeholder="" id="txtNumeroTarjeta" class="form-control full-size" value="" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group required">
                                        <label class="control-label" for="txtImporteTarjeta">Importe:</label>
                                        <input type="text" name="txtImporteTarjeta" placeholder="" id="txtImporteTarjeta" class="form-control full-size text-right" value="0.00" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pnlPagoEfectivo">
                            <legend>Pago en efectivo</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Pag&oacute; con</h5>
                                </div>
                                <div class="col-md-6">
                                    <h5>Cambio de</h5>
                                </div>
                                <div class="col-md-6">
                                    <h4 id="lblEfectivoPago" class="no-margin"><span class="moneda">S/.</span>&nbsp;<span class="monto">0.00</span></h4>
                                </div>
                                <div class="col-md-6">
                                    <h4 id="lblEfectivoCambio" class="no-margin"><span class="moneda">S/.</span>&nbsp;<span class="monto">0.00</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="lannisters-panel">
                    <div class="mdl-tabs__panel-content scrollbarra padding20">
                        <input type="hidden" name="hdIdCliente" id="hdIdCliente" value="0">
                        <div class="row">
                            <div class="col-md-12 pos-rel">
                                <p>
                                    <input type="checkbox" class="filled-in" id="chkClienteDefault" name="chkClienteDefault" checked />
                                    <label for="chkClienteDefault">Cliente por defecto</label>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pos-rel">
                                <p>
                                    <input name="rbRegCliente" type="radio" id="rbObtenerCliente" value="GET" checked />
                                    <label for="rbObtenerCliente">Buscar clientes...</label>
                                </p>
                                <input disabled type="text" name="txtSearchCliente" id="txtSearchCliente" class="full-size" style="width: 100%;" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <input name="rbRegCliente" type="radio" id="rbNuevoCliente" value="NEW" />
                                    <label for="rbNuevoCliente">... O registrar uno nuevo...</label>
                                </p>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-md-6">
                                <label class="control-label" for="ddlTipoDocCliente"><?php $translate->__('Tipo de documento'); ?></label>
                                <select id="ddlTipoDocCliente" name="ddlTipoDocCliente" disabled class="form-control full-size">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtNroDocCliente" name="txtNroDocCliente">
                                    <label for="txtNroDocCliente"><?php $translate->__('Documento de identidad'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin rowClienteNatural">
                            <div class="col-md-4">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtApePaternoCliente" name="txtApePaternoCliente">
                                    <label for="txtApePaternoCliente"><?php $translate->__('Apellido paterno'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtApeMaternoCliente" name="txtApeMaternoCliente">
                                    <label for="txtApeMaternoCliente"><?php $translate->__('Apellido materno'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtNombresCliente" name="txtNombresCliente">
                                    <label for="txtNombresCliente"><?php $translate->__('Nombres'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin rowClienteJuridico">
                            <div class="col-md-12">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtRazonSocialCliente" name="txtRazonSocialCliente">
                                    <label for="txtRazonSocialCliente"><?php $translate->__('Raz&oacute;n Social'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-md-12">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtDireccionCliente" name="txtDireccionCliente">
                                    <label for="txtDireccionCliente"><?php $translate->__('Direcci&oacute;n'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-md-6">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtTelefonoCliente" name="txtTelefonoCliente">
                                    <label for="txtTelefonoCliente"><?php $translate->__('Tel&eacute;fono'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-field">
                                    <input class="validate" disabled type="text" id="txtEmailCliente" name="txtEmailCliente">
                                    <label for="txtEmailCliente"><?php $translate->__('Email'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin">
                            <div class="col-md-6">
                                <label for="ddlPaisCliente" class="active"><?php $translate->__('Pa&iacute;s'); ?></label>
                                <select id="ddlPaisCliente" name="ddlPaisCliente" class="browser-default">
                                <?php echo loadOpcionSel("tp_pais", "Activo=1", "tp_idpais", "tp_nombre", "", "", "tp_codigo DESC"); ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ddlRegionCliente" class="active"><?php $translate->__('Regi&oacute;n'); ?></label>
                                <select id="ddlRegionCliente" name="ddlRegionCliente" class="browser-default">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="row">
                <div class="col-md-8">
                    <div class="row no-margin">
                        <div class="col-md-4">
                            <h5 class="no-margin">Total</h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="no-margin">Impuesto</h5>
                        </div>
                        <div class="col-md-4">
                            <h5 class="no-margin">Total + impuesto</h5>
                        </div>
                    </div>
                    <div class="row no-margin">
                        <div class="col-md-4">
                            <h4 id="lblTotalSinImpuesto"><span class="moneda">S/.</span> <span class="monto">0.00</span></h4>
                        </div>
                        <div class="col-md-4">
                            <h4 id="lblImpuesto"><span class="moneda">S/.</span> <span class="monto">0.00</span></h4>
                        </div>
                        <div class="col-md-4">
                            <h4 id="lblTotalConImpuesto"><span class="moneda">S/.</span> <span class="monto">0.00</span></h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button id="btnCobrar" type="button" class="btn btn-primary left waves-effect center-block margin5 v-align-middle">Cobrar</button>
                    <button id="btnImprimir" type="button" disabled class="btn btn-success right waves-effect center-block margin5 v-align-middle">Imprimir</button>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlVentas" class="modal-example-content modal-nomodal">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Lista de ventas realizadas</span>
                    <div class="mdl-layout-spacer"></div>
                    <div id="pnlSearchVentas" class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right hide">
                        <label class="mdl-button mdl-js-button mdl-button--icon" for="txtSearchServ">
                            <i class="material-icons">search</i>
                        </label>
                        <div class="mdl-textfield__expandable-holder">
                            <input class="mdl-textfield__input height-auto" type="text" name="txtSearchServ" id="txtSearchServ">
                        </div>
                    </div>
                    <button id="btnAbrirFiltroVentas" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect white-text tooltipped" data-tooltip="Filtrar ventas" data-position="top">Filtrar</button>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div id="gvVentas" class="gridview scrollbarra col-md-12 padding-top20" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar"></div>
        </div>
    </div>
    <div id="pnlImprimible" class="hide_imprimible">
        <?php
        $nombrecomercial = '';
        $razonsocial = '';
        $direccionfiscal = '';
        $descripcion_comercial = '';
        $eslogan = '';
        $numerodoc = '';
        $email = '';
        $telefono = '';
        $pagina_web = '';
        $logo = '../../images/logo-main100x100.png';
        $observaciones = '';

        $rowEmpresa = $objEmpresa->Listar('1', $IdEmpresa, "", 0);
        $countRowEmpresa = count($rowEmpresa);

        if ($countRowEmpresa > 0) {
            $nombrecomercial = $rowEmpresa[0]['tm_nombre_comercial'];
            $razonsocial = $rowEmpresa[0]['tm_razon_social'];
            $direccionfiscal = $rowEmpresa[0]['tm_direccion_fiscal'];
            $descripcion_comercial = $rowEmpresa[0]['tm_descripcion_comercial'];
            $eslogan = $rowEmpresa[0]['tm_eslogan'];
            $numerodoc = $rowEmpresa[0]['tm_codigo_fiscal'];
            $email = $rowEmpresa[0]['tm_email'];
            $telefono = $rowEmpresa[0]['tm_telefono'];
            $pagina_web = $rowEmpresa[0]['tm_pagina_web'];
            $logo = $rowEmpresa[0]['tm_logo'];
            $observaciones = $rowEmpresa[0]['tm_observaciones'];
        }
        ?>
        <article class="performance-facts">
            <header>
                <div class="row">
                    <table style="width: 100%;">
                        <tr>
                            <td rowspan="2" style="text-align: center;"><img src="<?php echo $logo; ?>" alt=""></td>
                            <td style="text-align: center;"><h2><?php echo $nombrecomercial; ?></h2></td>
                        </tr>
                        <tr>
                          <td style="text-align: center;"><h5><?php echo $descripcion_comercial; ?></h5></td>
                      </tr>
                    </table>
                </div>
                <div class="row">
                    <h5 style="text-align: center;"><?php echo $eslogan; ?></h5>
                </div>
                <div class="row">
                    <h4 style="text-align: center;"><?php echo $razonsocial; ?></h4>
                </div>
                <div class="row">
                    <h4 style="text-align: center;">RUC <?php echo $numerodoc; ?></h4>
                </div>
                <div class="row">
                    <h4 style="text-align: center;"><?php echo $direccionfiscal; ?></h4>
                </div>
                <div class="row">
                    <h5 style="text-align: center;"><?php echo $telefono; ?></h5>
                </div>
                <div class="row">
                    <h4 id="lblTipoComprobante_print" style="text-align: center;"></h4>
                </div>
                <div class="row">
                    <h4 id="lblCodigoVenta_print" style="text-align: center;"></h4>
                </div>
                <p>
                    <h4>CENTRO 1</h4>
                    <strong>Direccion CENTRO</strong>
                </p>
                <p>
                    FECHA DE EMISION: <span id="lblFechaHora_print"></span>
                </p>
                <p>
                    CORRELATIVO: <span id="lblCorrelativo_print"></span>
                </p>
                <p>
                    CAJA/TURNO: <span id="lblCajaTurno_print"></span>
                </p>
                <p>
                    TIPO DE MONEDA: <span id="lblMoneda_print"></span>
                </p>
            </header>
            <section>
              <table class="performance-facts__table">
                <thead>
                    <tr>
                        <th colspan="4" class="small-info">Conceptos de venta</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>
            <section>
                <p class="small-info">
                    Total de venta
                </p>
                <p class="small-info">
                    &bull;
                    Total <span id="lblTotal_print"></span><br>
                    &bull;
                    Impuestos <span id="lblImpuestos_print"></span><br>
                    &bull;
                    Total + Impuestos <span id="lblTotalImp_print"></span>
                </p>
            </section>
            <section>
                <table class="performance-facts__table--small small-info">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr><td><span id="lblNombreCliente_print"></span></td></tr>
                    </tbody>
                </table>
            </section>
        </article>
    </div>
    <div id="pnlProductos" class="modal-example-content modal-nomodal">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="no-shadow white-text padding10 dropbutton-material" id="btnChooseTipoItem" data-tipoitem="00"><i class="material-icons right">&#xE5C5;</i><span class="text">Seleccionar articulos</span></a>
                    </span>
                    <div class="mdl-layout-spacer"></div>
                    <div id="pnlSearchArticulo" class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">
                        <label class="mdl-button mdl-js-button mdl-button--icon" for="txtSearchProd">
                            <i class="material-icons">search</i>
                        </label>
                        <div class="mdl-textfield__expandable-holder">
                            <input class="mdl-textfield__input height-auto" type="text" name="txtSearchProd" id="txtSearchProd">
                        </div>
                    </div>
                    <div id="pnlSearchServicio" class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right hide">
                        <label class="mdl-button mdl-js-button mdl-button--icon" for="txtSearchServ">
                            <i class="material-icons">search</i>
                        </label>
                        <div class="mdl-textfield__expandable-holder">
                            <input class="mdl-textfield__input height-auto" type="text" name="txtSearchServ" id="txtSearchServ">
                        </div>
                    </div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <ul id="mnuTipoItem" class="dropdown dropdown-sites">
            <li><a href="#" data-tipoitem="00">Seleccionar articulos</a></li>
            <li><a href="#" data-tipoitem="01">Seleccionar servicios</a></li>
        </ul>
        <div class="modal-example-body">
            <div id="gvInsumo" class="pos-rel all-height" data-selected="none" data-multiselect="false">
                <div class="table-responsive-vertical shadow-z-1 all-height">
                    <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th><?php $translate->__('Articulo'); ?></th>
                                <th><?php $translate->__('Cantidad'); ?></th>
                                <th><?php $translate->__('Precio'); ?></th>
                                <th><?php $translate->__('Subtotal'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="gvServicio" class="pos-rel all-height hide" data-selected="none" data-multiselect="false">
                <div class="table-responsive-vertical shadow-z-1 all-height">
                    <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php $translate->__('Servicio'); ?></th>
                                <th><?php $translate->__('Cliente'); ?></th>
                                <th><?php $translate->__('Fecha de inicio'); ?></th>
                                <th><?php $translate->__('Precio'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAddItemsVenta" type="button" disabled class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Agregar seleccionados
            </button>
        </div>
    </div>
    <div id="modalFiltroVentas" class="modal-example-content expand-phone modaluno">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="Ocultar" class="close-modal-example padding5 circle left"><i class="material-icons md-32">close</i></a>
                <h3 class="no-margin left">
                    Filtrar Ventas
                </h3>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra padding10">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            
                            <label for="chkFiltroFechaUnica">Filtrar por s&oacute;lo una fecha:</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-field">
                            <input type="text" id="txtSingleDate" name="txtSingleDate">
                            <label for="txtSingleDate"><?php $translate->__('Fecha'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            
                            <label for="chkFiltroFechaUnica">Filtrar por s&oacute;lo una fecha:</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-field">
                            <input type="text" id="txtSingleDate" name="txtSingleDate">
                            <label for="txtSingleDate"><?php $translate->__('Fecha'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnFiltrarVentas" type="button" class="btn btn-primary waves-effect center-block v-align-middle">Filtrar</button>
        </div>
    </div>

    <div id="pnlIngresoCliente" class="modal-example-content modal-nomodal">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="no-shadow white-text padding10 dropbutton-material" id="btnChooseTipoItem" data-tipoitem="00"><i class="material-icons right">&#xE5C5;</i><span class="text">Ingresar informaci&oacute;n de cliente</span></a>
                    </span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
        </div>
        <div class="modal-example-body">
            <div id="pnlInfoOrden" class="scrollbarra padding10">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="left material-icons">&#xE88E;</i> Informaci&oacute;n de cliente</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Tipo y n&uacute;mero de documento</h5>
                            </div>
                            <div class="col-md-6">
                                <h5>Email</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 id="lblDocumentoCLiente" class="no-margin">No proporcionado.</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 id="lblEmailCLiente" class="no-margin">No proporcionado.</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Raz&oacute;n social / Apellidos y nombres</h5>
                            </div>
                            <div class="col-md-6">
                                <h5>Celular/Tel&eacute;fono</h5>
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4 id="lblApeNomCliente" class="no-margin">No proporcionado.</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 id="lblCelularCLiente" class="no-margin">No proporcionado.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="left material-icons">&#xE88E;</i> Informaci&oacute;n de pago</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Forma de pago</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 id="lblFormaPago" class="no-margin">Efectivo</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnInsertarCliente" type="button" class="btn btn-primary waves-effect center-block v-align-middle">Insertar Cliente</button>
        </div>
    </div>
    <div id="modalCajaBlocker" class="overlay-blocker">
        <div class="Aligner all-height">
            <div class="Aligner-item Aligner-item--fixed bg-opacity-5 padding20">
                <div class="Demo">
                    <div class="row">
                        <h3 class="white-text center">Caja bloqueada</h3>
                    </div>
                    <div class="row">
                        <p class="white-text">
                            Caja bloqueada. Aperture caja para poder acceder.
                        </p>
                    </div>
                    <div class="row">
                        <button id="btnAbrirAperturaCaja" type="button" class="btn btn-primary waves-effect center-block v-align-middle">Aperturar caja</button>
                    </div>
                    <div class="row">
                        <button id="btnMostrarVentas" type="button" class="btn btn-primary waves-effect center-block v-align-middle">Ver ventas</button>
                    </div>
                    <div class="row">
                        <button id="btnMostrarCaja" type="button" class="btn btn-primary waves-effect center-block v-align-middle">Ver movimientos de caja</button>
                    </div>
                    <div class="row">
                        <button id="btnCerrarVentana" type="button" class="btn btn-danger waves-effect center-block v-align-middle">Cerrar ventana</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="pnlClientePorServicio" class="modal-example-content modaluno">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header red darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Ingresar informaci&oacute;n de cliente</span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">        
            <div class="scrollbarra padding10">
                <div class="row">
                    <div class="col-md-12 pos-rel">
                        <p>
                            <input type="radio" id="rbObtenerCliente__Servicio" name="rbRegCliente__Servicio" value="GET" checked />
                            <label for="rbObtenerCliente__Servicio">Buscar clientes...</label>
                        </p>
                        <input type="text" id="txtSearchCliente__Servicio" class="full-size" style="width: 100%;" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <input type="radio" id="rbNuevoCliente__Servicio" name="rbRegCliente__Servicio" value="NEW" />
                            <label for="rbNuevoCliente__Servicio">... O registrar uno nuevo...</label>
                        </p>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-6">
                        <label class="control-label" for="ddlTipoDocCliente__Servicio"><?php $translate->__('Tipo de documento'); ?></label>
                        <select id="ddlTipoDocCliente__Servicio" disabled class="form-control full-size">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtNroDocCliente__Servicio">
                            <label for="txtNroDocCliente__Servicio"><?php $translate->__('Documento de identidad'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin rowClienteNatural">
                    <div class="col-md-4">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtApePaternoCliente__Servicio">
                            <label for="txtApePaternoCliente__Servicio"><?php $translate->__('Apellido paterno'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtApeMaternoCliente__Servicio">
                            <label for="txtApeMaternoCliente__Servicio"><?php $translate->__('Apellido materno'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtNombresCliente__Servicio">
                            <label for="txtNombresCliente__Servicio"><?php $translate->__('Nombres'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin rowClienteJuridico">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtRazonSocialCliente__Servicio">
                            <label for="txtRazonSocialCliente__Servicio"><?php $translate->__('Raz&oacute;n Social'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtDireccionCliente__Servicio">
                            <label for="txtDireccionCliente__Servicio"><?php $translate->__('Direcci&oacute;n'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-6">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtTelefonoCliente__Servicio">
                            <label for="txtTelefonoCliente__Servicio"><?php $translate->__('Tel&eacute;fono'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtEmailCliente__Servicio">
                            <label for="txtEmailCliente__Servicio"><?php $translate->__('Email'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-6">
                        <label for="ddlPaisCliente__Servicio" class="active"><?php $translate->__('Pa&iacute;s'); ?></label>
                        <select id="ddlPaisCliente__Servicio" class="browser-default">
                        <?php echo loadOpcionSel("tp_pais", "Activo=1", "tp_idpais", "tp_nombre", "", "", "tp_codigo DESC"); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="ddlRegionCliente__Servicio" class="active"><?php $translate->__('Regi&oacute;n'); ?></label>
                        <select id="ddlRegionCliente__Servicio" class="browser-default">
                        </select>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnInsertarCliente__Servicio" type="button" class="btn btn-primary waves-effect center-block v-align-middle">Insertar</button>
        </div>
    </div>
</form>