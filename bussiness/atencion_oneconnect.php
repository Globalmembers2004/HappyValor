<?php
class clsAtencion_oneconnect
{
    private $objData;
   
    function clsAtencion_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function Registrar($connect, $idatencion, $idempresa, $idcentro, $idambiente, $idcliente, $fechahora, $tipoubicacion, $estadoatencion, $idmesas, $tipomesa, $idusuario, &$rpta, &$nronewatencion)
    {
        $bd = $this->objData;
        $sp_name = 'pa_atencion_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idatencion, $idempresa, $idcentro, $idambiente, $idcliente, $fechahora, $tipoubicacion, $estadoatencion, $idmesas, $tipomesa, $idusuario), '@rpta, @nronewatencion');
        $rpta = $result[0]['@rpta'];
        $nronewatencion = $result[0]['@nronewatencion'];
        return $rpta;
    }

    function Eliminar($connect, $idatencion, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_atencion_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idatencion, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomensaje'];
        return $rpta;
    }

    function RegistrarCliente($connect, $idCliente,  $idempresa, $idcentro, $nrodni, $nombres,  $apellidos, $sexo, $nacimiento, $telefono, $celular, $email, $facebook, $ubigeo, $direccion, $foto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_cliente_registrar';

        $result = $bd->exec_sp_iud($connect, $sp_name, array($idCliente,  $idempresa, $idcentro, $nrodni, $nombres,  $apellidos, $sexo, $nacimiento, $telefono, $celular, $email, $facebook, $ubigeo, $direccion, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomensaje'];

        return $rpta;
    }

    function RegistrarDetalle($connect, $idatencion_articulo, $idempresa, $idcentro, $idatencion, $idarticulo, $idcliente, $idmoneda, $precio, $cantidad, $subtotal, $descripcion, $observacion, $tipomenudia, $fechainicio, $idusuario, $strListIdArticulo, &$rpta)
    {
        $bd = $this->objData;
        $sp_name = 'pa_detalle_atencion_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idatencion_articulo, $idempresa, $idcentro, $idatencion, $idarticulo, $idcliente, $idmoneda, $precio, $cantidad, $subtotal, $descripcion, $observacion, $tipomenudia, $fechainicio, $idusuario, $strListIdArticulo), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

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
	
	function UltimaAtencion($connect, $idempresa, $idcentro, $estadoatencion, &$idatencion, &$nroatencion, &$fechamaxmov)
    {
        $bd = $this->objData;
        $sp_name = 'pa_atencion_notificacion';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $estadoatencion), '@idatencion, @nroatencion, @fechamaxmov');
        
        $idatencion = $result[0]['@idatencion'];
        $nroatencion = $result[0]['@nroatencion'];
        $fechamaxmov = $result[0]['@fechamaxmov'];
    }

    function UltimaMesa($connect, $idempresa, $idcentro, $idambiente, &$idgrupomesa, &$ta_tipomesa, &$codigo_group, &$comensales_group, &$estadoatencion_group, &$color_leyenda_group, &$fechamaxmov)
    {
        $bd = $this->objData;
        $sp_name = 'pa_mesa_notificacion';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idambiente), '@idgrupomesa, @ta_tipomesa, @codigo_group, @comensales_group, @estadoatencion_group, @color_leyenda_group, @fechamaxmov');

        $idgrupomesa = $result[0]['@idgrupomesa'];
        $ta_tipomesa = $result[0]['@ta_tipomesa'];
        $codigo_group = $result[0]['@codigo_group'];
        $comensales_group = $result[0]['@comensales_group'];
        $estadoatencion_group = $result[0]['@estadoatencion_group'];
        $color_leyenda_group = $result[0]['@color_leyenda_group'];
        $fechamaxmov = $result[0]['@fechamaxmov'];
    }
    
    function EliminarArticulo($connect, $idatencion_articulo, &$rpta)
    {
        $bd = $this->objData;
        $sp_name = 'pa_detalle_atencion_quitar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idatencion_articulo), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function AgruparMesas($connect, $idgrupomesa, $idempresa, $idcentro, $idambiente, $idpersonal, $list_mesas, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_grupo_mesa_registrar';
        $params = array($idgrupomesa, $idempresa, $idcentro, $idambiente, $idpersonal, $list_mesas, $idusuario);
        
        $result = $bd->exec_sp_iud($connect, $sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function SepararMesas($connect, $idempresa, $idcentro, $list_mesas, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_grupo_mesa_separar';
        $params = array($idempresa, $idcentro, $list_mesas, $idusuario);
        
        $result = $bd->exec_sp_iud($connect, $sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

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