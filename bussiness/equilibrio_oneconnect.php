<?php
class clsEquilibrio_oneconnect
{
    private $objData;
   
    function clsEquilibrio_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function RegistrarMaestro($connect, $idequilibrio, $idempresa, $idcentro, $mes, $anno, $servicios, $sueldos, $otros, $total, $utilidad, $meta, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_equilibrio_registrar';

        $result = $bd->exec_sp_iud($connect, $sp_name, array($idequilibrio, $idempresa, $idcentro, $mes, $anno, $servicios, $sueldos, $otros, $total, $utilidad, $meta, $idusuario), '@rpta, @titulomsje, @contenidomensaje');

        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomensaje = $result[0]['@contenidomensaje'];

        return $rpta;
    }

    function EliminarDetalle($connect, $idevaluacion, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_detalle_equilibrio_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idevaluacion, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function RegistrarDetalle($connect, $idequilibrio, $idempresa, $idcentro, $principalequilibrio, $idcliente, $tipo_servicio, $nombre, $total, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_detalle_equilibrio_registrar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($idequilibrio, $idempresa, $idcentro, $principalequilibrio, $idcliente, $tipo_servicio, $nombre, $total, $idusuario), '@rpta, @titulomsje, @contenidomsje');
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