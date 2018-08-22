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
    require '../../bussiness/enlaces.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsEnlaces();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtLocal = (isset($_POST['txtLocal'])) ? $_POST['txtLocal'] : '';
        $txtCuenta_12 = (isset($_POST['txtCuenta_12'])) ? $_POST['txtCuenta_12'] : '';
        $txtCuenta_40 = (isset($_POST['txtCuenta_40'])) ? $_POST['txtCuenta_40'] : '';
        $txtCuentaFacturas = (isset($_POST['txtCuenta_Facturas'])) ? $_POST['txtCuenta_Facturas'] : '';
        $txtCuentaBoletas = (isset($_POST['txtCuentaBoletas'])) ? $_POST['txtCuentaBoletas'] : '';
        $txtCentroCosto = (isset($_POST['txtCentroCosto'])) ? $_POST['txtCentroCosto'] : '';
        $txtNombreLocal = (isset($_POST['txtNombreLocal'])) ? $_POST['txtNombreLocal'] : '';
        $txtSerie = (isset($_POST['txtSerie'])) ? $_POST['txtSerie'] : '';
        $txtCodigo = (isset($_POST['txtCodigo'])) ? $_POST['txtCodigo'] : '';
        
        $rpta = $objData->Registrar($hdIdPrimary, $txtLocal, $txtCuenta_12, $txtCuenta_40, $txtCuentaFacturas, $txtCuentaBoletas, $txtCentroCosto, $txtNombreLocal, $txtSerie, $txtCodigo, $idusuario, $rpta, $titulomsje, $contenidomsje);

    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdEnlace = $_POST['hdIdEnlace'];
        $rpta = $objData->EliminarStepByStep($hdIdEnlace, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>