<?php

	require_once 'functions/conexion.php';

	if (substr($_FILES['excel']['name'],-3)=="csv")
	{
		$fecha		= date("Y-m-d");
		$carpeta 	= "tmp_excel/";
		$excel  	= $fecha."-".$_FILES['excel']['name'];

		move_uploaded_file($_FILES['excel']['tmp_name'], "$carpeta$excel");


		$row = 1;

		$fp = fopen ("$carpeta$excel","r"); 

		while ($data = fgetcsv ($fp, 100000, ","))
		{
			if ($row!=1)
			{

				$num = count($data);

				$mysqli = getConnexion();
				$insertar="INSERT INTO origen (tipodoc, folio, rucreceptor, razonsocialreceptor, fechaemision, moneda, igv, isc, operacionesgravadas, operacionesexoneradas, operacionesinafectas, operacionesgratis, descuentoglobal, otroscargos, otrostributos, montototal, estado, url, referencia, Activo) VALUES('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]','$data[14]','$data[15]','$data[16]','$data[17]','$data[18]', 1)";

				$sql = $mysqli->query($insertar);

				if (!$sql)
				{
					echo "<div>Hubo un problema al momento de importar porfavor vuelva a intentarlo</div >";
					exit;
				}

			}

			$row++;

		}

		fclose ($fp);

		$mysqli = getConnexion();
		$actualizar="update origen set rucreceptor = '' where rucreceptor ='-'";

		$sql = $mysqli->query($actualizar);

		if (!$sql)
		{
			echo "<div>Hubo un problema al momento de actualizar por favor vuelva a intentarlo</div >";
			exit;
		}

		echo "<div>La importacion de archivo subio satisfactoriamente</div >";

		exit;

	}

	echo "<div>La importacion de archivo subio satisfactoriamente</div >";

	exit;
?>