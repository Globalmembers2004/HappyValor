<?php
class clsInventario
{
	private $objData;
	
	function clsInventario()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idcencosto, $idusuario, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_inventario_listar', array($tipo, $idempresa, $idcentro, $idcencosto, $idusuario, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idinventario, $idempresa, $idcentro, $idperiodo, $idcencosto, $idcencosto1, $idproducto, $cantenv, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_inventario_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idinventario, $idempresa, $idcentro, $idperiodo, $idcencosto, $idcencosto1, $idproducto, $cantenv, $cantinv, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_inventario', "tm_idinventario IN ($listIds)");
		return $rpta;
	}

	// function ListarPrecios($tipo, $idempresa, $idcentro, $idinventario, $tipomenu)
	// {
	// 	$bd = $this->objData;
	// 	$rs = $bd->exec_sp_select('pa_precio_articulo_listar', array($tipo, $idempresa, $idcentro, $idinventario, $tipomenu));
	// 	return $rs;
	// }

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_inventario_eliminar';
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
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." AND tm_idinventario <> " . $idregistro;
		$tabla = 'tm_inventario';
		$campos = 'tm_idinventario';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }

	function ListarReenvio($tipo, $idempresa, $idcentro, $idproducto, $idcencosto_ori,  $idcencosto_des, $idinventario, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_reenvio_listar', array($tipo, $idempresa, $idcentro, $idproducto, $idcencosto_ori,  $idcencosto_des, $idinventario, $id, $criterio, $pagina));
		return $rs;
	}

	function EliminarReenvio($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_reenvio_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function RegistrarReenvio($idenvio, $idempresa, $idcentro, $idinventario, $idperiodo, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_reenvio_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idenvio, $idempresa, $idcentro, $idinventario, $idperiodo, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}


    function ModificarReenvio($idenvio, $idempresa, $idcentro, $idinventario, $idperiodo, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_reenvio_eliminar';
        $params = array($idenvio, $idusuario);
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');
		$sp_name = 'pa_reenvio_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idenvio, $idempresa, $idcentro, $idinventario, $idperiodo, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

}
?>