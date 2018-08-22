<?php
class clsVenta_oneconnect
{
    private $objData;
   
    function clsVenta_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function Listar($connect, $tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina)
    {
        $bd = $this->objData;
        $rs = $bd->exec_sp_select($connect, 'pa_venta_listar', array($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina));
        return $rs;
    }

    function Registrar($connect, $idventa, $idempresa, $idcentro, $idtipocomprobante, $vserie_documento, $vnumero_documento, $idmoneda, $idcliente, $tipocobro, $fecha_emision, $fecha_vencimiento, $base_imponible, $impuesto, $total, $idpersonal, $estadoventa, $idregistrocaja, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_venta_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idventa, $idempresa, $idcentro, $idtipocomprobante, $vserie_documento, $vnumero_documento, $idmoneda, $idcliente, $tipocobro, $fecha_emision, $fecha_vencimiento, $base_imponible, $impuesto, $total, $idpersonal, $estadoventa, $idregistrocaja, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomensaje'];
        return $rpta;
    }


    function RegistrarDetalle($connect, $idventa, $idempresa, $idcentro, $idproducto, $cantidad, $precio, $idunidadmedida, $subtotal, $salidaautomatica_vta, $tipomenudia, $idcliente, $fechainicio, $idusuario, &$rpta){
        $bd = $this->objData;
        $sp_name = 'pa_detalle_venta_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idventa, $idempresa, $idcentro, $idproducto, $cantidad, $precio, $idunidadmedida, $subtotal, $salidaautomatica_vta, $tipomenudia, $idcliente, $fechainicio, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function RegistrarVentaFormaPago($connect, $idempresa, $idcentro, $idventa, $idformapago, $idmoneda, $idtarjetapago, $importe, $comision, $codigo, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_venta_formapago_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idventa, $idformapago, $idmoneda, $idtarjetapago, $importe, $comision, $codigo, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function RegistrarVentaImpuesto($connect, $idempresa, $idcentro, $idventa, $idimpuesto, $importe, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_venta_impuesto_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idventa, $idimpuesto, $importe, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function RegistrarDeudaCobrar($connect, $idventa, $iddeudacobrar_ref, $idempresa, $idcentro, $idtipocliente, $importe, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_deudacobrar_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idventa, $iddeudacobrar_ref, $idempresa, $idcentro, $idtipocliente, $importe, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    /*********** ACTUALIZACION DE ESTADO DE LA ATENCION ***************/

    function RegistrarMovimiento($connect, $idatencion, $estadoatencion, $direccionip, $idusuario, &$prta)
    {
        $bd = $this->objData;
        $sp_name = 'pa_atencion_movimiento_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idatencion, $estadoatencion, $direccionip, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function ActualizarEstado($connect, $idatencion, $estadoatencion, $idusuario, &$rpta, &$colorestado)
    {
        $bd = $this->objData;
        $sp_name = 'pa_atencion_estado_actualizar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idatencion, $estadoatencion, $idusuario), '@rpta, @colorestado');
        $rpta = $result[0]['@rpta'];
        $colorestado = $result[0]['@colorestado'];
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