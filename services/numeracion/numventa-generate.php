<?php
require '../../adata/Db.class.php';
require '../../bussiness/numeracionventa.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$row = array(array());

$idterminal = isset($_GET['idterminal']) ? $_GET['idterminal'] : '0';
$idtipocomprobante = isset($_GET['idtipocomprobante']) ? $_GET['idtipocomprobante'] : '0';

$parametros = array(
	'idterminal' => $idterminal,
	'idtipocomprobante' => $idtipocomprobante,
	'criterio' => '' );

$objNumVenta = new clsNumeracionVenta();

$row = $objNumVenta->Listar('G', $parametros);

if (isset($row))
	echo json_encode($row);
flush();
?>