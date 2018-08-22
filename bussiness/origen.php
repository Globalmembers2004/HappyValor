<?php
class clsOrigen
{
	function clsOrigen()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina ){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_origen_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}
	
	function Registrar($idorigen, $TipoDoc, $Folio, $Rucreceptor, $RazonSocial, $FechaEmision, $Moneda, $Local, $Igv, $Gravadas, $Total, $Referencia, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_origen_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idorigen, $TipoDoc, $Folio, $Rucreceptor, $RazonSocial, $FechaEmision, $Moneda, $Local, $Igv, $Gravadas, $Total, $Referencia, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
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
		$rpta = $bd->set_update(array('Activo' => '0'), 'origen', "tm_idorigen IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_origen_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
	
}
?>