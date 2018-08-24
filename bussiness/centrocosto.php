<?php
class clsCentroCosto {
	private $objData;
	
	function clsCentroCosto(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_centrocosto_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idCentroCosto, $idempresa, $idcentro, $centrocosto, $descripcion, $nombre, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_centrocosto_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idCentroCosto, $idempresa, $idcentro, $centrocosto, $descripcion, $nombre, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_centrocosto_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>