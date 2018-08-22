<form id="form1" name="form1" method="post">
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>" />
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
            <header class="mdl-layout__header light-blue darken-2">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Periodo</span>
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
                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese Periodo" />
                        <label for="txtNombre"><?php $translate->__('Descripción'); ?></label>
                    </div>
                </div>
                <div class="input-field full-size">
                    <input class="datepicker" type="text" id="txtFechaInicio" name="txtFechaInicio" value="<?php echo date('d/m/Y'); ?>">
                    <label for="txtFechaInicio"><?php $translate->__('Fecha Inicio'); ?></label>
                </div>
                <div class="input-field full-size">
                    <input class="datepicker" type="text" id="txtFechaFinal" name="txtFechaFinal" value="<?php echo date('d/m/Y'); ?>">
                    <label for="txtFechaFinal"><?php $translate->__('Fecha Final'); ?></label>
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