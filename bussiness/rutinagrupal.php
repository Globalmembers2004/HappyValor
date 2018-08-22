<?php
class clsrutinagrupal {
	private $objData;
	
	function clsrutinagrupal(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rutinagrupal_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idrutinagrupal, $idempresa, $idcentro, $nombre, $minutos, $foto, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_rutinagrupal_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idrutinagrupal, $idempresa, $idcentro, $nombre, $minutos, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_rutinagrupal_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>