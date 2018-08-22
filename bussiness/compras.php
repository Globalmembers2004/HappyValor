<?php
/**
* 
*/
class clsCompra
{
	private $objData;
	
	function clsCompra()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_compra_listar', array($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina));
		return $rs;
	}

	function RegistrarMaestro($idregistrocompra, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idformapago, $idmoneda, $idpersonal, $serie_documento, $numero_documento, $fecha_recibo, $estadocompra, $referencia, $subtotal, $impuesto, $totalcompra, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_compra_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idregistrocompra, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idformapago, $idmoneda, $idpersonal, $serie_documento, $numero_documento, $fecha_recibo, $estadocompra, $referencia, $subtotal, $impuesto, $totalcompra, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function AgregarKardexIngresoRegistroCompra($idregistrocompra, $idkardexingreso, $fecha, $idusuario, &$rpta, &$mensaje)
	{
		$bd = $this->objData;
		$rpta = 0;
		$sp_name = 'pa_kardex_ingreso_regcompra_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idregistrocompra, $idkardexingreso, $fecha, $idusuario), '@rpta, @mensaje');
		$rpta = $result[0]['@rpta'];
		$mensaje = $result[0]['@mensaje'];
		return 1;
	}
	
	function ActualizarSaldoCompra($idregistrocompra, $cantidadregcompra, $idproducto, &$rpta, &$mensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_saldo_compra_actualizar';
		$result = $bd->exec_sp_iud($sp_name, array($idregistrocompra, $cantidadregcompra, $idproducto), '@rpta, @mensaje');
		$rpta = $result[0]['@rpta'];
		$mensaje = $result[0]['@mensaje'];
		return 1;
	}

	function RegistrarDetalle($idempresa, $idcentro, $idregistrocompra, $idproducto, $tipoproducto, $idpresentacion, $idunidadmedida, $idunidadmedidapre, $medidapre, $cantidad, $costoUnitario, $subtotal, $serie, $previo, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_detalle_compra_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idregistrocompra, $idproducto, $tipoproducto, $idpresentacion, $idunidadmedida, $idunidadmedidapre, $medidapre, $cantidad, $costoUnitario, $subtotal, $serie, $previo, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function Reporte($tipo, $idempresa, $idcentro, $anhoini, $mesini, $anhofin, $mesfin)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_compra_reporte', array($tipo, $idempresa, $idcentro, $anhoini, $mesini, $anhofin, $mesfin));
		return $rs;
    }
}
?>