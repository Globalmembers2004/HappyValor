<?php
require 'bussiness/tabla.php';
require 'bussiness/almacen.php';
require 'bussiness/unidadmedida.php';
require 'bussiness/tipocomprobante.php';
require 'bussiness/documentos.php';
require 'bussiness/formapago.php';
require 'bussiness/impuestos.php';
require 'bussiness/tarjeta.php';
require 'bussiness/monedas.php';

$objTabla = new clsTabla();
$objAlmacen = new clsAlmacen();
$objUM = new clsUnidadMedida();
$objTipoComprobante = new clsTipoComprobante();
$objDocIdentidad = new clsDocumentos();
$objFormaPago = new clsFormaPago();
$objImpuesto = new clsImpuesto();
$objTarjeta = new clsTarjetaPago();
$objMoneda = new clsMoneda();

$rsAlmacen = $objAlmacen->Listar('2', $IdEmpresa, $IdCentro, 0, '',0);
$countAlmacen = count($rsAlmacen);
$rowDocIdentidad = $objDocIdentidad->CodigoTributable('1,6');
$countRowDocIdentidad = count($rowDocIdentidad);
$rowImpuesto = $objImpuesto->ListarVigImpuesto();
$countRowImpuesto = count($rowImpuesto);
// $rowMoneda = $objMoneda->ListarVigMoneda();
$rowMoneda = $objMoneda->Listar(1, 0, '', 1);
$countRowMoneda = count($rowMoneda);
$rowTarjeta = $objTarjeta->ListarVigComision();
$countRowTarjeta = count($rowTarjeta);
$rowTipoComprobante = $objTipoComprobante->Listar('1', $IdEmpresa, $IdCentro,'0', '');
$countRowTipoComprobante = count($rowTipoComprobante);
$rowFormaPago = $objFormaPago->Listar('3', 0, '');
$countRowFormaPago = count($rowFormaPago);
$rowUM = $objUM->Listar('1', 0, '');
$countRowUM = count($rowUM);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" id="hdPageGeneral" name="hdPageGeneral" value="1" />
    <input type="hidden" id="hdPageProv" name="hdPageProv" value="1" />
    <input type="hidden" id="hdPageInsu" name="hdPageInsu" value="1" />
    <input type="hidden" id="hdPageProd" name="hdPageProd" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <input type="hidden" id="hdIdProducto" name="hdIdProducto" value="0">
    <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="0">
    <input type="hidden" id="hdIdSubCategoria" name="hdIdSubCategoria" value="0">
    <input type="hidden" id="hdTipoProducto" name="hdTipoProducto" value="00">
    <input type="hidden" id="hdIdAperturaCaja" name="hdIdAperturaCaja" value="0">
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header orange --waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Compras</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <?php include 'common/droplist-generic.php'; ?>
            <div class="mdl-layout__drawer-button">
                <!-- <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a> -->
                <a class="back-activity mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>              
            
<!--             <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div> -->
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div id="gvDatos" class="gridview scrollbarra col-md-12 padding-top20" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                    </div>
                </div>
            </main>
            <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">&#xE145;</i>
            </a>
        </div>
        <div id="pnlForm" class="inner-page-content" style="display:none;">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header mdl-layout--fixed-header">
                    <header class="mdl-layout__header orange">
                        <div class="mdl-layout__header-row">
                            <span class="mdl-layout-title">Registro de compra</span>
                            <div class="mdl-layout-spacer"></div>
                            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar cambios" id="btnGuardar">
                                <i class="material-icons">&#xE5CA;</i>
                            </button>
                        </div>
                    </header>
                    <div id="btnBackToList" class="mdl-button--icon mdl-layout__drawer-button">
                        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                            <i class="material-icons">&#xE5C4;</i>
                        </a>
                    </div>
                </div>
                <div class="gp-body">
                    <input type="hidden" id="hdIdProveedor" name="hdIdProveedor" value="0" />
                    <input type="hidden" id="hdImpuesto" name="hdImpuesto" value="0" />
                    <input type="hidden" id="hdTotalConImpuesto" name="hdTotalConImpuesto" value="0" />
                    <input type="hidden" id="hdTotalSinImpuesto" name="hdTotalSinImpuesto" value="0" />
                    <div id="pnlCompra" class="generic-panel">
                        <header class="gp-header">
                            <div class="mdl-grid no-padding">
                                <div class="mdl-cell mdl-cell--2-col">
                                        <label class="active" for="ddlTipoComprobante"><?php $translate->__('Tipo de comprobante'); ?></label>
                                        <select name="ddlTipoComprobante" id="ddlTipoComprobante" class="browser-default full-size">
                                            <?php
                                            if ($countRowTipoComprobante > 0):
                                                for ($i=0; $i < $countRowTipoComprobante; $i++):
                                            ?>
                                            <option data-codigosunat="<?php echo $rowTipoComprobante[$i]['CodigoSunat']; ?>" value="<?php echo $rowTipoComprobante[$i]['tm_idtipocomprobante']; ?>"><?php echo $rowTipoComprobante[$i]['tm_nombre']; ?></option>
                                            <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </select>
                                </div>
                                <div class="mdl-cell mdl-cell--2-col">
                                    <div class="form-group required no-margin">
                                        <label class="control-label" for="txtFecha">Fecha:</label>
                                        <div class="input-group date date-register" data-provide="datepicker">
                                            <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo date('d/m/Y'); ?>" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdl-cell mdl-cell--1-col">
                                    <div class="input-field">
                                        <input id="txtSerieComprobante" name="txtSerieComprobante" type="text" value="" />
                                        <label class="active" for="txtSerieComprobante"><?php $translate->__('Serie'); ?></label>
                                    </div>
                                </div>
                                <div class="mdl-cell mdl-cell--2-col">
                                    <div class="input-field">
                                        <input id="txtNroComprobante" name="txtNroComprobante" type="text" value="" />
                                        <label class="active" for="txtNroComprobante"><?php $translate->__('N# comprobante'); ?></label>
                                    </div>
                                </div>
                                <div class="mdl-cell mdl-cell--3-col">
                                    <div class="mdl-grid mdl-grid--no-spacing">
                                        <div class="mdl-cell mdl-cell--10-col">
                                                <label class="active" for="ddlFormaPago"><?php $translate->__('Forma de pago'); ?></label>
                                                <select name="ddlFormaPago" id="ddlFormaPago" class="browser-default full-size">
                                                    <?php
                                                    if ($countRowFormaPago > 0):
                                                        for ($i=0; $i < $countRowFormaPago; ++$i):
                                                    ?>
                                                    <option data-codigosunat="<?php echo $rowFormaPago[$i]['CodigoSunat']; ?>" value="<?php echo $rowFormaPago[$i]['tm_idformapago']; ?>">
                                                        <?php echo $rowFormaPago[$i]['tm_nombre']; ?>
                                                    </option>
                                                    <?php
                                                        endfor;
                                                    endif;
                                                    ?>
                                                </select>
                                        </div>
                                        <div class="mdl-cell mdl-cell--2-col pos-rel">
                                            <button id="btnEditTarjeta" type="button" class="mdl-button mdl-js-button mdl-button--icon centered hide">
                                                <i class="material-icons">&#xE3C9;</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdl-cell mdl-cell--2-col pos-rel">
                                    <div class="centered input-field" style="height: 50px; width: 156px;">
                                        <input type="checkbox" class="filled-in" id="chkIngresoAutomatico" name="chkIngresoAutomatico" checked="checked" />
                                        <label for="chkIngresoAutomatico" class="no-margin"><?php $translate->__('Ingreso Almacen'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="mdl-grid no-padding">
                                <div class="mdl-cell mdl-cell--2-col">
                                        <label class="active" for="ddlMoneda"><?php $translate->__('Moneda'); ?></label>
                                        <select name="ddlMoneda" id="ddlMoneda" class="browser-default full-size">
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
                                </div>
                                <div class="mdl-cell mdl-cell--1-col">
                                    <div class="input-field">
                                        <input id="txtTipoCambio" name="txtTipoCambio" type="text" class="text-right no-margin only-numbers" placeholder="0.00" />
                                        <label for="txtTipoCambio">Tipo de cambio</label>
                                    </div>
                                </div>
                                <div class="mdl-cell mdl-cell--7-col">
                                    <ul id="pnlInfoProveedor" class="pnlInfoProveedor demo-list-two mdl-list no-padding no-margin mdl-shadow--2dp">
                                        <li class="mdl-list__item mdl-list__item--two-line">
                                            <span class="mdl-list__item-primary-content">
                                                <i class="material-icons mdl-list__item-avatar">person</i>
                                                <span class="descripcion">Elegir proveedor...</span>
                                                <span class="mdl-list__item-sub-title docidentidad"></span>
                                            </span>
                                        </li>
                                    </ul>
                                    <!-- <div id="pnlInfoProveedor" data-idproveedor="0" class="panel-info">
                                        <div id="noticeProveedor" class="notice bg-darkRed white-text marker-on-bottom">
                                            Los datos del proveedor deben ingresarse.
                                        </div>
                                        <div class="foto"></div>
                                        <div class="info">
                                            <h3 class="descripcion no-margin">Elegir proveedor...</h3>
                                            <div class="row">
                                                <div class="col-md-4 detalle docidentidad"></div>
                                                <div class="col-md-8 detalle direccion"></div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="mdl-cell mdl-cell--2-col pos-rel">
                                    <button id="btnSelectDetalleCompra" type="button" class="mdl-button mdl-js-button waves-effect mdl-button--raised centered" style="width: 170px;">
                                        Seleccionar ITEMS
                                    </button>
                                </div>
                            </div>
                        </header>
                        <main class="gp-body">
                            <div id="tableDetalle" class="gridview pos-rel all-height" data-selected="none" data-multiselect="false">
                                <div class="table-responsive-vertical shadow-z-1 all-height">
                                    <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                        <thead>
                                            <tr>
                                                <th><?php $translate->__('#'); ?></th>
                                                <th><?php $translate->__('Descripci&oacute;n'); ?></th>
                                                <th><?php $translate->__('Presentaci&oacute;n - UM'); ?></th>
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
                        </main>
                        <footer class="gp-footer">
                            <div class="card-panel mdl-shadow--2dp margin20 no-padding">
                                <div class="mdl-grid no-padding">
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h4 class="align-center no-margin">Comisi&oacute;n de tarjeta</h4>
                                    </div>
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h4 class="align-center no-margin">Total</h4>
                                    </div>
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h4 class="align-center no-margin">
                                            <input type="checkbox" class="filled-in" id="chkImpuesto" name="chkImpuesto" checked="checked" />
                                            <label for="chkImpuesto" class="no-margin"><?php $translate->__('Impuesto'); ?></label>
                                        </h4>
                                    </div>
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h4 class="align-center no-margin">Total + impuesto</h4>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="mdl-grid no-padding">
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h3 id="lblTotalComision" class="align-center no-margin">
                                            <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                        </h3>
                                    </div>
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h3 id="lblTotalSinImpuesto" class="align-center no-margin">
                                            <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                        </h3>
                                    </div>
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h3 id="lblTotalImpuesto" class="align-center no-margin">
                                            <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                        </h3>
                                    </div>
                                    <div class="mdl-cell mdl-cell--3-col">
                                        <h3 id="lblTotalConImpuesto" class="align-center no-margin">
                                            <span class="simbolo-moneda">S/.</span><span class="monto">0.00</span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div id="pnlGuia" class="inner-page-content" style="display:none;">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header mdl-layout--fixed-header">
                    <header class="mdl-layout__header">
                        <div class="mdl-layout__header-row">
                            <span class="mdl-layout-title">Gu&iacute;a de remisi&oacute;n</span>
                            <div class="mdl-layout-spacer"></div>
                            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnGuardarGuia">
                                <i class="material-icons">&#xE5CA;</i>
                            </button>
                        </div>
                    </header>
                    <div id="btnBackToList_FromGuia" class="mdl-button--icon mdl-layout__drawer-button">
                        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                            <i class="material-icons">&#xE5C4;</i>
                        </a>
                    </div>
                </div>
                <div class="gp-body">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--3-col">
                            <div id="gpAlmacen" class="input-field">
                                <select name="ddlAlmacen" id="ddlAlmacen" class="browser-default full-size">
                                    <?php
                                    if ($countAlmacen > 0):
                                        for ($i=0; $i < $countAlmacen; $i++):
                                            if ($i == 0)
                                                $selected = ' selected';
                                            else
                                                $selected = '';
                                    ?>
                                    <option value="<?php echo $rsAlmacen[$i]['tm_idalmacen']; ?>">
                                        <?php echo $rsAlmacen[$i]['tm_nombre']; ?>
                                    </option>
                                    <?php
                                        endfor;
                                    endif;
                                    ?>
                                </select>
                                <label class="active" for="ddlAlmacen"><?php $translate->__('Almacen'); ?></label>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--7-col">
                            <ul class="pnlInfoProveedor demo-list-two mdl-list no-padding no-margin mdl-shadow--2dp">
                                <li class="mdl-list__item mdl-list__item--two-line">
                                    <span class="mdl-list__item-primary-content">
                                        <i class="material-icons mdl-list__item-avatar">person</i>
                                        <span class="descripcion">Elegir proveedor...</span>
                                        <span class="mdl-list__item-sub-title docidentidad"></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col">
                            <div class="input-field">
                                <select name="ddlMotivo" id="ddlMotivo" class="form-control">
                                <?php
                                $rowMotivo = $objTabla->ValorPorCampo('ta_motivo');
                                $countRowMotivo = count($rowMotivo);

                                for ($i=0; $i < $countRowMotivo; $i++):
                                ?>
                                <option value="<?php echo $rowMotivo[$i]['ta_codigo']; ?>"<?php echo $selected; ?>><?php echo $rowMotivo[$i]['ta_denominacion']; ?></option>
                                <?php
                                endfor;
                                ?>
                                </select>
                                <label class="active" for="ddlMotivo">Motivo</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div id="pnlProductos" class="modal-example-content modal-nomodal">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header orange">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Seleccionar Items</span>
                    <div class="mdl-layout-spacer"></div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right">
                        <label class="mdl-button mdl-js-button mdl-button--icon" for="txtSearchProd">
                            <i class="material-icons">search</i>
                        </label>
                        <div class="mdl-textfield__expandable-holder">
                            <input class="mdl-textfield__input height-auto" type="text" name="txtSearchProd" id="txtSearchProd">
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
        <div class="modal-example-body">
            <div id="tabAddItemsCompra" class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect all-height">
                <div class="mdl-tabs__tab-bar">
                    <a href="#starks-panel" class="mdl-tabs__tab is-active no-">Insumos</a>
                    <a href="#starks-panel" class="mdl-tabs__tab no-">Articulos</a>
                    <a href="#rogers-panel" class="mdl-tabs__tab no-">Personalizado</a>
                </div>
                <div class="mdl-tabs__panel is-active" id="starks-panel">
                    <div class="mdl-tabs__panel-content">
                        <div id="gvInsumo" class="pos-rel all-height" data-selected="none" data-multiselect="false">
                            <div class="table-responsive-vertical shadow-z-1 all-height">
                                <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><?php $translate->__('Insumo'); ?></th>
                                            <th><?php $translate->__('Presentaci&oacute;n'); ?></th>
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
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="rogers-panel">
                    <div class="mdl-tabs__panel-content">
                        <div id="gvCustomDetails" class="pos-rel all-height" data-selected="none" data-multiselect="false">
                            <div class="table-responsive-vertical shadow-z-1 all-height">
                                <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                    <thead>
                                        <tr>
                                            <th><?php $translate->__('Descripci&oacute;n'); ?></th>
                                            <th><?php $translate->__('Cantidad'); ?></th>
                                            <th><?php $translate->__('Precio'); ?></th>
                                            <th><?php $translate->__('Subtotal'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-title="Descripci&oacute;n">
                                                <div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input descripcion" type="text" id="descripcion_custom0" value=""><label class="mdl-textfield__label" for="descripcion_custom0"></label></div>
                                            </td>
                                            <td data-title="Cantidad">
                                                <div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right cantidad" type="number" step="any" id="cantidad_custom0" value=""><label class="mdl-textfield__label" for="cantidad_custom0"></label></div>
                                            </td>
                                            <td data-title="Precio">
                                                <div class="mdl-input-js mdl-textfield mdl-js-textfield full-size no-padding"><input class="mdl-textfield__input align-right precio" type="number" step="any" id="precio_custom0" value=""><label class="mdl-textfield__label" for="precio_custom0"></label></div>
                                            </td>
                                            <td data-title="SubTotal" class="subtotal">
                                                <input type="hidden" id="subtotal_custom0" value="0"><h4 class="grey-text text-right">0.00</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAddItemsCompra" type="button" disabled class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Agregar seleccionados
            </button>
        </div>
    </div>
    <div id="pnlProveedor" class="modal-example-content modaldos expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Proveedor</span>
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
            <div class="scrollbarra padding20">
                <div class="row">
                    <div class="col-md-12 pos-rel">
                        <p>
                            <input name="rbRegProveedor" type="radio" id="rbObtenerProveedor" value="GET" checked />
                            <label for="rbObtenerProveedor">Buscar proveedores...</label>
                        </p>
                        <input type="text" name="txtSearchProveedor" id="txtSearchProveedor" class="full-size" style="width: 100%;" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <input name="rbRegProveedor" type="radio" id="rbNuevoProveedor" value="NEW" />
                            <label for="rbNuevoProveedor">... O registrar uno nuevo...</label>
                        </p>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-4">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtNroDocProveedor" name="txtNroDocProveedor">
                            <label for="txtNroDocProveedor"><?php $translate->__('RUC'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtRazonSocialProveedor" name="txtRazonSocialProveedor">
                            <label for="txtRazonSocialProveedor"><?php $translate->__('Raz&oacute;n Social'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtDireccionProveedor" name="txtDireccionProveedor">
                            <label for="txtDireccionProveedor"><?php $translate->__('Direcci&oacute;n'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-6">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtTelefonoProveedor" name="txtTelefonoProveedor">
                            <label for="txtTelefonoProveedor"><?php $translate->__('Celular'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field">
                            <input class="validate" disabled type="text" id="txtEmailProveedor" name="txtEmailProveedor">
                            <label for="txtEmailProveedor"><?php $translate->__('Email'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAddProveedor" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Seleccionar proveedor
            </button>
        </div>
    </div>
    <div id="pnlRequerimiento" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Compra por requerimiento
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <div class="col-md-4 no-margin">
                        <div id="dateMenu" class="calendar"></div>
                    </div>
                    <div class="col-md-6 no-margin">
                        <div id="tableDetRequerimiento" class="itables">
                            <div class="ihead">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><?php $translate->__('#'); ?></th>
                                            <th><?php $translate->__('Insumos'); ?></th>
                                            <th><?php $translate->__('Programado'); ?></th>
                                            <th><?php $translate->__('En stock'); ?></th>
                                            <th><?php $translate->__('Requerido'); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="ibody">
                                <div class="ibody-content">
                                    <table>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="col-md-6">
                        <button id="btnAplicarRequerimiento" type="button" class="command-button success">Aplicar</button>
                    </div>
                    <div class="col-md-6">
                        <button id="btnLimpiarRequerimiento" type="button" class="command-button default">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlInfoTarjeta" class="modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title"> Informaci&oacute;n de tarjeta</span>
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
            <div class="scrollbarra padding20">
                <div class="row no-margin">
                    <div class="col-md-6">
                            <label class="active" for="ddlNombreTarjeta"><?php $translate->__('Tarjeta'); ?></label>
                            <select name="ddlNombreTarjeta" id="ddlNombreTarjeta" class="browser-default">
                                <?php
                                if ($countRowTarjeta > 0):
                                    for ($i=0; $i < $countRowTarjeta; ++$i):
                                ?>
                                <option data-comision="<?php echo $rowTarjeta[$i]['td_importe']; ?>" value="<?php echo $rowTarjeta[$i]['tm_idtarjetapago']; ?>">
                                    <?php echo $rowTarjeta[$i]['tm_nombre']; ?>
                                </option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                            </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field">
                            <input id="txtComisionTarjeta" name="txtComisionTarjeta" type="text" class="text-right only-numbers" value="" />
                            <label for="txtComisionTarjeta"><?php $translate->__('Comisi&oacute;n'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input id="txtCodigoRecibo" name="txtCodigoRecibo" type="text" class="text-right only-numbers" value="" />
                            <label for="txtCodigoRecibo"><?php $translate->__('C&oacute;digo de recibo (voucher)'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarTarjeta" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
            <button id="btnLimpiarTarjeta" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Limpiar
            </button>
        </div>
    </div>
    <div id="modalOpcionDetalleCompra" class="modal-example-content modal-dialog expand-phone" style="width: 300px; height: 450px;">
        <header class="modal-example-header">
            <h4 class="no-margin padding5">Seleccionar opci&oacute;n</h4>
        </header>
        <main class="modal-example-body">
            <div class="modal-example-wrapper padding20">
                <div class="row">
                    <p>
                        <input class="with-gap" name="rbOpcionDetalleCompra" type="radio" id="rbOpcionInsumo" value="INS" checked /><label for="rbOpcionInsumo">Insumos</label>
                    </p>
                    <p>
                        <input class="with-gap" name="rbOpcionDetalleCompra" type="radio" id="rbOpcionArticulo" value="ART" /><label for="rbOpcionArticulo">Articulos</label>
                    </p>
                    <!-- <p>
                        <input class="with-gap" name="rbOpcionDetalleCompra" type="radio" id="rbOpcionArticulo" value="CUS" /><label for="rbOpcionCustom">Personalizado</label>
                    </p> -->
                </div>
                <!-- <div class="row">
                    <div class="input-field">
                        <input disabled value="" id="txtDetalleCompra" name="txtDetalleCompra" type="text" class="validate">
                        <label for="txtDetalleCompra">Detalle de compra</label>
                    </div>
                </div> -->
            </div>
        </main>
        <footer class="modal-example-footer">
            <button id="btnAplicarSeleccionDetalle" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
        </footer>
    </div>
    <div class="row hide">
        <select id="ddlUnidadMedida" name="ddlUnidadMedida">
        <?php 
        if ($countRowUM > 0):
            for ($i=0; $i < $countRowUM; $i++):
        ?>
        <option data-simbolo="<?php echo $rowUM[$i]['tm_abreviatura']; ?>" value="<?php echo $rowUM[$i]['tm_idunidadmedida']; ?>"><?php echo $rowUM[$i]['tm_nombre'].' ('.$rowUM[$i]['tm_abreviatura'].')'; ?></option>
        <?php
            endfor;
        endif;
        ?>
        </select>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>