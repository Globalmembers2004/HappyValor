<?php
/**
* 
*/
class clsAtencion
{
	function clsAtencion()
	{
		$this->objData = new Db();
	}

	function ListarAtencionInactiva($tipo, $idempresa, $idcentro)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_atencion_inactiva_listar', array($tipo, $idempresa, $idcentro));
		return $rs;
	}

	function Listar($tipo, $idempresa, $idcentro, $idambiente, $tipomesa, $estado, $idatencion, $idmesas)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_atencion_listar', array($tipo, $idempresa, $idcentro, $idambiente, $tipomesa, $estado, $idatencion, $idmesas));
		return $rs;
	}

	function ListarDetalle($tipo, $idatencion, $estado)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_atencion_listar', array($tipo, $idatencion, $estado));
		return $rs;
	}

	function ListarDetalleGrupo($tipo, $IdAtencion)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_atenciongpo_listar', array($tipo, $IdAtencion));
		return $rs;
	}

	function RegistrarAtencionMesa($tipo, $idempresa, $idcentro, $idatencion, $idmesas, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_atencion_mesa_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($tipo, $idempresa, $idcentro, $idatencion, $idmesas, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function ActualizarEstado($idatencion, $estadoatencion, $idusuario, &$rpta, &$colorestado)
	{
		$bd = $this->objData;
		$sp_name = 'pa_atencion_estado_actualizar';
		$result = $bd->exec_sp_iud($sp_name, array($idatencion, $estadoatencion, $idusuario), '@rpta, @colorestado');
		$rpta = $result[0]['@rpta'];
		$colorestado = $result[0]['@colorestado'];
		return $rpta;
	}

	function SepararMesa($idatencion, $idempresa, $idcentro, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_atencion_mesa_separar';
		$result = $bd->exec_sp_iud($sp_name, array($idatencion, $idempresa, $idcentro, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}
	
	function EliminarDetalle($idatencion, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_detalle_atencion_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($idatencion, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	// function RegistrarDetalle($idatencion_articulo, $idempresa, $idcentro, $idatencion, $idarticulo, $idmoneda, $precio, $cantidad, $subtotal, $observacion, $tipomenudia, $idusuario, $strListIdArticulo, &$rpta)
	// {
	// 	$bd = $this->objData;
	// 	$sp_name = 'pa_detalle_atencion_registrar';
	// 	$result = $bd->exec_sp_iud($sp_name, array($idatencion_articulo, $idempresa, $idcentro, $idatencion, $idarticulo, $idmoneda, $precio, $cantidad, $subtotal, $observacion, $tipomenudia, $idusuario, $strListIdArticulo), '@rpta');
	// 	$rpta = $result[0]['@rpta'];
	// 	return $rpta;
	// }

	// function RegisrarMovimiento($idatencion, $estadoatencion, $fechamov, $direccionip, $idusuario)
	// {
	// 	$bd = $this->objData;
	// 	$sp_name = 'pa_atencion_movimiento_registrar';
	// 	$result = $bd->exec_sp_iud($sp_name, array($idatencion, $estadoatencion, $fechamov, $direccionip, $idusuario), '@rpta');
	// 	$rpta = $result[0]['@rpta'];
	// 	return $rpta;
	// }

	// function CheckStateDetails($IdAtencion)
	// {
	// 	$bd = $this->objData;
		
	// 	$tabla = 'td_atencion_articulo';
	// 	$campos = 'COUNT(td_idatencion_articulo) as countCheck';
	// 	$condicion = 'tm_idatencion = '.$IdAtencion;
	// 	$condicion .= ' AND ta_estdetalle_atencion in (\'00\', \'01\')';
	// 	$rs = $bd->set_select($campos, $tabla, $condicion);
		
	// 	return $rs;
	// }

	function CheckStateDetails($tipo, $idatencion, $estdetalle_atencion)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_atencion_analizarestado', array($tipo, $idatencion, $estdetalle_atencion));
		return $rs;
	}

	function ActualizarEstadoItem($tipo, $codEstado, $paramsId, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_atencion_item_actualizaestado';
		$result = $bd->exec_sp_iud($sp_name, array($tipo, $codEstado, $paramsId, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function UpdateEstadoMultiple($estado, $IdAtencion)
	{
		$bd = $this->objData;
		$rpta = $bd->set_update(array('ta_estadoatencion' => $estado), 'tm_atencion', 'tm_idatencion IN ('.$IdAtencion.')');
		return $rpta;
	}

	// function UltimaAtencion($idempresa, $idcentro, $estado)
	// {
	// 	$bd = $this->objData;
	// 	$sp_name = 'pa_atencion_notificacion';
	// 	$rs = $bd->exec_sp_select($sp_name, array($idempresa, $idcentro, $estado));
	// 	return $rs;
	// }
}
?>