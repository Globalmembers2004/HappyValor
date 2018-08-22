<?php
require 'bussiness/tabla.php';

$objTabla = new clsTabla();
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageCategoria" name="hdPageCategoria" value="1" />
    <input type="hidden" id="hdPageInsumo" name="hdPageInsumo" value="1" />
    <input type="hidden" id="hdIdEmpresa" name="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>" />
    <input type="hidden" id="hdIdCentro" name="hdIdCentro" value="<?php echo $IdCentro; ?>" />
    <input type="hidden" name="hdIdAlmacen" id="hdIdAlmacen" value="0">
    <input type="hidden" name="hdIdArticulo" id="hdIdArticulo" value="0">
    <input type="hidden" name="hdTipoInsumo" id="hdTipoInsumo" value="1">
    <div class="page-region">
        <div id="pnlKardex" class="page generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
            <header class="gp-header mdl-layout__header orange">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Almacén</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <div class="mdl-layout__drawer-button">
                <!-- <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a> -->
                <a class="back-activity mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5C4;</i>
                </a>
            </div>  
            
<!--             <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
 -->            <main class="gp-body no-overflow pos-rel">
                <div id="pnlConsultaKardex" class="generic-panel">
                    <div class="gp-header">
                        <!-- <div class="row no-margin">
                            <div class="col-md-12">
                                <div class="input-field pos-rel">
                                    <input type="text" name="txtSearchAlmacenKardex" id="txtSearchAlmacenKardex" class="full-size" style="width: 100%;" />
                                    <label class="active" for="txtSearchAlmacenKardex">Almacen</label>
                                </div>
                            </div>
                        </div> -->
                        <div class="padding10">
                            <div class="row no-margin">
                                <div class="col-md-2">
                                    <div class="input-field">
                                        <select name="ddlAnho" id="ddlAnho" class="browser-default">
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016" selected>2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                        </select>
                                        <label class="active" for="ddlAnho">A&ntilde;o</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                        <label class="active" for="ddlMes">Mes</label>
                                        <select name="ddlMes" id="ddlMes" class="browser-default">
                                            <?php ListarMeses(); ?>
                                        </select>
                                </div>
                                <div class="col-md-2">
                                        <label class="active" for="ddlTipoExistencia">Tipo de Existencia</label>
                                        <select name="ddlTipoExistencia" id="ddlTipoExistencia" class="browser-default">
                                            <?php
                                            $rowTipoExistencia = $objTabla->ValorPorCampo_PorCodigos('ta_tipoproducto', '00,01');
                                            $countRowTipoExistencia = count($rowTipoExistencia);

                                            for ($i=0; $i < $countRowTipoExistencia; $i++):
                                            ?>
                                            <option value="<?php echo $rowTipoExistencia[$i]['ta_codigo']; ?>"<?php echo $selected; ?>><?php echo $rowTipoExistencia[$i]['ta_denominacion']; ?></option>
                                            <?php
                                            endfor;
                                            ?>
                                        </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-field pos-rel">
                                        <input type="text" name="txtSearchInsumoKardex" id="txtSearchInsumoKardex" class="full-size" style="width: 100%;" />
                                        <label class="active" for="txtSearchInsumoKardex">Existencia</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gp-body">
                        <div class="scrollbarra">
                            <div id="gvKardex" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false">
                                <table class="table_normie mdl-shadow--2dp">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center"><?php $translate->__('DOCUMENTO DE TRALSADO, COMPROBANTE DE PAGO, DOCUMENTO INTERNO O SIMILAR'); ?></th>
                                            <th class="text-center"><?php $translate->__('TIPO DE OPERACI&Oacute;N (TABLA 12)'); ?></th>
                                            <th colspan="3" class="text-center"><?php $translate->__('ENTRADAS'); ?></th>
                                            <th colspan="3" class="text-center"><?php $translate->__('SALIDAS'); ?></th>
                                            <th colspan="3" class="text-center"><?php $translate->__('SALDO FINAL'); ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-center"><?php $translate->__('FECHA'); ?></th>
                                            <th class="text-center"><?php $translate->__('TIPO (TABLA 10)'); ?></th>
                                            <th class="text-center"><?php $translate->__('SERIE'); ?></th>
                                            <th class="text-center"><?php $translate->__('N&Uacute;MERO'); ?></th>
                                            <th></th>
                                            <th class="text-center"><?php $translate->__('CANTIDAD'); ?></th>
                                            <th class="text-center"><?php $translate->__('COSTO UNITARIO'); ?></th>
                                            <th class="text-center"><?php $translate->__('COSTO TOTAL'); ?></th>
                                            <th class="text-center"><?php $translate->__('CANTIDAD'); ?></th>
                                            <th class="text-center"><?php $translate->__('COSTO UNITARIO'); ?></th>
                                            <th class="text-center"><?php $translate->__('COSTO TOTAL'); ?></th>
                                            <th class="text-center"><?php $translate->__('CANTIDAD'); ?></th>
                                            <th class="text-center"><?php $translate->__('COSTO UNITARIO'); ?></th>
                                            <th class="text-center"><?php $translate->__('COSTO TOTAL'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="gp-footer">
                        <button id="btnCerrarKardex" type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored waves-effect right margin10">
                            Cerrar kardex
                        </button>
                    </div>
                </div>
            </main>
        </div>
        <div id="pnlStock" class="page generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header hide">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">
                        <a class="waves-effect waves-light indigo no-shadow white-text padding10 dropbutton-material" id="btnTipoInsumo"><i class="material-icons right">&#xE5C5;</i><span class="text">Stock de insumos</span></a>
                    </span>
                    <div class="mdl-layout-spacer"></div>
                    <button id="btnSearchStock" type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" data-type="search">
                        <i class="material-icons">&#xE8B6;</i>
                    </button>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <ul id="mnuTipoInsumo" class="dropdown dropdown-sites">
                <li><a class="waves-effect" href="#gvStockInsumo"><?php $translate->__('Stock de insumos'); ?></a></li>
                <li><a class="waves-effect" href="#gvStockArticulo">Stock de articulos</a></li>
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="gp-body no-overflow pos-rel">
                <div id="pnlStockInsumo" class="generic-panel gp-no-header gp-no-footer">
                    <div class="gp-header hide white" style="border-bottom: 1px #ccc solid;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-field pos-rel">
                                    <input type="text" name="txtSearchAlmacen" id="txtSearchAlmacen" class="full-size z" style="width: 100%;" />
                                    <label class="active" for="txtSearchAlmacen">Almacen</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gp-body">
                        <section id="gvStockInsumo" class="gridview pos-rel all-height" data-selected="none" data-multiselect="false">
                            <div class="table-responsive-vertical shadow-z-1 all-height">
                                <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><?php $translate->__('Articulo'); ?></th>
                                            <th><?php $translate->__('Unidad de medida'); ?></th>
                                            <th><?php $translate->__('Saldo Inicial'); ?></th>
                                            <th><?php $translate->__('Costo unitario'); ?></th>
                                            <th><?php $translate->__('Costo total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="contenedor">
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
        <div id="pnlListado" class="page demo-layout-waterfall mdl-layout mdl-js-layout mdl-layout--fixed-header hide">
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
            <?php include 'common/droplist-generic.php'; ?>
            <ul id="mnuSites" class="dropdown dropdown-sites">
            </ul>
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="mdl-layout__content section-main">
                <div class="page-content">
                    <section id="gvCategoria" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar" style="display: none;">
                        <ul class="mini-collection gridview-content no-margin">
                        </ul>
                    </section>
                    <section id="gvDatos" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar">
                        <div class="mdl-grid gridview-content contenedor">
                        </div>
                    </section>
                    <section id="gvAlmacen" class="gridview" data-selected="none" data-multiselect="false" data-actionbar="generic-actionbar" style="display: none;">
                        <div class="padding20 list-group gridview-content">
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
                            <button type="button" class="btnOpciones tooltipped mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Agregar presentaci&oacute;n" id="btnAgregarPresentacion">
                                <i class="material-icons">&#xE145;</i>
                            </button>
                            <button type="button" class="btnOpciones tooltipped mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar cambios" id="btnGuardarInsumo">
                                <i class="material-icons">&#xE5CA;</i>
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
                    <div class="mdl-grid mdl-grid--no-spacing all-height">
                        <div class="mdl-cell mdl-cell--3-col all-height">
                            <div class="scrollbarra">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-field">
                                            <input id="txtNombre" name="txtNombre" type="text" class="validate">
                                            <label for="txtNombre"><?php $translate->__('Nombre de insumo'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-field">
                                            <textarea id="txtDescripcion" name="txtDescripcion" class="materialize-textarea"></textarea>
                                            <label for="txtDescripcion"><?php $translate->__('Descripci&oacute;n de insumo'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                            <label class="active" for="ddlCategoriaReg"><?php $translate->__('Categor&iacute;a'); ?></label>
                                            <select id="ddlCategoriaReg" name="ddlCategoriaReg" class="browser-default" style="width:100%;">
                                                <option value="0"><?php $translate->__('No existen categor&iacute;as registradas'); ?></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                            <label class="active" for="ddlUnidadMedidaReg">Unidad de medida</label>
                                            <select id="ddlUnidadMedidaReg" name="ddlUnidadMedidaReg" class="browser-default" style="width:100%;">
                                                <option value="0"><?php $translate->__('No existen unidades de medida registradas'); ?></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-field">
                                            <input id="txtCostoPromedio" name="txtCostoPromedio" type="number" class="validate align-right" value="0.00">
                                            <label for="txtCostoPromedio"><?php $translate->__('Costo promedio'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-field">
                                            <input id="txtStockMinimo" name="txtStockMinimo" type="number" class="validate align-right" value="0">
                                            <label for="txtStockMinimo"><?php $translate->__('Stock m&iacute;nimo'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-field">
                                            <input id="txtStockMaximo" name="txtStockMaximo" type="number" class="validate align-right" value="0">
                                            <label for="txtStockMaximo"><?php $translate->__('Stock m&aacute;ximo'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--9-col all-height">
                            <div id="tablePresentacion" class="pos-rel padding20 all-height" data-selected="none" data-multiselect="false" data-actionbar="articulos-actionbar">
                                <div class="table-responsive-vertical shadow-z-1 all-height">
                                    <table class="table table-bordered table-hover mdl-shadow--2dp all-height">
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
    <div id="generic-actionbar" class="actionbar fixed-top mdl-layout">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <div class="pos-rel full-size m-search">
                    <input type="text" name="txtSearch" id="txtSearch" data-input="search" placeholder="Ingrese un criterio de b&uacute;squeda" value="" autocomplete="off">
                    <button type="button" class="helper-button margin5 height-centered mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="mdl-layout-spacer"></div>
                <button type="button" data-action="change-stockminmax" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Actualizar stock mínimo y máximo">
                    <i class="material-icons">&#xE156;</i>
                </button>
                <button type="button" data-action="delete" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Eliminar">
                    <i class="material-icons">&#xE872;</i>
                </button>
                <button type="button" class="btnOpciones show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D4;</i>
                </button>
            </div>
        </header>
        <div class="mdl-layout__drawer-button">
            <a id="btnGenericBack" class="back-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </div>
    </div>
    <div id="stockinsumo-actionbar" class="actionbar fixed-top mdl-layout">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <div class="pos-rel full-size m-search">
                    <input type="text" name="txtSearchStock" id="txtSearchStock" data-input="search" placeholder="Ingrese un criterio de b&uacute;squeda" value="" autocomplete="off">
                    <button type="button" class="helper-button margin5 height-centered mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon"><i class="material-icons">&#xE5CD;</i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="mdl-layout-spacer"></div>
                <button id="btnStockInsumo" type="button" class="show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon tooltipped" data-placement="left" data-toggle="tooltip" title="Guardar stock de insumos">
                    <i class="material-icons">&#xE1DB;</i>
                </button>
                <!-- <button type="button" class="btnOpciones show-in-select mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D4;</i>
                </button> -->
            </div>
        </header>
        <div class="mdl-layout__drawer-button">
            <a class="back-button mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </div>
    </div>
    <div id="modalRegCategoria" class="modal-half modal-example-content modal-half">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title"><?php $translate->__('Registro de categoria'); ?></span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <input type="hidden" id="hdIdCategoria" name="hdIdCategoria" value="0" />
            <div class="padding20">
                <div class="row">
                    <div class="input-field full-size">
                      <input id="txtNombreCategoria" name="txtNombreCategoria" type="text" class="validate">
                      <label class="active" for="txtNombreCategoria"><?php $translate->__('Nombre de categor&iacute;a'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarCategoria" type="button" class="mdl-button mdl-js-button waves-effect mdl-button--primary right">
                <?php $translate->__('Guardar'); ?>
            </button>
        </div>
    </div>
    <div id="modalRegAlmacen" class="modaluno modal-example-content expand-phone">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Almacen</span>
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
                <div class="row no-margin">
                    <div class="input-field">
                        <input id="txtNombreAlmacen" name="txtNombreAlmacen" type="text" placeholder="Ingrese nombre" />
                        <label for="txtNombreAlmacen"><?php $translate->__('Nombre'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field">
                        <input id="txtDireccionAlmacen" name="txtDireccionAlmacen" type="text" placeholder="Ingrese direcci&oacute;n" />
                        <label for="txtDireccionAlmacen"><?php $translate->__('Direcci&oacute;n'); ?></label>
                    </div>
                </div>
                <div class="row">
                    <p>
                        <input type="checkbox" class="filled-in" id="chkDefaultAlmacen" name="chkDefaultAlmacen" value="1" />
                        <label for="chkDefaultAlmacen"><?php $translate->__('Almacen por defecto'); ?></label>
                    </p>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnAplicarAlmacen" type="button" class="mdl-button mdl-js-button waves-effect mdl-button--primary right">
                Guardar
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
                        <label class="active" for="ddlPresentacion">Presentaci&oacute;n</label>
                        <select name="ddlPresentacion" id="ddlPresentacion" class="browser-default" style="width:100%;">
                            <option value="0"><?php $translate->__('No existen presentaciones registradas'); ?></option>
                        </select>
                </div>
                <!-- <div class="row">
                    <div class="input-field full-size">
                        <select id="ddlUnidadMedida" name="ddlUnidadMedida" class="browser-default" style="width:100%;">
                            <option value="0"><?php $translate->__('No existen unidades de medida registradas'); ?></option>
                        </select>
                        <label class="active" for="ddlUnidadMedida">Unidad de medida</label>
                    </div>
                </div> -->
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-field text full-size">
                            <input id="txtMedida" name="txtMedida" type="text" value="0" class="validate aling-right">
                            <label for="txtMedida">Equivalencia</label>
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
    <div id="modalReporteKardex" class="hide">
        <div class="scrollbarra padding20">
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">PERÍODO:</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">RUC:</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">APELLIDOS Y NOMBRES, DENOMINACIÓN O RAZÓN SOCIAL:</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">ESTABLECIMIENTO (1):</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">CÓDIGO DE LA EXISTENCIA:</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">TIPO (TABLA 5):</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">DESCRIPCIÓN:</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">CÓDIGO DE LA UNIDAD DE MEDIDA (TABLA 6):</h5>
                </div>
            </div>
            <div class="row">
                <div class="input-field">
                    <h5 class="no-margin">MÉTODO DE VALUACIÓN:</h5>
                </div>
            </div>
        </div>
    </div>
    <div id="modalChangeCost" class="modaluno modal-example-content modal-half">
        <input type="hidden" id="hdIdInsumo" name="hdIdInsumo" value="0">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title"><?php $translate->__('Cambio de costo de insumo en recetas'); ?></span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="padding20">
                <div class="row">
                    <ul id="pnlInfoInsumo" class="pnlInfoProveedor demo-list-two mdl-list no-padding no-margin mdl-shadow--2dp">
                        <li class="mdl-list__item mdl-list__item--two-line">
                            <span class="mdl-list__item-primary-content">
                                <span id="lblInsumo_Costo" class="descripcion"></span>
                                <span id="lblUnidadMedida_Costo" class="mdl-list__item-sub-title"></span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-4 pull-right">
                        <div class="input-field full-size">
                          <input id="txtCostoReceta" name="txtCostoReceta" type="text" class="validate align-right" value="0.00">
                          <label class="active" for="txtCostoReceta"><?php $translate->__('Costo de insumo'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnCambiarCostoInsumo" type="button" class="mdl-button mdl-js-button waves-effect mdl-button--primary right">
                <?php $translate->__('Cambiar costo de insumo'); ?>
            </button>
        </div>
    </div>
    <div id="modalChangeStockMinMax" class="modal-example-content modal-half">
        <div class="modal-example-header no-padding mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title"><?php $translate->__('Cambio de stock de insumos'); ?></span>
                </div>
            </header>
            <div title="<?php $translate->__('Ocultar'); ?>" class="close-dialog mdl-button--icon mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE14C;</i>
                </a>
            </div>
        </div>
        <div class="modal-example-body">
            <div class="scrollbarra padding10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-field full-size">
                          <input id="txtStockMin_Masivo" name="txtStockMin_Masivo" type="text" class="validate align-right" value="0.00">
                          <label class="active" for="txtStockMin_Masivo"><?php $translate->__('Stock m&iacute;nimo'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-field full-size">
                          <input id="txtStockMax_Masivo" name="txtStockMax_Masivo" type="text" class="validate align-right" value="0.00">
                          <label class="active" for="txtStockMax_Masivo"><?php $translate->__('Stock m&aacute;ximo'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnCambiarStockMinMax" type="button" class="mdl-button mdl-js-button waves-effect mdl-button--primary right">
                <?php $translate->__('Cambiar stock de insumos'); ?>
            </button>
        </div>
    </div>
</form>