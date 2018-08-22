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
    require '../../bussiness/libroventas.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsLibroventas();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : '';
        $txtPeriodo = (isset($_POST['txtPeriodo'])) ? $_POST['txtPeriodo'] : '';
        $txtInicio = (isset($_POST['txtInicio'])) ? $_POST['txtInicio'] : '';

        set_time_limit(200);

        $rpta = $objData->Proceso($txtPeriodo, $txtInicio, $rpta, $titulomsje, $contenidomsje);
        
        set_time_limit(60);

        $rpta = $objData->Registrar($hdIdPrimary, $txtDescripcion, $txtPeriodo, $txtInicio, $idusuario, $rpta, $titulomsje, $contenidomsje);


    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdLibroventas = $_POST['hdIdLibroventas'];
        $rpta = $objData->EliminarStepByStep($hdIdLibroventas, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>