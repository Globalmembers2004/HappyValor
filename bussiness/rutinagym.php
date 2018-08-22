<?php
class clsRutinagym {
	private $objData;
	
	function clsRutinagym(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $calorias, $id, $criterio, $pagina){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rutinagym_listar', array($tipo, $idempresa, $idcentro, $calorias, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idRutinagym, $idempresa, $idcentro, $nombre, $calorias_min, $calorias_max, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_rutinagym_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idRutinagym, $idempresa, $idcentro, $nombre, $calorias_min, $calorias_max, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_rutinagym_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>