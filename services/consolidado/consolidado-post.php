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
    require '../../bussiness/consolidado.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsConsolidado();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : '';
        $txtPeriodo = (isset($_POST['txtPeriodo'])) ? $_POST['txtPeriodo'] : '';
        $txtImporte = (isset($_POST['txtImporte'])) ? $_POST['txtImporte'] : '';
        $txtSubdiario = (isset($_POST['txtSubdiario'])) ? $_POST['txtSubdiario'] : '';
        $txtInicio = (isset($_POST['txtInicio'])) ? $_POST['txtInicio'] : '';

        $rpta = $objData->Proceso($txtPeriodo, $txtImporte, $txtInicio, $txtSubdiario , $rpta, $titulomsje, $contenidomsje);
        
        $rpta = $objData->Registrar($hdIdPrimary, $txtDescripcion, $txtPeriodo, $txtSubdiario, $txtImporte, $txtInicio, $idusuario, $rpta, $titulomsje, $contenidomsje);

    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdConsolidado = $_POST['hdIdConsolidado'];
        $rpta = $objData->EliminarStepByStep($hdIdConsolidado, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>