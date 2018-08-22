<?php
class clsConsolidado
{
	function clsConsolidado()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina ){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_consolidado_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}
	
	function Registrar($idconsolidado, $descripcion, $periodo, $subdiario, $importe, $inicio, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_consolidado_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idconsolidado, $descripcion, $periodo, $subdiario, $importe, $inicio, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function Proceso($periodo, $importe, $inicio, $Subsiario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_migracion_startsoft';
		$result = $bd->exec_sp_iud($sp_name, array($periodo, $importe, $inicio, $Subsiario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}


	function MultiInsert($bulkQuery)
	{
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'consolidado', "tm_idconsolidado IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_consolidado_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
	
}
?>