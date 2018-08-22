<?php
class clsCartaDia
{
	function clsCartaDia()
	{
		$this->objData = new Db();
	}

	function ListarProgramaciones($tipo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $idgrupo, $idcarta, $idorden, $tipomenu, $fecha, $estadoapertura, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_programacion_listar', array($tipo, $idempresa, $idcentro, $idcategoria, $idsubcategoria, $idgrupo, $idcarta, $idorden, $tipomenu, $fecha, $estadoapertura, $criterio, $pagina));
		return $rs;
	}

	function ListarPrograma_Carta($tipo, $idempresa, $idcentro, $idcategoria, $idcarta, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_programacion_carta_listar', array($tipo, $idempresa, $idcentro, $idcategoria, $idcarta, $criterio, $pagina));
		return $rs;
	}

	function ListarPrograma_Menu($tipo, $idempresa, $idcentro, $idcategoria, $fecha, $idgrupo, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_programacion_menu_listar', array($tipo, $idempresa, $idcentro, $idcategoria, $fecha, $idgrupo, $criterio, $pagina));
		return $rs;
	}

	function ListarCartas($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_carta_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function ListarDiasProgramados($tipo, $idempresa, $idcentro, $anho, $mes)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_programacion_diasasignados', array($tipo, $idempresa, $idcentro, $anho, $mes));
		return $rs;
	}

	function ListarProgramaciones__Comensal($tipo, $idcategoria, $idsubcategoria, $tipomenu, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_programacion__comensal_listar', array($tipo, $idcategoria, $idsubcategoria, $tipomenu, $criterio, $pagina));
		return $rs;
	}

	function RegistrarCarta($idcarta, $idempresa, $idcentro, $nombre, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_carta_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idcarta, $idempresa, $idcentro, $nombre, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function ActivarCarta($idcarta, $idempresa, $idcentro, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_carta_activar';
		$result = $bd->exec_sp_iud($sp_name, array($idcarta, $idempresa, $idcentro, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function AperturarProgramacion($tipomenu, $idempresa, $idcentro, $idkardexsalida, $fechaMenu, $tienereceta, $listIdAlmacen, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_programacion_aperturar';
		$result = $bd->exec_sp_iud($sp_name, array($tipomenu, $idempresa, $idcentro, $idkardexsalida, $fechaMenu, $tienereceta, $listIdAlmacen, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function RegistrarProgramacion($iddetalle, $tipomenudia, $idempresa, $idcentro, $idgrupo, $idcarta, $idarticulo, $fecha, $idmoneda, $precio, $stockdia, $idusuario){
		$bd = $this->objData;
		$sp_name = 'pa_programacion_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($iddetalle, $tipomenudia, $idempresa, $idcentro, $idgrupo, $idcarta, $idarticulo, $fecha, $idmoneda, $precio, $stockdia, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function EliminarFechaProgramacion($tipomenu, $idempresa, $idcentro, $idgrupo, $fecha, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_programacion_fecha_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($tipomenu, $idempresa, $idcentro, $idgrupo, $fecha, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function EliminarProgramacion($tipomenu, $listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_programacion_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($tipomenu, $listIds, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function EliminarItemProgramacion($iddetalle, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_programacion_item_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($iddetalle, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function MultiDeleteCarta($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_carta_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($tipomenu, $listIds, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}
}
?>