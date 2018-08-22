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

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : 'INSUMO';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '1';
$idproducto = isset($_GET['idproducto']) ? $_GET['idproducto'] : '0';
$idalmacen = isset($_GET['idalmacen']) ? $_GET['idalmacen'] : '0';
$idcategoria = (isset($_GET['idcategoria'])) ? $_GET['idcategoria'] : '';
$id = (isset($_GET['id'])) ? $_GET['id'] : '0';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$tipoproducto = (isset($_GET['tipoproducto'])) ? $_GET['tipoproducto'] : '';
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';

$objData = new clsInsumo();

if ($tipobusqueda == 'INSUMO') {
	if ($tipo == '2') 
		$id = $idproducto;
	elseif ($tipo == '3') 
		$id = $idalmacen;
	
	$row = $objData->Listar($tipo, $IdEmpresa, $IdCentro, $id, $criterio, $pagina);
}
elseif ($tipobusqueda == 'INSUMO-PRESENTACION')
	$row = $objData->ListarInsumoPresentaciones($tipo, $IdEmpresa, $IdCentro, $criterio, $pagina);
elseif ($tipobusqueda == 'INSUMO-IDS')
	$row = $objData->ListarInsumoPorIDS($tipo, $IdEmpresa, $IdCentro, $IDS);
elseif ($tipobusqueda == 'INSUMO-STOCK')
	$row = $objData->ListarInsumoStock($tipo, $IdEmpresa, $IdCentro, $idalmacen, $criterio, $pagina);
elseif ($tipobusqueda == 'EXISTENCIAS')
	$row = $objData->ListarExistencias($tipo, $IdEmpresa, $IdCentro, $tipoproducto, $criterio);

echo json_encode($row);
flush();
?>