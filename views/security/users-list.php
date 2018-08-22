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
                    <span class="mdl-layout-title">Usuario</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdUsuario" name="hdIdUsuario" value="0">
            <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="0" />
            <div class="flex-grid all-height">
                <div class="row all-height pos-rel form-photo no-margin">
                    <div class="cell colspan4 all-height header-on-phone">
                        <div class="pos-rel padding10 all-height">
                            <?php include 'common/component-photo.php'; ?>
                        </div>
                    </div>
                    <div class="cell colspan8 all-height body-on-phone no-footer mdl-shadow--4dp">
                        <div class="scrollbarra padding20">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="active" for="ddlCentro"><?php $translate->__('Centro/Sede'); ?></label>
                                    <select name="ddlCentro" id="ddlCentro" class="browser-default">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="active" for="ddlPerfil"><?php $translate->__('Perfil'); ?></label>
                                    <select name="ddlPerfil" id="ddlPerfil" class="browser-default">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="active" for="ddlCenCosto"><?php $translate->__('Centro de Costo'); ?></label>
                                    <select name="ddlCenCosto" id="ddlCenCosto" class="browser-default">
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <label for="txtSearchPersonal"><?php $translate->__('Personal'); ?></label>
                                    <input type="text" name="txtSearchPersonal" id="txtSearchPersonal" class="full-size" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-field">
                                        <input id="txtNombre" name="txtNombre" type="text" />
                                        <label for="txtNombre"><?php $translate->__('Nombre de usuario'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-field">
                                        <input id="txtClave" name="txtClave" type="password" />
                                        <label for="txtClave"><?php $translate->__('Clave'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-field">
                                        <input id="txtConfirmClave" name="txtConfirmClave" type="password" />
                                        <label for="txtConfirmClave"><?php $translate->__('Confirmar clave'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-field">
                                        <input id="txtNombres" name="txtNombres" type="text" />
                                        <label for="txtNombres"><?php $translate->__('Nombres'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-field">
                                        <input id="txtApellidos" name="txtApellidos" type="text" />
                                        <label for="txtApellidos"><?php $translate->__('Apellidos'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-field">
                                        <input id="txtNumeroDoc" name="txtNumeroDoc" type="text" />
                                        <label for="txtNumeroDoc"><?php $translate->__('N&uacute;mero de documento'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-field">
                                        <input id="txtEmail" name="txtEmail" type="text" />
                                        <label for="txtEmail"><?php $translate->__('Email'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-field">
                                        <input id="txtTelefono" name="txtTelefono" type="text" />
                                        <label for="txtTelefono"><?php $translate->__('Tel&eacute;fono'); ?></label>
                                    </div>
                                </div>
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
    <div id="modalPerfil" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a class="close-modal-example" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Registro de perfil
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <label for="txtNombrePerfil"><?php $translate->__('Nombre'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtNombrePerfil" name="txtNombrePerfil" type="text" placeholder="Ingrese nombre de perfil" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
                <div class="row">
                    <label for="txtDescripcionPerfil"><?php $translate->__('Descripci&oacute;n'); ?></label>
                    <div class="input-control textarea" data-role="input-control">
                        <textarea id="txtDescripcionPerfil" name="txtDescripcionPerfil"></textarea>
                    </div>
                </div>
                <div class="row">
                    <label for="txtAbreviaturaPerfil"><?php $translate->__('Abreviatura'); ?></label>
                    <div class="input-control text" data-role="input-control">
                        <input id="txtAbreviaturaPerfil" name="txtAbreviaturaPerfil" type="text" placeholder="Ingrese abreviatura de perfil" />
                        <button class="btn-clear" tabindex="-1" type="button"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnGuardarPerfil" type="button" class="command-button mode-add success">Guardar</a>
                    </div>
                    <div class="span6">
                        <button id="btnLimpiarPerfil" type="button" class="command-button mode-add default">Limpiar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalChangePassword" class="modalocho modal-dialog modal-example-content">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Cambiar contrase&ntilde;a</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra padding20">
                <input type="hidden" name="hdIdUsuarioClave" id="hdIdUsuarioClave" value="0">
                <div class="row no-margin">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input class="validate" id="txtNewPassword" name="txtNewPassword" type="password" />
                            <label for="txtNewPassword"><?php $translate->__('Nueva contrase&ntilde;a'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row no-margin">
                    <div class="col-md-12">
                        <div class="input-field">
                            <input class="validate" id="txtConfirmNewPassword" name="txtConfirmNewPassword" type="password" />
                            <label for="txtConfirmNewPassword"><?php $translate->__('Confirmar contrase&ntilde;a'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnCambiarClave" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">Cambiar clave</button>
        </div>
    </div>
</form>