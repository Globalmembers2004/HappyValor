<?php
class clsComet {
	private $objData;
	
	function clsComet(){
		$this->objData = new Db();
	}

	function ConsultarUltimoRegistro(){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_fechareg_orden_pedido','');
		return $rs;
	}
}
?>