<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require('../../common/PHPExcel.php');
    require('../../common/PHPExcel/Writer/Excel2007.php');

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");
    $IdEmpresa = $sesion->get("idempresa");
    // $IdCentro = $sesion->get("idcentro");
    
    $hdTipoReporte = (isset($_POST['hdTipoReporte'])) ? $_POST['hdTipoReporte'] : '';


    // Instantiate a new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set the active Excel worksheet to sheet 0
    $objPHPExcel->setActiveSheetIndex(0);

    $hdIdProyecto = (isset($_POST['hdIdProyecto'])) ? $_POST['hdIdProyecto'] : '0';

    $nameFileExport = '../../media/xls/'.$idusuario.$idperfil.$IdEmpresa.generateRandomString();

	if ($hdTipoReporte == 'control-stock') {
		
		// $ddlAnho = (isset($_POST['ddlAnho'])) ? $_POST['ddlAnho'] : '0';
  //       $ddlMes = (isset($_POST['ddlMes'])) ? $_POST['ddlMes'] : '0';

        $rowCount = 0;
        // Execute the database query
        

        // $objPHPExcel->getActiveSheet()->SetCellValue('A'.($urut + 2), 'IMPORTE TOTAL');
        // $objPHPExcel->getActiveSheet()->SetCellValue('B'.($urut + 2), $totalfacturado);

        // $nameFileExport .= '_'.$ddlAnho.'_'.$ddlMes.'_TF.xlsx';
    }
}
?>