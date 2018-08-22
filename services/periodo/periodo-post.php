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
    require '../../common/functions.php';
    require '../../bussiness/periodo.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsperiodo();

    $hdIdPrimary = $_POST['hdIdPrimary'];

    if (isset($_POST['btnGuardar'])){
        $txtNombre = $_POST['txtNombre'];
        $estado = isset($_GET['estado']) ? $_GET['estado'] : '01';
        $txtFechaInicio = isset($_POST['txtFechaInicio']) ? fecha_mysql($_POST['txtFechaInicio']) : date('Y-m-d');
        $txtFechaFinal = isset($_POST['txtFechaFinal']) ? fecha_mysql($_POST['txtFechaFinal']) : date('Y-m-d');

        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $txtNombre, $txtFechaInicio, $txtFechaFinal, $estado, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar']))
        
            $objData->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);

    elseif (isset($_POST['btnCerrar']))
        
            $objData->Cerrar($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);

    elseif (isset($_POST['btnFijar']))
        
            $objData->Fijar($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>