<?php
class clsProducto
{
	private $objData;
	
	function clsProducto()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_producto_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idproducto, $idfamilia, $codigo, $nombre, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_producto_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idproducto, $idfamilia, $codigo, $nombre, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_producto', "tm_idproducto IN ($listIds)");
		return $rpta;
	}

	// function ListarPrecios($tipo, $idempresa, $idcentro, $idproducto, $tipomenu)
	// {
	// 	$bd = $this->objData;
	// 	$rs = $bd->exec_sp_select('pa_precio_articulo_listar', array($tipo, $idempresa, $idcentro, $idproducto, $tipomenu));
	// 	return $rs;
	// }

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_producto_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function Rentabilidad_Report()
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_stock_programado_reporte', array($idempresa, $idcentro, $fechaini, $fechafin, $pagina));
		return $rs;
    }

    function checkNombre($nombre, $idregistro, $idempresa, $idcentro)
    {
    	$bd = $this->objData;
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." AND tm_idproducto <> " . $idregistro;
		$tabla = 'tm_producto';
		$campos = 'tm_idproducto';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
}
?>