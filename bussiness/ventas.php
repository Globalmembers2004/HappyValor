<?php
class clsVenta {
	private $objData;
	
	function clsVenta(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_venta_listar', array($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idventa, $idempresa, $idcentro, $idtipocomprobante, $vserie_documento, $vnumero_documento, $idmoneda, $idcliente, $tipocobro, $fecha_emision, $fecha_vencimiento, $base_imponible, $impuesto, $total, $idpersonal, $estadoventa, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_venta_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idventa, $idempresa, $idcentro, $idtipocomprobante, $vserie_documento, $vnumero_documento, $idmoneda, $idcliente, $tipocobro, $fecha_emision, $fecha_vencimiento, $base_imponible, $impuesto, $total, $idpersonal, $estadoventa, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function RegistrarDetalle($idventa, $idproducto, $cantidad, $precio, $idunidadmedida, $subtotal, $salidaautomatica_vta, $idusuario, &$rpta){
		$bd = $this->objData;
		$sp_name = 'pa_detalle_venta_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idventa, $idproducto, $cantidad, $precio, $idunidadmedida, $subtotal, $salidaautomatica_vta, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function RegistrarVentaFormaPago($idempresa, $idcentro, $idventa, $idformapago, $idmoneda, $idtarjetapago, $importe, $comision, $codigo, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_venta_formapago_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idventa, $idformapago, $idmoneda, $idtarjetapago, $importe, $comision, $codigo, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function RegistrarVentaImpuesto($idempresa, $idcentro, $idventa, $idimpuesto, $importe, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_venta_impuesto_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idventa, $idimpuesto, $importe, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function EliminarDetalle($idventa, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_detalle_venta_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($idventa, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function ListarAperturaCaja($tipo, $idempresa, $idcentro, $fecha)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_registrocaja_listar', array($tipo, $idempresa, $idcentro, $fecha));
		return $rs;
	}

	function RegistrarAperturaCaja($idregistrocaja, $idempresa, $idcentro, $idpersonal, $idmoneda, $fecharegistro, $monto_inicial, $monto_final, $monto_actual, $turno, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_registrocaja_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idregistrocaja, $idempresa, $idcentro, $idpersonal, $idmoneda, $fecharegistro, $monto_inicial, $monto_final, $monto_actual, $turno, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function ListarDetalleCaja($tipo, $id, $tipomov)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_regcaja_listar', array($tipo, $id, $tipomov));
		return $rs;
	}

	function RegistrarDetalleCaja($idregistrocaja, $idempresa, $idcentro, $tipo_movimiento, $idmovimiento, $tipo_persona, $idpersona, $idmoneda, $monto_mn, $monto_me, $observacion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_detalle_regcaja_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idregistrocaja, $idempresa, $idcentro, $tipo_movimiento, $idmovimiento, $tipo_persona, $idpersona, $idmoneda, $monto_mn, $monto_me, $observacion, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function CierreCaja($idregistrocaja, $idempresa, $idcentro, $idpersonal, $idmoneda, $observacion, $limpiarmesas, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_registrocaja_cerrar';
		$result = $bd->exec_sp_iud($sp_name, array($idregistrocaja, $idempresa, $idcentro, $idpersonal, $idmoneda, $observacion, $limpiarmesas, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function ListarTipoMovCaja($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tipomovimientocaja_listar', array($tipo, $id, '', $criterio));
		return $rs;
	}

	function TipoMovCajaPorDefecto($codigo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_tipomovimientocaja_listar', array('3', 0, $codigo, ''));
		return $rs;
	}

	function RegistrarTipoMovCaja($idtipomovimiento_caja, $nombre, $descripcion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_tipomovimientocaja_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idtipomovimiento_caja, $nombre, $descripcion, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarTipoMovCaja($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_tipomovimientocaja_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function Reporte($tipo, $idempresa, $idcentro, $anhoini, $mesini, $anhofin, $mesfin, $idcliente)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_venta_reporte', array($tipo, $idempresa, $idcentro, $anhoini, $mesini, $anhofin, $mesfin, $idcliente));
		return $rs;
    }

    function DetalleVenta_Reporte($idempresa, $idcentro, $fechaini, $fechafin)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalleventa_reporte', array($idempresa, $idcentro, $fechaini, $fechafin));
		return $rs;
    }

    function CuadreCaja_Reporte($idempresa, $idcentro, $fechaini, $fechafin)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_caja_cuadre_reporte', array($idempresa, $idcentro, $fechaini, $fechafin));
		return $rs;
    }

    function CajaEfectivo_Reporte($idempresa, $idcentro, $fechaini, $fechafin)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_caja_efectivo_reporte', array($idempresa, $idcentro, $fechaini, $fechafin));
		return $rs;
    }

    function CajaImpuesto_Reporte($idempresa, $idcentro, $fechaini, $fechafin)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_caja_impuestos_reporte', array($idempresa, $idcentro, $fechaini, $fechafin));
		return $rs;
    }

    function ListarVentasPorFecha($tipo, $idempresa, $idcentro, $fecha, $criterio)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_venta_listar__xfecha', array($tipo, $idempresa, $idcentro, $fecha, $criterio));
		return $rs;
    }
}
?>