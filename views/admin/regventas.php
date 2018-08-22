<?php
	//Incluimos librería y archivo de conexión
	require 'common/PHPExcel.php';
	require 'adata/Db.class.php.php';
	
	//Consulta
	$sql = "SELECT *  FROM regventas";
	$resultado = $mysqli->query($sql);
	$fila = 2; //Establecemos en que fila inciara a imprimir los datos
	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Happyland")->setDescription("Libro Ventas");
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'C1');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'C2');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'C3');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'C4');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(1);
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'C5');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(2);
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'C6');
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
	$objPHPExcel->getActiveSheet()->setCellValue('EG1', 'C7');
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'C8');
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'C9');
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(1);
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'C10');
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'C11');
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(100);
	$objPHPExcel->getActiveSheet()->setCellValue('L1', 'C12');
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('M1', 'C13');
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('N1', 'C14');
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('O1', 'C15');
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('P1', 'C16');
	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'C17');
	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('R1', 'C18');
	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('S1', 'C19');
	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('T1', 'C20');
	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('U1', 'C21');
	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('V1', 'C22');
	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('W1', 'C23');
	$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('X1', 'C24');
	$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'C25');
	$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'C26');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'C27');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'C28');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'C29');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'C30');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'C31');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'C32');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'C33');
	$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'C34');

	while($rows = $resultado->fetch_assoc()){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['periodo']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['contador']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['contador1']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['fecha']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['otro']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['tipo']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $rows['serie']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $rows['numero']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $rows['numero1']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $rows['doc']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $rows['documento']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $rows['cliente']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $rows['isc']);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $rows['gravado']);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $rows['opeexo']);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $rows['igv']);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $rows['otroope']);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila, $rows['opeina']);
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila, $rows['opegra']);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$fila, $rows['descue']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$fila, $rows['otros1']);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$fila, $rows['otros2']);
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$fila, $rows['otros3']);
		$objPHPExcel->getActiveSheet()->setCellValue('X'.$fila, $rows['total']);
		$objPHPExcel->getActiveSheet()->setCellValue('Y'.$fila, $rows['moneda']);
		$objPHPExcel->getActiveSheet()->setCellValue('Z'.$fila, $rows['tc']);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$fila, $rows['fecha_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AB'.$fila, $rows['tip_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AC'.$fila, $rows['serie_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AD'.$fila, $rows['nro_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AE'.$fila, $rows['uno']);
		$objPHPExcel->getActiveSheet()->setCellValue('AF'.$fila, $rows['dos']);
		$objPHPExcel->getActiveSheet()->setCellValue('AG'.$fila, $rows['tres']);
		$objPHPExcel->getActiveSheet()->setCellValue('AH'.$fila, $rows['estado']);

		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
		
	$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="Productos.xlsx"');
	header('Cache-Control: max-age=0');
	
	$writer->save('php://output');
?>