<?php
class clsGrupo
{
	function clsGrupo()
	{
		$this->objData = new Db();
	}

	public function Listar($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_grupo_vigprecio_listar', array($tipo, $idempresa, $idcentro, $id, $fechaini, $fechafin, $criterio, $pagina));
		return $rs;
	}

	public function ListarSeccionPack($tipo, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_seccionpack_listar', array($tipo, $id, $criterio, $pagina));
		return $rs;
	}

	public function ListarSecciones($tipo, $idgrupoarticulo)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_detalle_grupo_listar', array($tipo, $idgrupoarticulo));
		return $rs;
	}

	function Registrar($idgrupoarticulo, $idempresa, $idcentro, $nombre, $nrosecciondefault, $idmoneda, $precio, $idusuario, &$rpta)
	{
		$bd = $this->objData;
		$sp_name = 'pa_grupo_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idgrupoarticulo, $idempresa, $idcentro, $nombre, $nrosecciondefault, $idmoneda, $precio, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_grupo_articulo_eliminar_stepbystep';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

    function EliminarSecciones($idgrupoarticulo, $idusuario, &$rpta)
    {
    	$bd = $this->objData;
        $sp_name = 'pa_seccionpack_eliminar';
        $params = array($idgrupoarticulo, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta');

        $rpta = $result[0]['@rpta'];

        return $rpta;
    }


    function RegistrarSeccion($idgrupoarticulo, $idseccionpack, $nombreseccion, $orden, $idusuario, &$rpta)
    {
    	$bd = $this->objData;
		$sp_name = 'pa_seccionpack_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idgrupoarticulo, $idseccionpack, $nombreseccion, $orden, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
    }

    function AsignarGrupoArticulo($idempresa, $idcentro, $idgrupoarticulo, $idseccion, $listaProductos, $idusuario, &$rpta)
    {
    	$bd = $this->objData;
		$sp_name = 'pa_grupo_articulo_asignar';
		$result = $bd->exec_sp_iud($sp_name, array($idempresa, $idcentro, $idgrupoarticulo, $idseccion, $listaProductos, $idusuario), '@rpta');
		$rpta = $result[0]['@rpta'];
		return $rpta;
    }
}
?>