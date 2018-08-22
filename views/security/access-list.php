<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
    <div class="page-region">
       <div id="gvDatos" class="scrollbarra" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
            <ul class="demo-list-item mdl-list gridview">
            </ul>
        </div>
        <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div id="modalRegistro" class="modal-example-content modal-nomodal">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header light-blue darken-2">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Perfil</span>
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
            <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="0" />
            <div id="pnlPerfil" class="generic-panel gp-no-footer">
                <div class="gp-header">
                    <div class="padding10">
                        <div class="row no-margin-bottom">
                            <div class="col-md-12">
                                <div class="input-field">
                                    <input id="txtNombre" name="txtNombre" class="validate" type="text" placeholder="Ingrese nombre de perfil" />
                                    <label for="txtNombre"><?php $translate->__('Nombre de perfil'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6 hide">
                                <div class="input-field">
                                    <input id="txtAbreviatura" name="txtAbreviatura" class="validate" type="text" placeholder="Ingrese abreviatura de perfil" />
                                    <label for="txtAbreviatura"><?php $translate->__('Abreviatura'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row no-margin-bottom hide">
                            <div class="col-md-12">
                                <div class="input-field">
                                    <textarea id="txtDescripcion" name="txtDescripcion" class="materialize-textarea"></textarea>
                                    <label for="txtDescripcion"><?php $translate->__('Descripci&oacute;n'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gp-body">
                    <div id="gvOpcionesMenu" class="gridview pos-rel all-height" data-selected="none" data-multiselect="false" data-actionbar="#articulos-actionbar">
                        <div class="table-responsive-vertical shadow-z-1 all-height">
                            <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                <thead>
                                    <tr>
                                        <th>
                                            <p>
                                              <input type="checkbox" class="filled-in" id="chkSelectAllMenu" name="chkSelectAllMenu" value="1" title="Seleccionar todos" />
                                              <label for="chkSelectAllMenu"></label>
                                            </p>
                                        </th>
                                        <th><?php $translate->__('Tipo de m&oacute;dulo'); ?></th>
                                        <th><?php $translate->__('M&oacute;dulos de la aplicaci&oacute;n'); ?></th>
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