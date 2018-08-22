<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

set_time_limit(0);

require '../../adata/Db-OneConnect.class.php';
require '../../bussiness/atencion_oneconnect.php';

$currentmodif = 0;
$idatencion = 0;
$nroatencion = '';

$objAtencion = new clsAtencion_oneconnect();

$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
$idempresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : 0;
$idcentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : 0;
$estadoatencion = isset($_GET['estadoatencion']) ? $_GET['estadoatencion'] : '02';

$conectar = $objAtencion->_conectar();

$objAtencion->UltimaAtencion($conectar, $idempresa, $idcentro, $estadoatencion, $idatencion, $nroatencion, $currentmodif);

while ($currentmodif <= $lastmodif){
	usleep(10000);
	clearstatcache();
	
	$objAtencion->UltimaAtencion($conectar, $idempresa, $idcentro, $estadoatencion, $idatencion, $nroatencion, $currentmodif);
}

$objAtencion->_desconectar($conectar);

$response = array();
$response['timestamp'] = $currentmodif;
$response['idatencion'] = $idatencion;
$response['nroatencion'] = $nroatencion;

echo json_encode($response);
flush();
?>