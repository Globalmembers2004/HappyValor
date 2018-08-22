<?php 
class clsTarjetaPago {
	private $objData;

	function clsTarjetaPago()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $param1, $param2 = '')
	{
		$bd = $this->objData;

		$tabla = 'tm_tarjeta_pago';
		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		$criterio = '';

		if ($tipo === 'L' || $tipo === 'ALL') {
			if ($tipo === 'L')
				$campos = array('tm_idtarjetapago', 'UPPER(tm_nombre) tm_nombre');
			elseif ($tipo === 'ALL')
				$campos = '*';
			
			$condicion = 'Activo = 1';
			
			if ($param1 != '')
				$condicion .= ' AND	 tm_nombre like \'%'.$param1.'%\'';

			$orden = ' tm_nombre DESC ';
		}
		elseif ($tipo === 'O') {			
			$campos = array('tm_idtarjetapago', 'tm_nombre');
			$condicion = 'tm_idtarjetapago = '.$param1;
		}
		$rs = $bd->set_select($campos, $tabla, $condicion, $orden);
		return $rs;
	}

	function ListarVigComision($tipo = "ACTUAL", $fechaini = "", $fechafin = "")
	{
		$bd = $this->objData;

		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		if ($tipo === "ACTUAL"){
			$tabla = "td_vigencia_tarjeta_comision as a INNER JOIN tm_tarjeta_pago as b ON a.tm_idtarjetapago = b.tm_idtarjetapago";
			$campos = "b.tm_idtarjetapago, UPPER(b.tm_nombre) as tm_nombre, a.td_importe";
			$condicion = "(NOW() BETWEEN a.td_fechainicio AND a.td_fechafin) and b.Activo = 1";
			$orden = ' b.tm_nombre DESC ';
		}

		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
}
?>