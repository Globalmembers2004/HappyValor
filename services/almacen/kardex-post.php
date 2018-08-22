<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST) {
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../common/functions.php';
    require '../../bussiness/kardex.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    
    $rpta = '0';

    $objData = new clsKardex();
    
    $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '0';
    $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '0';
    $ddlTipoExistencia = isset($_POST['ddlTipoExistencia']) ? $_POST['ddlTipoExistencia'] : '0';
    $ddlAnho = isset($_POST['ddlAnho']) ? $_POST['ddlAnho'] : '0';
    $ddlMes = isset($_POST['ddlMes']) ? $_POST['ddlMes'] : '0';
    $hdIdArticulo = isset($_POST['hdIdArticulo']) ? $_POST['hdIdArticulo'] : '0';

    $jsondata = $objData->Generar($ddlTipoExistencia, $IdEmpresa, $IdCentro, $ddlAnho, $ddlMes, $hdIdArticulo, $idusuario);
    echo json_encode($jsondata);
}
?>