<?php 
require_once 'functions/excel1.php';
activeErrorReporting();
noCli();
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'functions/conexion.php';
require_once 'functions/getVentas.php';
ini_set('memory_limit','512M');
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Luis Monroy")
               ->setLastModifiedBy("Global Members SAC")
               ->setTitle("Office 2007 XLSX Test Document")
               ->setSubject("Office 2007 XLSX Test Document")
               ->setDescription("Test document for Office 2007 XLSX")
               ->setKeywords("office 2007 openxml php")
               ->setCategory("Test result file");
               
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);         
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Cuenta')
            ->setCellValue('B1', 'Periodo')
            ->setCellValue('C1', 'Subdiario')
            ->setCellValue('D1', 'Comprobante')
            ->setCellValue('E1', 'Fecha_registro')
            ->setCellValue('F1', 'Tipo_anexo')
            ->setCellValue('G1', 'Código_Cliente')
            ->setCellValue('H1', 'Tipo_Documento')
            ->setCellValue('I1', 'Nro_Documento')
            ->setCellValue('J1', 'Nro_Documento_Final')
            ->setCellValue('K1', 'Fecha_Documento')
            ->setCellValue('L1', 'Tipo_Doc_Ref')
            ->setCellValue('M1', 'Nro_Doc_Ref')
            ->setCellValue('N1', 'IGV')
            ->setCellValue('O1', 'ISV')
            ->setCellValue('P1', 'Otros_Trib')
            ->setCellValue('Q1', 'Tasa_IGV')
            ->setCellValue('R1', 'Importe')
            ->setCellValue('S1', 'Conv_TC')
            ->setCellValue('T1', 'TC')
            ->setCellValue('U1', 'Glosa')
            ->setCellValue('V1', 'Glosa_Mov')
            ->setCellValue('W1', 'Anulado')
            ->setCellValue('X1', 'DH')
            ->setCellValue('Y1', 'RUC_Cliente')
            ->setCellValue('Z1', 'Razon_Social')
            ->setCellValue('AA1', 'Centro_costo')
            ->setCellValue('AB1', 'Fecha_Venc')
            ->setCellValue('AC1', 'Fecha_Doc_ref')
            ->setCellValue('AD1', 'Exportacion')
            ->setCellValue('AE1', 'Nro_File')
            ->setCellValue('AF1', 'Exonerado')
            ->setCellValue('AG1', 'Otros_cargos');

$informe = getVentas();
$i = 2;
while($row = $informe->fetch_array(MYSQLI_ASSOC))
{
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $row['cuenta'])
            ->setCellValue("B$i", $row['annomes'])
            ->setCellValue("C$i", $row['subdiario'])
            ->setCellValue("D$i", $row['comprobante'])
            ->setCellValue("E$i", $row['fecha_registro'])
            ->setCellValue("F$i", $row['tipo_anexo'])
            ->setCellValue("G$i", $row['cod_cliente'])
            ->setCellValue("H$i", $row['tipo_doc'])
            ->setCellValue("I$i", $row['nro_doc'])
            ->setCellValue("J$i", $row['nro_doc_final'])
            ->setCellValue("K$i", $row['fecha_doc'])
            ->setCellValue("L$i", $row['tipo_doc_ref'])
            ->setCellValue("M$i", $row['nro_doc_ref'])
            ->setCellValue("N$i", $row['igv'])
            ->setCellValue("O$i", $row['valor_isc'])
            ->setCellValue("P$i", $row['otros_trib'])
            ->setCellValue("Q$i", $row['tasa_igv'])
            ->setCellValue("R$i", $row['importe'])
            ->setCellValue("S$i", $row['conv_tc'])
            ->setCellValue("T$i", $row['tc'])
            ->setCellValue("U$i", $row['glosa'])
            ->setCellValue("V$i", $row['glosa_mov'])
            ->setCellValue("W$i", $row['anulado'])
            ->setCellValue("X$i", $row['debe_haber'])
            ->setCellValue("Y$i", $row['ruc_cliente'])
            ->setCellValue("Z$i", $row['raz_social'])
            ->setCellValue("AA$i", $row['cen_costo'])
            ->setCellValue("AB$i", $row['fec_vencimiento'])
            ->setCellValue("AC$i", $row['fec_doc_ref'])
            ->setCellValue("AD$i", $row['exportacion'])
            ->setCellValue("AE$i", $row['nro_file'])
            ->setCellValue("AF$i", $row['exonerado'])
            ->setCellValue("AG$i", $row['otr_cargos']);
$i++;
}
foreach(range('A','AG') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
$objPHPExcel->getActiveSheet()->setTitle('Informe Ventas');
$objPHPExcel->setActiveSheetIndex(0);
getHeaders();
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;