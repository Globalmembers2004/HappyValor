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
    require '../../bussiness/horariogrupal.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clshorariogrupal();

    $hdIdPrimary = $_POST['hdIdPrimary'];

    if (isset($_POST['btnGuardar'])){
        $ddlRutinaGrupal = (isset($_POST['ddlRutinaGrupal'])) ? $_POST['ddlRutinaGrupal'] : '';
        $ddlDia = (isset($_POST['ddlDia'])) ? $_POST['ddlDia'] : '01';
        $ddlInstructor = (isset($_POST['ddlInstructor'])) ? $_POST['ddlInstructor'] : '';
        $txtHoraInicio = (isset($_POST['txtHoraInicio'])) ? $_POST['txtHoraInicio'] : date('H:i:s A');
        $txtHoraFinal = (isset($_POST['txtHoraFinal'])) ? $_POST['txtHoraFinal'] : date('H:i:s A');
        $txtAforo = (isset($_POST['txtAforo'])) ? $_POST['txtAforo'] : '20';
        $txtminutos = (isset($_POST['txtminutos'])) ? $_POST['txtminutos'] : '10';
        
        $txtHoraInicio = date('H:i:s', strtotime($txtHoraInicio));
        $txtHoraFinal = date('H:i:s', strtotime($txtHoraFinal));

        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $ddlRutinaGrupal, $ddlInstructor, 0, $ddlDia, $txtHoraInicio, $txtHoraFinal, $txtAforo, $txtminutos, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar']))
            $objData->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>