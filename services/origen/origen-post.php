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
    require '../../bussiness/origen.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsOrigen();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtTipoDoc = (isset($_POST['txtTipoDoc'])) ? $_POST['txtTipoDoc'] : '';
        $txtFolio = (isset($_POST['txtFolio'])) ? $_POST['txtFolio'] : '';
        $txtRucreceptor = (isset($_POST['txtRucreceptor'])) ? $_POST['txtRucreceptor'] : '';
        $txtRazonSocial = (isset($_POST['txtRazonSocial'])) ? $_POST['txtRazonSocial'] : '';
        $txtFechaEmision = (isset($_POST['txtFechaEmision'])) ? $_POST['txtFechaEmision'] : '';
        $txtMoneda = (isset($_POST['txtMoneda'])) ? $_POST['txtMoneda'] : '';
        $txtLocal = (isset($_POST['txtLocal'])) ? $_POST['txtLocal'] : '';
        $txtIgv = (isset($_POST['txtIgv'])) ? $_POST['txtIgv'] : '';
        $txtGravadas = (isset($_POST['txtGravadas'])) ? $_POST['txtGravadas'] : '';
        $txtTotal = (isset($_POST['txtTotal'])) ? $_POST['txtTotal'] : '';
        $txtReferencia = (isset($_POST['txtReferencia'])) ? $_POST['txtReferencia'] : '';
        
        $rpta = $objData->Registrar($hdIdPrimary, $txtTipoDoc, $txtFolio, $txtRucreceptor, $txtRazonSocial, $txtFechaEmision, $txtMoneda, $txtIgv, $txtGravadas, $txtTotal, $txtReferencia, $txtLocal, $idusuario, $rpta, $titulomsje, $contenidomsje);

    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdOrigen = $_POST['hdIdOrigen'];
        $rpta = $objData->EliminarStepByStep($hdIdOrigen, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>