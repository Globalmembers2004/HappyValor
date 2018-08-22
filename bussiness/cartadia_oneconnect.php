<?php
class clsCartaDia_oneconnect
{
    private $objData;
   
    function clsCartaDia_oneconnect()
    {
        $this->objData = new DbOneConnect();
    }

    function AperturarProgramacion($connect, $tipomenu, $idempresa, $idcentro, $idgrupo, $idkardexsalida, $fechaMenu, $tipoOperacion, $listIdProducto, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_programacion_aperturar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($tipomenu, $idempresa, $idcentro, $idgrupo, $idkardexsalida, $fechaMenu, $tipoOperacion, $listIdProducto, $idusuario), '@rpta, @titulomsje, @contenidomsje');
        $rpta = $result[0]['@rpta'];
        $titulomsje = $result[0]['@titulomsje'];
        $contenidomsje = $result[0]['@contenidomsje'];
        return $rpta;
    }

    function EliminarProgramacion($connect, $tipomenu, $listIds, $idusuario, &$rpta, &$titulomsje, &$contenidomsje)
    {
        $bd = $this->objData;
        $sp_name = 'pa_programacion_eliminar';
        $result = $bd->exec_sp_iud($connect, $sp_name, array($tipomenu, $listIds, $idusuario), '@rpta, @titulomsje, @contenidomsje');
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