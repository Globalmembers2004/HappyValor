<?php
class clsDocumentos {
	private $objData;
	
	function clsDocumentos(){
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_documento_identificacion_listar', array($tipo, $id, $criterio));
        return $rs;
	}

	function CodigoTributable($criterio)
	{
		$bd = $this->objData;
        $rs = $bd->exec_sp_select('pa_documento_identificacion_codtributable', array($criterio));
        return $rs;
	}

	function GetIdByName($nombre)
	{
		$bd = $this->objData;
        $result = $bd->exec_sp_one_value('pa_documento_identificacion_getidbyname', array($nombre), 'DNI');
        return $result;
	}

	function Registrar($iddocident, $descripcion, $tipocli, $nummaxcaracteres, $codigosunat, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_documento_identificacion_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($iddocident, $descripcion, $tipocli, $nummaxcaracteres, $codigosunat, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_documento_identificacion_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>