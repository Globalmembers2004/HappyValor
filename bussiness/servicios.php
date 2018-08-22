<?php
class clsServicios
{
	function clsServicios()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_servicio_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idServicio,  $idempresa, $idcentro, $membresia, $nombreServicio, $dias, $dias_vencimiento, $precio, $foto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_servicio_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idServicio,  $idempresa, $idcentro, $membresia, $nombreServicio, $dias, $dias_vencimiento, $precio, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

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
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_servicio', "tm_idServicio IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_servicio_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function ListarServicioCliente($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_serviciocliente_listar', array($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina));
		return $rs;
    }
}
?>