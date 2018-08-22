<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/recomendacion.php';

$IdEmpresa = '1';
$IdCentro = '1';

$codigo = (isset($_GET['codigo'])) ? $_GET['codigo'] : '';

$objData = new clsRecomendacion();
$row = $objData->ObtenerPorCodigo($codigo);

echo json_encode($row);
flush();
?>