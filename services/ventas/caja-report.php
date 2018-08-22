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
require '../../common/functions.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$fechaini = isset($_GET['fechaini']) ? fecha_mysql($_GET['fechaini']) : date("Y-m-d h:i:s");
$fechafin = isset($_GET['fechafin']) ? fecha_mysql($_GET['fechafin']) : date("Y-m-d h:i:s");

$objData = new clsVenta();

if ($tipobusqueda == 'CUADRE')
	$row = $objData->CuadreCaja_Reporte($IdEmpresa, $IdCentro, $fechaini, $fechafin);
elseif ($tipobusqueda == 'EFECTIVO')
	$row = $objData->CajaEfectivo_Reporte($IdEmpresa, $IdCentro, $fechaini, $fechafin);
elseif ($tipobusqueda == 'IMPUESTOS')
	$row = $objData->CajaImpuesto_Reporte($IdEmpresa, $IdCentro, $fechaini, $fechafin);


echo json_encode($row);
flush();
?>