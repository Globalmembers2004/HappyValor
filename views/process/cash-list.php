<?php
include('bussiness/tabla.php');
include('bussiness/monedas.php');
include('bussiness/ventas.php');

$counterTurno = 0;
$counterMoneda = 0;
$counterTipoMovimiento = 0;
$counterTipoMovCaja = 0;

$objTabla = new clsTabla();
$objMoneda = new clsMoneda();
$objVenta = new clsVenta();

$rsTurno = $objTabla->Listar('BY-FIELD', 'ta_turno');
$countTurno = count($rsTurno);
$rsTipoMovimiento = $objTabla->Listar('BY-FIELD', 'ta_tipomovimiento');
$countTipoMovimiento = count($rsTipoMovimiento);
$rowMoneda = $objMoneda->ListarVigMoneda();
$countRowMoneda = count($rowMoneda);
$rsTipoMovCaja = $objVenta->ListarTipoMovCaja('1', 0, '');
$countTipoMovCaja = count($rsTipoMovCaja);
?>
<form id="form1" name="form1" method="post" action="services/ventas/caja-post.php">
    <input type="hidden" id="lang" name="lang" value="<?php echo $lang; ?>" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <input type="hidden" name="hdIdAperturaCaja" id="hdIdAperturaCaja" value="0">
    <input type="hidden" name="hdIdMoneda" id="hdIdMoneda" value="0">
    <input type="hidden" name="hdTipoDataPersona" id="hdTipoDataPersona" value="0">
    <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="0" />
    <input type="hidden" id="hdIdPerfil" name="hdIdPerfil" value="<?php echo $idperfil; ?>" />
    <div class="page-region">
        <div id="pnlCaja" class="sectionInception">
            <div class="sectionHeader">
                <h1 class="title-window">
                    <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i>
                    </a>
                    Caja
                    <button class="large no-margin success" type="button" data-tipomov="00">Ingresos</button>
                    <button class="large no-margin" type="button" data-tipomov="01" data-target="#tabCaja2">Salidas</button>
                </h1>
            </div>
            <div class="sectionContent">
                <section id="tabCaja1" class="padding10">
                    <div class="generic-panel">
                        <div class="gp-header">
                            <div class="grid fluid">
                                <div class="row">
                                    <div class="span4">
                                        <h2>
                                            Fecha: 
                                            <span id="lblFechaRegistroCaja"></span>
                                        </h2>
                                    </div>
                                    <div class="span4">
                                        <h2>
                                            Turno: 
                                            <span id="lblTurnoCaja"></span>
                                        </h2>
                                    </div>
                                    <div class="span4 text-right">
                                        <h2>
                                            Importe Actual: 
                                            <span id="lblMonedaActual"></span>
                                            <span id="lblImporteActual">0.00</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gp-body">
                            <div id="tableRegistroCaja" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Concepto</th>
                                                <th>Hora</th>
                                                <th>Moneda</th>
                                                <th>Importe</th>
                                                <th>Observaci&oacute;n</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="ibody">
                                    <div class="ibody-content">
                                        <table style="font-size: 12pt;">
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gp-footer">
                            <div class="grid fluid">
                                <div class="row">
                                    <div class="span4">
                                        <h2>Importe inicial: <span id="lblMonedaInicial"></span> <span id="lblImporteInicial">0.00</span></h2>
                                    </div>
                                    <div class="span4"></div>
                                    <div class="span4 text-right">
                                        <h2>Importe total: <span id="lblMonedaTotalCaja"></span> <span id="lblImporteTotalCaja">0.00</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="appbar">
        <button id="btnCierreCaja" type="button" class="metro_button oculto float-right" data-hint-position="top" data-hint="<?php $translate->__('Cerrar caja'); ?>">
            <h2><i class="icon-locked"></i></h2>
        </button>
        <button id="btnRegistrarMovimiento" type="button" class="metro_button oculto float-right" data-hint-position="top" data-hint="<?php $translate->__('Realizar movimiento'); ?>">
            <h2><i class="icon-coins"></i></h2>
        </button>
        <button id="btnVerAperturas" type="button" class="metro_button float-left" data-hint-position="top" data-hint="<?php $translate->__('Ver aperturas de hoy'); ?>">
            <h2><i class="icon-eye"></i></h2>
        </button>
        <button id="btnAperturaCaja" type="button" class="metro_button oculto float-left" data-hint-position="top" data-hint="<?php $translate->__('Aperturar caja'); ?>">
            <h2><i class="icon-unlocked"></i></h2>
        </button>
    </div>
    <div id="pnlSearchPersona" class="top-panel with-title-window" style="display:none;">
        <div id="pnlPersona" class="sectionInception">
            <div class="sectionHeader">
                <h1 class="title-window">
                    <a href="#" id="btnExitPersona" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    <?php $translate->__('Persona'); ?>
                    <button class="large success no-margin" type="button" data-tipodata="00"><?php $translate->__('Clientes'); ?></button>
                    <button class="large no-margin" type="button" data-tipodata="01"><?php $translate->__('Proveedores'); ?></button>
                    <button class="large no-margin" type="button" data-tipodata="02"><?php $translate->__('Empleados'); ?></button>
                </h1>
            </div>
            <div class="sectionContent">
                <section id="tab1">
                    <div class="inner-page with-panel-search">
                        <div class="panel-search">
                            <div class="input-control text" data-role="input-control">
                                <input type="text" id="txtSearchPersona" name="txtSearchPersona" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearchPersona" type="button" class="btn-search" tabindex="-1"></button>
                            </div>
                        </div>
                        <div id="precargaPer" class="divload">
                            <div id="gvPersona" style="height: 100%;">
                                <div class="items-area listview gridview"></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div id="pnlAperturaCaja" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Apertura de caja
            </h2>
        </div>
        <div class="modal-example-body">
            <div  id="pnlFormApertura" class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="grid fluid">
                        <div class="row">
                            <div class="span6">
                                <label for="ddlMonedaApertura"><?php $translate->__('Moneda'); ?></label>
                                <div class="input-control select fa-caret-down">
                                    <select name="ddlMonedaApertura" id="ddlMonedaApertura">
                                        <?php
                                        if ($countRowMoneda > 0):
                                            for ($counterMoneda=0; $counterMoneda < $countRowMoneda; ++$counterMoneda):
                                        ?>
                                        <option data-tipocambio="<?php echo $rowMoneda[$counterMoneda]['td_importe']; ?>" value="<?php echo $rowMoneda[$counterMoneda]['tm_idmoneda']; ?>">
                                            <?php echo $rowMoneda[$counterMoneda]['tm_nombre'].' ('.$rowMoneda[$counterMoneda]['tm_simbolo'].')'; ?>
                                        </option>
                                        <?php
                                            endfor;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span6">
                                <label for="txtImporteApertura"><?php $translate->__('Importe inicial'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtImporteApertura" name="txtImporteApertura" type="text" class="text-right only-numbers" placeholder="0.00" value="0.00" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="ddlTurnoApertura"><?php $translate->__('Turno'); ?></label>
                            <div class="input-control select fa-caret-down">
                                <select name="ddlTurnoApertura" id="ddlTurnoApertura">
                                    <?php
                                    if ($countTurno > 0):
                                        for ($counterTurno=0; $counterTurno < $countTurno; ++$counterTurno):
                                    ?>
                                    <option value="<?php echo $rsTurno[$counterTurno]['ta_codigo']; ?>">
                                        <?php echo $rsTurno[$counterTurno]['ta_denominacion']; ?>
                                    </option>
                                    <?php
                                        endfor;
                                    endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="gvPersonalTurno" class="items-area listview gridview scrollbarra"></div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6"></div>
                    <div class="span3">
                        <button id="btnRegistrarApertura" type="button" class="command-button success">Aperturar</button>
                    </div>
                    <div class="span3">
                        <button id="btnLimpiarApertura" type="button" class="command-button default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlRegMovimientoCaja" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Movimiento de caja
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="ddlTipoMovimiento"><?php $translate->__('Tipo Movimiento'); ?></label>
                    <div class="input-control select fa-caret-down">
                        <select name="ddlTipoMovimiento" id="ddlTipoMovimiento">
                            <?php
                            if ($countTipoMovimiento > 0):
                                for ($counterTipoMovimiento=0; $counterTipoMovimiento < $countTipoMovimiento; ++$counterTipoMovimiento):
                            ?>
                            <option value="<?php echo $rsTipoMovimiento[$counterTipoMovimiento]['ta_codigo']; ?>">
                                <?php echo $rsTipoMovimiento[$counterTipoMovimiento]['ta_denominacion']; ?>
                            </option>
                            <?php
                                endfor;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label for="ddlConcepto"><?php $translate->__('Concepto'); ?></label>
                    <div class="input-control select fa-caret-down">
                        <select name="ddlConcepto" id="ddlConcepto">
                            <?php
                            if ($countTipoMovCaja > 0):
                                for ($counterTipoMovCaja=0; $counterTipoMovCaja < $countTipoMovCaja; ++$counterTipoMovCaja):
                            ?>
                            <option value="<?php echo $rsTipoMovCaja[$counterTipoMovCaja]['tm_idtipomovimiento_caja']; ?>">
                                <?php echo $rsTipoMovCaja[$counterTipoMovCaja]['tm_nombre']; ?>
                            </option>
                            <?php
                                endfor;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label><?php $translate->__('Persona'); ?></label>
                    <div id="pnlInfoPersonal" data-idpersona="0" class="grid fluid no-padding no-margin">
                        <div class="row">
                            <div class="span2 no-margin"></div>
                            <div class="span10 no-margin">
                                <h3 class="descripcion">Elegir persona...</h3>
                                <div class="grid fluid">
                                    <div class="span4 detalle docidentidad"></div>
                                    <div class="span8 detalle direccion"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="txtImporteMovimiento"><?php $translate->__('Importe movimiento'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtImporteMovimiento" name="txtImporteMovimiento" type="text" class="text-right only-numbers" placeholder="0.00" value="0.00" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtObservacionMovCaja"><?php $translate->__('Observaci&oacute;n'); ?></label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea id="txtObservacionMovCaja" name="txtObservacionMovCaja"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnRegistrarMovCaja" type="button" class="command-button success">Registrar</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarMovCaja" type="button" class="command-button default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlAperturasDia" class="modal-dialog modal-example-content without-footer">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Aperturas de hoy <span id="lblFechaHoy"></span>
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="tableAperturaDia" class="itables">
                <div class="ihead">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Moneda</th>
                                <th>Importe Inicial</th>
                                <th>Importe Final</th>
                                <th>Turno</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="ibody">
                    <div class="ibody-content">
                        <table style="font-size: 12pt;">
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlCierreCaja" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Cierre de caja
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtObservacionCierreCaja"><?php $translate->__('Observaci&oacute;n'); ?></label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea id="txtObservacionCierreCaja" name="txtObservacionCierreCaja"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnCerrarCaja" type="button" class="command-button danger">Cerrar caja</button>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarCierreCaja" type="button" class="command-button default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script src="scripts/app/process/cash-script.php?lang=<?php echo $lang; ?>"></script>