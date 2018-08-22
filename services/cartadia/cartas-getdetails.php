<?php
require '../../adata/Db.class.php';
require '../../bussiness/cartadia.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsCartaDia();
$row = $objData->ListarCartas('2', $IdEmpresa, $IdCentro, 0, $id);

if (isset($row))
	echo json_encode($row);
flush();
?>