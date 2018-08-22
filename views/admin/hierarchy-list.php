<?php
require 'bussiness/tabla.php';
// require 'bussiness/cargos.php';
// require 'bussiness/areas.php';

$objTabla = new clsTabla();
// $objArea = new clsArea();
// $objCargo = new clsCargo();

// $rowCargo = $objCargo->Listar('1', $IdEmpresa, $IdCentro, 0, '');
// $countrowCargo = count($rowCargo);

// $rowArea = $objArea->Listar('1', $IdEmpresa, $IdCentro, 0, '');
// $countRowArea = count($rowArea);

$rsTurno = $objTabla->Listar('BY-FIELD', 'ta_turno');
$countTurno = count($rsTurno);
?>
<form id="form1" name="form1" method="post" class="validado">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPagePersonal" name="hdPage" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header orange --waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Personal</span>
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
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
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
    <div id="pnlForm" class="modal-example-content modaldos expand-phone">
        <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0" />
        <input type="hidden" id="hdFoto" name="hdFoto" value="no-set" />
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Personal</span>
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
                    <div class="cell colspan6 all-height header-on-phone">
                        <div class="pos-rel padding10 all-height">
                            <?php include 'common/component-photo.php'; ?>
                        </div>
                    </div>
                    <div class="cell colspan6 all-height body-on-phone no-footer z-depth-2">
                        <div class="scrollbarra">
                            <div class="grid padding20">
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtCodigo" name="txtCodigo">
                                        <label for="txtCodigo"><?php $translate->__('C&oacute;digo'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtNroDNI" name="txtNroDNI">
                                        <label for="txtNroDNI"><?php $translate->__('DNI'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtApePaterno" name="txtApePaterno">
                                        <label for="txtApePaterno"><?php $translate->__('Apellido paterno'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtApeMaterno" name="txtApeMaterno">
                                        <label for="txtApeMaterno"><?php $translate->__('Apellido materno'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtNombres" name="txtNombres">
                                        <label for="txtNombres"><?php $translate->__('Nombres'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtEmail" name="txtEmail">
                                        <label for="txtEmail"><?php $translate->__('Email'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <input class="validate" type="text" id="txtTelefono" name="txtTelefono">
                                        <label for="txtTelefono"><?php $translate->__('Telefono'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <select id="ddlCargoReg" name="ddlCargoReg" class="browser-default">
                                        </select>
                                        <label for="ddlCargoReg" class="active"><?php $translate->__('Cargo'); ?></label>
                                    </div>
                                </div>
                                <div class="row has-select">
                                    <div class="input-field full-size">
                                        <select id="ddlAreaReg" name="ddlAreaReg" class="browser-default">
                                        </select>
                                        <label for="ddlAreaReg" class="active"><?php $translate->__('&Aacute;rea'); ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field full-size">
                                        <select id="ddlTurnoReg" name="ddlTurnoReg" class="browser-default">
                                            <?php
                                            if ($countTurno > 0):
                                                for ($i=0; $i < $countTurno; ++$i):
                                            ?>
                                            <option value="<?php echo $rsTurno[$i]['ta_codigo']; ?>">
                                                <?php echo $rsTurno[$i]['ta_denominacion']; ?>
                                            </option>
                                            <?php
                                                endfor;
                                            endif;
                                            ?>
                                        </select>
                                        <label for="ddlTurnoReg" class="active"><?php $translate->__('Turno'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer grey lighten-2">
            <p>
              <input type="checkbox" class="filled-in" name="chkCrearUsuario" id="chkCrearUsuario" checked />
              <label for="chkCrearUsuario">Crear usuario</label>
            </p>
        </div>
    </div>

    <div id="pnlCrearUsuario" class="modal-example-content modal-half expand-phone without-footer">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Crear usuario</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar cambios" id="btnGuardarUsuario">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="input-field">
                        <input id="txtLogin" name="txtLogin" type="text" />
                        <label for="txtLogin"><?php $translate->__('Nombre de usuario'); ?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-field">
                        <input id="txtClave" name="txtClave" type="password" />
                        <label for="txtClave"><?php $translate->__('Clave'); ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-field">
                        <input id="txtConfirmClave" name="txtConfirmClave" type="password" />
                        <label for="txtConfirmClave"><?php $translate->__('Confirmar clave'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
</form>