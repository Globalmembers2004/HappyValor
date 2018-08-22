<?php
class clsKardex
{
	private $objData;
	
	function clsKardex()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $tipoexistencia, $idempresa, $idcentro, $idalmacen, $idarticulo, $fechaini, $fechafin, $fecha)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_kardex_listar', array($tipo, $tipoexistencia, $idempresa, $idcentro, $idalmacen, $idarticulo, $fechaini, $fechafin, $fecha));
		return $rs;
	}

	function Generar($tipoexistencia, $idempresa, $idcentro, $anho_periodo, $mes_periodo, $idarticulo, $idusuario)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_kardex_generar', array($tipoexistencia, $idempresa, $idcentro, $anho_periodo, $mes_periodo, $idarticulo, $idusuario));
		return $rs;
	}
}
?>