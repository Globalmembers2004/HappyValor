<?php
include('bussiness/almacen.php');
include('bussiness/unidadmedida.php');
include('bussiness/tipocomprobante.php');
include('bussiness/documentos.php');
include('bussiness/formapago.php');
include('bussiness/impuestos.php');
include('bussiness/tarjeta.php');
include('bussiness/monedas.php');

$IdEmpresa = 1;
$IdCentro = 1;

$counterMoneda = 0;
$counterTipoComprobante = 0;
$counterProdPrecio = 0;

$objAlmacen = new clsAlmacen();
$objUM = new clsUnidadMedida();
$objTipoComprobante = new clsTipoComprobante();
$objDocIdentidad = new clsDocumentos();
$objFormaPago = new clsFormaPago();
$objImpuesto = new clsImpuesto();
$objTarjeta = new clsTarjetaPago();
$objMoneda = new clsMoneda();

$rsAlmacen = $objAlmacen->Listar('2', $IdEmpresa, $IdCentro, 0, '');
$countAlmacen = count($rsAlmacen);
// $rowDocIdentidad = $objDocIdentidad->Listar('S', '', '\'1\', \'6\'');
// $countRowDocIdentidad = count($rowDocIdentidad);
$rowImpuesto = $objImpuesto->ListarVigImpuesto();
$countRowImpuesto = count($rowImpuesto);
$rowMoneda = $objMoneda->ListarVigMoneda();
$countRowMoneda = count($rowMoneda);
$rowTarjeta = $objTarjeta->ListarVigComision();
$countRowTarjeta = count($rowTarjeta);
$rowTipoComprobante = $objTipoComprobante->Listar('1', '0', '');
$countRowTipoComprobante = count($rowTipoComprobante);
$rowFormaPago = $objFormaPago->Listar('3', 0, '');
$countRowFormaPago = count($rowFormaPago);
$rowUM = $objUM->Listar('1', 0, '');
$countRowUM = count($rowUM);
?>
<form id="form1" name="form1" method="post" action="services/almacen/kardex-post.php">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageProv" name="hdPageProv" value="1" />
    <input type="hidden" id="hdPageInsu" name="hdPageInsu" value="1" />
    <input type="hidden" id="hdPageProd" name="hdPageProd" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdTipoProducto" name="hdTipoProducto" value="00" />
    <input type="hidden" id="hdIdProducto" name="hdIdProducto" value="0" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
       <!--  <div id="pnlListado" class="inner-page with-title-window with-panel-search">
            <h1 class="title-window">
                <a id="btnBack" href="#" title="Volver a inicio" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Log&iacute;stica
            </h1>
            <div class="panel-search">
                <table class="tabla-normal">
                    <tr>
                        <td>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtSearch" name="txtSearch" type="text" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                                <button id="btnSearch" name="btnSearch" type="button"  tabindex="-1" title="<?php $translate->__('Buscar'); ?>" class="btn-search"></button>
                            </div>
                        </td>
                        <td style="width:45px;">
                            <button id="btnFilter" type="button" title="<?php $translate->__('M&aacute;s filtros'); ?>" style="margin-left:10px; margin-bottom:0px;"><i class="icon-filter"></i></button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="grid filtro">
                <div class="row">
                    <div class="span12" style="margin-right:10px;">
                        <label for="ddlCargo"><?php $translate->__('Forma de pago'); ?></label>
                        <div class="input-control select" data-role="input-control">
                            <select id="ddlCargo" name="ddlCargo">
                                <option value="0"><?php $translate->__('TODOS'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="divload">
                <div id="gvDatos">
                    <div style="padding: 10px; height: 100%;">
                        <div id="tableDatos" class="itables">
                            <div class="ihead">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width:5%" class="text-left">#</th>
                                            <th style="width:30%" class="text-left"><?php $translate->__('Producto'); ?></th>
                                            <th style="width:25%" class="text-left"><?php $translate->__('Almacen'); ?></th>
                                            <th style="width:10%" class="text-left"><?php $translate->__('U. Medida'); ?></th>
                                            <th style="width:10%" class="text-right"><?php $translate->__('Ingreso'); ?></th>
                                            <th style="width:10%" class="text-right"><?php $translate->__('Salida'); ?></th>
                                            <th style="width:10%" class="text-right"><?php $translate->__('Existencias'); ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="ibody">
                                <div class="ibody-content">
                                    <table>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Log&iacute;stica</span>
                    <div class="mdl-layout-spacer"></div>
                    <input type="text" name="txtSearch" id="txtSearch" class="oculto" value="">
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <?php include 'common/droplist-generic.php'; ?>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div id="gvDatos">
                        <div style="padding: 10px; height: 100%;">
                            <div id="tableDatos" class="itables">
                                <div class="ihead">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th style="width:5%" class="text-left">#</th>
                                                <th style="width:30%" class="text-left"><?php $translate->__('Producto'); ?></th>
                                                <th style="width:25%" class="text-left"><?php $translate->__('Almacen'); ?></th>
                                                <th style="width:10%" class="text-left"><?php $translate->__('U. Medida'); ?></th>
                                                <th style="width:10%" class="text-right"><?php $translate->__('Ingreso'); ?></th>
                                                <th style="width:10%" class="text-right"><?php $translate->__('Salida'); ?></th>
                                                <th style="width:10%" class="text-right"><?php $translate->__('Existencias'); ?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="ibody">
                                    <div class="ibody-content">
                                        <table>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="pnlForm" class="inner-page" style="display:none;">
            <h1 class="title-window">
                <a id="btnBackList" href="#" title="<?php $translate->__('Regresar a listado'); ?>" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                <?php $translate->__('Ingreso de almacen'); ?>
            </h1>
            <div class="divContent">
                <div id="frmRegistro" class="form-register-data without-totales container">
                    <input type="hidden" id="lang" name="lang" value="<?php echo $lang; ?>" />
                    <input type="hidden" id="hdIdProveedor" name="hdIdProveedor" value="0" />
                    <input type="hidden" id="hdCodigoProveedor" name="hdCodigoProveedor" value="000" />
                    <input type="hidden" id="hdImpuesto" name="hdImpuesto" value="0" />
                    <input type="hidden" id="hdTotalConImpuesto" name="hdTotalConImpuesto" value="0" />
                    <input type="hidden" id="hdTotalSinImpuesto" name="hdTotalSinImpuesto" value="0" />
                    <div class="panel-maestro">
                        <div class="grid padding10">
                            <div class="row">
                                <div class="span5 no-margin">
                                    <div class="grid fluid">
                                        <div class="row">
                                            <div class="span7">
                                                <label for="ddlTipoComprobante"><?php $translate->__('Tipo de comprobante'); ?></label>
                                                    <select name="ddlTipoComprobante" id="ddlTipoComprobante">
                                                        <?php 
                                                        if ($countRowTipoComprobante > 0):
                                                            for ($counterTipoComprobante=0; $counterTipoComprobante < $countRowTipoComprobante; $counterTipoComprobante++):
                                                        ?>
                                                        <option data-codigosunat="<?php echo $rowTipoComprobante[$counterTipoComprobante]['CodigoSunat']; ?>" value="<?php echo $rowTipoComprobante[$counterTipoComprobante]['tm_idtipocomprobante']; ?>"><?php echo strtoupper($rowTipoComprobante[$counterTipoComprobante]['tm_nombre']); ?></option>
                                                        <?php
                                                            endfor;
                                                        endif;
                                                        ?>
                                                    </select>
                                            </div>
                                            <div class="span5">
                                                <label for="ddlFormaPago"><?php $translate->__('Forma de pago'); ?></label>
                                                    <select name="ddlFormaPago" id="ddlFormaPago">
                                                        <?php
                                                        if ($countRowFormaPago > 0):
                                                            for ($counterFormaPago=0; $counterFormaPago < $countRowFormaPago; ++$counterFormaPago):
                                                        ?>
                                                        <option data-codigosunat="<?php echo $rowFormaPago[$counterFormaPago]['CodigoSunat']; ?>" value="<?php echo $rowFormaPago[$counterFormaPago]['tm_idformapago']; ?>">
                                                            <?php echo $rowFormaPago[$counterFormaPago]['tm_nombre']; ?>
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
                                <div class="span3">
                                    <div class="grid fluid">
                                        <div class="row">
                                            <div class="span6">
                                                <label for="txtFecha"><?php $translate->__('Fecha'); ?></label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtFecha" name="txtFecha" type="text" />
                                                    <button type="button" class="btn-clear"></button>
                                                </div>
                                            </div>
                                            <div class="span6">
                                                <label for="txtFechaRecepcion"><?php $translate->__('Recepci&oacute;n'); ?></label>
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtFechaRecepcion" name="txtFechaRecepcion" type="text" />
                                                    <button type="button" class="btn-clear"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <label for="txtSerieComprobante"><?php $translate->__('N° de comprobante'); ?></label>
                                    <div class="grid fluid">
                                        <div class="row">
                                            <div class="span6" style="margin-left: 0;">
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtSerieComprobante" name="txtSerieComprobante" type="text" placeholder="Serie" value="" />
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                            <div class="span6">
                                                <div class="input-control text" data-role="input-control">
                                                    <input id="txtNroComprobante" name="txtNroComprobante" type="text" placeholder="N&uacute;mero" value="" />
                                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span3">
                                    <label for="ddlAlmacen"><?php $translate->__('Almacen'); ?></label>
                                        <select name="ddlAlmacen" id="ddlAlmacen">
                                            <?php
                                            if ($countAlmacen > 0):
                                                for ($counterAlmacen=0; $counterAlmacen < $countAlmacen; $counterAlmacen++):
                                                    if ($counterAlmacen == 0)
                                                        $selected = ' selected';
                                                    else
                                                        $selected = '';
                                            ?>
                                            <option value="<?php echo $rsAlmacen[$counterAlmacen]['tm_idalmacen']; ?>">
                                                <?php echo strtoupper($rsAlmacen[$counterAlmacen]['tm_nombre']); ?>
                                            </option>
                                            <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </select>
                                </div>
                                <div class="span3">
                                    <label for="txtDescripcionIngreso"><?php $translate->__('Descripci&oacute;n'); ?></label>
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtDescripcionIngreso" name="txtDescripcionIngreso" type="text" placeholder="Ingrese descripci&oacute;n" value="" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="pnlInfoProveedor" data-idproveedor="0" class="panel-info">
                                    <div class="foto"></div>
                                    <div class="info">
                                        <h3 class="descripcion">Elegir proveedor...</h3>
                                        <div class="grid fluid">
                                            <div class="span4 detalle docidentidad"></div>
                                            <div class="span8 detalle direccion"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-detalle">
                        <div id="tableDetalle" class="itables">
                            <div class="ihead">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><?php $translate->__('Item'); ?></th>
                                            <th><?php $translate->__('Presentaci&oacute;n'); ?></th>
                                            <th><?php $translate->__('UM'); ?></th>
                                            <th><?php $translate->__('Cantidad'); ?></th>
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
        <div id="pnlProductos" class="inner-page with-title-window with-panel-search" style="display:none;">
            <h1 class="title-window">
                <a id="btnBackForm" href="#" title="Regresar a mesas" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                <button id="btnInsumo" name="btnInsumo" class="large success" type="button" data-item="00">Insumos</button>
                <button id="btnArticulo" name="btnArticulo" class="large" type="button" data-item="01">Articulos</button>
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input type="text" id="txtSearchProd" name="txtSearchProd" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearchProducts" type="button" class="btn-search" tabindex="-1"></button>
                </div>
            </div>
            <div id="precargaInsu" class="divload">
                <div id="gvInsumo">
                    <div class="tile-area scrollbarra gridview"></div>
                </div>
            </div>
            <div id="precargaProd" class="divload" style="display:none;">
                <div id="gvProductos">
                    <div class="tile-area scrollbarra gridview"></div>
                </div>
            </div>
        </div>
        <div id="pnlOrdenesCompra" class="outer-page" style="background-color: #eee; display:none;"></div>
        <div id="pnlAdminAlmacen" class="outer-page" style="background-color: #eee; display:none;"></div>
    </div>
    <div class="appbar">
        <button id="btnStockAlmacen" name="btnStockAlmacen" type="button" class="metro_button float-left" data-hint-position="top" data-hint="Existencias" title="Existencias">
            <h2><i class="icon-battery"></i></h2>
        </button>
        <button id="btnCancelar" type="button" class="metro_button oculto float-right" data-hint-position="top" data-hint="Cancelar" title="Cancelar">
            <h2><i class="icon-cancel"></i></h2>
        </button>
        <button id="btnBuscarItems" type="button" class="metro_button oculto float-left" data-hint-position="top" data-hint="Agregar articulos" title="Agregar articulos">
            <h2><i class="icon-search"></i></h2>
        </button>
        <button id="btnQuitarItem" type="button" class="metro_button oculto float-left" data-hint-position="top" data-hint="Quitar item" title="Quitar item">
            <h2><i class="icon-remove"></i></h2>
        </button>
        <button id="btnGuardar" name="btnGuardar" type="button" class="metro_button oculto float-right" data-hint-position="top" data-hint="Guardar" title="Guardar">
            <h2><i class="icon-checkmark"></i></h2>
        </button>
        <button id="btnIngreso" type="button" class="metro_button float-right" data-hint-position="top" data-hint="Ingreso de almacen" title="Ingreso de almacen">
            <h2><i class="icon-plus-2"></i></h2>
        </button>
    </div>
    <div id="pnlProveedor" class="top-panel inner-page with-title-window with-panel-search with-appbar" style="display:none;">
        <h1 class="title-window">
            <a href="#" id="btnExitProvider" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
            <?php $translate->__('Proveedor'); ?>
        </h1>
        <div class="panel-search">
            <div class="input-control text" data-role="input-control">
                <input type="text" id="txtSearchProveedor" name="txtSearchProveedor" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                <button id="btnSearchProveedor" type="button" class="btn-search" tabindex="-1"></button>
            </div>
        </div>
        <div id="precargaProv" class="divload">
            <div id="gvProveedor" style="display:none;">
                <div class="items-area listview gridview"></div>
            </div>
            <div id="frmProveedor" class="form-insearch" style="display:none;">
                <div class="grid">
                    <div class="row">
                        <label for="txtRazonSocial">Raz&oacute;n Social</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtRazonSocial" name="txtRazonSocial" type="text" placeholder="<?php $translate->__('Ejemplo: Gonzales S.A.'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtRucEmpresa">N&uacute;mero de contribuyente</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtRucEmpresa" name="txtRucEmpresa" type="text" placeholder="<?php $translate->__('Ejemplo: 10450350261'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                    <div class="row">
                        <label for="txtDireccionJur">Direcci&oacute;n</label>
                        <div class="input-control text" data-role="input-control">
                            <input id="txtDireccionJur" name="txtDireccionJur" type="text" placeholder="<?php $translate->__('Ejemplo: Av. Jorge Chavez 484 Urb. Campodonico'); ?>">
                            <button class="btn-clear" tabindex="-1" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="appbar">
            <button id="btnDelProveedor" name="btnDelProveedor" type="button" class="cancel metro_button oculto float-right">
                <span class="content">
                    <img src="images/trash.png" alt="<?php $translate->__('Eliminar'); ?>" />
                    <span class="text"><?php $translate->__('Eliminar'); ?></span>
                </span>
            </button>
            <button id="btnEditProveedor" type="button" class="metro_button oculto float-right">
                <span class="content">
                    <img src="images/edit.png" alt="<?php $translate->__('Editar'); ?>" />
                    <span class="text"><?php $translate->__('Editar'); ?></span>
                </span>
            </button>
            <button id="btnCancelProveedor" type="button" class="metro_button oculto float-right">
                <span class="content">
                    <img src="images/cancel.png" alt="<?php $translate->__('Cancelar'); ?>" />
                    <span class="text"><?php $translate->__('Cancelar'); ?></span>
                </span>
            </button>
            <button id="btnSaveProveedor" name="btnSaveProveedor" type="button" class="metro_button oculto float-right">
                <span class="content">
                    <img src="images/save.png" alt="<?php $translate->__('Guardar'); ?>" />
                    <span class="text"><?php $translate->__('Guardar'); ?></span>
                </span>
            </button>
            <button id="btnNewProveedor" type="button" class="metro_button float-right">
                <span class="content">
                    <img src="images/add.png" alt="<?php $translate->__('Nuevo'); ?>" />
                    <span class="text"><?php $translate->__('Nuevo'); ?></span>
                </span>
            </button>
            <button id="btnCleanSelectProveedor" type="button" class="metro_button oculto float-right">
                <span class="content">
                    <img src="images/icon_uncheck.png" alt="<?php $translate->__('Limpiar selecci&oacute;n'); ?>" />
                    <span class="text"><?php $translate->__('Limpiar selecci&oacute;n'); ?></span>
                </span>
            </button>
        </div> -->
    </div>
    <div id="pnlInfoProducto" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a id="btnHidePnlInfoProducto" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Datos del producto
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="form-details">
                <div class="header-details">
                    <h2 id="lblDescripProducto"></h2>
                </div>
                <div class="input-details">
                    <div class="grid">
                        <div class="row">
                            <label for="">Presentaci&oacute;n</label>
                            <div class="input-control select">
                                <select name="ddlPresentacion" id="ddlPresentacion">
                                    <option value="0">NO SE HAN CONFIGURADO PRESENTACIONES</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="ddlUnidadMedida"><?php $translate->__('Unidad de medida'); ?></label>
                            <div class="input-control select">
                                <select id="ddlUnidadMedida" name="ddlUnidadMedida">
                                <?php 
                                if ($countRowUM > 0):
                                    for ($counterUM=0; $counterUM < $countRowUM; $counterUM++):
                                ?>
                                <option data-simbolo="<?php echo $rowUM[$counterUM]['tm_abreviatura']; ?>" value="<?php echo $rowUM[$counterUM]['tm_idunidadmedida']; ?>"><?php echo $rowUM[$counterUM]['tm_nombre'].' ('.$rowUM[$counterUM]['tm_abreviatura'].')'; ?></option>
                                <?php
                                    endfor;
                                endif;
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label for="txtCantidad"><?php $translate->__('Cantidad'); ?></label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtCantidad" name="txtCantidad" type="text" class="text-right only-numbers" placeholder="1.000" />
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <label for="txtPrecioRef"><?php $translate->__('Precio'); ?></label>
                            <div class="input-control text" data-role="input-control">
                                <input id="txtPrecioRef" name="txtPrecioRef" type="text" class="text-right only-numbers" placeholder="0.00" />
                                <button class="btn-clear" tabindex="-1" type="button"></button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnProductoAdd" type="button" class="command-button success">Agregar a compra</button>
        </div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script src="scripts/app/process/kardex-script.php?lang=<?php echo $lang; ?>"></script>
