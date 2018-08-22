<?php
class clsRutinaCliente_oneconnect
{
    private $objData;
   
    function clsRutinaCliente_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function RegistrarMaestro($connect, $idrutinasocio, $idempresa, $idcentro, $idcliente, $objetivo, $idinstructor, $fechainicial, $fechafinal, $imc_actual, $imc_meta, $calorias_meta, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_rutinasocio_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idrutinasocio, $idempresa, $idcentro, $idcliente, $objetivo, $idinstructor, $fechainicial, $fechafinal, $imc_actual, $imc_meta, $calorias_meta, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function EliminarDetalle($connect, $idrutinasocio, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_rutinadetallesocio_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idrutinasocio, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function RegistrarDetalle($connect, $idrutinadetallesocio, $idempresa, $idcentro, $idrutinasocio, $idzonacorporal, $idequipo, $serie, $repeticion, $peso, $observaciones, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_rutinadetallesocio_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idrutinadetallesocio, $idempresa, $idcentro, $idrutinasocio, $idzonacorporal, $idequipo, $serie, $repeticion, $peso, $observaciones, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function _conectar()
    {
    	$bd = $this->objData;
    	return $bd->conectar();
    }

    function _desconectar($connect)
    {
    	$bd = $this->objData;
    	return $bd->desconectar($connect);
    }
}
?>