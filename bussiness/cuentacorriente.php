<?php
class clsCuentaCorriente
{
	private $objData;

	function __construct()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_cuentacorriente_listar', array($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idcuentacorriente, $idempresa, $idcentro, $idtipocliente, $idmoneda, $facturado, $cancelado, $saldo, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_cuentacorriente_registrar';
        $params = array($idcuentacorriente, $idempresa, $idcentro, $idtipocliente, $idmoneda, $facturado, $cancelado, $saldo, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['rpta'];
        $titulomsje = $result[0]['titulomsje'];
        $contenidomsje = $result[0]['contenidomsje'];

        return $rpta;
	}
}