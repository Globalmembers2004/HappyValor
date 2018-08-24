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

$tipo =  '2'; 
$idempresa = '1';
$idcentro = '1';
$idperiodo = isset($_GET['idperiodo']) ? $_GET['idperiodo'] : '0';
$idproducto = 0;
$idcencosto_ori = 0;
$idcencosto_des = 0; 
$idinventario = isset($_GET['idinventario']) ? $_GET['idinventario'] : '0';
$id = '0';
$criterio = "";
$pagina = 1;

$row = $objData->ListarReenvio($tipo, $idempresa, $idcentro, $idperiodo, $idproducto, $idcencosto_ori,  $idcencosto_des, $idinventario, $id, $criterio, $pagina);

echo json_encode($row);
flush();
?>