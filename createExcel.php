<?php 
require_once 'functions/excel.php';
activeErrorReporting();
noCli();
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'functions/conexion.php';
require_once 'functions/getAllListsAndVideos.php';
ini_set('memory_limit','2048M');
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
            ->setCellValue('A1', 'c1')
            ->setCellValue('B1', 'c2')
            ->setCellValue('C1', 'c3')
            ->setCellValue('D1', 'c4')
            ->setCellValue('E1', 'c5')
            ->setCellValue('F1', 'c6')
            ->setCellValue('G1', 'c7')
            ->setCellValue('H1', 'c8')
            ->setCellValue('I1', 'c9')
            ->setCellValue('J1', 'c10')
            ->setCellValue('K1', 'c11')
            ->setCellValue('L1', 'c12')
            ->setCellValue('M1', 'c13')
            ->setCellValue('N1', 'c14')
            ->setCellValue('O1', 'c15')
            ->setCellValue('P1', 'c16')
            ->setCellValue('Q1', 'c17')
            ->setCellValue('R1', 'c18')
            ->setCellValue('S1', 'c19')
            ->setCellValue('T1', 'c20')
            ->setCellValue('U1', 'c21')
            ->setCellValue('V1', 'c22')
            ->setCellValue('W1', 'c23')
            ->setCellValue('X1', 'c24')
            ->setCellValue('Y1', 'c25')
            ->setCellValue('Z1', 'c26')
            ->setCellValue('AA1', 'c27')
            ->setCellValue('AB1', 'c28')
            ->setCellValue('AC1', 'c29')
            ->setCellValue('AD1', 'c30')
            ->setCellValue('AE1', 'c31')
            ->setCellValue('AF1', 'c32')
            ->setCellValue('AG1', 'c33')
            ->setCellValue('AH1', 'c34');

$informe = getAllListsAndVideos();
$i = 2;
while($row = $informe->fetch_array(MYSQLI_ASSOC))
{
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$i", $row['periodo'])
            ->setCellValue("B$i", $row['contador'])
            ->setCellValue("C$i", $row['contador1'])
            ->setCellValue("D$i", $row['fecha'])
            ->setCellValue("E$i", $row['otro'])
            ->setCellValue("F$i", $row['tipo'])
            ->setCellValue("G$i", $row['serie'])
            ->setCellValue("H$i", $row['numero'])
            ->setCellValue("I$i", $row['numero1'])
            ->setCellValue("J$i", $row['doc'])
            ->setCellValue("K$i", $row['documento'])
            ->setCellValue("L$i", $row['cliente'])
            ->setCellValue("M$i", $row['isc'])
            ->setCellValue("N$i", $row['gravado'])
            ->setCellValue("O$i", $row['opeexo'])
            ->setCellValue("P$i", $row['igv'])
            ->setCellValue("Q$i", $row['otroope'])
            ->setCellValue("R$i", $row['opeina'])
            ->setCellValue("S$i", $row['opegra'])
            ->setCellValue("T$i", $row['descue'])
            ->setCellValue("U$i", $row['otros1'])
            ->setCellValue("V$i", $row['otros2'])
            ->setCellValue("W$i", $row['otros3'])
            ->setCellValue("X$i", $row['total'])
            ->setCellValue("Y$i", $row['moneda'])
            ->setCellValue("Z$i", $row['tc'])
            ->setCellValue("AA$i", $row['fecha_referencia'])
            ->setCellValue("AB$i", $row['tip_referencia'])
            ->setCellValue("AC$i", $row['serie_referencia'])
            ->setCellValue("AD$i", $row['nro_referencia'])
            ->setCellValue("AE$i", $row['uno'])
            ->setCellValue("AF$i", $row['dos'])
            ->setCellValue("AG$i", $row['tres'])
            ->setCellValue("AH$i", $row['estado']);
$i++;
}
foreach(range('A','AH') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
$objPHPExcel->getActiveSheet()->setTitle('Informe Libro Ventas');
$objPHPExcel->setActiveSheetIndex(0);
getHeaders();
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;