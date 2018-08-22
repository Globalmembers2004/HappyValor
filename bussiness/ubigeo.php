<?php
class clsUbigeo {
	private $objData;
	
	function clsUbigeo(){
		$this->objData = new Db();
	}
	
	function Listar($tipo, $id, $idpais, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_ubigeo_listar', array($tipo, $id, $idpais, $criterio));
		return $rs;
	}
}
?>