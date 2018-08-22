<form id="form1" name="form1" method="post">
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region padding20">
        <ul id="nav" class="collapsible popout" data-collapsible="accordion">
        </ul>
        <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div id="modalTerminal" class="modalseis modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header pink darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Registrar terminal</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdTerminal" name="hdIdTerminal" value="0">
            <div class="scrollbarra padding20">
            	<div class="row">
                    <div class="input-field">
                        <input id="txtNombre" name="txtNombre" type="text" />
                        <label for="txtNombre"><?php $translate->__('Nombre de terminal'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="txtDireccionIP" name="txtDireccionIP" type="text" />
                        <label for="txtDireccionIP"><?php $translate->__('Direcci&oacute;n IP'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardarTerminal" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Guardar
            </button>
            <button id="btnLimpiarTerminal" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect right">
                Limpiar
            </button>
        </div>
	</div>
    <div id="modalSerie" class="modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header pink darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Serie/correlativo de impresi&oacute;n</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" name="hdIdSerie" id="hdIdSerie" value="0">
            <div class="scrollbarra padding20">
                <div class="row">
                    <div class="mdl-grid mdl-grid--no-spacing">
                        <div class="mdl-cell mdl-cell--9-col">
                                <label class="active" for="ddlTipoComprobante"><?php $translate->__('Tipo de comprobante'); ?></label>
                                <select name="ddlTipoComprobante" id="ddlTipoComprobante" class="browser-default">
                                </select>
                        </div>
                        <div class="mdl-cell mdl-cell--3-col">
                            <button id="btnUpdateTipoComprobante" type="button" class="btn btn-primary center-block">
                                <i class="material-icons">&#xE923;</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="txtSerie" name="txtSerie" type="text" class="validate" />
                        <label for="txtSerie"><?php $translate->__('Serie'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="txtCorrelativo" name="txtCorrelativo" type="text" class="validate" />
                        <label for="txtCorrelativo"><?php $translate->__('Correlativo'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardarSerie" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Guardar
            </button>
            <button id="btnLimpiarSerie" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect right">
                Limpiar
            </button>
        </div>
    </div>
</form>