<form id="form1" name="form1" method="post">
    <div class="page-region">
        <div id="gvDatos" class="scrollbarra" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
            <ul class="demo-list-item mdl-list gridview">
            </ul>
        </div>
        <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div id="modalRegistro" class="modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header orange">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Moneda</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
            <div class="scrollbarra padding20">
                <div class="row no-margin">
                    <div class="input-field">
                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre" />
                        <label for="txtNombre"><?php $translate->__('Nombre'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="txtSimbolo" name="txtSimbolo" type="text" placeholder="Ingrese simbolo de moneda" />
                        <label for="txtSimbolo"><?php $translate->__('Simbolo'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 no-padding-left">
                        <div class="input-field">
                            <input id="txtAbreviatura" name="txtAbreviatura" type="text" placeholder="Ingrese abreviatura" />
                            <label for="txtAbreviatura"><?php $translate->__('Abreviatura'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6 no-padding-right">
                        <p>
                          <input type="checkbox" class="filled-in" id="chkDefault" name="chkDefault" checked value="1" />
                          <label for="chkDefault"><?php $translate->__('Moneda por defecto'); ?></label>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnGuardar" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Guardar
            </button>
            <button id="btnLimpiar" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect right">
                Limpiar
            </button>
        </div>
    </div>
</form>