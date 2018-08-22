<?php
class clsCliente_oneconnect
{
    private $objData;
   
    function clsCliente_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function Registrar($connect, $tipocliente, $idcliente, $idempresa, $idcentro, $idcanal, $iddocident, $numerodoc, $razsocial, $representante, $nombres, $apepaterno, $apematerno, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idpais, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = '';
		$params = array();

		if ($tipocliente === 'JU'){
			$sp_name = 'pa_cliente_juridico_registrar';
			$params = array($idcliente, $idempresa, $idcentro, $idcanal, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $urlweb, $idpais, $idusuario, $razsocial, $representante);
		}
		else {
			$sp_name = 'pa_cliente_natural_registrar';
			$params = array($idcliente, $idempresa, $idcentro, $idcanal, $iddocident, $numerodoc, $direccion, $telefono, $fax, $email, $foto, $idpais, $idusuario, $nombres, $apepaterno, $apematerno);
		}

		$result = $bd->exec_sp_iud($connect, $sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function _conectar()
    {
    	$bd = $this->objData;
    	return $bd->conectar();
    }

    function _desconectar($connect)
    {
    	$bd = $this->objData;
    	return $bd->desconectar($connect);
    }
}
?>