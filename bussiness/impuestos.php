<?php
class clsImpuesto {
	private $objData;
	
	function clsImpuesto()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $id, $criterio)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_impuesto_listar', array($tipo, $idempresa, $idcentro, $id, $criterio));
		return $rs;
	}

	function Registrar($idimpuesto, $idempresa, $idcentro, $nombre, $porcentaje, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_impuesto_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idimpuesto, $idempresa, $idcentro, $nombre, $porcentaje, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_impuesto_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function ListarVigImpuesto($tipo = "ACTUAL", $fechaini = "", $fechafin = "")
	{
		$bd = $this->objData;

		$campos = '*';
		$condicion = '';
		$groupby = false;
		$orden = false;
		$limit = false;
		$lastid = 1;

		if ($tipo === "ACTUAL"){
			$tabla = "td_vigencia_impuesto as a INNER JOIN tm_impuesto as b ON a.tm_idimpuesto = b.tm_idimpuesto";
			$campos = "b.tm_idimpuesto, UPPER(b.tm_nombre) as tm_nombre, a.td_valorimpuesto";
			$condicion = "(NOW() BETWEEN a.td_fechainicio AND a.td_fechafin) and b.Activo = 1";
			$orden = ' b.tm_nombre DESC ';
		}

		$rs = $bd->set_select($campos, $tabla, $condicion);
		return $rs;
	}
}
?>