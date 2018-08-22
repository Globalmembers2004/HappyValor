<?php
class clsMoneda {
	private $objData;
	
	function clsMoneda()
	{
		$this->objData = new Db();
	}

	/*function Listar($tipo, $param1)
	{
		$bd = $this->objData;
		
		$tabla = 'tm_moneda';
		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		$criterio = '';

		if ($tipo === 'L' || $tipo === 'ALL'){			
			if ($tipo === 'L')
				$campos = array('tm_idmoneda', 'tm_nombre', 'tm_simbolo');
			elseif ($tipo === 'ALL')
				$campos = '*';
			
			$condicion = 'Activo = 1';
			if ($param1 != '')
				$condicion .= ' AND tm_nombre like \'%'.$param1.'%\'';
			$orden = 'tm_nombre';
		}
		elseif ($tipo === 'O'){
			$campos = array('tm_idmoneda', 'tm_nombre', 'tm_simbolo');
			$condicion = 'tm_idmoneda = '.$param1;
		}
		$rs = $bd->set_select($campos, $tabla, $condicion);
		
		return $rs;
	}*/

	function Listar($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_moneda_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	function Registrar($idmoneda, $nombre, $simbolo, $p_default, $abrev, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_moneda_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idmoneda, $nombre, $simbolo, $p_default, $abrev, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_moneda_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function ListarVigMoneda($tipo = "ACTUAL", $fechaini = "", $fechafin = "")
	{
		$bd = $this->objData;

		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		if ($tipo === "ACTUAL"){
			$tabla = "td_vigencia_moneda as a INNER JOIN tm_moneda as b ON a.tm_idmoneda = b.tm_idmoneda";
			$campos = "b.tm_idmoneda, b.tm_nombre, b.tm_simbolo, a.td_importe";
			$condicion = "(NOW() BETWEEN a.td_fechainicio AND a.td_fechafin) and b.Activo = 1";
			$orden = "b.tm_default DESC";
		}

		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
}
?>