<?php
class clsEvaluacionCliente_oneconnect
{
    private $objData;
   
    function clsEvaluacionCliente_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function RegistrarMaestro($connect, $idevaluacion, $idempresa, $idcentro, $fecha, $idcliente, $altura, $peso, $imc, $grasa, $observaciones, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_evaluacion_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idevaluacion, $idempresa, $idcentro, $fecha, $idcliente, $altura, $peso, $imc, $grasa, $observaciones, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function EliminarDetalle($connect, $idevaluacion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_evaluaciondetallesocio_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idevaluacion, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function RegistrarDetalle($connect, $idevaluaciondetallesocio, $idempresa, $idcentro, $idevaluacion, $idcliente, $idzonacorporal, $medida, $observaciones, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_evaluaciondetallesocio_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idevaluaciondetallesocio, $idempresa, $idcentro, $idevaluacion, $idcliente, $idzonacorporal, $medida, $observaciones, $idusuario), '@rpta, @titulomsje, @contenidomsje');
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