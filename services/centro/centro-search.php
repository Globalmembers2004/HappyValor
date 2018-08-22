<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/centro.php';

$tipoconsulta = isset($_GET['tipoconsulta']) ? $_GET['tipoconsulta'] : 'GENERAL';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$idregion = isset($_GET['idregion']) ? $_GET['idregion'] : '0';
$nombrearticulo = isset($_GET['nombrearticulo']) ? $_GET['nombrearticulo'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsCentro();

if ($tipoconsulta == 'COMENSAL')
	$row = $objData->Listar__Comensal($tipobusqueda, $idregion, $nombrearticulo, $criterio);
else
	$row = $objData->Listar($tipobusqueda, $id, $criterio);

echo json_encode($row);
flush();
?>