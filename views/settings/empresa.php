<?php
require 'bussiness/empresa.php';

$nombrecomercial = '';
$razonsocial = '';
$direccionfiscal = '';
$descripcion_comercial = '';
$eslogan = '';
$numerodoc = '';
$email = '';
$telefono = '';
$pagina_web = '';
$logo = '';
$observaciones = '';

$objEmpresa = new clsEmpresa();

$rowEmpresa = $objEmpresa->Listar('1', $IdEmpresa, "", 0);
$countRowEmpresa = count($rowEmpresa);

if ($countRowEmpresa > 0) {    
    $nombrecomercial = $rowEmpresa[0]['tm_nombre_comercial'];
    $razonsocial = $rowEmpresa[0]['tm_razon_social'];
    $direccionfiscal = $rowEmpresa[0]['tm_direccion_fiscal'];
    $descripcion_comercial = $rowEmpresa[0]['tm_descripcion_comercial'];
    $eslogan = $rowEmpresa[0]['tm_eslogan'];
    $numerodoc = $rowEmpresa[0]['tm_codigo_fiscal'];
    $email = $rowEmpresa[0]['tm_email'];
    $telefono = $rowEmpresa[0]['tm_telefono'];
    $pagina_web = $rowEmpresa[0]['tm_pagina_web'];
    $logo = $rowEmpresa[0]['tm_logo'];
    $observaciones = $rowEmpresa[0]['tm_observaciones'];
}
?>
<form id="form1" name="form1" method="post">
    <div class="page-region">
    	<input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="<?php echo $IdEmpresa; ?>">
        <input type="hidden" id="hdFoto" name="hdFoto" value="<?php echo $logo; ?>" />
        <div class="generic-panel gp-no-header">
            <div class="gp-body">
                <div class="mdl-grid mdl-grid--no-spacing all-height pos-rel form-photo no-margin">
                    <div class="mdl-cell mdl-cell--4-col header-on-phone">
                        <div class="pos-rel padding10 all-height">
                            <?php include 'common/component-photo.php'; ?>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--8-col body-on-phone no-footer">
                        <div class="scrollbarra padding10">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-field">
                                        <input id="txtNumeroDoc" name="txtNumeroDoc" maxlenght="11" type="text" value="<?php echo $numerodoc; ?>" />
                                        <label for="txtNumeroDoc"><?php $translate->__('N&uacute;mero de contribuyente'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-field">
                                        <input id="txtRazonSocial" name="txtRazonSocial" type="text" value="<?php echo $razonsocial; ?>" />
                                        <label for="txtRazonSocial"><?php $translate->__('Raz&oacute;n Social'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input id="txtDireccionFiscal" name="txtDireccionFiscal" type="text" value="<?php echo $direccionfiscal; ?>" />
                                        <label for="txtDireccionFiscal"><?php $translate->__('Direcci&oacute;n Fiscal'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input id="txtNombreComercial" name="txtNombreComercial" type="text" value="<?php echo $nombrecomercial; ?>" />
                                        <label for="txtNombreComercial"><?php $translate->__('Nombre Comercial'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input id="txtDescripcionComercial" name="txtDescripcionComercial" type="text" value="<?php echo $descripcion_comercial; ?>" />
                                        <label for="txtDescripcionComercial"><?php $translate->__('Descripci&oacute;n comercial'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input id="txtEslogan" name="txtEslogan" type="text" value="<?php echo $eslogan; ?>" />
                                        <label for="txtEslogan"><?php $translate->__('Facebook'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-field">
                                        <input id="txtTelefono" name="txtTelefono" type="text" value="<?php echo $telefono; ?>" />
                                        <label for="txtTelefono"><?php $translate->__('Tel&eacute;fono'); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-field">
                                        <input id="txtEmail" name="txtEmail" type="email" value="<?php echo $email; ?>" />
                                        <label for="txtEmail"><?php $translate->__('Email'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input id="txtPaginaWeb" name="txtPaginaWeb" type="text" value="<?php echo $pagina_web; ?>" />
                                        <label for="txtPaginaWeb"><?php $translate->__('P&aacute;gina web'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <textarea id="txtObservaciones" name="txtObservaciones" class="materialize-textarea"><?php echo $observaciones; ?></textarea>
                                        <label for="txtObservaciones">Observaciones</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="gp-footer">
                <div class="padding10">
                    <button id="btnGuardar" type="button" class="mdl-button mdl-js-button waves-effect mdl-button--primary right">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>