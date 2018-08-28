<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	$user_error = 'Access denied - direct call is not allowed...';
	trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../common/functions.php';
    require '../../bussiness/inventario.php';
    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

$tipo = isset($_GET['tipobusqueda']) ? $_GET['tipobusqueda'] : '1';
$idempresa = isset($_GET['idempresa']) ? $_GET['idempresa'] : '1';
$idcentro = isset($_GET['idcentro']) ? $_GET['idcentro'] : '1';
$criterio = (isset($_GET['criterio'])) ? $_GET['criterio'] : '';
$criterio = trim(strip_tags($criterio));
$criterio = preg_replace('/\s+/', ' ', $criterio);
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '1';
$idcencosto = isset($_GET['idcencosto']) ? $_GET['idcencosto'] : '1';
$id = isset($_GET['id']) ? $_GET['id'] : '0';


$objData = new clsInventario();

$row = $objData->Listar($tipo, $idempresa, $idcentro, $idcencosto, $idusuario, $id, $criterio, $pagina);

echo json_encode($row);
flush();
?>