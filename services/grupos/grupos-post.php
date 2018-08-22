<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
    $user_error = 'Access denied - direct call is not allowed...';
    trigger_error($user_error, E_USER_ERROR);
}
ini_set('display_errors',1);


if ($_POST){
    require "../../common/sesion.class.php";
    require '../../adata/Db.class.php';
    require '../../bussiness/grupos.php';

    $sesion = new sesion();
    $idusuario = $sesion->get("idusuario");
    $idperfil = $sesion->get("idperfil");

    $rptadet = 0;
    $orden = 1;

    $rpta = 0;
    $titulomsje = '';
    $contenidomsje = '';

    $objData = new clsGrupo();

	$hdIdPack = $_POST['hdIdPack'];
    
    if (isset($_POST['btnAplicarGrupo'])){
        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $txtNombreGrupo = $_POST['txtNombreGrupo'];
        // $txtNroSecciones = $_POST['txtNroSecciones'];
        $ddlMoneda = $_POST['ddlMoneda'];
        $txtPrecioVigente = $_POST['txtPrecioVigente'];

        $objData->Registrar($hdIdPack, $IdEmpresa, $IdCentro, $txtNombreGrupo, 0, $ddlMoneda, $txtPrecioVigente, $idusuario, $rpta);

        $objData->EliminarSecciones($rpta, $idusuario, $rptadet);

        if (isset($_POST['seccion'])) {
            foreach ($_POST['seccion'] as $seccion) {
                $objData->RegistrarSeccion($rpta, $seccion['chkSeccion'], $seccion['txtNombreSeccion'], $orden, $idusuario, $rptadet);
                ++$orden;
            }
        }

    	$titulomsje = 'Registrado correctamente';
        $contenidomsje = 'La operacion se completo satisfactoriamente';
    }
    elseif (isset($_POST['btnAsignarGrupoProducto'])) {
        $IdEmpresa = isset($_POST['hdIdEmpresa']) ? $_POST['hdIdEmpresa'] : '1';
        $IdCentro = isset($_POST['hdIdCentro']) ? $_POST['hdIdCentro'] : '1';
        $listaProductos = isset($_POST['listaProductos']) ? $_POST['listaProductos'] : '';
        $hdIdSeccion = $_POST['hdIdSeccion'];
        $rpta = $objData->AsignarGrupoArticulo($IdEmpresa, $IdCentro, $hdIdPack, $hdIdSeccion, $listaProductos, $idusuario, $rpta);

        $titulomsje = 'Asignado correctamente';
        $contenidomsje = 'La operacion se completo satisfactoriamente';
    }
    elseif (isset($_POST['btnEliminar'])) {
        $rpta = $objData->EliminarStepByStep($hdIdPack, $idusuario, $rpta, $titulomsje, $contenidomsje);
    }

    $jsondata = array('rpta' => $rpta, 'titulomsje' => $titulomsje, 'contenidomsje' => $contenidomsje);
    echo json_encode($jsondata);
}
?>