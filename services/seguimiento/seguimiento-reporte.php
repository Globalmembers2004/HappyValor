<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/seguimiento.php';

$idempresa = (isset($_GET['idempresa'])) ? $_GET['idempresa'] : '0';
$idcentro = (isset($_GET['idcentro'])) ? $_GET['idcentro'] : '';
$anho = (isset($_GET['anho'])) ? $_GET['anho'] : '0';
$mes_inicial = (isset($_GET['mes_inicial'])) ? $_GET['mes_inicial'] : '0';
$mes_final = (isset($_GET['mes_final'])) ? $_GET['mes_final'] : '0';

$objData = new clsSeguimiento();
$row = $objData->Reporte($idempresa, $idcentro, $anho, $mes_inicial, $mes_final);

echo json_encode($row);
flush();
?>