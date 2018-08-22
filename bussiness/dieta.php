<?php
class clsDieta
{
	function clsDieta()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcliente, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_dieta_listar', array($tipo, $idempresa, $idcliente, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idDieta,  $idempresa,  $Idcentro, $txtNombre, $txtPesominsg, $txtPesomaxsg, $txtCalorias, $txtDocumento, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_dieta_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idDieta,  $idempresa,  $Idcentro, $txtNombre, $txtPesominsg, $txtPesomaxsg, $txtCalorias, $txtDocumento, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

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
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_Dieta', "tm_idDieta IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_dieta_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>