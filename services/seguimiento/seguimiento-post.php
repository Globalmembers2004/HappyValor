<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../common/functions.php';
    require '../../bussiness/seguimiento.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsseguimiento();

    
    if (isset($_POST['btnGuardar'])){

        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $equilibrio = (isset($_POST['ddlPeriodo'])) ? $_POST['ddlPeriodo'] : '';
        $ingresos = (isset($_POST['txtIngresos'])) ? $_POST['txtIngresos'] : '';
        $meta = (isset($_POST['txtMeta'])) ? $_POST['txtMeta'] : '';
        $faltante = (isset($_POST['txtFaltante'])) ? $_POST['txtFaltante'] : '';
        $servicios = (isset($_POST['txtServicios'])) ? $_POST['txtServicios'] : '';
        $sueldos = (isset($_POST['txtSueldos'])) ? $_POST['txtSueldos'] : '';
        $otros = (isset($_POST['txtOtros'])) ? $_POST['txtOtros'] : '';
        $total = (isset($_POST['txtTotal'])) ? $_POST['txtTotal'] : '';
        $porcentaje = (isset($_POST['txtPorcentaje'])) ? $_POST['txtPorcentaje'] : '';
        $observacion = (isset($_POST['txtObservacion'])) ? $_POST['txtObservacion'] : '';

        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $equilibrio , $servicios, $sueldos, $otros, $total, $ingresos, $meta, $faltante, $porcentaje, $observacion, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        
        $hdIdseguimiento = $_POST['hdIdseguimiento'];

        $rpta = $objData->EliminarStepByStep($hdIdseguimiento, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>

