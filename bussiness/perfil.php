<?php
/**
* 
*/
class clsPerfil
{
	function clsPerfil()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_perfil_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Guardar($idperfil, $idempresa, $idcentro, $nombre, $descripcion, $abreviatura, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_perfil_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idperfil, $idempresa, $idcentro, $nombre, $descripcion, $abreviatura, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function Eliminar($idperfil, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_perfil_eliminar';
		$result = $bd->exec_sp_iud($sp_name, array($idperfil), '@rpta, @titulomsje, @contenidomensaje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return 1;
	}

	function RegistrarPerfilMenu($idperfil, $idempresa, $idcentro, $listIdMenu, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_perfil_menu_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idperfil, $idempresa, $idcentro, $listIdMenu, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return 1;
	}

	function PerfilUsuarioListar($tipo, $idperfil, $idusuario, $idempresa, $idcentro)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_perfil_usuario_listar', array($tipo, $idperfil, $idusuario, $idempresa, $idcentro));
		return $rs;
	}

	function GetPerfil__PorCodigo($codigo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_perfil__por_codigo', array($codigo));
		return $rs;
	}
}
?>