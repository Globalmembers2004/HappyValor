<?php
class clsseparacionrutina {
	private $objData;
	
	function clsseparacionrutina(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idcliente, $idrutina, $idhorariorutina, $fecha, $id, $criterio, $pagina){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_separacionrutina_listar', array($tipo, $idempresa, $idcentro, $idcliente, $idrutina, $idhorariorutina, $fecha, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idseparacionrutina, $idempresa, $idcentro, $idhorariogrupal, $idrutinagrupal, $idcliente, $hora, $fecha, $vino, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{

		$bd = $this->objData;
		$sp_name = 'pa_separacionrutina_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idseparacionrutina, $idempresa, $idcentro, $idhorariogrupal, $idrutinagrupal, $idcliente, $hora, $fecha, $vino, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_separacionrutina_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>