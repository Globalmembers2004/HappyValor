<?php
require 'bussiness/ambientes.php';

$objAmbiente = new clsAmbiente();

$rowAmbiente = $objAmbiente->Listar('GroupAmbiente', $IdEmpresa, $IdCentro);
$countRowAmbiente = count($rowAmbiente);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdTipoSeleccion" name="hdTipoSeleccion" value="00" />
    <input type="hidden" id="hdTipoMenuDia" name="hdTipoMenuDia" value="03" />
    <input type="hidden" id="hdTipoSave" name="hdTipoSave" value="00" />
    <input type="hidden" id="hdIdVenta" name="hdIdVenta" value="0" />
    <input type="hidden" id="hdIdAmbiente" name="hdIdAmbiente" value="0" />
    <input type="hidden" id="hdIdAtencion" name="hdIdAtencion" value="0" />
    <input type="hidden" id="hdIdMesa" name="hdIdMesa" value="0" />
    <input type="hidden" id="hdTipoMesa" name="hdTipoMesa" value="0" />
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
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <?php
        if ($screenmode == 'cliente') {
            $mostrar_from_cliente = ' style="display: block;"';
            $ocultar_from_cliente = ' style="display: none;"';
        }
        else {
            $mostrar_from_cliente = ' style="display: none;"';
            $ocultar_from_cliente = ' style="display: block;"';
        }
        ?>
        <div id="pnlLocal" class="generic-panel page gp-no-footer"<?php echo $mostrar_from_cliente; ?>>
            <div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Locales</span>
                        <div class="mdl-layout-spacer"></div>
                    </div>
                </header>
            </div>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <div class="gp-body">
                <div id="pnlBusquedaArticulos" class="generic-panel gp-no-footer">
                    <div class="gp-header">
                        <div class="input-group padding10">
                            <span class="input-group-btn">
                                <button id="btnActualizar" class="btn btn-default" type="button"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
                            </span>
                            <input id="txtDireccion"  name="txtDireccion" type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button id="btnBuscarDireccion" class="btn btn-default" type="button">Buscar</button>
                            </span>
                        </div>
                    </div>
                    <div class="gp-body">
                        
                    </div>
                </div>
                <!-- <section id="gvCentros" class="gridview scrollbarra padding20" data-selected="none" data-multiselect="false">
                    <div class="list-group gridview-content">
                    </div>
                    <div class="empty_state centered text-center"><img src="images/logo_empty.png" class="margin20" alt="" /><p class="text-center blue-text">No se encontraron resultados</p><a href="#" id="btnActualizar" class="mdl-button white mdl-button--colored mdl-js-button waves-effect">Actualizar</a></div>
                </section> -->
            </div>
        </div>
        <div id="pnlMesas" class="generic-panel page gp-no-footer"<?php echo $ocultar_from_cliente; ?>>
            <div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Atenci&oacute;n</span>
                        <div class="mdl-layout-spacer"></div>
                        <input type="text" name="txtSearch" id="txtSearch" class="oculto" value="">
                        
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped hide" data-placement="left" data-toggle="tooltip" title="Pedido directo" id="btnPedidoDirecto">
                            <i class="material-icons">&#xE52E;</i>
                        </button>

                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped hide" data-placement="left" data-toggle="tooltip" title="Delivery" id="btnDelivery">
                            <i class="material-icons">&#xE558;</i>
                        </button>

                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide" id="btnSearch" data-type="search">
                            <i class="material-icons">&#xE8B6;</i>
                        </button>

                        <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide" id="btnOpciones">
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
            <?php if ($screenmode == 'cliente'): ?>
            <div id="btnBackToLocal" class="mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    
                </a>
            </div>
            <?php else: ?>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <?php endif; ?>
            <div class="gp-body">
                <div id="carousel-example-generic" class="carousel slide all-height">
                    <div class="carousel-inner all-height" role="listbox"></div>
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>
            </div>
        </div>
		<div id="pnlOrden" class="page generic-panel gp-no-footer hide">
			<div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Toma de orden</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide tooltipped" data-placement="left" data-toggle="tooltip" title="Agregar art&iacute;culos seleccionados" id="btnAddArticles">
                            <i class="material-icons">&#xE146;</i>
                        </button>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect hidden-lg -sm-block mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Ver ordenes" id="btnChangeViewOrder" data-currentview="articles">
                            <i class="material-icons i__orders">&#xE417;</i>
                            <i class="material-icons i__articles" style="opacity: 0;">&#xE060;</i>
                        </button>
                        <?php if ($screenmode != 'cliente'): ?>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide tooltipped" data-placement="left" data-toggle="tooltip" title="Cobrar orden" id="btnPayOrder">
                            <i class="material-icons">&#xE227;</i>
                        </button>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide tooltipped" data-placement="left" data-toggle="tooltip" title="Eliminar orden" id="btnRemoveOrder">
                            <i class="material-icons">&#xE872;</i>
                        </button>
                        <?php endif ?>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide tooltipped" data-placement="left" data-toggle="tooltip" title="Confirmar orden" id="btnConfirmOrder">
                            <i class="material-icons">&#xE22B;</i>
                        </button>
                    </div>
                </header>
            </div>
            <div id="btnBackToRooms" class="mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <div class="gp-body no-overflow">
            	<div id="pnlOrdenArticulos" class="mdl-grid all-height no-overflow">
            		<div class="articulos mdl-cell mdl-cell--6-col mdl-cell-6-col-tablet mdl-cell--12-col-phone">
                        <div id="pnlViewAllArticles" class="generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header mdl-shadow--2dp">
                			<header class="gp-header mdl-layout__header white">
                                <div class="mdl-layout__header-row padding-left70">
                                    <div id="barSearchArticulos" class="pos-rel full-size m-search hide">
                                        <input type="text" name="txtBuscarArticulos" id="txtBuscarArticulos" data-input="search" placeholder="Ingrese un criterio de b&uacute;squeda" class="no-margin black-text padding-right20" value="" autocomplete="off">
                                        <button type="button" class="helper-button margin10 black-text height-centered place-right mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php if ($screenmode != 'cliente'): ?>
                                    <span id="titleArticulos" class="mdl-layout-title row no-margin grey-text text-darken-1">
                                    Articulos
                                    </span>
                                    <?php endif ?>
                                    <div class="mdl-layout-spacer"></div>
                                    <button data-action="view-menu" data-tipomenudia="03" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon active tooltipped" data-placement="left" data-toggle="tooltip" title="Men&uacute;">
                                        <i class="material-icons">&#xE896;</i>
                                    </button>
                                    <button data-action="view-card" data-tipomenudia="00" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Carta">
                                        <i class="material-icons">&#xE561;</i>
                                    </button>
                                    <button data-action="view-single" data-tipomenudia="01" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Individuales">
                                        <i class="material-icons">&#xE552;</i>
                                    </button>
                                </div>
                            </header>
                            <div class="mdl-layout__drawer-button">
                                <button id="btnBuscarArticulo" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped blue-text" data-placement="right" data-toggle="tooltip" title="Buscar articulos">
                                    <i class="material-icons">&#xE8B6;</i>
                                </button>
                                <button id="btnHideSearchBarArticles" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped blue-text" data-placement="right" data-toggle="tooltip" title="Ocutlar b&uacute;squeda">
                                    <i class="material-icons">&#xE5C4;</i>
                                </button>
                            </div>
                			<main class="gp-body no-overflow pos-rel">
                                <div id="gvArticuloPack" class="generic-panel" data-selected="none" data-multiselect="false">
                                </div>
                                <div id="gvArticuloMenu" class="pos-rel all-height hide" data-selected="none" data-multiselect="false">
                                    <div class="table-responsive-vertical shadow-z-1 all-height">
                                        <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th><?php $translate->__('Articulo'); ?></th>
                                                    <th><?php $translate->__('Cantidad'); ?></th>
                                                    <th><?php $translate->__('Precio'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                			</main>
                		</div>
                    </div>
            		<div class="ordenes mdl-cell mdl-cell--6-col mdl-cell-6-col-tablet mdl-cell--12-col-phone">
                        <div id="pnlOrdenesDetalle" class="generic-panel mdl-layout mdl-layout--fixed-header mdl-shadow--2dp">
                			<header class="gp-header mdl-layout__header white">
                                <div class="mdl-layout__header-row">
                                    <span class="mdl-layout-title row no-margin grey-text text-darken-1">Detalle de orden</span>
                                    <div class="mdl-layout-spacer"></div>
                                </div>
                			</header>
                			<main class="gp-body">
                                <div id="gvOrdenes" class="all-height" data-selected="none" data-multiselect="false">
                                    <div class="table-responsive-vertical shadow-z-1 all-height">
                                        <table class="table table-bordered table-hover mdl-shadow--2dp all-height no-margin">
                                            <thead>
                                                <tr>
                                                    <th><?php $translate->__('Articulo'); ?></th>
                                                    <th><?php $translate->__('Cantidad'); ?></th>
                                                    <th><?php $translate->__('Precio'); ?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                			</main>
                            <footer class="gp-footer white" style="border-top: 1px #ccc solid;">
                                 <div class="row no-margin">
                                    <div class="col-md-12 text-center">
                                        <h5>Total de orden</h5>
                                    </div>
                                </div>
                                <div class="row no-margin">
                                    <div class="col-md-12 text-right">
                                        <h4 id="lblTotalFromOrder"><span class="moneda">S/.</span> <span class="monto">0.00</span></h4>
                                    </div>
                                </div>
                            </footer>
                        </div>
            		</div>
            	</div>
            </div>
		</div>
	</div>
    <div id="mesas-actionbar" class="actionbar fixed-top mdl-layout no-overflow">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <div class="mdl-layout-spacer"></div>
                <button id="btnLiberarMesas" type="button" data-action="liberar" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Liberar mesas">
                    <i class="material-icons">&#xE166;</i>
                </button>
                <button id="btnAgruparMesas" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Agrupar mesas">
                    <i class="material-icons">&#xE886;</i>
                </button>
                <button id="btnReservarMesas" type="button" data-action="reserva" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Reservar mesas">
                    <i class="material-icons">&#xE878;</i>
                </button>
            </div>
        </header>
        <div class="mdl-layout__drawer-button">
            <a id="btnMesasBack" class="back-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </div>
    </div>
    <div id="grupos-actionbar" class="actionbar fixed-top mdl-layout no-overflow">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <div class="mdl-layout-spacer"></div>
                <button id="btnSepararMesas" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Separar mesas">
                    <i class="material-icons">&#xE3AD;</i>
                </button>
            </div>
        </header>
        <div class="mdl-layout__drawer-button">
            <a id="btnMesasGroupBack" class="back-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </div>
    </div>
</form>