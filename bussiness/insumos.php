<?php
class clsInsumo
{
	function clsInsumo()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_insumo_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idinsumo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $tipo_insumo, $nombre, $descripcion, $estadoinsumo, $abrev, $stock_min, $stock_max, $stock_ideal, $stock, $idGrupoInsumo, $ultimoCosto, $costoPromedio, $porImpuesto, $costoconImpuesto, $inventario, $porMerma, $ultimoCostoMerma, $idunidadmedida, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_insumo_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idinsumo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $tipo_insumo, $nombre, $descripcion, $estadoinsumo, $abrev, $stock_min, $stock_max, $stock_ideal, $stock, $idGrupoInsumo, $ultimoCosto, $costoPromedio, $porImpuesto, $costoconImpuesto, $inventario, $porMerma, $ultimoCostoMerma, $idunidadmedida, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function RegistrarDetalle($bulkQuery){
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}

	function MultiInsert($bulkQuery){
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_insumo', "tm_idinsumo IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_insumo_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function ListarInsumoPresentaciones($tipo, $idempresa, $idcentro, $criterio, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_insumo_listar', array($tipo, $idempresa, $idcentro, $criterio, $pagina));
		return $rs;
    }

    function ListarInsumoPorIDS($tipo, $idempresa, $idcentro, $ids)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_insumo_listar_porids', array($tipo, $idempresa, $idcentro, $ids));
		return $rs;
    }

    function ListarInsumoStock($tipo, $idempresa, $idcentro, $idalmacen, $criterio, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_insumo_stock_listar', array($tipo, $idempresa, $idcentro, $idalmacen, $criterio, $pagina));
		return $rs;
    }

    function RegistrarInsumoStock($idempresa, $idcentro, $tipoinsumo, $idinsumo, $saldoinicial, $costounitario, $costototal, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
		$result = $bd->exec_sp_iud('pa_insumo_stock_registrar', array($idempresa, $idcentro, $tipoinsumo, $idinsumo, $saldoinicial, $costounitario, $costototal, $idusuario), '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

		return $rpta;
    }
	
	function CambiarCostoReceta($idinsumo, $costoreceta, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_insumo_costo_actualizar';
        $params = array($idinsumo, $costoreceta, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function ActualizarStockMinMax($idinsumo, $stockmin, $stockmax, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_insumo_stockminmax_actualizar';
        $params = array($idinsumo, $stockmin, $stockmax, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
	
	function ListarExistencias($tipo, $idempresa, $idcentro, $tipoproducto, $criterio)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_existencia_listar', array($tipo, $idempresa, $idcentro, $tipoproducto, $criterio));
		return $rs;
    }

    function ControlStock_Reporte($idempresa, $idcentro, $fechaini, $fechafin, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_stock_programado_reporte', array($idempresa, $idcentro, $fechaini, $fechafin, $pagina));
		return $rs;
    }

    function ControlStockMinimo_Reporte($idempresa, $idcentro, $fechaini, $fechafin, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_stock_minimo_reporte', array($idempresa, $idcentro, $fechaini, $fechafin, $pagina));
		return $rs;
    }

    function Rentabilidad_Reporte($idempresa, $idcentro, $idcategoria, $tienreceta, $anhoini, $mesini, $anhofin, $mesfin)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rentabilidad_reporte', array($idempresa, $idcentro, $idcategoria, $tienreceta, $anhoini, $mesini, $anhofin, $mesfin));
		return $rs;
    }

    function checkNombre($nombre, $idregistro, $idempresa, $idcentro)
    {
    	$bd = $this->objData;
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND ".$idcentro." AND tm_idinsumo <> " . $idregistro;
		$tabla = 'tm_insumo';
		$campos = 'tm_idinsumo';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
}
?>