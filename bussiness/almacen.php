<?php
class clsAlmacen
{
	private $objData;
	
	function clsAlmacen()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_almacen_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idalmacen, $idempresa, $idcentro, $nombre, $direccion, $p_default, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_almacen_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idalmacen, $idempresa, $idcentro, $nombre, $direccion, $p_default, $idusuario), '@rpta, @titulomsje, @contenidomsje');

		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];

		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_almacen_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
	}

	function RegistrarIngresoKardex($idkardexingreso, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idalmacen, $idmotivo, $numerodoc, $fechadoc, $fecharecepcion, $descripcion, $estadokingreso, $razonsocial, $numeroruc, $placa, $observacionTransporte, $breveteTransporte, $chofer, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_ingresokardex_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idkardexingreso, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idalmacen, $idmotivo, $numerodoc, $fechadoc, $fecharecepcion, $descripcion, $estadokingreso, $razonsocial, $numeroruc, $placa, $observacionTransporte, $breveteTransporte, $chofer, $idusuario), '@rpta');

		$rpta = $result[0]['@rpta'];

		return $rpta;
	}

	function RegistrarSalidaKardex($idkardexsalida, $idempresa, $idcentro, $idventa, $idtipocomprobante, $seriedocumento, $nrodocumento, $fechasalida, $idalmacen, $estadosalida, $fechadoc, $idvendedor, $codtiposalida, $salidaautomatica, $carguio, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_salidakardex_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idkardexsalida, $idempresa, $idcentro, $idventa, $idtipocomprobante, $seriedocumento, $nrodocumento, $fechasalida, $idalmacen, $estadosalida, $fechadoc, $idvendedor, $codtiposalida, $salidaautomatica, $carguio, $idusuario), '@rpta');

		$rpta = $result[0]['@rpta'];

		return $rpta;
	}

	function RegistrarDetalleSalidaKardex(array $arrayParams)
	{
		$bd = $this->objData;
		$sp_name = 'pa_detalle_kardexsalida_registrar';

		$result = $bd->exec_sp_iud($sp_name, $arrayParams, '@rpta');

		$rpta = $result[0]['@rpta'];

		return $rpta;
	}

	function RegistrarDetalleIngresoKardex($idkardexingreso, $idempresa, $idcentro, $iddetregistrocompra, $idproducto, $idunidadmedida, $idpresentacion, $codtipoproducto, $cantidad, $series, $precio, $idusuario, &$rpta, &$mensaje)
	{
		$bd = $this->objData;
		$rpta = 0;
		$sp_name = 'pa_detalle_kardexingreso_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idkardexingreso, $idempresa, $idcentro, $iddetregistrocompra, $idproducto, $idunidadmedida, $idpresentacion, $codtipoproducto, $cantidad, $series, $precio, $idusuario), '@rpta, @mensaje');
		$rpta = $result[0]['@rpta'];
		$mensaje = $result[0]['@mensaje'];
		return 1;
	}

	function checkNombre($nombre, $idregistro, $idempresa, $idcentro)
    {
    	$bd = $this->objData;
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." AND tm_idalmacen <> " . $idregistro;
		$tabla = 'tm_almacen';
		$campos = 'tm_idalmacen';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
}
?>