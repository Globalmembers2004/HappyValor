<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/atencion.php';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$idatencion = isset($_GET['idatencion']) ? $_GET['idatencion'] : '0';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

$objData = new clsAtencion();
$row = $objData->ListarDetalle($tipo, $idatencion, $estado);
echo json_encode($row);
flush();
?>