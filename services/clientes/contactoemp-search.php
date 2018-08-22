<?php
require '../../adata/Db.class.php';
require '../../bussiness/clientes.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ( !isset($_REQUEST['criterio']) ) {
	exit;
}

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsCliente();

$row = $objData->ListarContactoEmpresa($tipobusqueda, $id);

echo json_encode($row);
flush();
?>