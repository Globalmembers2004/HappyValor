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
require '../../bussiness/categoria.php';

$valid = '';
$objCategoria = new clsCategoria();

$idregistro = $_POST['idregistro'];
$idempresa = $_POST['idempresa'];
$idcentro = $_POST['idcentro'];
$txtNombre = trim(strip_tags($_POST['txtNombre']));
$txtNombre = preg_replace('/\s+/', ' ', $txtNombre);

$row = $objCategoria->checkNombre($txtNombre, $idregistro, $idempresa, $idcentro);
$countrow = count($row);

if ($countrow == 0)
	$valid = 'true';
else
	$valid = 'false';

echo $valid;
?>