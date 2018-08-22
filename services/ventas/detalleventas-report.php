<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/ventas.php';
require '../../common/functions.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
// $id = isset($_GET['id']) ? $_GET['id'] : '0';
$fechaini = isset($_GET['fechaini']) ? fecha_mysql($_GET['fechaini']) : date("Y-m-d h:i:s");
$fechafin = isset($_GET['fechafin']) ? fecha_mysql($_GET['fechafin']) : date("Y-m-d h:i:s");

$isexport = isset($_GET['isexport']) ? $_GET['isexport'] : '1';

$objData = new clsVenta();
$row = $objData->DetalleVenta_Reporte($IdEmpresa, $IdCentro, $fechaini, $fechafin);

if ($isexport == '1') {
	require('../../common/PHPExcel.php');
    require('../../common/PHPExcel/Writer/Excel2007.php');
    require_once '../../common/PHPExcel/IOFactory.php';

    $folderXLS = '../../media/xls/';

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);

    $nameFileExport = $folderXLS.$IdEmpresa.date('Ymd').generateRandomString().'.xls';

    $tituloreporte = 'REPORTE DE VENTAS';
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', $tituloreporte);

     $countrow = count($row);
	    
	if ($countrow > 0) {
    	$counterColXLS = 0;
    	$columns = array_keys($row[0]);
		
		foreach ($columns as $key => $value) {
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($counterColXLS, 2, $value);

			++$counterColXLS;
		}

		$i = 0;

	    while ($i < $countrow) {
	    	$counterColXLS = 0;

		    foreach ($columns as $key => $value) {
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($counterColXLS, ($i + 3), $row[$i][$value]);

		    	++$counterColXLS;
		    }

		    ++$i;
		}
	}
    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    // Write the Excel file to filename some_excel_file.xlsx in the current directory
    $objWriter->save($nameFileExport);
    $archivo = 'media/xls/' . $nameFileExport;

    $arrayFile = array('archivo' => $archivo);

    echo json_encode($arrayFile);
}
else
	echo json_encode($row);
flush();
?>