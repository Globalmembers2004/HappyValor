<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

include("../../common/sesion.class.php");
include('../../adata/Db.class.php');
include('../../bussiness/categoriainsumo.php');

$sesion = new sesion();
$idusuario = $sesion->get("idusuario");
$idperfil = $sesion->get("idperfil");

$rpta = 0;
$titulomsje = '';
$contenidomsje = '';

$objData = new clsCategoriaInsumo();

if ($_POST){
    if (isset($_POST['btnAplicarCategoria'])){
        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';

        $hdIdCategoria = isset($_POST['hdIdCategoria']) ? $_POST['hdIdCategoria'] : '0';
        $txtNombreCategoria = isset($_POST['txtNombreCategoria']) ? $_POST['txtNombreCategoria'] : '';

        $objData->Registrar($hdIdCategoria, $IdEmpresa, $IdCentro, $txtNombreCategoria, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdCategoria = $_POST['hdIdCategoria'];
        $objData->EliminarStepByStep($hdIdCategoria, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>