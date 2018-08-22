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

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : 'ATENCION-AMBIENTE';
$idambiente = isset($_GET['idambiente']) ? $_GET['idambiente'] : '0';
$tipomesa = isset($_GET['tipomesa']) ? $_GET['tipomesa'] : '';
$idmesas = isset($_GET['idmesas']) ? $_GET['idmesas'] : '0';
$idatencion = isset($_GET['idatencion']) ? $_GET['idatencion'] : '0';
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

$objAtencion = new clsAtencion();

$row = $objAtencion->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $idambiente, $tipomesa, $estado, $idatencion, $idmesas);
echo json_encode($row);
flush();
?>