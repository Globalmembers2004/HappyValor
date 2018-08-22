<?php

	require_once 'functions/conexion.php';

	if (substr($_FILES['excel']['name'],-3)=="csv")
	{
		$fecha		= date("Y-m-d");
		$carpeta 	= "tmp_excel/";
		$nombre 	= "";
		$tm_direccion = "";
		$excel  	= $fecha."-".$_FILES['excel']['name'];

		move_uploaded_file($_FILES['excel']['tmp_name'], "$carpeta$excel");
		
		$elimina="truncate table clientes";

		$mysqli = getConnexion();

		$sql = $mysqli->query($elimina);

		if (!$sql)
		{
			echo "<div>Hubo un problema al momento de truncate por favor vuelva a intentarlo</div >";
			exit;
		}

		$row = 1;

		$fp = fopen ("$carpeta$excel","r"); 

		while ($data = fgetcsv ($fp, 100000, ","))
		{
			if ($row!=1)
			{

				$num = count($data);
				$mysqli = getConnexion();
				$nombre = $data[12];
				$nombre = str_replace("'"," ", $nombre);
				$direccion = $data[18];
				$direccion = str_replace("'"," ", $direccion);
				$insertar="INSERT INTO clientes (tm_codigo, tm_tipo, tm_doc_identidad, tm_ruc, tm_descripcion, tm_tipo_persona, tm_direccion,tm_telefono) VALUES('$data[2]','$data[5]','$data[7]','$data[9]','$nombre','$data[16]','$direccion','$data[23]')";

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

		$eliminar="DELETE FROM clientes where  CAST(tm_codigo AS UNSIGNED) = 0";

		$sql = $mysqli->query($eliminar);

		if (!$sql)
		{
			echo "<div>Hubo un problema al momento de eliminar por favor vuelva a intentarlo</div >";
			exit;
		}

		$actualizar="UPDATE clientes set Activo = 1, tm_codigo = trim(tm_codigo), tm_tipo = trim(tm_tipo), tm_doc_identidad = trim(tm_doc_identidad), tm_ruc = trim(tm_ruc), tm_descripcion = trim(tm_descripcion), tm_tipo_persona = trim(tm_tipo_persona), tm_direccion = trim(tm_direccion)";

		$mysqli = getConnexion();

		$sql = $mysqli->query($actualizar);

		if (!$sql)
		{
			echo "<div>Hubo un problema al momento de actualizar el estado Activo por favor vuelva a intentarlo</div >";
			exit;
		}



		echo "<div>La importacion de archivo subio satisfactoriamente</div >";
		
		exit;

	}

	else
	{
		echo "<p> No es un archivo CSV, vuelva a intentarlo por favor</p>" ; 
		echo "<p><a href=¬\"cliente.html\">Regresar al inicio </a></p>";
	}

?>