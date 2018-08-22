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
    require '../../bussiness/reenvio.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rpta = '0';
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsReenvio();

    if (isset($_POST['btnGuardar'])){

        $idinventario = (isset($_POST['idinventario'])) ? $_POST['idinventario'] : '0';
        $hdIdProducto = (isset($_POST['idproducto'])) ? $_POST['idproducto'] : '0';
        $ddlCenCosOri = (isset($_POST['centroori'])) ? $_POST['centroori'] : '0';
   
        $detalleReenvio = json_decode(stripslashes($_POST['detalleReenvio']));

        foreach ($detalleReenvio as $item) {
            $objData->RegistrarReenvio(0,1,1,$idinventario, $hdIdProducto, $ddlCenCosOri, $item->centrodes, $item->cantidad, $idusuario, $rpta, $titulomsje, $contenidomensaje);
        }
    }
    elseif (isset($_POST['btnEliminar'])) {
        $hdIdReenvio = $_POST['hdIdReenvio'];
        $rpta = $objData->EliminarStepByStep($hdIdReenvio, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }
    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>