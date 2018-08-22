<?php
class clsLineaCredito {
	private $objData;
	
	function clsLineaCredito(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_linea_credito_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idlineacredito, $idempresa, $idcentro, $idtipocliente, $idmoneda, $monto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_linea_credito_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idlineacredito, $idempresa, $idcentro, $idtipocliente, $idmoneda, $monto, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_lineacredito_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function DeudaCobrar_Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
    {
    	$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_deudacobrar_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
    }
	
    function DeudaCobrar_Amortizar($iddeudacobrar, $idempresa, $idcentro, $fecha, $tipo_operacion, $idbanco, $nrocuentabancaria, $num_operacion, $imagenvoucher, $valormora, $importecancelado, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_deudacobrar_amortizar';
        $params = array($iddeudacobrar, $idempresa, $idcentro, $fecha, $tipo_operacion, $idbanco, $nrocuentabancaria, $num_operacion, $imagenvoucher, $valormora, $importecancelado, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>