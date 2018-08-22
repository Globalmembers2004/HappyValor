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
                        <div id="barSearchLocales" class="full-size m-search white hide">
                            <input type="text" name="txtDireccion" id="txtDireccion" data-input="search" placeholder="Busca tu local, el m&aacute;s cercano ser&aacute;a el primero" class="no-margin black-text padding-right20" value="" autocomplete="off">
                            <button type="button" class="helper-button margin10 black-text height-centered place-right mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                            <div class="clearfix"></div>
                        </div>
                        <span class="mdl-layout-title">Ordenar pedido</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" data-view="mesas" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Actualizar ubicaci&oacute;n" id="btnActualizarUbicacion">
                            <i class="material-icons">&#xE55F;</i>
                        </button>
                        <button type="button" data-view="grupo" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Buscar" id="btnBuscarLocal">
                            <i class="material-icons">&#xE8B6;</i>
                        </button>
                    </div>
                </header>
            </div>
             <div class="mdl-layout__drawer-button">
                <a class="control-inner-app mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
                <a id="btnHideSearchBarLocales" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped black-text hide" data-placement="right" data-toggle="tooltip" title="Ocutlar b&uacute;squeda">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <div class="gp-body">
                <div id="pnlBusquedaArticulos" class="generic-panel">
                    <div class="gp-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <input id="txtDireccion"  name="txtDireccion" type="text" class="form-control" placeholder="Search for..."> -->
                            </div>
                        </div>
                    </div>
                    <div class="gp-body padding10">
                        <div id="pnlViewAllArticles" class="generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header mdl-shadow--2dp hide">
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
                        <div id="pnlEmpty__Articulos" class="all-height pos-rel">
                            <div class="empty_state centered text-center">
                                <img src="images/logo_empty.png" class="margin20" alt="" />
                                <p class="text-center blue-text"><strong>No se encontraron resultados</strong></p>
                                <button type="button" id="btnActualizar__Menu" class="mdl-button white mdl-button--colored mdl-js-button waves-effect">Actualizar</button>
                            </div>
                        </div>
                    </div>
                    <div class="gp-footer padding10">
                        <div class="row no-margin">
                            <div class="col-md-3 col-md-offset-9">
                                <div class="mdl-grid mdl-grid--no-spacing">
                                    <div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone">
                                        <button type="button" id="btnVerPedido" class="mdl-button btn-primary white-text mdl-button--colored center-block margin-top5 margin-bottom5 mdl-js-button waves-effect">Ver pedido</button>
                                    </div>
                                    <div class="mdl-cell mdl-cell--6-col mdl-cell--2-col-phone">
                                        <button type="button" id="btnRealizarPedido" class="mdl-button btn-success white-text mdl-button--colored center-block margin-top5 margin-bottom5 mdl-js-button waves-effect">Hacer pedido</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <section id="gvCentros" class="gridview scrollbarra padding20" data-selected="none" data-multiselect="false">
                    <div class="list-group gridview-content">
                    </div>
                    <div class="empty_state centered text-center"><img src="images/logo_empty.png" class="margin20" alt="" /><p class="text-center blue-text">No se encontraron resultados</p><a href="#" id="btnActualizar" class="mdl-button white mdl-button--colored mdl-js-button waves-effect">Actualizar</a></div>
                </section> -->
            </div>
        </div>
        <div id="pnlMesas" class="modal-example-content modalcuatro-xl expand-phone">
            <div class="modal-example-header no-padding mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Elija su mesa...</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" data-view="mesas" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped btn-success" data-placement="left" data-toggle="tooltip" title="Mesas individuales" id="btnMesaIndividual">
                            <i class="material-icons">&#xE3C1;</i>
                        </button>
                        <button type="button" data-view="grupo" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Mesas agrupadas" id="btnMesaGrupal">
                            <i class="material-icons">&#xE42A;</i>
                        </button>
                    </div>
                </header>
                <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                    <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE5C4;</i>
                    </a>
                </div>
            </div>
            <div class="modal-example-body">
                <!-- <div class="all-height"> -->
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
                <!-- </div> -->
            </div>
             <div class="modal-example-footer">
                <button id="btnSeleccionarMesa" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                    Seleccionar mesa
                </button>
            </div>
        </div>
		<div id="pnlOrden" class="page generic-panel gp-no-footer" style="display: none;">
			<div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Toma de orden</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Eliminar orden" id="btnRemoveOrder">
                            <i class="material-icons">&#xE872;</i>
                        </button>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Confirmar orden" id="btnConfirmOrder">
                            <i class="material-icons">&#xE22B;</i>
                        </button>
                    </div>
                </header>
            </div>
            <div id="btnBackToLocal__FromOrdenes" class="mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <div class="gp-body no-overflow">
                <div id="pnlOrdenesDetalle" class="generic-panel gp-no-header mdl-layout mdl-layout--fixed-header mdl-shadow--2dp">
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
                            <div class="col-md-12 text-right">
                                <strong>Total de orden</strong>
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

    <div id="modalConfirmUbicacion" class="modal-example-content modalcuatro-xl expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Ubicando posici&oacute;n</span>
                    <div class="mdl-layout-spacer"></div>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="all-height padding20">
                <!-- Event card -->
                <style>
                /*.demo-card-event.mdl-card {
                  width: 256px;
                  height: 256px;
                  background: #3E4EB8;
                }*/
                .demo-card-event > .mdl-card__actions {
                  border-color: rgba(255, 255, 255, 0.2);
                }
                .demo-card-event > .mdl-card__title {
                  align-items: flex-start;
                }
                .demo-card-event > .mdl-card__actions > h5 {
                  margin-top: 0;
                }
                .demo-card-event > .mdl-card__actions {
                  display: flex;
                  box-sizing:border-box;
                  align-items: center;
                }
                .demo-card-event > .mdl-card__actions > .material-icons {
                  padding-right: 10px;
                }
                .demo-card-event > .mdl-card__title,
                .demo-card-event > .mdl-card__actions,
                .demo-card-event > .mdl-card__actions > .mdl-button {
                  color: #fff;
                }
                </style>

                <div class="demo-card-event mdl-card mdl-shadow--2dp all-height full-size">
                    <div id="google-map" class="mdl-card__title mdl-card--expand">
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                    <h4 class="black-text"><strong id="lblTitlePlace"></strong></h4>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal-example-footer padding10">
            <button id="btnConfirmarUbicacion" type="button" disabled class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary center-block">
                Confirmar ubicaci&oacute;n
            </button>
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