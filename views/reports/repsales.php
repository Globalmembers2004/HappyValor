<?php
include('bussiness/tabla.php');
include('bussiness/ventas.php');

$IdEmpresa = 1;
$IdCentro = 1;
$Id = 0;
$Codigo = '';
$Nombre = '';
$IdCargo = 0;
$IdSubCategoria = 0;
$counterCategoria = 0;
$counterProducto = 0;
$counterValidItems = 0;

$counterTarjeta = 0;
$counterMoneda = 0;
$counterTipoComprobante = 0;

$strListItems = '';
$strListDelete = '';
$strListValids = '';
$validItems = false;
$arrayValid = array();
$arrayDelete = array();

$objTabla = new clsTabla();

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$fechaini = isset($_GET['fechaini']) ? $_GET['fechaini'] : date("Y-m-d h:i:s");
$fechafin = isset($_GET['fechafin']) ? $_GET['fechafin'] : date("Y-m-d h:i:s");
$criterio = trim(strip_tags($_GET['criterio'])); 
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsVenta();
$row = $objData->Listar($tipobusqueda, $id, $fechaini, $fechafin, $criterio, $pagina);
$countrow = count($row);
?>
<form id="form1" name="form1" method="post">
    <input type="hidden" id="fnPost" name="fnPost" value="fnPost" />
    <input type="hidden" id="hdPageActual" name="hdPageActual" value="1" />
    <input type="hidden" id="hdPage" name="hdPage" value="1" />
    <input type="hidden" id="hdIdPrimary" name="hdIdPrimary" value="0">
    <input type="hidden" id="hdFoto" name="hdFoto" value="no-set">
    <div class="page-region">
        <div id="pnlDatos" class="inner-page with-panel-search">
        	<div class="panel-search">
                <table class="tabla-normal">
                    <tr>
                        <td>
                            <h4>Filtros:</h4>
                        </td>
                        <td style="width:45px;">
                            <button id="btnFilter" type="button" title="<?php $translate->__('M&aacute;s filtros'); ?>" style="margin-left:10px; margin-bottom:0px;"><i class="icon-filter"></i></button>
                        </td>
                    </tr>
                </table>
            </div>
        	<div class="divload">
        		<div style="padding: 10px; height: 100%;">
		            <div id="tableDatos" class="itables">
					    <div class="ihead">
					        <table>
					            <thead>
					                <tr>
					                    <th>#</th>
										<th>C&oacute;digo</th>
										<th>Fecha</th>
										<th>Cliente</th>
										<th>Monto</th>
					                </tr>
					            </thead>
					        </table>
					    </div>
					    <div class="ibody">
					        <div class="ibody-content">
					            <table style="font-size: 12pt;">
					                <tbody>
					                	<?php
										if ($countrow > 0):
											for($i=0;$i < $countrow; $i++):
										?>
										<tr>
											<td class="align-right"><?php echo ($i + 1); ?></td>
											<td class="align-center"><?php echo $row[$i]['tm_vserie_documento'] .'-'. $row[$i]['tm_vnumero_documento']; ?></td>
											<td class="align-center"><?php echo date('d/m/Y', strtotime($row[$i]['tm_fecha_emision'])); ?></td>
											<td><?php echo $row[$i]['Cliente']; ?></td>
											<td class="align-right"><?php echo $row[$i]['SimboloMoneda'].' '.number_format((float)$row[$i]['tm_total'], 2, '.', ''); ?></td>
										</tr>
										<?php
											endfor;
										endif;
										?>
					                </tbody>
					            </table>
					        </div>
					    </div>
					</div>
				</div>
			</div>
        </div>
    </div>
    <div id="pnlOptFiltros" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a id="btnHideFilter" href="#" title="<?php $translate->__('Ocultar'); ?>"><i class="icon-cancel fg-darker smaller"></i></a>
                Filtros de b&uacute;squeda
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid">
                <div class="row">
                    <div class="input-control checkbox" data-role="input-control">
                        <label>
                            <input id="chkSinFiltro" name="chkSinFiltro" type="checkbox">
                            <span class="check"></span>
                            Sin filtros
                        </label>
                    </div>
                </div>
                <div id="pnlRangoFechas" class="row">
                    <label>Rango de fechas</label>
                    <div class="grid fluid no-margin no-padding">
                        <div class="row">
                            <div class="span6">
                                <div class="input-control text" data-role="datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-format="dd/mm/yyyy" data-effect="fade">
                                    <input id="txtFechaIni" name="txtFechaIni" type="text" />
                                    <button type="button" class="btn-date"></button>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="input-control text" data-role="datepicker" data-date="<?php echo date('Y-m-d'); ?>" data-format="dd/mm/yyyy" data-effect="fade">
                                    <input id="txtFechaFin" name="txtFechaFin" type="text" />
                                    <button type="button" class="btn-date"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-bloqueo oculto"></div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <div class="grid fluid">
                <div class="row">
                    <div class="span6">
                        <button id="btnAplicarFiltros" type="button" class="command-button success">Aplicar filtros</button>
                    </div>
                    <div class="span6">
                        <button id="btnDefaultFilter" type="button" class="command-button default">Valores por defecto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pnlExport" class="modal-dialog modal-example-content">
        <div class="modal-example-header">
            <h2 class="no-margin b-hide">
                <a href="#" title="<?php $translate->__('Ocultar'); ?>" class="close-modal-example"><i class="icon-cancel fg-darker smaller"></i></a>
                Elegir formato...
            </h2>
        </div>
        <div class="modal-example-body">
            <div class="grid fluid">
                <div class="row">
                	<div id="pnlOptionsExport" class="special-tab">
                        <ul class="menu">
                            <li>
                                <a data-export="excel">
                                	<img src="images/excel-export.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a data-export="pdf">
                                	<img src="images/pdf-export.png" alt="" />
                                </a>
                            </li>
                            <li>
                                <a data-export="pdf">
                                	<img src="images/word-export.png" alt="" />
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-example-footer">
            <button id="btnExportarDatos" type="button" class="command-button success">Exportar</button>
        </div>
    </div>
    <div class="appbar">
    	<button id="btnImprimir" name="btnImprimir" type="button" class="metro_button float-right">
            <span class="content">
                <img src="images/print.png" alt="<?php $translate->__('Imprimir'); ?>" />
                <span class="text"><?php $translate->__('Imprimir'); ?></span>
            </span>
        </button>
        <button id="btnExportar" name="btnExportar" type="button" class="metro_button float-right">
            <span class="content">
                <img src="images/Cloud-download.png" alt="<?php $translate->__('Exportar'); ?>" />
                <span class="text"><?php $translate->__('Exportar'); ?></span>
            </span>
        </button>
        <div class="clear"></div>
    </div>
</form>
<?php
include('common/libraries-js.php');
include('common/validate-js.php');
include('common/bootstrap-js.php');
?>
<script>
	$(function  () {
		$('#btnExportar').on('click', function(event) {
			event.preventDefault();
			openCustomModal('#pnlExport');
		});

		$('#btnHidePnlExport').on('click', function(event) {
			event.preventDefault();
			closeCustomModal('#pnlExport');
		});

        $('#btnFilter').on('click', function(event) {
            event.preventDefault();
            openCustomModal('#pnlOptFiltros');
        });

        $('#chkSinFiltro').on('click', function(event) {
            habilitarDiv('#pnlRangoFechas', $(this)[0].checked);
            habilitarControl('#txtFechaIni, #txtFechaFin', !$(this)[0].checked);
        });

        $('#btnHideFilter').on('click', function(event) {
            event.preventDefault();
            closeCustomModal('#pnlOptFiltros');
        });

        $('#btnAplicarFiltros').on('click', function(event) {
            event.preventDefault();
            closeCustomModal('#pnlOptFiltros');
        });

		setSpecialTab('#pnlOptionsExport', function () {
            
        });
	})
</script>