<?php
class clsCompra_oneconnect
{
    private $objData;
   
    function clsCompra_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function RegistrarMaestro($connect, $idregistrocompra, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idformapago, $idmoneda, $idpersonal, $serie_documento, $numero_documento, $fecha_recibo, $estadocompra, $referencia, $subtotal, $impuesto, $totalcompra, $idaperturacaja, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_compra_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idregistrocompra, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idformapago, $idmoneda, $idpersonal, $serie_documento, $numero_documento, $fecha_recibo, $estadocompra, $referencia, $subtotal, $impuesto, $totalcompra, $idaperturacaja, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function RegistrarDetalle($connect, $idempresa, $idcentro, $idregistrocompra, $idproducto, $tipoproducto, $idpresentacion, $idunidadmedida, $idunidadmedidapre, $medidapre, $cantidad, $costoUnitario, $subtotal, $descripcion, $serie, $previo, $idusuario, &$rpta)
    {
        $bd = $this->objData;
        $sp_name = 'pa_detalle_compra_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idregistrocompra, $idproducto, $tipoproducto, $idpresentacion, $idunidadmedida, $idunidadmedidapre, $medidapre, $cantidad, $costoUnitario, $subtotal, $descripcion, $serie, $previo, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function RegistrarIngresoKardex($connect, $idkardexingreso, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idalmacen, $codmotivo, $numerodoc, $fechadoc, $fecharecepcion, $descripcion, $estadokingreso, $razonsocial, $numeroruc, $placa, $observacionTransporte, $breveteTransporte, $chofer, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_ingresokardex_registrar';

        $result = $bd->exec_sp_iud($connect, $sp_name, array($idkardexingreso, $idempresa, $idcentro, $idtipocomprobante, $idproveedor, $idalmacen, $codmotivo, $numerodoc, $fechadoc, $fecharecepcion, $descripcion, $estadokingreso, $razonsocial, $numeroruc, $placa, $observacionTransporte, $breveteTransporte, $chofer, $idusuario), '@rpta');

        $rpta = $result[0]['@rpta'];

        return $rpta;
    }

    function ActualizarSaldoCompra($connect, $idregistrocompra, $cantidadregcompra, $idproducto, &$rpta, &$mensaje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_saldo_compra_actualizar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idregistrocompra, $cantidadregcompra, $idproducto), '@rpta, @mensaje');
        $rpta = $result[0]['@rpta'];
        $mensaje = $result[0]['@mensaje'];
        return 1;
    }

    function AgregarKardexIngresoRegistroCompra($connect, $idregistrocompra, $idkardexingreso, $fecha, $idusuario, &$rpta, &$mensaje)
    {
        $bd = $this->objData;
        $rpta = 0;
        $sp_name = 'pa_kardex_ingreso_regcompra_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idregistrocompra, $idkardexingreso, $fecha, $idusuario), '@rpta, @mensaje');
        $rpta = $result[0]['@rpta'];
        $mensaje = $result[0]['@mensaje'];
        return $rpta;
    }

    function RegistrarDetalleIngresoKardex($connect, $idkardexingreso, $idempresa, $idcentro, $iddetregistrocompra, $idproducto, $idunidadmedida, $idpresentacion, $codtipoproducto, $cantidad, $series, $precio, $subtotal, $idusuario, &$rpta, &$mensaje)
    {
        $bd = $this->objData;
        $rpta = 0;
        $sp_name = 'pa_detalle_kardexingreso_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idkardexingreso, $idempresa, $idcentro, $iddetregistrocompra, $idproducto, $idunidadmedida, $idpresentacion, $codtipoproducto, $cantidad, $series, $precio, $subtotal, $idusuario), '@rpta, @mensaje');
        $rpta = $result[0]['@rpta'];
        $mensaje = $result[0]['@mensaje'];
        return $rpta;
    }

    function RegistrarProveedor($connect, $idproveedor, $idempresa, $nombreproveedor, $nombrecontacto, $cargocontacto, $numerodoc, $direccion, $telefono, $celular, $email, $fax, $foto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proveedor_registrar';

        $result = $bd->exec_sp_iud($connect, $sp_name, array($idproveedor, $idempresa, $nombreproveedor, $nombrecontacto, $cargocontacto, $numerodoc, $direccion, $telefono, $celular, $email, $fax, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomensaje'];

        return $rpta;
    }

    function _conectar()
    {
    	$bd = $this->objData;
    	return $bd->conectar();
    }

    function _desconectar($connect)
    {
    	$bd = $this->objData;
    	return $bd->desconectar($connect);
    }
}
?>