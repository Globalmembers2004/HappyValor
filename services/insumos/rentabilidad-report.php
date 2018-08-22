<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/insumos.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';

$idcategoria = isset($_GET['idcategoria']) ? $_GET['idcategoria'] : '0';
$tienreceta = isset($_GET['tienreceta']) ? $_GET['tienreceta'] : '1';
$anhoini = isset($_GET['anhoini']) ? $_GET['anhoini'] : date('Y');
$mesini = isset($_GET['mesini']) ? $_GET['mesini'] : date('m');
$anhofin = isset($_GET['anhofin']) ? $_GET['anhofin'] : date('Y');
$mesfin = isset($_GET['mesfin']) ? $_GET['mesfin'] : date('m');


$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objData = new clsInsumo();
$row = $objData->Rentabilidad_Reporte($IdEmpresa, $IdCentro, $idcategoria, $tienreceta, $anhoini, $mesini, $anhofin, $mesfin);

echo json_encode($row);
flush();
?>