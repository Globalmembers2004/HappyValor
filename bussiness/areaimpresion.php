<?php
class clsAreaImpresion
{
	function clsAreaImpresion()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $param1 = '', $param2 = '')
	{
		$bd = $this->objData;
		$tabla = "tm_area_impresion";

		if ($tipo == "L" || $tipo == "ALL")
		{
			if ($tipo == "L")
				$campos = array("tm_idareaimpresion","tm_codigo","tm_descripcion","UPPER(tm_nombreareaimpresion) tm_nombreareaimpresion", "tm_idempresa", "tm_idcentro");
			else if ($tipo == "ALL")
				$campos = "*";
			
			$condicion = "Activo = 1 ";//tm_nombre like '%$param1%'";
			$orden = " tm_nombreareaimpresion ";
		}
		else if ($tipo == "O")
		{			
			$campos = "*";
			$condicion = "tm_idareaimpresion = $param1";
                        $orden = false;
		}
		$rs = $bd->set_select($campos, $tabla, $condicion,$orden);
		return $rs;
	}
}
?>