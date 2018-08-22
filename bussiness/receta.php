<?php
class clsReceta
{
	function clsReceta()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idproducto, $tipomenudia)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_receta_listar', array($tipo, $idempresa, $idcentro, $idproducto, $tipomenudia));
		return $rs;
	}

	function Registrar($idempresa, $idcentro, $idproducto, $idinsumo_orig, $idunidadmedida, $tipomenudia, $tipoinsumo, $descripcion, $cantidad, $nroporciones, $avgxporcion, $precio, $subtotal, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_receta_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idproducto, $idinsumo_orig, $idunidadmedida, $tipomenudia, $tipoinsumo, $descripcion, $cantidad, $nroporciones, $avgxporcion, $precio, $subtotal, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function DeletePrevDetReceta($idempresa, $idcentro, $idproducto, $tipomenudia)
	{
		$bd = $this->objData;
		$sp_name = 'pa_receta_producto_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idproducto, $tipomenudia), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_producto', "tm_idproducto IN ($listIds)");
		return $rpta;
	}
}
?>