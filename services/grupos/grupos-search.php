<?php
require '../../adata/Db.class.php';
require '../../bussiness/grupos.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$fechaini = isset($_GET['fechaini']) ? $_GET['fechaini'] : date("Y-m-d h:i:s");
$fechafin = isset($_GET['fechafin']) ? $_GET['fechafin'] : date("Y-m-d h:i:s");
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objData = new clsGrupo();

if ($tipo == 'TEMP-SECCIONPACK') {
	$row = $objData->ListarSeccionPack($tipobusqueda, $id, $criterio, $pagina);
}
else {
	$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $id, $fechaini, $fechafin, $criterio, $pagina);
}

echo json_encode($row);
flush();
?>