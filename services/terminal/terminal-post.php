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

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    
    $lang = isset($_POST['lang']) ? $_POST['lang'] : 'es';
    $translate = new Translator($lang);

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $IdEmpresa = $sesion->get("idempresa");
    $IdCentro = $sesion->get("idcentro");

    $hdIdTerminal = isset($_POST['hdIdTerminal']) ? $_POST['hdIdTerminal'] : '0';
    
    if (isset($_POST['btnGuardarTerminal']) || isset($_POST['btnEliminarTerminal'])){
        require '../../bussiness/terminal.php';
        $objTerminal = new clsTerminal();
        
        if (isset($_POST['btnGuardarTerminal'])){
            $txtNombre = $_POST['txtNombre'];
            $txtDireccionIP = $_POST['txtDireccionIP'];
            
            $objTerminal->Registrar($hdIdTerminal, $IdEmpresa, $IdCentro, $txtNombre, $txtDireccionIP, $idusuario, $rpta, $titulomsje, $contenidomsje);

            if ($rpta > 0)
                $rpta = $objTerminal->Listar('2', $IdEmpresa, $IdCentro, $rpta, '');
        }
        elseif (isset($_POST['btnEliminarTerminal']))
            $objTerminal->EliminarStepByStep($hdIdTerminal, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    else {
        require '../../bussiness/numeracionventa.php';
        $objNumeracionVenta = new clsNumeracionVenta();

        $hdIdSerie = isset($_POST['hdIdSerie']) ? $_POST['hdIdSerie'] : '0';

        if (isset($_POST['btnGuardarSerie'])){
            $ddlTipoComprobante = $_POST['ddlTipoComprobante'];
            $txtSerie = $_POST['txtSerie'];
            $txtCorrelativo = $_POST['txtCorrelativo'];
            
            $objNumeracionVenta->Registrar($hdIdSerie, $IdEmpresa, $IdCentro, $ddlTipoComprobante, $hdIdTerminal, $txtSerie, $txtCorrelativo, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
        elseif (isset($_POST['btnEliminarSerie']))
            $objNumeracionVenta->Eliminar($hdIdSerie, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array("rpta" => $rpta, 'titulomsje' => $translate->__s($titulomsje), 'contenidomsje' => $translate->__s($contenidomsje));
    echo json_encode($jsondata);
}
?>