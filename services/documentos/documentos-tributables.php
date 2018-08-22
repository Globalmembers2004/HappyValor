<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/documentos.php';

$codigotributable = isset($_GET['codigotributable']) ? $_GET['codigotributable'] : '1';

$objData = new clsDocumentos();
$row = $objData->CodigoTributable($codigotributable);

echo json_encode($row);
flush();
?>