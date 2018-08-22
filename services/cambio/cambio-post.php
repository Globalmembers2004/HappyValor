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
    require '../../bussiness/cambio.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsCambio();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtFecha = (isset($_POST['txtFecha'])) ? $_POST['txtFecha'] : '';
        $txtTipoCambio = (isset($_POST['txtTipoCambio'])) ? $_POST['txtTipoCambio'] : '';
        
        $rpta = $objData->Registrar($hdIdPrimary, $txtFecha, $txtTipoCambio, $idusuario, $rpta, $titulomsje, $contenidomsje);

    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdCambio = $_POST['hdIdCambio'];
        $rpta = $objData->EliminarStepByStep($hdIdCambio, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>