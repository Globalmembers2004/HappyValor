<?php
class clsRutinagymdetalle {
	private $objData;
	
	function clsRutinagymdetalle(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idrutina, $idzonacorporal, $idequipo, $id, $criterio, $pagina){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_rutinagym_listar', array($tipo, $idempresa, $idcentro, $idrutina, $idzonacorporal, $idequipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idrutinagymdetalle, $idempresa, $idcentro, $detalle, $rutina, $item, $zona, $equipo, $serie, $repeticiones, $peso, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_detalle_rutinagym_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idrutinagymdetalle, $idempresa, $idcentro, $detalle, $rutina, $item, $zona, $equipo, $serie, $repeticiones, $peso, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_detalle_rutinagym_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>