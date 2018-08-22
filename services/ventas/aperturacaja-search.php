<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/ventas.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = (isset($_GET['tipobusqueda'])) ? $_GET['tipobusqueda'] : '1' ;
$fecha = (isset($_GET['fecha'])) ? $_GET['fecha'] : date('Y-m-d') ;

$fecha = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $fecha);

$objData = new clsVenta();

$row = $objData->ListarAperturaCaja($tipobusqueda, $IdEmpresa, $IdCentro, $fecha);

echo json_encode($row);
flush();
?>