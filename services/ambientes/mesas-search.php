<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/atencion.php';
require '../../bussiness/mesas.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : 'M';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';
$idambiente = isset($_GET['idambiente']) ? $_GET['idambiente'] : '0';
$estadoatencion = isset($_GET['estadoatencion']) ? $_GET['estadoatencion'] : '00';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objMesa = new clsMesa();
$objAtencion = new clsAtencion();

if ($tipobusqueda == 'M')
	$row = $objMesa->ListarMesas($tipo, $IdEmpresa, $IdCentro, $id, $criterio, $pagina);
elseif (($tipobusqueda == 'ATENCION') || ($tipobusqueda == 'NOTIFTV') || ($tipobusqueda == 'NOTIFATENCION')){
	if (($tipobusqueda == 'NOTIFTV') || ($tipobusqueda == 'NOTIFATENCION'))
		$row = $objMesa->Listar($tipobusqueda, $IdEmpresa, $IdCentro);
	else
		$row = $objAtencion->ListarPedidos($tipobusqueda, $IdEmpresa, $IdCentro, $idambiente, '');
		//$row = $objMesa->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $idambiente);
}
elseif ($tipobusqueda == 'NOTIFCOCINA')
	$row = $objMesa->Listar($tipobusqueda, $IdEmpresa, $IdCentro, '\'03\'');
elseif ($tipobusqueda == 'UNIDAS')
	$row = $objMesa->Listar($tipobusqueda, $IdEmpresa, $IdCentro);
elseif ($tipobusqueda == 'GROUP-MESAS')
	$row = $objMesa->ListarGroupMesas($tipo, $IdEmpresa, $IdCentro, $idambiente, $estadoatencion);

echo json_encode($row);
flush();
?>