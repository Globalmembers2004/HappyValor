<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/receta.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : '0';
$tipomenudia = isset($_GET['tipomenudia']) ? $_GET['tipomenudia'] : '00';

$objData = new clsReceta();
$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $idproducto, $tipomenudia);

if (isset($row))
	echo json_encode($row);
flush();
?>