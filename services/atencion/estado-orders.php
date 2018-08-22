<?php
	include('../../adata/Db.class.php');
	include('../../bussiness/comet.php');
	$objData = new clsComet();
	set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
	$fecha_ac = isset($_GET['timestamp']) ? strtotime($_GET['timestamp']):0;
	$fecha_bd = isset($row_fecha[0]['fecha']) ? strtotime($row_fecha[0]['fecha']) : 0;
	while( $fecha_bd <= $fecha_ac ){	
		$ultimo_registro = $objData->ConsultarUltimoRegistro();
	    usleep(100000);//anteriormente 10000
		clearstatcache();
	    $fecha_bd  = strtotime($ultimo_registro[0]['fecha']);
	}
	$row_fecha = $objData->ConsultarUltimoRegistro();
	echo  json_encode($row_fecha);
	flush();
?>