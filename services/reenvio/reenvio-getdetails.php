<?php
require '../../adata/Db.class.php';
require '../../bussiness/reenvio.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

$objData = new clsReenvio();

$tipo =  '1'; 
$idempresa = '1';
$idcentro = '1';
$idcencosto_ori = isset($_GET['idcencosto_ori']) ? $_GET['idcencosto_ori'] : '0';
$idcencosto_des = isset($_GET['idcencosto_des']) ? $_GET['idcencosto_des'] : '0';
$idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : '0';
$criterio = "";
$pagina = 1;

$row = $objData->ListarReenvio($tipo, $idempresa, $idcentro, $idproducto, $idcencosto_ori, $idcencosto_des, $criterio, $pagina);

echo json_encode($row);
flush();
?>