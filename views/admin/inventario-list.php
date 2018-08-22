<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header light-green --waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Inventario</span>
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
                    <label class="active" for="ddlCenCos"><?php $translate->__('Centro de Costo'); ?></label>
                    <select id="ddlCenCos" name="ddlCenCos" style="width: 100%;" class="browser-default"></select>
                    <div id="gvDatos" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                        <div class="ihead">
                            <table>                        
                             <thead>
                                <tr>
                                  <th class="align-center">Producto</th>
                                  <th class="align-center">Saldo anterior</th>
                                  <th class="align-center">Cantidad enviada</th>
                                  <th class="align-center">Inventario</th>
                                  <th class="align-center">Consumo</th>
                                  <th></th>
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
            </main>
            <a data-toggle="tooltip" title="Guardar Inventario" id="btnGuardarInv" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">done</i>
            </a>
        </div>
    </div>
    <div id="pnlForm" class="modal-example-content modaldos expand-phone without-footer">
        <input type="hidden" id="hdIdInventario" name="hdIdInventario" value="0" />
        <input type="hidden" id="hdIdProducto" name="hdIdProducto" value="0" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header light-green">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Reenviar a otro centro de costo</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar reenvio" id="btnGuardar">
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
            <div class="flex-grid all-height">
                <div class="row all-height pos-rel form-photo no-margin">
                    <div class="cell colspan6 all-height body-on-phone no-footer mdl-shadow--4dp">
                        <div class="scrollbarra padding20">
                            <div class="col-sm-12">
                                    <label class="active" for="ddlCenCosDes"><?php $translate->__('Centro de Costo destino'); ?></label>
                                    <select id="ddlCenCosDes" name="ddlCenCosDes" style="width: 100%;" class="browser-default">
                                    </select>
                            </div>     
                            <div class="input-field col-sm-12">
                                <input class="validate" id="txtCantidadEnvi" name="txtCantidadEnvi" type="text" placeholder="Ingrese Cantidad enviada" />
                                <label for="txtCantidadEnvi"><?php $translate->__('Cantidad enviada'); ?></label>
                            </div>
                            <button id='Agregar'>Adicionar</button>
                        </div>
                    </div>
                    <div class="cell colspan6 all-height body-on-phone no-footer mdl-shadow--4dp">
                        <div class="scrollbarra padding20">
                            <table id="gvDetalle" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                                 <thead>
                                    <tr>
                                      <th class="align-center">Centro de Costo</th>
                                      <th class="align-center">Enviado</th>
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
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>