<?php
class clsctactb {
	private $objData;
	
	function clsctactb(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_ctactb_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idctactb, $idempresa, $idcentro, $codigo, $descripcion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_ctactb_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idctactb, $idempresa, $idcentro, $codigo, $descripcion, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_ctactb_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>