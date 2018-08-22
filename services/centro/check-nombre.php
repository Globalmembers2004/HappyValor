<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

header('Content-type: application/json');

if ( !isset($_POST['txtNombre']) )
	exit;

require '../../adata/Db.class.php';
require '../../bussiness/centro.php';

$valid = '';
$objCentro = new clsCentro();

$idempresa = $_POST['idempresa'];
$idregistro = $_POST['idregistro'];
$txtNombre = trim(strip_tags($_POST['txtNombre']));
$txtNombre = preg_replace('/\s+/', ' ', $txtNombre);

$row = $objCentro->checkNombre($txtNombre, $idregistro, $idempresa);
$countrow = count($row);

if ($countrow == 0)
	$valid = 'true';
else
	$valid = 'false';

echo $valid;
?>