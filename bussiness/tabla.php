<?php
class clsTabla
{
	function clsTabla()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $param1, $param2 = '')
	{
		$bd = $this->objData;
		$tabla = '';
		$campos = '';
		$condicion = '';
		$orden = false;
		$limit = false;

		if ($tipo === 'BY-FIELD'){
			$tabla = 'ta_tabla';
			$campos = 'ta_idtabla, ta_campo, ta_codigo, ta_denominacion, ta_colorleyenda';
			$condicion = 'ta_campo = \''.$param1.'\''.$param2;
			$orden = 'ta_codigo';
		}
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}

	function GetSpecificValue($field, $key, $value)
	{
		$bd = $this->objData;
		$specificValue = '';
		$tabla = 'ta_tabla';
		$condicion = ' ta_campo = \''.$key.'\' and ta_codigo = \''.$value.'\'';
		$rs = $bd->set_select($field, $tabla, $condicion);
		$countRs = count($rs);
		if ($countRs > 0)
			$specificValue = $rs[0][$field];
		return $specificValue;
	}

	function ValorPorCampo($campo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_valorporcampo', array($campo));
		return $rs;
	}

	function ValorPorCampo_Ordenado($campo, $campo_orden, $orden)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_valorporcampo_ordenado', array($campo, $campo_orden, $orden));
		return $rs;
	}

	function ValorPorCampo_Codigo($campo, $codigo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_valorporcampo_codigo', array($campo, $codigo));
		return $rs;
	}

	function ValorPorCampo_PorCodigos($campo, $codigos)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tabla_porcodigos', array($campo, $codigos));
		return $rs;
	}
}
?>