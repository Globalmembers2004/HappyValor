<?php
class clsNumeracionVenta
{
	function clsNumeracionVenta()
	{
		$this->objData = new Db();
	}

	function ListarNumeracion($tipo, $idempresa, $idcentro, $id)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_numeracion_terminal_listar', array($tipo, $idempresa, $idcentro, $id));
		return $rs;
	}

	function ActualizarNumeracion($tm_idterminal, $tm_idtipocomprobante, $serie_dct, $NumeroActual, $idusuario)
	{
		$parametros = array($tm_idterminal, $tm_idtipocomprobante, $serie_dct, $NumeroActual, $idusuario);
		$bd = $this->objData;
		$rpta = $bd->exec_sp_iud('pa_documento_terminal_actualizar', $parametros, '@rpta');
		$result = $rpta[0]['@rpta'];

		return $result;
	}

	function Registrar($idnumeraciondoc, $idempresa, $idcentro, $idtipocomprobante, $idterminal, $serie, $correlativo, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$parametros = array($idnumeraciondoc, $idempresa, $idcentro, $idtipocomprobante, $idterminal, $serie, $correlativo, $idusuario);
		
		$bd = $this->objData;
		$result = $bd->exec_sp_iud('pa_numeracion_terminal_registrar', $parametros, '@rpta, @titulomsje, @contenidomensaje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function Eliminar($idnumeraciondoc, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$parametros = array($idnumeraciondoc, $idusuario);
		
		$bd = $this->objData;
		$result = $bd->exec_sp_iud('pa_numeracion_terminal_eliminar', $parametros, '@rpta, @titulomsje, @contenidomensaje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}
}
?>