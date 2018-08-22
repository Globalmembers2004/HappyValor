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
    require '../../bussiness/rutinagymdetalle.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsRutinagymdetalle();

    $hdIdPrimary = $_POST['hdIdPrimary'];

    if (isset($_POST['btnGuardar'])){
        $txtDetalle = $_POST['txtDetalle'];
        $ddlRutina = $_POST['ddlRutina'];
        $ddlZonacorporal = $_POST['ddlZonacorporal'];
        $ddlEquipo = $_POST['ddlEquipo'];
        $txtSerie = $_POST['txtSerie'];
        $txtRepeticiones = $_POST['txtRepeticiones'];
        $txtPeso = $_POST['txtPeso'];
        
        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $txtDetalle, $ddlRutina, 0, $ddlZonacorporal, $ddlEquipo, $txtSerie, $txtRepeticiones, $txtPeso, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar']))

            $objData->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>