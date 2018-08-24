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
    require '../../bussiness/enlace.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");

    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsenlace();

    $hdIdPrimary = $_POST['hdIdPrimary'];

    if (isset($_POST['btnGuardar'])){
        $idtipofamilia = (isset($_POST['ddlTipoFamilia'])) ? $_POST['ddlTipoFamilia'] : '';
        $idcencosto = (isset($_POST['ddlCenCos'])) ? $_POST['ddlCenCos'] : '';
        $idctactb = (isset($_POST['ddlCtaCtb'])) ? $_POST['ddlCtaCtb'] : '';
        
        $rpta = $objData->Registrar($hdIdPrimary, $IdEmpresa, $IdCentro, $idcencosto, $idtipofamilia, $idctactb, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    elseif (isset($_POST['btnEliminar']))
            $objData->EliminarStepByStep($hdIdPrimary, $idusuario, $rpta, $titulomsje, $contenidomsje);
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>