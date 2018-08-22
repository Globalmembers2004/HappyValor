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
    require '../../bussiness/dieta.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsDieta();

    if (isset($_POST['btnGuardar'])){

        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : '';
        $txtPesominsg = (isset($_POST['txtPesominsg'])) ? $_POST['txtPesominsg'] : '';
        $txtPesomaxsg = (isset($_POST['txtPesomaxsg'])) ? $_POST['txtPesomaxsg'] : '';
        $txtCalorias = (isset($_POST['txtCalorias'])) ? $_POST['txtCalorias'] : '';
        $txtDocumento = (isset($_POST['txtDocumento'])) ? $_POST['txtDocumento'] : '';
  
        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $txtNombre, $txtPesominsg, $txtPesomaxsg, $txtCalorias, $txtDocumento,  $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdDieta = $_POST['hdIdDieta'];
        $rpta = $objData->EliminarStepByStep($hdIdDieta, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>