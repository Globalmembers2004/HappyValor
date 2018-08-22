<?php
require '../../adata/Db.class.php';
require '../../bussiness/grupos.php';

$IdEmpresa = 1;
$IdCentro = 1;

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '00';
$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsGrupo();
$row = $objData->ListarSecciones($tipo, $id);

echo json_encode($row);
flush();
?>