<?php
class clsfamilia {

	private $objData;
	
	function clsfamilia(){
		$this->objData = new Db();
	}

	function Listar($tipo, $idempresa, $idcentro, $idtipoFamilia, $id, $criterio){
		$bd = $this->objData;
		$rs = $bd->exec_sp_select('pa_familia_listar', array($tipo, $idempresa, $idcentro, $idtipoFamilia, $id, $criterio));
		return $rs;
	}

	function Registrar($idfamilia, $idempresa, $idcentro, $codfam_star, $idtipoFamilia, $descripcion, $flag, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
	{
		$bd = $this->objData;
		$sp_name = 'pa_familia_registrar';
		$result = $bd->exec_sp_iud($sp_name, array($idfamilia, $idempresa, $idcentro, $codfam_star, $idtipoFamilia, $descripcion, $flag, $idusuario), '@rpta, @titulomsje, @contenidomensaje');
		
		$rpta = $result[0]['@rpta'];
		$titulomsje = $result[0]['@titulomsje'];
		$contenidomensaje = $result[0]['@contenidomensaje'];
		return $rpta;
	}

	function EliminarStepByStep($id, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_familia_eliminar';
        $params = array($id, $idusuario);
        
        $result = $bd->exec_sp_iud($sp_name, $params, '@rpta, @titulomsje, @contenidomsje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];

        return $rpta;
    }
}
?>