<?php
require '../../adata/Db.class.php';
require '../../bussiness/categoria.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - direct call is not allowed...';
  trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$id = isset($_GET['id']) ? $_GET['id'] : '0';

$objData = new clsCategoria();
$row = $objData->Listar('O', $id);

if (isset($row))
	echo json_encode($row);
flush();
?>