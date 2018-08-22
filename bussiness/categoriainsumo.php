<?php
class clsCategoriaInsumo
{
	function clsCategoriaInsumo()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_categoriainsumo_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idcategoria_insumo, $idempresa, $idcentro, $nombre, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_categoriainsumo_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idcategoria_insumo, $idempresa, $idcentro, $nombre, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_categoria_insumo', "tm_idcategoria_insumo IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_categoriainsumo_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function checkNombre($nombre, $idregistro, $idempresa, $idcentro)
    {
    	$bd = $this->objData;
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." tm_idcategoria_insumo <> " . $idregistro;
		$tabla = 'tm_categoria_insumo';
		$campos = 'tm_idcategoria_insumo';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
}
?>