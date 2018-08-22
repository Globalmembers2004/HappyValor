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
    <div id="pnlForm" class="modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header pink darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Detalle de las Rutinas gym</span>
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
                <div class="row">
                    <div class="col-md-12">        
                        <div class="row no-margin">
                            <div class="input-field">
                                <input id="txtDetalle" name="txtDetalle" type="text" placeholder="Trabajo a realizar" />
                                <label for="txtDetalle"><?php $translate->__('Trabajo a realizar'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <label class="active" for="ddlRutina"><?php $translate->__('Rutina'); ?></label>
                            <select name="ddlRutina" id="ddlRutina" class="browser-default">
                            </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <label class="active" for="ddlZonacorporal"><?php $translate->__('Zonacorporal'); ?></label>
                            <select name="ddlZonacorporal" id="ddlZonacorporal" class="browser-default">
                            </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                            <label class="active" for="ddlEquipo"><?php $translate->__('Equipo'); ?></label>
                            <select name="ddlEquipo" id="ddlEquipo" class="browser-default">
                            </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row no-margin">
                            <div class="input-field">
                                <input id="txtSerie" name="numeric" type="text" placeholder="Ingrese series" />
                                <label for="txtSerie"><?php $translate->__('Series'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row no-margin">
                            <div class="input-field">
                                <input id="txtRepeticiones" name="numeric" type="text" placeholder="Ingrese repeticiones" />
                                <label for="txtRepeticiones"><?php $translate->__('Repeticiones'); ?></label>
                            </div>
                        </div>
                    </div>                        
                    <div class="col-md-4">
                        <div class="row no-margin">
                            <div class="input-field">
                                <input id="txtPeso" name="numeric" type="text" placeholder="Ingrese peso a cargar" />
                                <label for="txtPeso"><?php $translate->__('Peso a cargar (Kgs.)'); ?></label>
                            </div>
                        </div>
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