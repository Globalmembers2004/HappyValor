<?php
class clszonacorporal {
	private $objData;
	
	function clszonacorporal(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_zonacorporal_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idzonacorporal, $idempresa, $idcentro, $nombre, $maquina, $medida, $foto, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_zonacorporal_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idzonacorporal, $idempresa, $idcentro, $nombre, $maquina, $medida, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_zonacorporal_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>