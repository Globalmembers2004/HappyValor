<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with,x-json');
header('Content-type: application/x-json');
set_time_limit(0); 

include('../../adata/Db.class.php');
include('../../bussiness/atencion.php');

$currentmodif = 0;
$objAtencion = new clsAtencion();

$idempresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : 0;
$idcentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : 0;
$estado = isset($_GET['estado']) ? $_GET['estado'] : 0;
$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;

$rsAtencion = $objAtencion->UltimaAtencion($idempresa, $idcentro, $estado);
$countAtencion  = count($rsAtencion);
if ($countAtencion > 0){
	$currentmodif = $rsAtencion[0]['fechamaxmov'];
}

while ($currentmodif <= $lastmodif){
	usleep(10000); 
	clearstatcache();
	$rsAtencion = $objAtencion->UltimaAtencion($idempresa, $idcentro, $estado);
	$countAtencion  = count($rsAtencion);
	if ($countAtencion > 0){
		$currentmodif = $rsAtencion[0]['fechamaxmov'];
	}
}

echo json_encode($rsAtencion);
flush();
?>