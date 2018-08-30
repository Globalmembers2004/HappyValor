<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../bussiness/informes.php';
    require('../../common/PHPExcel.php');
    require('../../common/PHPExcel/Writer/Excel2007.php');


    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsInformes();

    $objPHPExcel = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0);

    $nameFileExport = '../../tmp_excel/InformeSuministro.xlsx';


    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $ddlPeriodo1 = (isset($_POST['ddlPeriodo1'])) ? $_POST['ddlPeriodo1'] : 0;
        $ddlPeriodo2 = (isset($_POST['ddlPeriodo2'])) ? $_POST['ddlPeriodo2'] : 0;

        $rowCount = 0;

        $rsInventario = $objData->Listar($ddlPeriodo1, $ddlPeriodo2);

        $countInventario = count($rsInventario);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'PERIODO');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CENTRO DE COSTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TIPO DE FAMILIA');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'FAMILIA');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'PRODUCTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'CANTIDAD');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'COSTO');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'VALOR');

        if ($countInventario > 0) {
            while ($rowCount < $countInventario) {
                $urut = $rowCount + 2;
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $urut, $rsInventario[$rowCount]['periodo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $urut, $rsInventario[$rowCount]['CentroCosto']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $urut, $rsInventario[$rowCount]['TipoFamilia']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $urut, $rsInventario[$rowCount]['Familia']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $urut, $rsInventario[$rowCount]['Producto']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $urut, $rsInventario[$rowCount]['cantidad']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $urut, $rsInventario[$rowCount]['costo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $urut, $rsInventario[$rowCount]['valor']);
                ++$rowCount;
            }
        }

        require_once '../../common/PHPExcel/IOFactory.php';

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save($nameFileExport);

    }  

    elseif (isset($_POST['btnEliminar'])) {
        $hdIdInventario = $_POST['hdIdInventario'];
        $rpta = $objData->EliminarStepByStep($hdIdInventario, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    // $jsondata = array('rpta' => 1, 'titulomsje' => $titulomsje, 'contenidomsje' => "CSV Importado");
    // //$jsondata = array('rpta' => $rpta_im);
    // echo json_encode($jsondata);
}
?>