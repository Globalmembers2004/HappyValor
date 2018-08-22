<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/kardex.php';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipoexistencia = isset($_GET['tipoexistencia']) ? $_GET['tipoexistencia'] : '1';
$idempresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$idcentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : '0';
$idarticulo = isset($_GET['idarticulo']) ? $_GET['idarticulo'] : '0';
$fechaini = isset($_GET['fechaini']) ? $_GET['fechaini'] : date('Y-m-d');
$fechafin = isset($_GET['fechafin']) ? $_GET['fechafin'] : date('Y-m-d');
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

$objData = new clsKardex();
$row = $objData->Listar($tipo, $tipoexistencia, $idempresa, $idcentro, $idalmacen, $idarticulo, $fechaini, $fechafin, $fecha);

echo json_encode($row);
flush();
?>