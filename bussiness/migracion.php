<?php
class clsmigracion
{
	function clsmigracion()
	{
		$this->objData = new Db();
	}


	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_migracion_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}


	function Registrar($idmigracion, $idempresa, $idcentro, $equilibrio , $servicios, $sueldos, $otros, $total, $ingresos, $meta, $faltante, $porcentaje, $observacion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_migracion_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idmigracion, $idempresa, $idcentro, $equilibrio , $servicios, $sueldos, $otros, $total, $ingresos, $meta, $faltante, $porcentaje, $observacion, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

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
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_migracion', "tm_idmigracion IN ($listIds)");
		return $rpta;
	}

	function Eliminarstepbystep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_migracion_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function Reporte($idempresa, $idcentro, $anho, $mes_inicial, $mes_final)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_migracion_reporte', array($idempresa, $idcentro, $anho, $mes_inicial, $mes_final));
		return $rs;
    }
}
?>