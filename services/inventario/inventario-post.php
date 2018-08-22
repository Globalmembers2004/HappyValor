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
        $ddlCenCos = (isset($_POST['ddlCenCos'])) ? $_POST['ddlCenCos'] : '0';
        $ddlProducto = (isset($_POST['ddlProducto'])) ? $_POST['ddlProducto'] : '0';
        $periodo = (isset($_POST['periodo'])) ? $_POST['periodo'] : 1;
        $txtCantEnv = (isset($_POST['txtCantidadEnvi'])) ? $_POST['txtCantidadEnvi'] : '0';
        $txtCantInv = (isset($_POST['txtCantidadInv'])) ? $_POST['txtCantidadInv'] : '0';

        $DetalleConsumo = json_decode(stripslashes($_POST['DetalleConsumo']));

        foreach ($DetalleConsumo as $item) {
            $rpta = $objData->Registrar($hdIdPrimary, 1, 1, $periodo, $ddlCenCos, $ddlCenCos, $ddlProducto, $txtCantEnv, $txtCantInv, $idusuario, $rpta, $titulomsje, $contenidomsje);
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