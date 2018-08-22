<?php
class clsBanco {
	private $objData;
	
	function clsBanco(){
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_banco_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}
}
?>