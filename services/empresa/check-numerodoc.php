<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

header('Content-type: application/json');

if ( !isset($_POST['txtNumeroDoc']) )
	exit;

require '../../adata/Db.class.php';
require '../../bussiness/empresa.php';

$valid = '';
$objEmpresa = new clsEmpresa();

$idregistro = $_POST['idregistro'];
$txtNumeroDoc = trim(strip_tags($_POST['txtNumeroDoc']));
$txtNumeroDoc = preg_replace('/\s+/', ' ', $txtNumeroDoc);

$row = $objEmpresa->checkNumeroDoc($txtNumeroDoc, $idregistro);
$countrow = count($row);

if ($countrow == 0)
	$valid = 'true';
else
	$valid = 'false';

echo $valid;
?>