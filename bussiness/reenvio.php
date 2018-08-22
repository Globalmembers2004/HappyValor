<?php
class clsReenvio
{
	private $objData;
	
	function clsReenvio()
	{
		$this->objData = new Db();
	}

	function ListarReenvio($tipo, $idempresa, $idcentro, $idperiodo, $idproducto, $idcencosto_ori,  $idcencosto_des, $idinventario, $id, $criterio, $pagina)
	{
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_reenvio_listar', array($tipo, $idempresa, $idcentro, $idperiodo, $idproducto, $idcencosto_ori,  $idcencosto_des, $idinventario, $id, $criterio, $pagina));
		return $rs;
	}

	function EliminarReenvio($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_reenvio_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }

	function RegistrarReenvio($idenvio, $idempresa, $idcentro, $idinventario, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_reenvio_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idenvio, $idempresa, $idcentro, $idinventario, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}


    function ModificarReenvio($idenvio, $idempresa, $idcentro, $idinventario, $idperiodo, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario, &$rpta, &$titulomsje, &$contenidomensaje)
	{
		$bd = $this->objData;
        $sp_name = 'pa_reenvio_eliminar';
        $params = array($idenvio, $idusuario);
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');
		$sp_name = 'pa_reenvio_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idenvio, $idempresa, $idcentro, $idinventario, $idperiodo, $idproducto, $idcencosto_ori, $idcencosto_des, $cantenv, $idusuario), '@rpta, @titulomsje, @contenidomsje');
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomsje'];
		return $rpta;
	}

}
?>