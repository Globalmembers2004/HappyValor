<?php
class clsProveedor
{
	function clsProveedor()
	{
		$this->objData = new Db();
	}

	/*function Listar($tipo, $arrayParams)
	{
		$bd = $this->objData;
		$tabla = '';
		$campos = '';
		$condicion = '';
		$orden = false;
		$pagina = 1;

		if ($tipo === 'L'){
			$tabla = 'tm_proveedor';
			
			if (is_array($arrayParams)) {
				$idempresa = $arrayParams['idempresa'];
				$criterio = $arrayParams['criterio'];
				$pagina = $arrayParams['pagina'];
			}

			$campos = array('tm_idproveedor', 'tm_nombreproveedor', 'tm_numerodoc', 'tm_direccion', 'tm_email', 'tm_telefono', 'tm_celular', 'tm_foto');
			
			$condicion = 'Activo = 1';
			
			if ($idempresa != '')
				$condicion .= ' and tm_idempresa = '.$idempresa;

			if ($criterio != '')
				$condicion .= ' and tm_nombreproveedor LIKE \'%'.$criterio.'%\'';
			
			$orden = 'tm_nombreproveedor';
			$firstLimit = 42;
			$start = ($pagina * $firstLimit) - $firstLimit;
			$limit = " $start, $firstLimit ";
		}
		elseif ($tipo === 'O'){
			$tabla = 'tm_proveedor';
			$campos = 'tm_idproveedor, tm_nombreproveedor, tm_nombrecontacto, tm_cargocontacto, tm_numerodoc, tm_direccion, tm_telefono, tm_celular, tm_email, tm_fax, tm_foto';
			$condicion = 'tm_idproveedor = '.$arrayParams;
		}
		elseif ($tipo === 'VALID'){
			$tabla = 'tm_proveedor';
			$campos = 'tm_idproveedor';
			$condicion = $arrayParams;
			$limit = '0, 1';
		}
		$rs = $bd->set_select($campos, $tabla, $condicion, $orden, false, $limit);
		return $rs;
	}*/

	function Listar($tipo, $idempresa, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_proveedor_listar', array($tipo, $idempresa, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idproveedor,  $idempresa,  $nombreproveedor,  $nombrecontacto,  $cargocontacto, $numerodoc, $direccion, $telefono, $celular, $email, $fax, $foto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_proveedor_registrar';

		$result = $bd->exec_sp_iud($sp_name, array($idproveedor,  $idempresa,  $nombreproveedor,  $nombrecontacto,  $cargocontacto, $numerodoc, $direccion, $telefono, $celular, $email, $fax, $foto, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

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
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_proveedor', "tm_idproveedor IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_proveedor_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>