<?php
include('bussiness/unidadmedida.php');
include('bussiness/presentacion.php');
include('bussiness/categoriainsumo.php');

$IdEmpresa = 1;
$IdCentro = 1;

$i = 0;

$objCategoria = new clsCategoriaInsumo();
$objUM = new clsUnidadMedida();
$objPresentacion = new clsPresentacion();

$rowCategoria = $objCategoria->Listar('1', $IdEmpresa, $IdCentro, '0', '', '1');
$countRowCategoria = count($rowCategoria);

$rowPresentacion = $objPresentacion->Listar('1', 0, '');
$countRowPresentacion = count($rowPresentacion);

$rowUM = $objUM->Listar('1', 0, '');
$countRowUM = count($rowUM);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageCategoria" name="hdPageCategoria" value="1" />
    <input type="hidden" id="hdPageInsumo" name="hdPageInsumo" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <div class="page-region">
        <div id="pnlListado" class="demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header mdl-layout__header--waterfall">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="waves-effect waves-light indigo no-shadow white-text padding10 dropbutton-material" id="btnMoreSites"><i class="material-icons right">&#xE5C5;</i><span class="text">Insumos</span></a>
                    </span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnSearch" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <ul class="mnuOpciones dropdown">
                <li><a href="#" id="btnShowAll" data-action="select-all">Mostrar todo</a></li>
                <li><a href="#" id="btnSelectAll" data-action="select-all">Seleccionar todo</a></li>
                <li><a href="#" id="btnUnSelectAll" data-action="unselect-all" class="hide">Quitar selecci&oacute;n</a></li>
                <li><a href="#" data-action="close">Cerrar</a></li>
            </ul>
            <ul id="mnuSites" class="dropdown dropdown-sites">
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <section id="gvCategoria" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar" style="display: none;">
                        <ul class="mini-collection gridview-content no-margin">
                        </ul>
                    </section>
                    <section id="gvDatos" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                        <div class="mdl-grid gridview-content">
                        </div>
                    </section>
                </div>
            </main>
            <a id="btnNuevo" class="mdl-button mdl-js-button mdl-button--fab animate mdl-js-ripple-effect mdl-button--colored" style="bottom: 45px; right: 24px; position: absolute; z-index: 900;">
                <i class="material-icons">&#xE145;</i>
            </a>
        </div>
        <div id="pnlForm" class="inner-page-content" style="display:none;">
            <div class="generic-panel gp-no-footer">
                <div class="gp-header mdl-layout--fixed-header">
                    <header class="mdl-layout__header">
                        <div class="mdl-layout__header-row">
                            <span class="mdl-layout-title">
                                <span class="text">Registro de insumos</span></a>
                            </span>
                            <div class="mdl-layout-spacer"></div>
                            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnGuardarInsumo">
                                <i class="material-icons">&#xE5CA;</i>
                            </button>
                            <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnAgregarPresentacion">
                                <i class="material-icons">&#xE145;</i>
                            </button>
                        </div>
                    </header>
                    <div id="btnBackToList" class="mdl-button--icon mdl-layout__drawer-button">
                        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                            <i class="material-icons">&#xE5C4;</i>
                        </a>
                    </div>
                </div>
                <div class="gp-body">
                    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--3-col">
                            <div class="row">
                                <div class="input-field">
                                    <input id="txtNombre" name="txtNombre" type="text" class="validate">
                                    <label for="txtNombre"><?php $translate->__('Nombre de insumo'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field">
                                  <textarea id="txtDescripcion" name="txtDescripcion" class="materialize-textarea"></textarea>
                                  <label for="txtDescripcion"><?php $translate->__('Descripci&oacute;n de insumo'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <select id="ddlCategoriaReg" name="ddlCategoriaReg" class="browser-default" style="width:100%;">
                                        <?php 
                                        if ($countRowCategoria > 0):
                                            for ($i=0; $i < $countRowCategoria; $i++):
                                        ?>
                                        <option value="<?php echo $rowCategoria[$i]['tm_idcategoria_insumo']; ?>"><?php echo $rowCategoria[$i]['tm_nombre']; ?></option>
                                        <?php
                                            endfor;
                                        endif;
                                        ?>
                                    </select>
                                    <label class="active" for="ddlCategoriaReg"><?php $translate->__('Categor&iacute;a'); ?></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <select id="ddlUnidadMedidaReg" name="ddlUnidadMedidaReg" class="browser-default" style="width:100%;">
                                    <?php 
                                    if ($countRowUM > 0):
                                        for ($i=0; $i < $countRowUM; $i++):
                                    ?>
                                    <option data-simbolo="<?php echo $rowUM[$i]['tm_abreviatura']; ?>" value="<?php echo $rowUM[$i]['tm_idunidadmedida']; ?>"><?php echo $rowUM[$i]['tm_nombre'].' ('.$rowUM[$i]['tm_abreviatura'].')'; ?></option>
                                    <?php
                                        endfor;
                                    endif;
                                    ?>
                                    </select>
                                    <label class="active" for="ddlUnidadMedidaReg">Unidad de medida</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field full-size">
                                    <input id="txtCostoPromedio" name="txtCostoPromedio" type="text" class="validate" value="0.00">
                                    <label for="txtCostoPromedio"><?php $translate->__('Costo promedio'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--9-col">
                            <div id="tablePresentacion" class="pos-rel padding20" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                                <div class="table-responsive-vertical shadow-z-1">
                                    <table class="table table-bordered table-hover mdl-shadow--2dp">
                                        <thead>
                                            <tr>
                                                <th class="hide"></th>
                                                <th><?php $translate->__('Presentaci&oacute;n'); ?></th>
                                                <th title="Unidad de medida">UM</th>
                                                <th><?php $translate->__('Medida'); ?></th>
                                                <th></th>
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
            </div>
        </div>
    </div>
    <?php include 'common/generic-actionbar.php'; ?>
    <div id="modalRegCategoria" class="modal-example-content modal-half">
        <div class="modal-example-header">
            <div class="left">
                <a href="#" title="<?php $translate->__('Ocultar'); ?>" class="close-modal-example fg-dark padding5 circle waves-effect waves-light left"><i class="material-icons md-18">close</i></a>
                <h4 class="no-margin fg-dark left">
                     Registro de categoria
                </h4>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="0" />
            <div class="padding20">
                <div class="row">
                    <div class="input-field full-size">
                      <input id="txtNombreCategoria" name="txtNombreCategoria" type="text" class="validate">
                      <label class="active" for="txtNombreCategoria">Nombre de categor&iacute;a</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarCategoria" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Aplicar
            </button>
        </div>
    </div>
    <div id="pnlInfoPresentacion" class="modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Detalle de presentaciones</span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="grid no-margin padding20">
                <div class="row">
                    <div class="input-field full-size">
                        <select name="ddlPresentacion" id="ddlPresentacion" class="browser-default" style="width:100%;">
                            <?php
                            if ($countRowPresentacion > 0):
                                for ($i=0; $i < $countRowPresentacion; $i++):
                            ?>
                            <option value="<?php echo $rowPresentacion[$i]['tm_idpresentacion']; ?>"><?php echo $rowPresentacion[$i]['tm_nombre']; ?></option>
                            <?php  
                                endfor;
                            endif;
                            ?>
                        </select>
                        <label class="active" for="ddlPresentacion">Presentaci&oacute;n</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field full-size">
                        <select id="ddlUnidadMedida" name="ddlUnidadMedida" class="browser-default" style="width:100%;">
                        <?php 
                        if ($countRowUM > 0):
                            for ($i=0; $i < $countRowUM; $i++):
                        ?>
                        <option data-simbolo="<?php echo $rowUM[$i]['tm_abreviatura']; ?>" value="<?php echo $rowUM[$i]['tm_idunidadmedida']; ?>"><?php echo $rowUM[$i]['tm_nombre'].' ('.$rowUM[$i]['tm_abreviatura'].')'; ?></option>
                        <?php
                            endfor;
                        endif;
                        ?>
                        </select>
                        <label class="active" for="ddlUnidadMedida">Unidad de medida</label>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-field text full-size">
                            <input id="txtMedida" name="txtMedida" type="text" value="0" class="validate">
                            <label for="txtMedida">Medida</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnPresentacionAdd" type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--primary right">
                Agregar a detalle
            </button>
        </div>
    </div>
</form>