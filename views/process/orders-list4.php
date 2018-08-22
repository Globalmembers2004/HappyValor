<?php
include('bussiness/tabla.php');
include('bussiness/tipocomprobante.php');
include('bussiness/documentos.php');
include('bussiness/formapago.php');
include('bussiness/impuestos.php');
include('bussiness/tarjeta.php');
include('bussiness/monedas.php');
include('bussiness/ambientes.php');

$IdEmpresa = 1;
$IdCentro = 1;

$counterTarjeta = 0;
$counterMoneda = 0;
$counterTipoComprobante = 0;
$counterAmbiente = 0;
$counterEstadoMesa = 0;
$counterTipoCobro = 0;

$objTabla = new clsTabla();
$objTipoComprobante = new clsTipoComprobante();
$objDocIdentidad = new clsDocumentos();
$objFormaPago = new clsFormaPago();
$objImpuesto = new clsImpuesto();
$objTarjeta = new clsTarjetaPago();
$objMoneda = new clsMoneda();
$objAmbiente = new clsAmbiente();

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
$rowAmbiente = $objAmbiente->Listar('GroupAmbiente', $IdEmpresa, $IdCentro);
$countRowAmbiente = count($rowAmbiente);
$rsEstadomesa = $objTabla->Listar('BY-FIELD', 'ta_estadoatencion');
$countEstadoMesa = count($rsEstadomesa);
$rsTipoCobro = $objTabla->Listar('BY-FIELD', 'ta_tipocobro');
$countTipoCobro = count($rsTipoCobro);
?>
<form id="form1" name="form1" method="post" action="services/atencion/atencion-post.php">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="lang" name="lang" value="<?php echo $lang; ?>" />
    <input type="hidden" id="hdTipoSeleccion" name="hdTipoSeleccion" value="00" />
    <input type="hidden" id="hdTipoSave" name="hdTipoSave" value="00" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
    <input type="hidden" id="hdIdVenta" name="hdIdVenta" value="0" />
    <input type="hidden" id="hdIdAmbiente" name="hdIdAmbiente" value="0" />
    <input type="hidden" id="hdIdMesa" name="hdIdMesa" value="0" />
    <input type="hidden" id="hdIdMoneda" name="hdIdMoneda" value="0" />
    <input type="hidden" id="hdIdPersonal" name="hdIdPersonal" value="0" />
    <input type="hidden" id="hdIdPerfil" name="hdIdPerfil" value="<?php echo $idperfil; ?>" />
    <input type="hidden" id="hdTotalPedido" name="hdTotalPedido" value="0" />
    <input type="hidden" id="hdIdGrupo" name="hdIdGrupo" value="0" />
    <input type="hidden" id="hdIdOrden" name="hdIdOrden" value="0" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdPageCli" name="hdPageCli" value="1" />
    <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="0" />
    <input type="hidden" id="hdIdSubCategoria" name="hdIdSubCategoria" value="0" />
    <input type="hidden" id="hdEstadoMesa" name="hdEstadoMesa" value="00" />
    <input type="hidden" id="hdTipoAgrupacion" name="hdTipoAgrupacion" value="00" />
    <input type="hidden" id="hdVista" name="hdVista" value="MESAS" />
    <div class="page-region">
        <div id="pnlMesas" class="generic-panel gp-no-footer">
            <div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Atenci&oacute;n</span>
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
            </div>
            <ul id="mnuOpciones" class="dropdown" tabindex="-1">
                <li id="btnSelectAll"><a href="#" data-action="select-all" class="waves-effect">Seleccionar todo</a></li>
                <li id="btnLimpiarSeleccion"><a href="#" data-action="unselect-all" class="waves-effect">Quitar selecci&oacute;n</a></li>
                <li class="divider"></li>
                <li><a href="#" data-action="close" class="close-inner-window">Cerrar</a></li>
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <div class="gp-body">
                <div id="sliderAmbientes" class="slider">
                    <a href="#" class="control_next circle mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon "><i class="material-icons">&#xE315;</i></a>
                    <a href="#" class="control_prev circle mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE314;</i></a>
                    <ul>
                        <?php
                        if ($countRowAmbiente > 0):
                            for ($counterAmbiente=0; $counterAmbiente < $countRowAmbiente; $counterAmbiente++):
                        ?>
                        <li data-idcontainer="<?php echo $rowAmbiente[$counterAmbiente]['tm_idambiente']; ?>">
                            <div class="generic-panel gp-no-footer">
                                <div class="gp-header">
                                    <h2 class="align-center"><?php echo $rowAmbiente[$counterAmbiente]['tm_nombre']; ?></h2>
                                </div>
                                <div class="gp-body">
                                    <div class="mesas scrollbarra" data-selected="none" data-multiselect="false" data-actionbar="mesas-actionbar">
                                        <div class="gridview mdl-grid"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                            endfor;
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
            <div id="mesas-actionbar" class="actionbar fixed-top bg-darkTeal">
                <div class="actionbar-container">
                    <div class="actionbar-wrapper">
                        <div class="mdl-grid no-padding">
                            <div class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone no-margin">
                                <div class="back-button">
                                    <h3 class="back-icon left">
                                        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon white-text">
                                            <i class="material-icons">&#xE5C4;</i>
                                        </a>
                                    </h3>
                                    <h3 class="text left hide-on-small-only padding5 white-text">
                                        Atr&aacute;s
                                    </h3>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--10-col mdl-cell--3-col-phone no-margin">
                                <div class="actionbar-actions">
                                    <div class="actionbar-edit">
                                        <div data-action="more" class="btnOpciones actionbar-button right tooltipped" id="btnMore">
                                            <h3 class="white-text">
                                                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right">
                                                    <i class="material-icons">&#xE5D4;</i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mdl-tooltip mdl-tooltip--large" for="btnMore">M&aacute;s</div>
                                        <div data-action="join" class="actionbar-button right tooltipped" id="btnUnirMesas">
                                            <h3 class="white-text">
                                                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right">
                                                    <i class="material-icons">&#xE0B3;</i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mdl-tooltip mdl-tooltip--large" for="btnUnirMesas">Unir mesas</div>
                                        <div data-action="split" class="actionbar-button oculto right tooltipped" id="btnSepararMesas">
                                            <h3 class="white-text">
                                                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right">
                                                    <i class="material-icons">&#xE0B6;</i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mdl-tooltip mdl-tooltip--large" for="btnSepararMesas">Separar mesas</div>
                                        <div data-action="view-order" class="actionbar-button right tooltipped" id="btnViewOrder">
                                            <h3 class="white-text">
                                                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right">
                                                    <i class="material-icons">&#xE8B0;</i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mdl-tooltip mdl-tooltip--large" for="btnViewOrder">Ver pedido</div>
                                        <div data-action="search-articles" class="actionbar-button right tooltipped" id="btnBuscarArticulos">
                                            <h3 class="white-text">
                                                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right">
                                                    <i class="material-icons">&#xE060;</i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mdl-tooltip mdl-tooltip--large" for="btnBuscarArticulos">Buscar articulos</div>
                                        <div data-action="reserve" class="actionbar-button right tooltipped" id="btnReserva">
                                            <h3 class="white-text">
                                                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon right">
                                                    <i class="material-icons">&#xE24F;</i>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mdl-tooltip mdl-tooltip--large" for="btnReserva">Reservar</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="pnlProductos" class="mdl-layout mdl-js-layout
                    mdl-layout--fixed-tabs" style="display:none;">
          <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
              <!-- Title -->
              <span class="mdl-layout-title">Art&iacute;culos</span>
            </div>

            <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
              <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Packs</a>
              <a href="#fixed-tab-2" class="mdl-layout__tab">Individuales</a>
            </div>
          </header>
          <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
          <main class="mdl-layout__content">
            <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
              <div class="page-content">
                  <div id="pnlPacks" class="grid fluid">
                    <div class="row">
                        <div class="span3">
                            <div id="gvGrupos">
                                <div class="tile-area gridview scrollbarra"></div>
                            </div>
                        </div>
                        <div class="span9">
                            <ul id="gvSecciones"></ul>
                        </div>
                    </div>
                </div>
              </div>
            </section>
            <section class="mdl-layout__tab-panel" id="fixed-tab-2">
                <div class="page-content">
                    <div id="precargaProd" class="divload">
                        <div id="gvCartaProd">
                            <div class="gridview scrollbarra"></div>
                        </div>
                        <div id="gvMenuProd" style="display: block;">
                            <div class="gridview scrollbarra"></div>
                        </div>
                    </div>
                </div>
            </section>
          </main>
        </div>
        <!-- <div id="pnlProductos" class="sectionInception" style="display:none;">
            <div class="sectionHeader">
                <h1 class="title-window">
                    <a id="btnBackTables" href="#" title="Regresar a atenci&oacute;n" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i>
                    </a>
                    Articulos
                    <button class="large no-margin success" type="button" data-tipomenu="03" data-target="#tab1"><?php $translate->__('Packs'); ?></button>
                    <button class="large no-margin" type="button" data-tipomenu="00" data-target="#tab2"><?php $translate->__('Carta'); ?></button>
                    <button class="large no-margin" type="button" data-tipomenu="01" data-target="#tab3"><?php $translate->__('Individuales'); ?></button>
                </h1>
            </div>
            <div class="sectionContent">
                <section id="pnlGrupos">
                    <div id="pnlPacks" class="grid fluid">
                        <div class="row">
                            <div class="span3">
                                <div id="gvGrupos">
                                    <div class="tile-area gridview scrollbarra"></div>
                                </div>
                            </div>
                            <div class="span9">
                                <ul id="gvSecciones"></ul>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="pnlIndividual" class="inner-page with-panel-search" style="display:none;">
                    <div class="panel-search">
                        <div class="input-control text" data-role="input-control">
                            <input type="text" id="txtSearch" name="txtSearch" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                            <button id="btnSearchProducts" type="button" class="btn-search" tabindex="-1"></button>
                        </div>
                    </div>
                    <div id="precargaProd" class="divload">
                        <div id="gvCartaProd">
                            <div class="tile-area gridview scrollbarra"></div>
                        </div>
                        <div id="gvMenuProd">
                            <div class="tile-area gridview scrollbarra"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div> -->
        <div id="pnlOrden" class="inner-page" style="display:none;">
            <h1 class="title-window">
                <a id="btnBackProducts" href="#" title="Regresar a" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                <?php $translate->__('Detalle'); ?>
            </h1>
            <div class="divContent">
                <div class="moduloTwoPanel">
                    <div class="colTwoPanel1 column-panel">
                        <div id="pnlDetallePedido" class="generic-panel gp-no-header">
                            <div class="gp-body">
                                <div id="tableDetalle" class="itables">
                                    <div class="ihead">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th><?php $translate->__('Art&iacute;culos'); ?></th>
                                                    <th><?php $translate->__('Precio'); ?></th>
                                                    <th><?php $translate->__('Cantidad'); ?></th>
                                                    <th><?php $translate->__('Importe'); ?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="ibody contentPedido">
                                        <div class="ibody-content">
                                            <table style="font-size: 12pt;">
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gp-footer">
                                <div class="totalbar">
                                    <div class="currency">
                                        <div class="slide-currency">
                                            <?php
                                            if ($countRowMoneda > 0):
                                                for ($counterMoneda=0; $counterMoneda < $countRowMoneda; ++$counterMoneda):
                                            ?>
                                            <div title="<?php echo $rowMoneda[$counterMoneda]['tm_nombre']; ?>" rel="<?php echo $rowMoneda[$counterMoneda]['tm_idmoneda']; ?>" class="simbol-currency">
                                                <h1><?php echo $rowMoneda[$counterMoneda]['tm_simbolo']; ?></h1>
                                            </div>
                                            <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </div>
                                        <div class="buttons oculto">
                                            <button type="button" class="upCurrency" disabled=""><i class="icon-arrow-up-4"></i></button>
                                            <button type="button" class="downCurrency"><i class="icon-arrow-down-4"></i></button>
                                        </div>
                                    </div>
                                    <div class="mount">
                                        <h1 id="totalDetails">0.00</h1>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="colTwoPanel2 column-panel">
                        <div id="pnlCuentas" class="generic-panel gp-no-header">
                            <div class="gp-body">
                                <div id="sliderCuentas" class="slider">
                                    <button id="btnTodoUnaCuenta">Todo a esta cuenta</button>
                                    <a href="#" class="control_next"><i class="icon-arrow-right-3"></i></a>
                                    <a href="#" class="control_prev disabled"><i class="icon-arrow-left-3"></i></a>
                                    <ul>
                                        <li data-idcontainer="1">
                                            <h3 class="slider-header"><?php $translate->__('Cuenta 1'); ?></h3>
                                            <div class="slider-content">
                                                <div class="slider-content-scroll"></div>
                                            </div>
                                        </li>
                                        <li data-idcontainer="2">
                                            <h3 class="slider-header"><?php $translate->__('Cuenta 2'); ?></h3>
                                            <div class="slider-content">
                                                <div class="slider-content-scroll"></div>
                                            </div>
                                        </li>
                                        <li data-idcontainer="3">
                                            <h3 class="slider-header"><?php $translate->__('Cuenta 3'); ?></h3>
                                            <div class="slider-content">
                                                <div class="slider-content-scroll"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <a id="btnCobrarPedido" href="#" class="circle-button">
                                    <i class="icon-dollar"></i>
                                </a>
                            </div>
                            <div class="gp-footer">
                                <h3 class="no-margin"><?php $translate->__('Importe de cuenta'); ?></h3>
                                <div class="pnlImporte">
                                    <h1 id="lblMonedaCuenta" class="simbolo text-center fg-darkCobalt">S/.</h1>
                                    <h1 id="lblImporteCuenta" class="importe text-right fg-emerald">0.00</h1>
                                </div>
                            </div>
                        </div>
                        <div id="pnlBloqueoCuentas" class="panel-bloqueo">
                            <div class="pb-body">
                                <div class="pb-mensaje">
                                    <h2 class="white-text">M&oacute;dulo no disponible</h2>
                                    <p class="white-text">Para acceder a este m&oacute;dulo, realice la apertura de caja en el m&oacute;dulo de caja</p>
                                    <button id="btnAperturarCaja" class="default large margin5" data-url="?pag=procesos&subpag=caja&op=list">Aperturar caja</button>
                                    <div class="clear"></div>
                                    <button id="btnComprobarCaja" class="success large margin5">Volver a comprobar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="pnlClientes" class="top-panel inner-page with-title-window with-panel-search with-appbar" style="display:none;">
            <h1 class="title-window">
                <a href="#" id="btnExitCustomer" class="back-button"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                <?php $translate->__('Clientes'); ?>
            </h1>
            <div class="panel-search">
                <div class="input-control text" data-role="input-control">
                    <input type="text" id="txtSearchCliente" name="txtSearchCliente" placeholder="<?php $translate->__('Ingrese criterios de b&uacute;squeda'); ?>">
                    <button id="btnSearchCliente" type="button" class="btn-search" tabindex="-1"></button>
                </div>
            </div>
            <div id="precargaCli" class="divload">
                <div id="gvClientes" style="display:none;">
                    <div class="items-area listview gridview"></div>
                </div>
                <div id="frmClientes" class="form-insearch" style="display:none;">
                    <div id="tabClientes" class="special-tab">
                        <ul class="menu">
                            <?php
                            for ($counterDocIdentidad=0; $counterDocIdentidad < $countRowDocIdentidad; $counterDocIdentidad++):
                            ?>
                            <li data-iddocident="<?php echo $rowDocIdentidad[$counterDocIdentidad]['tm_iddocident']; ?>">
                                <a href="#tab<?php $translate->__($rowDocIdentidad[$counterDocIdentidad]['tm_descripcion']); ?>">
                                    <?php $translate->__($rowDocIdentidad[$counterDocIdentidad]['tm_descripcion']); ?>
                                </a>
                            </li>
                            <?php
                            endfor;
                            ?>
                        </ul>
                        <div class="content">
                            <div id="tabDNI" class="panels">
                                <div class="grid">
                                    <div class="row">
                                        <label for="txtNombres">Nombres</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtNombres" name="txtNombres" type="text" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtApePaterno"><?php $translate->__('Apellido paterno'); ?></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtApePaterno" name="txtApePaterno" type="text" placeholder="Ejemplo: Qui&ntilde;onez">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtApeMaterno"><?php $translate->__('Apellido materno'); ?></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtApeMaterno" name="txtApeMaterno" type="text" placeholder="<?php $translate->__('Ejemplo:Gonzales'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtNroDocNatural">Documento de identidad</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtNroDocNatural" name="txtNroDocNatural" type="text" placeholder="<?php $translate->__('Ejemplo: 45035046'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtDireccionNat">Direcci&oacute;n</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtDireccionNat" name="txtDireccionNat" type="text" placeholder="<?php $translate->__('Ejemplo: Av. Jorge Chavez 484 Urb. Campodonico'); ?>">
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tabRUC" class="panels">
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
                    </div>
                </div>
            </div>
            <div class="appbar">
                <button id="btnDelCliente" name="btnDelCliente" type="button" title="<?php $translate->__('Eliminar'); ?>" class="cancel metro_button oculto float-right">
                    <span class="content">
                        <img src="images/trash.png" alt="<?php $translate->__('Eliminar'); ?>" />
                        <span class="text"><?php $translate->__('Eliminar'); ?></span>
                    </span>
                </button>
                <button id="btnEditCliente" type="button" title="<?php $translate->__('Editar'); ?>" class="metro_button oculto float-right">
                    <span class="content">
                        <img src="images/edit.png" alt="<?php $translate->__('Editar'); ?>" />
                        <span class="text"><?php $translate->__('Editar'); ?></span>
                    </span>
                </button>
                <button id="btnCancelCliente" type="button" title="<?php $translate->__('Cancelar'); ?>" class="metro_button oculto float-right">
                    <span class="content">
                        <img src="images/cancel.png" alt="<?php $translate->__('Cancelar'); ?>" />
                        <span class="text"><?php $translate->__('Cancelar'); ?></span>
                    </span>
                </button>
                <button id="btnSaveCliente" name="btnSaveCliente" type="button" title="<?php $translate->__('Guardar'); ?>" class="metro_button oculto float-right">
                    <span class="content">
                        <img src="images/save.png" alt="<?php $translate->__('Guardar'); ?>" />
                        <span class="text"><?php $translate->__('Guardar'); ?></span>
                    </span>
                </button>
                <button id="btnNewCliente" type="button" title="<?php $translate->__('Nuevo'); ?>" class="metro_button float-right">
                    <span class="content">
                        <img src="images/add.png" alt="<?php $translate->__('Nuevo'); ?>" />
                        <span class="text"><?php $translate->__('Nuevo'); ?></span>
                    </span>
                </button>
                <button id="btnCleanSelectCliente" type="button" class="metro_button oculto float-right">
                    <span class="content">
                        <img src="images/icon_uncheck.png" alt="<?php $translate->__('Limpiar selecci&oacute;n'); ?>" />
                        <span class="text"><?php $translate->__('Limpiar selecci&oacute;n'); ?></span>
                    </span>
                </button>
            </div>
        </div>
        <div id="pnlListVentas" class="outer-page" style="background-color: #eee; display:none;"></div>
    </div>
    <div id="pnlEstadoMesa" class="slide-options">
        <h2 class="white-text"><?php $translate->__('Leyenda de etapas'); ?></h2>
        <div class="slide-content">
            <div class="tile-area">
                <div class="tile bg-gray selected" data-codigo="*">
                    <div class="tile-content icon">
                        <span class="icon-cycle"></span>
                    </div>
                    <div class="tile-status bg-dark opacity">
                        <span class="label"><?php $translate->__('TODOS'); ?></span>
                    </div>
                </div>
                <?php
                if ($countEstadoMesa > 0):
                    for ($counterEstadoMesa=0; $counterEstadoMesa < $countEstadoMesa; $counterEstadoMesa++):
                ?>
                <div class="tile" data-codigo="<?php echo $rsEstadomesa[$counterEstadoMesa]['ta_codigo']; ?>" style="background-color: <?php echo $rsEstadomesa[$counterEstadoMesa]['ta_colorleyenda']; ?>">
                    <div class="tile-status bg-dark opacity">
                        <span class="label"><?php echo $rsEstadomesa[$counterEstadoMesa]['ta_denominacion'] ?></span>
                    </div>
                </div>
                <?php
                    endfor;
                endif;
                ?>
            </div>
        </div>
    </div>
    <!-- <div class="appbar">
        <button id="btnReserva" type="button" data-hint-position="top" data-hint="<?php $translate->__('Reservar'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-book"></i></h2>
        </button>
        <button id="btnUnirMesas" type="button" data-hint-position="top" data-hint="<?php $translate->__('Unir'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-link"></i></h2>
        </button>
        <button id="btnBuscarArticulos" type="button" data-hint-position="top" data-hint="<?php $translate->__('Buscar articulos'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-search"></i></h2>
        </button>
        <button id="btnGuardarCambios" type="button" data-hint-position="top" data-hint="<?php $translate->__('Guardar cambios'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-checkmark"></i></h2>
        </button>
        <button id="btnDividirCuenta" type="button" data-hint-position="top" data-hint="<?php $translate->__('Dividir cuenta'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-layers"></i></h2>
        </button>
        <button id="btnLiberarMesa" type="button" data-hint-position="top" data-hint="<?php $translate->__('Liberar'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-cycle"></i></h2>
        </button>
        <button id="btnViewOrder" type="button" data-hint-position="top" data-hint="<?php $translate->__('Ver pedido'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-list"></i></h2>
        </button>
        <button id="btnAddOrder" type="button" data-hint-position="top" data-hint="<?php $translate->__('Agregar a pedido'); ?>" class="metro_button oculto float-right">
            <h2><i class="icon-plus-2"></i></h2>
        </button>
        <button id="btnQuitarItem" type="button" data-hint-position="top" data-hint="<?php $translate->__('Quitar articulo'); ?>" class="metro_button oculto float-left">
            <h2><i class="icon-remove"></i></h2>
        </button>
        <button id="btnClearSelection" type="button" data-hint-position="top" data-hint="<?php $translate->__('Limpiar selecci&oacute;n'); ?>" class="metro_button oculto float-left">
            <h2><i class="icon-undo"></i></h2>
        </button>
        <button id="btnSepararMesas" type="button" data-hint-position="top" data-hint="<?php $translate->__('Separar'); ?>" class="metro_button oculto float-left">
            <h2><i class="icon-link-2"></i></h2>
        </button>
        <button id="btnAnularMesa" type="button" data-hint-position="top" data-hint="<?php $translate->__('Anular'); ?>" class="metro_button oculto float-left">
            <h2><i class="icon-blocked"></i></h2>
        </button>
        <button id="btnLeyendaMesas" type="button" data-hint-position="top" data-hint="<?php $translate->__('Leyenda de etapas'); ?>" class="metro_button float-left">
            <h2><i class="icon-flag"></i></h2>
        </button>
    </div> -->
    <div id="pnlDivision" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Dividir cuentas
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtNroCuentas"><?php $translate->__('N&uacute;mero de cuentas'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNroCuentas" name="txtNroCuentas" type="text" class="text-right only-numbers" placeholder="2" value="2" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnDividir" type="button" class="command-button success">Dividir</button>
        </div>
    </div>
    <div id="pnlVenta" class="modal-dialog modal-example-content">
        <input type="hidden" id="hdIdCliente" name="hdIdCliente" value="0" />
        <input type="hidden" id="hdIdDocIdent" name="hdIdDocIdent" value="0" />
        <input type="hidden" id="hdCodigoCliente" name="hdCodigoCliente" value="" />
        <input type="hidden" id="hdIdMonedaVenta" name="hdIdMonedaVenta" value="0" />
        <input type="hidden" id="hdImpuesto" name="hdImpuesto" value="0" />
        <input type="hidden" id="hdTotalSinImpuesto" name="hdTotalSinImpuesto" value="0" />
        <input type="hidden" id="hdTotalConImpuesto" name="hdTotalConImpuesto" value="0" />
        <div class="modal-example-header">
            <h2 class="no-margin">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Venta
            </h2>
        </div>
        <div class="modal-example-body">
            <div id="pnlContentVenta">
                <div class="modal-example-header">
                    <div class="grid fluid divVenta">
                        <div class="row">
                            <div class="span6">
                                <label for="ddlTipoComprobante"><?php $translate->__('Tipo de comprobante'); ?></label>
                                <div class="input-control select fa-caret-down">
                                    <select name="ddlTipoComprobante" id="ddlTipoComprobante">
                                        <?php 
                                        if ($countRowTipoComprobante > 0):
                                            for ($counterTipoComprobante=0; $counterTipoComprobante < $countRowTipoComprobante; $counterTipoComprobante++):
                                        ?>
                                        <option data-codigosunat="<?php echo $rowTipoComprobante[$counterTipoComprobante]['CodigoSunat']; ?>" value="<?php echo $rowTipoComprobante[$counterTipoComprobante]['tm_idtipocomprobante']; ?>"><?php echo $rowTipoComprobante[$counterTipoComprobante]['tm_nombre']; ?></option>
                                        <?php
                                            endfor;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="span6">
                                <label for="txtSerieComprobante"><?php $translate->__('N° de comprobante'); ?></label>
                                <div class="span6" style="margin-left: 0;">
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtSerieComprobante" name="txtSerieComprobante" type="text" placeholder="type text" value="001" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="input-control text" data-role="input-control">
                                        <input id="txtNroComprobante" name="txtNroComprobante" type="text" placeholder="type text" value="00001" />
                                        <button class="btn-clear" tabindex="-1" type="button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span6">
                                <label for="txtFechaVenta"><?php $translate->__('Fecha de venta'); ?></label>
                                <div class="input-control text" data-role="input-control">
                                    <input id="txtFechaVenta" name="txtFechaVenta" type="text" />
                                    <button class="btn-clear" tabindex="-1" type="button"></button>
                                </div>
                            </div>
                            <div class="span6">
                                <label for="ddlTipoCobro"><?php $translate->__('Tipo de pago'); ?></label>
                                <div class="input-control select fa-caret-down">
                                    <select name="ddlTipoCobro" id="ddlTipoCobro">
                                        <?php 
                                        if ($countTipoCobro > 0):
                                            for ($counterTipoCobro=0; $counterTipoCobro < $countTipoCobro; $counterTipoCobro++):
                                        ?>
                                        <option value="<?php echo $rsTipoCobro[$counterTipoCobro]['ta_codigo']; ?>"><?php echo $rsTipoCobro[$counterTipoCobro]['ta_denominacion']; ?></option>
                                        <?php
                                            endfor;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="row">
                            <div id="pnlInfoCliente" data-idcliente="0" class="panel-info">
                                <div id="noticeCliente" class="notice bg-darkRed white-text marker-on-bottom">
                                    En ventas con pago a cuenta, los datos del cliente deben ingresarse.
                                </div>
                                <div class="foto"></div>
                                <div class="info">
                                    <h3 class="descripcion">CLIENTE GENERICO</h3>
                                    <div class="grid fluid">
                                        <div class="span4 detalle docidentidad">000</div>
                                        <div class="span8 detalle direccion">Direcci&oacute;n no especificada</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-example-body">
                    <div id="pnlFormaPago" class="special-tab">
                        <ul class="menu">
                            <?php
                            if ($countRowFormaPago > 0):
                                for ($counterFormaPago=0; $counterFormaPago < $countRowFormaPago; $counterFormaPago++):
                            ?>
                            <li>
                                <a data-idformapago="<?php echo $rowFormaPago[$counterFormaPago]['tm_idformapago']; ?>" href="#tab<?php echo $rowFormaPago[$counterFormaPago]['CodigoSunat']; ?>">
                                    <?php $translate->__($rowFormaPago[$counterFormaPago]['tm_nombre']); ?>
                                </a>
                            </li>
                            <?php
                                endfor;
                            endif;
                             ?>
                        </ul>
                        <div class="content">
                            <div id="tab009" class="paneltab">
                                <div class="grid">
                                    <div class="row">
                                        <label for="ddlMoneda"><?php $translate->__('Moneda'); ?></label>
                                        <div class="input-control select fa-caret-down">
                                            <select name="ddlMoneda" id="ddlMoneda">
                                                <?php
                                                if ($countRowMoneda > 0):
                                                    for ($counterMoneda=0; $counterMoneda < $countRowMoneda; ++$counterMoneda):
                                                ?>
                                                <option data-simbolo="<?php echo $rowMoneda[$counterMoneda]['tm_simbolo']; ?>" data-tipocambio="<?php echo $rowMoneda[$counterMoneda]['td_importe']; ?>" value="<?php echo $rowMoneda[$counterMoneda]['tm_idmoneda']; ?>">
                                                    <?php echo $rowMoneda[$counterMoneda]['tm_nombre'].' ('.$rowMoneda[$counterMoneda]['tm_simbolo'].')'; ?>
                                                </option>
                                                <?php
                                                    endfor;
                                                endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtImporteRecibido"><?php $translate->__('Importe recibido'); ?></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtImporteRecibido" name="txtImporteRecibido" type="text" class="text-right only-numbers" placeholder="0.00" />
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="txtImporteCambio"><?php $translate->__('Cambio o vuelto'); ?></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input id="txtImporteCambio" name="txtImporteCambio" type="text" readonly="" class="text-right only-numbers" placeholder="0.00" value="" />
                                            <button class="btn-clear" tabindex="-1" type="button"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab005" class="paneltab">
                                <div class="grid fluid">
                                    <div class="row">
                                        <div class="span6">
                                            <label for="ddlMonedaTarjeta"><?php $translate->__('Moneda'); ?></label>
                                            <div class="input-control select fa-caret-down">
                                                <select name="ddlMonedaTarjeta" id="ddlMonedaTarjeta">
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
                                            <label for="txtTipoCambioEfectivo"><?php $translate->__('Tipo de cambio'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtTipoCambioEfectivo" name="txtTipoCambioEfectivo" type="text" class="text-right only-numbers" placeholder="0.00" />
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span6">
                                            <label for="ddlNombreTarjeta"><?php $translate->__('Tarjeta'); ?></label>
                                            <div class="input-control select fa-caret-down">
                                                <select name="ddlNombreTarjeta" id="ddlNombreTarjeta">
                                                    <?php
                                                    if ($countRowTarjeta > 0):
                                                        for ($counterTarjeta=0; $counterTarjeta < $countRowTarjeta; ++$counterTarjeta):
                                                    ?>
                                                    <option data-comision="<?php echo $rowTarjeta[$counterTarjeta]['td_importe']; ?>" value="<?php echo $rowTarjeta[$counterTarjeta]['tm_idtarjetapago']; ?>">
                                                        <?php echo $rowTarjeta[$counterTarjeta]['tm_nombre']; ?>
                                                    </option>
                                                    <?php
                                                        endfor;
                                                    endif;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <label for="txtComisionTarjeta"><?php $translate->__('Comisi&oacute;n'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtComisionTarjeta" name="txtComisionTarjeta" type="text" class="text-right only-numbers" placeholder="0.00" value="" />
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span6">
                                            <label for="txtCodigoRecibo"><?php $translate->__('C&oacute;digo de recibo (voucher)'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtCodigoRecibo" name="txtCodigoRecibo" type="text" class="text-right only-numbers" placeholder="00000000" value="" />
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <label for="txtImporteTarjeta"><?php $translate->__('Importe Tarjeta'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtImporteTarjeta" name="txtImporteTarjeta" type="text" class="text-right only-numbers" placeholder="0.00" value="" />
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab999" class="panels" style="display:none;">
                                <div class="grid fluid">
                                    <div class="row">
                                        <div class="span6">
                                            <label for="ddlTipoDescuento"><?php $translate->__('Tipo de descuento'); ?></label>
                                            <div class="input-control select fa-caret-down">
                                                <select name="ddlTipoDescuento" id="ddlTipoDescuento">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div id="descuentoVale" class="span6">
                                            <label for="txtValeDescuento"><?php $translate->__('C&oacute;digo de vale'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtValeDescuento" name="txtValeDescuento" type="text" class="text-right only-numbers" placeholder="00000000" value="" />
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                        <div id="descuentoPromocion" class="span6 oculto">
                                            <label for="ddlPromocion"><?php $translate->__('Promociones'); ?></label>
                                            <div class="input-control select fa-caret-down">
                                                <select name="ddlPromocion" id="ddlPromocion">
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="span12">
                                            <label for="txtImporteDescuento"><?php $translate->__('Importe de descuento'); ?></label>
                                            <div class="input-control text" data-role="input-control">
                                                <input id="txtImporteDescuento" name="txtImporteDescuento" type="text" class="text-right only-numbers" placeholder="00000000" value="" />
                                                <button class="btn-clear" tabindex="-1" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-example-footer">
                    <div class="pnlDisplayImporte">
                        <div class="simbolo">
                            <h1 id="lblMonedaCobro" class="text-center fg-darkCobalt">S/.</h1>
                        </div>
                        <div class="total">
                            <h1 id="lblImporteCobro" class="importe text-right fg-emerald">0.00</h1>
                        </div>
                        <div class="info">
                            <a href="#" id="btnInfoImporte">
                                <i class="icon-info"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="pnlInfoImporte" class="pnlInfoImporte">
                    <h2>Detalle de importe</h2>
                    <div class="grid fluid">
                        <?php
                        if ($countRowFormaPago > 0):
                            for ($counterFormaPago=0; $counterFormaPago < $countRowFormaPago; $counterFormaPago++):
                        ?>
                        <div data-idformapago="<?php echo $rowFormaPago[$counterFormaPago]['tm_idformapago']; ?>" data-codigo="<?php echo $rowFormaPago[$counterFormaPago]['CodigoSunat']; ?>" class="row">
                            <div class="span6">
                                <h3 class="detalle_importe fg-darker"><?php $translate->__($rowFormaPago[$counterFormaPago]['tm_nombre']); ?></h3>
                            </div>
                            <div class="span6">
                                <h3 class="total formapago align-right fg-darkGreen">0.00</h3>
                            </div>
                        </div>
                        <?php
                            endfor;
                        endif;
                        ?>
                        <div data-codigo="comision" class="row">
                            <div class="span6">
                                <h3 class="detalle_importe fg-darker">COMISION TARJETA</h3>
                            </div>
                            <div class="span6">
                                <h3 class="total align-right fg-darkGreen">0.00</h3>
                            </div>
                        </div>
                        <div data-codigo="totalsinimp" class="row">
                            <div class="span6">
                                <h3 class="detalle_importe fg-darker">IMPORTE BASE</h3>
                            </div>
                            <div class="span6">
                                <h3 class="total align-right fg-darkGreen">0.00</h3>
                            </div>
                        </div>
                        <?php
                        if ($countRowImpuesto > 0):
                            for ($counterImpuesto=0; $counterImpuesto < $countRowImpuesto; $counterImpuesto++):
                        ?>
                        <div data-idimpuesto="<?php echo $rowImpuesto[$counterImpuesto]['tm_idimpuesto']; ?>" class="row">
                            <div class="span6">
                                <h3 class="detalle_importe fg-darker"><?php $translate->__($rowImpuesto[$counterImpuesto]['tm_nombre']); ?></h3>
                            </div>
                            <div class="span6">
                                <h3 data-valorimpuesto="<?php echo $rowImpuesto[$counterImpuesto]['td_valorimpuesto']; ?>" class="total impuesto align-right fg-darkGreen">0.00</h3>
                            </div>
                        </div>
                        <?php
                            endfor;
                        endif;
                        ?>
                        <div data-codigo="totalconimp" class="row">
                            <div class="span6">
                                <h3 class="detalle_importe fg-darker">IMPORTE C/ IMPUESTOS</h3>
                            </div>
                            <div class="span6">
                                <h3 class="total align-right fg-darkGreen">0.00</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span4">
                        <button id="btnGenerarVenta" type="button" class="command-button success">Facturar</button>
                    </div>
                    <div class="span4"> 
                        <button id="btnImprimirVenta" type="button" class="command-button warning">Imprimir</button>
                    </div>
                    <div class="span4">
                        <button id="btnBackAtencion" type="button" class="command-button default">Atenci&oacute;n</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlImpresion" class="panel_impresion">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="lblFechaImp"></span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="lblNroReciboImp"></span>
        <br />
        <br />
        <br />
        <table cellpadding="0" cellspacing="0" border="0">
            <tbody></tbody>
        </table>
        <br />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span id="lblTotalImp">0.00</span>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
?>
<script src="scripts/jquery.autogrow-textarea.js"></script>
<script src="scripts/app/process/orders-script.min.js"></script>