<?php
class clsRecomendacion
{
	private $objData;
	
	function clsRecomendacion()
	{

		$this->objData = new Db();
	}

	function Listar($idrecomendacion, $idusuariofacilitador, $idusuariorecomendador, $tipo, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_recomendacion_listar', array($idrecomendacion, $idusuariofacilitador, $idusuariorecomendador, $tipo, $pagina));
		return $rs;
	}

	function Eliminar($idrecomendacion, $idusuario, &$rpta)
	{
		$bd = $this->objData;
		$sp_name = 'pa_recomendacion_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($idrecomendacion, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function Registrar($idrecomendacion, $tiporecomendacion, $_idusuario, $_idusuariorecomendador, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_recomendacion_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idrecomendacion, $tiporecomendacion, $_idusuario, $_idusuariorecomendador), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}
	
	function Contar($tipo, $id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_recomendacion_contar', array($tipo, $id));
		return $rs;
	}

	function ObtenerPorCodigo($codigo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_recomendador_obtener', array($codigo));
		return $rs;
	}
}
?>