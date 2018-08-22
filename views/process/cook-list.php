<form id="form1" name="form1" method="post" action="services/atencion/despacho-post.php">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdAtencion" name="hdIdAtencion" value="0" />
    <input type="hidden" id="hdIdMesa" name="hdIdMesa" value="0" />
    <input type="hidden" id="hdTipoAccion" name="hdTipoAccion" value="SELECTION" />
    <input type="hidden" id="hdEstadoActual" name="hdEstadoActual" value="00" />
    <input type="hidden" id="hdEstadoNuevo" name="hdEstadoNuevo" value="00" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="page generic-panel gp-no-footer demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Despacho</span>
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
            <main class="gp-body">
                <div class="mdl-grid all-height no-overflow">
                    <div class="mdl-cell mdl-cell--4-col mdl-cell-6-col-tablet mdl-cell--12-col-phone all-height">
                        <div class="generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header mdl-shadow--2dp">
                            <header class="gp-header mdl-layout__header white">
                                <div class="mdl-layout__header-row">
                                    <span class="mdl-layout-title row no-margin grey-text text-darken-1">Lista de ordenes</span>
                                    <div class="mdl-layout-spacer"></div>
                                </div>
                            </header>
                            <main class="gp-body">
                                <div id="gvOrdenes" class="gridview pos-rel padding10" data-selected="none" data-multiselect="false">
                                    <div class="mdl-grid gridview-content scrollbarra">
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                    <div id="pnlOrdenesDetalle" class="mdl-cell mdl-cell--8-col mdl-cell-6-col-tablet mdl-cell--12-col-phone all-height">
                        <div class="panel panel-default">
                            <div class="panel-heading pos-rel">
                                <h3 class="panel-title">Detalle por atender</h3>
                                <div class="place-top-right">
                                    <button id="btnAtenderSeleccion" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect right hide" data-toggle="tooltip" data-placement="right" title="Atender seleccionados"><i class="material-icons">&#xE877;</i> Atender seleccionados</button>
                                    <button id="btnAtenderOrden" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect right hide" data-toggle="tooltip" data-placement="right" title="Atender orden"><i class="material-icons">&#xE877;</i> Atender orden</button>
                                </div>
                            </div>
                            <div class="panel-body no-padding">
                                <div id="gvArticuloMenu_SinAtender" class="scrollbarra-x" data-selected="none" data-multiselect="false">
                                    <!-- <div class="table-responsive-vertical shadow-z-1">
                                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th><?php $translate->__('Articulo'); ?></th>
                                                    <th><?php $translate->__('Cantidad'); ?></th>
                                                    <th><?php $translate->__('Precio'); ?></th>
                                                    <th><?php $translate->__('Subtotal'); ?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading pos-rel">
                                <h3 class="panel-title">Detalle atendido</h3>
                                <div class="place-top-right">
                                    <button id="btnCompletarSeleccion" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect right hide" data-toggle="tooltip" data-placement="right" title="Completar seleccionados"><i class="material-icons">&#xE877;</i> Completar seleccionados</button>
                                    <button id="btnCompletarOrden" type="button" class="view-button mdl-button mdl-js-button mdl-js-ripple-effect right hide" data-toggle="tooltip" data-placement="right" title="Completar orden"><i class="material-icons">&#xE877;</i> Completar orden</button>
                                </div>
                            </div>
                            <div class="panel-body no-padding">
                                <div id="gvArticuloMenu_Atendidos" class="scrollbarra-x" data-selected="none" data-multiselect="false">
                                    <!-- <div class="table-responsive-vertical shadow-z-1">
                                        <table class="table table-bordered table-hover mdl-shadow--2dp">
                                            <thead>
                                                <tr>
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
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</form>