<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../adata/Db.class.php';
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../bussiness/monedas.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    // $IdEmpresa = 1;
    // $IdCentro = 1;

    $objData = new clsMoneda();

    $hdIdPrimary = $_POST['hdIdPrimary'];

    if (isset($_POST['btnGuardar'])){
        $txtNombre = $_POST['txtNombre'];
        $txtSimbolo = $_POST['txtSimbolo'];
        $chkDefault = isset($_POST['chkDefault']) ? $_POST['chkDefault'] : '0';
        $txtAbreviatura = $_POST['txtAbreviatura'];

        $objData->Registrar($hdIdPrimary, $txtNombre, $txtSimbolo, $chkDefault, $txtAbreviatura, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar']))
        $objData->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>