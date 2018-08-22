<?php
class clsAreaVenta
{
	function clsAreaVenta()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $param1 = '', $param2 = '')
	{
		$bd = $this->objData;
		$tabla = "tm_area_venta";

		if ($tipo == "L" || $tipo == "ALL")
		{
			if ($tipo == "L")
				$campos = array("tm_idareaVenta", "UPPER(tm_nombreAreaVenta) tm_nombreAreaVenta", "tm_idempresa", "tm_idcentro","tm_idServicio");
			else if ($tipo == "ALL")
				$campos = "*";
			
			$condicion = "Activo = 1 ";//tm_nombre like '%$param1%'";
			$orden = " tm_nombreAreaVenta ";
		}
		else if ($tipo == "O")
		{			
			$campos = "*";
			$condicion = "tm_idareaVenta = $param1";
                        $orden = false;
		}
		$rs = $bd->set_select($campos, $tabla, $condicion,$orden);
		return $rs;
	}
}
?>