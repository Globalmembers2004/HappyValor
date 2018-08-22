<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/compras.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$anhoini = isset($_GET['anhoini']) ? $_GET['anhoini'] : date('Y');
$mesini = isset($_GET['mesini']) ? $_GET['mesini'] : date('m');
$anhofin = isset($_GET['anhofin']) ? $_GET['anhofin'] : date('Y');
$mesfin = isset($_GET['mesfin']) ? $_GET['mesfin'] : date('m');
// $fechaini = isset($_GET['fechaini']) ? $_GET['fechaini'] : date("Y-m-d h:i:s");
// $fechafin = isset($_GET['fechafin']) ? $_GET['fechafin'] : date("Y-m-d h:i:s");

$objData = new clsCompra();
$row = $objData->Reporte($tipobusqueda, $IdEmpresa, $IdCentro, $anhoini, $mesini, $anhofin, $mesfin);

echo json_encode($row);
flush();
?>