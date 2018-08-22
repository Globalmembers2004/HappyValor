<?php
class clsFormaPago {
	private $objData;

	function clsFormaPago()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_formapago_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Registrar($idformapago, $nombre, $descripcion, $codsunat, $abrev, $referencia, $propina, $puntos, $visible, $comision, $efectivo, $tipo_cambio, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_formapago_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idformapago, $nombre, $descripcion, $codsunat, $abrev, $referencia, $propina, $puntos, $visible, $comision, $efectivo, $tipo_cambio, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_formapago_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>