<?php
class clsRutinacliente
{
	function clsRutinacliente()
	{
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rutinasocio_listar', array($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina));
		return $rs;
	}

	function ListarZonas($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rutinadetallesocio_listar', array($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina));
		return $rs;
	}

	function ListarDetalleZonas($tipo, $idempresa, $idcentro, $idcliente, $idzona, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rutinadetallesocio_listar', array($tipo, $idempresa, $idcentro, $idcliente, $idzona, $criterio, $pagina));
		return $rs;
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
		$rpta = $bd->set_update(array('Activo' => '0'), 'tm_rutinacliente', "tm_idrutinacliente IN ($listIds)");
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_rutinasocio_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function ListarDetalle($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_rutinadetallesocio_listar', array($tipo, $idempresa, $idcentro, $idcliente, $id, $criterio, $pagina));
		return $rs;
	}
}
?>