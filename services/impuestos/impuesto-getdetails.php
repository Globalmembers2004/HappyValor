<?php
require '../../adata/Db.class.php';
require '../../bussiness/impuestos.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsImpuesto();
$row = $objData->Listar('2', $IdEmpresa, $IdCentro, $id, '');

echo json_encode($row);
flush();
?>