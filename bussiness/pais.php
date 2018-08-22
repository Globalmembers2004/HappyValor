<?php
class clsPais {
	private $objData;
	
	function clsPais(){
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $codigo, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_pais_listar', array($tipo, $id, $codigo, $criterio));
		return $rs;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tp_pais', "tp_idpais IN ($listIds)");
		return $rpta;
	}
}
?>