<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <div class="page-region">
        <div id="gvDatos" class="scrollbarra" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
            <ul class="demo-list-item mdl-list gridview">
            </ul>
        </div>
        <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>
    <div id="modalRegistro" class="modaluno modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header pink darken">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Sedes</span>
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
            <input type="hidden" id="hdLatitudCentro" name="hdLatitudCentro" value="0">
            <input type="hidden" id="hdLongitudCentro" name="hdLongitudCentro" value="0">
            <input type="hidden" id="hdDireccionFormateada" name="hdDireccionFormateada" value="">
            <div class="scrollbarra padding20">
                <div class="row no-margin">
                    <div class="input-field">
                        <input id="txtNombre" name="txtNombre" type="text" placeholder="Ingrese nombre" />
                        <label for="txtNombre"><?php $translate->__('Nombre'); ?></label>
                    </div>
                </div>
                <div class="row no-margin">
                    <label for="txtDireccion"><?php $translate->__('Direcci&oacute;n'); ?></label>
                    <div class="input-group">
                      <input id="txtDireccion"  name="txtDireccion" type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button id="btnBuscarDireccion" class="btn btn-default" type="button">Buscar</button>
                      </span>
                    </div>
                </div>
                <div class="row">
                    <h4 id="lblDireccionFormateada"></h4>
                </div>
                <div class="row">
                        <label class="active" for="ddlDepartamento">Departamento</label>
                        <select id="ddlDepartamento" name="ddlDepartamento" class="browser-default">
                        </select>
                </div>
                <div class="row">
                        <label class="active" for="ddlProvincia">Provincia</label>
                        <select id="ddlProvincia" name="ddlProvincia" class="browser-default">
                        </select>
                </div>
                <div class="row">
                        <label class="active" for="ddlDistrito">Distrito</label>
                        <select id="ddlDistrito" name="ddlDistrito" class="browser-default">
                        </select>
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