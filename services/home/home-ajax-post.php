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
    require '../../adata/Db.class.php';
    require '../../bussiness/centro.php';

    $sesion = new sesion();
    $objCentro = new clsCentro();

    $hdIdEmpresa = $_POST['hdIdEmpresa'];
    $hdIdCentro = $_POST['hdIdCentro'];

    $sesion->set('idempresa', $hdIdEmpresa);
    $sesion->set('idcentro', $hdIdCentro);

    $rsCentro = $objCentro->Listar('2', $hdIdCentro, '');
    $nombre_centro = (count($rsCentro) > 0) ? $rsCentro[0]['tm_nombre'] : 'Centro sin especificar';

    $sesion->set('nombre_centro', $nombre_centro);
    
    $jsondata = array("rpta" => $hdIdCentro, 'titulomsje' => 'Programando pedido...');
    echo json_encode($jsondata);
}
?>
