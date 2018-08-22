<?php
class clsCliente
{
	function clsCliente()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_cliente_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($tipocliente, $idcliente, $idempresa, $idcentro, $idcanal, $iddocident, $numerodoc, $razsocial, $representante, $nombres, $apepaterno, $apematerno, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idpais, $idciudad, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = '';
		$params = array();

		if ($tipocliente === 'JU'){
			$sp_name = 'pa_cliente_juridico_registrar';
			$params = array($idcliente, $idempresa, $idcentro, $idcanal, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idpais, $idciudad, $idusuario, $razsocial, $representante);
		}
		else {
			$sp_name = 'pa_cliente_natural_registrar';
			$params = array($idcliente, $idempresa, $idcentro, $idcanal, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $idpais, $idciudad, $idusuario, $nombres, $apepaterno, $apematerno);
		}

		$result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function MultiDelete($listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_cliente_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($listIds, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function EliminarStepByStep($idcliente, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_cliente_eliminar_stepbystep';
        $params = array($idcliente, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function RegistrarContactoEmpresa($idcontactoemp, $idclientejr, $iddocident, $numerodoc, $nombres, $apepaterno, $apematerno, $email, $idpais, $idusuario)
	{
		$bd = $this->objData;
		$result = $bd->exec_sp_iud('pa_contacto_empresa_registrar', array($idcontactoemp, $idclientejr, $iddocident, $numerodoc, $nombres, $apepaterno, $apematerno, $email, $idpais, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];

		return $rpta;
	}

	function MultiInsert($bulkQuery)
	{
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}

	function ListarContactoEmpresa($tipo, $idclientejr)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_contacto_empresa_listar', array($tipo, $idclientejr));
		return $rs;
	}
}
?>