<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/servicios.php';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$idcliente = isset($_GET['idcliente']) ? $_GET['idcliente'] : '0';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '0';

$objData = new clsServicios();
$row = $objData->ListarServicioCliente($tipo, $IdEmpresa, $IdCentro, $idcliente, $id, $criterio, $pagina);

echo json_encode($row);
flush();
?>