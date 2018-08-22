<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdTipoSeleccion" name="hdTipoSeleccion" value="00" />
    <input type="hidden" id="hdTipoMenuDia" name="hdTipoMenuDia" value="03" />
    <input type="hidden" id="hdTipoSave" name="hdTipoSave" value="00" />
    <input type="hidden" id="hdIdVenta" name="hdIdVenta" value="0" />
    <input type="hidden" id="hdIdArticulo" name="hdIdArticulo" value="0" />
    <input type="hidden" id="hdNombreArticulo" name="hdNombreArticulo" value="" />
    <input type="hidden" id="hdIdAmbiente" name="hdIdAmbiente" value="0" />
    <input type="hidden" id="hdIdAtencion" name="hdIdAtencion" value="0" />
    <input type="hidden" id="hdIdMesa" name="hdIdMesa" value="0" />
    <input type="hidden" id="hdTipoMesa" name="hdTipoMesa" value="0" />
    <input type="hidden" id="hdIdMoneda" name="hdIdMoneda" value="0" />
    <?php if ($screenmode == 'cliente'): ?>
    <input type="hidden" id="hdIdCliente" name="hdIdCliente" value="<?php echo $idpersona; ?>" />
    <?php else: ?>
    <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="<?php echo $idpersona; ?>" />
    <?php endif ?>
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


    <input type="hidden" id="hdCantidad" name="hdCantidad" value="0" />
    <input type="hidden" id="hdPrecio" name="hdPrecio" value="0" />
    <input type="hidden" id="hdSubTotal" name="hdSubTotal" value="0" />
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
        <div id="pnlArticulo" class="generic-panel page"<?php echo $mostrar_from_cliente; ?>>
            <header class="gp-header mdl-layout--fixed-header">
                <div class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <div id="barSearchArticulos" class="searchview hide">
                            <div class="searchview-content">
                                <a id="btnHideSearchBarArticles" class="hide-searchview margin10 black-text height-centered mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="right" data-toggle="tooltip" title="Ocutlar b&uacute;squeda">
                                    <i class="material-icons">&#xE5C4;</i>
                                </a>
                                <input type="text" name="txtArticulo" id="txtArticulo" data-input="search" placeholder="Busca cualquier plato que se te antoje..." class="no-margin black-text padding-right20" value="" autocomplete="off">
                                <button type="button" class="helper-button margin10 black-text height-centered mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                            </div>
                        </div>
                        <span class="mdl-layout-title">Platos en lista</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" data-view="grupo" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Buscar" id="btnBuscarArticulo">
                            <i class="material-icons">&#xE8B6;</i>
                        </button>
                    </div>
                </div>
            </header>
             <div class="mdl-layout__drawer-button">
                <a class="control-inner-app mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <div class="gp-body">
                <div class="container-body pos-rel all-height">
                    
                    <section id="gvArticulo" class="gridview pos-rel all-height hide" data-selected="none" data-multiselect="false">
                        <div class="scrollbarra padding10">
                            <ul>
                            </ul>
                        </div>
                    </section>
                    <div id="emptyStateArticles" class="empty__state__panel all-height">
                        <div class="height--1-1 l-flex--col l-flexer soft-quad--sides soft-double--top">
                            <div class="height--1-1 flex flex--column flex-justified--center align-center soft-quad push-quad--top">
                                <img src="images/if_fastfood_512pxGREY_339910.png" class="anchor--middle push--ends" width="252px" style="width: 252px;">
                                <h3 class="push-half--bottom">No hay platos disponibles :(</h3>
                                <button type="button" class="mdl-button mdl-js-button center-block blue white margin20 mdl-js-ripple-effect" id="btnActualizarViewArticles__Portada">
                                    Refrescar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="gp-footer padding10">
                <button type="button" id="btnVerPedido" class="mdl-button btn-primary white-text mdl-button--colored center-block margin-top5 margin-bottom5 mdl-js-button waves-effect">Ver pedido</button>
            </footer>
        </div>

        <div id="pnlCentros" class="generic-panel page gp-no-footer" style="display: none;">
            <div class="gp-header mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <div id="barSearchSedes" class="full-size m-search white hide">
                            <input type="text" name="txtDireccion" id="txtDireccion" data-input="search" placeholder="Busca tu local, el m&aacute;s cercano ser&aacute;a el primero" class="no-margin black-text padding-right20" value="" autocomplete="off">
                            <button type="button" class="helper-button margin10 black-text height-centered place-right mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                            <div class="clearfix"></div>
                        </div>
                        <span class="mdl-layout-title">Elegir local</span>
                        <div class="mdl-layout-spacer"></div>
                        <button type="button" data-view="mesas" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Actualizar ubicaci&oacute;n" id="btnActualizarUbicacion">
                            <i class="material-icons">&#xE55F;</i>
                        </button>
                        <button type="button" data-view="grupo" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Buscar" id="btnBuscarSedes">
                            <i class="material-icons">&#xE8B6;</i>
                        </button>
                    </div>
                </header>
            </div>
            <div class="mdl-layout__drawer-button">
                <a id="btnBackToSede__FromArticles" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="right" data-toggle="tooltip" title="Ocutlar b&uacute;squeda">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <div class="gp-body">
                <div class="container-body pos-rel all-height">
                    <div id="pnlViewCentro" class="scrollbarra hide">
                        <ul id="gvCentro" class="padding20">
                        </ul>
                    </div>
                    <div id="emptyStateCentros" class="empty__state__panel all-height">
                        <div class="height--1-1 l-flex--col l-flexer soft-quad--sides soft-double--top">
                            <div class="height--1-1 flex flex--column flex-justified--center align-center soft-quad push-quad--top">
                                <img src="images/if_15_Place_Optimization_1688864.png" class="anchor--middle push--ends" width="252px" style="width: 252px;">
                                <h3 class="push-half--bottom">Aqu&iacute; aparecer&aacute;n los locales a elegir</h3>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide tooltipped" data-placement="left" data-toggle="tooltip" title="Eliminar orden" id="btnRemoveOrder">
                            <i class="material-icons">&#xE872;</i>
                        </button>
                        <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon hide tooltipped" data-placement="left" data-toggle="tooltip" title="Confirmar orden" id="btnConfirmOrder">
                            <i class="material-icons">&#xE22B;</i>
                        </button>
                    </div>
                </header>
            </div>
            <div id="btnBackToArticles__FromOrdenes" class="mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <div class="gp-body no-overflow">
                <div class="container-body pos-rel all-height">
                    <div id="pnlOrdenesDetalle" class="generic-panel gp-no-header mdl-layout mdl-layout--fixed-header mdl-shadow--2dp hide">
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
                    <div id="emptyStateOrders" class="empty__state__panel all-height">
                        <div class="height--1-1 l-flex--col l-flexer soft-quad--sides soft-double--top">
                            <div class="height--1-1 flex flex--column flex-justified--center align-center soft-quad push-quad--top">
                                <img src="images/if_Food-Dome_379338.png" class="anchor--middle push--ends" width="252px" style="width: 252px;">
                                <h3 class="push-half--bottom">En esta secci&oacute;n aparecer&aacute;n tus pedidos.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button id="btnVerUbicacion" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect blue darken-3 white-text" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">&#xE1B7;</i>
            </button>
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
        <div id="pnlLocal" class="modal-example-content modalcuatro-xl expand-phone">
            <div class="modal-example-header no-padding mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title">Local y m&aacute;s art&iacute;culos...</span>
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
                <div class="scrollbarra">
                    <div class="header-profile grey">
                        <div id="container">
                          <div id="mainimage">
                            <div id="heart"><div class="pos-rel full-size all-height"><i class="material-icons centered">&#xE87D;</i></div></div>
                            <div id="slides" class="text-center"><div class="pos-rel full-size all-height"><img id="imgLogo__Local" src="images/logo-main.png" title="image" class="centered img-responsive" /></div></div>
                          </div>
                          <div id="sidepanel">
                            <div id="next"><div class="pos-rel full-size all-height"><i class="material-icons centered">&#xE55F;</i></div></div>
                          </div>
                          <div id="ratingbox"><span class="counter" id="lblCounter__Local"></span>
                          </div>
                          <div id="infopanel">
                            <h1 id="lblTitle__Local"></h1>
                            <h2 id="lblAddress__Local"></h2>
                          </div>
                        </div>
                    </div>
                    <ul id="tabs-swipe-demo" class="tabs">
                        <li class="tab col s3"><a class="active" href="#test-swipe-1">MENU</a></li>
                        <li class="tab col s3"><a href="#test-swipe-2">CARTA</a></li>
                        <li class="tab col s3"><a href="#test-swipe-3">INDIVIDUAL</a></li>
                    </ul>
                    <div id="test-swipe-1" class="col s12">
                        <div id="emptyStateArticles__Menu" class="empty__state__panel all-height">
                            <div class="height--1-1 l-flex--col l-flexer soft-quad--sides soft-double--top">
                                <div class="height--1-1 flex flex--column flex-justified--center align-center soft-quad push-quad--top">
                                    <img src="images/if_food-blt-v1_2386377.png" class="anchor--middle push--ends" width="252px" style="width: 252px;">
                                    <h3 class="push-half--bottom">La lista de men&uacute; aparecer&aacute; aqu&iacute;</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test-swipe-2" class="col s12">
                        <div id="gvArticulo__Carta" class="scrollbarra hide">
                            <ul>
                            </ul>
                        </div>
                        <div id="emptyStateArticles__Carta" class="empty__state__panel all-height">
                            <div class="height--1-1 l-flex--col l-flexer soft-quad--sides soft-double--top">
                                <div class="height--1-1 flex flex--column flex-justified--center align-center soft-quad push-quad--top">
                                    <img src="images/if_Food_C224_2427872.png" class="anchor--middle push--ends" width="252px" style="width: 252px;">
                                    <h3 class="push-half--bottom">La carta aparecer&aacute; aqu&iacute;</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test-swipe-3" class="col s12">
                        <section id="gvArticulo__Individual" class="gridview pos-rel all-height hide" data-selected="none" data-multiselect="false">
                            <ul>
                            </ul>
                        </section>
                        <div id="emptyStateArticles__Individual" class="empty__state__panel all-height">
                            <div class="height--1-1 l-flex--col l-flexer soft-quad--sides soft-double--top">
                                <div class="height--1-1 flex flex--column flex-justified--center align-center soft-quad push-quad--top">
                                    <img src="images/if_wine_1936919.png" class="anchor--middle push--ends" width="252px" style="width: 252px;">
                                    <h3 class="push-half--bottom">Los platos del men&uacute; que desee pedir de forma individual aparecer&aacute;n aqu&iacute;n</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="modal-example-footer">
                <button id="btnAgregarArticulos" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                    Agregar art&iacute;culos
                </button>
            </footer>
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
</form>