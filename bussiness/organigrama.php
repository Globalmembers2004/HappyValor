<?php
class clsOrganigrama {
	private $objData;
	
	function clsOrganigrama(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idpersonal, $idarea, $idcargo, $criterio, $turno, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_personal_listar', array($tipo, $idempresa, $idcentro, $idpersonal, $idarea, $idcargo, $criterio, $turno, $pagina));
		return $rs;
	}

	function Registrar($idpersonal, $idempresa, $idcentro, $codigo, $idarea, $idcargo, $turno, $apellidopaterno, $apellidomaterno, $nombres, $nrodni, $email, $telefono, $foto, $orden, $correoenvio, $idusuario)
	{
		$bd = $this->objData;
		$sp_name = 'pa_personal_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idpersonal, $idempresa, $idcentro, $codigo, $idarea, $idcargo, $turno, $apellidopaterno, $apellidomaterno, $nombres, $nrodni, $email, $telefono, $foto, $orden, $correoenvio, $idusuario), '@rpta');

		$rpta = $result[0]['@rpta'];
		
		return $rpta;
	}

	function UpdateOrder($campoOrden, $condicion)
	{
		$bd = $this->objData;
		$rpta = $bd->set_update($campoOrden, "tm_personal", $condicion);
		return $rpta;
	}

	function MultiDelete($listIds)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_personal', 'tm_idpersonal IN ('.$listIds.')');
		return $rpta;
	}

	function UpdateMailOrigen($idpersona)
	{
		$bd = $this->objData;
		$rpta = $bd->set_update('tm_correoenvio = 1', 'tm_personal', "tm_idpersonal = $idpersona");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_personal_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>