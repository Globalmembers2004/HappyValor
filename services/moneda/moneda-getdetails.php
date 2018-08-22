<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/monedas.php';

$objData = new clsMoneda();

$id = isset($_GET['id']) ? $_GET['id'] : '0';

$row = $objData->Listar('2', $id, '',1);

echo json_encode($row);
flush();
?>