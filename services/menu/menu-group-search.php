<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/menu.php';

$tipobusqueda = (isset($_GET['tipobusqueda'])) ? $_GET['tipobusqueda'] : '1';
$idreferencia = (isset($_GET['idreferencia'])) ? $_GET['idreferencia'] : '0';
$tipomenu = (isset($_GET['tipomenu'])) ? $_GET['tipomenu'] : '00';
$idperfil = (isset($_GET['idperfil'])) ? $_GET['idperfil'] : '0';

$objData = new clsMenu();
$row = $objData->ListarMenuPerfilGroup($tipobusqueda, $idperfil, $tipomenu, $idreferencia);

echo json_encode($row);
flush();
?>