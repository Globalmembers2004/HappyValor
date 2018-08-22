<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/ubigeo.php';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : 'ATENCION-AMBIENTE';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$idpais = isset($_GET['idpais']) ? $_GET['idpais'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio)); 
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objUbigeo = new clsUbigeo();

$row = $objUbigeo->Listar($tipobusqueda, $id, $idpais, $criterio);
echo json_encode($row);
flush();
?>