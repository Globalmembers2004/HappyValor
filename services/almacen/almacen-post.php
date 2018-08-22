<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require "../../common/sesion.class.php";
require '../../adata/Db.class.php';
require '../../bussiness/almacen.php';

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$rpta = 0;
$titulomsje = '';
$contenidomsje = '';

$objData = new clsAlmacen();

if ($_POST){
    if (isset($_POST['btnAplicarAlmacen'])){
        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';

        $hdIdAlmacen = isset($_POST['hdIdAlmacen']) ? $_POST['hdIdAlmacen'] : '0';
        $txtNombreAlmacen = isset($_POST['txtNombreAlmacen']) ? $_POST['txtNombreAlmacen'] : '';
        $txtDireccionAlmacen = isset($_POST['txtDireccionAlmacen']) ? $_POST['txtDireccionAlmacen'] : '';
        $chkDefaultAlmacen = isset($_POST['chkDefaultAlmacen']) ? $_POST['chkDefaultAlmacen'] : '';
        
        $objData->Registrar($hdIdAlmacen, $IdEmpresa, $IdCentro, $txtNombreAlmacen, $txtDireccionAlmacen, $chkDefaultAlmacen, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdAlmacen = $_POST['hdIdAlmacen'];
        $objData->EliminarStepByStep($hdIdAlmacen, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>