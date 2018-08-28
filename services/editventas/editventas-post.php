<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);

if ($_POST){
    require '../../common/sesion.class.php';
    require '../../common/class.translation.php';
    require '../../adata/Db.class.php';
    require '../../common/functions.php';
    require '../../bussiness/inventario.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsInventario();

    if (isset($_POST['btnGuardar'])){
        $hdIdPrimary = (isset($_POST['hdIdPrimary'])) ? $_POST['hdIdPrimary'] : '0';
        $centroCosto = (isset($_POST['centroCosto'])) ? $_POST['centroCosto'] : '0';

        $DetalleConsumo = json_decode(stripslashes($_POST['DetalleConsumo']));

        foreach ($DetalleConsumo as $item) {
            
            $rpta = $objData->Registrar($item->iditem, 1, 1, $centroCosto, $centroCosto, $item->idproducto, $item->cantante, $item->cantenvi, $item->cantreen, $item->cantreci, $item->cantinve, $item->cantcons, $idusuario, $rpta, $titulomsje, $contenidomsje);
        }
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdInventario = $_POST['hdIdInventario'];
        $rpta = $objData->EliminarStepByStep($hdIdInventario, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>