<?php
	//Incluimos librería y archivo de conexión
    require('common/PHPExcel.php');

    // require('common/PHPExcel/Writer/Excel2007.php');

	$con=mysqli_connect("127.0.0.1","root","12345678","happyland");

	$sql = "SELECT 
			periodo,
			contador,
			contador1,
			fecha,
			otro,
			tipo,
			serie,
			numero,
			numero1,
			doc,
			documento,
			cliente,
			isc,
			gravado,
			opeexo,
			igv,
			otroope,
			opeina,
			opegra,
			descue,
			otros1,
			otros2,
			otros3,
			total,
			moneda,
			tc,
			fecha_referencia,
			tip_referencia,
			serie_referencia,
			nro_referencia,
			uno,
			doc,
			tres,
			estado 
			 FROM regventas";
 	$resultado = mysqli_query($con, $sql);
 	
 	$fila = 2; 
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("Happyland")->setDescription("Libro Ventas");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Ventas");

	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'C1');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'C2');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'C3');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'C4');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'C5');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'C6');
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'C7');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'C8');
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'C9');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'C10');
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'C11');
	$objPHPExcel->getActiveSheet()->setCellValue('L1', 'C12');
	$objPHPExcel->getActiveSheet()->setCellValue('M1', 'C13');
	$objPHPExcel->getActiveSheet()->setCellValue('N1', 'C14');
	$objPHPExcel->getActiveSheet()->setCellValue('O1', 'C15');
	$objPHPExcel->getActiveSheet()->setCellValue('P1', 'C16');
	$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'C17');
	$objPHPExcel->getActiveSheet()->setCellValue('R1', 'C18');
	$objPHPExcel->getActiveSheet()->setCellValue('S1', 'C19');
	$objPHPExcel->getActiveSheet()->setCellValue('T1', 'C20');
	$objPHPExcel->getActiveSheet()->setCellValue('U1', 'C21');
	$objPHPExcel->getActiveSheet()->setCellValue('V1', 'C22');
	$objPHPExcel->getActiveSheet()->setCellValue('W1', 'C23');
	$objPHPExcel->getActiveSheet()->setCellValue('X1', 'C24');
	$objPHPExcel->getActiveSheet()->setCellValue('Y1', 'C25');
	$objPHPExcel->getActiveSheet()->setCellValue('Z1', 'C26');
	$objPHPExcel->getActiveSheet()->setCellValue('AA1', 'C27');
	$objPHPExcel->getActiveSheet()->setCellValue('AB1', 'C28');
	$objPHPExcel->getActiveSheet()->setCellValue('AC1', 'C29');
	$objPHPExcel->getActiveSheet()->setCellValue('AD1', 'C30');
	$objPHPExcel->getActiveSheet()->setCellValue('AE1', 'C31');
	$objPHPExcel->getActiveSheet()->setCellValue('AF1', 'C32');
	$objPHPExcel->getActiveSheet()->setCellValue('AG1', 'C33');
	$objPHPExcel->getActiveSheet()->setCellValue('AH1', 'C34');

	while($row = $resultado->fetch_assoc()){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $row['periodo']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $row['contador']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $row['contador1']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $row['fecha']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $row['otro']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $row['tipo']);
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$fila, $row['serie']);
		$objPHPExcel->getActiveSheet()->setCellValue('H'.$fila, $row['numero']);
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$fila, $row['numero1']);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$fila, $row['doc']);
		$objPHPExcel->getActiveSheet()->setCellValue('K'.$fila, $row['documento']);
		$objPHPExcel->getActiveSheet()->setCellValue('L'.$fila, $row['cliente']);
		$objPHPExcel->getActiveSheet()->setCellValue('M'.$fila, $row['isc']);
		$objPHPExcel->getActiveSheet()->setCellValue('N'.$fila, $row['gravado']);
		$objPHPExcel->getActiveSheet()->setCellValue('O'.$fila, $row['opeexo']);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$fila, $row['igv']);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$fila, $row['otroope']);
		$objPHPExcel->getActiveSheet()->setCellValue('R'.$fila, $row['opeina']);
		$objPHPExcel->getActiveSheet()->setCellValue('S'.$fila, $row['opegra']);
		$objPHPExcel->getActiveSheet()->setCellValue('T'.$fila, $row['descue']);
		$objPHPExcel->getActiveSheet()->setCellValue('U'.$fila, $row['otros1']);
		$objPHPExcel->getActiveSheet()->setCellValue('V'.$fila, $row['otros2']);
		$objPHPExcel->getActiveSheet()->setCellValue('W'.$fila, $row['otros3']);
		$objPHPExcel->getActiveSheet()->setCellValue('X'.$fila, $row['total']);
		$objPHPExcel->getActiveSheet()->setCellValue('Y'.$fila, $row['moneda']);
		$objPHPExcel->getActiveSheet()->setCellValue('Z'.$fila, $row['tc']);
		$objPHPExcel->getActiveSheet()->setCellValue('AA'.$fila, $row['fecha_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AB'.$fila, $row['tip_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AC'.$fila, $row['serie_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AD'.$fila, $row['nro_referencia']);
		$objPHPExcel->getActiveSheet()->setCellValue('AE'.$fila, $row['uno']);
		$objPHPExcel->getActiveSheet()->setCellValue('AF'.$fila, $row['dos']);
		$objPHPExcel->getActiveSheet()->setCellValue('AG'.$fila, $row['tres']);
		$objPHPExcel->getActiveSheet()->setCellValue('AH'.$fila, $row['estado']);

		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
		
	header("Content-Type:
	application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment; filename="Libro Ventas.xlsx"');
	header('Cache-control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
	$objWriter->save('php://output');

?>