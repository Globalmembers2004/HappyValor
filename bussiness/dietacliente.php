<?php
/**
* 
*/
class clsDietaCliente
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_dietasocio_listar', array($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina));
		return $rs;
	}
	
	function Registrar($iddietasocio, $idempresa, $idcentro, $idcliente, $iddieta, $fechainicial, $fechafinal, $documento, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_dietasocio_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($iddietasocio, $idempresa, $idcentro, $idcliente, $iddieta, $fechainicial, $fechafinal, $documento, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];

		return $rpta;
	}
}
?>