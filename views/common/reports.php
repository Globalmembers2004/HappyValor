<form id="form1" name="form1" method="post">
    <input type="hidden" name="hdIdEmpresa" id="hdIdEmpresa" value="<?php echo $IdEmpresa; ?>">
    <input type="hidden" name="hdIdCentro" id="hdIdCentro" value="<?php echo $IdCentro; ?>">
	<div class="page-region">
		<div id="pnlReports" class="generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header">
            <header class="gp-header mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <span class="mdl-layout-title">Informes y estad&iacute;sticas</span>
                    <div class="mdl-layout-spacer"></div>
                    <button type="button" class="btnOpciones mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="btnOpciones">
                        <i class="material-icons">&#xE5D4;</i>
                    </button>
                </div>
            </header>
            <!-- <ul id="mnuOpcionesMenu" class="mnuOpciones dropdown">
                <li><a href="#" data-action="select-all">Seleccionar todo</a></li>
                <li><a href="#" data-action="unselect-all" class="hide">Quitar selecci&oacute;n</a></li>
                <li><a href="#" data-action="close" class="close-inner-window waves-effect">Cerrar</a></li>
            </ul> -->
            <div class="control-inner-app mdl-layout__drawer-button">
                <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons">&#xE5D2;</i>
                </a>
            </div>
            <main class="gp-body pos-rel no-overflow">
                <div id="pnlConsulta" class="generic-panel gp-no-footer mdl-layout mdl-layout--fixed-header mdl-shadow--2dp no-overflow">
                    <header class="gp-header mdl-layout__header white">
                        <div class="mdl-layout__header-row">
                            <span class="mdl-layout-title row no-margin grey-text text-darken-1">Ventas SUNAT</span>
                            <div class="mdl-layout-spacer"></div>
                        </div>
                    </header>
                    <div id="btnShowFilter" class="mdl-layout__drawer-button">
                        <a class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon black-text">
                            <i class="material-icons">&#xE152;</i>
                        </a>
                    </div>
                    <main class="gp-body">
                        <div id="gvVenta" class="page gridview pos-rel padding20 scrollbarra" data-selected="none" data-multiselect="false">
                            <table class="table_normie mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="3">N&Uacute;MERO CORRELATIVO DEL REGISTRO &Uacute;NICO O C&Oacute;DIGO &Uacute;NICO DE LA OPERACIÓN</th>
                                        <th class="text-center" rowspan="3">FECHA DE EMISIÓN DEL COMPROBANTE DE PAGO O DOCUMENTO</th>
                                        <th class="text-center" rowspan="3">FECHA DE EMISI&Oacute;N DE VENCIMIENTO Y/O PAGO</th>
                                        <th class="text-center" colspan="3" rowspan="2">COMPROBANTE DE PAGO O DOCUMENTO </th>
                                        <th class="text-center" colspan="3">INFORMACI&Oacute;N DEL CLIENTE </th>
                                        <th class="text-center" rowspan="3">VALOR FACTURADO DE LA EXPORTACI&Oacute;N </th>
                                        <th class="text-center" rowspan="3">BASE IMPONIBLE DE LA OPERACI&Oacute;N GRAVADA </th>
                                        <th class="text-center" colspan="2" rowspan="2">IMPORTE TOTAL DE LA OPERACI&Oacute;N EXONERADA O INAFECTA </th>
                                        <th class="text-center" rowspan="3">ISC</th>
                                        <th class="text-center" rowspan="3">IGV Y/O IPM</th>
                                        <th class="text-center" rowspan="3">OTROS TRIBUTOS Y CARGOS QUE NO FORMAN PARTE DE LA BASE IMPONIBLE </th>
                                        <th class="text-center" rowspan="3"> IMPORTE TOTAL DEL COMPROBANTE DE PAGO</th>
                                        <th class="text-center" rowspan="3">TIPO DE CAMBIO </th>
                                        <th class="text-center" colspan="4" rowspan="2">REFERENCIA DEL COMPROBANTE DE PAGO  O DOCUMENTO ORIGINAL QUE SE MODIFICA</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">DOCUMENTO DE IDENTIDAD </th>
                                        <th rowspan="2">APELLIDOS Y NOMBRES, DENOMINACION O RAZ&Oacute;N SOCIAL </th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">TIPO (TABLA 10) </th>
                                        <th class="text-center">NRO DE SERIE O SERIE DE LA MAQUINA REGISTRADORA</th>
                                        <th class="text-center">NUMERO</th>
                                        <th class="text-center">TIPO</th>
                                        <th class="text-center">NUMERO</th>
                                        <th class="text-center">EXONERADA</th>
                                        <th class="text-center">INAFECTA</th>
                                        <th class="text-center">FECHA</th>
                                        <th class="text-center">TIPO</th>
                                        <th class="text-center">SERIE</th>
                                        <th class="text-center">N&ordm; DEL COMPROBANTE DE PAGO O DOCUMENTO </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="gvCompra" class="page gridview pos-rel padding20 scrollbarra hide" data-selected="none" data-multiselect="false">
                            <table class="table_normie mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th rowspan="3" class="text-center">N&Uacute;MERO CORRELATIVO DEL REGISTRO O C&Oacute;DIGO UNICO DE LA OPERACI&Oacute;N</th>
                                        <th rowspan="3" class="text-center"> FECHA DE EMISI&Oacute;N DEL COMPROBANTE DE PAGO  O DOCUMENTO</th>
                                        <th rowspan="3" class="text-center">FECHA  DE VENCIMIENTO O FECHA DE PAGO (1)</th>
                                        <th colspan="3" rowspan="2" class="text-center">COMPROBANTE DE PAGO O DOCUMENTO</th>
                                        <th rowspan="3" class="text-center">N&deg; DEL COMPROBANTE DE PAGO, DOCUMENTO, N&deg; DE ORDEN DEL FORMULARIO F&Iacute;SICO O VIRTUAL, N&deg; DE DUA, DSI O LIQUIDACI&Oacute;N DE COBRANZA U OTROS DOCUMENTOS EMITIDOS POR SUNAT PARA ACREDITAR EL CR&Eacute;DITO FISCAL EN LA IMPORTACI&Oacute;N</th>
                                        <th colspan="3" class="text-center">INFORMACI&Oacute;N DEL PROVEEDOR</th>
                                        <th colspan="6" class="text-center">ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES</th>
                                        <th rowspan="3" class="text-center">VALOR DE LAS ADQUISICIONES NO GRAVADAS</th>
                                        <th rowspan="3" class="text-center">ISC</th>
                                        <th rowspan="3" class="text-center">OTROS TRIBUTOS Y CARGOS</th>
                                        <th rowspan="3" class="text-center">IMPORTE TOTAL</th>
                                        <th rowspan="3" class="text-center">N&deg; DE COMPROBANTE DE PAGO  EMITIDO POR SUJETO NO DOMICILIADO (2)</th>
                                        <th colspan="2" rowspan="2" class="text-center">CONSTANCIA DE DEP&Oacute;SITO DE DETRACCI&Oacute;N (3)</th>
                                        <th rowspan="3" class="text-center">TIPO DE CAMBIO</th>
                                        <th colspan="4" rowspan="2" class="text-center">REFERENCIA DEL COMPROBANTE DE PAGO O DOCUMENTO ORIGINAL QUE SE MODIFICA</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="text-center">DOCUMENTO DE IDENTIDAD</th>
                                        <th rowspan="2" class="text-center">APELLIDOS Y NOMBRES, DENOMINACI&Oacute;N O RAZ&Oacute;N SOCIAL</th>
                                        <th colspan="2" class="text-center"> GRAVADAS Y/O DE EXPORTACI&Oacute;N</th>
                                        <th colspan="2" class="text-center">GRAVADAS Y/O DE EXPORTACI&Oacute;N Y A OPERACIONES NO GRAVADAS</th>
                                        <th colspan="2" class="text-center">NO GRAVADAS</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">TIPO  (TABLA 10)</th>
                                        <th class="text-center">SERIE O C&Oacute;DIGO DE LA DEPENDENCIA ADUANERA  (TABLA 11)</th>
                                        <th class="text-center"> A&Ntilde;O DE EMISI&Oacute;N DE LA DUA O DSI</th>
                                        <th class="text-center">TIPO (TABLA 2)</th>
                                        <th class="text-center">N&Uacute;MERO</th>
                                        <th class="text-center">BASE IMPONIBLE</th>
                                        <th class="text-center">IGV</th>
                                        <th class="text-center">BASE IMPONIBLE</th>
                                        <th class="text-center">IGV</th>
                                        <th class="text-center">BASE IMPONIBLE</th>
                                        <th class="text-center">IGV</th>
                                        <th class="text-center">N&Uacute;MERO</th>
                                        <th class="text-center"> FECHA DE   EMISI&Oacute;N</th>
                                        <th class="text-center">FECHA</th>
                                        <th class="text-center">TIPO (TABLA 10)</th>
                                        <th class="text-center">SERIE</th>
                                        <th class="text-center">N&deg; DEL COMPROBANTE DE PAGO O DOCUMENTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="gvCaja" class="page hide scrollbarra">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="gvCaja_Cuadre" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false">
                                        <table class="table_normie mdl-shadow--2dp">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">CUADRE DE CAJA</th>
                                                    <th class="text-center">IMPORTE</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="gvCaja_Efectivo" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false">
                                        <table class="table_normie mdl-shadow--2dp">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">EFECTIVO EN CAJA</th>
                                                    <th class="text-center">IMPORTE</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="gvCaja_Impuesto" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false">
                                        <table class="table_normie mdl-shadow--2dp">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">IMPUESTO POR VENTAS</th>
                                                    <th class="text-center">IMPORTE</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="gvCaja_DetalleVenta" class="gridview pos-rel padding20" data-selected="none" data-multiselect="false">
                                        <table class="table_normie mdl-shadow--2dp">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">DOCUMENTO</th>
                                                    <th class="text-center">BRUTO</th>
                                                    <th class="text-center">DSCTO</th>
                                                    <th class="text-center">SUB TOTAL</th>
                                                    <th class="text-center">IMPUESTO</th>
                                                    <th class="text-center">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <h4 id="lblTotalDetalleVenta" class="text-right"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="gvEstadisticaVentas" class="page gridview pos-rel padding20 scrollbarra hide" data-selected="none" data-multiselect="false">
                            <table class="table_normie mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th class="text-center">PRODUCTO</th>
                                        <th class="text-center">CANTIDAD</th>
                                        <th class="text-center">PRECIO</th>
                                        <th class="text-center">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="gvRentabilidad" class="page gridview pos-rel padding20 scrollbarra hide" data-selected="none" data-multiselect="false">
                            <table class="table_normie mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th class="text-center">PRODUCTO</th>
                                        <th class="text-center">COSTO</th>
                                        <th class="text-center">PRECIO VENTA</th>
                                        <th class="text-center">MARGEN DE GANANCIA</th>
                                        <th class="text-center">%</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div id="gvControlStock" class="page gridview pos-rel padding20 scrollbarra hide" data-selected="none" data-multiselect="false">
                            <table class="table_normie mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th class="text-center">INSUMO</th>
                                        <th class="text-center">UNIDAD DE MEDIDA</th>
                                        <th class="text-center"> STOCK ALMACEN</th>
                                        <th class="text-center">STOCK PROGRAMADO</th>
                                        <th class="text-center">DIFERENCIA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="gvControlStockMinimo" class="page gridview pos-rel padding20 scrollbarra hide" data-selected="none" data-multiselect="false">
                            <table class="table_normie mdl-shadow--2dp">
                                <thead>
                                    <tr>
                                        <th class="text-center">INSUMO</th>
                                        <th class="text-center">UNIDAD DE MEDIDA</th>
                                        <th class="text-center"> STOCK ALMACEN</th>
                                        <th class="text-center">STOCK MINIMO</th>
                                        <th class="text-center">DIFERENCIA</th>
                                        <th class="text-center">PORCENTAJE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </main>
                    <div id="pnlFiltro" class="slide-panel white mdl-shadow--4dp place-top-bottom-left col-md-4 no-padding" style="display: none;">
                        <div class="generic-panel">
                            <div class="gp-header">
                                <h4 class="margin30">Filtros de b&uacute;squeda</h4>
                                <div class="place-top-right padding20">
                                  <button type="button" id="btnCloseFilter" data-toggle="tooltip" data-placement="left" title="Cerrar" class="btn orange white-text no-border"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="gp-body">
                                <div class="scrollbarra padding10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-field">
                                                <select name="ddlCentro" id="ddlCentro" class="browser-default">
                                                </select>
                                                <label class="active" for="ddlCentro">Sedes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row rowFilterPeriod_Ini">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Periodo de inicio</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-field">
                                                    <select name="ddlAnhoIni" id="ddlAnhoIni" class="browser-default">
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                    </select>
                                                    <label class="active" for="ddlAnhoIni">A&ntilde;o</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-field">
                                                    <select name="ddlMesIni" id="ddlMesIni" class="browser-default">
                                                        <?php ListarMeses(); ?>
                                                    </select>
                                                    <label class="active" for="ddlMesIni">Mes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row rowFilterPeriod_Fin">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Periodo de fin</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-field">
                                                    <select name="ddlAnhoFin" id="ddlAnhoFin" class="browser-default">
                                                        <option value="2017">2017</option>
                                                        <option value="2016">2016</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                    </select>
                                                    <label class="active" for="ddlAnhoFin">A&ntilde;o</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-field">
                                                    <select name="ddlMesFin" id="ddlMesFin" class="browser-default">
                                                        <?php ListarMeses(); ?>
                                                    </select>
                                                    <label class="active" for="ddlMesFin">Mes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row rowFilterPeriod hide">
                                        <div class="col-md-6">
                                            <div class="input-field">
                                                <select name="ddlAnho" id="ddlAnho" class="browser-default">
                                                    <option value="2017">2017</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2013">2013</option>
                                                </select>
                                                <label class="active" for="ddlAnho">A&ntilde;o</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-field">
                                                <select name="ddlMes" id="ddlMes" class="browser-default">
                                                    <?php ListarMeses(); ?>
                                                </select>
                                                <label class="active" for="ddlMes">Mes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row rowFilterCaja hide">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="txtFecha" class="control-label">Fecha de b&uacute;squeda</label>
                                                <div class="input-group date date-register" data-provide="datepicker">
                                                    <input type="text" name="txtFecha" id="txtFecha" class="form-control" value="<?php echo date('d/m/Y'); ?>" />
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rowFechas" class="row rowFilterVenta hide">
                                        <div class="col-md-6 center-block no-float">
                                            <div class="form-group">
                                                <label class="control-label">Desde el</label>
                                                <div id="fechaIni_Caja" class="input-group date date-register" data-provide="datepicker">
                                                    <input type="text" name="txtFechaIni_Caja" id="txtFechaIni_Caja" class="form-control" value="<?php echo date('d/m/Y'); ?>" />
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                                <div id="fechaIni_Control" class="input-group date date-register hide" data-provide="datepicker">
                                                    <input type="text" name="txtFechaIni" id="txtFechaIni" class="form-control" value="<?php echo date('d/m/Y'); ?>" />
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 center-block no-float">
                                            <div class="form-group">
                                                <label for="txtFechaFin" class="control-label">Hasta el</label>
                                                <div class="input-group date date-register" data-provide="datepicker">
                                                    <input type="text" name="txtFechaFin" id="txtFechaFin" class="form-control" value="<?php echo date('d/m/Y'); ?>" />
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rowCliente" class="row rowFilterVenta hide">
                                        <div class="col-md-12">
                                            <label for="txtSearchCliente"><?php $translate->__('Cliente'); ?></label>
                                            <input type="text" name="txtSearchCliente" id="txtSearchCliente" class="full-size" style="width: 100%;" />
                                        </div>
                                    </div>
                                    <div id="rowProveedor" class="row rowFilterVenta hide">
                                        <div class="col-md-12">
                                            <label for="txtSearchProveedor"><?php $translate->__('Proveedor'); ?></label>
                                            <input type="text" name="txtSearchProveedor" id="txtSearchProveedor" class="full-size" style="width: 100%;" />
                                        </div>
                                    </div>
                                    <div id="rowTipoProducto" class="row rowFilterVenta hide">
                                        <div class="col-md-12">
                                            <div class="input-field">
                                                <select name="ddlTipoProducto" id="ddlTipoProducto" class="browser-default">
                                                    <option value="-1">TODOS</option>
                                                    <option value="1">CON RECETA</option>
                                                    <option value="0">SIN RECETA</option>
                                                </select>
                                                <label class="active" for="ddlTipoProducto">Tipo de articulo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rowCategoria" class="row hide">
                                        <div class="col-md-12">
                                            <div class="input-field">
                                                <select name="ddlCategoria" id="ddlCategoria" class="browser-default">
                                                </select>
                                                <label class="active" for="ddlCategoria">Categor&iacute;a</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rowOrdenValor" class="row rowFilterVenta hide">
                                        <div class="col-md-6">
                                            <div class="input-field">
                                                <select name="ddlOrdenValor" id="ddlOrdenValor" class="browser-default">
                                                    <option value="1">SOLES</option>
                                                    <option value="2">PORCENTUAL</option>
                                                </select>
                                                <label class="active" for="ddlOrdenValor">Ordenar por valor</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="rowOrden" class="row rowFilterVenta hide">
                                        <div class="col-md-6">
                                            <div class="input-field">
                                                <select name="ddlOrden" id="ddlOrden" class="browser-default">
                                                    <option value="1">DE MAYOR A MENOR</option>
                                                    <option value="2">DE MENOR A MAYOR</option>
                                                </select>
                                                <label class="active" for="ddlOrden">Orden</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 hide">
                                            <div class="input-field">
                                                <input id="txtLimiteRegistros" name="txtLimiteRegistros" type="text" class="text-right only-numbers" value="0" />
                                                <label for="txtLimiteRegistros"><?php $translate->__('Primeros...'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="gp-footer padding20">
                                <div class="col-md-6">
                                    <button id="btnConsultarReporte" type="button" class="btn btn-primary waves-effect"><i class="fa fa-search" aria-hidden="true"></i> Consultar</button>
                                </div>
                                <div class="col-md-6">
                                    <button id="btnExportarReporte" type="button" class="btn btn-primary waves-effect"><i class="fa fa-download" aria-hidden="true"></i> Exportar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-overlay hide" data-referer="#pnlFiltro"></div>
                </div>
            </main>
        </div>
	</div>
</form>