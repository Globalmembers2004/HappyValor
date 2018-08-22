<?php
class clsCliente
{
	function clsCliente()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $id, $criterio, $pagina ){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_cliente_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}
	
	function Registrar($idcliente, $codigo, $tipo, $doc_identidad, $ruc, $descripcion, $tipo_persona, $direccion, $telefono, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_cliente_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idcliente, $codigo, $tipo, $doc_identidad, $ruc, $descripcion, $tipo_persona, $direccion, $telefono, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
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
		$rpta = $bd->set_update(array('Activo' => '0'), 'clientes', "tm_idcliente IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_cliente_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
	
}
?>