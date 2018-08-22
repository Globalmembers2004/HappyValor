<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header light-green --waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Información de Acepta</span>
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
    <div id="pnlForm" class="modal-example-content modaldos expand-phone without-footer">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header light-green">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Ventas registradas en Acepta</span>
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
                    <div class="cell colspan6 all-height body-on-phone no-footer mdl-shadow--4dp">
                        <div class="scrollbarra padding20">
                            <div class="input-field">
                                <input class="validate" id="txtTipoDoc" name="txtTipoDoc" type="text" placeholder="Ingrese Tipo Documento" />
                                <label for="txtTipoDoc"><?php $translate->__('Tipo Documento'); ?></label>
                            </div>
                            <div class="input-field">
                                <input class="validate" id="txtFolio" name="txtFolio" type="text" placeholder="Ingrese Folio" />
                                <label for="txtFolio"><?php $translate->__('Folio de Cliente'); ?></label>
                            </div>
                            <div class="input-field">
                                <input class="validate" id="txtRucreceptor" name="txtRucreceptor" type="text" placeholder="Ingrese RUC" />
                                <label for="txtRucreceptor"><?php $translate->__('RUC'); ?></label>
                            </div>
                            <div class="input-field">
                                <input class="validate" id="txtRazonSocial" name="txtRazonSocial" type="text" placeholder="Ingrese Razón social" />
                                <label for="txtRazonSocial"><?php $translate->__('Razón social'); ?></label>
                            </div>
                            <div class="input-field">
                                <input class="validate" id="txtFechaEmision" name="txtFechaEmision" type="text" placeholder="Ingrese Fecha" />
                                <label for="txtFechaEmision"><?php $translate->__('Fecha (YYYY-MM-DD)'); ?></label>
                            </div>
                            <div class="input-field">
                                <input class="validate" id="txtMoneda" name="txtMoneda" type="text" placeholder="Ingrese Moneda" />
                                <label for="txtMoneda"><?php $translate->__('Moneda'); ?></label>
                            </div>
                            <div class="input-field">
                                <input class="validate" id="txtLocal" name="txtLocal" type="text" placeholder="Ingrese serie de Local" />
                                <label for="txtLocal"><?php $translate->__('Serie de Local'); ?></label>
                            </div>                            
                            <div class="input-field">
                                <input class="validate" id="txtIgv" name="txtIgv" type="number" placeholder="Ingrese IGV" />
                                <label for="txtIgv"><?php $translate->__('IGV'); ?></label>
                            </div>                            
                            <div class="input-field">
                                <input class="validate" id="txtGravadas" name="txtGravadas" type="number" placeholder="Ingrese importe gravado" />
                                <label for="txtGravadas"><?php $translate->__('Importe Gravado'); ?></label>
                            </div>                            
                            <div class="input-field">
                                <input class="validate" id="txtTotal" name="txtTotal" type="number" placeholder="Ingrese monto total" />
                                <label for="txtTotal"><?php $translate->__('Monto total'); ?></label>
                            </div>                            
                            <div class="input-field">
                                <input class="validate" id="txtReferencia" name="txtReferencia" type="text" placeholder="Ingrese monto total" />
                                <label for="txtReferencia"><?php $translate->__('Documento Referencia'); ?></label>
                            </div>                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>