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
    require '../../bussiness/clasecliente.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    // $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsRutinaCliente();

    if (isset($_POST['btnGuardar'])){
        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $hdIdCliente = (isset($_POST['hdIdCliente'])) ? $_POST['hdIdCliente'] : '0';
        $ddlClaseDisponible = (isset($_POST['ddlClaseDisponible'])) ? $_POST['ddlClaseDisponible'] : '0';

        $rpta = $objData->Registrar('0', $IdEmpresa, $IdCentro, $ddlClaseDisponible, $hdIdCliente, date('Y-m-d'), $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>