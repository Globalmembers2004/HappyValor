<?php
class clsUsuario {
	private $objData;
	
	function clsUsuario(){
		$this->objData = new Db();
	}

	function checkUsername_Plataforma($username)
	{
		$bd = $this->objData;
		$condicion = "login='".$username."'";
		$tabla = 'tm_usuario_plataforma';
		$campos = 'idusuario';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}

	function checkPassword($password)
	{
		$bd = $this->objData;
		$condicion = "tm_password='".$password."'";
		$tabla = 'tm_usuario';
		$campos = 'tm_idusuario';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}

	function checkOnlyEmail_Plataforma($email)
	{
		$bd = $this->objData;
		$condicion = "email='".$email."'";
		$tabla = 'tm_usuario_plataforma';
		$campos = 'idusuario';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
	
	function loginUsuario($username, $password){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_acceder', array($username, $password));
		return $rs;
	}
	
	function Listar($tipo, $idempresa, $idcentro, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_listar', array($tipo, $idempresa, $idcentro, $id, $criterio, $pagina));
		return $rs;
	}

	// function Registrar(array $entidad)
	// {
	// 	$bd = $this->objData;
	// 	$rpta = 0;
	// 	if ($entidad['tm_idusuario'] == 0){
	// 		$rptaUser = $bd->set_insert($entidad, "tm_usuario");
	// 		if ($rptaUser > 0)
	// 			$rpta = $this->RegisterUserPerfil($rptaUser, $entidad['tm_idperfil']);
	// 	}
	// 	else
	// 		$rpta = $bd->set_update($entidad, "tm_usuario", "tm_idusuario = ".$entidad['tm_idusuario']);
	// 	return $rpta;
	// }

	function Registrar($idusuario, $idempresa, $idcentro, $idperfil, $idpersona, $tipopersona, $codigo, $login, $nombres, $apellidos, $clave, $sexo, $nrodni, $nroruc, $idpais, $direccion, $email, $telefono, $foto, $modulo, $idusuarioregistrador, $idcentrocosto, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idusuario, $idempresa, $idcentro, $idperfil, $idpersona, $tipopersona, $codigo, $login, $nombres, $apellidos, $clave, $sexo, $nrodni, $nroruc, $idpais, $direccion, $email, $telefono, $foto, $modulo, $idusuarioregistrador, $idcentrocosto), '@rpta, @titulomsje, @contenidomsje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		
		return $rpta;
	}
	
	function Registrar_Plataforma($_login, $_clave, $_esempresa, $_idciudad, $_numerodoc, $_razonsocial, $_nombres, $_apellidos, $_email, $idusuario_registrador, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_plataforma_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($_login, $_clave, $_esempresa, $_idciudad, $_numerodoc, $_razonsocial, $_nombres, $_apellidos, $_email, $idusuario_registrador), '@rpta, @titulomsje, @contenidomsje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomsje = $result[0]['@contenidomsje'];
		
		return $rpta;
	}

	function EliminarStepByStep($idusuario, $idusuario_registrador, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_usuario_eliminar';
        $params = array($idusuario, $idusuario_registrador);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	// function MultiDelete($listIds)
	// {
	// 	$bd = $this->objData;
	// 	$rpta = 0;
	// 	$rpta = $bd->set_delete("tm_usuario", "tm_idusuario IN ($listIds)");
	// 	return $rpta;
	// }

	function ToogleState($iditem, $state)
	{
		$bd = $this->objData;
		$rpta = 0;
		$rpta = $bd->set_update(array("Activo" => $state), "tm_usuario", "tm_idusuario = ".$iditem);
		return $rpta;
	}

	// public function RegisterUserPerfil($idusuario, $idperfil)
	// {
	// 	$bd = $this->objData;
	// 	$rpta = 0;
	// 	$entidadPerfilUsuario = array(
	// 		'tm_idperfil' => $idperfil, 
	// 		'tm_idusuario' => $idusuario,
	// 		'IdUsuarioReg' => 1,
	// 		'FechaReg' => date("Y-m-d h:i:s"),
	// 		'IdUsuarioAct' => 1,
	// 		'FechaAct' => date("Y-m-d h:i:s")
	// 	);
	// 	$rpta = $bd->set_insert($entidadPerfilUsuario, "td_perfilusuario");
	// 	return $rpta;
	// }

	function Usuario_ImportData($idusuario, $idempresa, $idcentro, $pregunta, $idusuario_registrador, &$rpta, &$titulomsje, &$contenidomsje)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_usuario_plataforma_preliminar';
        $params = array($idusuario, $idempresa, $idcentro, $pregunta, $idusuario_registrador);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function ActualizarUserPass($idusuario, $clave, $idusuarioregistrador, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_usuario_actualizar_userpass';
		$result = $bd->exec_sp_iud($sp_name, array($idusuario, $clave, $idusuarioregistrador), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

	function IfExists__UsuarioPersona($tipopersona, $idpersona)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_checkexists_persona', array($tipopersona, $idpersona));
		return $rs;
	}

	function IfExists__UsuarioEmail($email)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_usuario_checkexists_email', array($email));
		return $rs;
	}
}
?>