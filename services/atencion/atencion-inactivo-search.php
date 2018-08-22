<?php
require '../../adata/Db.class.php';
require '../../bussiness/atencion.php';

$IdEmpresa = 1;
$IdCentro = 1;

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$objAtencion = new clsAtencion();

$row = $objAtencion->ListarAtencionInactiva($tipobusqueda, $IdEmpresa, $IdCentro);
echo json_encode($row);
flush();
?>