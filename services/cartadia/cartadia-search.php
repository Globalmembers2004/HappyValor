<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

require '../../adata/Db.class.php';
require '../../bussiness/cartadia.php';

$IdEmpresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '0';
$IdCentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '0';
$tipoconsulta = isset($_GET['tipoconsulta']) ? $_GET['tipoconsulta'] : 'GENERAL';
$tipobusqueda = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$tipomenu = isset($_GET['tipomenu']) ? $_GET['tipomenu'] : '00';
$fecha = isset($_GET['fecha']) ? $_GET['fecha']: date('Y-m-d');
$estadoapertura = isset($_GET['estadoapertura']) ? $_GET['estadoapertura']: '';
$idcategoria = isset($_GET['idcategoria']) ? $_GET['idcategoria']: '0';
$idsubcategoria = isset($_GET['idsubcategoria']) ? $_GET['idsubcategoria']: '0';
$idcarta = isset($_GET['idcarta']) ? $_GET['idcarta']: '0';
$idgrupo = isset($_GET['idgrupo']) ? $_GET['idgrupo']: '0';
$idorden = isset($_GET['idorden']) ? $_GET['idorden']: '0';
$criterio = isset($_GET['criterio']) ? $_GET['criterio'] : '';
$pagina = isset($_GET['pagina']) ? $_GET['pagina']: '0';

$objData = new clsCartaDia();

if ($tipoconsulta == 'COMENSAL')
	$row = $objData->ListarProgramaciones__Comensal($tipobusqueda, $idcategoria, $idsubcategoria, $tipomenu, $criterio, $pagina);
else {
	if ($tipomenu == '00')
		$row = $objData->ListarPrograma_Carta($tipobusqueda, $IdEmpresa, $IdCentro, $idcategoria, $idcarta, $criterio, $pagina);
	elseif ($tipomenu == '03')
		$row = $objData->ListarPrograma_Menu($tipobusqueda, $IdEmpresa, $IdCentro, $idcategoria, $fecha, $idgrupo, $criterio, $pagina);
	else
		$row = $objData->ListarProgramaciones($tipobusqueda, $IdEmpresa, $IdCentro, $idcategoria, $idsubcategoria, $idgrupo, $idcarta, $idorden, $tipomenu, $fecha, $estadoapertura, $criterio, $pagina);
}

echo json_encode($row);
flush();
?>