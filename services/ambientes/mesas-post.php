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
    require "../../common/sesion.class.php";
    require '../../common/class.translation.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $hdIdAmbiente = isset($_POST['hdIdAmbiente']) ? $_POST['hdIdAmbiente'] : '0';
    
    if (isset($_POST['btnGuardarAmbiente']) || isset($_POST['btnEliminarAmbiente'])){
        require '../../bussiness/ambientes.php';
        $objAmbiente = new clsAmbiente();

        if (isset($_POST['btnGuardarAmbiente'])) {
            $txtCodigoAmbiente = isset($_POST['txtCodigoAmbiente']) ? $_POST['txtCodigoAmbiente'] : '';
            $txtNombreAmbiente = isset($_POST['txtNombreAmbiente']) ? $_POST['txtNombreAmbiente'] : '';

            $objAmbiente->RegistrarAmbientes($hdIdAmbiente, $IdEmpresa, $IdCentro, $txtCodigoAmbiente, $txtNombreAmbiente, $idusuario, $rpta, $titulomsje, $contenidomsje);

            if ($rpta > 0)
                $rpta = $objAmbiente->ListarAmbientes('2', $IdEmpresa, $IdCentro, $rpta, '', 0);
        }
        else
            $objAmbiente->EliminarAmbientes($hdIdAmbiente, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    else {
        require '../../bussiness/mesas.php';
        $objMesa = new clsMesa();
        
        $hdIdMesa = isset($_POST['hdIdMesa']) ? $_POST['hdIdMesa'] : '0';
        
        if (isset($_POST['btnGuardarMesa'])) {
            $txtCodigoMesa = isset($_POST['txtCodigoMesa']) ? $_POST['txtCodigoMesa'] : '';
            $chkCorrelativoMesa = isset($_POST['chkCorrelativoMesa']) ? $_POST['chkCorrelativoMesa'] : '0';
            $txtNroComensales = (isset($_POST['txtNroComensales'])) ? $_POST['txtNroComensales'] : '1';
            $txtNombreMesa = (isset($_POST['txtNombreMesa'])) ? $_POST['txtNombreMesa'] : '';

            $objMesa->RegistrarMesas($hdIdMesa, $IdEmpresa, $IdCentro, $hdIdAmbiente, $txtCodigoMesa, $txtNombreMesa, $chkCorrelativoMesa, $txtNroComensales, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
        elseif (isset($_POST['btnEliminarMesa']))
            $objMesa->EliminarMesas($hdIdMesa, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>