<?php
require '../../adata/Db.class.php';
require '../../bussiness/cartadia.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$anho = isset($_GET['anho']) ? $_GET['anho'] : date('Y');
$mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');

$objData = new clsCartaDia();
$row = $objData->ListarDiasProgramados($tipobusqueda, $IdEmpresa, $IdCentro, $anho, $mes);

echo json_encode($row);
flush();
?>