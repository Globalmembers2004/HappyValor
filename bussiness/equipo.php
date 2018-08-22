<?php
class clsEquipo
{
	function clsEquipo()
	{
		$this->objData = new Db();
	}


	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_equipo_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}


	function Registrar($idEquipo, $idempresa, $idcentro, $txtNombre, $ddlAmbiente, $ddlZonacorporal, $txtCodigo, $ddlTipoEquipo, $txtCantidad, $txtVideo, $urlFoto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_equipo_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idEquipo, $idempresa, $idcentro, $txtNombre, $ddlAmbiente, $ddlZonacorporal, $txtCodigo, $ddlTipoEquipo, $txtCantidad, $txtVideo, $urlFoto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];

		return $rpta;
	}

	function MultiInsert($bulkQuery)
	{
		$bd = $this->objData;
		$rpta = $bd->ejecutar($bulkQuery);
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_Equipo', "tm_idEquipo IN ($listIds)");
		return $rpta;
	}

	function Eliminarstepbystep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_equipo_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>