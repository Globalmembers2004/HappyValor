<form id="form1" name="form1" method="post" class="validado">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageRutina" name="hdPage" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <?php include 'common/droplist-generic.php'; ?>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div id="gvDatos" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                        <ul class="collection gridview-content">
                        </ul>
                    </div>
                </div>
            </main>
            <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">&#xE145;</i>
            </a>
        </div>
    </div>
    <div id="pnlForm" class="modal-example-content modaldos expand-phone">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header pink darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Zonas corporales</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar cambios" id="btnGuardar">
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
                    <div class="cell colspan6 all-height header-on-phone">
                        <div class="pos-rel padding10 all-height">
                            <?php include 'common/component-photo.php'; ?>
                        </div>
                    </div>
                    <div class="cell colspan6 all-height body-on-phone no-footer z-depth-2">
                        <div class="scrollbarra">
                            <div class="grid padding20">
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtNombre" name="txtNombre">
                                        <label for="txtNombre"><?php $translate->__('Descripción'); ?></label>
                                    </div>
                                 </div>
                                <div class="row">
                                    <p>
                                      <input type="checkbox" class="filled-in" id="chkMaquina" name="chkMaquina" checked value="1" />
                                      <label for="chkMaquina"><?php $translate->__('¿Utiliza equipo?'); ?></label>
                                    </p>
                                </div>
                                <div class="row">
                                    <p>
                                      <input type="checkbox" class="filled-in" id="chkMedida" name="chkMedida" checked value="1" />
                                      <label for="chkMedida"><?php $translate->__('¿Requiere medidas?'); ?></label>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>