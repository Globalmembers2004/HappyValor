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
    require '../../bussiness/cliente.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsCliente();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtCodigo = (isset($_POST['txtCodigo'])) ? $_POST['txtCodigo'] : '';
        $txtTipo = (isset($_POST['txtTipo'])) ? $_POST['txtTipo'] : '';
        $txtDocIdentidad = (isset($_POST['txtDocIdentidad'])) ? $_POST['txtDocIdentidad'] : '';
        $txtRuc = (isset($_POST['txtRuc'])) ? $_POST['txtRuc'] : '';
        $txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : '';
        $txtTipoPersona = (isset($_POST['txtTipoPersona'])) ? $_POST['txtTipoPersona'] : '';
        $txtDireccion = (isset($_POST['txtDireccion'])) ? $_POST['txtDireccion'] : '';
        $txtTelefono = (isset($_POST['txtTelefono'])) ? $_POST['txtTelefono'] : '';
        
        $rpta = $objData->Registrar($hdIdPrimary, $txtCodigo, $txtTipo, $txtDocIdentidad, $txtRuc, $txtDescripcion, $txtTipoPersona, $txtDireccion, $txtTelefono, $idusuario, $rpta, $titulomsje, $contenidomsje);

    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdCliente = $_POST['hdIdCliente'];
        $rpta = $objData->EliminarStepByStep($hdIdCliente, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>