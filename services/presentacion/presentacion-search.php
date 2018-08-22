<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/presentacion.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : 'L';
$idpresentacion = isset($_GET['idpresentacion']) ? $_GET['idpresentacion'] : '0';
$tipoinsumo = isset($_GET['tipoinsumo']) ? $_GET['tipoinsumo'] : '0';
$idinsumo = isset($_GET['idinsumo']) ? $_GET['idinsumo'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);

$objData = new clsPresentacion();

if ($tipo == 'L')
	$row = $objData->Listar($tipobusqueda, $IdEmpresa, $IdCentro, $idpresentacion, $criterio);
else
	$row = $objData->ListarInsumoPresentacion($tipobusqueda, $idinsumo, $tipoinsumo);

echo json_encode($row);
flush();
?>