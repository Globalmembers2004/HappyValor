<?php
class clsSuministro
{
	private $objData;
	
	function clsSuministro()
	{
		$this->objData = new Db();
	}

	function BorrarTabla($tabla)
	{
		$bd = $this->objData;
		$sql = "TRUNCATE TABLE ".$tabla."";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function Listar($tipo, $idempresa, $idcentro, $idperiodo, $idcencosto, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_suministros_listar', array($tipo, $idempresa, $idcentro, $idperiodo, $idcencosto, $id, $criterio, $pagina));
		return $rs;
	}

	function ImportarProducto($codigo,$familia,$descripcion)
	{
		$bd = $this->objData;
		$sql = "INSERT into tmp_productos (cod_starsoft,tm_familia,tm_descripcion) values ('".$codigo."','".$familia."','".$descripcion."')";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function AdicionarProducto()
	{
		$bd = $this->objData;
		$sql = 'call pa_producto_adicionar';
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function ImportarFamilia($codigo,$descripcion)
	{
		$bd = $this->objData;
		$sql = "INSERT into tmp_familia (tm_codfam_star,tm_descripcion) values ('".$codigo."','".$descripcion."')";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function AdicionarFamilia()
	{
		$bd = $this->objData;
		$sql = 'call pa_familia_adicionar';
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function ImportarCentroCosto($codigo,$descripcion)
	{
		$bd = $this->objData;
		$sql = "INSERT into tmp_centrocosto (tm_cencos_star,tm_descripcion) values ('".$codigo."','".$descripcion."')";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function AdicionarCentroCosto()
	{
		$bd = $this->objData;
		$sql = 'call pa_centrocosto_adicionar';
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function ImportarCostoProducto($producto,$costo,$periodo)
	{
		$bd = $this->objData;
		$sql = "INSERT into tmp_costoproducto (cod_starsoft,tm_costo,periodo) values ('".$producto."','".$costo."','".$periodo."')";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function AdicionarCosto($periodo)
	{
		$bd = $this->objData;
		$sql = "call pa_costo_adicionar(".$periodo.")";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function ImportarInventario($producto,$centrocosto,$periodo,$cant_env)
	{
		$bd = $this->objData;
		$sql = "INSERT into tmp_inventario (tm_codpro_star, tm_cencos_star,tm_idperiodo,tm_cant_envi) values ('".$producto."','".$centrocosto."','".$periodo."','".$cant_env."')";
		$result = $bd->ejecutar($sql);
		return $result;
	}

	function AdicionarInventario($periodo)
	{
		$bd = $this->objData;
		$sql = "call pa_inventario_adicionar(".$periodo.")";
		$result = $bd->ejecutar($sql);
		return $result;
	}



	function Registrar($idinventario, $idempresa, $idcentro, $idperiodo, $idcencosto, $idcencosto1, $idproducto, $cantant, $cantenv, $cantdev, $cantinv, $cantcon, $valocon, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_suministros_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idinventario, $idempresa, $idcentro, $idperiodo, $idcencosto, $idcencosto1, $idproducto, $cantant, $cantenv, $cantdev, $cantinv, $cantcon, $valocon, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_suministros', "tm_idsuministros IN ($listIds)");
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
        $sp_name = 'pa_suministros_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
    /*
    function checkNombre($nombre, $idregistro, $idempresa, $idcentro)
    {
    	$bd = $this->objData;
		$condicion = "tm_descripcion = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." AND tm_idinventario <> " . $idregistro;
		$tabla = 'tm_suministros';
		$campos = 'tm_idsuministros';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
    */
}
?>