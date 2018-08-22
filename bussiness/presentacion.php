<?php
class clsPresentacion
{
	function clsPresentacion()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_presentacion_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idpresentacion, $idempresa, $idcentro, $nombre, $abrev, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_presentacion_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idpresentacion, $idempresa, $idcentro,  $nombre, $abrev, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep_Presentacion($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_presentacion_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function ListarInsumoPresentacion($tipo, $idinsumo, $tipoinsumo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_presentacion_insumo_listar', array($tipo, $idinsumo, $tipoinsumo));
		return $rs;
	}

	function RegistrarInsumoPresentacion($bulkQuery){
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}

	function DeleteInsumoPresentacion($idinsumo, $tipoinsumo, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_presentacion_insumo_eliminar';

		$result = $bd->exec_sp_iud($sp_name, array($idinsumo, $tipoinsumo, $idusuario), '@rpta');

		$rpta = $result[0]['@rpta'];

		return $rpta;
	}

	function MultiInsert($bulkQuery)
	{
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}
}
?>