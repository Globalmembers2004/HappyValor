<?php
class clsenlace {

	private $objData;
	
	function clsenlace(){
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_enlace_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Registrar($idenlace, $idempresa, $idcentro, $idcencosto, $idtipofamilia, $idctactb, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_enlace_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idenlace, $idempresa, $idcentro, $idcencosto, $idtipofamilia, $idctactb, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_enlace_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>