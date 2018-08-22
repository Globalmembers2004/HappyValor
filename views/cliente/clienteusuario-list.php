<form id="form1" name="form1" method="post">
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
    <div id="modalRegistro" class="modal-example-content modal-nomodal" style="display: block;">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Mi Cuenta</span>
                </div>
            </header>
            <div title="<?php $translate->__('Regresar'); ?>" class="mdl-button--icon mdl-layout__drawer-button">
                <a class="back-activity mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdUsuario" name="hdIdUsuario" value="<?php echo $idusuario; ?>" />
            <input type="hidden" id="hdIdPersona" name="hdIdPersona" value="<?php echo $idpersona; ?>" />
            <input type="hidden" id="ddlTipoPersona" name="ddlTipoPersona" value="0" />
            <input type="hidden" id="ddlPerfil" name="ddlPerfil" value="0" />
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
                                <div class="col-md-4">
                                    <div class="input-field">
                                        <input id="txtNombre" name="txtNombre" type="text" />
                                        <label for="txtNombre"><?php $translate->__('Nombre de usuario'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <button id="btnEditarClave" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary center-block">
                                        Cambiar clave
                                    </button>
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
            <button id="btnGuardar" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary center-block">
                Guardar
            </button>
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
                <input type="hidden" name="hdIdUsuarioClave" id="hdIdUsuarioClave" value="<?php echo $idusuario_cliente; ?>">
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