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
$idgrupomesa = 0;
$ta_tipomesa = '';
$codigo_group = '';
$comensales_group = '';
$estadoatencion_group = '';
$color_leyenda_group = '';

$objAtencion = new clsAtencion_oneconnect();

$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
$idempresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : 0;
$idcentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : 0;
$idambiente = isset($_GET['idambiente']) ? $_GET['idambiente'] : '0';

$conectar = $objAtencion->_conectar();

$objAtencion->UltimaMesa($conectar, $idempresa, $idcentro, $idambiente, $idgrupomesa, $ta_tipomesa, $codigo_group, $comensales_group, $estadoatencion_group, $color_leyenda_group, $currentmodif);

while ($currentmodif <= $lastmodif){
	usleep(10000);
	clearstatcache();
	
	$objAtencion->UltimaMesa($conectar, $idempresa, $idcentro, $idambiente, $idgrupomesa, $ta_tipomesa, $codigo_group, $comensales_group, $estadoatencion_group, $color_leyenda_group, $currentmodif);
}

$objAtencion->_desconectar($conectar);

$response = array();
$response['timestamp'] = $currentmodif;

$response['idgrupomesa'] = $idgrupomesa;
$response['ta_tipomesa'] = $ta_tipomesa;
$response['codigo_group'] = $codigo_group;
$response['comensales_group'] = $comensales_group;
$response['estadoatencion_group'] = $estadoatencion_group;
$response['color_leyenda_group'] = $color_leyenda_group;

echo json_encode($response);
flush();
?>