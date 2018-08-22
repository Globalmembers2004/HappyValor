<?php
class clsvisitante
{
	function clsvisitante()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro,  $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_visitante_listar', array($tipo, $idempresa, $idcentro,  $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idvisitante,  $idempresa, $idcentro, $nrodni, $nombres,  $apellidos, $sexo, $nacimiento, $telefono, $celular, $email, $facebook, $ubigeo, $direccion, $foto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_visitante_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idvisitante,  $idempresa, $idcentro, $nrodni, $nombres,  $apellidos, $sexo, $nacimiento, $telefono, $celular, $email, $facebook, $ubigeo, $direccion, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

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
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_visitante', "tm_idvisitante IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_visitante_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>