<?php
class clsProducto_oneconnect
{
    private $objData;
   
    function clsProducto_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function Registrar($connect, $idproducto, $idempresa, $idcentro, $nombre, $idcategoria, $idsubcategoria, $foto, $precioVenta, $precioCompra, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_producto_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idproducto, $idempresa, $idcentro, $nombre, $idcategoria, $idsubcategoria, $foto, $precioVenta, $precioCompra, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function DeletePrevDetReceta($connect, $idempresa, $idcentro, $idproducto, $tipomenudia, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_receta_producto_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idproducto, $tipomenudia, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function Registrar__Receta($connect, $idempresa, $idcentro, $idproducto, $idinsumo_orig, $idunidadmedida, $tipomenudia, $tipoinsumo, $descripcion, $cantidad, $nroporciones, $avgxporcion, $precio, $subtotal, $costoreceta, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_receta_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idproducto, $idinsumo_orig, $idunidadmedida, $tipomenudia, $tipoinsumo, $descripcion, $cantidad, $nroporciones, $avgxporcion, $precio, $subtotal, $costoreceta, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function Registrar__Precio($connect, $idempresa, $idcentro, $idproducto, $tipomenudia, $precio, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_precio_articulo_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idproducto, $tipomenudia, $precio, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function RegistrarTiempoPreparacion($connect, $idempresa, $idcentro, $idproducto, $tipomenudia, $tiempo, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_producto_preparacion_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idempresa, $idcentro, $idproducto, $tipomenudia, $tiempo, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function DeleteInsumoPresentacion($connect, $idinsumo, $tipoinsumo, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_presentacion_insumo_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idinsumo, $tipoinsumo, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
        return $rpta;
    }

    function Registrar__Presentacion($connect, $tipoinsumo, $idempresa, $idcentro, $idinsumo, $idpresentacion, $idunidadmedida, $medida, $idusuario)
    {
        $bd = $this->objData;
        $sp_name = 'pa_presentacion_insumo_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($tipoinsumo, $idempresa, $idcentro, $idinsumo, $idpresentacion, $idunidadmedida, $medida, $idusuario), '@rpta');
        $rpta = $result[0]['@rpta'];
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