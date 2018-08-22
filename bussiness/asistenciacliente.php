<?php
/**
* 
*/
class clsAsistenciaCliente
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idcliente, $idservicio, $mes, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_asistencia_cliente_listar', array($tipo, $idempresa, $idcentro, $idcliente, $idservicio, $mes, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idasistenciacliente, $idempresa, $idcentro, $idservicio, $idcliente, $fecha, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_asistencia_cliente_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idasistenciacliente, $idempresa, $idcentro, $idservicio, $idcliente, $fecha, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];

		return $rpta;
	}
}
?>