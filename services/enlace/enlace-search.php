<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/enlace.php';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$Id = isset($_GET['id']) ? $_GET['id'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsenlace();

$row = $objData->Listar($tipobusqueda, $Id, $criterio);


if (isset($row))
	echo json_encode($row);
flush();
?>