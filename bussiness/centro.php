<?php
class clsCentro
{
	function clsCentro()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_centro_listar', array($tipo, $id, $criterio));
		return $rs;
	}

	function Listar__Comensal($tipo, $idregion, $nombrearticulo, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_centro__comensal_listar', array($tipo, $idregion, $nombrearticulo, $criterio));
		return $rs;
	}
	
	function Registrar($idcentro, $idempresa, $nombre, $direccion, $iddepartamento, $idprovincia, $iddistrito, $latitud, $longitud, $direccion_gmpas, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_centro_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idcentro, $idempresa, $nombre, $direccion, $iddepartamento, $idprovincia, $iddistrito, $latitud, $longitud, $direccion_gmpas, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_centro_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function checkNombre($nombre, $idregistro, $idempresa)
    {
    	$bd = $this->objData;
		$condicion = "tm_nombre = '".$nombre."' AND tm_idempresa = ".$idempresa." AND tm_idcentro <> " . $idregistro;
		$tabla = 'tm_centro';
		$campos = 'tm_idcentro';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
    }
}
?>