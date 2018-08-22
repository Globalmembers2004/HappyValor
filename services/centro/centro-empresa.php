<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../common/sesion.class.php';
require '../../adata/Db.class.php';
require '../../bussiness/centro.php';

$sesion = new sesion();
$objData = new clsCentro();

$IdEmpresa = $sesion->get("idempresa");
$row = $objData->Listar('1', $IdEmpresa, '');

echo json_encode($row);
flush();
?>