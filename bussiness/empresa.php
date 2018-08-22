<?php
class clsEmpresa
{
	function clsEmpresa()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_empresa_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idempresa, $nombre_comercial, $razon_social, $direccion_fiscal, $descripcion_comercial, $eslogan, $codigo_fiscal, $email, $telefono, $pagina_web, $observaciones, $logo, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_empresa_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $nombre_comercial, $razon_social, $direccion_fiscal, $descripcion_comercial, $eslogan, $codigo_fiscal, $email, $telefono, $pagina_web, $observaciones, $logo, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_empresa_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function checkNumeroDoc($numerodoc, $idregistro)
	{
		$bd = $this->objData;
		$condicion = "tm_codigo_fiscal = '".$numerodoc."' AND tm_idempresa <> " . $idregistro;
		$tabla = 'tm_empresa';
		$campos = 'tm_idempresa';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}

	function checkOnlyEmail($email, $idregistro)
	{
		$bd = $this->objData;
		$condicion = "tm_email = '".$email."' AND tm_idempresa <> " . $idregistro;
		$tabla = 'tm_empresa';
		$campos = 'tm_idempresa';
		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
}
?>