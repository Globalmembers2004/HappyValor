<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageGeneral" name="hdPageGeneral" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall orange">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Rutinas por zona</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D2;</i>
                    </button>
                </div>
            </header>
            <div class="mdl-layout__drawer-button">
                <a class="back-activity mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div id="gvDatos" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                        <div class="mdl-grid gridview-content">
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div id="pnlDetalle" class="modal-example-content modal-nomodal without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header orange">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Detalle de rutina</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div id="gvDetalle" class="gridview all-height" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                <ul class="collection gridview-content">
                </ul>
            </div>
        </div>
    </div>
</form>